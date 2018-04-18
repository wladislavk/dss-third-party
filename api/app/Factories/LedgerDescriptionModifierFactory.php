<?php

namespace DentalSleepSolutions\Factories;

use DentalSleepSolutions\Constants\Transactions;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Services\LedgerDescriptionModifiers\AbstractDescriptionModifier;
use DentalSleepSolutions\Services\LedgerDescriptionModifiers\DefaultDescriptionModifier;
use DentalSleepSolutions\Services\LedgerDescriptionModifiers\InsuranceDescriptionModifier;
use DentalSleepSolutions\Services\LedgerDescriptionModifiers\PatientDescriptionModifier;
use DentalSleepSolutions\Services\LedgerDescriptionModifiers\WriteoffDescriptionModifier;

class LedgerDescriptionModifierFactory
{
    const MODIFIERS = [
        Transactions::TRANSACTION_PAYER_PRIMARY => InsuranceDescriptionModifier::class,
        Transactions::TRANSACTION_PAYER_SECONDARY => InsuranceDescriptionModifier::class,
        Transactions::TRANSACTION_PAYER_PATIENT => PatientDescriptionModifier::class,
        Transactions::TRANSACTION_PAYER_WRITEOFF => WriteoffDescriptionModifier::class,
        Transactions::TRANSACTION_TYPE_INS => InsuranceDescriptionModifier::class,
        Transactions::TRANSACTION_TYPE_PATIENT => PatientDescriptionModifier::class,
    ];

    /**
     * @param int $type
     * @return AbstractDescriptionModifier
     * @throws GeneralException
     */
    public function getModifier($type)
    {
        $modifierClass = $this->getModifierClass($type);
        $modifier = \App::make($modifierClass);
        if (!$modifier instanceof AbstractDescriptionModifier) {
            throw new GeneralException("$modifierClass must extend " . AbstractDescriptionModifier::class);
        }
        return $modifier;
    }

    /**
     * @param string $type
     * @return string
     */
    private function getModifierClass($type)
    {
        if (array_key_exists($type, self::MODIFIERS)) {
            return self::MODIFIERS[$type];
        }
        return DefaultDescriptionModifier::class;
    }
}
