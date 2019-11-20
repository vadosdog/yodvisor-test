<?php

namespace App\Http\Controllers;

use App\Exceptions\PublicException;
use App\Http\Resources\OrdersCollection;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Traits\UploadTrait;

class OrderController extends Controller
{
	use UploadTrait;

	public function add(Request $request)
	{
		$request->validate([
			'title' => 'required|max:255',
			'description' => 'required',
			'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
		]);

		$order = new Order();
		$order->fill($request->only(['title', 'description']));

		if ($request->has('image')) {
			//TODO сжатие изображения
			$order->image = $this->uploadOne($request->file('image'));
		}

		$order->save();

		return Response::success(new OrderResource($order));
	}

	public function get(Request $request)
	{
		$orders = Order::query()
			->orderBy('created_at', 'desc')
			->paginate(15);

		return Response::success(new OrdersCollection($orders));
	}
}
