<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserSection\Task\StoreTaskRequest;
use App\Http\Requests\UserSection\Task\UpdateTaskRequest;
use App\Models\File;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::with('createdBy', 'user', 'project')
            ->where('user_id', auth()->user()->id)
            ->orderBy('id', 'DESC')->paginate(25);
        return response()->view('crm.pages.my.tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        if ($project->user_id != auth()->user()->id) return abort(Response::HTTP_NOT_FOUND);
        $users = User::all();
        return response()->view('crm.pages.my.tasks.create', compact(
            'project',
            'users'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request, Project $project)
    {
        $task = new Task();
        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->user_id = $request->input('user');
        $task->project_id = $project->id;
        $task->created_by = auth()->user()->id;
        $isSaved = $task->save();
        return response()->json([
            'message' => $isSaved ? 'Task Created Successfully!' : 'Failed to create task, Please try again.',
        ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project, Task $task)
    {
        if ($task->project->id != $project->id) return abort(Response::HTTP_NOT_FOUND);
        if ($task->user_id != auth()->user()->id && $project->user_id != auth()->user()->id) return abort(Response::HTTP_NOT_FOUND);
        $files = File::with('uploadedBy')->where('fileable_type', 'App\Models\Task')->where('fileable_id', $task->id)->orderBy('created_at', 'DESC')->get();
        return response()->view('crm.pages.my.tasks.show', compact(
            'project',
            'task',
            'files'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project, Task $task)
    {
        if ($task->project_id != $project->id) return abort(Response::HTTP_NOT_FOUND);
        if ($task->user_id != auth()->user()->id && $project->user_id != auth()->user()->id) return abort(Response::HTTP_NOT_FOUND);

        $users = User::all();
        return response()->view('crm.pages.my.tasks.edit', compact(
            'project',
            'task',
            'users',
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaskRequest $request, Project $project, Task $task)
    {
        if ($task->project->id != $project->id) return abort(Response::HTTP_NOT_FOUND);
        if ($task->user_id != auth()->user()->id && $project->user_id != auth()->user()->id) return abort(Response::HTTP_NOT_FOUND);

        $task->name = $request->input('name');
        $task->description = $request->input('description');
        $task->user_id = $request->input('user');
        $task->status = $request->input('status');
        $isSaved = $task->save();
        return response()->json([
            'message' => $isSaved ? 'Task Updated Successfully!' : 'Failed to update task, Please try again.',
        ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project, Task $task)
    {
        if ($task->project->id != $project->id) return abort(Response::HTTP_NOT_FOUND);
        if ($project->user_id != auth()->user()->id) return abort(Response::HTTP_NOT_FOUND);
        $files = $task->files;
        $isDeleted = $task->delete();
        if ($isDeleted) {
            foreach ($files as $file) {
                Storage::disk('public')->delete('' . $file->path);
            }
        }
        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted!' : 'Faild',
            'text' => $isDeleted ? 'Task Deleted Successfully!' : 'Failed to create task, Please try again.',
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
