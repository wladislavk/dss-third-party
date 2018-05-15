<?php

namespace DentalSleepSolutions\Services\Ledger\LedgerDescriptionModifiers;

abstract class AbstractDescriptionModifier
{
    const CHECKS_TRANSACTION_DESCRIPTION = 'Checks';

    /**
     * @param string $description
     * @return string
     */
    public function modify($description)
    {
        $description = $this->modifyByDescriptionChecks($description);
        return $this->modifyFurther($description);
    }

    /**
     * @param string $description
     * @return string
     */
    abstract protected function modifyFurther($description);

    /**
     * @param string $description
     * @return string
     */
    private function modifyByDescriptionChecks($description)
    {
        $regexp = '/^checks?$/i';
        if (preg_match($regexp, $description)) {
            return self::CHECKS_TRANSACTION_DESCRIPTION;
        }
        return $description;
    }
}
