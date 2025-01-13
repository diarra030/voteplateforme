<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidat;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    /**
     * Affiche la page de vote avec les candidats.
     */
    public function showVotePage()
    {
        // Récupère les candidats selon leur type
        $presidents = Candidat::where('type_candidat', 'president')->get();
        $commissaires = Candidat::where('type_candidat', 'commissaire aux comptes')->get();

        return view('vote', compact('presidents', 'commissaires'));
    }

    /**
     * Enregistre les votes de l'utilisateur.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Vérifie si l'utilisateur a déjà voté pour un président
        $hasVotedForPresident = Vote::where('user_id', $user->id)
            ->whereHas('candidat', function ($query) {
                $query->where('type_candidat', 'president');
            })->exists();

        if ($hasVotedForPresident) {
            return redirect()->route('vote.index')->with('error', 'Vous avez déjà voté.');
        }

        // Validation des entrées
        $request->validate([
            'president_id' => 'required|exists:candidats,id',
            'commissaire_ids' => 'nullable|array',
            'commissaire_ids.*' => 'exists:candidats,id',
        ]);

        // Enregistre le vote pour le président
        Vote::create([
            'user_id' => $user->id,
            'candidat_id' => $request->president_id,
        ]);

        // Enregistre les votes pour les commissaires aux comptes
        if ($request->has('commissaire_ids')) {
            foreach ($request->commissaire_ids as $commissaire_id) {
                Vote::create([
                    'user_id' => $user->id,
                    'candidat_id' => $commissaire_id,
                ]);
            }
        }

        return redirect()->route('vote.index')->with('success', 'Votre vote a été pris en compte.');
    }
}
