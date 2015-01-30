<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class QImage extends Model
{
	protected $table = 'dental_q_image';

	protected $fillable = ['formid', 'patientid', 'title', 'image_file', 'imagetypeid', 'userid', 'docid', 'status'];

	protected $primaryKey = 'imageid';

	public static function get($imageId)
	{
		try {
			$qImage = QImage::where('imageid', '=', $imageId)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $qImage;
	}

	public static function getImage($imageTypeId, $patientId)
	{
		try {
			$image = QImage::where('imagetypeid', '=', $imageTypeId)->where('patientid', '=', $patientId)
													  	  ->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $image;
	}

	public static function insertData($data)
	{
		$qImage = new QImage();

		foreach ($data as $attribute => $value) {
			$qImage->$attribute = $value;
		}

		try {
			$qImage->save();
		} catch (QueryException $e) {
			return null;
		}

		return $qImage->imageid;
	}

	public static function updateData($where, $values)
	{
		$qImage = new QImage();

		foreach ($where as $attribute => $value) {
			$qImage = $qImage->where($attribute, '=', $value);
		}

		$qImage = $qImage->update($values);

		return $qImage;
	}
}