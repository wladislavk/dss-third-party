<?php

namespace DentalSleepSolutions\Helpers\SummaryLetterTriggers;

class SecondRefusedTreatmentTrigger extends AbstractSummaryLetterTrigger
{
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
