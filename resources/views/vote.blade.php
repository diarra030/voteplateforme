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
            <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
                <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Flowbite</span>
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
                        <a href="{{ route('dashboard') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('list_user') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Liste
                            Membres</a>
                    </li>
                    <li>
                        <a href="{{ route('listes-candidats') }}"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Liste
                            Candidats</a>
                    </li>
                    @endif
                    <li>
                        <a href="/vote"
                            class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500">Votez
                            Ici</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container mx-auto py-6 px-4">
        <h1 class="text-2xl lg:text-3xl font-bold text-center mb-6 text-gray-800">Vote pour les candidats</h1>
    
        @if(session('error'))
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif
    
        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
    
        <form action="{{ route('vote.store') }}" method="POST">
            @csrf
    
            {{-- Section pour les candidats président --}}
            <div class="bg-white shadow-md rounded-lg p-4 lg:p-6 mb-8">
                <h2 class="text-xl lg:text-2xl font-semibold text-blue-600 mb-4">Vote pour le Président</h2>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    @foreach($presidents as $president)
                        <div class="bg-gray-50 border rounded-lg p-3 shadow-sm">
                            <img src="{{ asset('storage/' . $president->photo) }}" alt="Photo de {{ $president->nom }}" class="rounded-t-lg">
                            <h3 class="text-base font-semibold">{{ $president->nom }} {{ $president->prenom }}</h3>
                            <p class="text-sm text-gray-600">{{ $president->description }}</p>
                            <div class="mt-3">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="president_id" value="{{ $president->id }}" class="form-radio text-blue-600" required>
                                    <span class="ml-2 text-sm text-gray-700">Choisir {{ $president->nom }}</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
    
            {{-- Section pour les candidats commissaires aux comptes --}}
            <div class="bg-white shadow-md rounded-lg p-4 lg:p-6 mb-8">
                <h2 class="text-xl lg:text-2xl font-semibold text-green-600 mb-4">Vote pour les Commissaires aux Comptes</h2>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                    @foreach($commissaires as $commissaire)
                        <div class="bg-gray-50 border rounded-lg p-3 shadow-sm">
                            <img src="{{ asset('storage/' . $commissaire->photo) }}" alt="Photo de {{ $commissaire->nom }}" class="rounded-t-lg">
                            <h3 class="text-base font-semibold">{{ $commissaire->nom }} {{ $commissaire->prenom }}</h3>
                            <p class="text-sm text-gray-600">{{ $commissaire->description }}</p>
                            <div class="mt-3">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="commissaire_ids[]" value="{{ $commissaire->id }}" class="form-checkbox text-green-600">
                                    <span class="ml-2 text-sm text-gray-700">Choisir {{ $commissaire->nom }}</span>
                                </label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
    
            {{-- Bouton de soumission --}}
            <div class="text-center">
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Soumettre votre vote</button>
            </div>
        </form>
    </div>
    


    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- CDN jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>






</body>

</html>
