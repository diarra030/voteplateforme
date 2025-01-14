<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>VOTE PLATEFORME</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body>

    <nav class="bg-white border-gray-200 dark:bg-gray-900 shadow-lg">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">MUREGA</span>
            </a>
            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">

                <button id="user-menu-button" type="button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                    data-dropdown-placement="bottom-start">
                    <div
                        class="relative inline-flex items-center justify-center w-10 h-10 overflow-hidden bg-blue-100 rounded-full dark:bg-gray-600">
                        <span class="font-medium text-gray-600 dark:text-gray-300">{{ Auth::user()->nom[0] }}</span>
                    </div>
                </button>

                <!-- Dropdown menu -->
                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600"
                    id="user-dropdown">
                    <ul class="py-2" aria-labelledby="user-menu-button">
                        <li>
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profile</a>
                        </li>

                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
                <button data-collapse-toggle="navbar-user" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                    aria-controls="navbar-user" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
                <ul @if(Auth::user()->role === "admin")
                    class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                    <li>
                        <a href="/dashboard"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Dashboard</a>
                    </li>
                    <li>
                        <a href="/list_user"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Liste
                            Membres</a>
                    </li>
                    <li>
                        <a href="/listes-candidats"
                            class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500">Liste
                            Candidats</a>
                    </li>
                    @endif
                    <li>
                        <a href="/vote"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Votez
                            Ici</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


<div class="container mx-auto mt-10 p-6 bg-white shadow-md rounded" style="margin-top: 4rem;">
        <h1 class="text-2xl font-bold text-center mb-6">Informations sur le Candidat</h1>
<center>
@if (session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

</center>

        <!-- Card -->
        <div class="flex flex-col md:flex-row items-center justify-between">
            <!-- Informations textuelles -->
            <div class="md:w-2/3">
                <p class="mb-4"><strong>Nom :</strong> {{ $candidat->nom }}</p>
                <p class="mb-4"><strong>Prénom :</strong> {{ $candidat->prenom }}</p>
                <p class="mb-4"><strong>Type de Candidat :</strong> {{ $candidat->type_candidat }}</p>
            </div>

            <!-- Photo -->
            <div class="md:w-1/3 flex justify-end">
                <img src="{{ asset('storage/'.$candidat->photo) }}" alt="Photo du candidat"
                     class="w-32 h-32 rounded-full shadow-md">
            </div>
        </div>

        <!-- Boutons Modifier et Supprimer -->
        <div class="mt-6 flex justify-between">
            <a  class="px-4 py-2 bg-blue-500 text-white rounded shadow-md hover:bg-blue-600" data-modal-target="default-modal" data-modal-toggle="default-modal">

                Modifier

            </a>
            <form action="{{ route('candidats.destroy', $candidat->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce candidat ?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded shadow-md hover:bg-red-600">
        Supprimer
    </button>
</form>

        </div>
    </div>





<!-- Modal Modifier Candidat -->
<div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Modifier un Candidat
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
            <form id="formEditCandidat" action="{{ route('candidats.update', $candidat->id) }}" method="POST" enctype="multipart/form-data" class="max-w-sm mx-auto">
    @csrf
    @method('PUT') <!-- Méthode PUT pour la mise à jour -->

    <div class="mb-5">
        <label for="nom" class="block mb-2 text-sm font-medium text-gray-900">Nom du Candidat</label>
        <input type="text" id="nom" name="nom" value="{{ $candidat->nom }}"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required>
    </div>

    <div class="mb-5">
        <label for="prenom" class="block mb-2 text-sm font-medium text-gray-900">Prénom du Candidat</label>
        <input type="text" id="prenom" name="prenom" value="{{ $candidat->prenom }}"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5" required>
    </div>

    <div class="mb-5">
        <label for="type_candidat" class="block mb-2 text-sm font-medium text-gray-900">Type de Candidat</label>
        <select id="type_candidat" name="type_candidat"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5">
            <option value="" disabled>-- Sélectionnez --</option>
            <option value="president" {{ $candidat->type_candidat == 'PRESIDENT' ? 'selected' : '' }}>PRESIDENT</option>
            <option value="commissaire aux comptes" {{ $candidat->type_candidat == 'COMMISSAIRE AUX COMPTES' ? 'selected' : '' }}>COMMISSAIRE AUX COMPTES</option>
        </select>
    </div>

    <div class="mb-5">
        <label for="photo" class="block mb-2 text-sm font-medium text-gray-900">Photo du Candidat</label>
        <input type="file" id="photo" name="photo"
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5">
        <p class="mt-1 text-sm text-gray-500">NB : Si vous n'ajoutez pas de nouvelle photo, l'ancienne sera conservée.</p>
    </div>

    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 rounded-lg text-sm px-5 py-2.5">
        Modifier
    </button>
</form>

            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                <button data-modal-hide="default-modal" type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Fermé</button>

            </div>
        </div>
    </div>
</div>
    <!--Fin Modal Modifier Candidat -->

    <!--Tableau pour afficher les votants pour du candidat -->
    <div class="container mx-auto mt-8 mb-4">
        <center>
            <div class=" inline-flex p-3 space-x-10">
                <span> Liste des votants pour le candidat : {{ $candidat->nom }} </span>
                <span> Nombre de votants : {{ count($votants) }} </span>
            </div>
        </center>
        <table id="myTable2" class="table-auto w-full border-collapse border border-gray-200 shadow-lg rounded-lg">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="py-3 px-4 border border-gray-300">Nom et prenom</th>
                    <th class="py-3 px-4 border border-gray-300">email</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($votants as $votant)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border border-gray-300">{{ $votant->user->nom }}</td>
                        <td class="py-2 px-4 border border-gray-300">{{ $votant->user->email }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-2 px-4 text-center border border-gray-300">Pas de votant.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- Fin Tableau pour afficher les votants pour du candidat -->






    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- jQuery (nécessaire pour DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>




</body>

</html>
