<?php

namespace DentalSleepSolutions\Helpers\SummaryLetterTriggers;

class AnnualRecallTrigger extends AbstractSummaryLetterTrigger
{
    protected function getLetterId()
    {
        return 21;
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
