<?php

namespace DentalSleepSolutions\Helpers\PatientEditors;

use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Helpers\PasswordGenerator;
use DentalSleepSolutions\Helpers\PatientSummaryManager;
use DentalSleepSolutions\Helpers\SimilarHelper;
use DentalSleepSolutions\Structs\EditPatientResponseData;
use DentalSleepSolutions\Structs\NewPatientFormData;
use DentalSleepSolutions\Structs\PatientName;
use Illuminate\Http\Request;

class PatientCreator extends AbstractPatientEditor
{
    // TODO: it is highly likely that this URL is no longer relevant
    const DUPLICATE_URL = 'duplicate_patients.php?pid=';

    /** @var SimilarHelper */
    private $similarHelper;

    /** @var PatientSummaryManager */
    private $patientSummaryManager;

    /** @var PasswordGenerator */
    private $passwordGenerator;

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

    public function createPatient($ssn, User $currentUser, PatientName $patientName)
    {
    }

    protected function getNewFormData()
    {
        $newPatientFormData = new NewPatientFormData();
        if ($ssn) {
            $this->passwordGenerator->generatePassword($ssn, $newPatientFormData);
        }
        $newPatientFormData->userId = $currentUser->getUserIdOrZero();
        $newPatientFormData->docId = $currentUser->getDocIdOrZero();
        $newPatientFormData->ipAddress = $this->ip;
        $newPatientFormData->patientName = $patientName;
        return $newPatientFormData;
    }

    protected function launchDBUpdatingMethods(array $formData)
    {
//        $newPatientFormData = $patientCreator->createPatient($ssn, $this->currentUser, $patientName);
        $createdPatient = $this->patientModel->create($formData);
        return $createdPatient->patientid;
    }

    public function modifyResponseData(EditPatientResponseData $responseData)
    {
        parent::modifyResponseData($responseData);

        $this->patientSummaryManager->createSummary($createdPatientId, $patientLocation);

        $similarPatients = $this->similarHelper
            ->getSimilarPatients($createdPatientId, $currentUser->getDocIdOrZero());

        $responseData->createdPatientId = $createdPatientId;
        $fullName = $patientName->firstName . ' ' . $patientName->lastName;
        if (count($similarPatients)) {
            $responseData->redirectTo = self::DUPLICATE_URL . $createdPatientId;
            return;
        }
        $responseData->status = sprintf(EditPatientResponseData::PATIENT_ADDED_STATUS, $fullName);
    }
}
