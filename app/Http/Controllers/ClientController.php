<?php

namespace App\Http\Controllers;

use App\Events\Client\ClientCreated;
use App\Events\Client\ClientDeleted;
use App\Events\Client\ClientRestored;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients = Client::with('createdBy')->when($request->search, function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('vat', 'like', '%' . $request->search . '%');
        })->orderBy('created_at', 'DESC')->paginate(25);
        return response()->view('crm.pages.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('crm.pages.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreClientRequest $request)
    {
        $client = new Client();
        $client->name = $request->input('name');
        $client->vat = $request->input('vat');
        $client->address = $request->input('address');
        $client->city = $request->input('city');
        $client->zip = $request->input('zip');
        $client->contact_name = $request->input('contact_name');
        $client->contact_email = $request->input('contact_email');
        $client->contact_phone_number = $request->input('contact_phone');
        $client->created_by = auth()->user()->id;
        $isSaved = $client->save();
        if ($isSaved) {
            event(new ClientCreated($client));
        }
        return response()->json([
            'message' => $isSaved ? 'Client Created Successfully!' : 'Failed to create client, Please try again.',
        ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($client)
    {
        $client = Client::withTrashed()->withCount('projects', 'tasks')->findOrFail($client);
        return response()->view('crm.pages.clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($client)
    {
        $client = Client::withTrashed()->findOrFail($client);
        return response()->view('crm.pages.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClientRequest $request, $client)
    {
        $client = Client::withTrashed()->findOrFail($client);
        $client->name = $request->input('name');
        $client->vat = $request->input('vat');
        $client->address = $request->input('address');
        $client->city = $request->input('city');
        $client->zip = $request->input('zip');
        $client->contact_name = $request->input('contact_name');
        $client->contact_email = $request->input('contact_email');
        $client->contact_phone_number = $request->input('contact_phone');
        $isSaved = $client->save();
        return response()->json([
            'message' => $isSaved ? 'Client Updated Successfully!' : 'Failed to update client, Please try again.',
        ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        $client->deleted_at = now();
        $client->deleted_by = auth()->user()->id;
        $isDeleted = $client->save();
        if ($isDeleted) {
            event(new ClientDeleted($client));
        }
        return response()->json([
            'icon' => $isDeleted ? 'success' : 'error',
            'title' => $isDeleted ? 'Deleted!' : 'Failed',
            'text' => $isDeleted ? 'Client Deleted Successfully!' : 'Failed to delete client, Please try again.',
        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function showDeleted(Request $request)
    {
        $clients = Client::with('deletedBy')->onlyTrashed()->where(function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('vat', 'like', '%' . $request->search . '%');
        })->orderBy('deleted_at', 'DESC')->paginate(25);
        return response()->view('crm.pages.clients.deleted', compact('clients'));
    }

    public function restore($id)
    {
        $client = Client::onlyTrashed()->findOrFail($id);
        $client->deleted_at = null;
        $client->deleted_by = null;
        $isRestored = $client->save();
        if ($isRestored) {
            event(new ClientRestored($client));
        }
        return response()->json([
            'message' => $isRestored ? 'Client Restored Successfully!' : 'Failed to restore the client, please try again.',
        ], $isRestored ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
