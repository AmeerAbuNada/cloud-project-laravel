<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if(auth()->user()->is_admin) {

            //Counts
            $users_count = User::withTrashed()->count();
            $clients_count = Client::withTrashed()->count();
            $projects_count = Project::withTrashed()->count();
            $tasks_count = Task::count();
    
    
            //Projects
            $completed_projects = Project::where('status', 'Completed')->count();
            $inProgress_projects = Project::where('status', 'In Progress')->count();
            $canceled_projects = Project::where('status', 'Canceled')->count();
    
            //Tasks
            $completed_tasks = Task::where('status', 'Completed')->count();
            $inProgress_tasks = Task::where('status', 'In Progress')->count();
            $canceled_tasks = Task::where('status', 'Canceled')->count();
    
            $users = User::orderBy('created_at', 'DESC')->limit(4)->get();
            $clients = Client::orderBy('created_at', 'DESC')->limit(6)->get();
            $projects = Project::with('client')->limit(8)->get();
    
            //Deleted
            $deleted_users = User::onlyTrashed()->count();
            $deleted_clients = Client::onlyTrashed()->count();
            $deleted_projects = Project::onlyTrashed()->count();
            return response()->view('crm.pages.dashboard', compact(
                'users_count',
                'clients_count',
                'projects_count',
                'tasks_count',
                'completed_projects',
                'inProgress_projects',
                'canceled_projects',
                'completed_tasks',
                'inProgress_tasks',
                'canceled_tasks',
                'users',
                'clients',
                'projects',
                'deleted_users',
                'deleted_clients',
                'deleted_projects',
            ));
        } else {
            $tasks = Task::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->limit(15)->get();
            $projects = Project::where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->limit(15)->get();
            return response()->view('crm.pages.dashboard', compact(
                'tasks',
                'projects',
            ));
        }
    }
}
