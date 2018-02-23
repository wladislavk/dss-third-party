<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Helpers\LetterTriggers\LettersToMDTrigger;
use DentalSleepSolutions\Helpers\LetterTriggers\LetterToPatientTrigger;
use DentalSleepSolutions\Helpers\LetterTriggers\TreatmentCompleteTrigger;
use DentalSleepSolutions\Structs\EditPatientRequestData;

class LetterTriggerLauncher
{
    /** @var TreatmentCompleteTrigger */
    private $treatmentCompleteTrigger;

    /** @var LettersToMDTrigger */
    private $lettersToMDTrigger;

    /** @var LetterToPatientTrigger */
    private $letterToPatientTrigger;

    public function __construct(
        TreatmentCompleteTrigger $treatmentCompleteTrigger,
        LettersToMDTrigger $lettersToMDTrigger,
        LetterToPatientTrigger $letterToPatientTrigger
    ) {
        $this->treatmentCompleteTrigger = $treatmentCompleteTrigger;
        $this->lettersToMDTrigger = $lettersToMDTrigger;
        $this->letterToPatientTrigger = $letterToPatientTrigger;
    }

    /**
     * @param int $patientId
     * @param int $docId
     * @param int $userId
     * @param int $userType
     * @param EditPatientRequestData $requestData
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function triggerLetters(
        $patientId,
        $docId,
        $userId,
        $userType,
        EditPatientRequestData $requestData
    ) {
        $this->treatmentCompleteTrigger->trigger($patientId, $docId, $userId);

        $params = [
            LettersToMDTrigger::MD_CONTACTS_PARAM => $requestData->mdContacts,
        ];
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId, $userType, $params);

        if ($requestData->shouldSendIntroLetter) {
            $this->letterToPatientTrigger->trigger($patientId, $docId, $userId);
        }
    }
}
