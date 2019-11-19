<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @mixin User
 * @package App\Http\Resources
 */
class OrderResource extends JsonResource
{
	public function toArray($request)
	{
		return ['kek'];
	}
}
