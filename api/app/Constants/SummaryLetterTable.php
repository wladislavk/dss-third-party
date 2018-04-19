<?php

namespace DentalSleepSolutions\Constants;

// @todo: this data needs to be moved to the DB
interface SummaryLetterTable
{
    public const LETTER_ID_COLUMN = 'letterId';
    public const TO_PATIENT_COLUMN = 'isToPatient';
    public const MD_LIST_COLUMN = 'hasMdList';
    public const MD_REFERRAL_LIST_COLUMN = 'hasMdReferralList';
    public const STEP_ID_COLUMN = 'stepId';

    public const SUMMARY_LETTERS = [
        TrackerSteps::IMPRESSION_ID => [
            [
                self::LETTER_ID_COLUMN => LetterIds::IMPRESSION_ID,
                self::TO_PATIENT_COLUMN => false,
                self::MD_LIST_COLUMN => false,
                self::MD_REFERRAL_LIST_COLUMN => true,
                self::STEP_ID_COLUMN => 0,
            ],
        ],
        TrackerSteps::DELAYING_TREATMENT_ID => [
            [
                self::LETTER_ID_COLUMN => LetterIds::DELAYING_TREATMENT_ID,
                self::TO_PATIENT_COLUMN => false,
                self::MD_LIST_COLUMN => true,
                self::MD_REFERRAL_LIST_COLUMN => true,
                self::STEP_ID_COLUMN => TrackerSteps::CONSULT_ID,
            ],
        ],
        TrackerSteps::REFUSED_TREATMENT_ID => [
            [
                self::LETTER_ID_COLUMN => LetterIds::FIRST_REFUSED_TREATMENT_ID,
                self::TO_PATIENT_COLUMN => true,
                self::MD_LIST_COLUMN => false,
                self::MD_REFERRAL_LIST_COLUMN => false,
                self::STEP_ID_COLUMN => TrackerSteps::CONSULT_ID,
            ],
            [
                self::LETTER_ID_COLUMN => LetterIds::SECOND_REFUSED_TREATMENT_ID,
                self::TO_PATIENT_COLUMN => false,
                self::MD_LIST_COLUMN => true,
                self::MD_REFERRAL_LIST_COLUMN => true,
                self::STEP_ID_COLUMN => TrackerSteps::CONSULT_ID,
            ],
        ],
        TrackerSteps::FOLLOW_UP_ID => [
            [
                self::LETTER_ID_COLUMN => LetterIds::FOLLOW_UP_ID,
                self::TO_PATIENT_COLUMN => true,
                self::MD_LIST_COLUMN => true,
                self::MD_REFERRAL_LIST_COLUMN => true,
                self::STEP_ID_COLUMN => TrackerSteps::DEVICE_DELIVERY_ID,
            ],
        ],
        TrackerSteps::NON_COMPLIANT_ID => [
            [
                self::LETTER_ID_COLUMN => LetterIds::NON_COMPLIANT_ID,
                self::TO_PATIENT_COLUMN => true,
                self::MD_LIST_COLUMN => true,
                self::MD_REFERRAL_LIST_COLUMN => true,
                self::STEP_ID_COLUMN => 0,
            ],
        ],
        TrackerSteps::TREATMENT_COMPLETE_ID => [
            [
                self::LETTER_ID_COLUMN => LetterIds::TREATMENT_COMPLETE_ID,
                self::TO_PATIENT_COLUMN => true,
                self::MD_LIST_COLUMN => true,
                self::MD_REFERRAL_LIST_COLUMN => true,
                self::STEP_ID_COLUMN => 0,
            ]
        ],
        TrackerSteps::ANNUAL_RECALL_ID => [
            [
                self::LETTER_ID_COLUMN => LetterIds::ANNUAL_RECALL_ID,
                self::TO_PATIENT_COLUMN => true,
                self::MD_LIST_COLUMN => false,
                self::MD_REFERRAL_LIST_COLUMN => false,
                self::STEP_ID_COLUMN => 0,
            ],
        ],
        TrackerSteps::TERMINATION_ID => [
            [
                self::LETTER_ID_COLUMN => LetterIds::TERMINATION_ID,
                self::TO_PATIENT_COLUMN => true,
                self::MD_LIST_COLUMN => false,
                self::MD_REFERRAL_LIST_COLUMN => false,
                self::STEP_ID_COLUMN => 0,
            ]
        ],
        TrackerSteps::NOT_CANDIDATE_ID => [
            [
                self::LETTER_ID_COLUMN => LetterIds::NOT_CANDIDATE_ID,
                self::TO_PATIENT_COLUMN => false,
                self::MD_LIST_COLUMN => true,
                self::MD_REFERRAL_LIST_COLUMN => true,
                self::STEP_ID_COLUMN => 0,
            ],
        ],
    ];
}
