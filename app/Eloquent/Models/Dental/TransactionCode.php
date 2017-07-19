<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

class TransactionCode extends AbstractModel
{
    protected $table = 'dental_transaction_code';
    protected $primaryKey = 'transaction_codeid';
}
