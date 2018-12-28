<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
	{
		return view('pages.index');
	}
	
	// страница категории
	public function category($id)
	{
		$category = Category::where('id', $id)->firstOrFail();
		$products = $category->products;
		
		return view('pages.category', ['category' => $category, 'products' => $products]);
	}
	
	// страница поста
	public function show($id)
	{
		dd($id);
	}
}
