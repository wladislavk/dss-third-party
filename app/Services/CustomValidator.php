<?php
namespace DentalSleepSolutions\Services;

use Illuminate\Validation\Validator;

class CustomValidator extends Validator
{
    public function __construct($translator, $data, $rules, $messages=[], $customAttributes=[]) {
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);

        $this->implicitRules[] = 'Present';
        $this->implicitRules[] = 'PresentWith';
    }

    /**
     * Check if the given attribute is set
     *
     * @return bool
     */
    public function validatePresent ($attribute, $value, $parameters) {
        return array_has($this->data, $attribute);
    }

    /**
     * Check if the given attribute is set when other fields are set
     *
     * @return bool
     */
    public function validatePresentWith ($attribute, $value, $parameters) {
        $anySet = true;

        foreach ($parameters as $each) {
            $anySet = $anySet || array_has($this->data, $each);
        }

        return $anySet ? array_has($this->data, $attribute) : true;
    }
}
