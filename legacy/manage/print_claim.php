<?php
namespace Ds3\Libraries\Legacy;

include_once('includes/constants.inc');
include_once('admin/includes/main_include.php');

$db = new Db();

$s = "SELECT primary_fdf, secondary_fdf FROM dental_insurance i WHERE i.insuranceid='".$db->escape( $_GET['insid'])."'";

$r = $db->getRow($s);
$file = $r['primary_fdf'] ?: $r['secondary_fdf'];

$fdf_file_path = '../../../shared/q_file/'.$file;
$pdf_template_path = $path . 'claim_v2.pdf';
$pdftk = '/usr/bin/pdftk';
$pdf_name = substr( $fdf_file_path, 0, -4 ) . '.pdf';
$result_pdf = $pdf_name;
$command = "$pdftk $pdf_template_path fill_form $fdf_file_path output $result_pdf flatten";

exec($command, $output, $exitStatus);

if ($exitStatus) {
    error_log("Print claim failed. PDFtk command: $command");
    error_log("PDFtk output:\n\t" . join("\n\t", $output));
    error_log("PDFtk exit status: $exitStatus");
}

include_once '3rdParty/tcpdf/tcpdf.php';
include_once '3rdParty/fpdi/fpdi.php';

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

        $d_sql = "SELECT claim_margin_top, claim_margin_left FROM dental_users where userid='".$db->escape($_SESSION['docid'])."'";
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

$pdf->Output('insurance_claim.pdf', 'D');
