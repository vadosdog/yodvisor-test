<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ResponseMacroServiceProvider extends ServiceProvider
{
	public function boot()
	{
		/*
		 * добавление методов success & fail для класса Response. Удобно для API
		 */
		\Response::macro('success', function ($value = null) {
			return \Response::json([
				'body' => $value,
				'error' => null
			]);
		});

		\Response::macro('fail', function ($error = null) {
			return \Response::json([
				'body' => null,
				'error' => $error
			]);
		});
	}
}
