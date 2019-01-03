<?php


namespace Tests;

trait ValidationCreateTrait{
	
	private function assertCantCreate($data, $fields)
	{
		$response = $this->post('/admin/products', $data);     // post запрос на /categories пойдет на роут products.store
		$this->assertDatabaseHas('products', $data);
		$response->assertStatus(302);
		$response->assertSessionHasErrors($fields);
	}
	
}