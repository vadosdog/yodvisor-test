<?php

use Illuminate\Database\Seeder;

class DefaultDataSeeder extends Seeder
{

	public function run()
	{
		$user = DB::table('users')->insertGetId([
			'name' => 'Admin',
			'email' => 'admin@admin.ru',
			'password' => \Hash::make('123123123'),
		]);
	}
}
