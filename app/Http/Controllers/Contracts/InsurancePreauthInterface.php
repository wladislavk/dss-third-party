<?php namespace Ds3\Contracts;

interface InsurancePreauthInterface
{
    public function getInsurancePreauth($where, $status = null, $order = null);
    public function getPendingPreauth($docId, $DSS_PREAUTH_PENDING);
    public function getPreauth($docId, $status);
    public function updateData($patientId, $DSS_PREAUTH_PENDING, $DSS_PREAUTH_PREAUTH_PENDING, $values);
    public function insertData($data);
}
