<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BasicCollection extends ResourceCollection
{
	protected static $collectionResource = BasicResource::class;


	public static $wrap = 'body';

	/**
	 * @var array|null
	 */
	protected $pagination;

	/**
	 * BasicCollection constructor.
	 * @param mixed $resource
	 */
	public function __construct($resource)
	{
		if ($resource instanceof LengthAwarePaginator) {

			$this->pagination = new Pagination($resource);

			parent::__construct($resource->getCollection());
		}

		parent::__construct($resource);
	}

	/**
	 * Transform the resource collection into an array.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @return array
	 */
	public function toArray($request): array
	{
		return [
			'collection' => (static::$collectionResource)::collection($this->collection),
			'pagination' => $this->pagination
		];
	}
}
