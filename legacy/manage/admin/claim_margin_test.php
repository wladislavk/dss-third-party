<?php
namespace Ds3\Libraries\Legacy;

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

exec( $command, $output, $exitStatus );

if ($exitStatus) {
    error_log("Print claim failed. PDFtk command: $command");
    error_log("PDFtk output:\n\t" . join("\n\t", $output));
    error_log("PDFtk exit status: $exitStatus");
}

class PDF extends \FPDI
{
    /**
     * "Remembers" the template id of the imported page
     */
    var $_tplIdx;
    var $_template;
    
    /**
     * include a background template for every page
     */
    function Header()
    {
        $db = new Db();

        if (is_null($this->_tplIdx)) {
            $this->setSourceFile($this->_template);
            $this->_tplIdx = $this->importPage(1);
        }

        $d_sql = "SELECT claim_margin_top, claim_margin_left FROM admin where adminid='".$db->escape( $_SESSION['adminuserid'])."'";
        $d_r = $db->getRow($d_sql);

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
