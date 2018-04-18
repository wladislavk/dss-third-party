<?php

namespace DentalSleepSolutions\Services\LetterTriggers;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Services\LetterCreator;
use DentalSleepSolutions\Structs\LetterData;
use Illuminate\Database\Eloquent\Collection;

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

    // @todo: eliminate magic numbers
    const REFERRED_SOURCE_ONE = 1;
    const REFERRED_SOURCE_TWO = 2;

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
        if (!$currentPatient) {
            return false;
        }
        $patientReferredSource = $currentPatient->referred_source;
        $contacts = $this->getPatientReferralIds($patientReferredSource, $patientId);

        if (!isset($contacts[0]) || !isset($contacts[0]->ids)) {
            return false;
        }
        $patientReferralIds = $contacts[0]->ids;
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
     * @param int $patientReferredSource
     * @param int $patientId
     * @return array|Collection
     */
    private function getPatientReferralIds($patientReferredSource, $patientId)
    {
        if ($patientReferredSource == self::REFERRED_SOURCE_ONE) {
            return $this->patientRepository
                ->getPatientReferralIdsForReferredSourceOfOne($patientId);
        }
        if ($patientReferredSource == self::REFERRED_SOURCE_TWO) {
            return $this->patientRepository
                ->getPatientReferralIdsForReferredSourceOfTwo($patientId);
        }
        return [];
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
