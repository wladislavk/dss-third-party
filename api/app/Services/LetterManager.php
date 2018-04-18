<?php

namespace DentalSleepSolutions\Services;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Structs\PatientReferrer;

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

    /** @var LetterRepository */
    private $letterRepository;

    public function __construct(LetterDeleter $letterDeleter, LetterRepository $letterRepository)
    {
        $this->letterDeleter = $letterDeleter;
        $this->letterRepository = $letterRepository;
    }

    /**
     * @param int $docId
     * @param int $userId
     * @param Patient $unchangedPatient
     * @param PatientReferrer $referrer
     */
    public function manageLetters(
        $docId,
        $userId,
        Patient $unchangedPatient,
        PatientReferrer $referrer
    ) {
        if (
            !array_key_exists($unchangedPatient->referred_source, self::UPDATE_TYPES)
            ||
            !array_key_exists($unchangedPatient->referred_source, self::DELETE_TYPES)
        ) {
            // TODO: perhaps an exception is needed
            return;
        }
        if ($unchangedPatient->referred_source == $referrer->source) {
            $this->letterRepository->updatePendingLettersToNewReferrer(
                $unchangedPatient->referred_by,
                $referrer->referredBy,
                $unchangedPatient->patientid,
                self::UPDATE_TYPES[$unchangedPatient->referred_source]
            );
            return;
        }
        $letters = $this->letterRepository->getPhysicianOrPatientPendingLetters(
            $unchangedPatient->referred_by,
            $unchangedPatient->patientid,
            self::UPDATE_TYPES[$unchangedPatient->referred_source]
        );
        foreach ($letters as $letter) {
            $this->letterDeleter->deleteLetter(
                $letter,
                self::DELETE_TYPES[$unchangedPatient->referred_source],
                $unchangedPatient->referred_by,
                $docId,
                $userId
            );
        }
    }
}
