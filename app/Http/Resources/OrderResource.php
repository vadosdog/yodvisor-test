<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * Class OrderResource
 * @mixin Order
 * @package App\Http\Resources
 */
class OrderResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'id' => (int)$this->id,
			'title' => $this->title,
			'description' => $this->description,
			'comment' => $this->comment,
			'image' => Storage::url($this->image),
			'status' => (int)$this->status,
		];
	}
}
