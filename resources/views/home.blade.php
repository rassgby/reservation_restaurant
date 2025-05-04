<?php
// Démarrage de la session
session_start();

// Vérifier si l'utilisateur est connecté, sinon rediriger vers la page de connexion

// Configuration de la connexion à la base de données
$host = 'localhost';
$dbname = 'laravel';
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
        $reservation_message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">Veuillez choisir une date future pour votre réservation.</div>';
    } else {
        // Vérifier la disponibilité
        if (checkAvailability($db, $date, $time, $guests)) {
            try {
                $stmt = $db->prepare("INSERT INTO reservations (user_id, reservation_date, reservation_time, number_of_guests, special_requests, status, created_at)
                                     VALUES (:user_id, :date, :time, :guests, :requests, 'confirmed', NOW())");
                $stmt->execute([
                    'user_id' => $_SESSION['user_id'],
                    'date' => $date,
                    'time' => $time,
                    'guests' => $guests,
                    'requests' => $special_requests
                ]);

                $reservation_message = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">Votre réservation a été confirmée avec succès !</div>';
            } catch (PDOException $e) {
                $reservation_message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">Erreur lors de la réservation: ' . $e->getMessage() . '</div>';
            }
        } else {
            $reservation_message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">Désolé, nous n\'avons pas de disponibilité pour ' . $guests . ' personnes à cette date et heure. Veuillez essayer un autre créneau.</div>';
        }
    }
}

