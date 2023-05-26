<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        parent::saveLog('Opened all courses page', auth()->user()->id);
        $courses = Course::when($request->search, function ($q) use ($request) {
            return $q->where('title', 'LIKE', "%$request->search%");
        })->with('advisor')->paginate(10);
        return response()->view('crm.pages.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        parent::saveLog('Opened create course page', auth()->user()->id);
        $advisors = User::where('role', 'advisor')->where('id_card', '!=', null)->get();
        return response()->view('crm.pages.courses.create', compact('advisors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $course = Course::create($request->getParsedData());
        if ($course) {
            parent::saveLog('Create a new course', auth()->user()->id);
        }
        return response()->json([
            'message' => $course ? 'Course Created Successfully!' : 'Failed to create, try again.',
        ], $course ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        parent::saveLog('opened course page', auth()->user()->id);
        return response()->view('crm.pages.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        parent::saveLog('opened edit course page', auth()->user()->id);
        $advisors = User::where('role', 'advisor')->where('id_card', '!=', null)->get();
        return response()->view('crm.pages.courses.edit', compact('advisors', 'course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $updated = $course->update($request->getParsedData());
        if($updated) {
            parent::saveLog('Update a course', auth()->user()->id);
        }
        return response()->json([
            'message' => $updated ? 'Course Update Successfully!' : 'Failed to update, try again.',
        ], $updated ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $deleted = $course->delete();
        if($deleted) {
            parent::saveLog('Deleted a course', auth()->user()->id);
        }
        return response()->json([
            'title' => $deleted ? 'Deleted!' : 'Failed',
            'text' =>  $deleted ? 'Course Has been deleted successfully!' : 'failed to delete, try again.',
            'icon' => $deleted ? 'success' : 'error',
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
