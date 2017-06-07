<?php

namespace DentalSleepSolutions\Helpers\ReferredNameSetters;

use DentalSleepSolutions\DentalSleepSolutions\Interfaces\NamedModelInterface;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Helpers\NameSetter;

abstract class AbstractReferredNameSetter
{
    /** @var NameSetter */
    private $nameSetter;

    public function __construct(NameSetter $nameSetter)
    {
        $this->nameSetter = $nameSetter;
    }

    /**
     * @param Patient $foundPatient
     * @return string|null
     */
    public function setReferredName(Patient $foundPatient)
    {
        $model = $this->getModel($foundPatient);
        if (!$model) {
            return null;
        }
        $referredName = $this->nameSetter->formFullName(
            $model->getFirstName(),
            $model->getMiddleName(),
            $model->getLastName(),
            $model->getLabel()
        );
        return $referredName;
    }

    /**
     * @param Patient $foundPatient
     * @return NamedModelInterface|null $model
     */
    abstract protected function getModel(Patient $foundPatient);
}
