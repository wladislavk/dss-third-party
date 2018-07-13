<?php
namespace Ds3\Libraries\Legacy;

include '../../manage/admin/includes/main_include.php';
include '../../manage/includes/constants.inc';
require_once '../../manage/includes/general_functions.php';

linkRequestData('dental_patients', $_SESSION['pid']);

$db = new Db();

$chksql = "SELECT patientid FROM dental_patients WHERE parent_patientid='".mysqli_escape_string($con, $_SESSION['pid'])."'";
$chkq = mysqli_query($con, $chksql);
$chkc = mysqli_num_rows($chkq);

$dob = ($_POST['dob_month'] != '' && $_POST['dob_day'] != '' && $_POST['dob_year'] != '')?date('m/d/Y', mktime(0,0,0,$_POST['dob_month'],$_POST['dob_day'],$_POST['dob_year'])):'';
$ins_dob = ($_POST['ins_dob_month'] != '' && $_POST['ins_dob_day'] != '' && $_POST['ins_dob_year'] != '')?date('m/d/Y', mktime(0,0,0,$_POST['ins_dob_month'],$_POST['ins_dob_day'],$_POST['ins_dob_year'])):'';
$ins2_dob = ($_POST['ins2_dob_month'] != '' && $_POST['ins2_dob_day'] != '' && $_POST['ins2_dob_year'] != '')?date('m/d/Y', mktime(0,0,0,$_POST['ins2_dob_month'],$_POST['ins2_dob_day'],$_POST['ins2_dob_year'])):'';
if($_POST['p_m_ins_type']!=''){
    $p_m_ins_type = ($_POST['p_m_ins_type']==1)?$_POST['p_m_ins_type']:'7';
}else{
    $p_m_ins_type = '';
}
if($chkc == 0){
    $sql = "INSERT INTO dental_patients set
        firstname = '".$db->escape( $_POST['firstname'])."',
        middlename= '".$db->escape( $_POST['middlename'])."',
        lastname= '".$db->escape( $_POST['lastname'])."',
        preferred_name= '".$db->escape( $_POST['preferred_name'])."',
        email= '".$db->escape( $_POST['email'])."',
        home_phone = '".$db->escape( num($_POST['home_phone']))."',
        work_phone = '".$db->escape( num($_POST['work_phone']))."',
        cell_phone = '".$db->escape( num($_POST['cell_phone']))."',
        add1 = '".$db->escape( $_POST['add1'])."',
        add2 = '".$db->escape( $_POST['add2'])."',
        city = '".$db->escape( $_POST['city'])."',
        state = '".$db->escape( $_POST['state'])."',
        zip = '".$db->escape( $_POST['zip'])."',
        dob = '".$db->escape( $dob)."',
        gender = '".$db->escape( $_POST['gender'])."',
        marital_status = '".$db->escape( $_POST['marital_status'])."',
        partner_name = '".$db->escape( $_POST['partner_name'])."',
        ssn = '".$db->escape( num($_POST['ssn'], false))."',
        preferredcontact = '".$db->escape( $_POST['preferredcontact'])."',
        feet = '".$db->escape( $_POST['feet'])."',
        inches = '".$db->escape( $_POST['inches'])."',
        weight = '".$db->escape( $_POST['weight'])."',
        bmi = '".$db->escape( $_POST['bmi'])."',
        emergency_name = '".$db->escape( $_POST['emergency_name'])."',
        emergency_relationship = '".$db->escape( $_POST['emergency_relationship'])."',
        emergency_number = '".$db->escape( num($_POST['emergency_number']))."',
        p_m_relation = '".$db->escape( $_POST['p_m_relation'])."',
        p_m_partyfname = '".$db->escape( $_POST['p_m_partyfname'])."',
        p_m_partymname = '".$db->escape( $_POST['p_m_partymname'])."',
        p_m_partylname = '".$db->escape( $_POST['p_m_partylname'])."',
        p_m_gender = '".$db->escape( $_POST['p_m_gender'])."',
        ins_dob = '".$db->escape( $ins_dob)."',
        p_m_ins_co = '".$db->escape( $_POST['p_m_ins_co'])."',
        p_m_ins_id = '".$db->escape( $_POST['p_m_ins_id'])."',
        p_m_ins_grp = '".$db->escape( $_POST['p_m_ins_grp'])."',
        p_m_ins_plan = '".$db->escape( $_POST['p_m_ins_plan'])."',";
    if ($p_m_ins_type!='') {
        $sql .= " p_m_ins_type = '".$db->escape( $p_m_ins_type)."', ";
    }
    $sql .= "
        has_p_m_ins = '".$db->escape( $_POST['has_p_m_ins'])."',
        has_s_m_ins = '".$db->escape( $_POST['has_s_m_ins'])."',
        s_m_relation = '".$db->escape( $_POST['s_m_relation'])."',
        s_m_partyfname = '".$db->escape( $_POST['s_m_partyfname'])."',
        s_m_partymname = '".$db->escape( $_POST['s_m_partymname'])."',
        s_m_partylname = '".$db->escape( $_POST['s_m_partylname'])."',
        s_m_gender = '".$db->escape( $_POST['s_m_gender'])."',
        ins2_dob = '".$db->escape( $ins2_dob)."',
        s_m_ins_co = '".$db->escape( $_POST['s_m_ins_co'])."',
        s_m_ins_id = '".$db->escape( $_POST['s_m_ins_id'])."',
        s_m_ins_grp = '".$db->escape( $_POST['s_m_ins_grp'])."',
        s_m_ins_plan = '".$db->escape( $_POST['s_m_ins_plan'])."',";
    if ($_POST['has_s_m_ins']=="Yes") {
        $sql .= " s_m_ins_type = '7', ";
    }
    $sql .= "
        employer = '".$db->escape( $_POST['employer'])."',
        emp_add1 = '".$db->escape( $_POST['emp_add1'])."',
        emp_add2 = '".$db->escape( $_POST['emp_add2'])."',
        emp_city = '".$db->escape( $_POST['emp_city'])."',
        emp_state = '".$db->escape( $_POST['emp_state'])."',
        emp_zip = '".$db->escape( $_POST['emp_zip'])."',
        emp_phone = '".$db->escape( num($_POST['emp_phone']))."',
        emp_fax = '".$db->escape( num($_POST['emp_fax']))."',
        docsleep = '".$db->escape( $_POST['pc_1_contactid'])."',
        docpcp = '".$db->escape( $_POST['pc_2_contactid'])."',
        docdentist = '".$db->escape( $_POST['pc_3_contactid'])."',
        docent = '".$db->escape( $_POST['pc_4_contactid'])."',
        docmdother = '".$db->escape( $_POST['pc_5_contactid'])."',
        registered = '1',
        parent_patientid='".$db->escape( $_SESSION['pid'])."'
    ";
}else{
    $sql = "UPDATE dental_patients set
        firstname = '".$db->escape( $_POST['firstname'])."',
        middlename= '".$db->escape( $_POST['middlename'])."',
        lastname= '".$db->escape( $_POST['lastname'])."',
        preferred_name= '".$db->escape( $_POST['preferred_name'])."',
        email= '".$db->escape( $_POST['email'])."',
        home_phone = '".$db->escape( num($_POST['home_phone']))."',
        work_phone = '".$db->escape( num($_POST['work_phone']))."',
        cell_phone = '".$db->escape( num($_POST['cell_phone']))."',
        add1 = '".$db->escape( $_POST['add1'])."',
        add2 = '".$db->escape( $_POST['add2'])."',
        city = '".$db->escape( $_POST['city'])."',
        state = '".$db->escape( $_POST['state'])."',
        zip = '".$db->escape( $_POST['zip'])."',
        dob = '".$db->escape( $dob)."',
        gender = '".$db->escape( $_POST['gender'])."',
        marital_status = '".$db->escape( $_POST['marital_status'])."',
        partner_name = '".$db->escape( $_POST['partner_name'])."',
        ssn = '".$db->escape( num($_POST['ssn'], false))."',
        preferredcontact = '".$db->escape( $_POST['preferredcontact'])."',
        feet = '".$db->escape( $_POST['feet'])."',
        inches = '".$db->escape( $_POST['inches'])."',
        weight = '".$db->escape( $_POST['weight'])."',
        bmi = '".$db->escape( $_POST['bmi'])."',
        emergency_name = '".$db->escape( $_POST['emergency_name'])."',
        emergency_relationship = '".$db->escape( $_POST['emergency_relationship'])."',
        emergency_number = '".$db->escape( num($_POST['emergency_number']))."',
        p_m_relation = '".$db->escape( $_POST['p_m_relation'])."',
        p_m_partyfname = '".$db->escape( $_POST['p_m_partyfname'])."',
        p_m_partymname = '".$db->escape( $_POST['p_m_partymname'])."',
        p_m_partylname = '".$db->escape( $_POST['p_m_partylname'])."',
        p_m_gender = '".$db->escape( $_POST['p_m_gender'])."',
        ins_dob = '".$db->escape( $ins_dob)."',
        p_m_ins_co = '".$db->escape( $_POST['p_m_ins_company'])."',
        p_m_ins_id = '".$db->escape( $_POST['p_m_ins_id'])."',
        p_m_ins_grp = '".$db->escape( $_POST['p_m_ins_grp'])."',
        p_m_ins_plan = '".$db->escape( $_POST['p_m_ins_plan'])."',
        p_m_ins_type = '".$db->escape( $p_m_ins_type)."',
        has_p_m_ins = '".$db->escape( $_POST['has_p_m_ins'])."',
        has_s_m_ins = '".$db->escape( $_POST['has_s_m_ins'])."',
        s_m_relation = '".$db->escape( $_POST['s_m_relation'])."',
        s_m_partyfname = '".$db->escape( $_POST['s_m_partyfname'])."',
        s_m_partymname = '".$db->escape( $_POST['s_m_partymname'])."',
        s_m_partylname = '".$db->escape( $_POST['s_m_partylname'])."',
        s_m_gender = '".$db->escape( $_POST['s_m_gender'])."',
        ins2_dob = '".$db->escape( $ins2_dob)."',
        s_m_ins_co = '".$db->escape( $_POST['s_m_ins_company'])."',
        s_m_ins_id = '".$db->escape( $_POST['s_m_ins_id'])."',
        s_m_ins_grp = '".$db->escape( $_POST['s_m_ins_grp'])."',
        s_m_ins_plan = '".$db->escape( $_POST['s_m_ins_plan'])."',";
    if($_POST['has_s_m_ins']=="Yes") {
        $sql .= " s_m_ins_type = '7', ";
    }
    $sql .= "
        employer = '".$db->escape( $_POST['employer'])."',
        emp_add1 = '".$db->escape( $_POST['emp_add1'])."',
        emp_add2 = '".$db->escape( $_POST['emp_add2'])."',
        emp_city = '".$db->escape( $_POST['emp_city'])."',
        emp_state = '".$db->escape( $_POST['emp_state'])."',
        emp_zip = '".$db->escape( $_POST['emp_zip'])."',
        emp_phone = '".$db->escape( num($_POST['emp_phone']))."',
        emp_fax = '".$db->escape( num($_POST['emp_fax']))."',
        docsleep = '".$db->escape( $_POST['pc_1_contactid'])."',
        docpcp = '".$db->escape( $_POST['pc_2_contactid'])."',
        docdentist = '".$db->escape( $_POST['pc_3_contactid'])."',
        docent = '".$db->escape( $_POST['pc_4_contactid'])."',
        docmdother = '".$db->escape( $_POST['pc_5_contactid'])."',
        registered = '1',
        last_reg_sect = '".$db->escape( $_POST['last_reg_sect'])."'
        WHERE parent_patientid='".$db->escape( $_SESSION['pid'])."'
    ";
}
mysqli_query($con, $sql);

