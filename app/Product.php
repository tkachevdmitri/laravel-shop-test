<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
	protected $fillable = ['title', 'price', 'category_id', 'article', 'brand', 'description', 'is_new', 'is_recommended', 'status'];
	
	
	// Связи таблиц
	// Товар привязан к определенной категории (одной категории)
	public function category()
	{
		return $this->belongsTo(Category::class);
	}
	
	
	// Методы для работы с товаром
	/*
	// Добавление товара - не используется
	public static function add($fields)
	{
		$product = new static;   // новый экземпляр модели
		// присваиваем значения
		$product->fill($fields);
		
		$product->save();
		
		return $product;
	}
	
	
	// Редактирование, обновление товара - не используется
	public function edit($fields)
	{
		$this->fill($fields);
		$this->save();
	}
	
	
	// Загоржка и сохранение изображения
	public function uploadImage($image)
	{
		if($image == null){
			return;
		}
		
		$this->removeImage();
		
		// генерируем название файла
		$filename = str_random(10) . '.' . $image->extension();
		
		// сохраняем в папку public/uploads
		// первый параметр - папка в которую хотим загрузить изображение (относительно папки public)

		$image->storeAs('uploads', $filename);
		
		$this->image = $filename;
		$this->save();
	}
	*/
	// Удаление изображения товара
	public function removeImage()
	{
		if($this->image != null){
			// удаление предыдущей картинки поста
			//Storage::delete('storage/products/' . $this->image);
			Storage::disk('products')->delete($this->image);
		}
	}
	
	// Вывод изображения
	public function getImage()
	{
		if($this->image == null){
			return Storage::disk('products')->url('no-image.png');
		}
		return Storage::disk('products')->url($this->image);
		//return asset('storage/products/'.$this->image);
	}
	
	
}
