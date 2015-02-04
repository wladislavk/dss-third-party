<?php namespace Ds3\Eloquent\Ledger;

use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
	protected $table = 'dental_ledger';

	protected $primaryKey = 'ledgerid';
}