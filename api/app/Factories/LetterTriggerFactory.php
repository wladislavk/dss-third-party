<?php

namespace DentalSleepSolutions\Factories;

use DentalSleepSolutions\Constants\TrackerSteps;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Helpers\IdListCleaner;
use DentalSleepSolutions\Helpers\LetterTriggers\TreatmentCompleteTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\AbstractSummaryLetterTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\AnnualRecallTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\DelayingTreatmentTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\FirstRefusedTreatmentTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\FollowUpTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\ImpressionTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\NonCompliantTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\NotCandidateTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\SecondRefusedTreatmentTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\TerminationTrigger;
use Illuminate\Support\Facades\App;

class LetterTriggerFactory
{
    // sequence of elements matters
    private const TYPES = [
        TrackerSteps::IMPRESSION_ID => ImpressionTrigger::class,
        TrackerSteps::DELAYING_TREATMENT_ID => DelayingTreatmentTrigger::class,
        TrackerSteps::REFUSED_TREATMENT_ID => [
            FirstRefusedTreatmentTrigger::class,
            SecondRefusedTreatmentTrigger::class,
        ],
        TrackerSteps::FOLLOW_UP_ID => FollowUpTrigger::class,
        TrackerSteps::NON_COMPLIANT_ID => NonCompliantTrigger::class,
        TrackerSteps::TREATMENT_COMPLETE_ID => TreatmentCompleteTrigger::class,
        TrackerSteps::ANNUAL_RECALL_ID => AnnualRecallTrigger::class,
        TrackerSteps::TERMINATION_ID => TerminationTrigger::class,
        TrackerSteps::NOT_CANDIDATE_ID => NotCandidateTrigger::class,
    ];

    /** @var IdListCleaner */
    private $idListCleaner;

    public function __construct(IdListCleaner $idListCleaner)
    {
        $this->idListCleaner = $idListCleaner;
    }

    /**
     * @param int $stepId
     * @return AbstractSummaryLetterTrigger[]
     * @throws GeneralException
     */
    public function getLetterTriggers(int $stepId): array
    {
        if (!array_key_exists($stepId, self::TYPES)) {
            throw new GeneralException("Step ID $stepId is not valid");
        }
        $classes = self::TYPES[$stepId];
        if (!is_array($classes)) {
            $classes = [$classes];
        }
        $objects = [];
        foreach ($classes as $class) {
            $object = App::make($class, [$this->idListCleaner]);
            if (!$object instanceof AbstractSummaryLetterTrigger) {
                throw new GeneralException("Class $class must implement " . AbstractSummaryLetterTrigger::class);
            }
            $objects[] = $object;
        }
        return $objects;
    }
}
