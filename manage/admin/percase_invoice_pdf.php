<?php
require_once('../3rdParty/tcpdf/config/lang/eng.php');
require_once('../3rdParty/tcpdf/tcpdf.php');
require_once('includes/config.php');

$invoice_sql = "SELECT pi.*, u.name, u.address, u.city, u.state, u.zip, u.phone FROM dental_percase_invoice pi
	JOIN dental_users u ON u.userid=pi.docid
	WHERE id='".mysql_real_escape_string($_GET['invoice_id'])."'";
$invoice_q = mysql_query($invoice_sql);
$invoice = mysql_fetch_assoc($invoice_q);

$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>COMOD e-mail template layout - INVOICE</title>
<meta name="description" content="" />
<meta name="keywords" content="" />
</head>

<body bgcolor="#FFFFFF" style="background: #FFFFFF; padding: 0px; margin: 0px;" >
<!-- START main table -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" >
	<tr>
	<td bgcolor="#FFFFFF" align="center" ><div align="center">
		<!-- START main centred table -->
		<table width="630" border="0" cellpadding="0" cellspacing="0">
			<tr> 
			<td>
				<!-- START main content table -->
				<table width="630" border="0" cellspacing="0" cellpadding="0">
				
					<!-- START module / header with logo only -->
					<tr>
					<td bgcolor="#FFFFFF" >
						<table width="630" border="0" cellspacing="0" cellpadding="0" >
							<tr>
							<!-- table column with logo -->
							<td height="133" align="center" valign="middle" style="padding: 0px;">
							<a href="" title="" target="_blank"><img src="images/invoice/logo.jpg" alt="logo header" border="no" style="margin: 0px; padding: 0px; "/></a>
							</td>
							</tr>
						</table>
					</td>
					</tr>
					<tr>
					<td bgcolor="#FFFFFF" valign="top" style="border-top: none; border-right: none; border-bottom: none; border-left: none; padding-bottom: 20px;">
					<!-- divider goes here --><img src="images/invoice/splitted-header.jpg" alt="" border="no" style="margin: 0px; padding: 0px; display: block;"/>	
					</td>
					</tr>
					<!-- END module -->
					
					<!-- START module / three column content texts -->
					<tr>
					<td bgcolor="#FFFFFF" valign="top" style="border-top: none; border-right: none; border-bottom: none; border-left: none; padding-bottom: 0px;">
						<table width="630" border="0" cellspacing="0" cellpadding="0">
							<tr>
							<!-- start left table column -->
							<td width="196" align="left" valign="top" >
								<table width="196" border="0" cellspacing="0" cellpadding="0" >
									<tr>
									<td align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 30px; color: #54A9D0; padding-bottom: 10px;">
									<!-- title goes here -->Invoice '.str_pad($_GET['invoice_id'], 8, '0', STR_PAD_LEFT).'
									</td>
									</tr>							
								</table>
							</td>
							<td width="21">
							<!-- this is BLANK table column DO NOT DELETE -->
							</td>
							<!-- start center table column -->
							<td width="196" align="left" valign="top" >
								<table width="196" border="0" cellspacing="0" cellpadding="0" >
									<tr>
									<td align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 30px; color: #444444; padding-bottom: 10px;">
									<!-- title goes here -->From:
									</td>
									</tr>
									<tr>
									<td align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 30px; color: #888888; padding-bottom: 20px;">
									Dental Sleep Solutions
									</td>
									</tr>
								</table>
							</td>
							<td width="21">
							<!-- this is BLANK table column DO NOT DELETE -->
							</td>
							<!-- start right table column -->
							<td width="196" align="left" valign="top" >
								<table width="196" border="0" cellspacing="0" cellpadding="0" >
									<tr>
									<td align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 30px; color: #444444; padding-bottom: 10px;">
									<!-- title goes here -->Billing to:
									</td>
									</tr>
									<tr>
									<td align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 30px; color: #888888; padding-bottom: 20px;">
									'.$invoice['name'].'<br />
									'.$invoice['address'].'<br />
									'.$invoice['city'].', '.$invoice['state'].' '.$invoice['zip'].'<br />
									Phone: '.$invoice['phone'].'<br />
									</td>
									</tr>
								</table>
							</td>
							</tr>
						</table>
					</td>
					</tr>
					<!-- END module -->
					
					<!-- START module / invoice table-->
					<tr>
					<td bgcolor="#FFFFFF" style="border-top: none; border-right: none; border-bottom: none; border-left: none; padding-bottom: 20px; ">
						<table width="630" border="0" cellspacing="0" cellpadding="0">
							<tr>
							<td width="630" align="left" valign="top" >
								<!-- START comparison table-->
								
								<table width="630" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; color: #888888;">
									<!-- table row no1.-->
									<tr>
									<!-- table column with item quantity-->
                                                                        <td height="30" width="100" bgcolor="#54A9D0" align="center" valign="middle" style="font-weight: bold; font-size: 40px; text-align: center; color: #54a9d0;">Quantity</td>
									<!-- table column with item text -->
									<td height="30" width="220" bgcolor="#54A9D0" align="left" valign="middle" style="font-weight: bold; font-size: 40px; text-align: left; color: #54a9d0; padding-left: 10px;">Item</td>
                                                                        <!-- table column with item price per pc -->
                                                                        <td height="30" width="100" bgcolor="#54A9D0" align="left" valign="middle" style="font-weight: bold; font-size: 40px; text-align: right; color: #54a9d0;">Date</td>
									<!-- table column with item number-->
									<td height="30" width="100" bgcolor="#54A9D0" align="left" valign="middle" style="font-weight: bold; font-size: 40px; text-align: left; color: #54a9d0;">Case No.</td>
									<!-- table column with item price -->
									<td height="30" width="90" bgcolor="#54A9D0" align="right" valign="middle" style="font-weight: bold; font-size: 40px; text-align: right; color: #54a9d0; padding-right: 10px;">Price</td>
									</tr>';

