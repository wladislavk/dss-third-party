<?php

namespace DentalSleepSolutions\Services\Ledger\LedgerDescriptionModifiers;

use DentalSleepSolutions\Constants\Transactions;

class WriteoffDescriptionModifier extends AbstractDescriptionModifier
{
    protected function modifyFurther($description)
    {
        return Transactions::TRANSACTION_PAYER_LABELS[Transactions::TRANSACTION_PAYER_WRITEOFF];
    }
}
