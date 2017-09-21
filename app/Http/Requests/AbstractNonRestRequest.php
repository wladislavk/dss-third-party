<?php

namespace DentalSleepSolutions\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use DentalSleepSolutions\Facades\ApiResponse;

abstract class AbstractNonRestRequest extends FormRequest
{
    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        return ApiResponse::responseError('Provided data is invalid.', 422, ['errors' => $errors]);
    }
}
