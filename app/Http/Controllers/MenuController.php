<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    // Afficher tous les plats du menu
    public function index()
    {
        // Pour le module gérant, vous pouvez par exemple récupérer tous les menus
        $menuItems = Menu::orderBy('jour')->orderBy('categorie')->orderBy('nom_plat')->get();
        // Assurez-vous que vos vues se trouvent dans resources/views/gerant/menus/
        return view('gerant.menus.index', compact('menuItems'));
    }

    // Afficher le formulaire pour créer un nouveau plat
    public function create()
    {
        // La vue de création se trouve dans resources/views/gerant/menus/create.blade.php
        return view('gerant.menus.create');
    }

    // Enregistrer un nouveau plat
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_plat'   => 'required|string|max:255',
            'prix'       => 'required|numeric|min:0',
            'description'=> 'required|string',
            'jour'       => 'required|string|max:20', // par exemple "Lundi", "Mardi", etc.
            'categorie'  => 'required|in:entrees,plat,dessert'  // si vous utilisez ENUM ou restreignez les valeurs
        ]);

        Menu::create($validated);

        return redirect()->route('gerant.menus.index')->with('success', 'Plat ajouté avec succès!');
    }

    // Afficher un plat spécifique
    public function show(Menu $menu)
    {
        return view('gerant.menus.show', compact('menu'));
    }

    // Afficher le formulaire pour modifier un plat
    public function edit(Menu $menu)
    {
        return view('gerant.menus.edit', compact('menu'));
    }

    // Mettre à jour un plat
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'nom_plat'   => 'required|string|max:255',
            'prix'       => 'required|numeric|min:0',
            'description'=> 'required|string',
            'jour'       => 'required|string|max:20',
            'categorie'  => 'required|in:entrees,plat,dessert'
        ]);

        $menu->update($validated);

        return redirect()->route('gerant.menus.index')->with('success', 'Plat mis à jour avec succès!');
    }

    // Supprimer un plat
    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('gerant.menus.index')->with('success', 'Plat supprimé avec succès!');
    }
}
