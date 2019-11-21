<?php

namespace App\Exceptions;

use Exception;

class PublicException extends Exception
{
	protected $message;
	protected $code = 'public_exception';
	public $status;

	public function __construct(string $code = null, int $status = null)
	{
		$code = $code ?? $this->code;
		$this->message = __('errors.' . $code);
		$this->code = strtoupper($code);
	}
}
