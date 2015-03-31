<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\SummSleeplabInterface;
use Ds3\Eloquent\SummSleeplab;

class SummSleeplabRepository implements SummSleeplabInterface
{
    public function getSummSleeplabs($where, $order = null)
    {
        $summSleeplab = new SummSleeplab();

        foreach ($where as $attribute => $value) {
            $summSleeplab = $summSleeplab->where($attribute, '=', $value);
        }

        if (!empty($order)) {
            $summSleeplab = $summSleeplab->orderBy(DB::raw($order), 'desc');
        }
        
        return $summSleeplab->get();
    }

    public function getSleepStudies($patientId, $completed = null)
    {
        $sleepStudies = DB::table(DB::raw('dental_summ_sleeplab ss'))
            ->join(DB::raw('dental_patients p'), 'ss.patiendid', '=', 'p.patientid')
            ->where(function($query){
                $query->where('p.p_m_ins_type', '!=', 1)
                    ->orWhere(function($query){
                        $query->where(function($query){
                          $query->whereRaw('ss.diagnosising_doc IS NOT NULL')
                                  ->where('ss.diagnosising_doc', '!=', '');
                        })
                        ->where(function($query){
                            $query->whereRaw('ss.diagnosising_npi IS NOT NULL')
                                  ->where('ss.diagnosising_npi', '!=', '');
                        });
                    });
            })
            ->where(function($query){
                $query->whereRaw('ss.diagnosis IS NOT NULL')
                      ->where('ss.diagnosis', '!=', '');
            });

        if (!empty($completed)) {
            $sleepStudies = $sleepStudies->where('ss.completed', '=', 'Yes');
        }

        $sleepStudies = $sleepStudies->whereRaw('ss.filename IS NOT NULL')
            ->where('ss.patiendid', '=', $patientId)
            ->get();

        return $sleepStudies;
    }

    public function getPreauthSleepStudy($patientId)
    {
        $sleepStudy = SummSleeplab::select('diagnosis')
            ->whereRaw("(diagnosis IS NOT NULL && diagnosis != '')")
            ->whereNotNull('filename')
            ->where('patiendid', '=', $patientId)
            ->orderBy('id', 'desc')
            ->first();

        return $sleepStudy;
    }

    public function updateData($id, $values)
    {
        $summSleeplab = SummSleeplab::where('id', '=', $id)->update($values);

        return $summSleeplab;
    }

    public function insertData($data)
    {
        $summSleeplab = new SummSleeplab();

        foreach ($data as $attribute => $value) {
            $summSleeplab->$attribute = $value;
        }

        try {
            $summSleeplab->save();
        } catch (QueryException $e) {
            return null;
        }

        return $summSleeplab->id;
    }

    public function deleteData($id)
    {
        $summSleeplab = SummSleeplab::where('id', '=', $id)->delete();

        return $summSleeplab;
    }
}
