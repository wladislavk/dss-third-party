<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Ds3\Contracts\InsurancePreauthInterface;
use Ds3\Eloquent\Insurance\InsurancePreauth;

class InsurancePreauthRepository implements InsurancePreauthInterface
{
    public function get($where, $status = null, $order = null)
    {
        $insurancePreauth = new InsurancePreauth();

        foreach ($where as $attribute => $value) {
            $insurancePreauth = $insurancePreauth->where($attribute, '=', $value);
        }

        if (!empty($status)) {
            $insurancePreauth = $insurancePreauth->whereRaw('(status IN (' . $status . '))');
        }

        if (!empty($order)) {
            $insurancePreauth = $insurancePreauth->orderBy($order, 'desc');
        }

        return $insurancePreauth->get();
    }

    public function getPendingPreauth($docId, $DSS_PREAUTH_PENDING)
    {
        $pendingPreauth = InsurancePreauth::where('doc_id', '=', $docId)
            ->where('status', '=', $DSS_PREAUTH_PENDING)->get();

        return $pendingPreauth;
    }

    public function getPreauth($docId, $status)
    {
        $rejectedPreauth = InsurancePreauth::where('doc_id', '=', $docId)
            ->where('status', '=', $status)
            ->where(function($query){
                $query->whereNull('viewed')
                      ->orWhere('viewed', '!=', 1);
            })
            ->get();

        return $rejectedPreauth;
    }

    public function updateData($patientId, $DSS_PREAUTH_PENDING, $DSS_PREAUTH_PREAUTH_PENDING, $values)
    {
        $insurancePreauth = InsurancePreauth::where('patient_id', '=', $patientId)
            ->whereRaw('(status = ' . $DSS_PREAUTH_PENDING . ' OR status = ' . $DSS_PREAUTH_PREAUTH_PENDING . ')')
            ->update($values);

        return $insurancePreauth;
    }

    public function insertData($data)
    {
        $insurancePreauth = new InsurancePreauth();

        foreach ($data as $attribute => $value) {
            $insurancePreauth->$attribute = $value;
        }

        try {
            $insurancePreauth->save();
        } catch (ModelNotFoundException $e) {
            return null;
        }

        return $insurancePreauth->id;
    }
}
