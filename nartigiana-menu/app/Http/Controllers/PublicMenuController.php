<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class PublicMenuController extends Controller
{
    public function show(Menu $menu)
    {
        // Carica categorie e piatti
        $menu->load('categories.dishes');

        return view('menus.public', compact('menu'));
    }
}
