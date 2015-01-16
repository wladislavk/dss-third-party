<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class ClaimNote extends Model
{
	protected $table = 'dental_claim_notes';

	protected $fillable = ['claim_id', 'create_type', 'note'];

	protected $primaryKey = 'id';

	public static function get($where)
	{
		$claimNote = new ClaimNote();

		foreach ($where as $attribute => $value) {
			$claimNote = $claimNote->where($attribute, '=', $value);
		}

		try {
			$claimNote = $claimNote->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $claimNote;
	}

	public static function insertData($data)
	{
		$claimNote = new ClaimNote();

		foreach ($data as $attribute => $value) {
			$claimNote->$attribute = $value;
		}

		try {
			$claimNote->save();
		} catch (QueryException $e) {
			return null;
		}

		return $claimNote->id;
	}

	public static function updateData($ed, $values)
	{
		$claimNote = ClaimNote::where('id', '=', $ed)->update($values);

		return $claimNote;
	}
}