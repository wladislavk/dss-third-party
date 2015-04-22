<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class Intolerance extends Model
{
    protected $table = 'dental_intolerance';
    protected $fillable = ['intolerance', 'description', 'sortby', 'status'];
    protected $primaryKey = 'intoleranceid';

    public static function get($where)
    {
        $intolerance = new Intolerance();

        foreach ($where as $attribute => $value) {
            $intolerance = $intolerance->where($attribute, '=', $value);
        }

        $intolerance = $intolerance->first();

        return $intolerance;
    }
}
