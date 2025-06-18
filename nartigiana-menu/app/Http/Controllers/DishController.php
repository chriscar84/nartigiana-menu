<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Category;
use Illuminate\Http\Request;

class DishController extends Controller
{
    public function index()
    {
        $dishes = Dish::whereHas('category.menu', function($q) {
            $q->where('user_id', auth()->id());
        })->with('category')->get();

        return view('dishes.index', compact('dishes'));
    }

    public function create()
    {
        $categories = Category::whereHas('menu', function($q) {
            $q->where('user_id', auth()->id());
        })->get();

        return view('dishes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string|max:255',
        ]);

        // Controlla che la categoria appartenga a utente
        if (!Category::where('id', $data['category_id'])
            ->whereHas('menu', function($q) {
                $q->where('user_id', auth()->id());
            })->exists()) {
            abort(403);
        }

        Dish::create($data);

        return redirect()->route('dishes.index')->with('success', 'Piatto creato!');
    }

    public function show(Dish $dish)
    {
        $this->authorizeDish($dish);
        return view('dishes.show', compact('dish'));
    }

    public function edit(Dish $dish)
    {
        $this->authorizeDish($dish);
        $categories = Category::whereHas('menu', function($q) {
            $q->where('user_id', auth()->id());
        })->get();

        return view('dishes.edit', compact('dish', 'categories'));
    }

    public function update(Request $request, Dish $dish)
    {
        $this->authorizeDish($dish);

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string|max:255',
        ]);

        if (!Category::where('id', $data['category_id'])
            ->whereHas('menu', function($q) {
                $q->where('user_id', auth()->id());
            })->exists()) {
            abort(403);
        }

        $dish->update($data);

        return redirect()->route('dishes.index')->with('success', 'Piatto aggiornato!');
    }

    public function destroy(Dish $dish)
    {
        $this->authorizeDish($dish);
        $dish->delete();

        return redirect()->route('dishes.index')->with('success', 'Piatto eliminato!');
    }

    private function authorizeDish(Dish $dish)
    {
        abort_unless($dish->category->menu->user_id == auth()->id(), 403);
    }
}