$case_sql = "SELECT * FROM dental_ledger dl 
                JOIN dental_patients dp ON dl.patientid=dp.patientid
        WHERE 
                dl.transaction_code='E0486' AND
                dl.docid='".$invoice['docid']."' AND
		dl.percase_invoice='".$invoice['id']."'
";
$case_q = mysql_query($case_sql);
$num_case = mysql_num_rows($case_q);

$html .= '<tr>
                                                                        <td height="30" width="100" align="center" valign="middle" style="text-align: center; font-size:24px; border-bottom: 1px dotted #DDDDDD;">'.$num_case.'</td>
                                                                        <td height="30" width="220" align="left" valign="middle" style="text-align: left; color: #444444; font-size:24px; font-weight: bold; border-bottom: 1px dotted #DDDDDD; padding-left: 10px;">PER-CASE FEES</td>

                                                                        <!-- table column with item number-->
                                                                        <td height="30" width="100" align="left" valign="middle" style="text-align: left; font-size:24px;border-bottom: 1px dotted #DDDDDD;"></td>
                                                                        <!-- table column with item price per pc -->
                                                                        <td height="30" width="100" align="right" valign="middle" style="text-align: right; font-size:24px;border-bottom: 1px dotted #DDDDDD;"></td>
                                                                        <!-- table column with item price -->
                                                                        <td height="30" width="90" align="right" valign="middle" style="text-align: right; font-size:24px;border-bottom: 1px dotted #DDDDDD; padding-right: 10px;"></td>
                                                                        </tr>';

