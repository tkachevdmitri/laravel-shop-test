<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
	
	// 401 - пользователь не авторизован
	// 403 - пользователь авторизован, но ему запрещен доступ
	// 405 - неизвестный роут
	// 419 - token exeption csrf
	// 422 - validation exeption
	// 301 - перманентный редирект
	// 302 - временный редирект
	
	use RefreshDatabase;
	/**
	 * Тест: пользователь может просматривать форму входа
	 */
	public function testUserCanViewLoginForm()
	{
		$response = $this->get('/login');
		
		$response->assertSuccessful();
		$response->assertViewIs('auth.login');
	}
	
	/**
	 * Тест: пользователь не может просматривать форму входа при аутентификации
	 */
	public function testUserCannotViewLoginFormWhenAuthenticated()
	{
		$user = factory(User::class)->make();
		//dd($user);
		$response = $this->actingAs($user)->get('/login');
		$response->assertRedirect('/home');
	}
	
	
	/**
	 * Тест: пользователь может войти с правильными учетными данными
	 */
	public function testUserCanLoginWithCorrectCredentials()
	{
		$user = factory(User::class)->create([
			'password' => bcrypt($password = 'test2222')
		]);
		
		$response = $this->post('/login', [
			'email' => $user->email,
			'password' => $password,
		]);
		
		$this->assertAuthenticatedAs($user);
		$response->assertRedirect('/home');
		
	}
	
	
	/**
	 * Тест: пользователь не может зайти с неправильным паролем
	 */
	public function testUserCannotLoginWithIncorrectPassword()
	{
		$user = factory(User::class)->create([
			'password' => bcrypt('test2222')
		]);
		
		// выполняем вход с неправильным паролем
		$response = $this->from('/login')->post('/login', [
			'email' => $user->email,
			'password' => 'incorrect_password',
		]);
		
		$response->assertRedirect('/login'); // пользователь перенаправлен на страницу входа
		$response->assertSessionHasErrors('email');  // утверждение, что в сеансе произошла ошибка
		$this->assertTrue(session()->hasOldInput('email'));  // поле email имеет старый ввод
		$this->assertFalse(session()->hasOldInput('password'));  // поле password имеет старый ввод
		$this->assertGuest(); // пользователь все еще гость
	}
	
	/*
	 * Тест: пользователь не может зайти с несуществующим email
	 */
	public function testUserCannotLoginWithIncorrectEmail()
	{
		$user = factory(User::class)->create([
			'password' => bcrypt($password = 'test2222')
		]);
		
		// выполняем вход с несуществующим email
		$response = $this->from('/login')->post('/login', [
			'email' => 'test222@mail.ru',
			'password' => $password
		]);
		
		$response->assertRedirect('/login');
		$response->assertSessionHasErrors('email');
		$this->assertTrue(session()->hasOldInput('email'));
		$this->assertFalse(session()->hasOldInput('password'));
		$this->assertGuest();
	}
	
}
