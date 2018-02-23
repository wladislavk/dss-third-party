<?php

namespace DentalSleepSolutions\Helpers\SummaryLetterTriggers;

class FirstRefusedTreatmentTrigger extends AbstractSummaryLetterTrigger
{
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
