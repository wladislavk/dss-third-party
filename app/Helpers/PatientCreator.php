<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Libraries\Password;
use DentalSleepSolutions\Structs\EditPatientResponseData;
use DentalSleepSolutions\Structs\NewPatientFormData;
use DentalSleepSolutions\Structs\PatientName;
use Illuminate\Http\Request;

class PatientCreator
{
    // TODO: it is highly likely that this URL is no longer relevant
    const DUPLICATE_URL = 'duplicate_patients.php?pid=';

    /** @var SimilarHelper */
    private $similarHelper;

    /** @var PatientSummaryManager */
    private $patientSummaryManager;

    /** @var PasswordGenerator */
    private $passwordGenerator;

    /** @var Patient */
    private $patientModel;

    /** @var string */
    private $ip;

    public function __construct(
        SimilarHelper $similarHelper,
        PatientSummaryManager $patientSummaryManager,
        PasswordGenerator $passwordGenerator,
        Patient $patientModel,
        Request $request
    ) {
        $this->similarHelper = $similarHelper;
        $this->patientSummaryManager = $patientSummaryManager;
        $this->passwordGenerator = $passwordGenerator;
        $this->patientModel = $patientModel;
        $this->ip = $request->ip();
    }

    public function createPatient(
        EditPatientResponseData $responseData,
        array $patientFormData,
        User $currentUser,
        $patientLocation,
        PatientName $patientName
    ) {
        $newPatientFormData = new NewPatientFormData();
        if (isset($patientFormData['ssn']) && $patientFormData['ssn']) {
            $this->passwordGenerator->generatePassword($patientFormData['ssn'], $newPatientFormData);
        }
        $newPatientFormData->userId = $currentUser->getUserIdOrZero();
        $newPatientFormData->docId = $currentUser->getDocIdOrZero();
        $newPatientFormData->ipAddress = $this->ip;
        $newPatientFormData->patientName = $patientName;
        // TODO: divide this method so that it is possible to return $newPatientFormData
        /*$patientFormData = array_merge($patientFormData, [
            'password'   => $password,
            'salt'       => $salt,
            'userid'     => $currentUser->getUserIdOrZero(),
            'docid'      => $currentUser->getDocIdOrZero(),
            'ip_address' => $this->ip,
            'firstname'  => ucfirst($patientName->firstName),
            'lastname'   => ucfirst($patientName->lastName),
            'middlename' => ucfirst($patientName->middleName),
        ]);*/

        $createdPatient = $this->patientModel->create($patientFormData);
        $createdPatientId = $createdPatient->patientid;
        $responseData->createdPatientId = $createdPatient;

        $this->patientSummaryManager->createSummary($createdPatientId, $patientLocation);

        $similarPatients = $this->similarHelper
            ->getSimilarPatients($createdPatientId, $currentUser->getDocIdOrZero());

        $fullName = $patientName->firstName . ' ' . $patientName->lastName;
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
