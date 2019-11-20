<?php

namespace App\Http\Controllers;

use App\Exceptions\PublicException;
use App\Http\Resources\OrdersCollection;
use App\Http\Resources\OrderResource;
use App\Http\Resources\Pagination;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Redirect;
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

		return redirect()->back()->with(['status' => __('Order created successfully')]);
	}

	public function get(Request $request)
	{
		/** @var LengthAwarePaginator $awarePaginator */
		$awarePaginator = Order::query()
			->orderBy('created_at', 'desc')
			->paginate(15);

		return view('ordersList', [
			'orders' => $awarePaginator->getCollection(),
			'paginator' => $awarePaginator
		]);
	}

	public function update(Request $request, Order $order)
	{
		//Список доступных статусов. Возможно стоит унести куда нибудь, например в модель,
		//Но пока проще так
		$availableType = [
			Order::STATUS_PROCESSING,
			Order::STATUS_COMPLETED,
			Order::STATUS_ON_HOLD,
			Order::STATUS_CANCELED,
		];
		$request->validate([
			'status' => ['integer', 'in:' . implode(', ', $availableType)],
		]);

		if (in_array($order->status, [Order::STATUS_COMPLETED, Order::STATUS_CANCELED])) {
			return Redirect::back()->withErrors([__('Order status is completed or canceled')]);
		}

		if ($request->has('status')) {
			$order->status = $request->input('status');
		}

		if ($request->has('comment')) {
			$order->comment = $request->input('comment');
		}

		$order->save();

		return Redirect::back()->with(['status' => __('Order updated successfully')]);
	}
}
