<?php namespace Ds3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DocumentCategory extends Model
{
	protected $table = 'dental_document_category';

	protected $fillable = ['name', 'status'];

	protected $primaryKey = 'categoryid';

	public static function get()
	{
		try {
			$documentCategories = DocumentCategory::where('status', '=', 1)->orderBy('name', 'asc')->get();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $documentCategories;
	}
}