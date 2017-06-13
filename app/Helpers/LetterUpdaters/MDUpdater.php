<?php

namespace DentalSleepSolutions\Helpers\LetterUpdaters;

use DentalSleepSolutions\Eloquent\Dental\Letter;
use DentalSleepSolutions\Structs\LetterData;

// TODO: this class is never used, check if it's needed
class MDUpdater implements LetterUpdaterInterface
{
    /**
     * @return array
     */
    public function getUpdatedFields()
    {
        return ['md_list', 'cc_md_list'];
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
        $newLetterData->mdList = $recipientId;
        $mds = array_diff(explode(',', $letter->md_list), [$recipientId]);
        $ccMds = array_diff(explode(',', $letter->cc_md_list), [$recipientId]);
        $dataForUpdate->mdList = implode(',', $mds);
        $dataForUpdate->ccMdList = implode(',', $ccMds);
    }
}
