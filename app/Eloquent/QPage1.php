<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class QPage1 extends Model
{
    protected $table = 'dental_q_page1';
    protected $fillable = ['formid', 'patientid', 'member_no'];
    protected $primaryKey = 'q_page1id';

    public static function get($patientId)
    {
        $qPage1 = QPage1::where('patientid', '=', $patientId)->first();

        return $qPage1;
    }
}
