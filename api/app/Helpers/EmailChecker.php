<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Exceptions\IncorrectEmailException;

class EmailChecker
{
    const EMPTY_EMAIL_MESSAGE = 'The email address you entered is empty.';
    const EMAIL_IN_USE_MESSAGE = 'The email address you entered is already associated with another patient. Please enter a different email address.';
    const EMAIL_CHANGED_MESSAGE = "You have changed the patient's email address. The patient must be notified via email or he/she will not be able to access the Patient Portal. Send email notification and proceed?";

    // TODO: resolve magic numbers
    const ALLOWED_STATUSES = [1, 2];

    /** @var PatientRepository */
    private $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    /**
     * @param string $email
     * @param int $patientId
     * @return string
     * @throws IncorrectEmailException
     */
    public function checkEmail($email, $patientId)
    {
        if (strlen($email) == 0) {
            $message = self::EMPTY_EMAIL_MESSAGE;
            throw new IncorrectEmailException($message);
        }
        if (!$this->isPatientEmailValid($email, $patientId)) {
            $message = self::EMAIL_IN_USE_MESSAGE;
            throw new IncorrectEmailException($message);
        }
        $patient = $this->patientRepository->getPatientInfoWithDocInfo($patientId);
        if ($patient && $this->confirmPatientEmail($email, $patient)) {
            return self::EMAIL_CHANGED_MESSAGE;
        }
        return '';
    }

    /**
     * @param string $email
     * @param int $patientId
     * @return bool
     */
    private function isPatientEmailValid($email, $patientId)
    {
        $numberOfEmails = $this->patientRepository->getSameEmails($email, $patientId);
        if ($numberOfEmails > 0) {
            return false;
        }
        return true;
    }

    /**
     * @param string $email
     * @param Patient $patient
     * @return bool
     */
    private function confirmPatientEmail($email, Patient $patient)
    {
        if (!in_array($patient->registration_status, self::ALLOWED_STATUSES)) {
            return false;
        }
        // TODO: check if this field is really a boolean in disguise
        if (!boolval($patient->use_patient_portal)) {
            return false;
        }
        if (!isset($patient->doc_use_patient_portal) || !boolval($patient->doc_use_patient_portal)) {
            return false;
        }
        if ($patient->email == $email) {
            return false;
        }
        return true;
    }
}
