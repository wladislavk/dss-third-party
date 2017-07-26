<?php

namespace DentalSleepSolutions\Factories;

use DentalSleepSolutions\Constants\ReferredTypes;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Helpers\ReferredNameSetters\AbstractReferredNameSetter;
use DentalSleepSolutions\Helpers\ReferredNameSetters\PatientReferredNameSetter;
use DentalSleepSolutions\Helpers\ReferredNameSetters\PhysicianReferredNameSetter;
use Illuminate\Support\Facades\App;

class ReferredNameSetterFactory
{
    const REFERRED_NAME_SETTERS = [
        ReferredTypes::DSS_REFERRED_PATIENT => PatientReferredNameSetter::class,
        ReferredTypes::DSS_REFERRED_PHYSICIAN => PhysicianReferredNameSetter::class,
    ];

    /**
     * @param int $type
     * @return AbstractReferredNameSetter
     * @throws GeneralException
     */
    public function getReferredNameSetter($type)
    {
        if (!array_key_exists($type, self::REFERRED_NAME_SETTERS[$type])) {
            throw new GeneralException("Type $type is not valid");
        }
        $class = self::REFERRED_NAME_SETTERS[$type];
        $object = App::make($class);
        if (!$object instanceof AbstractReferredNameSetter) {
            throw new GeneralException("Class $class must implement " . AbstractReferredNameSetter::class);
        }
        return $object;
    }
}
