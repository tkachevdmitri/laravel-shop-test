<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Cart;

class CartController extends Controller
{
    public function add(Request $request){
    	//$cart = Cart::getInstance();
		//dd($request->get('product'));
    	$cart = new Cart();
    	$cart->add($request->get('product'));
		return redirect()->back();
	}
	
	public function remove(Request $request)
	{
		//$cart = Cart::getInstance();
		$cart = new Cart();
		$cart->remove($request->get('product'));
		return redirect()->back();
	}
	
	public function clear()
	{
		//$cart = Cart::getInstance();
		$cart = new Cart();
		$cart->clear();
		return redirect()->back();
	}
	
	public function get()
	{
		$categories = Category::all();
		//$cart = Cart::getInstance();
		
		$cart = new Cart();
		$products = $cart->get();
		return view('pages.cart', ['categories' => $categories, 'products' => $products, 'cart' => $cart]);
	}
}
