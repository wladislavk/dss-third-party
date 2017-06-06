<?php

namespace DentalSleepSolutions\Factories;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Http\Requests\PatientStore;
use DentalSleepSolutions\Http\Requests\PatientUpdate;
use DentalSleepSolutions\Http\Requests\RequestWithRulesInterface;
use Illuminate\Support\Facades\App;

class RequestWithRulesFactory
{
    const PATIENT_UPDATE = 'patient_update';
    const PATIENT_STORE = 'patient_store';

    const REQUESTS = [
        self::PATIENT_UPDATE => PatientUpdate::class,
        self::PATIENT_STORE => PatientStore::class,
    ];

    /**
     * @param string $type
     * @return RequestWithRulesInterface
     * @throws GeneralException
     */
    public function getRequestClass($type)
    {
        if (!isset(self::REQUESTS[$type])) {
            throw new GeneralException("Type $type is not valid");
        }
        $class = self::REQUESTS[$type];
        $object = App::make($class);
        if (!$object instanceof RequestWithRulesInterface) {
            throw new GeneralException("Class $class must implement " . RequestWithRulesInterface::class);
        }
        return $object;
    }
}
