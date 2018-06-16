<?php
namespace Ds3\Libraries\Legacy;

include_once('includes/constants.inc');
include_once('admin/includes/main_include.php');
include_once('admin/includes/invoice_functions.php');

  $file = (!empty($_GET['f']) ? $_GET['f'] : '');
  // this is where you'd do any custom handling of the data
	// if you wanted to put it in a database, email t
  // FDF data, push ti back to the user with a header() call, etc.
  // write the file out

  $handle = fopen("../../../shared/q_file/".$file, 'x+');
  fwrite($handle, $fdf);
  fclose($handle);

	$xfdf_file_path = '../../../shared/q_file/'.$file;
  $pdf_template_path = 'claim_v2.pdf';
  $pdftk = '/usr/bin/pdftk';
  $pdf_name = substr( $xfdf_file_path, 0, -4 ) . '.pdf';
  $result_pdf = $pdf_name;
  $command = "$pdftk $pdf_template_path fill_form $xfdf_file_path output $result_pdf flatten";

  exec( $command, $output, $exitStatus );

    if ($exitStatus) {
        error_log("Print claim failed. PDFtk command: $command");
        error_log("PDFtk output:\n\t" . join("\n\t", $output));
        error_log("PDFtk exit status: $exitStatus");
    }

  include_once '3rdParty/tcpdf/tcpdf.php';
  include_once '3rdParty/fpdi/fpdi.php';

  class PDF extends \FPDI {
    /**
     * "Remembers" the template id of the imported page
     */
    public $_tplIdx;
    public $_template;
    
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

      if(isset($_SESSION['adminuserid'])){
        $d_sql = "SELECT claim_margin_top, claim_margin_left FROM admin where adminid='".mysqli_real_escape_string($con, $_SESSION['adminuserid'])."'";
       
        $d_r = $db->getRow($d_sql);
        $claim_margin_left = $d_r['claim_margin_left'];
        $claim_margin_top = $d_r['claim_margin_top'];
      }elseif(isset($_SESSION['userid'])){
        $d_sql = "SELECT claim_margin_top, claim_margin_left FROM dental_users where userid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";

        $d_r = $db->getRow($d_sql);
        $claim_margin_left = $d_r['claim_margin_left'];
        $claim_margin_top = $d_r['claim_margin_top'];
      }else{
        $claim_margin_top = 0;
        $claim_margin_left = 0;
      }

      $this->useTemplate($this->_tplIdx, $claim_margin_left, $claim_margin_top);
    }
    
    function Footer()
    {
        // nothing here
    }
  }

  // initiate PDF
  $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  $pdf->_template = $result_pdf;
  $pdf->SetMargins(0, 0, 0);
  $pdf->SetAutoPageBreak(true, 40);
  $pdf->setFontSubsetting(false);

  // add a page
  $pdf->AddPage();

  $pdf->Output('insurance_claim.pdf', 'D');
