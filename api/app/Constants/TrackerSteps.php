<?php

namespace DentalSleepSolutions\Constants;

interface TrackerSteps
{
    public const CONSULT_ID = 2;
    public const IMPRESSION_ID = 4;
    public const DELAYING_TREATMENT_ID = 5;
    public const REFUSED_TREATMENT_ID = 6;
    public const DEVICE_DELIVERY_ID = 7;
    public const FOLLOW_UP_ID = 8;
    public const NON_COMPLIANT_ID = 9;
    public const TREATMENT_COMPLETE_ID = 11;
    public const ANNUAL_RECALL_ID = 12;
    public const TERMINATION_ID = 13;
    public const NOT_CANDIDATE_ID = 14;

    public const STEPS_WITH_LETTERS = [
        self::IMPRESSION_ID,
        self::DELAYING_TREATMENT_ID,
        self::REFUSED_TREATMENT_ID,
        self::FOLLOW_UP_ID,
        self::NON_COMPLIANT_ID,
        self::TREATMENT_COMPLETE_ID,
        self::ANNUAL_RECALL_ID,
        self::TERMINATION_ID,
        self::NOT_CANDIDATE_ID,
    ];
}
