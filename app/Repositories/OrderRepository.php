<?php


namespace App\Repositories;


use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderRepository
{
	public static function getPaginated()
	{
		/**
		 * @return LengthAwarePaginator
		 */
		return Order::query()
			->orderBy('created_at', 'desc')
			->paginate(15);
	}
}
