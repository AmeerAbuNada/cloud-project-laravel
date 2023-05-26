<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserSection\Project\UpdateProjectRequest;
use App\Http\Requests\UserSection\Project\UploadFileRequest;
use App\Models\Client;
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
        if ($request->user()->is_admin) {
            $projects = Project::with('createdBy', 'client')
                ->withTrashed()
                ->where('user_id', $request->user()->id)
                ->where(function ($q) use ($request) {
                    return $q->when($request->search, function ($q) use ($request) {
                        return $q->where('title', 'like', '%' . $request->search . '%')
                            ->orWhere('status', 'like', '%' . $request->search . '%');
                    });
                })->orderBy('created_at', 'DESC')->paginate(25);
        } else {
            $projects = Project::with('client')
                ->where('user_id', $request->user()->id)
                ->where(function ($q) use ($request) {
                    return $q->when($request->search, function ($q) use ($request) {
                        return $q->where('title', 'like', '%' . $request->search . '%')
                            ->orWhere('status', 'like', '%' . $request->search . '%');
                    });
                })->orderBy('created_at', 'DESC')->paginate(25);
        }
        return response()->view('crm.pages.my.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($project)
    {
        $project = Project::with(['tasks.createdBy', 'files.uploadedBy', 'tasks.user'])->findOrFail($project);
        if(!auth()->user()->hasAccessToProject($project)) return abort(Response::HTTP_NOT_FOUND);
        return response()->view('crm.pages.my.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        if ($project->user_id != auth()->user()->id) {
            return abort(Response::HTTP_NOT_FOUND);
        }
        return response()->view('crm.pages.my.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->title = $request->input('title');
        $project->description = $request->input('description');
        $project->deadline = $request->input('deadline');
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
        //
    }
}
