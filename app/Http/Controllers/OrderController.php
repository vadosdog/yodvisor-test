<?php

namespace App\Http\Controllers;

use App\Exceptions\PublicException;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrdersCollection;
use App\Models\Order;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Traits\UploadTrait;
use Illuminate\View\View;

class OrderController extends Controller
{
	use UploadTrait;

	/**
	 * Метод создания заявки с фронта с картиной
	 *
	 * @param CreateOrderRequest $request
	 * @return RedirectResponse
	 */
	public function add(CreateOrderRequest $request)
	{
		$order = new Order();
		$order->fill($request->only(['title', 'description']));

		if ($request->has('image')) {
			//TODO сжатие изображения
			$order->image = $this->uploadOne($request->file('image'));
		}

		$order->save();

		return \Response::success(new OrderResource($order), 201);
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

		return \Response::success(new OrdersCollection($awarePaginator));
	}

	/**
	 * Метод получения списка заявок
	 *
	 * @param Request $request
	 * @return Factory|View
	 */
	public function getListPage(Request $request)
	{
		//TODO вынести в сервис
		/** @var LengthAwarePaginator $awarePaginator */
		$awarePaginator = Order::query()
			->orderBy('created_at', 'desc')
			->paginate(15);

		//TODO реализовать пагинатор
		return view('ordersList', [
			'orders' => $awarePaginator->getCollection(),
			'paginator' => $awarePaginator
		]);
	}

	/**
	 * Редактирование заявки админом
	 * только статус и комментарий, если заявка не закрыта
	 *
	 * @param UpdateOrderRequest $request
	 * @param Order $order
	 * @return mixed
	 * @throws PublicException
	 */
	public function update(UpdateOrderRequest $request, Order $order)
	{
		$order->fill($request->only(['status', 'comment']));

		$order->save();

		return \Response::success(new OrderResource($order));
	}
}
