<?php

namespace DentalSleepSolutions\Helpers\SummaryLetterTriggers;

class FollowUpTrigger extends AbstractSummaryLetterTrigger
{
    protected function getLetterId()
    {
        return 16;
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
