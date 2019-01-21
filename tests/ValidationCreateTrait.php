<?php


namespace Tests;

trait ValidationCreateTrait{
	
	private function assertCantCreate($table, $url, $data, $fields)
	{
		$response = $this->post($url, $data);
		$this->assertDatabaseMissing($table, $data);
		$response->assertStatus(302);
		$response->assertSessionHasErrors($fields);
	}
	
}