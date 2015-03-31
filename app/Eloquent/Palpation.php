<?php namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Palpation extends Model
{
    protected $table = 'dental_palpation';
    protected $fillable = ['palpation', 'sortby', 'status'];
    protected $primaryKey = 'palpationid';

    public static function get($palpationId)
    {
        try {
            $palpation = Palpation::where('palpationid', '=', $palpationId)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return $palpation;
    }

    public static function getOrderBy()
    {
        $palpations = Palpation::orderBy('sortby')->get();

        return $palpations;
    }

    public static function checkPalpation($palpation, $palpationId)
    {
        $palpations = Palpation::where('palpation', '=', $palpation)
            ->where('palpationid', '!=', $palpationId)
            ->get();

        return $palpations;
    }

    public static function updateData($palpationId, $values)
    {
        $palpation = Palpation::where('palpationid', '=', $palpationId)->update($values);

        return $palpation;
    }

    public static function insertData($data)
    {
        $palpation = new Palpation();

        foreach ($data as $attribute => $value) {
            $palpation->$attribute = $value;
        }

        try {
            $palpation->save();
        } catch (QueryException $e) {
            return null;
        }

        return $palpation->palpationid;
    }

    public static function deleteData($palpationId)
    {
        $palpation = Palpation::where('palpationid', '=', $palpationId)->delete();

        return $palpation;
    }
}
