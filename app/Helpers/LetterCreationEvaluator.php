<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Structs\LetterData;

// TODO: the logic of this class is extremely hard to understand. it needs to be thoroughly checked
// TODO: and clarified in the code
class LetterCreationEvaluator
{
    // TODO: why are they special? this data should be in the DB
    const SPECIAL_TEMPLATE_IDS = [16, 19];

    /**
     * @param LetterData $letterData
     * @param int $templateId
     * @return bool
     */
    public function shouldLetterBeCreated(LetterData $letterData, $templateId)
    {
        $condition1 = $this->evaluateFirstCondition($letterData);
        $condition2 = $this->evaluateSecondCondition($letterData, $templateId);
        if ($condition1 || $condition2) {
            return false;
        }
        return true;
    }

    /**
     * @param LetterData $letterData
     * @return bool
     */
    private function evaluateFirstCondition(LetterData $letterData)
    {
        if ($letterData->toPatient) {
            return false;
        }
        if ($letterData->mdReferralList) {
            return false;
        }
        if ($letterData->mdList) {
            return false;
        }
        if ($letterData->patientReferralList) {
            return false;
        }
        return true;
    }

    /**
     * @param LetterData $letterData
     * @param int $templateId
     * @return bool
     */
    private function evaluateSecondCondition(LetterData $letterData, $templateId)
    {
        if (!$letterData->checkRecipient) {
            return false;
        }
        if ($letterData->mdReferralList) {
            return false;
        }
        if ($letterData->mdList) {
            return false;
        }
        if (!in_array($templateId, self::SPECIAL_TEMPLATE_IDS)) {
            return false;
        }
        return true;
    }
}
