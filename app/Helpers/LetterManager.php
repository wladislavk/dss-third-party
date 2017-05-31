<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Dental\Letter;
use DentalSleepSolutions\Eloquent\Dental\Patient;

class LetterManager
{
    // TODO: these constants need to be moved to the DB
    const PATIENT_REFERRED_SOURCE = 1;
    const PHYSICIAN_REFERRED_SOURCE = 2;
    const PATIENT_TYPE = 'patient';
    const PHYSICIAN_TYPE = 'physician';

    /** @var LetterDeleter */
    private $letterDeleter;

    /** @var Letter */
    private $letterModel;

    public function __construct(LetterDeleter $letterDeleter, Letter $letterModel)
    {
        $this->letterDeleter = $letterDeleter;
        $this->letterModel = $letterModel;
    }

    public function manageLetters(
        $patientId,
        $docId,
        $userId,
        Patient $unchangedPatient,
        array $patientFormData
    ) {
        if ($unchangedPatient->referred_source == self::PHYSICIAN_REFERRED_SOURCE && $patientFormData['referred_source'] == self::PHYSICIAN_REFERRED_SOURCE) {
            $this->letterModel->updatePendingLettersToNewReferrer(
                $unchangedPatient->referred_by,
                $patientFormData['referred_by'],
                $patientId,
                self::PHYSICIAN_TYPE
            );
        } elseif ($unchangedPatient->referred_source == self::PATIENT_REFERRED_SOURCE && $patientFormData['referred_source'] == self::PATIENT_REFERRED_SOURCE) {
            $this->letterModel->updatePendingLettersToNewReferrer(
                $unchangedPatient->referred_by,
                $patientFormData['referred_by'],
                $patientId,
                self::PATIENT_TYPE
            );
        } elseif ($unchangedPatient->referred_source == self::PHYSICIAN_REFERRED_SOURCE && $patientFormData['referred_source'] != self::PHYSICIAN_REFERRED_SOURCE) {
            $letters = $this->letterModel->getPhysicianOrPatientPendingLetters(
                $unchangedPatient->referred_by,
                $patientId
            );
            if (count($letters)) {
                foreach ($letters as $letter) {
                    $type = 'md_referral';
                    $recipientId = $unchangedPatient->referred_by;
                    $this->letterDeleter->deleteLetter($letter->letterid, $type, $recipientId, $docId, $userId);
                }
            }
        } elseif ($unchangedPatient->referred_source == self::PATIENT_REFERRED_SOURCE && $patientFormData['referred_source'] != self::PATIENT_REFERRED_SOURCE) {
            $letters = $this->letterModel->getPhysicianOrPatientPendingLetters(
                $unchangedPatient->referred_by,
                $patientId,
                'patient'
            );
            if (count($letters)) {
                foreach ($letters as $letter) {
                    $type = 'pat_referral';
                    $recipientId = $unchangedPatient->referred_by;
                    $this->letterDeleter->deleteLetter($letter->letterid, $type, $recipientId, $docId, $userId);
                }
            }
        }
    }
}
