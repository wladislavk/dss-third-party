<?php namespace Ds3\Contracts;

interface LedgerInterface
{
    public function getClaim($primaryClaimId);
    public function getNumTransactions($id);
    public function getSum($patientId);
    public function getPendingClaims($where);
    public function getNumRecords($primaryClaimId, $ledgerIds);
    public function insertData($data);
    public function updateData($where, $values);
    public function updatePrimaryClaimId($id, $ledgerIds, $primaryClaimId);
    public function deleteData($where);
}
