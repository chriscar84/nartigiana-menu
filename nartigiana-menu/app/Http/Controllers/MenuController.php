<?php

namespace App\Http\Controllers;

use App\Imports\MenuImport;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index(Request $request)
	{
		$query = Menu::where('user_id', auth()->id());

		if ($request->filled('search')) {
			$query->where('title', 'like', '%' . $request->search . '%');
		}

		$menus = $query->orderBy('created_at', 'desc')->paginate(10);

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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
			'slug' => 'nullable|string|max:255|unique:menus,slug',
			'background_color' => 'nullable|string',
			'primary_color' => 'nullable|string',
			'background_image' => 'nullable|image|max:2048'
        ]);
		
		$slug = $request->slug ? Str::slug($request->slug) : Str::slug($request->title);
		
		// Slug unico automatico
		$original = $slug;
		$i = 1;
		while (Menu::where('slug', $slug)->exists()) {
			$slug = $original . '-' . $i++;
		}

		if ($request->hasFile('logo')) {
			$file = $request->file('logo');
			$filename = Str::uuid() . '.' . $file->extension();
			$path = $file->storeAs('logos', $filename, 'public');
			$data['logo'] = $path;
		}
		
		if ($request->hasFile('background_image')) {
			$file = $request->file('background_image');
			$filename = Str::uuid() . '.' . $file->extension();
			$path = $file->storeAs('backgrounds', $filename, 'public');
			$data['background_image'] = $path;
		}

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
		
		if ($request->has('delete_background_image')) {
			if ($menu->background_image && Storage::disk('public')->exists($menu->background_image)) {
				Storage::disk('public')->delete($menu->background_image);
			}
			$menu->background_image = null;
			$menu->save();

			return redirect()->back()->with('success', 'Immagine di sfondo eliminata!');
		}
		
		$data = $request->validate([
            'title' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
			'slug' => 'nullable|string|max:255|unique:menus,slug,' . $menu->id,
			'background_color' => 'nullable|string',
			'primary_color' => 'nullable|string',
			'background_image' => 'nullable|image|max:2048'
        ]);
		        
		if ($request->filled('slug') && $request->slug !== $menu->slug) {
			$original = Str::slug($request->slug);
			$slug = $original;
			$i = 1;
			while (Menu::where('slug', $slug)->where('id', '!=', $menu->id)->exists()) {
				$slug = $original . '-' . $i++;
			}
			$data['slug'] = $slug;
		}
		
		if ($request->hasFile('logo')) {
			if ($menu->logo && Storage::disk('public')->exists($menu->logo)) {
				Storage::disk('public')->delete($menu->logo);
			}
       
			$file = $request->file('logo');
			$filename = Str::uuid() . '.' . $file->extension();
			$path = $file->storeAs('logos', $filename, 'public');
			$data['logo'] = $path;
		}

		if ($request->hasFile('background_image')) {
			if ($menu->background_image && Storage::disk('public')->exists($menu->background_image)) {
				Storage::disk('public')->delete($menu->background_image);
			}

			$file = $request->file('background_image');
			$filename = Str::uuid() . '.' . $file->extension();
			$path = $file->storeAs('backgrounds', $filename, 'public');
			$data['background_image'] = $path;
		}
        $menu->update($data);

        return redirect()->route('menus.index')->with('success', 'Menu aggiornato!');
    }

    public function destroy(Menu $menu)
    {
        $this->authorizeMenu($menu);
        
		if ($menu->logo && Storage::disk('public')->exists($menu->logo)) {
			Storage::disk('public')->delete($menu->logo);
		}

		$menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu eliminato!');
    }

    private function authorizeMenu(Menu $menu)
    {
        abort_unless($menu->user_id == auth()->id(), 403);
    }

	function ensureUtf8Encoding(string $filePath): string
	{
		$originalContent = file_get_contents($filePath);

		// Tenta di rilevare la codifica originale
		$encoding = mb_detect_encoding($originalContent, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);

		if ($encoding !== 'UTF-8') {
			// Converte in UTF-8
			$converted = mb_convert_encoding($originalContent, 'UTF-8', $encoding);

			// Sovrascrive o crea una nuova versione del file
			$newPath = $filePath . '.utf8.csv';
			file_put_contents($newPath, $converted);

			return $newPath;
		}

		return $filePath; // già UTF-8
	}

	public function import(Request $request, MenuImport $importer)
	{
		$request->validate([
			'file' => ['required', 'file', 'mimes:csv,txt'],
			'menu_id' => ['required', 'exists:menus,id'],
		]);

		$path = $request->file('file')->store('imports');
		$fullPath = Storage::path($path);

		$utf8Path = $this->ensureUtf8Encoding($fullPath);

		$importer->handle($utf8Path, $request->menu_id);

		return redirect()->route('menus.index')->with('success', 'Menu importato con successo!');
	}

	public function showImportForm()
	{
		$menus = Menu::where('user_id', auth()->id())->get();

		return view('menus.import', compact('menus'));
	}
}
