<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/../admin/includes/main_include.php';

function similar_doctors($id)
{
    $db = new Db();

    $id = intval($id);
    $docId = intval($_SESSION['docid']);

    $s = "SELECT * from dental_patient_contacts WHERE id='$id'";
    $r = $db->getRow($s);

    $r = array_map([$db, 'escape'], $r);

    $s2 = "SELECT firstname, lastname, add1, city, state, zip
        FROM dental_contact
        WHERE docid = '$docId'
            AND contacttypeid != '11'
            AND (
                (
                    (
                        IFNULL(firstname, '') != ''
                        OR IFNULL(lastname, '') != ''
                    )
                    AND IFNULL(firstname, '') = '{$r['firstname']}'
                    AND IFNULL(lastname, '') = '{$r['lastname']}'
                )
                OR (
                    (
                        IFNULL(add1, '') != ''
                        OR IFNULL(city, '') != ''
                        OR IFNULL(state, '') != ''
                        OR IFNULL(zip, '') != ''
                    )
                    AND IFNULL(add1, '') = '{$r['add1']}'
                    AND IFNULL(city, '') = '{$r['city']}'
                    AND IFNULL(state, '') = '{$r['state']}'
                    AND IFNULL(zip, '') = '{$r['zip']}'
                )
            )";

    $q2 = $db->getResults($s2);
    $docs = [];
    $c = 0;

    foreach ($q2 as $r2) {
        $docs[$c]['id'] = $r2['contactid'];
        $docs[$c]['name'] = $r2['firstname']. " " .$r2['lastname'];
        $docs[$c]['address'] = $r2['add1']. " " . $r2['add2']. " " . $r2['city']. " " . $r2['state']. " " . $r2['zip'];
        $docs[$c]['phone'] = $r2['phone1'];
        $c++;
    }

    return $docs;
}

function similar_contacts($id)
{
    $db = new Db();

    $id = intval($id);
    $docId = intval($_SESSION['docid']);

    $s = "SELECT firstname, lastname, company, add1, city, state, zip
        FROM dental_contact
        WHERE contactid = '$id'";
    $r = $db->getRow($s);

    $r = array_map([$db, 'escape'], $r);

    $s2 = "SELECT firstname, lastname, company, add1, city, state, zip, phone1
        FROM dental_contact
        WHERE docid = '$docId'
            AND status IN (1, 2)
            AND contactid != '$id'
            AND (
                (
                    IFNULL(company, '') != ''
                    AND IFNULL(company, '') = '{$r['company']}'
                )
                OR (
                    (
                        IFNULL(firstname, '') != ''
                        OR IFNULL(lastname, '') != ''
                    )
                    AND IFNULL(firstname, '') = '{$r['firstname']}'
                    AND IFNULL(lastname, '') = '{$r['lastname']}'
                )
                OR (
                    (
                        IFNULL(add1, '') != ''
                        OR IFNULL(city, '') != ''
                        OR IFNULL(state, '') != ''
                        OR IFNULL(zip, '') != ''
                    )
                    AND IFNULL(add1, '') = '{$r['add1']}'
                    AND IFNULL(city, '') = '{$r['city']}'
                    AND IFNULL(state, '') = '{$r['state']}'
                    AND IFNULL(zip, '') = '{$r['zip']}'
                )
            )";

    $q2 = $db->getResults($s2);
    $docs = [];
    $c = 0;

    foreach ($q2 as $r2) {
        $docs[$c]['id'] = $r2['contactid'];
        $docs[$c]['name'] = $r2['firstname']. " " .$r2['lastname'];
        $docs[$c]['company'] = $r2['company'];
        $docs[$c]['address'] = $r2['add1']. " " . $r2['add2']. " " . $r2['city']. " " . $r2['state']. " " . $r2['zip'];
        $docs[$c]['phone1'] = $r2['phone1'];
        $c++;
    }

    return $docs;
}

function similar_patients($id)
{
    $db = new Db();

    $id = intval($id);
    $docId = intval($_SESSION['docid']);

    $s = "SELECT firstname, lastname, add1, city, state, zip
        FROM dental_patients
        WHERE patientid = '$id'";
    $r = $db->getRow($s);

    array_walk($r, function (&$each) use ($db) {
        $each = $db->escape($each);
    });

    $s2 = "SELECT patientid, firstname, lastname, add1, add2, city, state, zip, home_phone
        FROM dental_patients
        WHERE docid = '$docId'
            AND status IN (1)
            AND patientid != '$id'
            AND (
                (
                    (
                        IFNULL(firstname, '') != ''
                        OR IFNULL(lastname, '') != ''
                    )
                    AND IFNULL(firstname, '') = '{$r['firstname']}'
                    AND IFNULL(lastname, '') = '{$r['lastname']}'
                )
                OR (
                    (
                        IFNULL(add1, '') != ''
                        OR IFNULL(city, '') != ''
                        OR IFNULL(state, '') != ''
                        OR IFNULL(zip, '') != ''
                    )
                    AND IFNULL(add1, '') = '{$r['add1']}'
                    AND IFNULL(city, '') = '{$r['city']}'
                    AND IFNULL(state, '') = '{$r['state']}'
                    AND IFNULL(zip, '') = '{$r['zip']}'
                )
            )";

    $q2 = $db->getResults($s2);
    $docs = [];
    $c = 0;

    foreach ($q2 as $r2) {
        $docs[$c]['id'] = $r2['patientid'];
        $docs[$c]['name'] = $r2['firstname']. " " .$r2['lastname'];
        $docs[$c]['address'] = $r2['add1']. " " . $r2['add2']. " " . $r2['city']. " " . $r2['state']. " " . $r2['zip'];
        $docs[$c]['phone'] = $r2['home_phone'];
        $c++;
    }

    return $docs;
}

function similar_insurance($id)
{
    $db = new Db();

    $id = intval($id);
    $docId = intval($_SESSION['docid']);

    $s = "SELECT company, address1, city, state, zip
        FROM dental_patient_insurance
        WHERE id = '$id'";
    $r = $db->getRow($s);

    array_walk($r, function (&$each) use ($db) {
        $each = $db->escape($each);
    });

    $s2 = "SELECT contactid, company, add1, add2, city, state, zip, phone1
        FROM dental_contact
        WHERE docid = '$docId'
            AND contacttypeid =  '11'
            AND (
                (
                    IFNULL(company, '') != ''
                    AND company LIKE '%{$r['company']}%'
                )
                OR (
                    (
                        IFNULL(add1, '') != ''
                        OR IFNULL(city, '') != ''
                        OR IFNULL(state, '') != ''
                        OR IFNULL(zip, '') != ''
                    )
                    AND IFNULL(add1, '') = '{$r['add1']}'
                    AND IFNULL(city, '') = '{$r['city']}'
                    AND IFNULL(state, '') = '{$r['state']}'
                    AND IFNULL(zip, '') = '{$r['zip']}'
                )
            )";

    $q2 = $db->getResults($s2);
    $docs = [];
    $c = 0;
    if ($q2) {
        foreach($q2 as $r2){
            $docs[$c]['id'] = $r2['contactid'];
            $docs[$c]['name'] = $r2['company'];
            $docs[$c]['address'] = $r2['add1']. " " . $r2['add2']. " " . $r2['city']. " " . $r2['state']. " " . $r2['zip'];
            $docs[$c]['phone'] = $r2['phone1'];
            $c++;
        }
    }

    return $docs;
}
