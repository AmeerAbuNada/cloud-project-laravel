<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    public function availableCourses(Request $request)
    {
        $courses = Course::when($request->search, function ($q) use ($request) {
            return $q->where('title', 'LIKE', "%$request->search%");
        })->with('users')->paginate(10);
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

    public function showCourse(Course $course)
    {
        return response()->view('crm.pages.available-courses.show-course', compact('course'));
    }

    public function applyForCourse(Course $course, Request $request)
    {
        $user = $request->user();
        $user->appliedCourses()->attach($course->id);
        return response()->json([
            'message' => 'Course Assinged Successfully!',
        ], Response::HTTP_CREATED);
    }
    public function removeCourse(Course $course, Request $request)
    {
        $user = $request->user();
        $user->appliedCourses()->detach($course->id);
        return response()->json([
            'message' => 'Course Removed Successfully!',
        ], Response::HTTP_OK);
    }
}
