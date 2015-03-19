<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\FlowPg2InfoInterface;
use Ds3\Eloquent\FlowPg2Info;

class FlowPg2Inforepository implements FlowPg2InfoInterface
{
    public function getFlowPages2Info($where, $order = null)
    {
        $flowPg2Info = new FlowPg2Info();

        foreach ($where as $attribute => $value) {
            $flowPg2Info = $flowPg2Info->where($attribute, '=', $value);
        }

        if (!empty($order)) {
            foreach ($order as $attribute) {
                $flowPg2Info = $flowPg2Info->orderBy($attribute, 'desc');
            }
        }

        return $flowPg2Info->get();
    }

    public function insertData($data)
    {
        $flowPg2Info = new FlowPg2Info();

        foreach ($data as $attribute => $value) {
            $flowPg2Info->$attribute = $value;
        }

        try {
            $flowPg2Info->save();
        } catch (QueryException $e) {
            return null;
        }

        return $flowPg2Info->id;
    }

    public function updateData($patientId, $values)
    {
        $flowPg2Info = FlowPg2Info::where('patientid', '=', $patientId)
            ->where('stepid', '=', 1)
            ->update($values);

        return $flowPg2Info;
    }
}
