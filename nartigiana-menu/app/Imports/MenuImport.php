<?php

namespace App\Imports;

use App\Models\Menu;
use App\Models\Category;
use App\Models\Dish;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Str;

class MenuImport
{
    public function handle(string $filePath, int $menuId): void
    {
        $userId = auth()->id();

        $existingCategories = Category::where('menu_id', $menuId)->where('user_id', $userId)->get();

        foreach ($existingCategories as $category) {
            // Questo elimina anche i piatti collegati se hai relazioni con `onDelete('cascade')`
            $category->dishes()->delete();
            $category->delete();
        }
		
		SimpleExcelReader::create($filePath,'csv')
			->useDelimiter(';')
			->getRows()->each(function (array $row) use ($menuId) {
					$categoryName = trim($row['category']);

					// Crea la categoria se non esiste già per questo menu e utente
					$category = Category::firstOrCreate([
						'name' => $categoryName,
						'menu_id' => $menuId,
						'user_id' => auth()->id(),
					]);

					// Crea il piatto
					Dish::create([
						'name'        => trim($row['name']),
						'description' => trim($row['description'] ?? ''),
						'price'       => floatval($row['price']),
						'category_id' => $category->id,
						'user_id'     => auth()->id(),
					]);
        });
    }
}