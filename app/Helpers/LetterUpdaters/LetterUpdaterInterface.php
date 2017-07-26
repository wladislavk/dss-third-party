<?php

namespace DentalSleepSolutions\Helpers\LetterUpdaters;

use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Structs\LetterData;

interface LetterUpdaterInterface
{
    /**
     * @return array
     */
    public function getUpdatedFields();

    /**
     * @param Letter $letter
     * @param int $recipientId
     * @param LetterData $newLetterData
     * @param LetterData $dataForUpdate
     * @return void
     */
    public function updateDataBeforeDeleting(
        Letter $letter,
        $recipientId,
        LetterData $newLetterData,
        LetterData $dataForUpdate
    );
}
