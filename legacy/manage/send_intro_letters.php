<?php namespace Ds3\Libraries\Legacy; ?><?php
//Prod letter ids 4242 through 4733 (492)
require($_SERVER['DOCUMENT_ROOT'] . '/manage/admin/includes/main_include.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/manage/3rdParty/tcpdf/config/lang/eng.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/manage/3rdParty/tcpdf/tcpdf.php');
require($_SERVER['DOCUMENT_ROOT'] . '/manage/includes/constants.inc');


//DID NOT USE MASS CREATE SINGLE PDF DUE TO SPACING ISSUES
//INSTEAD GENERATED SINGLE LETTERS AND USED SCRIPT TO COMBINE THEM
//temporarily created addition export to new folder to keep separate


$todays_date = date('F d, Y');

$sql = "SELECT l.*, lt.body FROM dental_letters l 
	JOIN dental_letter_templates lt ON l.templateid=lt.id
	WHERE 
	(l.templateid = 1 OR l.templateid = 2) AND
	status=0 and deleted=0 and deleted=0";
$q = mysqli_query($con, $sql);
while($r = mysqli_fetch_assoc($q)){
  $template = $r['body'];

  $contact_info = get_contact_info('', $r['md_list'], '');
  $contact = $contact_info['mds'][0];

$franchisee_query = "SELECT mailing_name as name, mailing_practice as practice, mailing_address as address, mailing_city as city, mailing_state as state, mailing_zip as zip, email FROM dental_users WHERE userid = '".$r['docid']."';";
$franchisee_result = mysqli_query($con, $franchisee_query);
while ($row = mysqli_fetch_assoc($franchisee_result)) {
        $franchisee_info = $row;
}

// Get Company Name and Address
$company_query = "SELECT c.* FROM companies c 
                JOIN dental_user_company uc ON c.id = uc.companyid
                WHERE uc.userid = '".$r['docid']."';";
$company_result = mysqli_query($con, $company_query);
while ($row = mysqli_fetch_assoc($company_result)) {
        $company_info = $row;
}


                $search = array();
                $replace = array();
                $search[] = '%todays_date%';
                $replace[] = $todays_date;
                $search[] = "%company%";
                $replace[] = $company_info['name'];
                $search[] = "%company_addr%";
                $replace[] = nl2br($company_info['add1']." ".$company_info['add2']) . "<br />" . $company_info['city'] . ", " . $company_info['state'] . " " . $company_info['zip'];
                $search[] = "%franchisee_fullname%";
                $replace[] = $franchisee_info['name'];
                $search[] = "%franchisee_lastname%";
                $replace[] = preg_replace('/^.*[ ]([^ ]+)$/', '$1', ($franchisee_info['name']));
                $search[] = "%franchisee_practice%";
                $replace[] = $franchisee_info['practice'];
                $search[] = "%franchisee_phone%";
                $replace[] = $franchisee_info['phone'];
                $search[] = "%franchisee_addr%";
                $replace[] = nl2br($franchisee_info['address']) . "<br />" . $franchisee_info['city'] . ", " . $franchisee_info['state'] . " " . $franchisee_info['zip'];
                
                $search[] = '%contact_salutation%';
                $replace[] = $contact['salutation'];
                $search[] = '%contact_fullname%';
                $replace[] = $contact['salutation'] . " " . $contact['firstname'] . " " . $contact['lastname'];
                $search[] = '%contact_firstname%';
                $replace[] = $contact['firstname'];
                $search[] = '%contact_lastname%';
                $replace[] = $contact['lastname'];
                $search[] = "%salutation%";
                $replace[] = $contact['salutation'];
                $search[] = '%practice%';
                $replace[] = ($contact['company']) ? $contact['company'] . "<br />" : "<!--%practice%-->";
                $search[] = '%contact_email%';
                $replace[] = $contact['email'];
                $search[] = '%addr1%';
                $replace[] = $contact['add1'];
                $search[] = '%addr2%';
                $replace[] = ($contact['add2']) ? ", " . $contact['add2'] : "<!--%addr2%-->";
                $search[] = '%insurance_id%';
                $replace[] = $patient_info['p_m_ins_id'];
                $search[] = '%city%';
                $replace[] = $contact['city'];
                $search[] = '%state%';
                $replace[] = $contact['state'];
                $search[] = '%zip%';
                $replace[] = $contact['zip'];






  $template = str_replace($search, $replace, $template);

}
