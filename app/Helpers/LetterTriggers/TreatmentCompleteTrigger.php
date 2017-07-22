<?php

namespace DentalSleepSolutions\Helpers\LetterTriggers;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Helpers\LetterCreator;
use DentalSleepSolutions\Structs\LetterData;

class TreatmentCompleteTrigger extends AbstractLetterTrigger
{
    // TODO: these IDs should not be hardcoded
    const TEMPLATE_ID = 20;

    const TREATMENT_COMPLETE_FIELDS = [
        'referred_source',
        'docsleep',
        'docpcp',
        'docdentist',
        'docent',
        'docmdother',
        'docmdother2',
        'docmdother3',
    ];

    /** @var PatientRepository */
    private $patientRepository;

    public function __construct(
        LetterCreator $letterCreator,
        LetterRepository $letterRepository,
        PatientRepository $patientRepository
    ) {
        parent::__construct($letterCreator, $letterRepository);
        $this->patientRepository = $patientRepository;
    }

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
    protected function fillLetterData(LetterData $letterData, $patientId, $docId, array $params = [])
    {
        $currentPatient = $this->getCurrentPatient($patientId);

        $patientReferralIds = $this->patientRepository->getPatientReferralIds($patientId, $currentPatient);
        if (!$patientReferralIds) {
            return false;
        }
        $letters = $this->letterRepository->getPatientTreatmentComplete($patientId, $patientReferralIds);
        if (count($letters)) {
            return false;
        }
        $letterData->patientReferralList = $patientReferralIds;
        return true;
    }

    /**
     * @param int $patientId
     * @return Patient|null
     */
    private function getCurrentPatient($patientId)
    {
        if (!$patientId) {
            return null;
        }
        $where = ['patientid' => $patientId];
        $foundPatients = $this->patientRepository->getWithFilter(self::TREATMENT_COMPLETE_FIELDS, $where);
        // TODO: why is only first entry used? perhaps better to use first() on the model
        if (isset($foundPatients[0])) {
            return $foundPatients[0];
        }
        return null;
    }
}