// Récupération de l'historique des réservations
// $stmt = $db->prepare("SELECT * FROM reservations WHERE user_id = :user_id ORDER BY reservation_date DESC, reservation_time DESC");
// $stmt->execute(['user_id' => $_SESSION['user_id']]);
// $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Annulation d'une réservation
if (isset($_GET['cancel_reservation']) && !empty($_GET['cancel_reservation'])) {
    $reservation_id = $_GET['cancel_reservation'];

    // Vérifier que la réservation appartient à l'utilisateur
    $stmt = $db->prepare("SELECT * FROM reservations WHERE id = :id AND user_id = :user_id");
    $stmt->execute(['id' => $reservation_id, 'user_id' => $_SESSION['user_id']]);
    $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($reservation) {
        // Vérifier que la réservation est dans le futur
        $reservation_date = new DateTime($reservation['reservation_date'] . ' ' . $reservation['reservation_time']);
        $now = new DateTime();

        // Calculer la différence en heures
        $diff = $now->diff($reservation_date);
        $hours = $diff->h + ($diff->days * 24);

        // On peut annuler seulement si c'est au moins 24h à l'avance
        if ($reservation_date > $now && $hours >= 24) {
            $stmt = $db->prepare("UPDATE reservations SET status = 'cancelled' WHERE id = :id");
            $stmt->execute(['id' => $reservation_id]);
            $reservation_message = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">Votre réservation a été annulée avec succès.</div>';
        } else {
            $reservation_message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">Les réservations ne peuvent être annulées que 24 heures à l\'avance.</div>';
        }
    } else {
        $reservation_message = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">Réservation non trouvée ou non autorisée.</div>';
    }

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
        $availability_result = '<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
            <p class="font-bold">Disponible!</p>
            <p>Nous avons de la place pour ' . $guests . ' personnes le ' . date('d/m/Y', strtotime($date)) . ' à ' . $time . '.</p>
            <a href="#reservation" class="mt-2 inline-block px-4 py-2 bg-restaurant-gold text-white rounded hover:bg-opacity-90 transition">Réserver maintenant</a>
        </div>';
    } else {
        $availability_result = '<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
            <p class="font-bold">Désolé!</p>
            <p>Nous n\'avons pas de disponibilité pour ' . $guests . ' personnes le ' . date('d/m/Y', strtotime($date)) . ' à ' . $time . '.</p>
            <p class="mt-2">Veuillez essayer un autre créneau ou contacter directement le restaurant.</p>
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

        .btn-gold:hover {
            color: white;
        }
    </style>
</head>

<body class="bg-gray-100 text-restaurant-dark font-sans">
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
                    <div class="flex flex-col items-center">
                        <i class="fas fa-user-circle mb-1"></i>
                        <span class="text-restaurant-gold">Rassoul</span>
                    </div>
                    <a href="?logout=1"
                        class="flex flex-col items-center hover:text-restaurant-gold transition-colors duration-300">
                        <i class="fas fa-sign-out-alt mb-1"></i>
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
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-3">
                    <div class="py-2 px-3 flex items-center space-x-2">
                        <i class="fas fa-user-circle"></i>
                        <span class="text-restaurant-gold">Rassoul</span>
                    </div>
                    <a href="?logout=1"
                        class="hover:text-restaurant-gold transition-colors duration-300 py-2 px-3 flex items-center space-x-2">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Déconnexion</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Bannière de bienvenue -->
    <header class="bg-restaurant-dark text-white py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-5xl mx-auto">
                <h2 class="text-3xl md:text-4xl font-serif font-bold">Bienvenue, Rassoul
                </h2>
                <p class="mt-2 text-restaurant-gold font-script text-lg">Gérez vos réservations et explorez nos services
                </p>
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
            <div class="mb-8 border-b border-gray-200">
                <div class="flex flex-wrap -mb-px">
                    <button id="tab-reservation"
                        class="tab-button text-restaurant-gold border-restaurant-gold inline-block p-4 border-b-2 font-medium">
                        <i class="fas fa-calendar-plus mr-2"></i>Réserver une table
                    </button>
                    <button id="tab-availability"
                        class="tab-button text-gray-500 hover:text-restaurant-gold inline-block p-4 border-b-2 border-transparent hover:border-restaurant-gold/50 font-medium">
                        <i class="fas fa-search mr-2"></i>Vérifier les disponibilités
                    </button>
                    <button id="tab-history"
                        class="tab-button text-gray-500 hover:text-restaurant-gold inline-block p-4 border-b-2 border-transparent hover:border-restaurant-gold/50 font-medium">
                        <i class="fas fa-history mr-2"></i>Historique des réservations
                    </button>
                </div>
            </div>

            <!-- Section Réservation -->
            <div id="content-reservation" class="tab-content active">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-2xl font-serif font-bold mb-6">Réserver une table</h3>

                    <form method="POST" action="" id="reservation">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2"
                                    for="reservation_date">Date</label>
                                <input type="date" id="reservation_date" name="reservation_date"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold"
                                    min="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2"
                                    for="reservation_time">Heure</label>
                                <select id="reservation_time" name="reservation_time"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold"
                                    required>
                                    <option value="">Sélectionnez une heure</option>
                                    <optgroup label="Déjeuner">
                                        <option value="12:00">12:00</option>
                                        <option value="12:30">12:30</option>
                                        <option value="13:00">13:00</option>
                                        <option value="13:30">13:30</option>
                                        <option value="14:00">14:00</option>
                                    </optgroup>
                                    <optgroup label="Dîner">
                                        <option value="19:00">19:00</option>
                                        <option value="19:30">19:30</option>
                                        <option value="20:00">20:00</option>
                                        <option value="20:30">20:30</option>
                                        <option value="21:00">21:00</option>
                                        <option value="21:30">21:30</option>
                                    </optgroup>
                                </select>
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="guests">Nombre de
                                personnes</label>
                            <select id="guests" name="guests"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold"
                                required>
                                <option value="">Sélectionnez le nombre de personnes</option>
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?= $i ?>"><?= $i ?> <?= $i > 1 ? 'personnes' : 'personne' ?></option>
                                <?php endfor; ?>
                                <option value="11">Plus de 10 personnes (nous contacter)</option>
                            </select>
                        </div>

                        <div class="mb-6">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="special_requests">Demandes
                                spéciales (optionnel)</label>
                            <textarea id="special_requests" name="special_requests" rows="3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold"
                                placeholder="Allergies, occasion spéciale, préférences..."></textarea>
                        </div>

                        <button type="submit" name="reserve"
                            class="px-8 py-3 bg-restaurant-gold text-restaurant-dark rounded-full font-bold btn-gold hover:text-white transition">
                            Confirmer la réservation
                        </button>
                    </form>

                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <h4 class="text-lg font-semibold mb-3">Politique de réservation</h4>
                        <ul class="text-gray-600 space-y-2">
                            <li><i class="fas fa-check text-green-500 mr-2"></i>Annulation gratuite jusqu'à 24 heures
                                avant la réservation</li>
                            <li><i class="fas fa-info-circle text-blue-500 mr-2"></i>Retard de plus de 15 minutes : nous
                                pouvons être amenés à libérer votre table</li>
                            <li><i class="fas fa-users text-restaurant-gold mr-2"></i>Pour les groupes de plus de 10
                                personnes, veuillez nous contacter directement</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Section Vérifier les disponibilités -->
            <div id="content-availability" class="tab-content">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-2xl font-serif font-bold mb-6">Vérifier les disponibilités</h3>

                    <form method="POST" action="" id="availability-form">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="check_date">Date</label>
                                <input type="date" id="check_date" name="check_date"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold"
                                    min="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="check_time">Heure</label>
                                <select id="check_time" name="check_time"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold"
                                    required>
                                    <option value="">Sélectionnez une heure</option>
                                    <optgroup label="Déjeuner">
                                        <option value="12:00">12:00</option>
                                        <option value="12:30">12:30</option>
                                        <option value="13:00">13:00</option>
                                        <option value="13:30">13:30</option>
                                        <option value="14:00">14:00</option>
                                    </optgroup>
                                    <optgroup label="Dîner">
                                        <option value="19:00">19:00</option>
                                        <option value="19:30">19:30</option>
                                        <option value="20:00">20:00</option>
                                        <option value="20:30">20:30</option>
                                        <option value="21:00">21:00</option>
                                        <option value="21:30">21:30</option>
                                    </optgroup>
                                </select>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="check_guests">Nombre de
                                    personnes</label>
                                <select id="check_guests" name="check_guests"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-restaurant-gold"
                                    required>
                                    <option value="">Sélectionnez le nombre</option>
                                    <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?> <?= $i > 1 ? 'personnes' : 'personne' ?>
                                    </option>
                                    <?php endfor; ?>
                                    <option value="11">Plus de 10 personnes</option>
                                </select>
                            </div>
                        </div>

                        <button type="submit" name="check_availability"
                            class="px-8 py-3 bg-restaurant-gold text-restaurant-dark rounded-full font-bold btn-gold hover:text-white transition">
                            Vérifier la disponibilité
                        </button>
                    </form>

                    <?php if (!empty($availability_result)): ?>
                    <div class="mt-6">
                        <h4 class="text-lg font-semibold mb-3">Résultat de la recherche</h4>
                        <?= $availability_result ?>
                    </div>
                    <?php endif; ?>

                    <div class="mt-8 bg-gray-50 p-6 rounded-lg">
                        <h4 class="text-lg font-semibold mb-4">Disponibilités habituelles</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h5 class="font-semibold mb-2">Déjeuner</h5>
                                <p class="text-gray-600">Du Lundi au Samedi<br>12h00 - 14h30</p>
                                <p class="mt-3 text-sm text-gray-500">Dernière commande en cuisine à 14h00</p>
                            </div>
                            <div>
                                <h5 class="font-semibold mb-2">Dîner</h5>
                                <p class="text-gray-600">Du Lundi au Samedi<br>19h00 - 22h30</p>
                                <p class="mt-3 text-sm text-gray-500">Dernière commande en cuisine à 22h00</p>
                            </div>
                        </div>
                        <div class="mt-4 text-restaurant-dark">
                            <p><i class="fas fa-info-circle text-restaurant-gold mr-2"></i>Le restaurant est fermé le
                                dimanche et les jours fériés.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section Historique -->
            <div id="content-history" class="tab-content">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h3 class="text-2xl font-serif font-bold mb-6">Historique de vos réservations</h3>

                    <?php if (empty($reservations)): ?>
                    <div class="bg-gray-50 p-6 text-center rounded-lg">
                        <i class="fas fa-calendar-xmark text-gray-400 text-4xl mb-3"></i>
                        <p class="text-gray-600">Vous n'avez pas encore effectué de réservation.</p>
                        <a href="#" id="history-make-reservation"
                            class="mt-4 inline-block px-6 py-2 bg-restaurant-gold text-restaurant-dark rounded-full btn-gold hover:text-white transition">
                            Faire une première réservation
                        </a>
                    </div>
                    <?php else: ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Date</th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Heure</th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Personnes</th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Demandes</th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Statut</th>
                                    <th
                                        class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php    foreach ($reservations as $reservation): ?>
                                <?php
                                            // Déterminer si la réservation est future ou passée
        $reservation_datetime = new DateTime($reservation['reservation_date'] . ' ' . $reservation['reservation_time']);
        $now = new DateTime();
        $is_future = $reservation_datetime > $now;

        // Calculer la différence en heures pour vérifier si on peut annuler (24h à l'avance)
        $diff = $now->diff($reservation_datetime);
        $hours = $diff->h + ($diff->days * 24);
        $can_cancel = $is_future && $hours >= 24 && $reservation['status'] != 'cancelled';

        // Définir la classe de la ligne en fonction du statut
        $row_class = '';
        switch ($reservation['status']) {
            case 'confirmed':
                $row_class = $is_future ? 'bg-green-50' : '';
                break;
            case 'cancelled':
                $row_class = 'bg-gray-50 text-gray-500';
                break;
            case 'completed':
                $row_class = 'bg-blue-50';
                break;
        }

        // Traduire le statut en français
        $status_text = '';
        $status_class = '';
        switch ($reservation['status']) {
            case 'confirmed':
                $status_text = 'Confirmée';
                $status_class = 'bg-green-100 text-green-800';
                break;
            case 'cancelled':
                $status_text = 'Annulée';
                $status_class = 'bg-red-100 text-red-800';
                break;
            case 'completed':
                $status_text = 'Terminée';
                $status_class = 'bg-blue-100 text-blue-800';
                break;
            default:
                $status_text = 'Inconnue';
                $status_class = 'bg-gray-100 text-gray-800';
        }
                                        ?>
                                <tr class="<?= $row_class ?>">
                                    <td class="py-4 px-4">
                                        <?= date('d/m/Y', strtotime($reservation['reservation_date'])) ?>
                                        <?php        if ($is_future && $reservation['status'] == 'confirmed'): ?>
                                        <span class="ml-2 text-xs text-green-600">(À venir)</span>
                                        <?php        endif; ?>
                                    </td>
                                    <td class="py-4 px-4"><?= $reservation['reservation_time'] ?></td>
                                    <td class="py-4 px-4"><?= $reservation['number_of_guests'] ?>
                                        <?= $reservation['number_of_guests'] > 1 ? 'personnes' : 'personne' ?></td>
                                    <td class="py-4 px-4 max-w-xs truncate">
                                        <?= !empty($reservation['special_requests']) ? htmlspecialchars($reservation['special_requests']) : '<span class="text-gray-400">Aucune</span>' ?>
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="px-2 py-1 text-xs font-medium rounded-full <?= $status_class ?>">
                                            <?= $status_text ?>
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <?php        if ($can_cancel): ?>
                                        <a href="?cancel_reservation=<?= $reservation['id'] ?>"
                                            class="text-red-600 hover:text-red-800 mr-3"
                                            onclick="return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');">
                                            <i class="fas fa-times-circle"></i> Annuler
                                        </a>
                                        <?php        elseif ($is_future && $reservation['status'] == 'confirmed'): ?>
                                        <span class="text-gray-500 text-sm italic">
                                            <i class="fas fa-clock"></i> Annulation impossible
                                        </span>
                                        <?php        endif; ?>
                                    </td>
                                </tr>
                                <?php    endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 bg-gray-50 p-4 rounded-lg text-sm">
                        <h4 class="font-semibold mb-2">À noter :</h4>
                        <ul class="text-gray-600 space-y-1">
                            <li><i class="fas fa-info-circle text-blue-500 mr-2"></i> Les réservations ne peuvent être
                                annulées que 24 heures à l'avance.</li>
                            <li><i class="fas fa-calendar-check text-green-500 mr-2"></i> Les réservations passées sont
                                automatiquement marquées comme terminées.</li>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>

    <!-- Pied de page -->
    <footer class="bg-restaurant-dark text-white py-8 mt-10">
        <div class="container mx-auto px-4">
            <div class="mt-8 pt-6 border-t border-gray-700 text-center text-gray-400 text-sm">
                <p>&copy; <?= date('Y') ?> Le Bon Goût. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // Navigation mobile
        document.getElementById('mobile-menu-button').addEventListener('click', function () {
            const mobileMenu = document.getElementById('mobile-menu');
            mobileMenu.classList.toggle('hidden');
        });

        // Gestion des onglets
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Supprimer la classe active de tous les boutons et contenus
                tabButtons.forEach(btn => {
                    btn.classList.remove('text-restaurant-gold', 'border-restaurant-gold');
                    btn.classList.add('text-gray-500', 'border-transparent');
                });
                tabContents.forEach(content => {
                    content.classList.remove('active');
                });

                // Ajouter la classe active au bouton cliqué
                button.classList.add('text-restaurant-gold', 'border-restaurant-gold');
                button.classList.remove('text-gray-500', 'border-transparent');

                // Afficher le contenu correspondant
                const tabId = button.id.replace('tab-', '');
                document.getElementById('content-' + tabId).classList.add('active');
            });
        });

        // Lien de l'historique vers la réservation
        document.getElementById('history-make-reservation')?.addEventListener('click', function (e) {
            e.preventDefault();
            document.getElementById('tab-reservation').click();
        });

        // Vérification de la date de réservation (empêcher dates passées)
        const dateInputs = document.querySelectorAll('input[type="date"]');
        const today = new Date().toISOString().split('T')[0];

        dateInputs.forEach(input => {
            input.setAttribute('min', today);
        });

        // Animation des boutons dorés
        document.querySelectorAll('.btn-gold').forEach(button => {
            button.addEventListener('mouseenter', function () {
                this.style.color = 'white';
            });

            button.addEventListener('mouseleave', function () {
                this.style.color = '#2C2C2C';
            });
        });
    </script>
</body>

</html>
