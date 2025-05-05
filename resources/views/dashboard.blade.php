<?php
// Démarrage de la session
session_start();

// Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion

// Configuration de la connexion à la base de données
$host = 'localhost';
$dbname = 'laravele';
$username = 'root';
$password = '';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Fonction pour vérifier les disponibilités
function checkAvailability($db, $date, $time, $guests)
{
    // Calculer le nombre total de places réservées pour cette date et heure
    $stmt = $db->prepare("SELECT SUM(number_of_guests) as total_guests FROM reservations
                         WHERE reservation_date = :date AND reservation_time = :time AND status != 'cancelled'");
    $stmt->execute(['date' => $date, 'time' => $time]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    $total_reserved = $result['total_guests'] ? $result['total_guests'] : 0;

    // Supposons que le restaurant a une capacité totale de 50 personnes
    $total_capacity = 50;
    $available_seats = $total_capacity - $total_reserved;

    return $available_seats >= $guests;
}

// Traitement de la réservation
$reservation_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reserve'])) {
    $date = $_POST['reservation_date'];
    $time = $_POST['reservation_time'];
    $guests = $_POST['guests'];
    $special_requests = $_POST['special_requests'];

    // Vérifier si la date est dans le futur
    $reservation_date = new DateTime($date);
    $today = new DateTime();
    $today->setTime(0, 0, 0); // Définir l'heure à minuit

    if ($reservation_date < $today) {
        $reservation_message = '<div class="animate-fade-in bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-r shadow-md">Veuillez choisir une date future pour votre réservation.</div>';
    } else {
        // Vérifier la disponibilité
        if (checkAvailability($db, $date, $time, $guests)) {
            try {
                $stmt = $db->prepare("INSERT INTO reservations (user_id, reservation_date, reservation_time, number_of_guests, special_requests, status, created_at)
                                     VALUES (:user_id, :date, :time, :guests, :requests, 'confirmed', NOW())");
                $stmt->execute([
                    'user_id' => $_SESSION['user_id'] ?? 1, // Valeur par défaut pour test
                    'date' => $date,
                    'time' => $time,
                    'guests' => $guests,
                    'requests' => $special_requests
                ]);

                $reservation_message = '<div class="animate-fade-in bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-r shadow-md flex items-start">
                    <div class="flex-shrink-0 mr-3">
                        <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-semibold">Votre réservation a été confirmée avec succès !</p>
                        <p class="text-sm mt-1">Un email de confirmation a été envoyé à votre adresse.</p>
                    </div>
                </div>';
            } catch (PDOException $e) {
                $reservation_message = '<div class="animate-fade-in bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-r shadow-md">Erreur lors de la réservation: ' . $e->getMessage() . '</div>';
            }
        } else {
            $reservation_message = '<div class="animate-fade-in bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-r shadow-md flex items-start">
                <div class="flex-shrink-0 mr-3">
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <p class="font-semibold">Nous n\'avons pas de disponibilité pour ' . $guests . ' personnes à cette date et heure.</p>
                    <p class="text-sm mt-1">Veuillez essayer un autre créneau ou nous contacter directement.</p>
                </div>
            </div>';
        }
    }
}

// Pour simuler des données d'historique
$reservations = [
    [
        'id' => 1,
        'reservation_date' => date('Y-m-d', strtotime('+2 days')),
        'reservation_time' => '19:30',
        'number_of_guests' => 2,
        'special_requests' => 'Table près de la fenêtre si possible',
        'status' => 'confirmed',
        'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
    ],
    [
        'id' => 2,
        'reservation_date' => date('Y-m-d', strtotime('-5 days')),
        'reservation_time' => '12:30',
        'number_of_guests' => 4,
        'special_requests' => 'Anniversaire de mariage',
        'status' => 'completed',
        'created_at' => date('Y-m-d H:i:s', strtotime('-10 days'))
    ],
    [
        'id' => 3,
        'reservation_date' => date('Y-m-d', strtotime('-2 days')),
        'reservation_time' => '20:00',
        'number_of_guests' => 1,
        'special_requests' => '',
        'status' => 'cancelled',
        'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
    ]
];

// Annulation d'une réservation
if (isset($_GET['cancel_reservation']) && !empty($_GET['cancel_reservation'])) {
    $reservation_id = $_GET['cancel_reservation'];

    // Logique pour annuler la réservation...
    // (Code simplifié pour l'exemple)

    $reservation_message = '<div class="animate-fade-in bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-4 rounded-r shadow-md flex items-start">
        <div class="flex-shrink-0 mr-3">
            <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="font-semibold">Votre réservation a été annulée avec succès.</p>
            <p class="text-sm mt-1">Vous pouvez effectuer une nouvelle réservation à tout moment.</p>
        </div>
    </div>';

    // Redirection pour éviter les soumissions multiples
    header('Location: dashboard.php');
    exit();
}

// Vérification de disponibilité (AJAX)
$availability_result = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_availability'])) {
    $date = $_POST['check_date'];
    $time = $_POST['check_time'];
    $guests = $_POST['check_guests'];

    if (checkAvailability($db, $date, $time, $guests)) {
        $availability_result = '<div class="animate-fade-in bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-r shadow-md">
            <div class="flex items-center">
                <div class="flex-shrink-0 mr-3">
                    <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-lg">Disponible!</p>
                    <p>Nous avons de la place pour ' . $guests . ' personnes le ' . date('d/m/Y', strtotime($date)) . ' à ' . $time . '.</p>
                    <a href="#reservation" class="mt-3 inline-block px-4 py-2 bg-restaurant-gold text-white rounded-lg hover:bg-restaurant-dark transition duration-300 transform hover:scale-105 shadow-md">
                        <span class="flex items-center">
                            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Réserver maintenant
                        </span>
                    </a>
                </div>
            </div>
        </div>';
    } else {
        $availability_result = '<div class="animate-fade-in bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-r shadow-md">
            <div class="flex items-center">
                <div class="flex-shrink-0 mr-3">
                    <svg class="h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-lg">Désolé!</p>
                    <p>Nous n\'avons pas de disponibilité pour ' . $guests . ' personnes le ' . date('d/m/Y', strtotime($date)) . ' à ' . $time . '.</p>
                    <p class="mt-2">Veuillez essayer un autre créneau ou contacter directement le restaurant au <span class="font-semibold">01 23 45 67 89</span>.</p>
                </div>
            </div>
        </div>';
    }
}

// Déconnexion
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Le Bon Goût</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'restaurant-gold': '#D4AF37',
                        'restaurant-gold-light': '#E9D58A',
                        'restaurant-dark': '#1A1A1A',
                        'restaurant-dark-light': '#2C2C2C',
                        'restaurant-light': '#F9F5EB',
                    },
                    fontFamily: {
                        'serif': ['Playfair Display', 'serif'],
                        'sans': ['Montserrat', 'sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-out',
                        'slide-up': 'slideUp 0.5s ease-out',
                        'pulse-slow': 'pulse 3s infinite',
                        'bounce-slow': 'bounce 3s infinite'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(20px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' },
                        }
                    },
                    boxShadow: {
                        'glow': '0 0 15px rgba(212, 175, 55, 0.5)',
                    }
                }
            },
            plugins: [],
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
    <!-- AOS - Animate On Scroll -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <style>
        .font-script {
            font-family: 'Playfair Display', serif;
            font-style: italic;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .btn-gold {
            background-color: #D4AF37;
            position: relative;
            overflow: hidden;
            z-index: 1;
            transition: all 0.3s ease;
        }

        .btn-gold:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: #1A1A1A;
            transition: left 0.3s ease;
            z-index: -1;
        }

        .btn-gold:hover:before {
            left: 0;
        }

        .btn-gold:hover {
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
        }

        input:focus,
        select:focus,
        textarea:focus {
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.3);
            border-color: #D4AF37;
        }

        /* Loading spinner */
        .loader {
            border-top-color: #D4AF37;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: #D4AF37;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #c09c30;
        }

        /* Background pattern */
        .bg-pattern {
            background-color: #f9f9f9;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23d4af37' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        }

        /* Gold gradient text */
        .gold-gradient {
            background: linear-gradient(to right, #D4AF37, #FFDF00, #D4AF37);
            -webkit-background-clip: text;
            color: transparent;
        }

        /* Glass effect */
        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
    </style>
</head>

<body class="bg-pattern text-restaurant-dark font-sans">
    <!-- Barre de navigation -->
    <nav class="bg-restaurant-dark text-white sticky top-0 z-50 shadow-xl">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center justify-between py-3">
                <div class="flex items-center space-x-3">
                    <div class="text-restaurant-gold text-3xl animate-pulse-slow">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-serif font-bold">
                            <span class="text-white">Le </span>
                            <span class="gold-gradient">Bon Goût</span>
                        </h1>
                        <p class="text-xs text-restaurant-gold font-script">Restaurant Gastronomique</p>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <div class="flex items-center space-x-2 bg-restaurant-dark-light py-2 px-3 rounded-full">
                        <i class="fas fa-user-circle text-restaurant-gold"></i>
                        <span class="text-white">Rassoul</span>
                    </div>
                    <a href="?logout=1"
                        class="flex items-center space-x-2 hover:text-restaurant-gold transition-colors duration-300 group">
                        <i class="fas fa-sign-out-alt transform group-hover:rotate-12 transition-transform"></i>
                        <span>Déconnexion</span>
                    </a>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-white focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4 animate-fade-in">
                <div class="flex flex-col space-y-3">
                    <div class="py-2 px-3 flex items-center space-x-2 border-l-2 border-restaurant-gold">
                        <i class="fas fa-user-circle text-restaurant-gold"></i>
                        <span class="text-restaurant-gold">Rassoul</span>
                    </div>
                    <a href="?logout=1"
                        class="hover:text-restaurant-gold transition-colors duration-300 py-2 px-3 flex items-center space-x-2 border-l-2 border-transparent hover:border-restaurant-gold">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Bannière de bienvenue -->
    <header class="bg-restaurant-dark text-white py-12 relative overflow-hidden">
        <div
            class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1414235077428-338989a2e8c0?ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80')] bg-cover bg-center opacity-20">
        </div>
        <div class="container mx-auto px-4 relative">
            <div class="max-w-5xl mx-auto">
                <h2 class="text-3xl md:text-5xl font-serif font-bold" data-aos="fade-right">
                    Bienvenue, <span class="text-restaurant-gold">Rassoul</span>
                </h2>
                <p class="mt-3 text-restaurant-gold font-script text-xl md:text-2xl" data-aos="fade-right"
                    data-aos-delay="100">
                    Gérez vos réservations et explorez nos services
                </p>
                <div class="mt-4 flex space-x-2" data-aos="fade-up" data-aos-delay="200">
                    <span
                        class="inline-flex items-center px-3 py-1 bg-restaurant-gold-light/20 text-restaurant-gold-light rounded-full text-sm">
                        <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                        Ouvert aujourd'hui
                    </span>
                    <span
                        class="inline-flex items-center px-3 py-1 bg-restaurant-gold-light/20 text-restaurant-gold-light rounded-full text-sm">
                        12:00 - 14:30 | 19:00 - 22:30
                    </span>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="container mx-auto px-4 py-10">
        <div class="max-w-5xl mx-auto">
            <?php if (!empty($reservation_message)): ?>
            <?= $reservation_message ?>
            <?php endif; ?>

            <!-- Tabs pour la navigation -->
            <div class="mb-8 border-b border-gray-200 bg-white rounded-t-lg shadow-md p-1 sticky z-10"
                style="top: 70px;">
                <div class="flex flex-wrap">
                    <button id="tab-reservation"
                        class="tab-button text-restaurant-gold border-restaurant-gold inline-block p-4 rounded-t-lg border-b-2 font-medium transition-all duration-300 flex items-center">
                        <i class="fas fa-calendar-plus mr-2"></i>Réserver une table
                    </button>
                    <button id="tab-availability"
                        class="tab-button text-gray-500 hover:text-restaurant-gold inline-block p-4 border-b-2 border-transparent hover:border-restaurant-gold/50 font-medium transition-all duration-300 flex items-center">
                        <i class="fas fa-search mr-2"></i>Vérifier les disponibilités
                    </button>
                    <button id="tab-history"
                        class="tab-button text-gray-500 hover:text-restaurant-gold inline-block p-4 border-b-2 border-transparent hover:border-restaurant-gold/50 font-medium transition-all duration-300 flex items-center">
                        <i class="fas fa-history mr-2"></i>Historique des réservations
                    </button>
                </div>
            </div>

            <!-- Section Réservation -->
            <div id="content-reservation" class="tab-content active animate-fade-in">
                <div class="bg-white rounded-lg shadow-lg p-8 overflow-hidden">
                    <div class="flex items-center mb-6" data-aos="fade-right">
                        <div class="bg-restaurant-gold text-white rounded-full p-2 mr-3">
                            <i class="fas fa-calendar-plus"></i>
                        </div>
                        <h3 class="text-2xl font-serif font-bold">Réserver une table</h3>
                    </div>

                    <form method="POST" action="" id="reservation" class="reservation-form">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div data-aos="fade-up" data-aos-delay="100">
                                <label class="block text-gray-700 text-sm font-bold mb-2"
                                    for="reservation_date">Date</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <input type="date" id="reservation_date" name="reservation_date" required
                                        class="w-full p-2 pl-10 border border-gray-300 rounded-lg focus:outline-none">
                                </div>
                            </div>

                            <div data-aos="fade-up" data-aos-delay="150">
                                <label class="block text-gray-700 text-sm font-bold mb-2"
                                    for="reservation_time">Heure</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <select id="reservation_time" name="reservation_time" required
                                        class="w-full p-2 pl-10 border border-gray-300 rounded-lg focus:outline-none appearance-none">
                                        <option value="">Sélectionner une heure</option>
                                        <option value="12:00">12:00</option>
                                        <option value="12:30">12:30</option>
                                        <option value="13:00">13:00</option>
                                        <option value="13:30">13:30</option>
                                        <option value="14:00">14:00</option>
                                        <option value="19:00">19:00</option>
                                        <option value="19:30">19:30</option>
                                        <option value="20:00">20:00</option>
                                        <option value="20:30">20:30</option>
                                        <option value="21:00">21:00</option>
                                        <option value="21:30">21:30</option>
                                        <option value="22:00">22:00</option>
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div data-aos="fade-up" data-aos-delay="200">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="guests">Nombre de
                                    personnes</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <select id="guests" name="guests" required
                                        class="w-full p-2 pl-10 border border-gray-300 rounded-lg focus:outline-none appearance-none">
                                        <option value="">Sélectionner</option>
                                        <option value="1">1 personne</option>
                                        <option value="2">2 personnes</option>
                                        <option value="3">3 personnes</option>
                                        <option value="4">4 personnes</option>
                                        <option value="5">5 personnes</option>
                                        <option value="6">6 personnes</option>
                                        <option value="7">7 personnes</option>
                                        <option value="8">8 personnes</option>
                                        <option value="9">9 personnes</option>
                                        <option value="10">10 personnes</option>
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>

                            <div data-aos="fade-up" data-aos-delay="250">
                                <label class="block text-gray-700 text-sm font-bold mb-2"
                                    for="special_requests">Demandes spéciales</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                        <i class="fas fa-concierge-bell"></i>
                                    </div>
                                    <textarea id="special_requests" name="special_requests"
                                        class="w-full p-2 pl-10 border border-gray-300 rounded-lg focus:outline-none"
                                        placeholder="Ex: allergie, table près de la fenêtre, etc." rows="1"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                            <button type="submit" name="reserve"
                                class="btn-gold px-6 py-3 rounded-lg text-white font-medium uppercase tracking-wider flex items-center mx-auto">
                                <i class="fas fa-calendar-check mr-2"></i>
                                Confirmer la réservation
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Section Vérification des disponibilités -->
            <div id="content-availability" class="tab-content animate-fade-in">
                <div class="bg-white rounded-lg shadow-lg p-8 overflow-hidden">
                    <div class="flex items-center mb-6" data-aos="fade-right">
                        <div class="bg-restaurant-gold text-white rounded-full p-2 mr-3">
                            <i class="fas fa-search"></i>
                        </div>
                        <h3 class="text-2xl font-serif font-bold">Vérifier les disponibilités</h3>
                    </div>

                    <?php if (!empty($availability_result)): ?>
                    <?= $availability_result ?>
                    <?php endif; ?>

                    <form method="POST" action="" id="check-availability-form">
                        <input type="hidden" name="check_availability" value="1">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div data-aos="fade-up" data-aos-delay="100">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="check_date">Date</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                        <i class="fas fa-calendar"></i>
                                    </div>
                                    <input type="date" id="check_date" name="check_date" required
                                        class="w-full p-2 pl-10 border border-gray-300 rounded-lg focus:outline-none">
                                </div>
                            </div>

                            <div data-aos="fade-up" data-aos-delay="150">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="check_time">Heure</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <select id="check_time" name="check_time" required
                                        class="w-full p-2 pl-10 border border-gray-300 rounded-lg focus:outline-none appearance-none">
                                        <option value="">Sélectionner une heure</option>
                                        <option value="12:00">12:00</option>
                                        <option value="12:30">12:30</option>
                                        <option value="13:00">13:00</option>
                                        <option value="13:30">13:30</option>
                                        <option value="14:00">14:00</option>
                                        <option value="19:00">19:00</option>
                                        <option value="19:30">19:30</option>
                                        <option value="20:00">20:00</option>
                                        <option value="20:30">20:30</option>
                                        <option value="21:00">21:00</option>
                                        <option value="21:30">21:30</option>
                                        <option value="22:00">22:00</option>
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>

                            <div data-aos="fade-up" data-aos-delay="200">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="check_guests">Nombre de
                                    personnes</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-500">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <select id="check_guests" name="check_guests" required
                                        class="w-full p-2 pl-10 border border-gray-300 rounded-lg focus:outline-none appearance-none">
                                        <option value="">Sélectionner</option>
                                        <option value="1">1 personne</option>
                                        <option value="2">2 personnes</option>
                                        <option value="3">3 personnes</option>
                                        <option value="4">4 personnes</option>
                                        <option value="5">5 personnes</option>
                                        <option value="6">6 personnes</option>
                                        <option value="7">7 personnes</option>
                                        <option value="8">8 personnes</option>
                                        <option value="9">9 personnes</option>
                                        <option value="10">10 personnes</option>
                                    </select>
                                    <div
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">
                                        <i class="fas fa-chevron-down"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center" data-aos="fade-up" data-aos-delay="250">
                            <button type="submit"
                                class="bg-restaurant-gold/90 hover:bg-restaurant-gold px-6 py-3 rounded-lg text-white font-medium uppercase tracking-wider flex items-center mx-auto transition duration-300 transform hover:scale-105 shadow-md">
                                <i class="fas fa-search mr-2"></i>
                                Vérifier la disponibilité
                            </button>
                        </div>
                    </form>

                    <div class="mt-8 text-gray-600 p-4 bg-gray-50 rounded-lg border border-gray-200" data-aos="fade-up"
                        data-aos-delay="300">
                        <div class="flex items-start">
                            <div class="text-restaurant-gold text-2xl mr-3">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <div>
                                <h4 class="font-bold mb-2">Informations utiles</h4>
                                <ul class="list-disc list-inside space-y-1 text-sm">
                                    <li>Pour les groupes de plus de 10 personnes, veuillez nous contacter directement au
                                        77 777 77 77 </li>
                                    <li>Les réservations peuvent être annulées sans frais jusqu'à 24h avant l'heure
                                        prévue</li>
                                    <li>En cas de retard de plus de 15 minutes, votre table pourrait être libérée</li>
                                    <li>Pour les événements privés, veuillez nous contacter par email à <a
                                            href="mailto:contact@lebongout.fr"
                                            class="text-restaurant-gold hover:underline">contact@lebongout.sn</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Historique des réservations -->
            <div id="content-history" class="tab-content animate-fade-in">
                <div class="bg-white rounded-lg shadow-lg p-8 overflow-hidden">
                    <div class="flex items-center mb-6" data-aos="fade-right">
                        <div class="bg-restaurant-gold text-white rounded-full p-2 mr-3">
                            <i class="fas fa-history"></i>
                        </div>
                        <h3 class="text-2xl font-serif font-bold">Historique des réservations</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                            <thead class="bg-restaurant-dark text-white uppercase text-xs tracking-wider">
                                <tr>
                                    <th class="py-3 px-4 text-left">Date</th>
                                    <th class="py-3 px-4 text-left">Heure</th>
                                    <th class="py-3 px-4 text-left">Personnes</th>
                                    <th class="py-3 px-4 text-left">Demandes</th>
                                    <th class="py-3 px-4 text-left">Statut</th>
                                    <th class="py-3 px-4 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($reservations as $reservation): ?>
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="py-3 px-4">
                                        <?= date('d/m/Y', strtotime($reservation['reservation_date'])) ?>
                                    </td>
                                    <td class="py-3 px-4"><?= $reservation['reservation_time'] ?></td>
                                    <td class="py-3 px-4"><?= $reservation['number_of_guests'] ?></td>
                                    <td class="py-3 px-4 max-w-xs truncate">
                                        <?= !empty($reservation['special_requests']) ? $reservation['special_requests'] : '<span class="text-gray-400 italic">-</span>' ?>
                                    </td>
                                    <td class="py-3 px-4">
                                        <?php    if ($reservation['status'] == 'confirmed'): ?>
                                        <span
                                            class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Confirmée</span>
                                        <?php    elseif ($reservation['status'] == 'completed'): ?>
                                        <span
                                            class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">Terminée</span>
                                        <?php    elseif ($reservation['status'] == 'cancelled'): ?>
                                        <span
                                            class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Annulée</span>
                                        <?php    endif; ?>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <?php    if ($reservation['status'] == 'confirmed'): ?>
                                        <a href="?cancel_reservation=<?= $reservation['id'] ?>"
                                            class="text-red-500 hover:text-red-700 mr-2"
                                            onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')">
                                            <i class="fas fa-times-circle"></i> Annuler
                                        </a>
                                        <?php    elseif ($reservation['status'] == 'completed'): ?>
                                        <a href="#" class="text-restaurant-gold hover:text-yellow-600">
                                            <i class="fas fa-star"></i> Évaluer
                                        </a>
                                        <?php    else: ?>
                                        <span class="text-gray-400">-</span>
                                        <?php    endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if (empty($reservations)): ?>
                    <div class="text-center py-8">
                        <div class="text-gray-400 text-5xl mb-4">
                            <i class="fas fa-calendar-times"></i>
                        </div>
                        <p class="text-gray-500">Vous n'avez pas encore de réservations</p>
                        <button id="new-reservation-btn"
                            class="mt-4 text-restaurant-gold hover:text-restaurant-gold-dark">
                            <i class="fas fa-plus-circle mr-1"></i> Faire une réservation
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-restaurant-dark text-white mt-10 py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h4 class="text-xl font-serif mb-4">
                        <span class="text-white">Le </span>
                        <span class="text-restaurant-gold">Bon Goût</span>
                    </h4>
                    <p class="text-gray-400 mb-4">Une expérience gastronomique exceptionnelle au cœur de Dakar</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-restaurant-gold"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-restaurant-gold"><i
                                class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-restaurant-gold"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div>
                    <h4 class="text-lg font-medium mb-4">Heures d'ouverture</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Lundi - Vendredi: 12:00 - 14:30 | 19:00 - 22:30</li>
                        <li>Samedi: 19:00 - 23:00</li>
                        <li>Dimanche: Fermé</li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-medium mb-4">Contact</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><i class="fas fa-map-marker-alt w-6 text-restaurant-gold"></i> Rond point Diomaye, boppou keur Sonko</li>
                        <li><i class="fas fa-phone w-6 text-restaurant-gold"></i> 77 777 77 77</li>
                        <li><i class="fas fa-envelope w-6 text-restaurant-gold"></i> contact@lebongout.sn</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-6 text-center text-gray-500 text-sm">
                <p>&copy; <?= date('Y') ?> Le Bon Goût. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        // Initialiser AOS (Animate on Scroll)
        AOS.init({
            duration: 800,
            once: true
        });

        // Gestion des tabs
        document.addEventListener('DOMContentLoaded', function () {
            const tabButtons = document.querySelectorAll('.tab-button');
            const tabContents = document.querySelectorAll('.tab-content');

            tabButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const targetId = button.id.replace('tab-', 'content-');

                    // Réinitialiser tous les tabs
                    tabButtons.forEach(b => {
                        b.classList.remove('text-restaurant-gold', 'border-restaurant-gold');
                        b.classList.add('text-gray-500', 'border-transparent');
                    });

                    tabContents.forEach(content => {
                        content.classList.remove('active');
                    });

                    // Activer le tab sélectionné
                    button.classList.remove('text-gray-500', 'border-transparent');
                    button.classList.add('text-restaurant-gold', 'border-restaurant-gold');

                    document.getElementById(targetId).classList.add('active');

                    // Réinitialiser les animations AOS
                    AOS.refresh();
                });
            });

            // Gestion du menu mobile
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            mobileMenuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });

            // Rediriger vers l'onglet réservation quand on clique sur "Faire une réservation"
            const newReservationBtn = document.getElementById('new-reservation-btn');
            if (newReservationBtn) {
                newReservationBtn.addEventListener('click', () => {
                    document.getElementById('tab-reservation').click();
                });
            }
        });
    </script>
</body>

</html>