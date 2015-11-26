<?php

namespace DentalSleepSolutions\Helpers;

use Traversable;
use League\Fractal\Manager;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resource;
use Symfony\Component\HttpFoundation\Response;

/**
 * Response helper class providing consistent structure of the json content
 * that is sent by the application. It tries to transform the resources
 * using dedicated transformer if there is one in default namespace.
 *
 * @see \DentalSleepSolutions\Http\Transformers\
 */
class ApiResponse
{
    /**
     * Transformers namespace.
     *
     * @var string
     */
    private static $namespace = 'DentalSleepSolutions\Http\Transformers\\';

    /**
     * Human-friendly representation of http response code.
     *
     * @param  integer $code
     * @return string
     */
    private static function getStatusName($code)
    {
        return Arr::get(Response::$statusTexts, $code, '');
    }

    /**
     * Json response to valid request.
     *
     * @param  string  $message
     * @param  array   $data
     * @param  integer $code
     * @param  array   $headers
     * @param  integer $options
     * @return \Illuminate\Http\JsonResponse
     */
    public static function responseOk($message = '', $data = null, $code = 200, $headers = [], $options = 0)
    {
        return self::createResponse($message, $data, $code, $headers, $options);
    }

    /**
     * Json response to invalid request.
     *
     * @param  string  $message
     * @param  integer $code
     * @param  array   $data
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

        return self::createResponse($message, $data, $code, $headers, $options);
    }

    /**
     * Create json response.
     *
     * @param  string  $message
     * @param  mixed   $data
     * @param  integer $code
     * @param  array   $headers
     * @param  integer $options
     * @return string
     */
    private static function createResponse($message, $data, $code, $headers, $options)
    {
        $json = [
            'status'  => self::getStatusesName($code),
            'message' => $message,
            'data'    => self::transform($data),
        ];

        return new JsonResponse($json, $code, $headers, $options);
    }

    /**
     * Json response depending on provided data. Used after processing Eligible API responses.
     *
     * @param  array  $data
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

    /**
     * Transform resource with fractal transformers if possible.
     *
     * @param  mixed $data
     * @return mixed
     */
    private static function transform($data)
    {
        $fractal = new Manager;

        if (self::isResource($data) && $transformer = self::hasTransformer($data)) {
            $data = $fractal->createData(new Item($data, new $transformer))->toArray();
        }

        if (self::isCollection($data) && self::isResource($data[0]) && $transformer = self::hasTransformer($data[0])) {
            $data = $fractal->createData(new Collection($data, new $transformer))->toArray();
        }

        return Arr::get($data, 'data', $data);
    }

    private static function hasTransformer($resource)
    {
        return class_exists($transformer = self::$namespace.class_basename($resource))
                ? $transformer
                : false;
    }

    private static function isResource($data)
    {
        return $data instanceof Resource || $data instanceof Model;
    }

    private static function isCollection($data)
    {
        return (is_array($data) || $data instanceof Traversable) && isset($data[0]);
    }
}
