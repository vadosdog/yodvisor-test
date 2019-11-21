<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Redirect;
use App\Traits\UploadTrait;
use Illuminate\View\View;

class OrderController extends Controller
{
	use UploadTrait;

	/**
	 * Метод создания заявки с фронта с картиной
	 *
	 * @param Request $request
	 * @return RedirectResponse
	 */
	public function add(Request $request)
	{
		//TODO в Request
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

	/**
	 * Метод получения списка заявок
	 *
	 * @param Request $request
	 * @return Factory|View
	 */
	public function get(Request $request)
	{
		//TODO вынести в сервис
		/** @var LengthAwarePaginator $awarePaginator */
		$awarePaginator = Order::query()
			->orderBy('created_at', 'desc')
			->paginate(15);

		return view('ordersList', [
			'orders' => $awarePaginator->getCollection(),
			'paginator' => $awarePaginator
		]);
	}

	/**
	 * Редактирование заявки админом
	 * только статус и комментарий, если заявка не закрыта
	 *
	 * @param Request $request
	 * @param Order $order
	 * @return RedirectResponse
	 */
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
		//TODO в Request
		$request->validate([
			'status' => ['integer', 'in:' . implode(', ', $availableType)],
		]);

		//TODO в middlware
		if (in_array($order->status, [Order::STATUS_COMPLETED, Order::STATUS_CANCELED])) {
			return Redirect::back()->withErrors([__('Order status is completed or canceled')]);
		}

		$order->fill($request->only(['status', 'comment']));

		$order->save();

		return Redirect::back()->with(['status' => __('Order updated successfully')]);
	}
}
