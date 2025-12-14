<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding-bottom: 60px;
        }
        
        /* Navigation moderne avec dégradé */
        .navbar-custom {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%) !important;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            padding: 1rem 0;
        }
        
        .navbar-brand-custom {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff !important;
            text-decoration: none;
        }
        
        .navbar-brand-custom:hover {
            color: #3498db !important;
            transform: scale(1.05);
            transition: all 0.3s;
        }
        
        .nav-link-custom {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .nav-link-custom:hover {
            background: rgba(255,255,255,0.1);
            color: #fff !important;
            transform: translateY(-2px);
        }
        
        .nav-link-custom.active {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: #fff !important;
        }
        
        /* Boutons modernes */
        .btn-custom-primary {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.4);
            transition: all 0.3s;
        }
        
        .btn-custom-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.6);
            color: white;
        }
        
        .btn-custom-success {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.4);
            transition: all 0.3s;
        }
        
        .btn-custom-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(39, 174, 96, 0.6);
            color: white;
        }
        
        .btn-custom-warning {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(243, 156, 18, 0.4);
            transition: all 0.3s;
        }
        
        .btn-custom-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(243, 156, 18, 0.6);
            color: white;
        }
        
        .btn-custom-danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
            transition: all 0.3s;
        }
        
        .btn-custom-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.6);
            color: white;
        }
        
        .btn-custom-secondary {
            background: linear-gradient(135deg, #95a5a6 0%, #7f8c8d 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            transition: all 0.3s;
        }
        
        .btn-custom-secondary:hover {
            transform: translateY(-2px);
            color: white;
        }
        
        /* Cards modernes */
        .card-custom {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
            transition: all 0.3s;
            background: white;
            overflow: hidden;
        }
        
        .card-custom:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.2);
        }
        
        .card-header-custom {
            background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);
            color: white;
            border: none;
            padding: 1.5rem;
            font-weight: 600;
        }
        
        /* Conteneur principal */
        .main-content {
            background: rgba(255,255,255,0.95);
            border-radius: 20px;
            padding: 2rem;
            margin: 2rem 0;
            box-shadow: 0 8px 30px rgba(0,0,0,0.1);
        }
        
        /* Formulaires */
        .form-control-custom {
            border-radius: 10px;
            border: 2px solid #e0e0e0;
            padding: 0.75rem 1rem;
            transition: all 0.3s;
        }
        
        .form-control-custom:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }
        
        /* Footer */
        .footer-custom {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 1.5rem 0;
            margin-top: 3rem;
            box-shadow: 0 -4px 15px rgba(0,0,0,0.2);
        }
        
        /* Badges */
        .badge-custom-success {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .badge-custom-warning {
            background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }
        
        .badge-custom-danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }
        
        /* Alerts */
        .alert-custom-success {
            background: linear-gradient(135deg, #27ae60 0%, #229954 100%);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 1rem 1.5rem;
        }
        
        .alert-custom-danger {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            border: none;
            border-radius: 15px;
            padding: 1rem 1.5rem;
        }
        
        /* Titres */
        h1, h2, h3, h4, h5, h6 {
            color: #2c3e50;
            font-weight: 700;
        }
        
        /* Zone de recherche */
        .search-box {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand-custom" href="{{ route('livres.index') }}">
                <i class="bi bi-book-half"></i> {{ config('app.name', 'Bibliothèque') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border-color: rgba(255,255,255,0.5);">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom {{ request()->routeIs('livres.*') ? 'active' : '' }}" href="{{ route('livres.index') }}">
                            <i class="bi bi-book"></i> Livres
                        </a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom {{ request()->routeIs('reservations.*') ? 'active' : '' }}" href="{{ route('reservations.index') }}">
                                <i class="bi bi-calendar-check"></i> Mes Réservations
                            </a>
                        </li>
                        @if(auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link nav-link-custom {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-speedometer2"></i> Dashboard Admin
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-link-custom dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" style="border-radius: 15px; border: none; box-shadow: 0 8px 30px rgba(0,0,0,0.15);">
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    <i class="bi bi-person"></i> Mon Profil
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> Déconnexion
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> Connexion
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-link-custom" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> Inscription
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container">
        <div class="main-content">
            @if(session('success'))
                <div class="alert alert-custom-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-custom-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill"></i> {{ session('error') }}
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-custom text-center">
        <div class="container">
            <p class="mb-0">&copy; {{ date('Y') }} {{ config('app.name', 'Bibliothèque') }}. Tous droits réservés.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
