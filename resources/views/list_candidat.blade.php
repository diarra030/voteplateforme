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
                    </li> @endif
                    <li>
                        <a href="/vote"
                            class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Votez
                            Ici</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="text-center text-5xl font-bold mt-5">
            Listes des Candidats.
        </div>

    </div>

    <div class="overflow-x-auto container mx-auto mt-8">
    <button data-modal-target="static-modal" data-modal-toggle="static-modal"
            class="inline-flex items-center space-x-2 text-white bg-blue-500 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button">
            <span
                class="inline-flex items-center justify-center w-4 h-4 text-xs font-semibold text-blue-800 bg-blue-200 rounded-full">
                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2"
                        d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
            </span>
            <span>
                Nouveau Candidat
            </span>
        </button>
                            <center>
                            @if (session('success_supprime'))
                                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                                 {{ session('success_supprime') }}
                                </div>
                             @endif
                            </center>
        <table id="myTable2" class="table-auto w-full border-collapse border border-gray-200 shadow-lg rounded-lg">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="py-3 px-4 border border-gray-300">Nom</th>
                    <th class="py-3 px-4 border border-gray-300">Prénom</th>
                    <th class="py-3 px-4 border border-gray-300">Type Candidat</th>
                    <th class="py-3 px-4 border border-gray-300">Photo</th>
                    <th class="py-3 px-4 border border-gray-300">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($candidats as $candidat)
                    <tr class="hover:bg-gray-100">
                        <td class="py-2 px-4 border border-gray-300">{{ $candidat->nom }}</td>
                        <td class="py-2 px-4 border border-gray-300">{{ $candidat->prenom }}</td>
                        <td class="py-2 px-4 border border-gray-300">{{ $candidat->type_candidat }}</td>
                        <td class="py-2 px-4 border border-gray-300">
                            <img src="{{ $candidat->photo ? asset('storage/' . $candidat->photo) : asset('images/default-avatar.png') }}"
                                alt="Photo du Candidat" class="w-10 h-10 rounded-full">
                        </td>
                        <td class="py-2 px-4 border border-gray-300">
                            <center>
                                <a href="{{ route('candidats.show', $candidat->id) }}">
                                    <button
                                        class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-cyan-500 to-blue-500 group-hover:from-cyan-500 group-hover:to-blue-500 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-cyan-200 dark:focus:ring-cyan-800">
                                        <span
                                            class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                            Voir </span>
                                    </button>
                                </a>
                            </center>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-2 px-4 text-center border border-gray-300">Aucun candidat trouvé.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>


    <!-- Modal Candidat -->
    <div id="static-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Enregistrement de Candidat
                        <!-- Messages d'alerte -->
                        <div id="successMessageCandidat" class="alert text-center bg-green-500 text-white mt-4 hidden"
                            role="alert">
                        </div>

                        <div id="errorMessageCandidat" class="alert text-center bg-red-500 text-white mt-4 hidden"
                            role="alert"></div>
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="static-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Fermé</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">



                    <form id="CandidatForm" action="/enregistrement-candidat" method="POST"
                        enctype="multipart/form-data" class="max-w-sm mx-auto">
                        @csrf
                        <div class="mb-5">
                            <label for="nom" class="block mb-2 text-sm font-medium text-gray-900">Nom du
                                Candidat</label>
                            <input type="text" id="nom" name="nom"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5"
                                required>
                        </div>
                        <div class="mb-5">
                            <label for="prenom" class="block mb-2 text-sm font-medium text-gray-900">Prénom du
                                Candidat</label>
                            <input type="text" id="prenom" name="prenom"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5"
                                required>
                        </div>
                        <div class="mb-5">
                            <label for="type_candidat" class="block mb-2 text-sm font-medium text-gray-900">Type de
                                Candidat</label>
                            <select id="type_candidat" name="type_candidat"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5">
                                <option value="" disabled selected>Sélectionnez</option>
                                <option value="PRESIDENT">PRESIDENT</option>
                                <option value="COMMISSAIRE AUX COMPTES">Commissaire aux comptes</option>
                            </select>
                        </div>
                        <div class="mb-5">
                            <label for="photo" class="block mb-2 text-sm font-medium text-gray-900">Photo du
                                Candidat</label>
                            <input type="file" id="photo" name="photo"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5">
                            <p class="mt-1 text-sm text-gray-500">NB: Si vous n'avez pas de photo, une image sera
                                utilisée par défaut.</p>
                        </div>
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 rounded-lg text-sm px-5 py-2.5">
                            Enregistrer
                        </button>
                    </form>




                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="static-modal" type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Fermer</button>

                </div>
            </div>
        </div>
    </div>
    <!--Fin Modal Candidat -->






    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- jQuery (nécessaire pour DataTables) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#myTable2').DataTable({
                "paging": true, // Activer la pagination
                "searching": true, // Activer la barre de recherche
                "ordering": true, // Activer l'option de tri
                "pageLength": 10, // Nombre de lignes par page
                "order": [
                    [3, "desc"]
                ] // Trier par la 4ème colonne (index 3) par défaut
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#CandidatForm').on('submit', function(e) {
                e.preventDefault(); // Empêcher la soumission par défaut du formulaire

                // Récupérer les données du formulaire
                var formData = new FormData(this);

                $.ajax({
                    url: '/enregistrement-candidat', // URL du formulaire
                    type: 'POST', // Méthode POST
                    data: formData, // Données du formulaire
                    processData: false, // Ne pas traiter les données
                    contentType: false, // Ne pas définir le type de contenu
                    success: function(response) {
                        // Afficher le message de succès
                        $('#successMessageCandidat').text(response.message).show();

                        // Vider le formulaire
                        $('#CandidatForm')[0].reset();

                        // Fermer le modal après 2 secondes
                        setTimeout(function() {
                            $('#modalClient').modal('hide');
                            $('#successMessageCandidat').hide();
                        }, 2000);
                    },
                    error: function(xhr) {
                        // Afficher le message d'erreur
                        var errorMessage = 'Une erreur s\'est produite, veuillez réessayer.';

                        // Vérifier si le serveur retourne un message d'erreur
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON
                                .message; // Récupérer le message d'erreur du serveur
                        }

                        $('#errorMessageCandidat').text(errorMessage).show();
                        // Cacher le message d'erreur après 2 secondes
                        setTimeout(function() {
                            $('#errorMessageCandidat').hide();
                        }, 2000);
                    }
                });
            });
        });
    </script>

</body>

</html>
