<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

// use Illuminate\Http\Response;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		\Illuminate\Auth\AuthenticationException::class,
		\Illuminate\Auth\Access\AuthorizationException::class,
		\Symfony\Component\HttpKernel\Exception\HttpException::class,
		\Illuminate\Database\Eloquent\ModelNotFoundException::class,
		\Illuminate\Session\TokenMismatchException::class,
		\Illuminate\Validation\ValidationException::class,
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $exception
	 * @return void
	 */
	public function report(Exception $exception)
	{
		parent::report($exception);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $exception
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $exception)
	{
		// dd($exception);
		// if ($exception instanceof ErrorException) {
		// 	abort(500);
	 //        return response()->view('errors.error');
	 //    }

		// dd(app('Illuminate\Http\Response')->status());

		// if (app('Illuminate\Http\Response')->status() != 500) {
		// 	// dd('Hola');
		// 	return response()->view('errors.error');
		// }

		// dd('Hola');

		// if ($exception->getStatusCode() == 500)
		// 	return response()->view('errors.500');

		// return response()->view('errors.error');

		// dd(app('Illuminate\Http\Response')->status());

		// dd($exception->getCode());

		// dd($request);

		// dd(http_response_code());

		// if (app('Illuminate\Http\Response')->status() == 200) {
		// 	// dd('Hola');
		// 	return parent::render($request, $exception);
		// }
		// else {
		// 	return response()->view('errors.error');
		// }

		// abort(500);
		// abort(400);

		// $status = 400;


		// if ($this->isHttpException($exception))
		// {
		// 	$status = $exception->getStatusCode();
		// 	dd($status);

		// }

		// dd($exception->getStatusCode());




		// if($this->isHttpException($exception))
		// {
		// 	switch ($exception->getStatusCode()) {
		// 		//access denied
		// 		case 403:
		// 			return response()->view('errors.403', [], 403);  
		// 		break;
		// 		// not found
		// 		case 404:
		// 			return response()->view('errors.404', [], 404);
		// 		break;
		// 		// internal error
		// 		case 500:
		// 			return response()->view('errors.500', [], 500);  
		// 		break;

		// 		default:
		// 			return $this->renderHttpException($exception);
		// 		break;
		// 	}
		// }
		// else
		// {
		// 	return parent::render($request, $exception);
		// }

		
		return parent::render($request, $exception);
	}

	/**
	 * Convert an authentication exception into an unauthenticated response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Illuminate\Auth\AuthenticationException  $exception
	 * @return \Illuminate\Http\Response
	 */
	protected function unauthenticated($request, AuthenticationException $exception)
	{
		if ($request->expectsJson()) {
			return response()->json(['error' => 'Unauthenticated.'], 401);
		}

		return redirect()->guest(route('login'));
	}
}