<?php

namespace DentalSleepSolutions\Services\ApiResponse;

use DentalSleepSolutions\Exceptions\GeneralException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ApiResponseHelper
{
    /** @var FractalDataRetriever */
    private $fractalDataRetriever;

    public function __construct(
        FractalDataRetriever $fractalDataRetriever
    ) {
        $this->fractalDataRetriever = $fractalDataRetriever;
    }

    /**
     * Json response to valid request.
     *
     * @param string $message
     * @param array|null $data
     * @param int $code
     * @return JsonResponse
     * @throws GeneralException
     */
    public function responseOk(
        $message = '',
        $data = null,
        $code = 200
    ) {
        return $this->createResponse($message, $data, $code);
    }

    /**
     * Json response to invalid request.
     *
     * @param string $message
     * @param int $code
     * @param array|null $data
     * @return JsonResponse
     * @throws GeneralException
     */
    public function responseError(
        $message = '',
        $code = 404,
        $data = null
    ) {
        if (!is_array($data)) {
            $data = [
                'errorMessage' => $message,
                'errors' => [],
            ];
        }

        return $this->createResponse($message, $data, $code);
    }

    /**
     * Json response depending on provided data
     *
     * @param array $data
     * @param string $messageSuccess
     * @param string $messageError
     * @return JsonResponse
     * @throws GeneralException
     */
    public function response(
        array $data,
        $messageSuccess,
        $messageError
    ) {
        if (!array_key_exists('data', $data)) {
            throw new GeneralException('Data array must contain key \'data\'');
        }

        if (isset($data['success']) && $data['success']) {
            return $this->responseOk($messageSuccess, $data['data'], 200);
        }

        if (!isset($data['status'])) {
            throw new GeneralException('Data array must contain key \'status\'');
        }

        return $this->responseError($messageError, $data['status'], $data['data']);
    }

    /**
     * @param string $message
     * @param mixed $data
     * @param int $code
     * @return JsonResponse
     * @throws GeneralException
     */
    private function createResponse(
        $message,
        $data,
        $code
    ) {
        $json = [
            'status'  => $this->getStatusName($code),
            'code'    => $code,
            'message' => $message,
            'data'    => $this->transform($data),
        ];

        return new JsonResponse($json, $code);
    }

    /**
     * Human-friendly representation of http response code.
     *
     * @param int $code
     * @return string
     */
    private function getStatusName($code)
    {
        if (array_key_exists($code, Response::$statusTexts)) {
            return Response::$statusTexts[$code];
        }
        return '';
    }

    /**
     * @todo: this code looks dirty, look for refactoring possibilities
     *
     * Convert paginate data do response data
     *
     * @param string $result
     * @return array
     * @throws GeneralException
     */
    public function getPaginateStructure(string $result)
    {
        $result = json_decode($result, true);
        if (!isset($result['data'])) {
            throw new GeneralException('Result must contain \'data\' key');
        }
        $result['items'] = $result['data'];
        unset($result['data']);

        return $result;
    }

    /**
     * Transform resource with fractal transformers if possible.
     *
     * @param mixed $data
     * @return mixed
     * @throws GeneralException
     */
    public function transform($data)
    {
        $fractalData = $this->fractalDataRetriever->getFractalData($data);
        if ($fractalData) {
            return $fractalData;
        }

        return $data;
    }
}
