<?php

namespace DentalSleepSolutions\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use DentalSleepSolutions\StaticClasses\ApiResponse;

abstract class Request extends FormRequest
{
    /** @var array */
    protected $rules = [];

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
     * @param  array $errors
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
    public function storeRules()
    {
        return $this->getStoreRules();
    }

    /**
     * @return array
     */
    public function updateRules()
    {
        return $this->getUpdateRules();
    }

    /**
     * @return array
     */
    protected function getStoreRules()
    {
        return $this->rules;
    }

    /**
     * @return array
     */
    protected function getUpdateRules()
    {
        $rules = [];
        foreach ($this->rules as $attribute => $rule) {
            $rules[$attribute] = $this->addOptionalRequired($rule);
        }
        return $rules;
    }

    /**
     * @param string|array $rule
     * @return mixed
     */
    private function addOptionalRequired($rule)
    {
        if (is_string($rule)) {
            $modifiedRule = str_replace('required', 'sometimes|required', $rule);
            return $modifiedRule;
        }
        if (is_array($rule)) {
            if ($rule[0] == 'required') {
                array_unshift($rule, 'sometimes');
            }
        }
        return $rule;
    }
}
