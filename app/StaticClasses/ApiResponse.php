<?php

namespace DentalSleepSolutions\StaticClasses;

use Traversable;
use League\Fractal\Manager;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use Illuminate\Database\Eloquent\Model;
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
     * @return JsonResponse
     */
    public static function responseOk($message = '', $data = null, $code = 200, $headers = [], $options = 0)
    {
        return self::createResponse($message, $data, $code, $headers, $options);
    }

    /**
     * Json response to invalid request.
     *
     * @param string $message
     * @param int $code
     * @param array|null $data
     * @param bool $createErrorsArray
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    public static function responseError(
        $message = '',
        $code = 404,
        $data = null,
        $createErrorsArray = true,
        $headers = [],
        $options = 0
    ) {
        if (!is_array($data) && $createErrorsArray) {
            $dataArray = [];
            if (is_array($data) && isset($data['errors'])) {
                $dataArray = $data['errors'];
            }
            $data = [
                'errorMessage' => $message,
                'errors' => $dataArray,
            ];
        }

        return self::createResponse($message, $data, $code, $headers, $options);
    }

    /**
     * Convert paginate data do response data
     *
     * @param $result
     * @return array
     */
    public static function getPaginateStructure($result)
    {
        $result = json_decode($result->toJson(), true);
        $result['items'] = $result['data'];
        unset($result['data']);

        return $result;
    }

    /**
     * Create json response.
     *
     * @param  string  $message
     * @param  mixed   $data
     * @param  integer $code
     * @param  array   $headers
     * @param  integer $options
     * @return JsonResponse
     */
    private static function createResponse($message, $data, $code, $headers, $options)
    {
        $json = [
            'status'  => self::getStatusName($code),
            'code'    => $code,
            'message' => $message,
            'data'    => self::transform($data),
        ];

        return new JsonResponse($json, $code, $headers, $options);
    }

    /**
     * Json response depending on provided data. Used after processing Eligible API responses.
     *
     * @param  array  $data
     * @param  string $messageSuccess
     * @param  string $messageError
     * @param array $headers
     * @param int $options
     * @return JsonResponse
     */
    public static function response(
        $data,
        $messageSuccess,
        $messageError,
        $headers = [],
        $options = 0
    ) {
        if ($data['success']) {
            return self::responseOk($messageSuccess, $data['data'], 200, $headers, $options);
        }

        return self::responseError($messageError, $data['status'], $data['data'], true, $headers, $options);
    }

    /**
     * @todo: this function should be checked for argument type-safety
     *
     * Transform resource with fractal transformers if possible.
     *
     * @param  mixed $data
     * @return mixed
     */
    public static function transform($data)
    {
        $fractal = new Manager();
        $transformer = self::hasTransformer($data);

        if (self::isResource($data) && strlen($transformer)) {
            $data = $fractal->createData(new Item($data, new $transformer))->toArray();
        }

        $transformer = self::hasTransformer($data[0]);

        if (self::isCollection($data) && self::isResource($data[0]) && strlen($transformer)) {
            $data = $fractal->createData(new Collection($data, new $transformer()))->toArray();
        }

        return Arr::get($data, 'data', $data);
    }

    /**
     * @param string|object $resource
     * @return string
     */
    private static function hasTransformer($resource)
    {
        $transformer = self::$namespace . class_basename($resource);

        /**
         * class_exists() throws an exception if the class doesn't exist and autoload is enabled
         */
        try {
            if (class_exists($transformer)) {
                return $transformer;
            }
        } catch (\ErrorException $e) {
            return '';
        }

        return '';
    }

    /**
     * @param mixed $data
     * @return bool
     */
    private static function isResource($data)
    {
        return $data instanceof Model;
    }

    /**
     * @param mixed $data
     * @return bool
     */
    private static function isCollection($data)
    {
        return (is_array($data) || $data instanceof Traversable) && isset($data[0]);
    }
}
