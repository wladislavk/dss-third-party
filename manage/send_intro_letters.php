<?php
require($_SERVER['DOCUMENT_ROOT'] . '/manage/admin/includes/config.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/manage/3rdParty/tcpdf/config/lang/eng.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/manage/3rdParty/tcpdf/tcpdf.php');
require($_SERVER['DOCUMENT_ROOT'] . '/manage/includes/constants.inc');

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

$sql = "SELECT * FROM dental_letters WHERE status=1 AND template!='' AND template IS NOT NULL LIMIT 1, 10";
$q = mysql_query($sql);
while($r = mysql_fetch_assoc($q)){
  $template = $r['template'];













  if($template != ''){
        // add a page
        $pdf->AddPage();

        // output the HTML content
        $pdf->writeHTML($template, true, false, true, false, '');
  }

}

        //Close and output PDF document
        $pdf->Output($_SERVER['DOCUMENT_ROOT'] . '/manage/letterpdfs/master_output.pdf', 'F');



 ?>
