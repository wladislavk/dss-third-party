<?php

namespace DentalSleepSolutions\Http\Controllers\Api;
use DentalSleepSolutions\Http\Controllers\BaseController;

class ApiBaseController extends BaseController
{
    /**
     * Create an error response
     *
     * @param string $message
     * @param string $responseCode
     * @return array
     */
    public function createErrorResponse($message, $responseCode = '400')
    {
        $errors = is_string($message) ? [$message] : $message;
        return response()->json(['status' => false,'errors' => $errors], $responseCode);
    }
}
