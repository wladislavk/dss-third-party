<?php
namespace Ds3\Libraries\Legacy;

// create new invoice for user and return id
function invoice_create($user_type, $user_id, $inv_type)
{
    $db = new Db();

    if ($user_type == '1') { //Front office is billed
        $sql = "INSERT INTO dental_percase_invoice SET
            docid = '".$db->escape($user_id)."',
            status = '".$db->escape(DSS_INVOICE_PENDING)."',
            invoice_type = '".$db->escape($inv_type)."',
            adddate = now(),
            ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'";
        return $db->getInsertId($sql);
    } elseif ($user_type == '2') { //Billing company is billed
        $sql = "INSERT INTO dental_percase_invoice SET
            companyid = '".$db->escape($user_id)."',
            status = '".$db->escape(DSS_INVOICE_PENDING)."',
            invoice_type = '".DSS_INVOICE_TYPE_SU_BC."',
            adddate = now(),
            ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'";
        return $db->getInsertId($sql);
    }
    return null;
}

//Find existing pending invoice for user
function invoice_find($user_type, $user_id, $inv_type = DSS_INVOICE_TYPE_SU_FO)
{
    $db = new Db();

    if ($user_type == '1') {
        $sql = "SELECT id FROM dental_percase_invoice 
            WHERE docid='".$db->escape($user_id)."'
            AND invoice_type='".$db->escape($inv_type)."'
            AND status = '".DSS_INVOICE_PENDING."'";
        $q = $db->getRow($sql);
        if (!empty($q)) {
            return $q['id'];
        } else {  // if no pending invoice create new
            return invoice_create($user_type, $user_id, $inv_type);
        }
    } elseif ($user_type == '2') {
        $sql = "SELECT id FROM dental_percase_invoice 
            WHERE companyid='".$db->escape($user_id)."'
            AND invoice_type='".DSS_INVOICE_TYPE_SU_BC."'
            AND status = '".DSS_INVOICE_PENDING."'";
        $q = $db->getRow($sql);
        if (!empty($q)) {
            return $q['id'];
        } else {  // if no pending invoice create new
            return invoice_create($user_type, $user_id, $inv_type);
        }
    }
    return null;
}

function invoice_add_efile($user_type, $user_id, $eid)
{
    $db = new Db();

    $inv_id = invoice_find($user_type, $user_id);
    $sql = "UPDATE dental_claim_electronic SET
        percase_invoice = '".$db->escape($inv_id)."'
        WHERE id='".$db->escape($eid)."'";
    return $db->query($sql);
}

function invoice_add_claim($user_type, $user_id, $eid)
{
    $db = new Db();

    $inv_id = invoice_find($user_type, $user_id, DSS_INVOICE_TYPE_BC_FO);
    $sql = "UPDATE dental_insurance SET
        percase_invoice = '".$db->escape($inv_id)."'
        WHERE insuranceid='".$db->escape($eid)."'";
    return $db->query($sql);
}

function invoice_add_e0486($user_type, $user_id, $eid)
{
    $db = new Db();

    $inv_id = invoice_find($user_type, $user_id, DSS_INVOICE_TYPE_BC_FO);
    $sql = "UPDATE dental_ledger SET
        percase_invoice = '".$db->escape($inv_id)."'
        WHERE ledgerid='".$db->escape($eid)."'";
    return $db->query($sql);
}

function invoice_add_vob($user_type, $user_id, $eid)
{
    $db = new Db();

    $inv_id = invoice_find($user_type, $user_id, DSS_INVOICE_TYPE_BC_FO);
    $sql = "UPDATE dental_insurance_preauth SET
        invoice_id = '".$db->escape($inv_id)."'
        WHERE id='".$db->escape($eid)."'";
    return $db->query($sql);
}

// create new eligibility invoice for user and return id
function invoice_eligibility_create($user_type, $user_id)
{
    $db = new Db();

    $inv_id = invoice_find($user_type, $user_id);
    $sql = "INSERT INTO dental_eligibility_invoice SET
        invoice_id = '".$db->escape($inv_id)."',
        adddate = now(),
        ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'";

    return $db->getInsertId($sql);
}

//find existing pending eligibility
function invoice_eligibility_find($user_type, $user_id)
{
    $db = new Db();

    if ($user_type == '1') {
        $sql = "SELECT ei.id FROM dental_percase_invoice i
            JOIN dental_eligibility_invoice ei ON ei.invoice_id=i.id
            WHERE i.docid='".$db->escape($user_id)."'
            AND i.status = '".DSS_INVOICE_PENDING."'";
        $q = $db->getRow($sql);
        if (!empty($q)) {
            return $q['id'];
        } else {  // if no pending invoice create new
            return invoice_eligibility_create($user_type, $user_id);
        }
    } elseif ($user_type == '2') {
        $sql = "SELECT ei.id FROM dental_percase_invoice i
            JOIN dental_eligibility_invoice ei ON ei.invoice_id=i.id
            WHERE i.companyid='".$db->escape($user_id)."'
            AND i.status = '".DSS_INVOICE_PENDING."'";
        $q = $db->getRow($sql);
        if (!empty($q)) {
            return $q['id'];
        } else {  // if no pending invoice create new
            return invoice_eligibility_create($user_type, $user_id);
        }
    }
    return null;
}

