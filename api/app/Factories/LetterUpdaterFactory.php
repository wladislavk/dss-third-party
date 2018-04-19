<?php

namespace DentalSleepSolutions\Factories;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Services\Letters\LetterUpdaters\LetterUpdaterInterface;
use DentalSleepSolutions\Services\Letters\LetterUpdaters\MDReferralUpdater;
use DentalSleepSolutions\Services\Letters\LetterUpdaters\MDUpdater;
use DentalSleepSolutions\Services\Letters\LetterUpdaters\PatientReferralUpdater;
use DentalSleepSolutions\Services\Letters\LetterUpdaters\PatientUpdater;
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
        if (!array_key_exists($type, self::TYPES)) {
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
