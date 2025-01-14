<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nom' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'role' => 'membre',
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }

    public function store_membre(Request $request)
    {
        $ValidatedData = $request->validate([
            'nom' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $utilisateur = User::create([
            'nom' => $ValidatedData['nom'],
            'email' => $ValidatedData['email'],
            'password' => bcrypt($ValidatedData['password']),
            'role' => 'membre',
        ]);

        return response()->json(['success' => 'Votre compte a bien été créé.']);
    }

    public function update(Request $request, $id)
    {
        $ValidatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|string',
            'password' => 'nullable|string',
        ]);

        $user = User::findOrFail($id);
        $user->nom = $ValidatedData['nom'];
        $user->email = $ValidatedData['email'];
        $user->role = $ValidatedData['role'];
        if (strlen($ValidatedData['password']) > 0) {
            $user->password = bcrypt($ValidatedData['password']);
        }
        $user->save();

        return redirect()->back()->with('success', 'Utilisateur modifié avec succès.');
    }

    public function listeUser()
    {
        // Récupérer la liste des utilisateurs
        $utilisateurs = User::all();

        return view('list_user')->with('utilisateurs', $utilisateurs);
    }

    public function destroy($id)
    {
        // Rechercher le candidat à supprimer
        $user = User::findOrFail($id);
    
        // Supprimer le candidat
        $user->delete();
    
        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Utilisateur supprimé avec succès.');
    }
}
