<?php

namespace DentalSleepSolutions\Helpers\LetterUpdaters;

use DentalSleepSolutions\Eloquent\Dental\Letter;
use DentalSleepSolutions\Structs\LetterData;

class MDReferralUpdater implements LetterUpdaterInterface
{
    /**
     * @return array
     */
    public function getUpdatedFields()
    {
        return ['md_referral_list', 'cc_md_referral_list'];
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
        $newLetterData->mdReferralList = $recipientId;
        $mdReferrals = array_diff(explode(',', $letter->md_referral_list), [$recipientId]);
        $ccMdReferrals = array_diff(explode(',', $letter->cc_md_referral_list), [$recipientId]);
        $dataForUpdate->mdReferralList = implode(',', $mdReferrals);
        $dataForUpdate->ccMdReferralList = implode(',', $ccMdReferrals);
    }
}
