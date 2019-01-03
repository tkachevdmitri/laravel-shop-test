<?php


namespace Tests;

trait ValidationTrait{
	
	private function assertCantUpdate($table, $url, $input, $fields, $output)
	{
		$this->assertDatabaseHas($table, $input);
		$response = $this->call('PUT', $url, $output);
		$this->assertDatabaseHas($table, $input);
		$response->assertStatus(302);
		$response->assertSessionHasErrors($fields);
	}

}