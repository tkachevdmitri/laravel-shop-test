<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
	{

		$user = Auth::user();
		//dd($user, Auth::check());
		
		// если пользователь авторизован
		/**/
		if(Auth::check()){
			$user = Auth::user();
			if($user->is_admin){
				return view('admin.index');
			}
			die('acces denied, вы не админ');
		}
		
		return redirect()->route('home');
		
		
		return view('admin.index');
	}
}
