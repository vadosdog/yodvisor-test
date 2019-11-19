<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property string $comment
 * @property int $status
 * @package App\Models
 */
class Order extends Model
{
	const STATUS_PENDING = 1;
	const STATUS_PROCESSING = 2;
	const STATUS_COMPLETED = 3;
	const STATUS_ON_HOLD = 4;
	const STATUS_CANCELED = 5;

	protected $fillable = [
		'title',
		'description',
		'comment',
		'image',
		'status'
	];
}
