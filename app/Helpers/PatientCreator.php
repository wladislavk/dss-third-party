<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Libraries\Password;
use DentalSleepSolutions\Structs\EditPatientResponseData;

class PatientCreator
{
    // TODO: it is highly likely that this URL is no longer relevant
    const DUPLICATE_URL = 'duplicate_patients.php?pid=';

    /** @var SimilarHelper */
    private $similarHelper;

    /** @var PatientSummaryManager */
    private $patientSummaryManager;

    /** @var Patient */
    private $patientModel;

    public function __construct(
        SimilarHelper $similarHelper,
        PatientSummaryManager $patientSummaryManager,
        Patient $patientModel
    ) {
        $this->similarHelper = $similarHelper;
        $this->patientSummaryManager = $patientSummaryManager;
        $this->patientModel = $patientModel;
    }

    public function createPatient(
        EditPatientResponseData $responseData,
        array $patientFormData,
        User $currentUser,
        $ip,
        $uniqueLogin,
        $patientLocation
    ) {
        $salt = '';
        $password = '';
        if ($patientFormData['ssn']) {
            $salt = Password::createSalt();
            $password = preg_replace('/\D/', '', $patientFormData['ssn']);
            $password = Password::genPassword($password, $salt);
        }

        $middleName = '';
        if (!empty($patientFormData['middlename'])) {
            $middleName = ucfirst($patientFormData['middlename']);
        }
        $patientFormData = array_merge($patientFormData, [
            'login'      => $uniqueLogin,
            'password'   => $password,
            'salt'       => $salt,
            'userid'     => $currentUser->getUserIdOrZero(),
            'docid'      => $currentUser->getDocIdOrZero(),
            'ip_address' => $ip,
            // set filters
            'firstname'  => ucfirst($patientFormData['firstname']),
            'lastname'   => ucfirst($patientFormData['lastname']),
            'middlename' => $middleName,
        ]);

        $createdPatient = $this->patientModel->create($patientFormData);
        $createdPatientId = $createdPatient->patientid;
        $responseData->createdPatientId = $createdPatient;

        $this->patientSummaryManager->createSummary($createdPatientId, $patientLocation);

        $similarPatients = $this->similarHelper
            ->getSimilarPatients($createdPatientId, $currentUser->getDocIdOrZero());

        $fullName = $patientFormData['firstname'] . ' ' . $patientFormData['lastname'];
        $this->modifyResponseData($responseData, $similarPatients, $fullName, $createdPatientId);
    }

    private function modifyResponseData(
        EditPatientResponseData $responseData,
        array $similarPatients,
        $fullName,
        $patientId
    ) {
        if (count($similarPatients)) {
            $responseData->redirectTo = self::DUPLICATE_URL . $patientId;
            return;
        }
        $responseData->status = sprintf(EditPatientResponseData::PATIENT_ADDED_STATUS, $fullName);
    }
}
