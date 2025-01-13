<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Candidat;
use App\Models\Vote;
use App\Models\Utilisateur;

class CandidatController extends Controller
{

    public function form_candidat()
    {
        return view('liste_candidat');
    }

    // Enregistre un nouveau candidat
    public function creation_candidat(Request $request)
    {
        // Validation des données
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'type_candidat' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Vérifie si une photo est fournie
        if ($request->hasFile('photo')) {
            // Enregistre la photo dans le répertoire `public/photos_candidats`
            $photoPath = $request->file('photo')->store('images', 'public');
        } else {
            // Définit un chemin par défaut pour les photos
            $photoPath = 'images/default-photo.jpg';
        }

        // Crée un nouvel enregistrement pour le candidat
        $candidat = new Candidat();
        $candidat->nom = $request->nom;
        $candidat->prenom = $request->prenom;
        $candidat->type_candidat = $request->type_candidat;
        $candidat->photo = $photoPath;
        $candidat->save();

        // Redirige avec un message de succès
        return response()->json(['message' => 'Candidat créé avec succès !'], 200);
    }


    // liste des candidats
    public function liste_candidats()
    {
        $candidats = Candidat::all();
        return view('list_candidat', compact('candidats'));
    }

// voir un candidat
public function show($id)
    {
        // Récupérer le candidat par son ID
        $candidat = Candidat::findOrFail($id);

        // Retourner la vue avec les données du candidat
        return view('show_candidat', compact('candidat'));
    }



    public function update(Request $request, $id)
{
    // Validation des données
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'type_candidat' => 'required|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Récupération du candidat
    $candidat = Candidat::findOrFail($id);

    // Mise à jour des champs
    $candidat->nom = $request->input('nom');
    $candidat->prenom = $request->input('prenom');
    $candidat->type_candidat = $request->input('type_candidat');

    // Gestion de la photo (si une nouvelle photo est uploadée)
    if ($request->hasFile('photo')) {
        // Supprimer l'ancienne photo si elle existe
        if ($candidat->photo && Storage::exists('public/' . $candidat->photo)) {
            Storage::delete('public/' . $candidat->photo);
        }

        // Stocker la nouvelle photo
        $path = $request->file('photo')->store('candidats', 'public');
        $candidat->photo = $path;
    }

    // Enregistrement des modifications
    $candidat->save();

    // Redirection avec un message de succès
    return redirect()->route('candidats.show', $candidat->id)
                     ->with('success', 'Le candidat a été modifié avec succès.');
}

//Supprimer un candidat
public function destroy($id)
{
    // Rechercher le candidat à supprimer
    $candidat = Candidat::findOrFail($id);

    // Supprimer la photo si elle existe
    if ($candidat->photo && Storage::exists($candidat->photo)) {
        Storage::delete($candidat->photo);
    }

    // Supprimer le candidat
    $candidat->delete();

    // Rediriger avec un message de succès
    return redirect('/listes-candidats')->with('success_supprime', 'Le candidat a été supprimé avec succès.');
}



}
