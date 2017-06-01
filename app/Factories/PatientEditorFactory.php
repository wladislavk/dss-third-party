<?php

namespace DentalSleepSolutions\Factories;

use DentalSleepSolutions\Helpers\PatientEditors\AbstractPatientEditor;
use DentalSleepSolutions\Helpers\PatientEditors\PatientCreator;
use DentalSleepSolutions\Helpers\PatientEditors\PatientUpdater;
use Illuminate\Support\Facades\App;

class PatientEditorFactory
{
    const PATIENT_EDITORS = [
        'create' => PatientCreator::class,
        'update' => PatientUpdater::class,
    ];

    /**
     * @param int $patientId
     * @return AbstractPatientEditor
     */
    public function getPatientEditor($patientId)
    {
        $type = 'create';
        if ($patientId) {
            $type = 'update';
        }
        return App::make(self::PATIENT_EDITORS[$type]);
    }
}
