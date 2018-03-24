<?php

namespace DentalSleepSolutions\Helpers\SummaryLetterTriggers;

use DentalSleepSolutions\Constants\TrackerSteps;

class FollowUpTrigger extends AbstractSummaryCompletedTrigger
{
    protected function getStepId(): int
    {
        return TrackerSteps::DEVICE_DELIVERY_ID;
    }

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
