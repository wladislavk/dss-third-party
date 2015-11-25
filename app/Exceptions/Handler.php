<?php

namespace DentalSleepSolutions\Exceptions;

use Exception;
use DentalSleepSolutions\Helpers\ApiResponse;
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
        ModelNotFoundException::class,
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
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof ModelNotFoundException) {
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
            return ApiResponse::responseError($e->getMessage());
        }

        return ApiResponse::responseError('Internal error occured. We are investigating the issue.', 500);
    }
}
