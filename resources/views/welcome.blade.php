<?php
use Illuminate\Support\Facades\Auth; // Importation de la façade Auth

// Démarrage de la session n'est pas nécessaire avec Laravel
// session_start();

// Avec Laravel, on vérifie l'authentification différemment
// $isLoggedIn = isset($_SESSION['user_id']);
$isLoggedIn = Auth::check(); // Utilise l'authentification de Laravel

// Base de données fictive pour les plats
$menu = [
    'entrees' => [
        ['id' => 1, 'nom' => 'Salade César', 'description' => 'Laitue romaine, croûtons, parmesan, sauce césar maison', 'prix' => 50000, 'image' => 'salade-cesar.jpg'],
        ['id' => 2, 'nom' => 'Soupe à l\'oignon gratinée', 'description' => 'Oignons caramélisés, bouillon de bœuf, croûtons, fromage gratiné', 'prix' => 49000, 'image' => 'soupe-oignon.jpg'],
        ['id' => 3, 'nom' => 'Carpaccio de bœuf', 'description' => 'Fines tranches de bœuf, copeaux de parmesan, huile d\'olive, câpres', 'prix' => 105000, 'image' => 'carpaccio.jpg']
    ],
    'plats' => [
        ['id' => 4, 'nom' => 'Entrecôte Grillée', 'description' => 'Entrecôte de bœuf grillée 300g, frites maison, sauce au poivre vert', 'prix' => 215000, 'image' => 'entrecote.jpg'],
        ['id' => 5, 'nom' => 'Risotto aux Cèpes', 'description' => 'Riz arborio, cèpes frais, parmesan affiné 24 mois, huile de truffe', 'prix' => 180000, 'image' => 'risotto.jpg'],
        ['id' => 6, 'nom' => 'Pavé de Saumon', 'description' => 'Filet de saumon Label Rouge, légumes de saison, sauce hollandaise', 'prix' => 195000, 'image' => 'saumon.jpg']
    ],
    'desserts' => [
        ['id' => 7, 'nom' => 'Crème Brûlée à la Vanille', 'description' => 'Crème infusée à la vanille Bourbon, sucre caramélisé', 'prix' => 65000, 'image' => 'creme-brulee.jpg'],
        ['id' => 8, 'nom' => 'Moelleux au Chocolat', 'description' => 'Chocolat noir 70%, cœur coulant, glace vanille de Madagascar', 'prix' => 75000, 'image' => 'moelleux.jpg'],
        ['id' => 9, 'nom' => 'Tarte aux Fruits de Saison', 'description' => 'Pâte sablée maison, fruits frais de saison, crème pâtissière', 'prix' => 60000, 'image' => 'tarte-fruits.jpg']
    ]
];

// On n'a plus besoin de ces blocs de traitement car l'authentification est gérée par Laravel Breeze
// Traitement de la connexion
// $loginError = '';
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
//     ...
// }

// Traitement de l'inscription
// $registerError = '';
// $registerSuccess = '';
// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
//     ...
// }

// La déconnexion est maintenant gérée par Laravel Breeze
// if (isset($_GET['logout'])) {
//     ...
// }
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le Bon Goût - Restaurant Gastronomique</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'restaurant-gold': '#D4AF37',
                        'restaurant-dark': '#2C2C2C',
                        'restaurant-light': '#F9F5EB',
                    },
                    fontFamily: {
                        'serif': ['Playfair Display', 'serif'],
                        'sans': ['Montserrat', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- AOS Animation Library -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <style>
        .menu-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .menu-card:hover {
            transform: translateY(-5px);
        }

        .bg-dish {
            background-size: cover;
            background-position: center;
            background-blend-mode: overlay;
        }

        .section-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #D4AF37, transparent);
        }

        .btn-gold {
            background-color: #D4AF37;
            border: none;
            position: relative;
            overflow: hidden;
            z-index: 1;
            transition: color 0.3s ease;
        }

        .btn-gold:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: #2C2C2C;
            transition: left 0.3s ease;
            z-index: -1;
        }

        .btn-gold:hover:before {
            left: 0;
        }

        .font-script {
            font-family: 'Playfair Display', serif;
            font-style: italic;
        }
    </style>
</head>

