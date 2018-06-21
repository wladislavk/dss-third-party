<?php
namespace Ds3\Libraries\Legacy;

function find_patient_notifications($p)
{
    $db = new Db();

    $s = "SELECT * FROM dental_notifications WHERE patientid='".$db->escape($p)."' AND status=1";
    $q = $db->getResults($s);

    $not = [];
    if ($q) {
        foreach ($q as $r){
            array_push($not, $r);
        }
    }
    return $not;
}
