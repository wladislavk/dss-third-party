<?php namespace Ds3\Libraries\Legacy; ?><?php
require_once('../3rdParty/tcpdf/config/lang/eng.php');
require_once('../3rdParty/tcpdf/tcpdf.php');
require_once('includes/main_include.php');
require_once('../includes/constants.inc');

$invoice_sql = "SELECT pi.*, u.name, u.address, u.city, u.state, u.zip, u.phone, u.user_type FROM dental_percase_invoice pi
	JOIN dental_users u ON u.userid=pi.docid
	WHERE id='".mysqli_real_escape_string($con, $_GET['invoice_id'])."'";
$invoice_q = mysqli_query($con, $invoice_sql);
$invoice = mysqli_fetch_assoc($invoice_q);

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
							<td height="133" align="center" valign="middle" style="padding: 0px;">';
							if($invoice['user_type']==DSS_USER_TYPE_SOFTWARE){
								$html .= '<a href="" title="" target="_blank"><img src="images/invoice/invoice_logo_ds3.png" alt="logo header" border="no" style="margin: 0px; padding: 0px; "/></a>';
							}else{
								$html .= '<a href="" title="" target="_blank"><img src="images/invoice/invoice_logo.jpg" alt="logo header" border="no" style="margin: 0px; padding: 0px; "/></a>';
							}
							$html .= '</td>
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
									<!-- title goes here -->Invoice '.str_pad($_GET['invoice_id'], 8, '0', STR_PAD_LEFT).'<br />
									Invoice Date: '.date('m/d/Y').'<br />';
                                                                          $html .= 'Payment Charged: '.date('m/d/Y', strtotime($invoice['due_date']));
									$html .= '</td>
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
									Dental Sleep Solutions<br />
									402 43rd St. West, Ste A<br />
									Bradenton, FL 34209
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
									<!-- title goes here -->Billed to:
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
$total_charge = 0;
if($invoice['monthly_fee_amount']!=''){
$total_charge += $invoice['monthly_fee_amount'];
$html .= '<tr>
                                                                        <td height="30" width="100" align="center" valign="middle" style="text-align: center; font-size:24px; border-bottom: 1px dotted #DDDDDD;">1</td>
                                                                        <td height="30" width="220" align="left" valign="middle" style="text-align: left; color: #444444; font-size:24px; font-weight: bold; border-bottom: 1px dotted #DDDDDD; padding-left: 10px;">MONTHLY FEE</td>

                                                                        <!-- table column with item number-->
                                                                        <td height="30" width="100" align="left" valign="middle" style="text-align: left; font-size:24px;border-bottom: 1px dotted #DDDDDD;">'.date('m/d/Y', strtotime($invoice['monthly_fee_date'])).'</td>
                                                                        <!-- table column with item price per pc -->
                                                                        <td height="30" width="100" align="left" valign="middle" style="text-align: right; font-size:24px;border-bottom: 1px dotted #DDDDDD;">N/A</td>
                                                                        <!-- table column with item price -->
                                                                        <td height="30" width="90" align="right" valign="middle" style="text-align: right; font-size:24px;border-bottom: 1px dotted #DDDDDD; padding-right: 10px;">'.$invoice['monthly_fee_amount'].'</td>
                                                                        </tr>';

}
if($invoice['producer_fee_amount']!=''){
$total_charge += $invoice['producer_fee_amount'];
$html .= '<tr>
                                                                        <td height="30" width="100" align="center" valign="middle" style="text-align: center; font-size:24px; border-bottom: 1px dotted #DDDDDD;">1</td>
                                                                        <td height="30" width="220" align="left" valign="middle" style="text-align: left; color: #444444; font-size:24px; font-weight: bold; border-bottom: 1px dotted #DDDDDD; padding-left: 10px;">'.$invoice['producer_fee_desc'].'</td>

                                                                        <!-- table column with item number-->
                                                                        <td height="30" width="100" align="left" valign="middle" style="text-align: left; font-size:24px;border-bottom: 1px dotted #DDDDDD;">'.date('m/d/Y', strtotime($invoice['producer_fee_date'])).'</td>
                                                                        <!-- table column with item price per pc -->
                                                                        <td height="30" width="100" align="left" valign="middle" style="text-align: right; font-size:24px;border-bottom: 1px dotted #DDDDDD;">N/A</td>
                                                                        <!-- table column with item price -->
                                                                        <td height="30" width="90" align="right" valign="middle" style="text-align: right; font-size:24px;border-bottom: 1px dotted #DDDDDD; padding-right: 10px;">'.$invoice['producer_fee_amount'].'</td>
                                                                        </tr>';

}

