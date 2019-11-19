<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class Pagination extends JsonResource
{
	/**
	 * @var $resource LengthAwarePaginator
	 */
	public $resource;

	public function toArray($request)
	{
		$current = (int)$this->resource->currentPage();
		$last = (int)$this->resource->lastPage();
		return [
			'prev' => $current <= 1 ? null : $current - 1,
			'current' => $current,
			'next' => $current >= $last ? null : $current + 1,
			'last' => $last,
			'total' => $this->resource->total(),
			'perPage' => $this->resource->perPage(),
		];
	}

}
