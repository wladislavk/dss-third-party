<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class ExPage5 extends Model
{
    protected $table = 'dental_ex_page5';
    protected $fillable = ['formid', 'patientid', 'palpationid'];
    protected $primaryKey = 'ex_page5id';

    public static function get($where)
    {
        $exPage5 = new ExPage5();

        foreach ($where as $attribute => $value) {
            $exPage5 = $exPage5->where($attribute, '=', $value);
        }

        return $exPage5->get();
    }
}
