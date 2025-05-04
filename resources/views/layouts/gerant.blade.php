<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Gérant')</title>
    <!-- Inclusion de Tailwind CSS via CDN -->
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    @yield('styles')
</head>
<body class="bg-restaurant-light text-restaurant-dark font-sans">
    <!-- Navigation du gérant -->
    <nav class="bg-restaurant-dark text-white sticky top-0 z-50 shadow-xl">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap items-center justify-between py-3">
                <div class="flex items-center space-x-3">
                    <div class="text-restaurant-gold text-3xl">
                        <i class="fas fa-utensils"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-serif font-bold">Le Bon Goût</h1>
                        <p class="text-xs text-restaurant-gold">Dashboard Gérant</p>
                    </div>
                </div>
                <!-- Liens de navigation pour le gérant -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('gerant.dashboard') }}" class="hover:text-restaurant-gold transition-colors duration-300">
                        Dashboard
                    </a>
                    <a href="{{ route('gerant.reservations.index') }}" class="hover:text-restaurant-gold transition-colors duration-300">
                        Réservations
                    </a>
                    <a href="{{ route('gerant.disponibilites.index') }}" class="hover:text-restaurant-gold transition-colors duration-300">
                        Disponibilités
                    </a>
                    <a href="{{ route('gerant.menus.index') }}" class="hover:text-restaurant-gold transition-colors duration-300">
                        Menus
                    </a>
                    <!-- Lien vers la page de profil -->
                    <a href="{{ route('profile.edit') }}" class="flex flex-col items-center hover:text-restaurant-gold transition-colors duration-300">
                        <i class="fas fa-user-circle mb-1"></i>
                        <span class="text-restaurant-gold">{{ Auth::user()->name }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex flex-col items-center hover:text-restaurant-gold transition-colors duration-300">
                            <i class="fas fa-sign-out-alt mb-1"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                </div>
                <!-- Bouton menu mobile -->
                <div class="md:hidden">
                    <button id="mobile-menu-button" class="text-white focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden pb-4">
                <div class="flex flex-col space-y-3">
                    <a href="{{ route('gerant.dashboard') }}" class="py-2 px-3 hover:text-restaurant-gold">Dashboard</a>
                    <a href="{{ route('gerant.reservations.index') }}" class="py-2 px-3 hover:text-restaurant-gold">Réservations</a>
                    <a href="{{ route('gerant.disponibilites.index') }}" class="py-2 px-3 hover:text-restaurant-gold">Disponibilités</a>
                    <a href="{{ route('gerant.menus.index') }}" class="py-2 px-3 hover:text-restaurant-gold">Menus</a>

                    <!-- Lien mobile vers la page de profil -->
                    <a href="{{ route('profile.edit') }}" class="py-2 px-3 flex items-center space-x-2 hover:text-restaurant-gold">
                        <i class="fas fa-user-circle"></i>
                        <span class="text-restaurant-gold">{{ Auth::user()->name }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="py-2 px-3 flex items-center space-x-2 hover:text-restaurant-gold">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenu principal -->
    <main class="py-10">
        @yield('content')
    </main>

    <!-- Pied de page -->
    <footer class="bg-restaurant-dark text-white pt-16 pb-8">
        <div class="container mx-auto px-4">
            <div class="pt-8 mt-8 border-t border-gray-800 text-center text-gray-500 text-sm">
                <p>&copy; {{ date('Y') }} Le Bon Goût - Restaurant Gastronomique. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    @yield('scripts')
    <script>
      document.getElementById('mobile-menu-button').addEventListener('click', function(){
        document.getElementById('mobile-menu').classList.toggle('hidden');
      });
    </script>
</body>
</html>
