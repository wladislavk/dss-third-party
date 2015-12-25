<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;

class TransactionCode extends Model
{
    protected $table = 'dental_transaction_code';
    protected $primaryKey = 'transaction_codeid';
}
