<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidat;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashoardController extends Controller
{
    public function dashboard()
    {
        // Récupérer la liste des candidats avec le nombre de votes
        $candidats = DB::table('candidats')
            ->leftJoin('votes', 'candidats.id', '=', 'votes.candidat_id')
            ->select(
                'candidats.id',
                'candidats.nom',
                'candidats.prenom',
                'candidats.photo',
                'candidats.type_candidat',
                DB::raw('COUNT(votes.id) as nombre_votes')
            )
            ->groupBy('candidats.id', 'candidats.nom', 'candidats.prenom', 'candidats.photo', 'candidats.type_candidat')
            ->get();
    
        // Récupérer le nombre total de candidats
        $nombreCandidats = DB::table('candidats')->count();
    
        // Récupérer le nombre d'utilisateurs distincts qui ont voté
        $nombreVotants = DB::table('votes')->distinct('user_id')->count('user_id');
    
        // Retourner les données à la vue du tableau de bord
        return view('dashboard', compact('candidats', 'nombreCandidats', 'nombreVotants'));
    }
    


}
