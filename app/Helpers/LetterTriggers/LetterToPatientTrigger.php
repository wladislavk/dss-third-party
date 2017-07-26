<?php

namespace DentalSleepSolutions\Helpers\LetterTriggers;

use DentalSleepSolutions\Structs\LetterData;

class LetterToPatientTrigger extends AbstractLetterTrigger
{
    // TODO: these IDs should not be hardcoded
    const TEMPLATE_ID = 3;

    /**
     * @param int $userType
     * @return array
     */
    protected function getTemplateIds($userType)
    {
        return [self::TEMPLATE_ID];
    }

    /**
     * @param LetterData $letterData
     * @param int $patientId
     * @param int $docId
     * @param array $params
     * @return bool
     */
    protected function fillLetterData(LetterData $letterData, $patientId, $docId, array $params)
    {
        $letterData->toPatient = true;
        return true;
    }
}
