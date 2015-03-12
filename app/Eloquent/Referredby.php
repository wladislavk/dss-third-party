<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Referredby extends Model
{
    protected $table = 'dental_referredby';
    protected $fillable = ['docid', 'salutation', 'lastname', 'firstname', 'middlename'];
    protected $primaryKey = 'referredbyid';

    public static function get($referredbyId)
    {
        try {
            $referredby = Referredby::where('referredbyid', '=', $referredbyId)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return $referredby;
    }

    public static function updateData($referredbyId, $values)
    {
        $referredby = Referredby::where('referredbyid', '=', $referredbyId)->update($values);

        return $referredby;
    }

    public static function insertData($data)
    {
        $referredby = new Referredby();

        foreach ($data as $attribute => $value) {
            $referredby->$attribute = $value;
        }

        try {
            $referredby->save();
        } catch (QueryException $e) {
            return null;
        }

        return $referredby->referredbyid;
    }
}
