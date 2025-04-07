// pages/index.js
'use client';
import { useState, useEffect } from 'react';
import Head from 'next/head';
import Link from 'next/link';

export default function Home() {
  const [date, setDate] = useState('');
  const [time, setTime] = useState('');
  const [guests, setGuests] = useState(2);
  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [phone, setPhone] = useState('');
  const [isModalOpen, setIsModalOpen] = useState(false);
  const [isBookingConfirmed, setIsBookingConfirmed] = useState(false);
  const [scrolled, setScrolled] = useState(false);
  const [mobileMenuOpen, setMobileMenuOpen] = useState(false);

  useEffect(() => {
    const handleScroll = () => {
      if (window.scrollY > 50) {
        setScrolled(true);
      } else {
        setScrolled(false);
      }
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const handleSubmit = (e: { preventDefault: () => void; }) => {
    e.preventDefault();
    // Ici vous implémenteriez la logique pour envoyer les données de réservation à votre backend
    console.log({ date, time, guests, name, email, phone });
    setIsBookingConfirmed(true);
    setTimeout(() => {
      setIsModalOpen(false);
      setIsBookingConfirmed(false);
      // Réinitialiser le formulaire
      setDate('');
      setTime('');
      setGuests(2);
      setName('');
      setEmail('');
      setPhone('');
    }, 2000);
  };

  return (
    <div className="min-h-screen bg-slate-50 font-serif">
      <Head>
  <title>L'Élégance - Restaurant Gastronomique</title>
  <meta name="description" content="Restaurant gastronomique français avec une cuisine raffinée" />
</Head>
{/* Navigation */}
<nav className={`fixed w-full z-50 transition-all duration-300 ${scrolled ? 'bg-zinc-900/95 shadow-lg' : 'bg-transparent'}`}>
  <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div className="flex justify-between h-16 md:h-20">
      <div className="flex items-center">
        <h1 className={`text-xl md:text-2xl font-bold font-sans italic ${scrolled ? 'text-rose-300' : 'text-white'}`}>L'Élégance</h1>
      </div>
      
      {/* Menu pour écrans desktop */}
      <div className="hidden md:flex items-center space-x-6 lg:space-x-8">
        <a href="#menu" className={`${scrolled ? 'text-gray-300' : 'text-white'} hover:text-rose-300 transition-colors text-sm uppercase tracking-widest`}>Menu</a>
        <a href="#about" className={`${scrolled ? 'text-gray-300' : 'text-white'} hover:text-rose-300 transition-colors text-sm uppercase tracking-widest`}>À propos</a>
        <button
          onClick={() => setIsModalOpen(true)}
          className="bg-rose-600 text-white px-4 sm:px-6 py-2 rounded-full hover:bg-rose-700 transition-colors shadow-md shadow-rose-900/20 text-sm uppercase tracking-widest"
        >
          Réserver
        </button>
      </div>
      
      {/* Bouton de menu mobile */}
      <div className="flex items-center md:hidden">
        <button
          onClick={() => setMobileMenuOpen(!mobileMenuOpen)}
          className={`${scrolled ? 'text-gray-300' : 'text-white'} p-2`}
          aria-expanded="false"
        >
          <span className="sr-only">Ouvrir le menu</span>
          {!mobileMenuOpen ? (
            <svg className="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          ) : (
            <svg className="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
            </svg>
          )}
        </button>
      </div>
    </div>
  </div>
  
  {/* Menu mobile */}
  {mobileMenuOpen && (
    <div className="md:hidden bg-zinc-900/95 shadow-lg">
      <div className="px-4 pt-2 pb-4 space-y-2">
        <a 
          href="#menu" 
          className="block text-gray-300 hover:text-rose-300 py-2 text-sm uppercase tracking-widest"
          onClick={() => setMobileMenuOpen(false)}
        >
          Menu
        </a>
        <a 
          href="#about" 
          className="block text-gray-300 hover:text-rose-300 py-2 text-sm uppercase tracking-widest"
          onClick={() => setMobileMenuOpen(false)}
        >
          À propos
        </a>
        <button
          onClick={() => {
            setMobileMenuOpen(false);
            setIsModalOpen(true);
          }}
          className="w-full mt-2 bg-rose-600 text-white px-6 py-2 rounded-full hover:bg-rose-700 transition-colors shadow-md shadow-rose-900/20 text-sm uppercase tracking-widest"
        >
          Réserver
        </button>
      </div>
    </div>
  )}
</nav>

      {/* Hero Section */}
      <div className="relative h-screen bg-cover bg-center" style={{ backgroundImage: `url('/api/placeholder/1200/800')` }}>
        <div className="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
          <div className="text-center text-white p-4 max-w-3xl mx-auto">
            <p className="text-rose-300 mb-2 italic text-lg">Bienvenue à</p>
            <h2 className="text-6xl font-bold mb-6 font-serif">L'Élégance</h2>
            <div className="h-0.5 w-24 bg-rose-400 mx-auto mb-6"></div>
            <p className="text-xl mb-8 text-gray-100 font-light">Une expérience culinaire exceptionnelle au cœur de Paris, où la tradition française rencontre l'innovation gastronomique</p>
            <button
              onClick={() => setIsModalOpen(true)}
              className="bg-rose-600 text-white px-8 py-4 rounded-full hover:bg-rose-700 transition-colors shadow-lg hover:shadow-xl shadow-rose-800/30 hover:shadow-rose-800/40 transform hover:-translate-y-1 uppercase tracking-widest"
            >
              Réserver une table
            </button>
          </div>
        </div>
      </div>

      {/* Menu Section */}
      <section id="menu" className="py-24 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 className="text-4xl font-bold text-center mb-4 text-zinc-800">Notre Menu</h2>
        <p className="text-center text-gray-500 mb-16 max-w-2xl mx-auto">Découvrez notre sélection de plats saisonniers, préparés avec des ingrédients locaux et bio par notre chef étoilé.</p>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-10">
          {/* Entrées */}
          <div className="group">
            <div className="relative overflow-hidden rounded-xl mb-6">
              <div className="aspect-w-16 aspect-h-9 bg-cover bg-center h-64" style={{ backgroundImage: `url('/api/placeholder/600/400')` }}></div>
              <div className="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end">
                <h3 className="text-2xl font-semibold p-6 text-white">Entrées</h3>
              </div>
            </div>
            <ul className="space-y-6">
              <li>
                <div className="flex justify-between border-b border-dashed border-gray-200 pb-2">
                  <h4 className="font-medium text-zinc-800">Carpaccio de Saint-Jacques</h4>
                  <span className="text-rose-600 font-medium">18€</span>
                </div>
                <p className="text-sm text-gray-500 mt-1">Fines tranches de Saint-Jacques, citron vert, huile d'olive extra vierge, fleur de sel</p>
              </li>
              <li>
                <div className="flex justify-between border-b border-dashed border-gray-200 pb-2">
                  <h4 className="font-medium text-zinc-800">Foie Gras Maison</h4>
                  <span className="text-rose-600 font-medium">22€</span>
                </div>
                <p className="text-sm text-gray-500 mt-1">Mi-cuit, chutney de figues, pain brioché toasté, fleur de sel</p>
              </li>
              <li>
                <div className="flex justify-between border-b border-dashed border-gray-200 pb-2">
                  <h4 className="font-medium text-zinc-800">Velouté de Saison</h4>
                  <span className="text-rose-600 font-medium">14€</span>
                </div>
                <p className="text-sm text-gray-500 mt-1">Velouté de légumes de saison, crème fraîche, huile aromatisée</p>
              </li>
            </ul>
          </div>

          {/* Plats */}
          <div className="group">
            <div className="relative overflow-hidden rounded-xl mb-6">
              <div className="aspect-w-16 aspect-h-9 bg-cover bg-center h-64" style={{ backgroundImage: `url('/api/placeholder/600/400')` }}></div>
              <div className="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end">
                <h3 className="text-2xl font-semibold p-6 text-white">Plats Principaux</h3>
              </div>
            </div>
            <ul className="space-y-6">
              <li>
                <div className="flex justify-between border-b border-dashed border-gray-200 pb-2">
                  <h4 className="font-medium text-zinc-800">Filet de Bœuf Rossini</h4>
                  <span className="text-rose-600 font-medium">36€</span>
                </div>
                <p className="text-sm text-gray-500 mt-1">Filet de bœuf, escalope de foie gras poêlée, sauce au truffe, purée de pommes de terre</p>
              </li>
              <li>
                <div className="flex justify-between border-b border-dashed border-gray-200 pb-2">
                  <h4 className="font-medium text-zinc-800">Lotte à l'Armoricaine</h4>
                  <span className="text-rose-600 font-medium">32€</span>
                </div>
                <p className="text-sm text-gray-500 mt-1">Queue de lotte, sauce armoricaine, riz sauvage, légumes croquants</p>
              </li>
              <li>
                <div className="flex justify-between border-b border-dashed border-gray-200 pb-2">
                  <h4 className="font-medium text-zinc-800">Risotto aux Truffes</h4>
                  <span className="text-rose-600 font-medium">28€</span>
                </div>
                <p className="text-sm text-gray-500 mt-1">Riz carnaroli, truffe noire, parmesan affiné 24 mois, beurre aux herbes</p>
              </li>
            </ul>
          </div>

          {/* Desserts */}
          <div className="group">
            <div className="relative overflow-hidden rounded-xl mb-6">
              <div className="aspect-w-16 aspect-h-9 bg-cover bg-center h-64" style={{ backgroundImage: `url('/api/placeholder/600/400')` }}></div>
              <div className="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent flex items-end">
                <h3 className="text-2xl font-semibold p-6 text-white">Desserts</h3>
              </div>
            </div>
            <ul className="space-y-6">
              <li>
                <div className="flex justify-between border-b border-dashed border-gray-200 pb-2">
                  <h4 className="font-medium text-zinc-800">Soufflé au Grand Marnier</h4>
                  <span className="text-rose-600 font-medium">14€</span>
                </div>
                <p className="text-sm text-gray-500 mt-1">Soufflé aérien parfumé au Grand Marnier, glace vanille</p>
              </li>
              <li>
                <div className="flex justify-between border-b border-dashed border-gray-200 pb-2">
                  <h4 className="font-medium text-zinc-800">Tarte au Citron Meringuée</h4>
                  <span className="text-rose-600 font-medium">12€</span>
                </div>
                <p className="text-sm text-gray-500 mt-1">Crème de citron, meringue italienne, sablé breton</p>
              </li>
              <li>
                <div className="flex justify-between border-b border-dashed border-gray-200 pb-2">
                  <h4 className="font-medium text-zinc-800">Assiette de Fromages</h4>
                  <span className="text-rose-600 font-medium">16€</span>
                </div>
                <p className="text-sm text-gray-500 mt-1">Sélection de fromages affinés, confiture, noix, pain aux céréales</p>
              </li>
            </ul>
          </div>
        </div>

        <div className="text-center mt-16">
          <Link href="/menu-complet">
            <span className="text-rose-600 font-medium hover:text-rose-700 border-b border-rose-300 hover:border-rose-600 pb-1 transition-colors cursor-pointer inline-flex items-center">
              Voir le menu complet
              <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M14 5l7 7m0 0l-7 7m7-7H3" />
              </svg>
            </span>
          </Link>
        </div>
      </section>

      {/* Chef's Special */}
      <section className="py-20 bg-zinc-900 text-white relative overflow-hidden">
        <div className="absolute inset-0 opacity-20">
          <div className="absolute inset-0 bg-cover bg-center" style={{ backgroundImage: `url('/api/placeholder/1200/800')` }}></div>
        </div>
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
          <div className="text-center mb-16">
            <h2 className="text-4xl font-bold mb-6">Menu Dégustation</h2>
            <div className="h-0.5 w-24 bg-rose-400 mx-auto mb-6"></div>
            <p className="text-gray-300 max-w-2xl mx-auto">Laissez-vous guider par notre chef à travers un voyage culinaire en 7 services</p>
          </div>

          <div className="bg-zinc-800/80 backdrop-blur-sm p-12 rounded-xl max-w-3xl mx-auto shadow-2xl">
            <div className="mb-8 pb-8 border-b border-zinc-700 text-center">
              <h3 className="text-2xl font-semibold mb-2">Menu Prestige</h3>
              <p className="text-rose-300 text-lg">120€ par personne</p>
              <p className="text-sm text-gray-400 mt-2">Accord mets et vins disponible pour 65€ supplémentaires</p>
            </div>
            <ul className="space-y-6">
              <li className="pl-4 border-l-2 border-rose-500">
                <span className="text-gray-400 text-sm">Amuse-bouche</span>
                <p className="text-white font-medium">Mise en bouche du chef selon inspiration du jour</p>
              </li>
              <li className="pl-4 border-l-2 border-rose-500">
                <span className="text-gray-400 text-sm">Entrée froide</span>
                <p className="text-white font-medium">Tartare de thon rouge, avocat et agrumes</p>
              </li>
              <li className="pl-4 border-l-2 border-rose-500">
                <span className="text-gray-400 text-sm">Entrée chaude</span>
                <p className="text-white font-medium">Raviole de homard, bisque crémeuse, brunoise de légumes</p>
              </li>
              <li className="pl-4 border-l-2 border-rose-500">
                <span className="text-gray-400 text-sm">Poisson</span>
                <p className="text-white font-medium">Saint-Pierre, mousseline de céleri, émulsion au champagne</p>
              </li>
              <li className="pl-4 border-l-2 border-rose-500">
                <span className="text-gray-400 text-sm">Viande</span>
                <p className="text-white font-medium">Filet d'agneau en croûte d'herbes, jus corsé à la truffe</p>
              </li>
              <li className="pl-4 border-l-2 border-rose-500">
                <span className="text-gray-400 text-sm">Pré-dessert</span>
                <p className="text-white font-medium">Sorbet citron basilic, espuma de gin</p>
              </li>
              <li className="pl-4 border-l-2 border-rose-500">
                <span className="text-gray-400 text-sm">Dessert</span>
                <p className="text-white font-medium">Dôme au chocolat grand cru, cœur caramel fleur de sel</p>
              </li>
            </ul>
            <div className="mt-10 text-center">
              <button
                onClick={() => setIsModalOpen(true)}
                className="bg-rose-600 text-white px-8 py-3 rounded-full hover:bg-rose-700 transition-colors shadow-lg shadow-rose-800/30 text-sm uppercase tracking-widest"
              >
                Réserver pour le menu dégustation
              </button>
            </div>
          </div>
        </div>
      </section>

      {/* About Section */}
      <section id="about" className="py-24 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
            <div>
              <h2 className="text-4xl font-bold mb-6 text-zinc-800">Notre Histoire</h2>
              <div className="h-1 w-16 bg-rose-500 mb-8"></div>
              <p className="text-gray-600 mb-6 leading-relaxed">
                Fondé en 2010 par le Chef Jean-Michel Leblanc, L'Élégance s'est rapidement imposé
                comme l'une des tables les plus raffinées de la capitale.
              </p>
              <p className="text-gray-600 mb-6 leading-relaxed">
                Chaque plat raconte une histoire, celle d'un terroir français riche et généreux,
                magnifié par des techniques modernes et une créativité sans cesse renouvelée.
              </p>
              <p className="text-gray-600 leading-relaxed">
                Notre philosophie repose sur trois piliers : l'excellence des produits,
                le respect des saisons et l'innovation culinaire. Notre restaurant a été
                récompensé par deux étoiles au guide Michelin depuis 2015.
              </p>
              <div className="mt-10">
                <div className="flex items-center">
                  <img src="/api/placeholder/100/100" alt="Chef" className="rounded-full w-16 h-16 object-cover" />
                  <div className="ml-4">
                    <p className="font-medium text-zinc-800">Jean-Michel Leblanc</p>
                    <p className="text-sm text-gray-500">Chef exécutif</p>
                  </div>
                </div>
              </div>
            </div>
            <div className="relative">
              <div className="absolute -top-6 -left-6 w-64 h-64 bg-rose-100 rounded-lg -z-10"></div>
              <img src="/api/placeholder/600/800" alt="Restaurant Interior" className="rounded-lg shadow-xl z-10 relative" />
              <div className="absolute -bottom-6 -right-6 w-64 h-64 bg-rose-100 rounded-lg -z-10"></div>
            </div>
          </div>
        </div>
      </section>

      {/* Testimonials */}
      <section className="py-20 bg-slate-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <h2 className="text-4xl font-bold text-center mb-4 text-zinc-800">Ce que disent nos clients</h2>
          <p className="text-center text-gray-500 mb-16 max-w-2xl mx-auto">Découvrez l'expérience de nos clients et pourquoi ils reviennent</p>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div className="bg-white p-8 rounded-xl shadow-lg">
              <div className="flex mb-4">
                {[1, 2, 3, 4, 5].map((star) => (
                  <svg key={star} xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                ))}
              </div>
              <p className="text-gray-600 italic mb-6">"Une expérience culinaire inoubliable. Chaque bouchée était une découverte, un véritable voyage des sens. Le service impeccable."</p>
              <div className="flex items-center">
                <div>
                  <p className="font-medium text-zinc-800">Marie Durand</p>
                  <p className="text-sm text-gray-500">Dîner en couple - Mai 2024</p>
                </div>
              </div>
            </div>

            <div className="bg-white p-8 rounded-xl shadow-lg">
              <div className="flex mb-4">
                {[1, 2, 3, 4, 5].map((star) => (
                  <svg key={star} xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                ))}
              </div>
              <p className="text-gray-600 italic mb-6">"Le menu dégustation vaut absolument son prix. La créativité du chef est remarquable, et l'accord mets-vins parfaitement exécuté."</p>
              <div className="flex items-center">
                <div>
                  <p className="font-medium text-zinc-800">François Martin</p>
                  <p className="text-sm text-gray-500">Menu dégustation - Janvier 2025</p>
                </div>
              </div>
            </div>

            <div className="bg-white p-8 rounded-xl shadow-lg">
              <div className="flex mb-4">
                {[1, 2, 3, 4, 5].map((star) => (
                  <svg key={star} xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.8-2.034c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                  </svg>
                ))}
              </div>
              <p className="text-gray-600 italic mb-6">"Parfait pour célébrer un événement spécial. L'ambiance, la nourriture, le service... tout était à la hauteur de nos attentes et même au-delà."</p>
              <div className="flex items-center">
                <div>
                  <p className="font-medium text-zinc-800">Sophie et Pierre Lambert</p>
                  <p className="text-sm text-gray-500">Anniversaire de mariage - Mars 2025</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Contact/Hours Section */}
      <section className="py-20 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 md:grid-cols-2 gap-16">
            <div>
              <h2 className="text-3xl font-bold mb-6 text-zinc-800">Horaires d'ouverture</h2>
              <div className="space-y-4">
                <div className="flex justify-between pb-4 border-b border-gray-200">
                  <span className="font-medium text-zinc-800">Lundi & Mardi</span>
                  <span className="text-gray-500">Fermé</span>
                </div>
                <div className="flex justify-between pb-4 border-b border-gray-200">
                  <span className="font-medium text-zinc-800">Mercredi - Vendredi</span>
                  <span className="text-gray-500">19:00 - 23:00</span>
                </div>
                <div className="flex justify-between pb-4 border-b border-gray-200">
                  <span className="font-medium text-zinc-800">Samedi</span>
                  <span className="text-gray-500">12:00 - 14:30, 19:00 - 23:00</span>
                </div>
                <div className="flex justify-between pb-4 border-b border-gray-200">
                  <span className="font-medium text-zinc-800">Dimanche</span>
                  <span className="text-gray-500">12:00 - 15:00</span>
                </div>
              </div>

              <div className="mt-16">
                <h3 className="text-2xl font-bold mb-6 text-zinc-800">Nous trouver</h3>
                <div className="bg-slate-50 p-6 rounded-lg">
                  <p className="text-gray-600 mb-2 flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 mr-3 text-rose-500 flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>25 Avenue des Champs-Élysées, 75008 Paris</span>
                  </p>
                  <p className="text-gray-600 mb-2 flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 mr-3 text-rose-500 flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span>+33 1 23 45 67 89</span>
                  </p>
                  <p className="text-gray-600 flex items-start">
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 mr-3 text-rose-500 flex-shrink-0 mt-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span>contact@lelegance-restaurant.fr</span>
                  </p>
                </div>
              </div>
            </div>

            <div>
              <h2 className="text-3xl font-bold mb-6 text-zinc-800">Réservation</h2>
              <p className="text-gray-600 mb-8">Pour garantir une expérience optimale, nous vous conseillons de réserver votre table à l'avance. Notre équipe se fera un plaisir de vous accueillir.</p>

              <div className="bg-slate-50 p-6 rounded-lg">
                <div className="flex flex-col space-y-4">
                  <button
                    onClick={() => setIsModalOpen(true)}
                    className="bg-rose-600 text-white px-6 py-3 rounded-full hover:bg-rose-700 transition-colors shadow-md hover:shadow-lg shadow-rose-900/20 hover:shadow-rose-900/30 text-sm uppercase tracking-widest flex items-center justify-center"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Réserver une table
                  </button>

                  <a
                    href="tel:+33123456789"
                    className="border border-rose-600 text-rose-600 px-6 py-3 rounded-full hover:bg-rose-50 transition-colors text-sm uppercase tracking-widest flex items-center justify-center"
                  >
                    <svg xmlns="http://www.w3.org/2000/svg" className="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Nous appeler
                  </a>
                </div>

                <div className="mt-6 pt-6 border-t border-gray-200">
                  <p className="text-gray-500 text-sm">Pour les groupes de plus de 8 personnes, veuillez nous contacter directement par téléphone pour discuter des options de menu et d'espace.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-zinc-900 text-white pt-16 pb-8">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 md:grid-cols-3 gap-10 mb-12">
            <div>
              <h3 className="text-2xl font-bold mb-6 text-white font-sans italic">L'Élégance</h3>
              <p className="text-gray-400 mb-6">Une expérience gastronomique d'exception au cœur de Paris.</p>
              <div className="flex space-x-4">
                <a href="#" className="text-gray-400 hover:text-rose-400 transition-colors">
                  <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path fillRule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clipRule="evenodd" />
                  </svg>
                </a>
                <a href="#" className="text-gray-400 hover:text-rose-400 transition-colors">
                  <svg className="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path fillRule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clipRule="evenodd" />
                  </svg>
                </a>
              </div>
            </div>

            <div>
              <h3 className="text-xl font-semibold mb-6 text-white">Liens utiles</h3>
              <ul className="space-y-4">
                <li><a href="#" className="text-gray-400 hover:text-rose-300 transition-colors">Mentions légales</a></li>
                <li><a href="#" className="text-gray-400 hover:text-rose-300 transition-colors">Politique de confidentialité</a></li>
                <li><a href="#" className="text-gray-400 hover:text-rose-300 transition-colors">Conditions générales</a></li>
                <li><a href="#" className="text-gray-400 hover:text-rose-300 transition-colors">Plan du site</a></li>
              </ul>
            </div>

            <div>
              <h3 className="text-xl font-semibold mb-6 text-white">Newsletter</h3>
              <p className="text-gray-400 mb-4">Inscrivez-vous pour recevoir nos actualités et offres spéciales.</p>
              <form className="flex">
                <input
                  type="email"
                  placeholder="Votre email"
                  className="bg-zinc-800 border border-zinc-700 text-white px-4 py-2 rounded-l-md focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent w-full"
                />
                <button
                  type="submit"
                  className="bg-rose-600 text-white px-4 py-2 rounded-r-md hover:bg-rose-700 transition-colors"
                >
                  OK
                </button>
              </form>
            </div>
          </div>

          <div className="border-t border-zinc-800 pt-8 mt-8 text-center text-gray-500 text-sm">
            <p>&copy; {new Date().getFullYear()} L'Élégance. Tous droits réservés.</p>
          </div>
        </div>
      </footer>

      {/* Reservation Modal */}
      {isModalOpen && (
        <div className="fixed inset-0 bg-black bg-opacity-60 flex items-center justify-center z-50 p-4">
          <div className="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden">
            <div className="p-6">
              <div className="flex justify-between items-center mb-6">
                <h3 className="text-2xl font-bold">Réserver une table</h3>
                <button
                  onClick={() => setIsModalOpen(false)}
                  className="text-gray-500 hover:text-gray-700"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>

              {isBookingConfirmed ? (
                <div className="text-center py-8">
                  <svg xmlns="http://www.w3.org/2000/svg" className="h-16 w-16 mx-auto text-green-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M5 13l4 4L19 7" />
                  </svg>
                  <h4 className="text-xl font-semibold mb-2">Réservation confirmée !</h4>
                  <p className="text-gray-600">Nous avons hâte de vous accueillir.</p>
                </div>
              ) : (
                <form onSubmit={handleSubmit} className="space-y-4">
                  <div className="grid grid-cols-2 gap-4">
                    <div>
                      <label htmlFor="date" className="block text-sm font-medium text-gray-700 mb-1">Date</label>
                      <input
                        type="date"
                        id="date"
                        value={date}
                        onChange={(e) => setDate(e.target.value)}
                        className="w-full border-gray-300 rounded-md focus:ring-rose-500 focus:border-rose-500"
                        required
                      />
                    </div>
                    <div>
                      <label htmlFor="time" className="block text-sm font-medium text-gray-700 mb-1">Heure</label>
                      <select
                        id="time"
                        value={time}
                        onChange={(e) => setTime(e.target.value)}
                        className="w-full border-gray-300 rounded-md focus:ring-rose-500 focus:border-rose-500"
                        required
                      >
                        <option value="">Sélectionner</option>
                        <option value="19:00">19:00</option>
                        <option value="19:30">19:30</option>
                        <option value="20:00">20:00</option>
                        <option value="20:30">20:30</option>
                        <option value="21:00">21:00</option>
                        <option value="21:30">21:30</option>
                      </select>
                    </div>
                  </div>

                  <div>
                    <label htmlFor="guests" className="block text-sm font-medium text-gray-700 mb-1">Nombre de personnes</label>
                    <select
                      id="guests"
                      value={guests}
                      onChange={(e) => setGuests(parseInt(e.target.value))}
                      className="w-full border-gray-300 rounded-md focus:ring-rose-500 focus:border-rose-500"
                      required
                    >
                      {[1, 2, 3, 4, 5, 6, 7, 8].map((num) => (
                        <option key={num} value={num}>{num} {num === 1 ? 'personne' : 'personnes'}</option>
                      ))}
                    </select>
                  </div>

                  <div>
                    <label htmlFor="name" className="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input
                      type="text"
                      id="name"
                      value={name}
                      onChange={(e) => setName(e.target.value)}
                      className="w-full border-gray-300 rounded-md focus:ring-rose-500 focus:border-rose-500"
                      required
                    />
                  </div>

                  <div>
                    <label htmlFor="email" className="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input
                      type="email"
                      id="email"
                      value={email}
                      onChange={(e) => setEmail(e.target.value)}
                      className="w-full border-gray-300 rounded-md focus:ring-rose-500 focus:border-rose-500"
                      required
                    />
                  </div>

                  <div>
                    <label htmlFor="phone" className="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                    <input
                      type="tel"
                      id="phone"
                      value={phone}
                      onChange={(e) => setPhone(e.target.value)}
                      className="w-full border-gray-300 rounded-md focus:ring-rose-500 focus:border-rose-500"
                      required
                    />
                  </div>

                  <button
                    type="submit"
                    className="w-full bg-rose-600 text-white px-4 py-3 rounded-md hover:bg-rose-700 transition-colors shadow-md hover:shadow-lg shadow-rose-900/20 hover:shadow-rose-900/30 mt-6"
                  >
                    Confirmer la réservation
                  </button>
                </form>
              )}
            </div>
          </div>
        </div>
      )}
    </div>
  );
}