<?php

namespace DentalSleepSolutions\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use DentalSleepSolutions\StaticClasses\ApiResponse;

abstract class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function response(array $errors)
    {
        return ApiResponse::responseError('Provided data is invalid.', 422, ['errors' => $errors]);
    }

    public function rules()
    {
        return [];
    }

    /**
     * @return array
     */
    abstract public function storeRules();

    /**
     * @return array
     */
    abstract public function updateRules();

    /**
     * @return array
     */
    abstract public function destroyRules();
}
