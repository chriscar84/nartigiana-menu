<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'menu_id',
		'user_id'
    ];
	
	public function menu()
	{
		return $this->belongsTo(Menu::class);
	}

	public function dishes()
	{
		return $this->hasMany(Dish::class);
	}

}
