<?php

namespace App\Http\Controllers;

use App\Events\User\UserDeleted;
use App\Events\User\UserRestored;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Client;
use App\Models\File;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Notifications\WelcomeEmailNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::with('createdBy')->when($request->search, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('role', 'like', '%' . $request->search . '%');
        })->orderBy('created_at', 'DESC')->paginate(25);
        return response()->view('crm.pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('crm.pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $random = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ234567890!$%^&!$%^&');
        $generatedPassword = substr($random, 0, 10);
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($generatedPassword);
        $user->address = $request->input('address');
        $user->phone_number = $request->input('phone');
        $user->role = $request->input('role');
        $user->created_by = auth()->user()->id;
        $isSaved = $user->save();
        if ($isSaved) {
            $user->notify(new WelcomeEmailNotification($user, $generatedPassword));
            event(new Registered($user));
        }
        return response()->json([
            'message' => $isSaved ? 'User Created Successfully!' : 'Failed to create a user, Please try again.',
        ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        if ($user == auth()->user()->id) {
            return abort(Response::HTTP_NOT_FOUND);
        }
        $user = User::withTrashed()->findOrFail($user);
        $assigned_projects_count = Project::withTrashed()->where('user_id', $user->id)->count();
        $created_projects_count = Project::withTrashed()->where('created_by', $user->id)->count();
        $deleted_projects_count = Project::withTrashed()->where('deleted_by', $user->id)->count();
        $assigned_tasks_count = Task::where('user_id', $user->id)->count();
        $created_tasks_count = Task::where('created_by', $user->id)->count();
        $created_users_count = User::withTrashed()->where('created_by', $user->id)->count();
        $deleted_users_count = User::withTrashed()->where('deleted_by', $user->id)->count();
        $created_clients_count = Client::withTrashed()->where('created_by', $user->id)->count();
        $deleted_clients_count = Client::withTrashed()->where('deleted_by', $user->id)->count();
        $files_count = File::where('uploaded_by', $user->id)->count();
        return response()->view('crm.pages.users.show', compact(
            'user',
            'assigned_projects_count',
            'created_projects_count',
            'deleted_projects_count',
            'assigned_tasks_count',
            'created_tasks_count',
            'created_users_count',
            'deleted_users_count',
            'created_clients_count',
            'deleted_clients_count',
            'files_count',
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        if ($user == auth()->user()->id) {
            return abort(Response::HTTP_NOT_FOUND);
        }
        $user = User::withTrashed()->findOrFail($user);
        return response()->view('crm.pages.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $user)
    {
        if ($user == auth()->user()->id) {
            return abort(Response::HTTP_NOT_FOUND);
        }
        $user = User::withTrashed()->findOrFail($user);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->phone_number = $request->input('phone');
        $user->role = $request->input('role');
        $isSaved = $user->save();
        return response()->json([
            'message' => $isSaved ? 'User Updated Successfully!' : 'Failed to update a user, Please try again.',
        ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if ($user->id == auth()->user()->id) {
            return abort(Response::HTTP_NOT_FOUND);
        }
        $user->deleted_at = now();
        $user->deleted_by = auth()->user()->id;
        $isDeleted = $user->save();
        if ($isDeleted) {
            event(new UserDeleted($user));
        }
        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted!' : 'Failed',
            'text' => $isDeleted ? 'User Deleted Successfully!' : 'Failed to delete user, Please try again',
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function showDeleted(Request $request)
    {
        $users = User::with('deletedBy')->onlyTrashed()->where(function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('role', 'like', '%' . $request->search . '%');
        })->orderBy('deleted_at', 'DESC')->paginate(25);
        return response()->view('crm.pages.users.deleted', compact('users'));
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->deleted_at = null;
        $user->deleted_by = null;
        $isRestored = $user->save();
        if ($isRestored) {
            event(new UserRestored($user));
        }
        return response()->json([
            'message' => $isRestored ? 'User Restored Successfully!' : 'Failed to restore the user, please try again.',
        ], $isRestored ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
