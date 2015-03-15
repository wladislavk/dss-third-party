<?php namespace Ds3\Libraries\Legacy; ?><?php
    include_once('admin/includes/main_include.php');
    include("includes/sescheck.php");
    include_once("admin/includes/general.htm");

    if (isset($_POST['templateid']) && isset($_POST['patientid'])) {
    	$templateid = $_POST['templateid'];
    	$patientid = $_POST['patientid'];
    } else {
    	$html = "No data received.";
        $patientid = '';
    }

    $md_list = get_mdcontactids($patientid, false);
    $md_referral_list = get_mdreferralids($patientid, false);
    $contactinfo = get_contact_info($patientid, $md_list, $md_referral_list);

    $contacts = array();
    $j = 0;
    $contacts[$j]['type'] = 'patient';
    $contacts[$j]['id'] = $patientid;
    $contacts[$j]['name'] = (!empty($contactinfo['patient'][0]['salutation']) ? $contactinfo['patient'][0]['salutation'] : '') . " " . (!empty($contactinfo['patient'][0]['firstname']) ? $contactinfo['patient'][0]['firstname'] : '') . " " . (!empty($contactinfo['patient'][0]['lastname']) ? $contactinfo['patient'][0]['lastname'] : '');
    $contacts[$j]['email'] = (!empty($contactinfo['patient'][0]['email']) ? $contactinfo['patient'][0]['email'] : '');
    $contacts[$j]['fax'] = (!empty($contactinfo['patient'][0]['fax']) ? $contactinfo['patient'][0]['fax'] : '');
    $j++;

    $i = 0;
    if ($contactinfo) foreach ($contactinfo['md_referrals'] as $md) {
        $contacts[$j]['type'] = 'md_referral';
        $contacts[$j]['id'] = $md['id'];
        $contacts[$j]['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
        $contacts[$j]['email'] = $md['email'];
        $contacts[$j]['fax'] = $md['fax'];
        $contacts[$j]['status'] = $md['status'];
        $j++;
        $i++;
    }

    $i = 0;
    $contact_sql = "SELECT docsleep, docpcp, docdentist, docent, docmdother, docmdother2, docmdother3 FROM dental_patients where patientid = '".s_for((!empty($_POST['patientid']) ? $_POST['patientid'] : ''))."';";
    
    $row = $db->getRow($contact_sql);
    if($row['docsleep']!=''){
        $sql = "SELECT dental_contact.contactid AS id, dental_contact.salutation, dental_contact.firstname, dental_contact.lastname, dental_contact.middlename, dental_contact.company, dental_contact.add1, dental_contact.add2, dental_contact.city, dental_contact.state, dental_contact.zip, dental_contact.email, dental_contact.fax, dental_contact.preferredcontact, dental_contacttype.contacttype, dental_contact.status FROM dental_contact LEFT JOIN dental_contacttype ON dental_contact.contacttypeid=dental_contacttype.contacttypeid WHERE dental_contact.contactid IN(".$row['docsleep'].");";

        $md = $db->getRow($sql);
        $contacts[$j]['type'] = 'md';
        $contacts[$j]['label'] = "Sleep MD";
        $contacts[$j]['id'] = $md['id'];
        $contacts[$j]['name'] = $md['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
        $contacts[$j]['email'] = $md['email'];
        $contacts[$j]['fax'] = $md['fax'];
        $contacts[$j]['status'] = $md['status'];
        $j++;
    }

    if($row['docpcp']!=''){
        $sql = "SELECT dental_contact.contactid AS id, dental_contact.salutation, dental_contact.firstname, dental_contact.lastname, dental_contact.middlename, dental_contact.company, dental_contact.add1, dental_contact.add2, dental_contact.city, dental_contact.state, dental_contact.zip, dental_contact.email, dental_contact.fax, dental_contact.preferredcontact, dental_contacttype.contacttype, dental_contact.status FROM dental_contact LEFT JOIN dental_contacttype ON dental_contact.contacttypeid=dental_contacttype.contacttypeid WHERE dental_contact.contactid =".$row['docpcp'].";";
        
        error_log($sql);
        $md = $db->getRow($sql);
        $contacts[$j]['type'] = 'md';
        $contacts[$j]['label'] = "Primary Care MD";
        $contacts[$j]['id'] = $md['id'];
        $contacts[$j]['name'] = $md['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
        $contacts[$j]['email'] = $md['email'];
        $contacts[$j]['fax'] = $md['fax'];
        $contacts[$j]['status'] = $md['status'];
        $j++;
    }

    if($row['docdentist']!=''){
        $sql = "SELECT dental_contact.contactid AS id, dental_contact.salutation, dental_contact.firstname, dental_contact.lastname, dental_contact.middlename, dental_contact.company, dental_contact.add1, dental_contact.add2, dental_contact.city, dental_contact.state, dental_contact.zip, dental_contact.email, dental_contact.fax, dental_contact.preferredcontact, dental_contacttype.contacttype, dental_contact.status FROM dental_contact LEFT JOIN dental_contacttype ON dental_contact.contacttypeid=dental_contacttype.contacttypeid WHERE dental_contact.contactid =".$row['docdentist'].";";
        
        error_log($sql);
        $md = $db->getRow($sql);
        $contacts[$j]['type'] = 'md';
        $contacts[$j]['label'] = "Dentist";
        $contacts[$j]['id'] = $md['id'];
        $contacts[$j]['name'] = $md['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
        $contacts[$j]['email'] = $md['email'];
        $contacts[$j]['fax'] = $md['fax'];
        $contacts[$j]['status'] = $md['status'];
        $j++;
    }

    if($row['docent']!=''){
        $sql = "SELECT dental_contact.contactid AS id, dental_contact.salutation, dental_contact.firstname, dental_contact.lastname, dental_contact.middlename, dental_contact.company, dental_contact.add1, dental_contact.add2, dental_contact.city, dental_contact.state, dental_contact.zip, dental_contact.email, dental_contact.fax, dental_contact.preferredcontact, dental_contacttype.contacttype, dental_contact.status FROM dental_contact LEFT JOIN dental_contacttype ON dental_contact.contacttypeid=dental_contacttype.contacttypeid WHERE dental_contact.contactid =".$row['docent'].";";
        
        error_log($sql);
        $md = $db->getRow($sql);
        $contacts[$j]['type'] = 'md';
        $contacts[$j]['label'] = "ENT";
        $contacts[$j]['id'] = $md['id'];
        $contacts[$j]['name'] = $md['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
        $contacts[$j]['email'] = $md['email'];
        $contacts[$j]['fax'] = $md['fax'];
        $contacts[$j]['status'] = $md['status'];
        $j++;
    }

    if($row['docmdother']!=''){
        $sql = "SELECT dental_contact.contactid AS id, dental_contact.salutation, dental_contact.firstname, dental_contact.lastname, dental_contact.middlename, dental_contact.company, dental_contact.add1, dental_contact.add2, dental_contact.city, dental_contact.state, dental_contact.zip, dental_contact.email, dental_contact.fax, dental_contact.preferredcontact, dental_contacttype.contacttype, dental_contact.status FROM dental_contact LEFT JOIN dental_contacttype ON dental_contact.contacttypeid=dental_contacttype.contacttypeid WHERE dental_contact.contactid =".$row['docmdother'].";";
        
        $md = $db->getRow($sql);
        $contacts[$j]['type'] = 'md';
        $contacts[$j]['label'] = "Other MD";
        $contacts[$j]['id'] = $md['id'];
        $contacts[$j]['name'] = $md['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
        $contacts[$j]['email'] = $md['email'];
        $contacts[$j]['fax'] = $md['fax'];
        $contacts[$j]['status'] = $md['status'];
        $j++;
    }

    if($row['docmdother2']!=''){
        $sql = "SELECT dental_contact.contactid AS id, dental_contact.salutation, dental_contact.firstname, dental_contact.lastname, dental_contact.middlename, dental_contact.company, dental_contact.add1, dental_contact.add2, dental_contact.city, dental_contact.state, dental_contact.zip, dental_contact.email, dental_contact.fax, dental_contact.preferredcontact, dental_contacttype.contacttype, dental_contact.status FROM dental_contact LEFT JOIN dental_contacttype ON dental_contact.contacttypeid=dental_contacttype.contacttypeid WHERE dental_contact.contactid =".$row['docmdother2'].";";
        
        $md = $db->getRow($sql);
        $contacts[$j]['type'] = 'md';
        $contacts[$j]['label'] = "Other MD";
        $contacts[$j]['id'] = $md['id'];
        $contacts[$j]['name'] = $md['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
        $contacts[$j]['email'] = $md['email'];
        $contacts[$j]['fax'] = $md['fax'];
        $contacts[$j]['status'] = $md['status'];
        $j++;
    }

    if($row['docmdother3']!=''){
        $sql = "SELECT dental_contact.contactid AS id, dental_contact.salutation, dental_contact.firstname, dental_contact.lastname, dental_contact.middlename, dental_contact.company, dental_contact.add1, dental_contact.add2, dental_contact.city, dental_contact.state, dental_contact.zip, dental_contact.email, dental_contact.fax, dental_contact.preferredcontact, dental_contacttype.contacttype, dental_contact.status FROM dental_contact LEFT JOIN dental_contacttype ON dental_contact.contacttypeid=dental_contacttype.contacttypeid WHERE dental_contact.contactid =".$row['docmdother3'].";";
        
        $md = $db->getRow($sql);
        $contacts[$j]['type'] = 'md';
        $contacts[$j]['label'] = "Other MD";
        $contacts[$j]['id'] = $md['id'];
        $contacts[$j]['name'] = $md['name'] = $md['salutation'] . " " . $md['firstname'] . " " . $md['lastname'];
        $contacts[$j]['email'] = $md['email'];
        $contacts[$j]['fax'] = $md['fax'];
        $contacts[$j]['status'] = $md['status'];
        $j++;
    }

    echo json_encode($contacts);
?>
