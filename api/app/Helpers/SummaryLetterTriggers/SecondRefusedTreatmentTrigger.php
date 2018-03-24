<?php

namespace DentalSleepSolutions\Helpers\SummaryLetterTriggers;

use DentalSleepSolutions\Constants\TrackerSteps;

class SecondRefusedTreatmentTrigger extends AbstractSummaryCompletedTrigger
{
    protected function getStepId(): int
    {
        return TrackerSteps::CONSULT_ID;
    }

    protected function getLetterId()
    {
        return 11;
    }

    protected function isToPatient()
    {
        return false;
    }

    protected function hasMdList()
    {
        return true;
    }

    protected function hasMdReferralList()
    {
        return true;
    }
}
