<?php
//Prod letter ids 4242 through 4733 (492)
require($_SERVER['DOCUMENT_ROOT'] . '/manage/admin/includes/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/manage/3rdParty/tcpdf/config/lang/eng.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/manage/3rdParty/tcpdf/tcpdf.php');
require($_SERVER['DOCUMENT_ROOT'] . '/manage/includes/constants.inc');


//DID NOT USE MASS CREATE SINGLE PDF DUE TO SPACING ISSUES
//INSTEAD GENERATED SINGLE LETTERS AND USED SCRIPT TO COMBINE THEM
//temporarily created addition export to new folder to keep separate


/*
// Extend the TCPDF class to create custom Header and Footer
class NEWPDF extends TCPDF {

                public $footerText = '';

                //Page header
                public function Header() {
                                // Logo
                                $image_file = K_PATH_IMAGES.'dss_print_header.jpg';
                                        //$this->Image($image_file, 0, 0, '', '', 'JPG', '', 'M', false, 300, '', false, false, 0, false, false, false);
                        }

                        // Page footer
                        public function Footer() {
                                // Position at 26 mm from bottom
                                $this->SetY(-17);
                                $this->Cell(0, 10, $this->footerText, 0, false, 'C', 0, '', 0, false, 'T', 'M');
                }
        public function AcceptPageBreak() {
                if ($this->num_columns > 1) {
                        // multi column mode
                        if ($this->current_column < ($this->num_columns - 1)) {
                                // go to next column
                                $this->selectColumn($this->current_column + 1);
                        } else {
                                // add a new page
                                $this->AddPage();
                                // set first column
                                $this->selectColumn(0);
                        }
                        // avoid page breaking from checkPageBreak()
                        return false;
                }
                $this->setMargins(18,40,18);
                return $this->AutoPageBreak;
        }
}

	$pdf = new NEWPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        //$pdf->footerText = $footer;

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Dental Sleep Solutions');
        //$pdf->SetTitle($title);
        //$pdf->SetSubject($title);
        $pdf->SetKeywords('DSS Correspondance');

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        //set some language-dependent strings
        $pdf->setLanguageArray($l);

        // set font
        $pdf->SetFont('dejavusans', '', 10);
*/

$todays_date = date('F d, Y');

$sql = "SELECT l.*, lt.body FROM dental_letters l 
	JOIN dental_letter_templates lt ON l.templateid=lt.id
	WHERE 
	(l.templateid = 1 OR l.templateid = 2) AND
	status=0 and deleted=0 and deleted=0";
$q = mysql_query($sql);
while($r = mysql_fetch_assoc($q)){
  $template = $r['body'];

  $contact_info = get_contact_info('', $r['md_list'], '');
  $contact = $contact_info['mds'][0];

$franchisee_query = "SELECT mailing_name as name, mailing_practice as practice, mailing_address as address, mailing_city as city, mailing_state as state, mailing_zip as zip, email FROM dental_users WHERE userid = '".$r['docid']."';";
$franchisee_result = mysql_query($franchisee_query);
while ($row = mysql_fetch_assoc($franchisee_result)) {
        $franchisee_info = $row;
}

// Get Company Name and Address
$company_query = "SELECT c.* FROM companies c 
                JOIN dental_user_company uc ON c.id = uc.companyid
                WHERE uc.userid = '".$r['docid']."';";
//echo $company_query;
$company_result = mysql_query($company_query);
while ($row = mysql_fetch_assoc($company_result)) {
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
                $replace[] = end(explode(" ", $franchisee_info['name']));
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

  deliver_letter($r['letterid'], $template);
  /*if($template != ''){
        // add a page
        $pdf->AddPage();

        // output the HTML content
        $pdf->writeHTML($template, true, false, true, false, '');
  }*/

}

        //Close and output PDF document
        //$pdf->Output($_SERVER['DOCUMENT_ROOT'] . '/manage/master_output.pdf', 'F');



 ?>