$s_sql = "SELECT email FROM dental_patients
    WHERE patientid=".$db->escape( $_SESSION['pid']);
$s_q = mysqli_query($con, $s_sql);
$s_r = mysqli_fetch_assoc($s_q);

sendUpdatedEmail($_SESSION['pid'], $_POST['email'], $s_r['email'], 'pat');

$s = "UPDATE dental_patients set email='".$db->escape( $_POST['email'])."' WHERE patientid='".$db->escape( $_SESSION['pid'])."'";
mysqli_query($con, $s);

$types = [DSS_PATIENT_CONTACT_SLEEP, DSS_PATIENT_CONTACT_PRIMARY, DSS_PATIENT_CONTACT_DENTIST, DSS_PATIENT_CONTACT_ENT, DSS_PATIENT_CONTACT_OTHER];
$updatevals = '';
foreach ($types as $t) {
    if (trim($_POST['pc_'.$t.'_contactid']) =='') {
        if ($_POST['pc_'.$t.'_firstname'] != '') {
            if ($_POST['pc_'.$t.'_patient_contactid'] == '') {
                $insql = "INSERT INTO dental_patient_contacts SET 
                    contacttype = '" . $t . "',
                    patientid = '" . $db->escape( $_SESSION['pid']) . "',
                    firstname = '" . $db->escape( trim($_POST['pc_'.$t.'_firstname'])) . "',
                    lastname = '" . $db->escape( trim($_POST['pc_'.$t.'_lastname'])) . "',
                    address1 = '" . $db->escape( $_POST['pc_'.$t.'_address1']) . "',
                    address2 = '" . $db->escape( $_POST['pc_'.$t.'_address2']) . "',
                    city = '" . $db->escape( $_POST['pc_'.$t.'_city']) . "',
                    state = '" . $db->escape( $_POST['pc_'.$t.'_state']) . "',
                    zip = '" . $db->escape( $_POST['pc_'.$t.'_zip']) . "',
                    phone = '" . $db->escape( num($_POST['pc_'.$t.'_phone'])) . "',
                    adddate = now(),
                    ip_address = '".$db->escape( $_SERVER['REMOTE_ADDR'])."';";
                mysqli_query($con, $insql);
                $id = mysqli_insert_id($con);

                if($updatevals!=''){
                    $updatevals .= ',';
                }
                $updatevals .= '"pc_'.$t.'_patient_contactid": "'.$id.'"';
            } else {
                $insql = "UPDATE dental_patient_contacts SET
                    contacttype = '" . $t . "',
                    patientid = '" . $db->escape( $_SESSION['pid']) . "',
                    firstname = '" . $db->escape( trim($_POST['pc_'.$t.'_firstname'])) . "',
                    lastname = '" . $db->escape( trim($_POST['pc_'.$t.'_lastname'])) . "',
                    address1 = '" . $db->escape( $_POST['pc_'.$t.'_address1']) . "',
                    address2 = '" . $db->escape( $_POST['pc_'.$t.'_address2']) . "',
                    city = '" . $db->escape( $_POST['pc_'.$t.'_city']) . "',
                    state = '" . $db->escape( $_POST['pc_'.$t.'_state']) . "',
                    zip = '" . $db->escape( $_POST['pc_'.$t.'_zip']) . "',
                    phone = '" . $db->escape( num($_POST['pc_'.$t.'_phone'])) . "'
                    WHERE id = '" . $db->escape( $_POST['pc_'.$t.'_patient_contactid']) . "'";
                mysqli_query($con, $insql);
            }
        }
    }
}
if($updatevals != ''){
    echo "{".$updatevals."}";
}

