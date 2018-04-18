<?php

namespace DentalSleepSolutions\Services;

use DentalSleepSolutions\Services\LetterTriggers\LettersToMDTrigger;
use DentalSleepSolutions\Services\LetterTriggers\LetterToPatientTrigger;
use DentalSleepSolutions\Services\LetterTriggers\TreatmentCompleteTrigger;
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
