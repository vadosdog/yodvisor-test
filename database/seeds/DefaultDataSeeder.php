<?php

use Illuminate\Database\Seeder;

class DefaultDataSeeder extends Seeder
{

	public function run()
	{
		/*
		 * Добавляем админа по умолчани
		 * email - admin@admin.ru
		 * password - 123123123
		 */
		DB::table('users')->insert([
			'name' => 'Admin',
			'email' => 'admin@admin.ru',
			'password' => \Hash::make('123123123'),
		]);
	}
}
