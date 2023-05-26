<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMeetingRequest;
use App\Mail\NewMessageEmail;
use App\Models\Course;
use App\Models\Meeting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    public function availableCourses(Request $request)
    {
        $courses = Course::when($request->search, function ($q) use ($request) {
            return $q->where('title', 'LIKE', "%$request->search%");
        })->with(['users', 'advisor'])->paginate(10);
        $user = $request->user();
        foreach ($courses as $course) {
            $course->setAttribute('assinged', false);
            foreach ($course->users as $u) {
                if ($u->id == $user->id) {
                    $course->setAttribute('assinged', true);
                    break;
                }
            }
        }
        return response()->view('crm.pages.available-courses.index', compact('courses'));
    }

    public function showCourse(Course $course, Request $request)
    {
        $user = $request->user();
        $course->setAttribute('assinged', false);
        foreach ($course->users as $u) {
            if ($u->id == $user->id) {
                $course->setAttribute('assinged', true);
                break;
            }
        }
        return response()->view('crm.pages.available-courses.show-course', compact('course'));
    }

    public function applyForCourse(Course $course, Request $request)
    {
        $user = $request->user();
        if (!$course->users()->where('id', $user->id)->exists()) {
            $user->appliedCourses()->attach($course->id);
        }
        return response()->json([
            'message' => 'Course Assinged Successfully!',
        ], Response::HTTP_CREATED);
    }

    public function removeCourse(Course $course, Request $request)
    {
        $user = $request->user();
        if ($course->users()->where('id', $user->id)->exists()) {
            $user->appliedCourses()->detach($course->id);
        }
        return response()->json([
            'message' => 'Course Removed Successfully!',
        ], Response::HTTP_OK);
    }

    public function addAttendance(Course $course, Request $request)
    {
        $user = $request->user();
        if (DB::table('attendance')->where('user_id', $user->id)->where('course_id', $course->id)->where('date', now()->format('Y-m-d'))->exists()) {
            return response()->json([
                'message' => 'You made your attendace today',
            ], Response::HTTP_BAD_REQUEST);
        }
        $user->attendances()->attach($course->id, ['date' => now()]);
        return response()->json([
            'message' => 'Attendance Registered Successfully!',
        ], Response::HTTP_OK);
    }

    public function requestMeeting(Course $course, StoreMeetingRequest $request)
    {
        $user = $request->user();
        $carbonObj = Carbon::createFromFormat('Y-m-d\TH:i', $request->input('time'));
        $meetings = Meeting::all();
        foreach ($meetings as $meeting) {
            $meetingStartsAt = $meeting->time;
            $meetingendtsAt = $meeting->time->addHour();
            if (($meetingStartsAt >= $carbonObj && $meetingStartsAt <= $carbonObj->addHour()) || ($meetingendtsAt >= $carbonObj && $meetingendtsAt <= $carbonObj->addHour())) {
                return response()->json([
                    'message' => 'There is a conflict in this time, please choose another time',
                ], Response::HTTP_BAD_REQUEST);
            }
        }
        Meeting::create($request->getParsedDate());
        return response()->json([
            'message' => 'Meeting has been scheduled successfully!',
        ], Response::HTTP_OK);
    }

    public function myMeetings(Request $request)
    {
        $meetings = $request->user()->meetings()->orderBy('time', 'ASC')->paginate(10);
        return response()->view('crm.pages.myMeetings.index', compact('meetings'));
    }

    public function deleteMeeting(Meeting $meeting)
    {
        $meeting->delete();
        return response()->json([
            'message' => 'Meeting has been deleted successfully!',
        ], Response::HTTP_OK);
    }

    public function acceptMeeting(Meeting $meeting)
    {
        $meeting->is_accepted = true;
        $meeting->save();
        return response()->json([
            'message' => 'Meeting has been accepted successfully!',
        ], Response::HTTP_OK);
    }

    public function myCourses(Request $request)
    {
        $user = $request->user();
        if ($user->role == 'advisor') {
            $courses = $user->courses()->orderBy('created_at', 'DESC')->paginate(10);
        } else {
            $courses = $user->appliedCourses()->orderBy('created_at', 'DESC')->paginate(10);
        }
        return response()->view('crm.pages.myCourses.index', compact('courses'));
    }

    public function sendEmail(User $user, Request $request)
    {
        $validator = Validator($request->all(), [
            'message' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
        Mail::to($user)->send(new NewMessageEmail($request->input('message')));
        return response()->json([
            'message' => 'Email has been sent successfully!'
        ], Response::HTTP_OK);
    }
}
