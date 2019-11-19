<?php

namespace App\Http\Controllers;

use App\Exceptions\PublicException;
use App\Http\Resources\OrdersCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
	public function add(Request $request)
	{
		$orders = Order::paginate(15);
		return Response::success(new OrdersCollection($orders));
	}
}