<body class="bg-restaurant-light text-restaurant-dark font-sans">
    <!-- Barre de navigation -->
    <nav class="bg-restaurant-dark text-white sticky top-0 z-50 shadow-xl">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center justify-between py-3">
                <div class="flex items-center space-x-3">
                    <div class="text-restaurant-gold text-3xl">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-serif font-bold">Le Bon Goût</h1>
                        <p class="text-xs text-restaurant-gold font-script">Restaurant Gastronomique</p>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#menu"
                        class="hover:text-restaurant-gold transition-colors duration-300 flex flex-col items-center">
                        <i class="fas fa-book-open mb-1"></i>
                        <span>Menu</span>
                    </a>
                    <a href="#about"
                        class="hover:text-restaurant-gold transition-colors duration-300 flex flex-col items-center">
                        <i class="fas fa-info-circle mb-1"></i>
                        <span>À propos</span>
                    </a>
                    <a href="#contact"
                        class="hover:text-restaurant-gold transition-colors duration-300 flex flex-col items-center">
                        <i class="fas fa-envelope mb-1"></i>
                        <span>Contact</span>
                    </a>
                    @auth
                    <div class="flex flex-col items-center">
                        <i class="fas fa-user-circle mb-1"></i>
                        <span class="text-restaurant-gold">{{ Auth::user()->name }}</span>
                    </div>
                    <!-- Utiliser la route de déconnexion de Laravel Breeze -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex flex-col items-center hover:text-restaurant-gold transition-colors duration-300">
                            <i class="fas fa-sign-out-alt mb-1"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                    @else
                    <!-- Utiliser les routes de Laravel Breeze -->
                    <a href="{{ route('login') }}" class="hover:text-restaurant-gold transition-colors duration-300 flex flex-col items-center">
                        <i class="fas fa-sign-in-alt mb-1"></i>
                        <span>Connexion</span>
                    </a>
                    <a href="{{ route('register') }}" class="flex flex-col items-center px-4 py-2 rounded-full bg-restaurant-gold text-restaurant-dark hover:bg-opacity-80 transition-all duration-300 btn-gold hover:text-white">
                        <span>Inscription</span>
                    </a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-white focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-3">
                    <a href="#menu"
                        class="hover:text-restaurant-gold transition-colors duration-300 py-2 px-3 flex items-center space-x-2">
                        <i class="fas fa-book-open"></i>
                        <span>Menu</span>
                    </a>
                    <a href="#about"
                        class="hover:text-restaurant-gold transition-colors duration-300 py-2 px-3 flex items-center space-x-2">
                        <i class="fas fa-info-circle"></i>
                        <span>À propos</span>
                    </a>
                    <a href="#contact"
                        class="hover:text-restaurant-gold transition-colors duration-300 py-2 px-3 flex items-center space-x-2">
                        <i class="fas fa-envelope"></i>
                        <span>Contact</span>
                    </a>
                    @auth
                    <div class="py-2 px-3 flex items-center space-x-2">
                        <i class="fas fa-user-circle"></i>
                        <span class="text-restaurant-gold">{{ Auth::user()->name }}</span>
                    </div>
                    <!-- Utiliser la route de déconnexion de Laravel Breeze -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="hover:text-restaurant-gold transition-colors duration-300 py-2 px-3 flex items-center space-x-2">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                    @else
                    <!-- Utiliser les routes de Laravel Breeze -->
                    <a href="{{ route('login') }}" class="hover:text-restaurant-gold transition-colors duration-300 py-2 px-3 flex items-center space-x-2">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Connexion</span>
                    </a>
                    <a href="{{ route('register') }}" class="py-2 px-3 flex items-center space-x-2 bg-restaurant-gold text-restaurant-dark rounded-lg hover:bg-opacity-80 transition-all duration-300">
                        <i class="fas fa-user-plus"></i>
                        <span>Inscription</span>
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- En-tête hero avec parallax -->
    <header class="relative h-screen flex items-center justify-center overflow-hidden">
        <div
            class="absolute inset-0 bg-[url('https://via.placeholder.com/1600x900')] bg-cover bg-center bg-fixed opacity-80">
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-black/30"></div>
        <div class="z-10 text-center text-white px-6" data-aos="fade-up" data-aos-duration="1000">
            <h2 class="text-4xl md:text-6xl font-serif font-bold mb-4">Le Bon Goût</h2>
            <div class="flex justify-center mb-6">
                <div class="w-24 h-1 bg-restaurant-gold"></div>
            </div>
            <p class="text-xl md:text-2xl font-script mb-8">Une expérience culinaire d'exception</p>
            <a href="#menu"
                class="px-8 py-3 bg-restaurant-gold text-restaurant-dark rounded-full hover:shadow-lg transform transition hover:-translate-y-1 hover:bg-opacity-90 inline-block btn-gold hover:text-white">
                Découvrir notre menu
            </a>
        </div>
        <div class="absolute bottom-8 w-full text-center text-white animate-bounce">
            <i class="fas fa-chevron-down"></i>
        </div>
    </header>

    <!-- Le reste du code HTML reste le même... -->

    <!-- Citation -->
    <section class="py-12 md:py-20 bg-restaurant-dark text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center" data-aos="fade-up">
                <i class="fas fa-quote-left text-restaurant-gold text-4xl mb-6"></i>
                <blockquote class="text-xl md:text-2xl font-serif italic mb-6">
                    "La cuisine est l'art de transformer instantanément les produits chargés d'histoire en joie."
                </blockquote>
                <p class="text-restaurant-gold">— Fatou NGOM</p>
            </div>
        </div>
    </section>

    <!-- Contenu principal -->
    <main class="container mx-auto px-4">
        <!-- Section Menu -->
        <section id="menu" class="py-16 md:py-24">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-restaurant-gold uppercase tracking-wide font-medium">Notre Carte</span>
                <h2 class="text-3xl md:text-4xl font-serif font-bold mt-2 mb-4">Menu Gastronomique</h2>
                <div class="section-divider w-24 mx-auto my-4"></div>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Explorez notre sélection de plats préparés avec des ingrédients frais et locaux,
                    mettant en valeur le meilleur de la cuisine française contemporaine.
                </p>
            </div>

            <!-- Filtres de catégories -->
            <div class="flex justify-center mb-12">
                <div class="flex flex-wrap gap-4 justify-center">
                    <button
                        class="category-filter px-6 py-2 rounded-full border-2 border-restaurant-gold text-restaurant-gold hover:bg-restaurant-gold hover:text-white transition-all duration-300 active">
                        Toutes les catégories
                    </button>
                    <button
                        class="category-filter px-6 py-2 rounded-full border-2 border-gray-300 hover:border-restaurant-gold hover:text-restaurant-gold transition-all duration-300">
                        Entrées
                    </button>
                    <button
                        class="category-filter px-6 py-2 rounded-full border-2 border-gray-300 hover:border-restaurant-gold hover:text-restaurant-gold transition-all duration-300">
                        Plats
                    </button>
                    <button
                        class="category-filter px-6 py-2 rounded-full border-2 border-gray-300 hover:border-restaurant-gold hover:text-restaurant-gold transition-all duration-300">
                        Desserts
                    </button>
                </div>
            </div>

            <!-- Entrées -->
            <div class="category-section mb-16" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-2xl font-serif font-semibold mb-8 flex items-center">
                    <span class="w-8 h-1 bg-restaurant-gold mr-3"></span>
                    Entrées
                    <span class="w-full h-px bg-gray-200 ml-3"></span>
                </h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($menu['entrees'] as $plat)
                    <div class="menu-card bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl"
                        data-aos="fade-up">
                        <div class="h-48 bg-dish"
                            style="background-image: url('https://via.placeholder.com/600x400'), linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4));">
                            <div class="w-full h-full flex items-end p-4">
                                <span
                                    class="bg-restaurant-gold text-restaurant-dark px-3 py-1 rounded-full text-sm font-bold">
                                    {{ number_format($plat['prix'], 2, ',', ' ') }} FRANCS CFA
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h4 class="text-xl font-serif font-semibold text-restaurant-dark mb-2">
                                {{ $plat['nom'] }}
                            </h4>
                            <p class="text-gray-600 leading-relaxed">{{ $plat['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Plats -->
            <div class="category-section mb-16" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-2xl font-serif font-semibold mb-8 flex items-center">
                    <span class="w-8 h-1 bg-restaurant-gold mr-3"></span>
                    Plats Principaux
                    <span class="w-full h-px bg-gray-200 ml-3"></span>
                </h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($menu['plats'] as $plat)
                    <div class="menu-card bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl"
                        data-aos="fade-up">
                        <div class="h-48 bg-dish"
                            style="background-image: url('https://via.placeholder.com/600x400'), linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4));">
                            <div class="w-full h-full flex items-end p-4">
                                <span
                                    class="bg-restaurant-gold text-restaurant-dark px-3 py-1 rounded-full text-sm font-bold">
                                    {{ number_format($plat['prix'], 2, ',', ' ') }} FRANCS CFA
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h4 class="text-xl font-serif font-semibold text-restaurant-dark mb-2">
                                {{ $plat['nom'] }}
                            </h4>
                            <p class="text-gray-600 leading-relaxed">{{ $plat['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Desserts -->
            <div class="category-section mb-8" data-aos="fade-up" data-aos-delay="300">
                <h3 class="text-2xl font-serif font-semibold mb-8 flex items-center">
                    <span class="w-8 h-1 bg-restaurant-gold mr-3"></span>
                    Desserts
                    <span class="w-full h-px bg-gray-200 ml-3"></span>
                </h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($menu['desserts'] as $plat)
                    <div class="menu-card bg-white rounded-lg overflow-hidden shadow-lg hover:shadow-xl"
                        data-aos="fade-up">
                        <div class="h-48 bg-dish"
                            style="background-image: url('https://via.placeholder.com/600x400'), linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4));">
                            <div class="w-full h-full flex items-end p-4">
                                <span
                                    class="bg-restaurant-gold text-restaurant-dark px-3 py-1 rounded-full text-sm font-bold">
                                    {{ number_format($plat['prix'], 2, ',', ' ') }} FRANCS CFA
                                </span>
                            </div>
                        </div>
                        <div class="p-6">
                            <h4 class="text-xl font-serif font-semibold text-restaurant-dark mb-2">
                                {{ $plat['nom'] }}
                            </h4>
                            <p class="text-gray-600 leading-relaxed">{{ $plat['description'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
                <!-- Section À Propos -->
                <section id="about" class="py-16 md:py-24 bg-white">
            <div class="container mx-auto px-4">
                <div class="flex flex-col lg:flex-row items-center gap-12">
                    <div class="lg:w-1/2" data-aos="fade-right">
                        <div class="relative">
                            <div class="absolute -top-4 -left-4 w-64 h-64 border-2 border-restaurant-gold z-0"></div>
                            <img src="https://via.placeholder.com/600x800" alt="Notre Chef"
                                class="relative z-10 w-full max-w-lg mx-auto shadow-xl">
                        </div>
                    </div>
                    <div class="lg:w-1/2" data-aos="fade-left">
                        <span class="text-restaurant-gold uppercase tracking-wide font-medium">À Propos de Nous</span>
                        <h2 class="text-3xl md:text-4xl font-serif font-bold mt-2 mb-6">Notre Passion pour la
                            Gastronomie</h2>
                        <div class="w-20 h-1 bg-restaurant-gold mb-6"></div>
                        <p class="text-gray-600 mb-4 leading-relaxed">
                            Depuis 2005, <span class="font-serif italic">Le Bon Goût</span> vous accueille dans un cadre
                            élégant et chaleureux au cœur de Paris,
                            pour vous faire découvrir une cuisine française raffinée et inventive.
                        </p>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Notre Chef étoilé, Pierre Moreau, sélectionne avec soin des produits frais et de saison
                            auprès
                            de producteurs locaux passionnés pour créer des plats qui subliment les saveurs authentiques
                            tout en y apportant une touche de modernité.
                        </p>
                        <div class="flex items-center space-x-6 mb-8">
                            <div class="text-center">
                                <p class="text-4xl font-serif font-bold text-restaurant-gold">15</p>
                                <p class="text-gray-500">Années d'expertise</p>
                            </div>
                            <div class="h-12 w-px bg-gray-300"></div>
                            <div class="text-center">
                                <p class="text-4xl font-serif font-bold text-restaurant-gold">2</p>
                                <p class="text-gray-500">Étoiles Michelin</p>
                            </div>
                            <div class="h-12 w-px bg-gray-300"></div>
                            <div class="text-center">
                                <p class="text-4xl font-serif font-bold text-restaurant-gold">12</p>
                                <p class="text-gray-500">Chefs passionnés</p>
                            </div>
                        </div>
                        <a href="#contact"
                            class="px-8 py-3 bg-restaurant-gold text-restaurant-dark rounded-full hover:shadow-lg transform transition hover:-translate-y-1 hover:bg-opacity-90 inline-block btn-gold hover:text-white">
                            Réserver une table
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section Contact -->
        <section id="contact" class="py-16 md:py-24">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="text-restaurant-gold uppercase tracking-wide font-medium">Nous Contacter</span>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold mt-2 mb-4">Réservez Votre Table</h2>
                    <div class="section-divider w-24 mx-auto my-4"></div>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Pour réserver une table ou pour toute demande d'information,
                        n'hésitez pas à nous contacter par téléphone ou via le formulaire ci-dessous.
                    </p>
                </div>

                <div class="flex flex-col lg:flex-row gap-12">
                    <div class="lg:w-1/2" data-aos="fade-right">
                        <div class="bg-white p-8 rounded-lg shadow-lg">
                            <h3 class="text-xl font-serif font-semibold mb-6">Formulaire de Contact</h3>
                            <form>
                                <div class="mb-6">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Nom
                                        complet</label>
                                    <input type="text" id="name"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold">
                                </div>
                                <div class="mb-6">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="email">Email</label>
                                    <input type="email" id="email"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold">
                                </div>
                                <div class="mb-6">
                                    <label class="block text-gray-700 text-sm font-bold mb-2"
                                        for="phone">Téléphone</label>
                                    <input type="tel" id="phone"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold">
                                </div>

                                <div class="mb-6">
                                    <label class="block text-gray-700 text-sm font-bold mb-2" for="message">Commentaires
                                    </label>
                                    <textarea id="message" rows="4"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold"></textarea>
                                </div>
                                <button type="submit"
                                    class="w-full px-6 py-3 bg-restaurant-gold text-restaurant-dark font-bold rounded-md hover:shadow-lg transform transition hover:-translate-y-1 hover:bg-opacity-90 btn-gold hover:text-white">
                                    Envoyer mon appreciation
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="lg:w-1/2" data-aos="fade-left">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                                <div
                                    class="w-16 h-16 bg-restaurant-gold/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-map-marker-alt text-restaurant-gold text-2xl"></i>
                                </div>
                                <h4 class="font-serif font-semibold mb-2">Notre Adresse</h4>
                                <p class="text-gray-600">15 Rue du Restaurant<br>75008 Dakar, Senegal</p>
                            </div>

                            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                                <div
                                    class="w-16 h-16 bg-restaurant-gold/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-phone-alt text-restaurant-gold text-2xl"></i>
                                </div>
                                <h4 class="font-serif font-semibold mb-2">Téléphone</h4>
                                <p class="text-gray-600">+221 77 888 99 99</p>
                            </div>

                            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                                <div
                                    class="w-16 h-16 bg-restaurant-gold/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-envelope text-restaurant-gold text-2xl"></i>
                                </div>
                                <h4 class="font-serif font-semibold mb-2">Email</h4>
                                <p class="text-gray-600">contact@lebongout.fr</p>
                            </div>

                            <div class="bg-white p-6 rounded-lg shadow-lg text-center">
                                <div
                                    class="w-16 h-16 bg-restaurant-gold/20 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-clock text-restaurant-gold text-2xl"></i>
                                </div>
                                <h4 class="font-serif font-semibold mb-2">Horaires</h4>
                                <p class="text-gray-600">Lun-Sam: 12h–14h30, 19h–22h30<br>Dimanche: Fermé</p>
                            </div>
                        </div>

                        <div class="mt-8 bg-white p-6 rounded-lg shadow-lg">
                            <h4 class="font-serif font-semibold mb-4">Nous Trouver</h4>
                            <div class="w-full h-64 bg-gray-200 rounded-lg">
                                <!-- Emplacement pour Google Maps -->
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <span>Carte interactive indisponible</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Témoignages -->
        <section class="py-16 md:py-24 bg-restaurant-dark text-white">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="text-restaurant-gold uppercase tracking-wide font-medium">Ce Que Disent Nos
                        Clients</span>
                    <h2 class="text-3xl md:text-4xl font-serif font-bold mt-2 mb-4">Témoignages</h2>
                    <div class="section-divider w-24 mx-auto my-4"></div>
                </div>

                <div class="max-w-5xl mx-auto">
                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="bg-white/10 backdrop-blur-md p-6 rounded-lg" data-aos="fade-up"
                            data-aos-delay="100">
                            <div class="flex mb-4">
                                <div class="text-restaurant-gold">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <p class="italic mb-6">
                                "Une expérience culinaire exceptionnelle ! Les saveurs sont parfaitement équilibrées et
                                le service est impeccable. Le cadre est élégant sans être prétentieux."
                            </p>
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-gray-300 mr-4"></div>
                                <div>
                                    <h5 class="font-semibold">Bintou Ndiaye </h5>
                                    <p class="text-xs text-restaurant-gold">Cliente fidèle</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white/10 backdrop-blur-md p-6 rounded-lg" data-aos="fade-up"
                            data-aos-delay="200">
                            <div class="flex mb-4">
                                <div class="text-restaurant-gold">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                            <p class="italic mb-6">
                                "Le chef fait preuve d'une créativité remarquable. Chaque assiette est une œuvre d'art,
                                et les saveurs sont à la hauteur de la présentation. À essayer absolument !"
                            </p>
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-gray-300 mr-4"></div>
                                <div>
                                    <h5 class="font-semibold">Mamadou Lamine Fofana</h5>
                                    <p class="text-xs text-restaurant-gold">Critique gastronomique</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white/10 backdrop-blur-md p-6 rounded-lg" data-aos="fade-up"
                            data-aos-delay="300">
                            <div class="flex mb-4">
                                <div class="text-restaurant-gold">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                            <p class="italic mb-6">
                                "Un moment délicieux passé en famille. La carte des vins est exceptionnelle et les
                                recommandations du sommelier parfaites. Les desserts sont divins !"
                            </p>
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-full bg-gray-300 mr-4"></div>
                                <div>
                                    <h5 class="font-semibold">Amadou Tidiane Sow</h5>
                                    <p class="text-xs text-restaurant-gold">Amateur de gastronomie</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </main>

    <!-- Footer -->
    <footer class="bg-restaurant-dark text-white pt-16 pb-8">
        <!-- Contenu du footer inchangé -->

        <div class="pt-8 mt-8 border-t border-gray-800 text-center text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Le Bon Goût - Restaurant Gastronomique. Tous droits réservés.</p>
        </div>
    </footer>

    <!-- Suppression des modals de connexion et d'inscription -->
    <!-- Ils ne sont plus nécessaires puisqu'on utilise maintenant les pages Laravel Breeze -->

    <!-- Script AOS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <!-- Script personnalisé -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialisation des animations AOS
            AOS.init({
                duration: 800,
                once: true
            });

            // Gestion du menu mobile
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', function () {
                mobileMenu.classList.toggle('hidden');
            });

            // Gestion des filtres de catégories
            const categoryFilters = document.querySelectorAll('.category-filter');
            const categorySections = document.querySelectorAll('.category-section');

            categoryFilters.forEach(filter => {
                filter.addEventListener('click', function () {
                    // Retirer la classe active de tous les filtres
                    categoryFilters.forEach(f => {
                        f.classList.remove('active', 'bg-restaurant-gold', 'text-white');
                        f.classList.add('border-gray-300');
                    });

                    // Ajouter la classe active au filtre cliqué
                    this.classList.add('active', 'bg-restaurant-gold', 'text-white');
                    this.classList.remove('border-gray-300');

                    // Afficher/masquer les sections correspondantes
                    const category = this.textContent.trim().toLowerCase();

                    if (category === 'toutes les catégories') {
                        categorySections.forEach(section => {
                            section.style.display = 'block';
                        });
                    } else {
                        categorySections.forEach(section => {
                            const sectionTitle = section.querySelector('h3').textContent.trim().toLowerCase();
                            if (sectionTitle.includes(category) ||
                                (category === 'plats' && sectionTitle.includes('plats principaux'))) {
                                section.style.display = 'block';
                            } else {
                                section.style.display = 'none';
                            }
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
