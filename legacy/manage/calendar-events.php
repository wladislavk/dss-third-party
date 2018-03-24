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

$conditional = strlen($eventId) ? "dc.event_id = '$eventId'" :
    "(start_date BETWEEN '$startInterval' AND '$endInterval')
    OR (end_date BETWEEN '$startInterval' AND '$endInterval')
    OR (start_date <= '$startInterval' AND end_date >= '$endInterval')";

$sql = "SELECT dc.*, dp.firstname, dp.lastname, dt.name AS etype
    FROM dental_calendar AS dc
        LEFT JOIN dental_patients AS dp ON dc.patientid = dp.patientid
        INNER JOIN dental_appt_types AS dt ON dc.category = dt.classname
    WHERE dc.docid='$docId'
        AND dt.docid='$docId'
        AND ($conditional)
    ORDER BY dc.id ASC";
$eventList = $db->getResults($sql);

foreach ($eventList as &$event) {
    $event['description'] = preg_replace('/[\r\n]+/', ' ', $event['description']);
    $event['rec_type'] = preg_replace('/[\r\n]+/', ' ', $event['rec_type']);
    $event['rec_pattern'] = preg_replace('/[\r\n]+/', ' ', $event['rec_pattern']);

    $event = [
        'start_date' => $event['start_date'],
        'end_date' => $event['end_date'],
        'text' => $event['description'],
        'title' => $event['description'],
        'rec_type' => $event['rec_type'],
        'rec_pattern' => $event['rec_pattern'],
        'event_length' => $event['event_length'],
        'event_pid' => $event['event_pid'],
        'category' => $event['category'],
        'producer' => $event['producer_id'],
        'resource' => $event['res_id'],
        'patient' => $event['patientid'],
        'id' => $event['event_id'],
        'table_id' => $event['id'],
        'patientfn' => $event['firstname'],
        'patientln' => $event['lastname'],
        'eventtype' => $event['etype']
    ];
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