$p_m_sql = "SELECT c.company, c.add1 as address1, c.add2 as address2, c.city, c.state, c.zip, c.phone1 as phone, c.fax, c.email FROM dental_contact c inner join dental_patients p on p.p_m_ins_co=c.contactid WHERE p.patientid='".$db->escape( $_SESSION['pid'])."'";
$p_m_q = mysqli_query($con, $p_m_sql);
$p_m_r = mysqli_fetch_assoc($p_m_q);

if(trim($_POST['p_m_ins_company'])!='') {
    if($_POST['p_m_patient_insuranceid'] == '') {
        if(
            $p_m_r['company'] != $_POST['p_m_ins_company'] ||
            $p_m_r['address1'] != $_POST['p_m_ins_address1'] ||
            $p_m_r['address2'] != $_POST['p_m_ins_address2'] ||
            $p_m_r['city'] != $_POST['p_m_ins_city'] ||
            $p_m_r['state'] != $_POST['p_m_ins_state'] ||
            $p_m_r['zip'] != $_POST['p_m_ins_zip'] ||
            num($p_m_r['fax']) != num($_POST['p_m_ins_fax']) ||
            $p_m_r['email'] != $_POST['p_m_ins_email'] ||
            num($p_m_r['phone']) != num($_POST['p_m_ins_phone'])
        ) {
            $insql = "INSERT INTO dental_patient_insurance SET
                insurancetype = '1',
                patientid = '" . $db->escape( $_SESSION['pid']) . "',
                company = '" . $db->escape( $_POST['p_m_ins_company']) . "',
                address1 = '" . $db->escape( $_POST['p_m_ins_address1']) . "',
                address2 = '" . $db->escape( $_POST['p_m_ins_address2']) . "',
                city = '" . $db->escape( $_POST['p_m_ins_city']) . "',
                state = '" . $db->escape( $_POST['p_m_ins_state']) . "',
                zip = '" . $db->escape( $_POST['p_m_ins_zip']) . "',
                fax = '" . $db->escape( $_POST['p_m_ins_fax']) . "',
                email = '" . $db->escape( $_POST['p_m_ins_email']) . "',
                phone = '" . $db->escape( num($_POST['p_m_ins_phone'])) . "';";
            mysqli_query($con, $insql);
            $id = mysqli_insert_id($con);
            echo '{"p_m_patient_insuranceid": "'.$id.'"}';
        }
    }else{
        $insql = "UPDATE dental_patient_insurance SET 
            insurancetype = '1', 
            patientid = '" . $db->escape( $_SESSION['pid']) . "', 
            company = '" . $db->escape( $_POST['p_m_ins_company']) . "', 
            address1 = '" . $db->escape( $_POST['p_m_ins_address1']) . "', 
            address2 = '" . $db->escape( $_POST['p_m_ins_address2']) . "', 
            city = '" . $db->escape( $_POST['p_m_ins_city']) . "', 
            state = '" . $db->escape( $_POST['p_m_ins_state']) . "', 
            zip = '" . $db->escape( $_POST['p_m_ins_zip']) . "', 
            fax = '" . $db->escape( $_POST['p_m_ins_fax']) . "', 
            email = '" . $db->escape( $_POST['p_m_ins_email']) . "', 
            phone = '" . $db->escape( num($_POST['p_m_ins_phone'])) . "' 
            WHERE id = '". $db->escape( $_POST['p_m_patient_insuranceid']) ."'";
        mysqli_query($con, $insql);
    }
}

