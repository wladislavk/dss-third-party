<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Imagetype extends Model
{
	protected $table = 'dental_imagetype';

	protected $fillable = ['imagetype', 'description', 'sortby', 'status'];

	protected $primaryKey = 'imagetypeid';

	public static function get()
	{
		$imagetypes = Imagetype::where('status', '=', 1)->orderBy('sortby')
													    ->get();

		return $imagetypes;
	}
}