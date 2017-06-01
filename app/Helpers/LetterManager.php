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

    const UPDATE_TYPES = [
        self::PATIENT_REFERRED_SOURCE => self::PATIENT_TYPE,
        self::PHYSICIAN_REFERRED_SOURCE => self::PHYSICIAN_TYPE,
    ];

    const MD_REFERRAL_TYPE = 'md_referral';
    const PATIENT_REFERRAL_TYPE = 'pat_referral';

    const DELETE_TYPES = [
        self::PATIENT_REFERRED_SOURCE => self::PATIENT_REFERRAL_TYPE,
        self::PHYSICIAN_REFERRED_SOURCE => self::MD_REFERRAL_TYPE,
    ];

    /** @var LetterDeleter */
    private $letterDeleter;

    /** @var Letter */
    private $letterModel;

    public function __construct(LetterDeleter $letterDeleter, Letter $letterModel)
    {
        $this->letterDeleter = $letterDeleter;
        $this->letterModel = $letterModel;
    }

    /**
     * @param int $patientId
     * @param int $docId
     * @param int $userId
     * @param Patient $unchangedPatient
     * @param string $referredSource
     * @param string $referredBy
     */
    public function manageLetters(
        $patientId,
        $docId,
        $userId,
        Patient $unchangedPatient,
        $referredSource,
        $referredBy
    ) {
        if (
            !isset(self::UPDATE_TYPES[$unchangedPatient->referred_source])
            ||
            !isset(self::DELETE_TYPES[$unchangedPatient->referred_source])
        ) {
            // TODO: perhaps an exception is needed
            return;
        }
        if ($unchangedPatient->referred_source == $referredSource) {
            $this->letterModel->updatePendingLettersToNewReferrer(
                $unchangedPatient->referred_by,
                $referredBy,
                $patientId,
                self::UPDATE_TYPES[$unchangedPatient->referred_source]
            );
            return;
        }
        $letters = $this->letterModel->getPhysicianOrPatientPendingLetters(
            $unchangedPatient->referred_by,
            $patientId,
            self::UPDATE_TYPES[$unchangedPatient->referred_source]
        );
        foreach ($letters as $letter) {
            $this->letterDeleter->deleteLetter(
                $letter->letterid,
                self::DELETE_TYPES[$unchangedPatient->referred_source],
                $unchangedPatient->referred_by,
                $docId,
                $userId
            );
        }
    }
}
