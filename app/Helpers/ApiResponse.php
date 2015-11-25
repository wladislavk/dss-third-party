<?php

namespace DentalSleepSolutions\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponse
{
    /**
     * Human-friendly representation of http response code.
     *
     * @param  integer $code
     * @return string
     */
    private static function getStatusesName($code)
    {
        return Arr::get(Response::$statusTexts, $code, '');
    }

    /**
     * Json response to valid request.
     *
     * @param  string $message
     * @param  array $data
     * @param  integer $code
     * @param  array $headers
     * @param  integer $options
     * @return \Illuminate\Http\JsonResponse
     */
    public static function responseOk($message = '', $data = null, $code = 200, $headers = [], $options = 0)
    {
        return new JsonResponse([
            'status'  => self::getStatusesName($code),
            'message' => $message,
            'data'    => $data,
        ], $code, $headers, $options);
    }

    /**
     * Json response to invalid request.
     *
     * @param  string $message
     * @param  integer $code
     * @param  array $data
     * @param  boolean $create_errors_array
     * @return \Illuminate\Http\JsonResponse
     */
    public static function responseError(
        $message = '',
        $code = 404,
        $data = null,
        $create_errors_array = true,
        $headers = [],
        $options = 0
    ) {
        if (!is_array($data) && $create_errors_array) {
            $data = [
                'errors' => [$data ? $data : $message]
            ];
        }

        return new JsonResponse([
            'status'  => self::getStatusesName($code),
            'message' => $message,
            'data'    => $data
        ], $code, $headers, $options);
    }

    /**
     * Json response depending on provided data. Used after processing Eligible API responses.
     *
     * @param  array $data
     * @param  string $message_success
     * @param  string $message_error
     * @return \Illuminate\Http\JsonResponse
     */
    public static function response($data, $message_success, $message_error, $headers = [], $options = 0)
    {
        if ($data['success']) {
            return self::responseOk($message_success, $data['data'], 200, $headers, $options);
        }

        return self::responseError($message_error, $data['status'], $data['data'], true, $headers, $options);
    }
}