$case_sql_e0486 = "SELECT percase_name, percase_date as start_date, '' as end_date, percase_amount, ledgerid FROM dental_ledger dl 
                JOIN dental_patients dp ON dl.patientid=dp.patientid
        WHERE 
                dl.transaction_code='E0486' AND
                dl.docid='".$invoice['docid']."' AND
                dl.percase_invoice='".$invoice['id']."'";
$case_q_e0486 = mysqli_query($con, $case_sql_e0486);
$num_case_e0486 = mysqli_num_rows($case_q_e0486);


$case_sql = "SELECT percase_name, percase_date as start_date, '' as end_date, percase_amount, ledgerid FROM dental_ledger dl 
                JOIN dental_patients dp ON dl.patientid=dp.patientid
        WHERE 
                dl.transaction_code='E0486' AND
                dl.docid='".$invoice['docid']."' AND
		dl.percase_invoice='".$invoice['id']."'
        UNION
SELECT percase_name, percase_date, '', percase_amount, insuranceid FROM dental_insurance i 
        WHERE 
                i.percase_invoice='".$invoice['id']."'
	UNION
SELECT percase_name, percase_date, '', percase_amount, id FROM dental_claim_electronic e 
        WHERE 
                e.percase_invoice='".$invoice['id']."'
        UNION
SELECT percase_name, percase_date, '', percase_amount, id FROM dental_percase_invoice_extra dl 
        WHERE 
                dl.percase_invoice='".$invoice['id']."'
	UNION
SELECT CONCAT('Insurance Verification Services – ', patient_firstname, ' ', patient_lastname),
invoice_date, '', invoice_amount, id FROM dental_insurance_preauth
	WHERE
		invoice_id='".$invoice['id']."'
        UNION
SELECT description,
start_date, end_date, amount, id FROM dental_fax_invoice
        WHERE
                invoice_id='".$invoice['id']."'
        UNION
SELECT description,
start_date, end_date, amount, id FROM dental_eligibility_invoice
        WHERE
                invoice_id='".$invoice['id']."'
        UNION
SELECT description,
start_date, end_date, amount, id FROM dental_enrollment_invoice
        WHERE
                invoice_id='".$invoice['id']."'
        UNION
SELECT new_fee_desc,
new_fee_date, '', new_fee_amount, patientid FROM dental_patients
        WHERE
                new_fee_invoice_id='".$invoice['id']."'

";
$case_q = mysqli_query($con, $case_sql);
$num_case = mysqli_num_rows($case_q);

