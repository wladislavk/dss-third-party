<?php

namespace DentalSleepSolutions\Http\Requests;

use Closure;
use Illuminate\Foundation\Http\FormRequest;
use DentalSleepSolutions\Facades\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class Request extends FormRequest
{
    /** @var \Symfony\Component\HttpFoundation\ParameterBag */
    public $request;

    /** @var Closure */
    protected $adminResolver;

    /** @var Closure */
    protected $patientResolver;

    /** @var array */
    protected $rules = [];

    /**
     * Force JSON responses for all requests
     *
     * @return bool
     */
    public function wantsJson()
    {
        return true;
    }

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
     * @return array
     */
    public function payload()
    {
        if ($this->request->all()) {
            return $this->request->all();
        }
        return [];
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param array $errors
     * @return JsonResponse
     */
    public function response(array $errors)
    {
        $transformed = [];
        foreach ($errors as $field => $message) {
            $transformed[] = [
                'field' => $field,
                'message' => $message[0],
            ];
        }
        return ApiResponse::responseError('Provided data is invalid.', 422, ['errors' => $transformed]);
    }

    /**
     * Get the admin making the request.
     *
     * @return mixed
     */
    public function admin()
    {
        return call_user_func($this->getAdminResolver());
    }

    /**
     * Get the admin resolver callback.
     *
     * @return Closure
     */
    public function getAdminResolver()
    {
        if ($this->adminResolver) {
            return $this->adminResolver;
        }

        return function()
        {
            // noop
        };
    }

    /**
     * Set the admin resolver callback.
     *
     * @param Closure $callback
     * @return $this
     */
    public function setAdminResolver(Closure $callback)
    {
        $this->adminResolver = $callback;
        return $this;
    }

    /**
     * Get the patient associated to the request.
     *
     * @return mixed
     */
    public function patient()
    {
        return call_user_func($this->getPatientResolver());
    }

    /**
     * Get the patient resolver callback.
     *
     * @return Closure
     */
    public function getPatientResolver()
    {
        if ($this->patientResolver) {
            return $this->patientResolver;
        }

        return function()
        {
            // noop
        };
    }

    /**
     * Set the patient resolver callback.
     *
     * @param Closure $callback
     * @return $this
     */
    public function setPatientResolver(Closure $callback)
    {
        $this->patientResolver = $callback;
        return $this;
    }

    /**
     * @return array
     */
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

    public function getRawRules()
    {
        return $this->rules;
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
     * @return string|array
     */
    private function addOptionalRequired($rule)
    {
        if (is_string($rule)) {
            $modifiedRule = str_replace('required', 'sometimes|required', $rule);
            return $modifiedRule;
        }
        if (is_array($rule) && $rule[0] == 'required') {
            array_unshift($rule, 'sometimes');
        }
        return $rule;
    }
}
