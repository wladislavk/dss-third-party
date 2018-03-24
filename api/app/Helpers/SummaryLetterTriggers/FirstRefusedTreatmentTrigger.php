<?php

namespace DentalSleepSolutions\Helpers\SummaryLetterTriggers;

use DentalSleepSolutions\Constants\TrackerSteps;

class FirstRefusedTreatmentTrigger extends AbstractSummaryCompletedTrigger
{
    protected function getStepId(): int
    {
        return TrackerSteps::CONSULT_ID;
    }

    protected function getLetterId()
    {
        return 8;
    }

    protected function isToPatient()
    {
        return true;
    }

    protected function hasMdList()
    {
        return false;
    }

    protected function hasMdReferralList()
    {
        return false;
    }
}
