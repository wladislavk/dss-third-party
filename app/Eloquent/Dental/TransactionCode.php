<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;

class TransactionCode extends AbstractModel
{
    protected $table = 'dental_transaction_code';
    protected $primaryKey = 'transaction_codeid';
}
