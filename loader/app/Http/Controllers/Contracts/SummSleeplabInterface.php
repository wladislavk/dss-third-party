<?php
namespace Ds3\Contracts;

interface SummSleeplabInterface
{
    public function getSummSleeplabs($where, $order = null);
    public function getSleepStudies($patientId, $completed = null);
    public function getPreauthSleepStudy($patientId);
    public function updateData($id, $values);
    public function insertData($data);
    public function deleteData($id);
}