while($case = mysql_fetch_assoc($case_q)){

$html .= '<tr>
                                                                        <td height="30" width="100" align="center" valign="middle" style="text-align: center; font-size:24px; border-bottom: 1px dotted #DDDDDD;"></td>
									<td height="30" width="220" align="left" valign="middle" style="text-align: left; color: #444444; font-size:24px; font-weight: bold; border-bottom: 1px dotted #DDDDDD; padding-left: 10px;">'.$case['firstname'].' '.$case['lastname'].'</td>
                                                                        <td height="30" width="100" align="left" valign="middle" style="text-align: left; font-size:24px;border-bottom: 1px dotted #DDDDDD;">'.date('m/d/Y', strtotime($case['service_date'])).'</td>
									<td height="30" width="100" align="left" valign="middle" style="text-align: left; font-size:24px;border-bottom: 1px dotted #DDDDDD;">#'.str_pad($case['ledgerid'],5,'0',STR_PAD_LEFT).'</td>
									<td height="30" width="90" align="right" valign="middle" style="text-align: right; font-size:24px;border-bottom: 1px dotted #DDDDDD; padding-right: 10px;">$195.00</td>
									</tr>'; 

}
/*								<!-- table row no3.-->
									<tr>
									<!-- table column with item name-->
									<td height="30" width="220" align="left" valign="middle" style="text-align: left; color: #444444; font-weight: bold; border-bottom: 1px dotted #DDDDDD; padding-left: 10px;">Second item</td>
									<!-- table column with item number-->
									<td height="30" width="100" align="left" valign="middle" style="text-align: left; border-bottom: 1px dotted #DDDDDD;">#00000</td>
									<!-- table column with item quantity-->
									<td height="30" width="100" align="center" valign="middle" style="text-align: center; border-bottom: 1px dotted #DDDDDD;">0</td>
									<!-- table column with item price per pc -->
									<td height="30" width="100" align="right" valign="middle" style="text-align: right; border-bottom: 1px dotted #DDDDDD;">0.00 $</td>
									<!-- table column with item price -->
									<td height="30" width="90" align="right" valign="middle" style="text-align: right; border-bottom: 1px dotted #DDDDDD; padding-right: 10px;">0.00 $</td>
									</tr>
									<!-- table row no4.-->
									<tr>
									<!-- table column with item name-->
									<td height="30" width="220" align="left" valign="middle" style="text-align: left; color: #444444; font-weight: bold; border-bottom: 1px dotted #DDDDDD; padding-left: 10px;">Third item</td>
									<!-- table column with item number-->
									<td height="30" width="100" align="left" valign="middle" style="text-align: left; border-bottom: 1px dotted #DDDDDD;">#00000</td>
									<!-- table column with item quantity-->
									<td height="30" width="100" align="center" valign="middle" style="text-align: center; border-bottom: 1px dotted #DDDDDD;">0</td>
									<!-- table column with item price per pc -->
									<td height="30" width="100" align="right" valign="middle" style="text-align: right; border-bottom: 1px dotted #DDDDDD;">0.00 $</td>
									<!-- table column with item price -->
									<td height="30" width="90" align="right" valign="middle" style="text-align: right; border-bottom: 1px dotted #DDDDDD; padding-right: 10px;">0.00 $</td>
									</tr>
*/
$html .= '
									<!-- table row no5.-->
									<tr style="font-size:30px;">
									<!-- empty table column -->
									<td height="30" width="230" align="left" valign="middle" style="text-align: left;"></td>
									<!-- empty table column -->
									<td height="30" width="100" align="left" valign="middle" style="text-align: left;"></td>
									<!-- empty table column -->
									<td height="30" width="100" align="center" valign="middle" style="text-align: center;"></td>
									<!-- table column with subtotal text -->
									<td height="30" width="100" align="left" valign="middle" style="text-align: left;">Subtotal:</td>
									<!-- table column with subtotal price -->
									<td height="30" width="90" align="right" valign="middle" style="text-align: right; padding-right: 10px;">$'.number_format($num_case*195).'.00</td>
									</tr>
									<!-- table row no6.-->
									<tr style="font-size:30px;">
									<!-- empty table column -->
									<td height="30" width="230" align="left" valign="middle" style="text-align: left;"></td>
									<!-- empty table column -->
									<td height="30" width="100" align="left" valign="middle" style="text-align: left;"></td>
									<!-- empty table column -->
									<td height="30" width="100" align="center" valign="middle" style="text-align: center;"></td>
									<!-- table column with VAT text -->
									<td height="30" width="100" align="left" valign="middle" style="text-align: left;">Sales Tax:</td>
									<!-- table column with VAT price-->
									<td height="30" width="90" align="right" valign="middle" style="text-align: right; padding-right: 10px;">$0.00</td>
									</tr>
									<!-- table row no7.-->
									<tr style="font-size:30px">
									<!-- empty table column -->
									<td height="30" width="230" align="left" valign="middle" style="text-align: left;"></td>
									<!-- empty table column -->
									<td height="30" width="100" align="left" valign="middle" style="text-align: left;"></td>
									<!-- empty table column -->
									<td height="30" width="100" align="center" valign="middle" style="text-align: center;"></td>
									<!-- table column with total text -->
									<td height="30" width="100" align="left" valign="middle" style="color: #444444; font-weight: bold; text-align: left;">Total:</td>
									<!-- table column with total price -->
									<td height="30" width="90" align="right" valign="middle" style="color: #444444; font-weight: bold; text-align: right; padding-right: 10px;">$'.number_format($num_case*195).'.00</td>
									</tr>
								</table>
							</td>
							</tr>
							</table>
					</td>
					</tr>
					<!-- END module -->
					
