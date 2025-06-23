<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Menu extends Model
{
	use HasFactory;

    protected $fillable = [
        'title',
        'logo',
        'slug',
        'user_id'
    ];
	
    public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function categories()
	{
		return $this->hasMany(Category::class);
	}

	protected static function booted()
	{
		static::creating(function ($menu) {
			$menu->slug = Str::slug($menu->title);

			// Se esiste già uno slug simile, aggiungiamo un numero alla fine
			$original = $menu->slug;
			$i = 1;
			while (Menu::where('slug', $menu->slug)->exists()) {
				$menu->slug = $original . '-' . $i++;
			}
		});
	}
}
