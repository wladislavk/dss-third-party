<?php

namespace DentalSleepSolutions\Exceptions;

use Exception;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        HttpException::class,
        ResourceNotFoundException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ResourceNotFoundException || $e instanceof ModelNotFoundException) {
            $e = new HttpException(404, 'Resource not found');
        }

        if ($request->wantsJson()) {
            return $this->renderJsonException($e);
        }

        return parent::render($request, $e);
    }

    /**
     * Render json error response.
     *
     * @param  \Exception $e
     * @return \Illuminate\Http\JsonResponse
     */
    protected function renderJsonException(Exception $e)
    {
        if ($this->isHttpException($e)) {
            return ApiResponse::responseError($e->getMessage(), $e->getStatusCode());
        }

        $message = 'An internal error occurred. We are investigating the issue.';

        return ApiResponse::responseError($message, 500);
    }
}
