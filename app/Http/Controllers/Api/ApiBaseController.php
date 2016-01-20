<?php
namespace DentalSleepSolutions\Http\Controllers\Api;
use DentalSleepSolutions\Http\Controllers\Controller;

class ApiBaseController extends Controller
{
    /**
     * Create an error response
     *
     * @param string  $message
     * @param string  $responseCode
     * @param array   $headers
     * @param integer $options
     * @return \Illuminate\Http\JsonResponse
     */
    public function createErrorResponse($message, $responseCode = '400', array $headers = [], $options = 0)
    {
        $errors = is_string($message) ? [$message] : $message;
        return response()->json(['status' => false,'errors' => $errors], $responseCode, $headers, $options);
    }
}
