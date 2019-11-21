<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Response;

class Handler extends ExceptionHandler
{
	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Exception $exception
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $exception)
	{
//		if ($exception instanceof PublicException) {
//			return $this->invalid($request, $exception);
//		}
		if ($exception instanceof NotFoundHttpException) {
			return parent::render($request, $exception);
		}

		$exceptionAnswer = [
			'message' => __('errors.unknown_exception'),
			'code' => 'UNKNOWN_ERROR'
		];

		if (config('app.debug')) {
			$exceptionAnswer['devDetails'] = $exception->getMessage() . ' at ' . $exception->getFile() . ':' . $exception->getLine();
		}

		if ($exception instanceof PublicException) {
			$exceptionAnswer['code'] = $exception->getCode();
			$exceptionAnswer['message'] = $exception->getMessage();
		} else if ($exception instanceof ValidationException) {
			$exceptionAnswer['message'] = __('errors.validation_error');
			$exceptionAnswer['code'] = 'VALIDATION_ERROR';
			$exceptionAnswer['details'] = $exception->errors();
		} else if ($exception instanceof AuthenticationException) {
			$exceptionAnswer['code'] = 'UNAUTHENTICATED';
			$exceptionAnswer['message'] = __('errors.unauthenticated');
			$exception->status = 401; //TODO исправить
		}

		if ($exception instanceof HttpException) {
			$code = $exception->getStatusCode();
		} else {
			$code = $exception->status ?? 200;
		}

		return \Response::fail($exceptionAnswer, $code);
	}


}