$s_m_sql = "SELECT c.company, c.add1 as address1, c.add2 as address2, c.city, c.state, c.zip, c.phone1 as phone, c.fax, c.email FROM dental_contact c inner join dental_patients p on p.s_m_ins_co=c.contactid WHERE p.patientid='".$db->escape( $_SESSION['pid'])."'";
$s_m_q = mysqli_query($con, $s_m_sql);
$s_m_r = mysqli_fetch_assoc($s_m_q);

if(trim($_POST['s_m_ins_company'])!=''){
    if($_POST['s_m_patient_insuranceid'] == ''){
        if(
            $s_m_r['company'] != $_POST['s_m_ins_company'] ||
            $s_m_r['address1'] != $_POST['s_m_ins_address1'] ||
            $s_m_r['address2'] != $_POST['s_m_ins_address2'] ||
            $s_m_r['city'] != $_POST['s_m_ins_city'] ||
            $s_m_r['state'] != $_POST['s_m_ins_state'] ||
            $s_m_r['zip'] != $_POST['s_m_ins_zip'] ||
            num($s_m_r['fax']) != num($_POST['s_m_ins_fax']) ||
            $s_m_r['email'] != $_POST['s_m_ins_email'] ||
            num($s_m_r['phone']) != num($_POST['s_m_ins_phone'])
        ) {
            $insql = "INSERT INTO dental_patient_insurance SET
                insurancetype = '2',
                patientid = '" . $db->escape( $_SESSION['pid']) . "',
                company = '" . $db->escape( $_POST['s_m_ins_company']) . "',
                address1 = '" . $db->escape( $_POST['s_m_ins_address1']) . "',
                address2 = '" . $db->escape( $_POST['s_m_ins_address2']) . "',
                city = '" . $db->escape( $_POST['s_m_ins_city']) . "',
                state = '" . $db->escape( $_POST['s_m_ins_state']) . "',
                zip = '" . $db->escape( $_POST['s_m_ins_zip']) . "',
                fax = '" . $db->escape( $_POST['s_m_ins_fax']) . "',
                email = '" . $db->escape( $_POST['s_m_ins_email']) . "',
                phone = '" . $db->escape( num($_POST['s_m_ins_phone'])) . "';";
            mysqli_query($con, $insql);
            $id = mysqli_insert_id($con);
            echo '{"s_m_patient_insuranceid": "'.$id.'"}';
        }
    }else{
        $insql = "UPDATE dental_patient_insurance SET 
            insurancetype = '2', 
            patientid = '" . $db->escape( $_SESSION['pid']) . "', 
            company = '" . $db->escape( $_POST['s_m_ins_company']) . "', 
            address1 = '" . $db->escape( $_POST['s_m_ins_address1']) . "', 
            address2 = '" . $db->escape( $_POST['s_m_ins_address2']) . "', 
            city = '" . $db->escape( $_POST['s_m_ins_city']) . "', 
            state = '" . $db->escape( $_POST['s_m_ins_state']) . "', 
            zip = '" . $db->escape( $_POST['s_m_ins_zip']) . "', 
            fax = '" . $db->escape( $_POST['s_m_ins_fax']) . "', 
            email = '" . $db->escape( $_POST['s_m_ins_email']) . "', 
            phone = '" . $db->escape( num($_POST['s_m_ins_phone'])) . "' 
            WHERE id = '". $db->escape( $_POST['s_m_patient_insuranceid']) ."'";
        mysqli_query($con, $insql);
    }
}
