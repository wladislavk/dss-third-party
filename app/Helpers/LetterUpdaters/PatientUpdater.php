<?php

namespace DentalSleepSolutions\Helpers\LetterUpdaters;

use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Structs\LetterData;

// TODO: this class is never used, check if it's needed
class PatientUpdater implements LetterUpdaterInterface
{
    /**
     * @return array
     */
    public function getUpdatedFields()
    {
        return ['topatient', 'cc_topatient'];
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
        $newLetterData->toPatient = true;
        $dataForUpdate->toPatient = false;
        $dataForUpdate->ccToPatient = false;
    }
}
