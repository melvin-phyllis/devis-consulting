<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    // Récupérer tous les clients
    $clients = \App\Models\Client::all();
    
    // Envoyer les clients à la vue index.blade.php
    return view('clients.index', compact('clients'));
}

    public function create()
{
    // Afficher le formulaire de création avec la liste des clients existants
    $clients = \App\Models\Client::all();
    return view('clients.create', compact('clients'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'raison_sociale' => 'required|string|max:255',
        'adresse'        => 'required',
        'telephone'      => 'required',
        'email'          => 'required|email',
        'rccm_cc'        => 'nullable|string',
        'logo'           => 'nullable|file|mimes:jpg,jpeg,png,gif,svg,webp|max:4096',
    ]);

    $validated['user_id'] = auth()->id();

    if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
        $validated['logo'] = $request->file('logo')->store('clients', 'public');
    }

    \App\Models\Client::create($validated);

    return redirect()->route('clients.index')->with('success', 'Client créé avec succès !');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::findOrFail($id);
        $devis = $client->documents()->where('type', 'devis')->orderBy('created_at', 'desc')->get();
        $factures = $client->documents()->where('type', 'facture')->orderBy('created_at', 'desc')->get();
        
        return view('clients.show', compact('client', 'devis', 'factures'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::findOrFail($id);

        $validated = $request->validate([
            'raison_sociale' => 'required|string|max:255',
            'email'          => [
                'required', 'email', 'max:255',
                Rule::unique('clients')->where(fn($q) => $q->where('user_id', auth()->id()))->ignore($client->id),
            ],
            'telephone' => 'required|string|max:20',
            'adresse'   => 'required|string',
            'rccm_cc'   => 'nullable|string|max:50',
            'logo'      => 'nullable|file|mimes:jpg,jpeg,png,gif,svg,webp|max:4096',
        ]);

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            if ($client->logo) Storage::disk('public')->delete($client->logo);
            $validated['logo'] = $request->file('logo')->store('clients', 'public');
        }

        $client->update($validated);

        return redirect()->route('clients.index')->with('success', 'Client mis à jour avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::findOrFail($id);
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client supprimé avec succès');
    }
}
