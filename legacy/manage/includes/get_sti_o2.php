<?php
namespace Ds3\Libraries\Legacy;

function getStiO2(Db $db, $patientId)
{
    $maxIdSql = "SELECT MAX(`summaryid`) AS `max_summaryid` FROM `dental_summary` WHERE `patientid`=$patientId";
    $maxIdRow = $db->getRow($maxIdSql);
    $maxId = $maxIdRow['max_summaryid'];
    $sum_sql = "select sti_o2_1 from dental_summary where summaryid=$maxId";
    $sum_myarray = $db->getRow($sum_sql);
    return st($sum_myarray['sti_o2_1']);
}
