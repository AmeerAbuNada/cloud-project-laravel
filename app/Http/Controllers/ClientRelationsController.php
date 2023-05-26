<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ClientRelationsController extends Controller
{
    public function projects(Client $client, Request $request)
    {
        $projects = Project::with('createdBy', 'user', 'client')->withTrashed()->where('client_id', $client->id)
            ->where(function ($q) use ($request) {
                return $q->when($request->search, function ($q) use ($request) {
                    return $q->where('title', 'like', '%' . $request->search . '%')
                        ->orWhere('status', 'like', '%' . $request->search . '%');
                });
            })->orderBy('id', 'DESC')->paginate(25);
        return response()->view('crm.pages.clients.relations.projects', compact('client', 'projects'));
    }

    public function tasks(Client $client)
    {
        $tasks = $client->tasks;
        return response()->view('crm.pages.clients.relations.tasks', compact('client', 'tasks'));
    }
}
