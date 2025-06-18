<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::whereHas('menu', function($q) {
            $q->where('user_id', auth()->id());
        })->with('menu')->get();

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $menus = auth()->user()->menus()->get();
        return view('categories.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'name' => 'required|string|max:255',
        ]);

        // Verifica che il menu appartenga all'utente
        if (!auth()->user()->menus()->where('id', $data['menu_id'])->exists()) {
            abort(403);
        }

        Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Categoria creata!');
    }

    public function show(Category $category)
    {
        $this->authorizeCategory($category);
        return view('categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $this->authorizeCategory($category);
        $menus = auth()->user()->menus()->get();
        return view('categories.edit', compact('category', 'menus'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorizeCategory($category);

        $data = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'name' => 'required|string|max:255',
        ]);

        if (!auth()->user()->menus()->where('id', $data['menu_id'])->exists()) {
            abort(403);
        }

        $category->update($data);

        return redirect()->route('categories.index')->with('success', 'Categoria aggiornata!');
    }

    public function destroy(Category $category)
    {
        $this->authorizeCategory($category);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoria eliminata!');
    }

    private function authorizeCategory(Category $category)
    {
        abort_unless($category->menu->user_id == auth()->id(), 403);
    }
}
