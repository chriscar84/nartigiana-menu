<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
	{
		$query = Category::query()
			->where('user_id', auth()->id());

		if ($request->filled('search')) {
			$search = $request->input('search');
			$query->where('name', 'like', "%{$search}%");
		}

		$categories = $query->orderBy('name')->paginate(10)->withQueryString();

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

		$data['user_id'] = auth()->id();
        
		Category::create($data);

        return redirect()->route('categories.index')->with('success', 'Categoria creata!');
    }
	
	/*public function store(Request $request)
	{
		$request->validate([
			'name' => 'required|string|max:255',
		]);

		// Recupera il menu dell'utente loggato
		$menu = auth()->user()->menu; // Assumendo che User abbia relazione menu()

		if (!$menu) {
			return redirect()->back()->withErrors('Nessun menù trovato per questo utente.');
		}

		Category::create([
			'name' => $request->input('name'),
			'user_id' => auth()->id(),
			'menu_id' => $menu->id,
		]);

		return redirect()->route('categories.index')->with('success', 'Categoria creata con successo.');
	}*/


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
