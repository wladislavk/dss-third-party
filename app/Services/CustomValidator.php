<?php
namespace DentalSleepSolutions\Services;

use Illuminate\Validation\Validator;
use Symfony\Component\Translation\TranslatorInterface;

class CustomValidator extends Validator
{
    /**
     * @param TranslatorInterface $translator
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     */
    public function __construct($translator, $data, $rules, $messages = [], $customAttributes = []) {
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

        if ($anySet) {
            return array_has($this->data, $attribute);
        }

        return true;
    }

    /**
     * @param  string  $message
     * @param  string  $attribute
     * @param  string  $rule
     * @param  array   $parameters
     * @return string
     */
    protected function replacePresentWith($message, $attribute, $rule, $parameters)
    {
        return $this->replaceRequiredWith($message, $attribute, $rule, $parameters);
    }
}
