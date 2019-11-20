<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

/**
 * Class Order
 *
 * @property string $id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property string $comment
 * @property int $status
 * @package App\Models
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Order newModelQuery()
 * @method static Builder|Order newQuery()
 * @method static Builder|Order query()
 * @method static Builder|Order whereComment($value)
 * @method static Builder|Order whereCreatedAt($value)
 * @method static Builder|Order whereDescription($value)
 * @method static Builder|Order whereId($value)
 * @method static Builder|Order whereImage($value)
 * @method static Builder|Order whereStatus($value)
 * @method static Builder|Order whereTitle($value)
 * @method static Builder|Order whereUpdatedAt($value)
 * @mixin Eloquent
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

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
		'id' => 'integer',
		'status' => 'integer',
	];

	public function getImageUrlAttribute()
	{
		return \Storage::url($this->image);
	}

	public function isEditable() :bool
	{
		return !in_array($this->status, [\App\Models\Order::STATUS_COMPLETED, \App\Models\Order::STATUS_CANCELED]);
	}
}
