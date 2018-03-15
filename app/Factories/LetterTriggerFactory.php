<?php

namespace DentalSleepSolutions\Factories;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Helpers\IdListCleaner;
use DentalSleepSolutions\Helpers\LetterTriggers\TreatmentCompleteTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\AbstractSummaryLetterTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\AnnualRecallTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\DelayingTreatmentTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\FollowUpTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\ImpressionTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\NonCompliantTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\NotCandidateTrigger;
use DentalSleepSolutions\Helpers\SummaryLetterTriggers\TerminationTrigger;
use Illuminate\Support\Facades\App;

class LetterTriggerFactory
{
    private const IMPRESSION_ID = 4;
    private const DELAYING_TREATMENT_ID = 5;
    private const FOLLOW_UP_ID = 8;
    private const NON_COMPLIANT_ID = 9;
    private const TREATMENT_COMPLETE_ID = 11;
    private const ANNUAL_RECALL_ID = 12;
    private const TERMINATION_ID = 13;
    private const NOT_CANDIDATE_ID = 14;

    // sequence of elements matters
    private const TYPES = [
        self::IMPRESSION_ID => ImpressionTrigger::class,
        self::DELAYING_TREATMENT_ID => DelayingTreatmentTrigger::class,
        self::FOLLOW_UP_ID => FollowUpTrigger::class,
        self::NON_COMPLIANT_ID => NonCompliantTrigger::class,
        self::TREATMENT_COMPLETE_ID => TreatmentCompleteTrigger::class,
        self::ANNUAL_RECALL_ID => AnnualRecallTrigger::class,
        self::TERMINATION_ID => TerminationTrigger::class,
        self::NOT_CANDIDATE_ID => NotCandidateTrigger::class,
    ];

    /** @var IdListCleaner */
    private $idListCleaner;

    public function __construct(IdListCleaner $idListCleaner)
    {
        $this->idListCleaner = $idListCleaner;
    }

    /**
     * @param int $stepId
     * @return AbstractSummaryLetterTrigger
     * @throws GeneralException
     */
    public function getLetterTrigger(int $stepId): AbstractSummaryLetterTrigger
    {
        if (!array_key_exists($stepId, self::TYPES[$stepId])) {
            throw new GeneralException("Step ID $stepId is not valid");
        }
        $class = self::TYPES[$stepId];
        $object = App::make($class, [$this->idListCleaner]);
        if (!$object instanceof AbstractSummaryLetterTrigger) {
            throw new GeneralException("Class $class must implement " . AbstractSummaryLetterTrigger::class);
        }
        return $object;
    }
}
