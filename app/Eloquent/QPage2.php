<?php
namespace Ds3\Eloquent;

use Illuminate\Database\Eloquent\Model;

class QPage2 extends Model
{
    protected $table = 'dental_q_page2';
    protected $fillable = ['formid', 'patientid', 'polysomnographic'];
    protected $primaryKey = 'q_page2id';

    public static function get($patientId)
    {
        $qPage2 = QPage2::where('patientid', '=', $patientId)->first();

        return $qPage2;
    }
}
