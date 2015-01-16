<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Support\Facades\DB;

class TransactionCode extends Model
{
	protected $table = 'dental_transaction_code';

	protected $fillable = ['transaction_code', 'description', 'type', 'sortby', 'status'];

	protected $primaryKey = 'transaction_codeid';

	public $timestamps = false;

	public static function get($id)
	{
		try {
			$transactionCode = TransactionCode::where('transaction_codeid', '=', $id)->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $transactionCode;
	}

	public static function getTransactionType($docId, $code)
	{
		try {
			$transactionType = TransactionCode::select('type')->where('docid', '=', $docId)
														  	  ->where('transaction_code', '=', $code)
														 	  ->firstOrFail();
		} catch (ModelNotFoundException $e) {
			return false;
		}

		return $transactionType;
	}

	public static function getCodes($where, $order = null)
	{
		$codes = new TransactionCode();

		foreach ($where as $attribute => $value) {
			$codes = $codes->where($attribute, '=', $value);
		}

		if (!empty($order)) {
			$codes = $codes->orderBy($order);
		}

		return $codes->get();
	}

	public static function isUniqueField($field, $transactionCodeId, $docId)
	{
		reset($field);
		$attribute = key($field);
		$value = $field[$attribute];

		$transactionCode = TransactionCode::where($attribute, '=', $value)->where('transaction_codeid', '!=', $transactionCodeId)
																		  ->where('docid', '=', $docId);

		return $transactionCode->get();
	}

	public static function updateData($transactionCodeId, $values)
	{
		$transactionCode = TransactionCode::where('transaction_codeid', '=', $transactionCodeId)->update($values);

		return $transactionCode;
	}

	public static function insertData($data)
	{
		$transactionCode = new TransactionCode();

		foreach ($data as $attribute => $value) {
			$transactionCode->$attribute = $value;
		}

		try {
			$transactionCode->save();
		} catch (QueryException $e) {
			return null;
		}

		return $transactionCode->transaction_codeid;
	}
}