if($num_case_e0486 > 0){
$html .= '<tr>
                                                                        <td height="30" width="100" align="center" valign="middle" style="text-align: center; font-size:24px; border-bottom: 1px dotted #DDDDDD;">'.$num_case_e0486.'</td>
                                                                        <td height="30" width="220" align="left" valign="middle" style="text-align: left; color: #444444; font-size:24px; font-weight: bold; border-bottom: 1px dotted #DDDDDD; padding-left: 10px;">PER-CASE FEES</td>

                                                                        <!-- table column with item number-->
                                                                        <td height="30" width="100" align="left" valign="middle" style="text-align: left; font-size:24px;border-bottom: 1px dotted #DDDDDD;"></td>
                                                                        <!-- table column with item price per pc -->
                                                                        <td height="30" width="100" align="right" valign="middle" style="text-align: right; font-size:24px;border-bottom: 1px dotted #DDDDDD;"></td>
                                                                        <!-- table column with item price -->
                                                                        <td height="30" width="90" align="right" valign="middle" style="text-align: right; font-size:24px;border-bottom: 1px dotted #DDDDDD; padding-right: 10px;"></td>
                                                                        </tr>';
}
while($case = mysqli_fetch_assoc($case_q)){
$total_charge += $case['percase_amount'];
$html .= '<tr>
                                                                        <td height="30" width="100" align="center" valign="middle" style="text-align: center; font-size:24px; border-bottom: 2px dotted #DDDDDD;"></td>
									<td height="30" width="220" align="left" valign="middle" style="text-align: left; color: #444444; font-size:24px; font-weight: bold; border-bottom: 1px dotted #DDDDDD; padding-left: 10px;">'.$case['percase_name'].'</td>
                                                                        <td height="30" width="100" align="left" valign="middle" style="text-align: left; font-size:24px;border-bottom: 1px dotted #DDDDDD;">'.date('m/d/Y', strtotime($case['start_date'])).
(($case['end_date']!='' && $case['end_date']!='0000-00-00')?' to '.date('m/d/Y', strtotime($case['start_date'])):'') .
'</td>
									<td height="30" width="100" align="left" valign="middle" style="text-align: left; font-size:24px;border-bottom: 1px dotted #DDDDDD;">#'.str_pad($case['ledgerid'],5,'0',STR_PAD_LEFT).'</td>
									<td height="30" width="90" align="right" valign="middle" style="text-align: right; font-size:24px;border-bottom: 1px dotted #DDDDDD; padding-right: 10px;">'.$case['percase_amount'].'</td>
									</tr><tr><td colspan="5" style="color:#333333;" valign="top">'.str_pad('-',430,'-').'</td></tr>'; 

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
									<td height="30" width="90" align="right" valign="middle" style="text-align: right; padding-right: 10px;">$'.number_format($total_charge,2).'</td>
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
									<td height="30" width="90" align="right" valign="middle" style="color: #444444; font-weight: bold; text-align: right; padding-right: 10px;">$'.number_format($total_charge,2).'</td>
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
							<td align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 32px; color: #888888; padding-bottom: 20px;">
							<span style="font-weight: bold; color: #444444;">NOTICE:</span>
							The amount above will be automatically debited from your account on file on ';
							if($invoice['user_type']==DSS_USER_TYPE_SOFTWARE){
							  $html .= date('m/d/Y');
							}else{
							  $html .= date('m/d/Y', strtotime(date() . " +7 day"));
							}
							$html .='. DO NOT send a check or payment. If you dispute the amount above please contact us immediately.';
							if($invoice['user_type']!=DSS_USER_TYPE_SOFTWARE){
							  $html .= 'Please RETURN the Verification page following this invoice to confirm completed cases and total bill.';
							}
							$html .= '</td>
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
				
				</table>
				<!-- END main content table -->
			 </td>
		</tr>
		</table>
		<!-- END main centred table -->
	</div></td>
	</tr>
</table>';
if($invoice['user_type']!=DSS_USER_TYPE_SOFTWARE){
$html .= '<br pagebreak="true"/>
 <span style="font-size:45px">
INVOICE '.str_pad($_GET['invoice_id'], 8, '0', STR_PAD_LEFT).' - VERIFICATION 
</span>
<br />
<span style="font-size:40px;">
Please SIGN AND RETURN this Verification page. DO NOT send a check or payment.
</span>
<br />
<br />
 <table width="630" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                        <!-- start left table column -->
                                                        <td width="196" align="left" valign="top" >
                                                                <table width="196" border="0" cellspacing="0" cellpadding="0" >
                                                                        <tr>
                                                                        <td align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 30px; color: #54A9D0; padding-bott
om: 10px;">
Invoice '.str_pad($_GET['invoice_id'], 8, '0', STR_PAD_LEFT).'<br />
                                                                        Invoice Date: '.date('m/d/Y').'<br />
                                                                        Payment Charged: '.date('m/d/Y', strtotime(date() . " +7 day")).'
                                                                        </td>
                                                                        </tr>                                                   
                                                                </table>                                                        </td>
                                                        <td width="21">
                                                        <!-- this is BLANK table column DO NOT DELETE -->
                                                        </td>
                                                        <!-- start center table column -->
                                                        <td width="196" align="left" valign="top" >
                                                                <table width="196" border="0" cellspacing="0" cellpadding="0" >
                                                                        <tr>
                                                                        <td align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 30px; color: #444444; padding-bottom: 10px;">
Mail this page to:
                                                                        </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 30px; color: #888888; padding-bottom: 20px;">
Dental Sleep Solutions<br />
                                                                        402 43rd St. West, Ste A<br />
                                                                        Bradenton, FL 34209
                                                                        </td>
                                                                        </tr>
                                                                </table>
                                                        </td>
                                                       <!-- start right table column -->
                                                        <td width="196" align="left" valign="top" >
                                                                <table width="196" border="0" cellspacing="0" cellpadding="0" >
                                                                        <tr>
                                                                        <td align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 30px; color: #444444; padding-bottom: 10px;">
Billed to:
                                                                        </td>
                                                                        </tr>
                                                                        <tr>
                                                                        <td align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 30px; color: #888888; padding-bott
om: 20px;">
'.$invoice['name'].'<br />
                                                                        '.$invoice['address'].'<br />
                                                                        '.$invoice['city'].', '.$invoice['state'].' '.$invoice['zip'].'<br />
                                                                        Phone: '.$invoice['phone'].'<br />
                                                                        <br />
                                                                        <span style="color:#000; font-size:43px;">
                                                                                Total: $'.number_format($total_charge,2).' 
                                                                        </span>
                                                                        </td>
                                                                        </tr>
                                                                </table>
                                                        </td>
                                                        </tr>


                                                </table>



<div style="display:block;">
<table border="1" style="font-size:30px;" cellpadding="10">
<tr>
<td>

Additional Cases?&nbsp;&nbsp;&nbsp;&nbsp;Yes&nbsp;&nbsp;&nbsp;&nbsp;No<br />
If YES, please list all cases performed to-date that have not been previously invoiced:
<br />
<br />
<table>
<tr>
<td>
<table style="width: 400px;">
	<tr>
		<td>Name</td>
		<td>Date</td>
	</tr>
	<tr>
		<td>______________________________</td>
		<td>____________</td>
	</tr>	
        <tr>
                <td>______________________________</td>
                <td>____________</td>
        </tr>   
        <tr>
                <td>______________________________</td>
                <td>____________</td>
        </tr>   
        <tr>
                <td>______________________________</td>
                <td>____________</td>
        </tr>   
        <tr>
                <td>______________________________</td>
                <td>____________</td>
        </tr>   
</table>
</td>
<td align="right">
Number of Additional Cases=__________<br />
No Cases * $195=__________<br />
<b>Total:</b>__________
</td>
</tr>
</table>
</td>
</tr>
</table>
<div style="font-size:30px;">
I certify that the above invoice accurately reflects the dental sleep medicine cases performed in this office up to and including invoice date, and have noted any cases not listed on this or previous invoices performed to-date and adjusted payment accordingly.<br />
<br />
__________________________________________________(signature) '.$invoice['name'].'
</div>
</div>
';
}
$html .= '<!-- END main table -->
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
	
        $filename = 'percase_invoice_'.$invoice['docid'].'_'.$_GET['invoice_id'].'.pdf';
        $pdf->Output('../../../../shared/q_file/'.$filename, 'F');
//$pdf->Output('example_001.pdf', 'I');
if(!isset($redirect) || $redirect){
?>

<script type="text/javascript">
  window.open("display_file.php?f=<?= $filename; ?>");
  window.location = "manage_percase_invoice_history.php?docid=<?= $invoice['docid']; ?>";
</script>
<?php
} ?>
