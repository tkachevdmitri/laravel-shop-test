<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;

class CartController extends Controller
{
    public function add(Request $request){
    	$cart = new Cart;
    	$cart->add($request->get('product'));
	}
	
	public function remove(Request $request)
	{
		$cart = new Cart;
		$cart->remove($request->get('product'));
	}
	
	public function get()
	{
		$cart = new Cart;
		return $cart->get();
	}
}
