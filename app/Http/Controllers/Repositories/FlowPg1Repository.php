<?php
namespace Ds3\Repositories;

use Illuminate\Support\Facades\DB;

use Ds3\Contracts\FlowPg1Interface;
use Ds3\Eloquent\FlowPg1;

class FlowPg1Repository implements FlowPg1Interface
{
    public function find($patientId)
    {
        $flowPg1 = FlowPg1::where('pid', '=', $patientId)->first();

        return $flowPg1;
    }

    public function updateData($id, $values)
    {
        $flowPg1 = FlowPg1::where('pid', '=', $id)->update($values);

        return $flowPg1;
    }

    public function insertData($data)
    {
        $flowPg1 = new FlowPg1();

        foreach ($data as $attribute => $value) {
            $flowPg1->$attribute = $value;
        }

        $flowPg1->save();

        return $flowPg1->id;
    }
}
