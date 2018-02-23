<?php

namespace DentalSleepSolutions\Helpers\SummaryLetterTriggers;

class NonCompliantTrigger extends AbstractSummaryLetterTrigger
{
    protected function getLetterId()
    {
        return 17;
    }

    protected function isToPatient()
    {
        return true;
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
