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
		$validatedData = $request->validate([
			'title' => 'required|max:255',
			'description' => 'required',
			'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
		]);

		$order = new Order();
		$order->fill($request->only(['title', 'description']));

		if ($request->has('image')) {
			$order->image = $this->uploadOne($request->file('image'));
		}

		$order->save();

		return Response::success(new OrderResource($order));
	}
}
