<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TechStore') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Bootstrap JS dashboard>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  
    <!-- panier -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    
    <!-- AOS CSS -->
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">



    <style>
        /* Body global */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #0f172a; /* Fond sombre */
            color: #e2e8f0; /* Texte clair */
            line-height: 1.6;
        }

        /* Navbar */
        .navbar {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: 700;
            color: #38bdf8;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .navbar-brand:hover {
            color: #0ea5e9;
        }

        .nav-link {
            font-size: 1rem;
            font-weight: 500;
            color: #94a3b8;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 6px;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .nav-link:hover {
            background: #1e293b;
            color: #38bdf8;
        }

        /* Dropdown styles */
        .dropdown-menu {
            background: #1e293b;
            border: none;
            border-radius: 8px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
            width:100%;
        }

        .dropdown-item {
            padding: 10px 15px;
            font-size: 0.95rem;
            color: #94a3b8;
            text-decoration: none;
            transition: background 0.3s ease, color 0.3s ease;
        }

        .dropdown-item:hover {
            background: #0f172a;
            color: #38bdf8;
        }

        /* Main content */
        .main-content {
            padding: 50px 20px;
            text-align: center;
            min-height: calc(100vh - 150px); /* Ajustement pour navbar et footer */

            height: 100%; /* S'assurer que la hauteur du corps occupe toute la page */
                    margin: 0; /* Supprimer les marges par défaut */
                    display: flex;
                    flex-direction: column; /* Disposer les éléments en colonne */
        }

        .main-content h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #38bdf8;
        }

        .main-content p {
            font-size: 1rem;
            line-height: 1.8;
            color: #94a3b8;
        }

        /* Footer 
        footer {
            background: #1e293b;
            color: #94a3b8;
            text-align: center;
            padding: 20px 30px;
        }

        footer a {
            color: #38bdf8;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        footer a:hover {
            color: #0ea5e9;
        }

        /* Responsiveness 
        @media (max-width: 768px) {
            .navbar-nav {
                flex-direction: column;
                gap: 10px;
            }
        }*/

        /**** test suprimable si footer*/
                        /* Applique le style global à la page */
                html, body {
                    height: 100%; /* S'assurer que la hauteur du corps occupe toute la page */
                    margin: 0; /* Supprimer les marges par défaut */
                    display: flex;
                    flex-direction: column; /* Disposer les éléments en colonne */
                }

                .container {
                    flex: 1; /* Faire en sorte que le contenu occupe tout l'espace restant */
                }

                /* Reste du CSS du footer... */


    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'TechStore') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Connexion') }}</a>
                                </li>
                            @endif
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Inscription') }}</a>
                                </li>
                            @endif
                        @else


                        <li class="nav-item"><a class="nav-link" href="{{ route('produits') }}">Produits</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('panier.afficher') }}">
                                Panier <span class="badge bg-danger">{{ App\Http\Controllers\PanierController::compterArticlesPanier() }}</span>
                            </a>
                        </li>

                            <!-- Vérifier si l'utilisateur est admin -->
                        @if(Auth::user()->role === 'admin')
                            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        @endif


                        <li class="nav-item"><a class="nav-link" href="{{ route('propos') }}">A propos</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('pricing') }}">Promotions</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('services') }}">Services clients</a></li>

                        
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                          <!-- Vérifier si l'utilisateur est admin -->
                                    @if(Auth::user()->role === 'admin')
                                        <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    @endif
                                    <li><a class="dropdown-item" href="{{ route('produits') }}">{{ __('Produits') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('home') }}">{{ __('Home') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('panier.afficher') }}">{{ __('Panier') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('propos') }}">{{ __('A propos') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('pricing') }}">{{ __('Promotions') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('services') }}">{{ __('Services clients') }}</a></li>
                                    <li><a class="dropdown-item" href="{{ route('profile.show') }}">{{ __('Profile') }}</a></li>
                                    <li>
                                       
                                        <form  class="dropdown-item" id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;"> 
                                            @csrf 
                                        </form> 
 
                                        <!-- Lien de déconnexion qui soumet le formulaire --> 
                                        <a class="dropdown-item" href="javascript:void(0);" onclick="document.getElementById('logout-form').submit();">Déconnexion</a>
                               
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="main-content">
            @yield('content')
        </main>

    </div>






    @include('include.footer')

</body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let dropdownToggle = document.querySelector('#navbarDropdown');
        let mainNavLinks = document.querySelectorAll('.navbar-nav > .nav-item:not(.dropdown)');

        dropdownToggle.addEventListener('click', function () {
            let dropdownMenu = document.querySelector('.dropdown-menu');

            if (dropdownMenu.classList.contains('show')) {
                // Le menu va se fermer, alors on réaffiche les autres liens
                mainNavLinks.forEach(link => link.style.display = 'none');
            } else {
                // Le menu va s'ouvrir, alors on cache les autres liens
                mainNavLinks.forEach(link => link.style.display = 'block');
            }
        });

        /*Détecter le clic en dehors du menu pour réafficher les liens*/
        document.addEventListener('click', function (event) {
            let isClickInside = dropdownToggle.contains(event.target) || document.querySelector('.dropdown-menu').contains(event.target);
            
            if (!isClickInside) {
                mainNavLinks.forEach(link => link.style.display = 'block');
            }
        });
    });
</script>


<script>
    /* compteur pour le panier supprimable
    document.addEventListener('DOMContentLoaded', function () {
        function updateCartCount() {
            fetch("{{ route('panier.count') }}")  // Route Laravel qui renvoie le nombre d'articles
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.count;
                })
                .catch(error => console.error('Erreur mise à jour panier:', error));
        }

        // Vérifie et met à jour le compteur toutes les 5 secondes
        setInterval(updateCartCount, 5000);
    }); */
</script>

