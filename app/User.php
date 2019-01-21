<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    
    public static function checkAdmin()
	{
		if(Auth::check()){
			$user = Auth::user();
			if($user->is_admin){
				return view('admin.index');
			}
			die('acces denied');
		}
	}
	
	public static function test()
	{
		dd('asdasd');
	}
    
}
