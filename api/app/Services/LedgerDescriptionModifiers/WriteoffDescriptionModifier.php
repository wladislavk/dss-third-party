<?php

namespace DentalSleepSolutions\Services\LedgerDescriptionModifiers;

use DentalSleepSolutions\Constants\Transactions;

class WriteoffDescriptionModifier extends AbstractDescriptionModifier
{
    protected function modifyFurther($description)
    {
        return Transactions::TRANSACTION_PAYER_LABELS[Transactions::TRANSACTION_PAYER_WRITEOFF];
    }
}