function invoice_add_eligibility($user_type, $user_id, $eid)
{
    $db = new Db();

    $inv_id = invoice_eligibility_find($user_type, $user_id);
    $sql = "UPDATE dental_eligibility SET
        eligibility_invoice_id = '".$db->escape($inv_id)."'
        WHERE id='".$db->escape($eid)."'";
    error_log($sql);
    return $db->query($sql);
}

//////////////////
//ENROLLMENTS

// create new eligibility invoice for user and return id
function invoice_enrollment_create($user_type, $user_id)
{
    $db = new Db();

    if ($user_type == '1') {
        $inv_id = invoice_find($user_type, $user_id);
        $sql = "INSERT INTO dental_enrollment_invoice SET
            invoice_id = '".$db->escape($inv_id)."',
            adddate = now(),
            ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'";
        return $db->getInsertId($sql);
    } elseif ($user_type == '2') {
        $inv_id = invoice_find($user_type, $user_id);
        $sql = "INSERT INTO dental_enrollment_invoice SET
            invoice_id = '".$db->escape($inv_id)."',
            adddate = now(),
            ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'";
        return $db->getInsertId($sql);
    }
    return null;
}

//find existing pending eligibility
function invoice_enrollment_find($user_type, $user_id)
{
    $db = new Db();

    if ($user_type == '1') {
        $sql = "SELECT ei.id FROM dental_percase_invoice i
            JOIN dental_enrollment_invoice ei ON ei.invoice_id=i.id
            WHERE i.companyid='".$db->escape($user_id)."'
            AND i.status = '".DSS_INVOICE_PENDING."'";
        $q = $db->getRow($sql);

        if (!empty($q)) {
            return $q['id'];
        } else {  // if no pending invoice create new
            return invoice_enrollment_create($user_type, $user_id);
        }
    } elseif($user_type == '2') {
        $sql = "SELECT ei.id FROM dental_percase_invoice i
            JOIN dental_enrollment_invoice ei ON ei.invoice_id=i.id
            WHERE i.docid='".$db->escape($user_id)."'
            AND i.status = '".DSS_INVOICE_PENDING."'";
        $q = $db->getRow($sql);

        if (!empty($q)) {
            return $q['id'];
        } else {  // if no pending invoice create new
            return invoice_enrollment_create($user_type, $user_id);
        }
    }
    return null;
}

function invoice_add_enrollment($user_type, $user_id, $eid)
{
    $db = new Db();

    $inv_id = invoice_enrollment_find($user_type, $user_id);
    $sql = "UPDATE dental_eligible_enrollment SET
        enrollment_invoice_id = '".$db->escape($inv_id)."'
        WHERE id='".$db->escape($eid)."'";

    return $db->query($sql);
}

// create new eligibility invoice for user and return id
function invoice_fax_create($user_type, $user_id)
{
    $db = new Db();

    if ($user_type == '1') {
        $inv_id = invoice_find($user_type, $user_id);
        $sql = "INSERT INTO dental_fax_invoice SET
            invoice_id = '".$db->escape($inv_id)."',
            adddate = now(),
            ip_address = '".$db->escape($_SERVER['REMOTE_ADDR'])."'";
        return $db->getInsertId($sql);
    }
    return null;
}

//find existing pending faxes
function invoice_fax_find($user_type, $user_id)
{
    $db = new Db();

    if ($user_type == '1') {
        $sql = "SELECT fi.id FROM dental_percase_invoice i
            JOIN dental_fax_invoice fi ON fi.invoice_id=i.id
            WHERE i.docid='".$db->escape($user_id)."'
            AND i.status = '".DSS_INVOICE_PENDING."'";
        $q = $db->getRow($sql);

        if (!empty($q)) {
            return $q['id'];
        } else {  // if no pending invoice create new
            return invoice_fax_create($user_type, $user_id);
        }
    }
    return null;
}

function invoice_add_fax($user_type, $user_id, $fid)
{
    $db = new Db();

    $inv_id = invoice_fax_find($user_type, $user_id);
    $sql = "UPDATE dental_faxes SET
        fax_invoice_id = '".$db->escape($inv_id)."'
        WHERE id='".$db->escape($fid)."'";

    return $db->query($sql);
}
