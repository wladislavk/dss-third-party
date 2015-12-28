<?php
namespace DentalSleepSolutions\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use DentalSleepSolutions\Helpers\ApiResponse;

abstract class Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return boolean
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
        if ($this->ajax() || $this->wantsJson()) {
            return ApiResponse::responseError('Provided data is invalid.', 422, ['errors' => $errors]);
        }

        return parent::response($errors);
    }
}
