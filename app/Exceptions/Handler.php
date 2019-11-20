<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Support\Facades\Response;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that are not reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		//
	];

	/**
	 * A list of the inputs that are never flashed for validation exceptions.
	 *
	 * @var array
	 */
	protected $dontFlash = [
		'password',
		'password_confirmation',
	];

	/**
	 * Report or log an exception.
	 *
	 * @param \Exception $exception
	 * @return void
	 */
	public function report(Exception $exception)
	{
		parent::report($exception);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Exception $exception
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $exception)
	{
		return parent::render($request, $exception);
		if ($exception instanceof NotFoundHttpException) {
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
		}

		if ($exception instanceof ValidationException) {
			$exceptionAnswer['message'] = __('errors.validation_error');
			$exceptionAnswer['code'] = 'VALIDATION_ERROR';
			$exceptionAnswer['details'] = $exception->errors();
		}


		return \Response::fail($exceptionAnswer);
	}


}
