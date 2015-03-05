<?php namespace Ds3\Eloquent\Letter;

use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
	protected $table = 'dental_letters';

	protected $primaryKey = 'letterid';

	// public $timestamps = false;
}