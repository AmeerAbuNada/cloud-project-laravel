<?php

namespace App\Http\Controllers;

use App\Events\Project\ProjectCreated;
use App\Events\Project\ProjectDeleted;
use App\Events\Project\ProjectRestored;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Client;
use App\Models\File;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $projects = Project::with('createdBy', 'user', 'client')->when($request->search, function ($q) use ($request) {
            return $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('status', 'like', '%' . $request->search . '%');
        })->orderBy('created_at', 'DESC')->paginate(25);
        return response()->view('crm.pages.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        $clients = Client::all();
        return response()->view('crm.pages.projects.create', compact('users', 'clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $project = new Project();
        $project->title = $request->input('title');
        $project->description = $request->input('description');
        $project->deadline = $request->input('deadline');
        $project->user_id = $request->input('user');
        $project->client_id = $request->input('client');
        $project->created_by = auth()->user()->id;
        $isSaved = $project->save();
        if ($isSaved) {
            event(new ProjectCreated($project));
        }
        return response()->json([
            'message' => $isSaved ? 'Project Created Successfully!' : 'Failed to create project, Please try again.',
        ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($project)
    {
        $project = Project::withTrashed()->with(['tasks.user', 'tasks.createdBy', 'files.uploadedBy'])->findOrFail($project);
        return response()->view('crm.pages.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit($project)
    {
        $project = Project::withTrashed()->findOrFail($project);
        $users = User::all();
        $clients = Client::all();
        return response()->view('crm.pages.projects.edit', compact('users', 'clients', 'project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, $project)
    {
        $project = Project::withTrashed()->findOrFail($project);
        $project->title = $request->input('title');
        $project->description = $request->input('description');
        $project->deadline = $request->input('deadline');
        $project->user_id = $request->input('user');
        $project->client_id = $request->input('client');
        $project->status = $request->input('status');
        $isSaved = $project->save();
        return response()->json([
            'message' => $isSaved ? 'Project Updated Successfully!' : 'Failed to update project, Please try again.',
        ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->deleted_at = now();
        $project->deleted_by = auth()->user()->id;
        $isDeleted = $project->save();
        if ($isDeleted) {
            event(new ProjectDeleted($project));
        }
        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted!' : 'Failed',
            'text' => $isDeleted ? 'Project Deleted Successfully!' : 'Failed to delete project, Please try again.',
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function showDeleted(Request $request)
    {
        $projects = Project::with('deletedBy', 'user', 'client')->onlyTrashed()->where(function ($q) use ($request) {
            return $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('status', 'like', '%' . $request->search . '%');
        })->orderBy('deleted_at', 'DESC')->paginate(25);
        return response()->view('crm.pages.projects.deleted', compact('projects'));
    }

    public function restore($project)
    {
        $project = Project::onlyTrashed()->findOrFail($project);
        $project->deleted_at = null;
        $project->deleted_by = null;
        $isRestored = $project->save();
        if ($isRestored) {
            event(new ProjectRestored($project));
        }
        return response()->json([
            'message' => $isRestored ? 'Project Restored Successfully!' : 'Failed to restore the project, please try again.',
        ], $isRestored ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
