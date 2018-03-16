<?php

namespace DentalSleepSolutions\Helpers\SummaryLetterTriggers;

class SecondRefusedTreatmentTrigger extends AbstractSummaryCompletedTrigger
{
    protected function getStepId(): int
    {
        return 2;
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
