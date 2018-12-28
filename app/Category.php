<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = ['title'];
	
	// Связи таблиц
	
	// У одной категории может быть много товаров
	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
