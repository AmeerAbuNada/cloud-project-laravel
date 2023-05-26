<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManagerRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::where('role', 'manager')->when($request->search, function ($q) use ($request) {
            return $q->where('name', 'LIKE', "%$request->search%")->orWhere('email', 'LIKE', "%$request->search%");
        })->paginate(10);
        parent::saveLog('Opened all managers page', auth()->user()->id);
        return response()->view('crm.pages.managers.index', compact('users'));
    }


    public function trainees(Request $request)
    {
        $users = User::where('role', 'trainee')->when($request->search, function ($q) use ($request) {
            return $q->where('name', 'LIKE', "%$request->search%")->orWhere('email', 'LIKE', "%$request->search%");
        })->paginate(10);
        parent::saveLog('Opened all trainees page', auth()->user()->id);

        return response()->view('crm.pages.managers.index', compact('users'));
    }


    public function advisors(Request $request)
    {
        $users = User::where('role', 'advisor')->when($request->search, function ($q) use ($request) {
            return $q->where('name', 'LIKE', "%$request->search%")->orWhere('email', 'LIKE', "%$request->search%");
        })->paginate(10);

        parent::saveLog('Opened all advisors page', auth()->user()->id);

        return response()->view('crm.pages.managers.index', compact('users'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        parent::saveLog('Opened create manager page', auth()->user()->id);
        return response()->view('crm.pages.managers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreManagerRequest $request)
    {
        $user = User::create($request->getParsedData());
        parent::saveLog('Created a new manager', auth()->user()->id);
        return response()->json([
            'message' => $user ? 'Manager has been created!' : 'Failed, try again.',
        ], $user ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $manager)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $manager)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $manager)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $manager)
    {
        if (auth()->user()->id == $manager->id) {
            return response()->json([
                'title' => 'Failed',
                'text' => 'you can\'t delete yourself',
                'icon' => 'error',
            ], Response::HTTP_BAD_REQUEST);
        }
        $deleted = $manager->delete();
        if ($deleted) {
            parent::saveLog('Deleted a manager', auth()->user()->id);
        }

        return response()->json([
            'title' => $deleted ? 'Deleted!' : 'Failed',
            'text' =>  $deleted ? 'Manager Has been deleted successfully!' : 'failed to delete, try again.',
            'icon' => $deleted ? 'success' : 'error',
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
