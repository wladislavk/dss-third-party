<?php

namespace DentalSleepSolutions\Helpers\SummaryLetterTriggers;

class ImpressionTrigger extends AbstractSummaryLetterTrigger
{
    protected function getLetterId()
    {
        return 9;
    }

    protected function isToPatient()
    {
        return false;
    }

    protected function hasMdList()
    {
        return false;
    }

    protected function hasMdReferralList()
    {
        return true;
    }
}
