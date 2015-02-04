<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Qualifier extends Model
{
	protected $table = 'dental_qualifier';

	protected $fillable = ['qualifier', 'sortby', 'status'];

	protected $primaryKey = 'qualifierid';

	public static function getQualifiers()
	{
		$qualifiers = Qualifier::where('status', '=', 1)->orderBy('sortby')
														->get();

		return $qualifiers;
	}
}