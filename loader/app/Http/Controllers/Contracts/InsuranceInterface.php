<?php
namespace Ds3\Contracts;

interface InsuranceInterface
{
    public function filterBy($where, $status = null);
    public function getPendingNodssClaims($docId, $input);
    public function getUnmailedClaims($docId, $DSS_CLAIM_PENDING, $DSS_CLAIM_SEC_PENDING);
    public function getJoin($patientId);
    public function updateData($insuranceId, $values);
    public function insertData($data);
    public function deleteData($insuranceId);
}
