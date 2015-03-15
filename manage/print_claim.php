<?php namespace Ds3\Libraries\Legacy; ?><?php
    include_once('includes/constants.inc');
    include_once('admin/includes/main_include.php');

    $s = "SELECT primary_fdf FROM dental_insurance i WHERE i.insuranceid='".mysqli_real_escape_string($con, $_GET['insid'])."'";
    
    $r = $db->getRow($s);
    $file = $r['primary_fdf'];

    $fdf_file_path = '../../../shared/q_file/'.$file;
    $pdf_template_path = $path . 'claim_v2.pdf';
    $pdftk = '/usr/bin/pdftk';
    $pdf_name = substr( $fdf_file_path, 0, -4 ) . '.pdf';
    $result_pdf = $pdf_name;
    $command = "$pdftk $pdf_template_path fill_form $fdf_file_path output $result_pdf flatten";

    exec( $command, $output, $ret );

    include_once '3rdParty/tcpdf/tcpdf.php';
    include_once '3rdParty/fpdi/fpdi.php';

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
            $db = new Db();
            if (is_null($this->_tplIdx)) {
                $this->setSourceFile($this->_template);
                $this->_tplIdx = $this->importPage(1);
            }
            $h_con = $db->con;
            $d_sql = "SELECT claim_margin_top, claim_margin_left FROM dental_users where userid='".mysqli_real_escape_string($h_con, $_SESSION['docid'])."'";

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
?>
