<?php

namespace DentalSleepSolutions\Services\LetterUpdaters;

use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Structs\LetterData;

class PatientReferralUpdater implements LetterUpdaterInterface
{
    /**
     * @return array
     */
    public function getUpdatedFields()
    {
        return ['pat_referral_list', 'cc_pat_referral_list'];
    }

    /**
     * @param Letter $letter
     * @param int $recipientId
     * @param LetterData $newLetterData
     * @param LetterData $dataForUpdate
     */
    public function updateDataBeforeDeleting(
        Letter $letter,
        $recipientId,
        LetterData $newLetterData,
        LetterData $dataForUpdate
    ) {
        $newLetterData->patientReferralList = $recipientId;
        $patReferrals = array_diff(explode(',', $letter->pat_referral_list), [$recipientId]);
        $ccPatReferrals = array_diff(explode(',', $letter->cc_pat_referral_list), [$recipientId]);
        $dataForUpdate->patientReferralList = implode(',', $patReferrals);
        $dataForUpdate->ccPatientReferralList = implode(',', $ccPatReferrals);
    }
}