<!-- START module / dark gray divider -->
					<tr>
					<td bgcolor="#FFFFFF" valign="top" style="border-top: none; border-right: none; border-bottom: none; border-left: none; padding-bottom: 20px;">
						<!-- divider goes here --><img src="images/invoice/splitted-gray-dark.jpg" alt="" border="no" style="margin: 0px; padding: 0px; display: block;"/>	
					</td>
					</tr>
<!-- END module -->
					
					<!-- START module / one column text-->
					<tr>
					<td bgcolor="#FFFFFF" valign="top" style="border-top: none; border-right: none; border-bottom: none; border-left: none; padding-bottom: 0px;">
						<table border="0" cellspacing="0" cellpadding="0" >
							<tr>
							<td align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 18px; color: #888888; padding-bottom: 20px;">
							<span style="font-weight: bold; color: #444444;">NOTICE:</span>
							<!-- text goes here -->Donec porttitor quam vel purus venenatis rutrum. Nullam quam nibh, congue sed aliquet posuere, aliquam non lacus. Maecenas nec luctus neque. Aliquam sagittis tincidunt lectus, non semper lorem sollicitudin ac. Proin ac felis tortor, eu ultricies orci. Vivamus consequat sapien ut mi tempus aliquam. Praesent egestas leo at erat sodales auctor. Curabitur non nunc justo, id sagittis neque. Praesent eget justo vel arcu faucibus elementum eget vitae dui. Ut at velit urna, eget pulvinar nibh. Proin aliquet pulvinar consectetur. Proin semper tempus tortor vitae semper. 
							</td>
							</tr>
						</table>	
					</td>
					</tr>
					<!-- END module -->
					
					<!-- START module / footer -->
					<tr>
					<td bgcolor="#FFFFFF" valign="top" style="border-top: none; border-right: none; border-bottom: none; border-left: none; padding-bottom: 20px;">
					<!-- divider goes here --><img src="images/invoice/splitted-footer.jpg" alt="" border="no" style="margin: 0px; padding: 0px; display: block;"/>	
					</td>
					</tr>
					<tr>
					<td bgcolor="#FFFFFF" valign="top" style="border-top: none; border-right: none; border-bottom: none; border-left: none; padding-bottom: 0px;">
						<table width="630" border="0" cellspacing="0" cellpadding="0">
							<tr>
							<!-- start left table column with contact data -->
							<td width="196" align="left" valign="top" style="padding-bottom: 20px; padding-top: 0px;">
								<table width="196" border="0" cellspacing="0" cellpadding="0" >
									<tr>
									<td align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 20px; color: #888888; ">
									Company adress, City, State<br/>
									Phone: 1-800-0000-000<br/>
									</td>
									</tr>
								</table>
							</td>
							<td width="21">
							<!-- this is BLANK table column DO NOT DELETE -->
							</td>
							<!-- start center table column with links-->
							<td width="196" align="left" valign="top" style="padding-bottom: 20px; padding-top: 0px;">
								<table width="196" border="0" cellspacing="0" cellpadding="0" >
									<tr>
									<td align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 20px; color: #888888; ">
									<a href="" title="" target="_blank" style="color: #54A9D0; text-decoration: none;">info@companywebsite.com</a><br/>
									<a href="" title="" target="_blank" style="color: #54A9D0; text-decoration: none;">companywebsite.com</a>
									</td>
									</tr>
								</table>
							</td>
							<td width="21">
							<!-- this is BLANK table column DO NOT DELETE -->
							</td>
							<!-- start right table column with social media links -->
							<td align="right" valign="middle" style="margin:0px; padding-bottom: 20px; padding-top: 0px;">
								<table border="0" cellspacing="0" cellpadding="0">
									<tr>
									<td width="20" align="left" valign="top" style="padding-left: 5px">
									<!-- footer icon --><a href="" title="" target="_blank"><img src="images/invoice/icon-footer.jpg" alt="footer icon" border="no" style="margin: 0px; padding: 0px;"/></a>
									</td>
									<td width="20" align="left" valign="top" style="padding-left: 5px">
									<!-- footer icon --><a href="" title="" target="_blank"><img src="images/invoice/icon-footer.jpg" alt="footer icon" border="no" style="margin: 0px; padding: 0px;"/></a>
									</td>
									<td width="20" align="left" valign="top" style="padding-left: 5px">
									<!-- footer icon --><a href="" title="" target="_blank"><img src="images/invoice/icon-footer.jpg" alt="footer icon" border="no" style="margin: 0px; padding: 0px;"/></a>
									</td>
									</tr>
								</table>
							</td>
							</tr>
							<tr>
							<td align="left" colspan="5" valign="top">
								<table width="196" border="0" cellspacing="0" cellpadding="0" >
									<tr>
									<td align="left" valign="middle" style="font-family: Arial,Helvetica,sans-serif; font-size: 16px; font-weight: bold; color: #444444; padding-bottom: 30px; padding-top: 20px; border-top: solid 5px #444444; ">
									<!-- featuring text-->Company name Ltd. 
									</td>
									</tr>
								</table>
							</td>
							</tr>
						</table>
					</td>
					</tr>
					<!-- END module -->
				
				</table>
				<!-- END main content table -->
			 </td>
		</tr>
		</table>
		<!-- END main centred table -->
	</div></td>
	</tr>
</table>
<!-- END main table -->
</body>
</html>';


$title = "test";
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Dental Sleep Solutions');
        $pdf->SetTitle($title);
        $pdf->SetSubject($title);
        $pdf->SetKeywords('DSS Per-case Invoice');

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
        //$pdf->setLanguageArray($l);

        // set font
        //$pdf->SetFont('dejavusans', '', 10);

        // add a page
        $pdf->AddPage();

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        $filename = '/manage/letterpdfs/percase_invoice_'.$_GET['invoice_id'].'.pdf';
        $pdf->Output($_SERVER['DOCUMENT_ROOT'] . $filename, 'F');
//$pdf->Output('example_001.pdf', 'I');
?>

<script type="text/javascript">
  window.location = "<?= $filename; ?>";
</script>
