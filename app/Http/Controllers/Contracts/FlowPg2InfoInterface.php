<?php
namespace Ds3\Contracts;

interface FlowPg2InfoInterface
{
    public function getFlowPages2Info($where, $order = null);
    public function insertData($data);
    public function updateData($patientId, $values);
}
