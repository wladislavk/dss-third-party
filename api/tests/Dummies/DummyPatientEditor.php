<?php

namespace Tests\Dummies;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Services\PatientEditors\AbstractPatientEditor;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\EditPatientResponseData;
use DentalSleepSolutions\Structs\NewPatientFormData;

class DummyPatientEditor extends AbstractPatientEditor
{
    /** @var array */
    public $modifiedFormData = [];

    /**
     * @param User $currentUser
     * @param EditPatientRequestData $requestData
     * @return NewPatientFormData
     */
    protected function getNewFormData(
        User $currentUser,
        EditPatientRequestData $requestData
    ) {
        return new NewPatientFormData();
    }

    /**
     * @param array $formData
     * @param User $currentUser
     * @param EditPatientResponseData $responseData
     * @param EditPatientRequestData $requestData
     * @param Patient|null $unchangedPatient
     */
    protected function launchDBUpdatingMethods(
        array $formData,
        User $currentUser,
        EditPatientResponseData $responseData,
        EditPatientRequestData $requestData,
        Patient $unchangedPatient = null
    ) {
        $this->modifiedFormData = $formData;
    }

    /**
     * @param User $currentUser
     * @param EditPatientResponseData $responseData
     * @param EditPatientRequestData $requestData
     * @param Patient|null $unchangedPatient
     */
    protected function setResponseData(
        User $currentUser,
        EditPatientResponseData $responseData,
        EditPatientRequestData $requestData,
        Patient $unchangedPatient = null
    ) {
        // do nothing
    }
}
