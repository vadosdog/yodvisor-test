<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	const STATUS_PENDING = 1;
	const STATUS_PROCESSING = 2;
	const STATUS_COMPLETED = 3;
	const STATUS_ON_HOLD = 4;
	const STATUS_CANCELED = 5;
}
