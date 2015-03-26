<?php
namespace Ds3\Repositories;

use Ds3\Contracts\InsurancePreauthInterface;
use Ds3\Eloquent\Insurance\InsurancePreauth;

class InsurancePreauthRepository implements InsurancePreauthInterface
{
    public function getInsurancePreauth($where, $status = null, $order = null)
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
            ->nonViewed()
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

        $insurancePreauth->save();

        return $insurancePreauth->id;
    }
}
