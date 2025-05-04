{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title','Le Bon Goût')</title>
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
            'serif': ['Playfair Display','serif'],
            'sans': ['Montserrat','sans-serif'],
          }
        }
      }
    }
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&
    family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap"
    rel="stylesheet">
</head>
<body class="bg-restaurant-light font-sans text-restaurant-dark min-h-screen flex flex-col">

  {{-- Barre de navigation publique --}}
  <nav class="bg-restaurant-dark text-white sticky top-0 z-50 shadow-lg">
    <div class="container mx-auto px-4 py-3 flex items-center">
      <div class="flex items-center space-x-3">
        <div class="text-restaurant-gold text-3xl">
          <i class="fas fa-utensils"></i>
        </div>
        <div>
          <h1 class="text-2xl font-serif font-bold">Le Bon Goût</h1>
          <p class="text-xs text-restaurant-gold italic">Restaurant Gastronomique</p>
        </div>
      </div>
    </div>
  </nav>

  {{-- Contenu central --}}
  <main class="flex-grow flex items-center justify-center py-10">
    @yield('content')
  </main>

  {{-- Footer simplifié --}}
  <footer class="bg-restaurant-dark text-white py-6">
    <div class="container mx-auto px-4 text-center text-sm">
      &copy; {{ date('Y') }} Le Bon Goût – Restaurant Gastronomique. Tous droits réservés.
    </div>
  </footer>

  {{-- Font Awesome pour l’icône --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
