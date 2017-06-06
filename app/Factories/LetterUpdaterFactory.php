<?php

namespace DentalSleepSolutions\Factories;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Helpers\LetterUpdaters\LetterUpdaterInterface;
use DentalSleepSolutions\Helpers\LetterUpdaters\MDReferralUpdater;
use DentalSleepSolutions\Helpers\LetterUpdaters\MDUpdater;
use DentalSleepSolutions\Helpers\LetterUpdaters\PatientReferralUpdater;
use DentalSleepSolutions\Helpers\LetterUpdaters\PatientUpdater;
use Illuminate\Support\Facades\App;

class LetterUpdaterFactory
{
    const TYPES = [
        'patient' => PatientUpdater::class,
        'md' => MDUpdater::class,
        'md_referral' => MDReferralUpdater::class,
        'pat_referral' => PatientReferralUpdater::class,
    ];

    /**
     * @param string $type
     * @return LetterUpdaterInterface
     * @throws GeneralException
     */
    public function getLetterUpdater($type)
    {
        if (!isset(self::TYPES[$type])) {
            throw new GeneralException("Type $type is not valid");
        }
        $class = self::TYPES[$type];
        $object = App::make($class);
        if (!$object instanceof LetterUpdaterInterface) {
            throw new GeneralException("Class $class must implement " . LetterUpdaterInterface::class);
        }
        return $object;
    }
}
