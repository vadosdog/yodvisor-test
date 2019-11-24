<?php

namespace App\Http\Middleware;

use App\Exceptions\PublicException;
use App\Models\Order;
use Closure;
use Illuminate\Http\Request;

class CheckIsEditableMiddleware
{
	/**
	 * @param $request
	 * @param Closure $next
	 * @return mixed
	 * @throws PublicException
	 */
	public function handle($request, Closure $next)
	{
		/** @var Order $order */
		$order = $request->route()->parameter('order');
		if (in_array($order->status, [Order::STATUS_COMPLETED, Order::STATUS_CANCELED])) {
			throw new PublicException('order_completed', 409);
		}
		return $next($request);
	}
}
