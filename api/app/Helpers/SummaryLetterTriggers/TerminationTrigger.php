<?php

namespace DentalSleepSolutions\Helpers\SummaryLetterTriggers;

class TerminationTrigger extends AbstractSummaryLetterTrigger
{
    protected function getLetterId()
    {
        return 24;
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
