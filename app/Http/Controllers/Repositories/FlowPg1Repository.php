<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\FlowPg1Interface;
use Ds3\Eloquent\FlowPg1;

class FlowPg1Repository implements FlowPg1Interface
{
    public function find($patientId)
    {
        try {
            $flowPg1 = FlowPg1::where('pid', '=', $patientId)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }

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

        try {
            $flowPg1->save();
        } catch (QueryException $e) {
            return null;
        }

        return $flowPg1->id;
    }
}
