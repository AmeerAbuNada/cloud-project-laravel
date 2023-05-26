<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\File;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class UserRelationsController extends Controller
{
    public function showAssignedProjects(User $user, Request $request)
    {
        $projects = Project::with('createdBy', 'user', 'client')->withTrashed()->where('user_id', $user->id)
            ->where(function ($q) use ($request) {
                return $q->when($request->search, function ($q) use ($request) {
                    return $q->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('status', 'like', '%' . $request->search . '%');
                });
            })->orderBy('id', 'DESC')->paginate(25);
        return response()->view('crm.pages.users.relations.projects.assigned', compact('user', 'projects'));
    }

    public function showCreatedProject(User $user, Request $request)
    {
        $projects = Project::with('createdBy', 'user', 'client')->withTrashed()->where('created_by', $user->id)
            ->where(function ($q) use ($request) {
                return $q->when($request->search, function ($q) use ($request) {
                    return $q->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('status', 'like', '%' . $request->search . '%');
                });
            })->orderBy('id', 'DESC')->paginate(25);
        return response()->view('crm.pages.users.relations.projects.created', compact('user', 'projects'));
    }

    public function showDeletedProject(User $user, Request $request)
    {
        $projects = Project::with('createdBy', 'user', 'client')->onlyTrashed()->where('deleted_by', $user->id)
            ->where(function ($q) use ($request) {
                return $q->when($request->search, function ($q) use ($request) {
                    return $q->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('status', 'like', '%' . $request->search . '%');
                });
            })->orderBy('deleted_at', 'DESC')->paginate(25);
        return response()->view('crm.pages.users.relations.projects.deleted', compact('user', 'projects'));
    }

    public function showAssignedTasks(User $user, Request $request)
    {
        $tasks = Task::with('createdBy', 'user', 'project')
            ->where('user_id', $user->id)
            ->orderBy('id', 'DESC')->paginate(25);
        return response()->view('crm.pages.users.relations.tasks.assigned', compact('user', 'tasks'));
    }

    public function showCreatedTasks(User $user, Request $request)
    {
        $tasks = Task::with('createdBy', 'user', 'project')
            ->where('created_by', $user->id)
            ->orderBy('id', 'DESC')->paginate(25);
        return response()->view('crm.pages.users.relations.tasks.created', compact('user', 'tasks'));
    }

    public function showCreatedUsers(User $user, Request $request)
    {
        $users = User::with('createdBy')->withTrashed()
            ->where('created_by', $user->id)
            ->where(function ($q) use ($request) {
                return $q->when($request->search, function ($q) use ($request) {
                    return $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%')
                        ->orWhere('role', 'like', '%' . $request->search . '%');
                });
            })->orderBy('id', 'DESC')->paginate(25);
        return response()->view('crm.pages.users.relations.users.created', compact('user', 'users'));
    }

    public function showDeletedUsers(User $user, Request $request)
    {
        $users = User::with('deletedBy')->onlyTrashed()
            ->where('deleted_by', $user->id)
            ->where(function ($q) use ($request) {
                return $q->when($request->search, function ($q) use ($request) {
                    return $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%')
                        ->orWhere('role', 'like', '%' . $request->search . '%');
                });
            })->orderBy('id', 'DESC')->paginate(25);
        return response()->view('crm.pages.users.relations.users.deleted', compact('user', 'users'));
    }

    public function showCreatedClients(User $user, Request $request)
    {
        $clients = Client::with('createdBy')->withTrashed()
            ->where('created_by', $user->id)
            ->where(function ($q) use ($request) {
                return $q->when($request->search, function ($q) use ($request) {
                    return $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('vat', 'like', '%' . $request->search . '%');
                });
            })->orderBy('id', 'DESC')->paginate(25);
        return response()->view('crm.pages.users.relations.clients.created', compact('user', 'clients'));
    }

    public function showDeletedClients(User $user, Request $request)
    {
        $clients = Client::with('deletedBy')->withTrashed()
            ->where('deleted_by', $user->id)
            ->where(function ($q) use ($request) {
                return $q->when($request->search, function ($q) use ($request) {
                    return $q->where('name', 'like', '%' . $request->search . '%')
                        ->orWhere('vat', 'like', '%' . $request->search . '%');
                });
            })->orderBy('id', 'DESC')->paginate(25);
        return response()->view('crm.pages.users.relations.clients.deleted', compact('user', 'clients'));
    }

    public function showUploadedFiles(User $user, Request $request)
    {
        $files = File::with('uploadedBy')
            ->where('uploaded_by', $user->id)
            ->orderBy('id', 'DESC')->paginate(25);
            
            return response()->view('crm.pages.users.relations.files.uploaded', compact('user', 'files'));
    }
}
