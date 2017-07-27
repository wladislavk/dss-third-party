<?php

namespace DentalSleepSolutions\Helpers;

class NameSetter
{
    /**
     * TODO: an interface is needed for models that share these fields
     *
     * @param string $firstName
     * @param string $middleName
     * @param string $lastName
     * @param string $label
     * @return string
     */
    public function formFullName($firstName, $middleName, $lastName, $label = '')
    {
        $name = "$lastName, $firstName $middleName";
        if ($label) {
            $name .= " - $label";
        }
        return $name;
    }
}
