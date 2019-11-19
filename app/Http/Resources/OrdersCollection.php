<?php

namespace App\Http\Resources;

use App\Http\Resources\BasicCollection;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;

class OrdersCollection extends BasicCollection
{
	protected static $collectionResource = OrderResource::class;
}
