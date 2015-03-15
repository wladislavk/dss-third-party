<?php namespace Ds3\Legacy; ?><?php
session_start();
require_once('../includes/constants.inc');
require_once('includes/main_include.php');

if(!empty($_SERVER['HTTPS'])){
$path = 'https://'.$_SERVER['HTTP_HOST'].'/manage/';
}else{
$path = 'http://'.$_SERVER['HTTP_HOST'].'/manage/';
}

$xfdf_file_path = "../fdf_test.fdf";
$pdf_template_path = '../claim_v2.pdf';
$pdftk = '/usr/bin/pdftk';
$result_pdf = "../../../../shared/q_file/claim_margin_admin_".$_SESSION['adminuserid']."_".date('YmdHis').".pdf"; 
$command = "$pdftk $pdf_template_path fill_form $xfdf_file_path output $result_pdf flatten";

exec( $command, $output, $ret );


require_once '../3rdParty/tcpdf/tcpdf.php';
require_once '../3rdParty/fpdi/fpdi.php';


class PDF extends FPDI {
    /**
     * "Remembers" the template id of the imported page
     */
    var $_tplIdx;
    var $_template;
    
    /**
     * include a background template for every page
     */
    function Header() {
        if (is_null($this->_tplIdx)) {
            $this->setSourceFile($this->_template);
            $this->_tplIdx = $this->importPage(1);
        }

	$d_sql = "SELECT claim_margin_top, claim_margin_left FROM admin where adminid='".mysql_real_escape_string($_SESSION['adminuserid'])."'";
	$d_q = mysql_query($d_sql);
	$d_r = mysql_fetch_assoc($d_q);

        $this->useTemplate($this->_tplIdx, $d_r['claim_margin_left'], $d_r['claim_margin_top']);
        
    }
    
    function Footer() {}
}

// initiate PDF
$pdf = new PDF();
$pdf->_template = $result_pdf;
$pdf->SetMargins(0, 0, 0);
$pdf->SetAutoPageBreak(true, 40);
$pdf->setFontSubsetting(false);

// add a page
$pdf->AddPage();

$pdf->Output('margin_test.pdf', 'D');

//echo $fdf;

?>

