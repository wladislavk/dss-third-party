<?php

namespace DentalSleepSolutions\Factories;

use DentalSleepSolutions\Services\PatientEditors\AbstractPatientEditor;
use DentalSleepSolutions\Services\PatientEditors\PatientCreator;
use DentalSleepSolutions\Services\PatientEditors\PatientUpdater;
use Illuminate\Support\Facades\App;

class PatientEditorFactory
{
    const CREATE_TYPE = 'create';
    const UPDATE_TYPE = 'update';

    const PATIENT_EDITORS = [
        self::CREATE_TYPE => PatientCreator::class,
        self::UPDATE_TYPE => PatientUpdater::class,
    ];

    /**
     * @param int $patientId
     * @return AbstractPatientEditor
     */
    public function getPatientEditor($patientId)
    {
        $type = self::CREATE_TYPE;
        if ($patientId) {
            $type = self::UPDATE_TYPE;
        }
        return App::make(self::PATIENT_EDITORS[$type]);
    }
}
