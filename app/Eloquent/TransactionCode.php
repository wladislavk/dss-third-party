<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class TransactionCode extends Model
{
    protected $table = 'dental_transaction_code';
    protected $primaryKey = 'transaction_codeid';
    //public $timestamps = false;
}
