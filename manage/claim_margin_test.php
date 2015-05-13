<?php namespace Ds3\Libraries\Legacy; ?><?php
    include_once('includes/constants.inc');
    include_once('admin/includes/main_include.php');

    if(!empty($_SERVER['HTTPS'])) {
        $path = 'https://'.$_SERVER['HTTP_HOST'].'/manage/';
    } else {
        $path = 'http://'.$_SERVER['HTTP_HOST'].'/manage/';
    }

    $xfdf_file_path = "fdf_test.fdf";
    $pdf_template_path = $path.'claim_v2.pdf';
    $pdftk = '/usr/bin/pdftk';
    $result_pdf = "../../../shared/q_file/claim_margin_".$_SESSION['docid']."_".date('YmdHis').".pdf"; 
    $command = "$pdftk $pdf_template_path fill_form $xfdf_file_path output $result_pdf flatten";

    exec( $command, $output, $ret );

    include_once '3rdParty/tcpdf/tcpdf.php';
    include_once '3rdParty/fpdi/fpdi.php';

    class PDF extends \FPDI {
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

        	$d_sql = "SELECT claim_margin_top, claim_margin_left FROM dental_users where userid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";

        	$d_r = $db->getRow($d_sql);

            $this->useTemplate($this->_tplIdx, $d_r['claim_margin_left'], $d_r['claim_margin_top']);
        }
        
        function Footer() {}
    }

    if (file_exists($result_pdf)) {

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

    }
?>
