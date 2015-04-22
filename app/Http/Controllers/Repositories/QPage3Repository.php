<?php
namespace Ds3\Repositories;

use Ds3\Contracts\QPage3Interface;
use Ds3\Eloquent\QPage3;

class QPage3Repository implements QPage3Interface
{
    public function find($patientId)
    {
        $qPage3 = QPage3::where('patientid', '=', $patientId)->first();

        return $qPage3;
    }
}
