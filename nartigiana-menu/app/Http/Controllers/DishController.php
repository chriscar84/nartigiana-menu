<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DishController extends Controller
{
    public function index(Request $request)
	{
		$user = auth()->user();

		$query = Dish::where('user_id', $user->id);

		if ($request->filled('search')) {
			$query->where('name', 'like', '%' . $request->search . '%');
		}

		if ($request->filled('category_id')) {
			$query->where('category_id', $request->category_id);
		}

		$dishes = $query->paginate(10)->withQueryString();

		$categories = Category::where('user_id', $user->id)->get();

		return view('dishes.index', compact('dishes', 'categories'));
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
			]);
		
		if ($request->hasFile('image')) {
			$file = $request->file('image');
			$filename = Str::uuid() . '.' . $file->extension();
			$path = $file->storeAs('dishes', $filename, 'public');
			$data['image'] = $path;
		}

        // Controlla che la categoria appartenga a utente
        if (!Category::where('id', $data['category_id'])
            ->whereHas('menu', function($q) {
                $q->where('user_id', auth()->id());
            })->exists()) {
            abort(403);
        }

		$data['user_id'] = auth()->id();

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

		if ($dish->image && Storage::disk('public')->exists($dish->image)) {
			Storage::disk('public')->delete($dish->image);
		}

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

		if ($request->hasFile('image')) {
			$file = $request->file('image');
			$filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
			$path = $file->storeAs('dishes', $filename, 'public');
			$data['image'] = $path;
		}

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
        
		if ($dish->image && Storage::disk('public')->exists($dish->image)) {
			Storage::disk('public')->delete($dish->image);
		}

		$dish->delete();

        return redirect()->route('dishes.index')->with('success', 'Piatto eliminato!');
    }

    private function authorizeDish(Dish $dish)
    {
        abort_unless($dish->category->menu->user_id == auth()->id(), 403);
    }
}
