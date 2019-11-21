<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedException extends PublicException
{
	protected $message;
	protected $code = 'unauthorized';
	public $status = 401;
}
