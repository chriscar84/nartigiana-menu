<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = auth()->user()->menus()->get();
        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        return view('menus.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        auth()->user()->menus()->create($data);

        return redirect()->route('menus.index')->with('success', 'Menu creato!');
    }

    public function show(Menu $menu)
    {
        $this->authorizeMenu($menu);
        return view('menus.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $this->authorizeMenu($menu);
        return view('menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $this->authorizeMenu($menu);

        $data = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $menu->update($data);

        return redirect()->route('menus.index')->with('success', 'Menu aggiornato!');
    }

    public function destroy(Menu $menu)
    {
        $this->authorizeMenu($menu);
        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu eliminato!');
    }

    private function authorizeMenu(Menu $menu)
    {
        abort_unless($menu->user_id == auth()->id(), 403);
    }
}
