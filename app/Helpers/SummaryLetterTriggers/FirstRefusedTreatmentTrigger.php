<?php

namespace DentalSleepSolutions\Helpers\SummaryLetterTriggers;

class FirstRefusedTreatmentTrigger extends AbstractSummaryCompletedTrigger
{
    protected function getStepId(): int
    {
        return 2;
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
