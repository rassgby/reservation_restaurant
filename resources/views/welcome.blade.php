<?php
use Illuminate\Support\Facades\Auth;

$isLoggedIn = Auth::check();

// Base de données fictive pour les plats
$menu = [
    'entrees' => [
        ['id' => 1, 'nom' => 'Salade César', 'description' => 'Laitue romaine, croûtons, parmesan, sauce césar maison', 'prix' => 50000000, 'image' => 'salade-cesar.jpeg'],
        ['id' => 2, 'nom' => 'Soupe à l\'oignon gratinée', 'description' => 'Oignons caramélisés, bouillon de bœuf, croûtons, fromage gratiné', 'prix' => 49000, 'image' => 'soupe-oignon.jpg'],
        ['id' => 3, 'nom' => 'Carpaccio de bœuf', 'description' => 'Fines tranches de bœuf, copeaux de parmesan, huile d\'olive, câpres', 'prix' => 105000, 'image' => 'carpaccio.jpeg']
    ],
    'plats' => [
        ['id' => 4, 'nom' => 'Entrecôte Grillée', 'description' => 'Entrecôte de bœuf grillée 300g, frites maison, sauce au poivre vert', 'prix' => 215000, 'image' => 'entrecote.jpg'],
        ['id' => 5, 'nom' => 'Risotto aux Cèpes', 'description' => 'Riz arborio, cèpes frais, parmesan affiné 24 mois, huile de truffe', 'prix' => 180000, 'image' => 'risotto.jpg'],
        ['id' => 6, 'nom' => 'Pavé de Saumon', 'description' => 'Filet de saumon Label Rouge, légumes de saison, sauce hollandaise', 'prix' => 195000, 'image' => 'saumon.png']
    ],
    'desserts' => [
        ['id' => 7, 'nom' => 'Crème Brûlée à la Vanille', 'description' => 'Crème infusée à la vanille Bourbon, sucre caramélisé', 'prix' => 65000, 'image' => 'creme-brulee.webp'],
        ['id' => 8, 'nom' => 'Moelleux au Chocolat', 'description' => 'Chocolat noir 70%, cœur coulant, glace vanille de Madagascar', 'prix' => 75000, 'image' => 'moelleux.jpg'],
        ['id' => 9, 'nom' => 'Tarte aux Fruits de Saison', 'description' => 'Pâte sablée maison, fruits frais de saison, crème pâtissière', 'prix' => 60000, 'image' => 'tarte-fruits.jpeg']
    ]
];
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
                        'restaurant-dark': '#1C1C1C',
                        'restaurant-light': '#F9F5EB',
                        'restaurant-accent': '#8B4513',
                    },
                    fontFamily: {
                        'serif': ['Playfair Display', 'serif'],
                        'sans': ['Montserrat', 'sans-serif'],
                        'script': ['Pinyon Script', 'cursive'],
                    },
                    backgroundImage: {
                        'hero-pattern': "url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80')",
                        'about-pattern': "url('https://images.unsplash.com/photo-1519676867240-f03562e64548?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80')",
                    }
                }
            }
        }
    </script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Pinyon+Script&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap"
        rel="stylesheet">
    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- AOS Animation Library -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <!-- Splide Carousel -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <!-- Ajout de GSAP pour des animations avancées -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"></script>
    <style>
        /* Styles globaux */
        html {
            scroll-behavior: smooth;
        }

        body {
            overflow-x: hidden;
        }

        .menu-card {
            transition: transform 0.5s ease, box-shadow 0.5s ease;
            overflow: hidden;
        }

        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .menu-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #D4AF37, transparent);
            transform: scaleX(0);
            transform-origin: 0% 50%;
            transition: transform 0.5s ease;
        }

        .menu-card:hover::before {
            transform: scaleX(1);
        }

        .bg-dish {
            background-size: cover;
            background-position: center;
            transition: transform 0.8s ease;
        }

        .menu-card:hover .bg-dish {
            transform: scale(1.1);
        }

        .section-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, #D4AF37, transparent);
        }

        .btn-gold {
            background-color: #D4AF37;
            position: relative;
            overflow: hidden;
            z-index: 1;
            transition: all 0.4s ease;
        }

        .btn-gold::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: #1C1C1C;
            transition: left 0.4s ease;
            z-index: -1;
        }

        .btn-gold:hover::before {
            left: 0;
        }

        .btn-gold:hover {
            color: #fff;
            transform: translateY(-3px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        /* Effet de parallaxe et overlay pour les sections avec image de fond */
        .parallax {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        /* Animation du logo du restaurant */
        .logo-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        /* Animation de défilement pour indiquer de continuer vers le bas */
        .scroll-indicator {
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        /* Style personnalisé pour le menu de navigation lors du défilement */
        .navbar-scrolled {
            background-color: rgba(28, 28, 28, 0.98) !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Animation des cartes de témoignage */
        .testimonial-card {
            transition: all 0.5s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
            background-color: rgba(255, 255, 255, 0.15);
        }

        /* Animation des icônes dans la section contact */
        .contact-icon-container {
            transition: all 0.3s ease;
        }

        .contact-icon-container:hover {
            transform: scale(1.1);
            background-color: rgba(212, 175, 55, 0.3);
        }

        /* Style pour la galerie d'images */
        .gallery-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            grid-gap: 10px;
            grid-auto-flow: dense;
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            transition: all 0.5s ease;
        }

        .gallery-item:hover {
            transform: scale(1.02);
            z-index: 1;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.2);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0) 60%);
            z-index: 1;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .gallery-item:hover::before {
            opacity: 1;
        }

        /* Animation des chiffres en compteur */
        .counter-value {
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .counter-value.pulse {
            animation: pulse 0.5s ease;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        /* Style pour le menu flottant de réservation rapide */
        .quick-reservation {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 999;
            transition: all 0.3s ease;
        }

        .quick-reservation:hover {
            transform: scale(1.05);
        }

        /* Effet de surlignage personnalisé pour les liens de navigation */
        .nav-link {
            position: relative;
            padding-bottom: 5px;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: #D4AF37;
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 100%;
        }
    </style>
</head>

<body class="bg-restaurant-light text-restaurant-dark font-sans">

    <!-- Barre de navigation -->
    <nav id="main-nav" class="bg-restaurant-dark text-white sticky top-0 z-50 transition-all duration-500">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center justify-between py-3">
                <div class="flex items-center space-x-3 logo-animation">
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
                        class="nav-link hover:text-restaurant-gold transition-colors duration-300 flex flex-col items-center">
                        <i class="fas fa-book-open mb-1"></i>
                        <span>Menu</span>
                    </a>
                    <a href="#gallery"
                        class="nav-link hover:text-restaurant-gold transition-colors duration-300 flex flex-col items-center">
                        <i class="fas fa-images mb-1"></i>
                        <span>Galerie</span>
                    </a>
                    <a href="#about"
                        class="nav-link hover:text-restaurant-gold transition-colors duration-300 flex flex-col items-center">
                        <i class="fas fa-info-circle mb-1"></i>
                        <span>À propos</span>
                    </a>
                    <a href="#testimonials"
                        class="nav-link hover:text-restaurant-gold transition-colors duration-300 flex flex-col items-center">
                        <i class="fas fa-star mb-1"></i>
                        <span>Témoignages</span>
                    </a>
                    @auth
                        <div class="flex flex-col items-center">
                            <i class="fas fa-user-circle mb-1"></i>
                            <span class="text-restaurant-gold">{{ Auth::user()->name }}</span>
                        </div>
                        <!-- Utiliser la route de déconnexion de Laravel Breeze -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex flex-col items-center hover:text-restaurant-gold transition-colors duration-300">
                                <i class="fas fa-sign-out-alt mb-1"></i>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    @else
                        <!-- Utiliser les routes de Laravel Breeze -->
                        <a href="{{ route('login') }}"
                            class="nav-link hover:text-restaurant-gold transition-colors duration-300 flex flex-col items-center">
                            <i class="fas fa-sign-in-alt mb-1"></i>
                            <span>Connexion</span>
                        </a>
                        <a href="{{ route('register') }}"
                            class="flex flex-col items-center px-4 py-2 rounded-full bg-restaurant-gold text-restaurant-dark hover:bg-opacity-80 transition-all duration-300 btn-gold hover:text-white">
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
                    <a href="#gallery"
                        class="hover:text-restaurant-gold transition-colors duration-300 py-2 px-3 flex items-center space-x-2">
                        <i class="fas fa-images"></i>
                        <span>Galerie</span>
                    </a>
                    <a href="#about"
                        class="hover:text-restaurant-gold transition-colors duration-300 py-2 px-3 flex items-center space-x-2">
                        <i class="fas fa-info-circle"></i>
                        <span>À propos</span>
                    </a>
                    <a href="#testimonials"
                        class="hover:text-restaurant-gold transition-colors duration-300 py-2 px-3 flex items-center space-x-2">
                        <i class="fas fa-star"></i>
                        <span>Témoignages</span>
                    </a>
                    @auth
                        <div class="py-2 px-3 flex items-center space-x-2">
                            <i class="fas fa-user-circle"></i>
                            <span class="text-restaurant-gold">{{ Auth::user()->name }}</span>
                        </div>
                        <!-- Utiliser la route de déconnexion de Laravel Breeze -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="hover:text-restaurant-gold transition-colors duration-300 py-2 px-3 flex items-center space-x-2">
                                <i class="fas fa-sign-out-alt"></i>
                                <span>Déconnexion</span>
                            </button>
                        </form>
                    @else
                        <!-- Utiliser les routes de Laravel Breeze -->
                        <a href="{{ route('login') }}"
                            class="hover:text-restaurant-gold transition-colors duration-300 py-2 px-3 flex items-center space-x-2">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Connexion</span>
                        </a>
                        <a href="{{ route('register') }}"
                            class="py-2 px-3 flex items-center space-x-2 bg-restaurant-gold text-restaurant-dark rounded-lg hover:bg-opacity-80 transition-all duration-300">
                            <i class="fas fa-user-plus"></i>
                            <span>Inscription</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- En-tête hero avec vidéo ou parallax amélioré -->
    <header class="relative h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-hero-pattern bg-cover bg-center bg-fixed opacity-90"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/70 to-black/40"></div>
        <div class="z-10 text-center text-white px-6 max-w-4xl mx-auto" data-aos="fade-up" data-aos-duration="1200">
            <div class="mb-6 animate-pulse">
                <i class="fas fa-crown text-restaurant-gold text-3xl"></i>
            </div>
            <h2 class="text-5xl md:text-7xl font-serif font-bold mb-6">Le Bon Goût</h2>
            <div class="flex justify-center mb-8">
                <div class="w-32 h-1 bg-restaurant-gold"></div>
            </div>
            <p class="text-2xl md:text-3xl font-script mb-10">Une expérience culinaire d'exception</p>
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <a href="#menu"
                    class="px-8 py-4 bg-restaurant-gold text-restaurant-dark rounded-full hover:shadow-lg transform transition hover:-translate-y-1 hover:bg-opacity-90 inline-block btn-gold hover:text-white">
                    <i class="fas fa-utensils mr-2"></i> Découvrir notre menu
                </a>
                <a href="#contact"
                    class="px-8 py-4 border-2 border-white text-white rounded-full hover:border-restaurant-gold hover:text-restaurant-gold transition-all duration-300 hover:-translate-y-1">
                    <i class="fas fa-calendar-alt mr-2"></i> Réserver une table
                </a>
            </div>
        </div>
        <div class="absolute bottom-12 w-full text-center text-white scroll-indicator">
            <i class="fas fa-chevron-down text-2xl"></i>
        </div>
    </header>

    <!-- Bannière spéciale -->
    <div class="bg-restaurant-gold text-restaurant-dark py-3 relative overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center justify-center gap-4 md:gap-10 font-medium">
                <div class="flex items-center">
                    <i class="fas fa-calendar-day text-xl mr-2"></i>
                    <span>Ouvert tous les jours sauf le dimanche</span>
                </div>
                <div class="hidden md:block h-6 w-px bg-restaurant-dark/30"></div>
                <div class="flex items-center">
                    <i class="fas fa-clock text-xl mr-2"></i>
                    <span>12h–14h30, 19h–22h30</span>
                </div>
                <div class="hidden md:block h-6 w-px bg-restaurant-dark/30"></div>
                <div class="flex items-center">
                    <i class="fas fa-phone-alt text-xl mr-2"></i>
                    <span>+221 77 888 99 99</span>
                </div>
            </div>
        </div>
        <!-- Effet de particules dorées -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none" id="particles-container"></div>
    </div>

    <!-- Introduction avec animation -->
    <section class="py-16 md:py-20">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center" data-aos="fade-up">
                <span class="text-restaurant-gold uppercase tracking-wide font-medium">Bienvenue à</span>
                <h2 class="text-3xl md:text-4xl font-serif font-bold mt-2 mb-6">Le Bon Goût Restaurant</h2>
                <div class="section-divider w-24 mx-auto my-4"></div>
                <p class="text-gray-700 text-lg leading-relaxed mb-8">
                    Au cœur de Dakar, <span class="font-serif italic">Le Bon Goût</span> vous invite à découvrir une
                    cuisine raffinée
                    qui célèbre les saveurs sénégalaises et françaises dans un cadre élégant. Notre Chef étoilé
                    compose des plats d'exception qui éveillent les sens et racontent une histoire.
                </p>
                <div class="flex flex-wrap justify-center gap-6">
                    <div class="w-32 text-center" data-aos="fade-up" data-aos-delay="100">
                        <i class="fas fa-award text-4xl text-restaurant-gold mb-3"></i>
                        <h4 class="font-serif font-semibold">Cuisine Primée</h4>
                    </div>
                    <div class="w-32 text-center" data-aos="fade-up" data-aos-delay="200">
                        <i class="fas fa-leaf text-4xl text-restaurant-gold mb-3"></i>
                        <h4 class="font-serif font-semibold">Produits Locaux</h4>
                    </div>
                    <div class="w-32 text-center" data-aos="fade-up" data-aos-delay="300">
                        <i class="fas fa-glass-cheers text-4xl text-restaurant-gold mb-3"></i>
                        <h4 class="font-serif font-semibold">Carte des Vins</h4>
                    </div>
                    <div class="w-32 text-center" data-aos="fade-up" data-aos-delay="400">
                        <i class="fas fa-concierge-bell text-4xl text-restaurant-gold mb-3"></i>
                        <h4 class="font-serif font-semibold">Service 5 Étoiles</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Citation avec parallaxe -->
    <section class="py-20 md:py-28 bg-restaurant-dark text-white parallax"
        style="background-image: url('https://images.unsplash.com/photo-1559339352-11d035aa65de?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1974&q=80'); background-attachment: fixed;">
        <div class="absolute inset-0 bg-restaurant-dark/80"></div>
        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-3xl mx-auto text-center" data-aos="fade">
                <i class="fas fa-quote-left text-restaurant-gold text-4xl mb-8"></i>
                <blockquote class="text-2xl md:text-3xl font-serif italic mb-8 leading-relaxed">
                    "La cuisine est l'art de transformer instantanément les produits chargés d'histoire en joie pure,
                    une alchimie qui nourrit à la fois le corps et l'âme."
                </blockquote>
                <div class="flex items-center justify-center">
                    <div class="w-16 h-16 rounded-full bg-gray-300 mr-4 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                            alt="Fatou NGOM" class="w-full h-full object-cover">
                    </div>
                    <div class="text-left">
                        <p class="text-restaurant-gold text-xl font-serif">Fatou NGOM</p>
                        <p class="text-gray-300">Chef Exécutif</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contenu principal -->
    <main class="container mx-auto px-4">
        <!-- Section Menu avec animations et filtres améliorés -->
        <section id="menu" class="py-20 md:py-28">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-restaurant-gold uppercase tracking-wide font-medium">Savourez l'Excellence</span>
                <h2 class="text-3xl md:text-5xl font-serif font-bold mt-2 mb-6">Notre Menu</h2>
                <div class="section-divider w-24 mx-auto my-4"></div>
                <p class="text-gray-700 text-lg max-w-2xl mx-auto">
                    Découvrez notre sélection de plats d'exception, élaborés avec des produits frais et locaux.
                    Chaque création est une invitation au voyage gustatif entre tradition et innovation.
                </p>
            </div>

            <!-- Filtres de menu -->
            <div class="flex justify-center mb-10">
                <div class="inline-flex flex-wrap justify-center gap-2 md:gap-4 bg-restaurant-dark/5 p-2 rounded-full">
                    <button
                        class="menu-filter-btn active py-2 px-6 rounded-full transition-all duration-300 bg-restaurant-gold text-restaurant-dark font-medium"
                        data-filter="all">
                        Tous
                    </button>
                    <button
                        class="menu-filter-btn py-2 px-6 rounded-full transition-all duration-300 hover:bg-restaurant-gold/20 font-medium"
                        data-filter="entrees">
                        Entrées
                    </button>
                    <button
                        class="menu-filter-btn py-2 px-6 rounded-full transition-all duration-300 hover:bg-restaurant-gold/20 font-medium"
                        data-filter="plats">
                        Plats
                    </button>
                    <button
                        class="menu-filter-btn py-2 px-6 rounded-full transition-all duration-300 hover:bg-restaurant-gold/20 font-medium"
                        data-filter="desserts">
                        Desserts
                    </button>
                </div>
            </div>

            <!-- Cartes de menu -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 menu-container">
                <!-- Entrées -->
                <?php foreach ($menu['entrees'] as $item): ?>
                <div class="menu-card rounded-xl overflow-hidden shadow-lg bg-white relative group menu-item"
                    data-category="entrees" data-aos="fade-up" data-aos-delay="<?= ($item['id'] - 1) * 100 ?>">
                    <div class="h-56 overflow-hidden relative">
                        <div class="bg-dish absolute inset-0"
                            style="background-image: url('images/<?= $item['image'] ?>')"></div>
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-60 group-hover:opacity-80 transition-opacity">
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                            <p class="text-xs text-restaurant-gold uppercase font-bold tracking-wider mb-1">Entrée</p>
                            <h3 class="font-serif text-xl font-bold"><?= htmlspecialchars($item['nom']) ?></h3>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-gray-600 mb-4"><?= htmlspecialchars($item['description']) ?></p>
                        <div class="flex justify-between items-center">
                            <span
                                class="text-restaurant-gold font-bold"><?= number_format($item['prix'] / 1000, 0, ',', ' ') ?>
                                FCFA</span>
                            <button
                                class="add-to-cart-btn bg-restaurant-dark/10 hover:bg-restaurant-gold text-restaurant-dark w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300"
                                data-id="<?= $item['id'] ?>" data-name="<?= htmlspecialchars($item['nom']) ?>"
                                data-price="<?= $item['prix'] ?>">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="absolute top-3 right-3">
                        <button
                            class="favorite-btn bg-white/80 hover:bg-restaurant-gold w-9 h-9 rounded-full flex items-center justify-center transition-all duration-300 text-gray-600 hover:text-white">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Plats -->
                <?php foreach ($menu['plats'] as $item): ?>
                <div class="menu-card rounded-xl overflow-hidden shadow-lg bg-white relative group menu-item"
                    data-category="plats" data-aos="fade-up" data-aos-delay="<?= ($item['id'] - 4) * 100 ?>">
                    <div class="h-56 overflow-hidden relative">
                        <div class="bg-dish absolute inset-0"
                            style="background-image: url('images/<?= $item['image'] ?>')"></div>
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-60 group-hover:opacity-80 transition-opacity">
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                            <p class="text-xs text-restaurant-gold uppercase font-bold tracking-wider mb-1">Plat
                                Principal</p>
                            <h3 class="font-serif text-xl font-bold"><?= htmlspecialchars($item['nom']) ?></h3>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-gray-600 mb-4"><?= htmlspecialchars($item['description']) ?></p>
                        <div class="flex justify-between items-center">
                            <span
                                class="text-restaurant-gold font-bold"><?= number_format($item['prix'] / 1000, 0, ',', ' ') ?>
                                FCFA</span>
                            <button
                                class="add-to-cart-btn bg-restaurant-dark/10 hover:bg-restaurant-gold text-restaurant-dark w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300"
                                data-id="<?= $item['id'] ?>" data-name="<?= htmlspecialchars($item['nom']) ?>"
                                data-price="<?= $item['prix'] ?>">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="absolute top-3 right-3">
                        <button
                            class="favorite-btn bg-white/80 hover:bg-restaurant-gold w-9 h-9 rounded-full flex items-center justify-center transition-all duration-300 text-gray-600 hover:text-white">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>

                <!-- Desserts -->
                <?php foreach ($menu['desserts'] as $item): ?>
                <div class="menu-card rounded-xl overflow-hidden shadow-lg bg-white relative group menu-item"
                    data-category="desserts" data-aos="fade-up" data-aos-delay="<?= ($item['id'] - 7) * 100 ?>">
                    <div class="h-56 overflow-hidden relative">
                        <div class="bg-dish absolute inset-0"
                            style="background-image: url('images/<?= $item['image'] ?>')"></div>
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-60 group-hover:opacity-80 transition-opacity">
                        </div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 text-white">
                            <p class="text-xs text-restaurant-gold uppercase font-bold tracking-wider mb-1">Dessert</p>
                            <h3 class="font-serif text-xl font-bold"><?= htmlspecialchars($item['nom']) ?></h3>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-gray-600 mb-4"><?= htmlspecialchars($item['description']) ?></p>
                        <div class="flex justify-between items-center">
                            <span
                                class="text-restaurant-gold font-bold"><?= number_format($item['prix'] , 0, ',', ' ') ?>
                                FCFA</span>
                            <button
                                class="add-to-cart-btn bg-restaurant-dark/10 hover:bg-restaurant-gold text-restaurant-dark w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300"
                                data-id="<?= $item['id'] ?>" data-name="<?= htmlspecialchars($item['nom']) ?>"
                                data-price="<?= $item['prix'] ?>">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="absolute top-3 right-3">
                        <button
                            class="favorite-btn bg-white/80 hover:bg-restaurant-gold w-9 h-9 rounded-full flex items-center justify-center transition-all duration-300 text-gray-600 hover:text-white">
                            <i class="far fa-heart"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Télécharger le menu complet -->
            <div class="text-center mt-16">
                <a href="#"
                    class="inline-flex items-center space-x-2 px-8 py-3 bg-restaurant-dark text-white rounded-full hover:bg-restaurant-gold transition-all duration-300">
                    <i class="fas fa-download"></i>
                    <span>Télécharger notre menu complet</span>
                </a>
            </div>
        </section>

        <!-- Galerie photos avec effets avancés -->
        <section id="gallery" class="py-20 md:py-28 bg-restaurant-dark text-white">
            <div class="text-center mb-16" data-aos="fade-up">
                <span class="text-restaurant-gold uppercase tracking-wide font-medium">Notre Univers</span>
                <h2 class="text-3xl md:text-5xl font-serif font-bold mt-2 mb-6">Galerie</h2>
                <div class="section-divider w-24 mx-auto my-4"></div>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto">
                    Plongez dans l'atmosphère unique de notre établissement à travers ces images qui capturent
                    l'essence du Bon Goût. Une immersion visuelle dans notre univers gastronomique.
                </p>
            </div>

            <div class="splide" id="gallery-slider" data-aos="fade-up">
                <div class="splide__track">
                    <ul class="splide__list">
                        <li class="splide__slide">
                            <div class="gallery-item aspect-w-16 aspect-h-9 overflow-hidden cursor-pointer relative group"
                                onclick="openGalleryModal(this)">
                                <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&h=450&q=80"
                                    alt="Restaurant interior"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div
                                    class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white text-3xl"></i>
                                </div>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="gallery-item aspect-w-16 aspect-h-9 overflow-hidden cursor-pointer relative group"
                                onclick="openGalleryModal(this)">
                                <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&h=450&q=80"
                                    alt="Gourmet dish"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div
                                    class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white text-3xl"></i>
                                </div>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="gallery-item aspect-w-16 aspect-h-9 overflow-hidden cursor-pointer relative group"
                                onclick="openGalleryModal(this)">
                                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&h=450&q=80"
                                    alt="Elegant plating"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div
                                    class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white text-3xl"></i>
                                </div>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="gallery-item aspect-w-16 aspect-h-9 overflow-hidden cursor-pointer relative group"
                                onclick="openGalleryModal(this)">
                                <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&h=450&q=80"
                                    alt="Chef preparing food"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div
                                    class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white text-3xl"></i>
                                </div>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="gallery-item aspect-w-16 aspect-h-9 overflow-hidden cursor-pointer relative group"
                                onclick="openGalleryModal(this)">
                                <img src="https://images.unsplash.com/photo-1600891964599-f61ba0e24092?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&h=450&q=80"
                                    alt="Restaurant terrace"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div
                                    class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white text-3xl"></i>
                                </div>
                            </div>
                        </li>
                        <li class="splide__slide">
                            <div class="gallery-item aspect-w-16 aspect-h-9 overflow-hidden cursor-pointer relative group"
                                onclick="openGalleryModal(this)">
                                <img src="https://images.unsplash.com/photo-1551218372-a8789b81b253?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&h=450&q=80"
                                    alt="Cocktail preparation"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                <div
                                    class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                    <i class="fas fa-search-plus text-white text-3xl"></i>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bouton Instagram -->
            <div class="text-center mt-10">
                <a href="https://instagram.com/lebongout" target="_blank"
                    class="inline-flex items-center space-x-2 px-6 py-3 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-full hover:from-purple-600 hover:to-pink-600 transition-all duration-300">
                    <i class="fab fa-instagram"></i>
                    <span>Suivez-nous sur Instagram</span>
                </a>
            </div>
        </section>

        <!-- Section À propos avec animation -->
        <section id="about" class="py-20 md:py-28">
            <div class="container mx-auto px-4">
                <div class="flex flex-col lg:flex-row items-center gap-12">
                    <div class="lg:w-1/2 relative" data-aos="fade-right">
                        <div class="relative z-10">
                            <img src="https://images.unsplash.com/photo-1600891964599-f61ba0e24092?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=800&q=80"
                                alt="Notre restaurant" class="rounded-lg shadow-xl" />
                        </div>
                        <div
                            class="absolute -bottom-8 -right-8 w-64 h-64 bg-restaurant-gold/20 rounded-full blur-3xl -z-10">
                        </div>
                        <div
                            class="absolute -top-8 -left-8 w-48 h-48 bg-restaurant-gold/30 rounded-full blur-3xl -z-10">
                        </div>
                    </div>
                    <div class="lg:w-1/2" data-aos="fade-left" data-aos-delay="200">
                        <span class="text-restaurant-gold uppercase tracking-wide font-medium">Notre Histoire</span>
                        <h2 class="text-3xl md:text-4xl font-serif font-bold mt-2 mb-6">À Propos du Bon Goût</h2>
                        <div class="h-1 w-24 bg-restaurant-gold mb-8"></div>
                        <p class="text-gray-700 mb-6 leading-relaxed">
                            Fondé en 2018 par le Chef Mamadou Sall, Le Bon Goût s'est rapidement imposé comme
                            une référence de la gastronomie à Dakar. Notre restaurant allie avec subtilité
                            les traditions culinaires sénégalaises et les techniques de la haute gastronomie française.
                        </p>
                        <p class="text-gray-700 mb-6 leading-relaxed">
                            Nous sélectionnons avec soin les meilleurs produits locaux et travaillons en étroite
                            collaboration avec des producteurs responsables pour vous offrir une expérience gustative
                            authentique et respectueuse de l'environnement.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-6 mt-8">
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-12 h-12 rounded-full bg-restaurant-gold/20 flex items-center justify-center">
                                    <i class="fas fa-users text-restaurant-gold"></i>
                                </div>
                                <div>
                                    <h4 class="font-serif font-bold text-lg">Équipe Passionnée</h4>
                                    <p class="text-gray-600">Plus de 20 experts</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-4">
                                <div
                                    class="w-12 h-12 rounded-full bg-restaurant-gold/20 flex items-center justify-center">
                                    <i class="fas fa-trophy text-restaurant-gold"></i>
                                </div>
                                <div>
                                    <h4 class="font-serif font-bold text-lg">Reconnu</h4>
                                    <p class="text-gray-600">Prix d'Excellence 2023</p>
                                </div>
                            </div>
                        </div>

                        <a href="#testimonials"
                            class="mt-8 inline-block px-8 py-3 bg-restaurant-gold text-restaurant-dark rounded-full hover:shadow-lg transform transition hover:-translate-y-1 btn-gold hover:text-white">
                            Découvrir nos valeurs
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bannière statistiques -->
        <section class="py-12 bg-restaurant-dark text-white relative overflow-hidden">
            <div class="absolute inset-0 bg-about-pattern bg-cover bg-center opacity-20"></div>
            <div class="absolute inset-0 bg-restaurant-dark/80"></div>
            <div class="container mx-auto px-4 relative z-10">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                    <div data-aos="fade-up" data-aos-delay="0">
                        <div class="text-4xl font-bold text-restaurant-gold mb-2">
                            <span class="counter-value" data-count="5">0</span>+
                        </div>
                        <p class="text-gray-300 font-serif">Années d'Excellence</p>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="100">
                        <div class="text-4xl font-bold text-restaurant-gold mb-2">
                            <span class="counter-value" data-count="12500">0</span>+
                        </div>
                        <p class="text-gray-300 font-serif">Clients Satisfaits</p>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="200">
                        <div class="text-4xl font-bold text-restaurant-gold mb-2">
                            <span class="counter-value" data-count="80">0</span>+
                        </div>
                        <p class="text-gray-300 font-serif">Recettes Uniques</p>
                    </div>
                    <div data-aos="fade-up" data-aos-delay="300">
                        <div class="text-4xl font-bold text-restaurant-gold mb-2">
                            <span class="counter-value" data-count="15">0</span>
                        </div>
                        <p class="text-gray-300 font-serif">Récompenses</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Témoignages clients -->
        <section id="testimonials" class="py-20 md:py-28 bg-restaurant-light">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16" data-aos="fade-up">
                    <span class="text-restaurant-gold uppercase tracking-wide font-medium">Ce qu'ils en disent</span>
                    <h2 class="text-3xl md:text-5xl font-serif font-bold mt-2 mb-6">Témoignages</h2>
                    <div class="section-divider w-24 mx-auto my-4"></div>
                    <p class="text-gray-700 text-lg max-w-2xl mx-auto">
                        Découvrez les expériences vécues par nos clients qui ont partagé la passion
                        que nous mettons chaque jour dans notre cuisine.
                    </p>
                </div>

                <div class="splide" id="testimonials-slider">
                    <div class="splide__track">
                        <ul class="splide__list">
                            <li class="splide__slide p-4">
                                <div class="testimonial-card bg-white p-6 md:p-8 rounded-xl shadow-lg relative">
                                    <div class="text-restaurant-gold text-5xl absolute -top-6 left-6 opacity-20">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                    <div class="flex items-center mb-4">
                                        <div class="w-14 h-14 rounded-full overflow-hidden mr-4">
                                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                                alt="Ousmane D." class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="font-serif font-bold text-lg">Ousmane D.</h4>
                                            <div class="flex text-restaurant-gold text-sm">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 italic mb-4">
                                        "Une expérience gastronomique inoubliable ! Les saveurs sont parfaitement
                                        équilibrées et le service est impeccable.
                                        Le cadre élégant et l'ambiance chaleureuse font du Bon Goût un lieu
                                        incontournable pour les amateurs de fine cuisine."
                                    </p>
                                    <p class="text-xs text-gray-400">Visité en avril 2025</p>
                                </div>
                            </li>
                            <li class="splide__slide p-4">
                                <div class="testimonial-card bg-white p-6 md:p-8 rounded-xl shadow-lg relative">
                                    <div class="text-restaurant-gold text-5xl absolute -top-6 left-6 opacity-20">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                    <div class="flex items-center mb-4">
                                        <div class="w-14 h-14 rounded-full overflow-hidden mr-4">
                                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                                alt="Aminata S." class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="font-serif font-bold text-lg">Aminata S.</h4>
                                            <div class="flex text-restaurant-gold text-sm">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 italic mb-4">
                                        "J'ai fêté mon anniversaire au Bon Goût et ce fut magique. Le menu dégustation
                                        est une véritable symphonie de saveurs.
                                        Mention spéciale au dessert, un moelleux au chocolat d'exception. Merci à toute
                                        l'équipe pour cette soirée mémorable !"
                                    </p>
                                    <p class="text-xs text-gray-400">Visité en mars 2025</p>
                                </div>
                            </li>
                            <li class="splide__slide p-4">
                                <div class="testimonial-card bg-white p-6 md:p-8 rounded-xl shadow-lg relative">
                                    <div class="text-restaurant-gold text-5xl absolute -top-6 left-6 opacity-20">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                    <div class="flex items-center mb-4">
                                        <div class="w-14 h-14 rounded-full overflow-hidden mr-4">
                                            <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                                alt="Pierre M." class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="font-serif font-bold text-lg">Pierre M.</h4>
                                            <div class="flex text-restaurant-gold text-sm">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 italic mb-4">
                                        "En tant que critique culinaire, je suis impressionné par l'audace et la
                                        créativité du Chef Sall.
                                        Sa réinterprétation des plats traditionnels sénégalais est brillante. Un
                                        établissement qui mérite amplement sa réputation grandissante."
                                    </p>
                                    <p class="text-xs text-gray-400">Visité en février 2025</p>
                                </div>
                            </li>
                            <li class="splide__slide p-4">
                                <div class="testimonial-card bg-white p-6 md:p-8 rounded-xl shadow-lg relative">
                                    <div class="text-restaurant-gold text-5xl absolute -top-6 left-6 opacity-20">
                                        <i class="fas fa-quote-left"></i>
                                    </div>
                                    <div class="flex items-center mb-4">
                                        <div class="w-14 h-14 rounded-full overflow-hidden mr-4">
                                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80"
                                                alt="Fatou N." class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <h4 class="font-serif font-bold text-lg">Fatou N.</h4>
                                            <div class="flex text-restaurant-gold text-sm">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-gray-600 italic mb-4">
                                        "Le Bon Goût est devenu notre restaurant favori pour les occasions spéciales.
                                        L'attention portée aux détails, tant dans l'assiette que dans le service,
                                        est remarquable. Les accords mets-vins sont toujours parfaits. Une adresse à ne
                                        surtout pas manquer!"
                                    </p>
                                    <p class="text-xs text-gray-400">Visité en avril 2025</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <footer class="bg-restaurant-dark text-white pt-16 pb-8">
            <!-- Contenu du footer inchangé -->

            <div class="pt-8 mt-8 border-t border-gray-800 text-center text-gray-500 text-sm">
                <p>&copy; {{ date('Y') }} Le Bon Goût - Restaurant Gastronomique. Tous droits réservés.</p>
            </div>
        </footer>

        <!-- Modal d'image galerie -->
        <div id="gallery-modal" class="fixed inset-0 z-50 hidden">
            <div class="absolute inset-0 bg-black/90"></div>
            <div class="absolute inset-0 flex items-center justify-center p-4">
                <div class="relative max-w-4xl w-full">
                    <button id="close-gallery" class="absolute -top-12 right-0 text-white hover:text-restaurant-gold">
                        <i class="fas fa-times text-2xl"></i>
                    </button>
                    <img id="gallery-modal-img" src="" alt="Gallery image" class="w-full h-auto">
                    <div class="absolute left-0 top-1/2 -translate-y-1/2">
                        <button id="gallery-prev"
                            class="bg-black/50 hover:bg-restaurant-gold w-10 h-10 rounded-full flex items-center justify-center text-white transition-colors">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                    </div>
                    <div class="absolute right-0 top-1/2 -translate-y-1/2">
                        <button id="gallery-next"
                            class="bg-black/50 hover:bg-restaurant-gold w-10 h-10 rounded-full flex items-center justify-center text-white transition-colors">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bouton retour en haut -->
        <button id="back-to-top"
            class="fixed bottom-6 left-6 z-40 w-12 h-12 rounded-full bg-restaurant-gold flex items-center justify-center text-restaurant-dark shadow-lg opacity-0 invisible transition-all">
            <i class="fas fa-chevron-up"></i>
        </button>

        <!-- Scripts -->
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/js/splide.min.js"></script>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
        <script>
            // Initialisation AOS (Animate on Scroll)
            AOS.init({
                duration: 800,
                once: true
            });

            // Initialisation du slider témoignages
            document.addEventListener('DOMContentLoaded', function () {
                new Splide('#testimonials-slider', {
                    perPage: 3,
                    perMove: 1,
                    gap: '1rem',
                    breakpoints: {
                        1024: {
                            perPage: 2,
                        },
                        640: {
                            perPage: 1,
                        },
                    },
                    pagination: true,
                    arrows: true,
                    autoplay: true,
                    interval: 5000,
                }).mount();

                // Initialisation du slider galerie
                new Splide('#gallery-slider', {
                    perPage: 3,
                    perMove: 1,
                    gap: '1rem',
                    breakpoints: {
                        1024: {
                            perPage: 2,
                        },
                        640: {
                            perPage: 1,
                        },
                    },
                    pagination: true,
                    arrows: true,
                }).mount();

                // Initialisation de la carte
                var map = L.map('map').setView([14.6937, -17.4441], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(map);

                var restaurantIcon = L.icon({
                    iconUrl: 'images/map-marker.png',
                    iconSize: [40, 40],
                    iconAnchor: [20, 40],
                    popupAnchor: [0, -40]
                });

                L.marker([14.6937, -17.4441], { icon: restaurantIcon }).addTo(map)
                    .bindPopup("<b>Le Bon Goût</b><br>42 Avenue de la République");
            });

            // Animation des compteurs
            const counterObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counters = document.querySelectorAll('.counter-value');
                        counters.forEach(counter => {
                            const target = parseInt(counter.getAttribute('data-count'));
                            let count = 0;
                            const updateCounter = () => {
                                const increment = target / 50;
                                if (count < target) {
                                    count += increment;
                                    counter.innerText = Math.ceil(count);
                                    setTimeout(updateCounter, 20);
                                } else {
                                    counter.innerText = target;
                                }
                            };
                            updateCounter();
                        });
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.5 });

            document.querySelectorAll('.counter-value').forEach(counter => {
                counterObserver.observe(counter.parentElement.parentElement);
            });

            // Filtres de menu
            document.querySelectorAll('.menu-filter-btn').forEach(button => {
                button.addEventListener('click', function () {
                    // Retirer la classe active de tous les boutons
                    document.querySelectorAll('.menu-filter-btn').forEach(btn => {
                        btn.classList.remove('active', 'bg-restaurant-gold', 'text-restaurant-dark');
                        btn.classList.add('hover:bg-restaurant-gold/20');
                    });

                    // Ajouter la classe active au bouton cliqué
                    this.classList.add('active', 'bg-restaurant-gold', 'text-restaurant-dark');
                    this.classList.remove('hover:bg-restaurant-gold/20');

                    const filter = this.getAttribute('data-filter');

                    // Filtrer les éléments du menu
                    document.querySelectorAll('.menu-item').forEach(item => {
                        if (filter === 'all' || item.getAttribute('data-category') === filter) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });

            // Galerie modal
            function openGalleryModal(el) {
                const modal = document.getElementById('gallery-modal');
                const modalImg = document.getElementById('gallery-modal-img');
                const img = el.querySelector('img');
                modalImg.src = img.src;
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            document.getElementById('close-gallery').addEventListener('click', function () {
                document.getElementById('gallery-modal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            });

            // Panier
            document.getElementById('cart-widget').addEventListener('click', function () {
                document.getElementById('cart-modal').classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            });

            document.getElementById('close-cart').addEventListener('click', function () {
                document.getElementById('cart-modal').classList.add('hidden');
                document.body.style.overflow = 'auto';
            });

            // Bouton retour en haut
            window.addEventListener('scroll', function () {
                const backToTop = document.getElementById('back-to-top');
                if (window.scrollY > 300) {
                    backToTop.classList.remove('opacity-0', 'invisible');
                    backToTop.classList.add('opacity-100', 'visible');
                } else {
                    backToTop.classList.add('opacity-0', 'invisible');
                    backToTop.classList.remove('opacity-100', 'visible');
                }
            });

            document.getElementById('back-to-top').addEventListener('click', function () {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        </script>
</body>

</html>