<?php

namespace App\Http\Controllers;

use App\Exceptions\PublicException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
	public function add(Request $request)
	{
		throw new PublicException('kek');
		return Response::success(true);
	}
}
