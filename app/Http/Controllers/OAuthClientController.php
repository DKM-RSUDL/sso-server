<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;

class OAuthClientController extends Controller
{
    protected $clientRepository;

    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function index()
    {
        $clients = Client::all();
        return view('client.index', compact('clients'));
    }

    public function create()
    {
        return view('client.create');
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'redirect_uri' => 'required|url',
            ]);

            $client = $this->clientRepository->create(
                Auth::id(), // User ID (admin yang membuat client)
                $request->name,
                $request->redirect_uri
            );

            // Generate client secret
            $client->secret = Str::random(40);
            $client->save();

            return back()->with('success', 'Client created successfully! Client ID: ' . $client->id . ', Client Secret: ' . $client->secret);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $request->validate([
                'id'            => 'required',
                'name'          => 'required|string|max:255',
                'redirect_uri'  => 'required|url',
            ]);

            $client = Client::find($request->id);

            if (empty($client)) throw new Exception('Client not found !');

            $this->clientRepository->update(
                $client,
                $request->name,
                $request->redirect_uri
            );

            return back()->with('success', 'Client updated successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        try {
            $request->validate([
                'id'            => 'required',
            ]);

            $client = Client::find($request->id);

            if (empty($client)) throw new Exception('Client not found !');

            $client->delete();

            return back()->with('success', 'Client deleted successfully!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
