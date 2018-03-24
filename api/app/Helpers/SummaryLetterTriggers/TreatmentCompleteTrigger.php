<?php

namespace DentalSleepSolutions\Helpers\SummaryLetterTriggers;

class TreatmentCompleteTrigger extends AbstractSummaryLetterTrigger
{
    protected function getLetterId()
    {
        return 19;
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
