<?php

namespace DentalSleepSolutions\Helpers\SummaryLetterTriggers;

class NotCandidateTrigger extends AbstractSummaryLetterTrigger
{
    protected function getLetterId()
    {
        return 7;
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
