<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Helpers\LetterTriggers\LettersToMDTrigger;
use DentalSleepSolutions\Helpers\LetterTriggers\LetterToPatientTrigger;
use DentalSleepSolutions\Helpers\LetterTriggers\TreatmentCompleteTrigger;
use DentalSleepSolutions\Structs\MDContacts;

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
        $shouldSendIntro,
        MDContacts $mdContacts
    ) {
        $this->treatmentCompleteTrigger->trigger($patientId, $docId, $userId);

        $mdContactsArray = $this->formMdContacts($mdContacts);
        $params = [
            LettersToMDTrigger::MD_CONTACTS_PARAM => $mdContactsArray,
        ];
        $this->lettersToMDTrigger->trigger($patientId, $docId, $userId, $userType, $params);

        if ($shouldSendIntro) {
            $this->letterToPatientTrigger->trigger($patientId, $docId, $userId);
        }
    }

    private function formMdContacts(MDContacts $mdContacts)
    {
        $mdContacts = [];
        foreach (self::DOC_FIELDS as $field) {
            $newMdContact = 0;
            if (!empty($patientFormData[$field])) {
                $newMdContact = $patientFormData[$field];
            }
            $mdContacts[] = $newMdContact;
        }
        return $mdContacts;
    }
}
