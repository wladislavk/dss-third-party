<?php
namespace Ds3\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		HttpException::class,
	];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception $e
     * @return mixed
     * @throws \Exception
     */
	public function report(\Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return Response
	 */
	public function render($request, \Exception $e)
	{
		if ($this->isHttpException($e) && $e instanceof HttpException) {
            return $this->renderHttpException($e);
		} else {
            // Dependency injection?
            if (preg_match('/^production|release|stage|staging$/', app()->environment())) {
                /**
                 * Assume the DB is unreachable
                 * Show a "Maintenance mode" message
                 */
                if ($e instanceof \RuntimeException) {
                    return response()->view('errors.503', [], 503);
                }

                /**
                 * Assume some error in the code or in some SQL query
                 * Show a generic error message
                 */
                return response()->view('errors.500', [], 500);
            }

			return parent::render($request, $e);
		}
	}
}
