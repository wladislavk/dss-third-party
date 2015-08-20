<?php namespace Ds3\Libraries\Legacy; ?><?php

use Carbon\Carbon;

include __DIR__ . '/admin/includes/main_include.php';
include __DIR__ . '/includes/sescheck.php';

$docId = intval($_SESSION['docid']);
$eventId = !empty($_GET['eid']) ? preg_replace('/\D+/', '', $_GET['eid']) : '';
$referenceDate = Carbon::today();
$startInterval = !empty($_GET['from']) ? $db->escape($_GET['from']) . ' 00:00:00' :
    $referenceDate->copy()->startOfMonth()->subWeek()->toDateTimeString();
$endInterval = !empty($_GET['to']) ? $db->escape($_GET['to']) . ' 23:59:59' :
    $referenceDate->copy()->endOfMonth()->subWeek()->toDateTimeString();

$sql = "SELECT dc.*, dp.firstname, dp.lastname, dt.name AS etype
    FROM dental_calendar AS dc
        LEFT JOIN dental_patients AS dp ON dc.patientid = dp.patientid
        INNER JOIN dental_appt_types AS dt ON dc.category = dt.classname
    WHERE dc.docid='$docId'
        AND dt.docid='$docId'
        AND (
            dc.event_id = '$eventId'
            OR (
                '' = '$eventId'
                AND (
                    (start_date BETWEEN '$startInterval' AND '$endInterval')
                    OR (end_date BETWEEN '$startInterval' AND '$endInterval')
                    OR (start_date <= '$startInterval' AND end_date >= '$endInterval')
                )
            )
        )
    ORDER BY dc.id ASC";
$eventList = $db->getResults($sql);

foreach ($eventList as &$event) {
    // $event['start_date'] = date('d/m/Y H:i', strtotime($event['start_date']));
    // $event['end_date'] = date('d/m/Y H:i', strtotime($event['end_date']));

    $event['description'] = preg_replace('/[\r\n]+/', ' ', $event['description']);
    $event['rec_type'] = preg_replace('/[\r\n]+/', ' ', $event['rec_type']);
    $event['rec_pattern'] = preg_replace('/[\r\n]+/', ' ', $event['rec_pattern']);

    unset($event['ip_address']);
}

function safeJsonEncode ($object) {
    if (is_array($object)) {
        array_walk_recursive($object, function(&$value){
            if (is_string($value)) {
                $value = utf8_encode($value);
            }
        });
    } elseif (is_string($object)) {
        $object = utf8_encode($object);
    }

    return json_encode($object);
}

header('Content-Type: text/json');

echo safeJsonEncode($eventList);
