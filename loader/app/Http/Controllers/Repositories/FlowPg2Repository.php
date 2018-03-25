<?php
namespace Ds3\Repositories;

use Ds3\Contracts\FlowPg2Interface;
use Ds3\Eloquent\FlowPg2;

class FlowPg2Repository implements FlowPg2Interface
{
    public function getStep($patientId)
    {
        $step = FlowPg2::where('patientid', '=', $patientId)->first();

        return $step; 
    }

    public function updateData($patientId, $values)
    {
        $flowPg2 = FlowPg2::where('patientid', '=', $patientId)
            ->where('stepid', '=', 1)
            ->update($values);

        return $flowPg2;
    }
}
