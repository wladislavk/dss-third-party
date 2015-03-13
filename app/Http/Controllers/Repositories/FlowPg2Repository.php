<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Ds3\Contracts\FlowPg2Interface;
use Ds3\Eloquent\FlowPg2;

class FlowPg2Repository implements FlowPg2Interface
{
    public function getStep($patientId)
    {
        try {
            $step = FlowPg2::where('patientid', '=', $patientId)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }

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
