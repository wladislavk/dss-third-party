<?php
namespace Ds3\Libraries\Legacy;

function create_notification($pid, $docid, $n, $n_type, $s = 1)
{
    $db = new Db();$s = "INSERT INTO dental_notifications (patientid, docid, notification, notification_type, status, notification_date)
        VALUES
        ('".$db->escape($pid)."',
         '".$db->escape($docid)."',
         '".$db->escape($n)."',
         '".$db->escape($n_type)."',
         '".$db->escape($s)."',
         NOW())";
    $q = $db->query($s);
    return $q;
}

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
