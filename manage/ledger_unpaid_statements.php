<?php namespace Ds3\Libraries\Legacy; ?><?php
set_time_limit(300);
session_start();
//header("Content-type:application/pdf");

// It will be called downloaded.pdf
//header("Content-Disposition:attachment;filename='downloaded.pdf'");
require_once('3rdParty/tcpdf/config/lang/eng.php');
require_once('3rdParty/tcpdf/tcpdf.php');

require_once('admin/includes/main_include.php');
include("includes/sescheck.php");
require_once('includes/dental_patient_summary.php');
include_once 'includes/constants.inc';
$docsql = "SELECT * FROM dental_users where userid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";
$docq = mysqli_query($con, $docsql);
$docr = mysqli_fetch_assoc($docq); 


//START PDF
$title = "test";
                $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Dental Sleep Solutions');
        $pdf->SetTitle($title);
        $pdf->SetSubject($title);
        $pdf->SetKeywords('DSS Correspondence');

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
        $pdf->SetFont('dejavusans', '', 10);


$find_sql = "SELECT  "
                 . "  sum(dl.amount) as amount, sum(dl.paid_amount) as paid_amount, "
     . "p.firstname, p.lastname, p.patientid "
     . "FROM dental_ledger dl  "
     . "JOIN dental_patients p ON p.patientid=dl.patientid "
     . "WHERE dl.docid='".$_SESSION['docid']."'  "
     . "GROUP BY dl.patientid";
$find_my = mysqli_query($con, $find_sql);
                while($find_myarray = mysqli_fetch_array($find_my))
                {
$pay_sql = "SELECT  "
                 . "  sum(pay.amount) as paid_amount "
     . "FROM dental_ledger dl  "
     . "JOIN dental_patients p ON p.patientid=dl.patientid "
     . "LEFT JOIN dental_ledger_payment pay on pay.ledgerid = dl.ledgerid  "
     . "WHERE dl.docid='".$_SESSION['docid']."' "
     . "AND p.patientid='".$find_myarray['patientid']."' "
     . "GROUP BY dl.patientid";
$pay_q = mysqli_query($con, $pay_sql);
$pay_r = mysqli_fetch_assoc($pay_q);
$paid_amount = $find_myarray['paid_amount']+$pay_r['paid_amount'];
                        if(round($find_myarray['amount'],2)!=round($paid_amount,2)){

//HACK TO USE EXISTING STRUCTURE EXPECING _GET
$_GET['pid'] = $find_myarray['patientid'];
$sql = "SELECT  "
		 . "  dl.amount, sum(pay.amount) as paid_amount "
     . "FROM dental_ledger dl  "
     . "LEFT JOIN dental_ledger_payment pay on pay.ledgerid = dl.ledgerid  "
     . "WHERE dl.docid='".$_SESSION['docid']."' AND dl.patientid='".s_for($_GET['pid'])."'  "
     . "GROUP BY dl.ledgerid";
$result = mysqli_query($con, $sql);
$ledger_balance = 0;
while ($row = mysqli_fetch_array($result)) {
  $ledger_balance -= $row['amount'];
  $ledger_balance += $row['paid_amount'];
}
if(!isset($_REQUEST['sort'])){
  $_REQUEST['sort'] = 'service_date';
  $_REQUEST['sortdir'] = 'desc';
}

$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysqli_query($con, $pat_sql);
$pat_myarray = mysqli_fetch_array($pat_my); 

$name = st($pat_myarray['firstname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['lastname']);

$rec_disp = 200;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;

$sql = "select 
                'ledger',
		dl.ledgerid,
		dl.service_date,
            	dl.entry_date,
		CONCAT(p.first_name,' ',p.last_name) as name,
 		dl.description,
		dl.amount,
		'' as paid_amount,
		dl.status,
		dl.primary_claim_id,
		'' as payer,
		'' as payment_type,
		di.status as claim_status
	from dental_ledger dl 
		LEFT JOIN dental_users p ON dl.producerid=p.userid 
		LEFT JOIN dental_ledger_payment pay on pay.ledgerid=dl.ledgerid
		LEFT JOIN dental_insurance di on di.insuranceid = dl.primary_claim_id
			where dl.docid='".$_SESSION['docid']."' and dl.patientid='".s_for($_GET['pid'])."' 
			and (dl.paid_amount IS NULL || dl.paid_amount = 0)
		GROUP BY dl.ledgerid
 UNION
        select 
                'ledger_payment',
                dlp.id,
                dlp.payment_date,
                dlp.entry_date,
                CONCAT(p.first_name,' ',p.last_name),
                '',
                '',
                dlp.amount,
                '',
                dl.primary_claim_id,
		dlp.payer,
		dlp.payment_type,
		''
        from dental_ledger dl 
                LEFT JOIN dental_users p ON dl.producerid=p.userid 
                LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$_SESSION['docid']."' and dl.patientid='".s_for($_GET['pid'])."' 
			AND dlp.amount != 0
  UNION
	select 
                'ledger_paid',
                dl.ledgerid,
                dl.service_date,
                dl.entry_date,
                CONCAT(p.first_name,' ',p.last_name),
                dl.description,
                dl.amount,
                dl.paid_amount,
                dl.status,
                dl.primary_claim_id,
		tc.type,
		'',
		''	
        from dental_ledger dl 
                LEFT JOIN dental_users p ON dl.producerid=p.userid 
                LEFT JOIN dental_ledger_payment pay on pay.ledgerid=dl.ledgerid
		LEFT JOIN dental_transaction_code tc on tc.transaction_code = dl.transaction_code
                        where dl.docid='".$_SESSION['docid']."' and dl.patientid='".s_for($_GET['pid'])."' 
			AND (dl.paid_amount IS NOT NULL AND dl.paid_amount != 0)
  UNION
   	select 
		'note',
		n.id,
		n.service_date,
		n.entry_date,
		concat('Note - ', p.first_name,' ',p.last_name),
		n.note,
		'',
		'',
	 	n.private,
		'',
		'',
		'',
		''	
	from dental_ledger_note n
		LEFT JOIN dental_users p on n.producerid=p.userid
			where n.patientid='".s_for($_GET['pid'])."'       
			AND n.private!=1
  UNION
	select
		'claim',
		i.insuranceid,
		i.adddate,
		i.adddate,
		'Claim',
		'Insurance Claim',
		(select sum(dl2.amount) FROM dental_ledger dl2
				INNER JOIN dental_insurance i2 on dl2.primary_claim_id=i2.insuranceid
				where i2.insuranceid=i.insuranceid),
		sum(pay.amount),
		i.status,
		i.insuranceid,
		'',
		'',
		''
	from dental_insurance i
		LEFT JOIN dental_ledger dl ON dl.primary_claim_id=i.insuranceid
		LEFT JOIN dental_ledger_payment pay on dl.ledgerid=pay.ledgerid
		where i.patientid='".s_for($_GET['pid'])."'
	GROUP BY i.insuranceid

";


$my=mysqli_query($con, $sql) or trigger_error(mysqli_error($con), E_USER_ERROR);
$num_users=mysqli_num_rows($my);

$html = '';

$html .=' <table width="98%">
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="15%">
			Date
		</td>
                <td valign="top" class="col_head" width="20%">
                        Producer
                </td>

		<td valign="top" class="col_head" width="30%">
			Description
		</td>
		<td valign="top" width="12%">
			Charges
		</td>
		<td valign="top" width="11%">
			Credits
		</td>
		<td valign="top" width="12%">
			Balance
		</td>
	</tr>';

	 if(mysqli_num_rows($my) == 0)
	{ 
		$html .= '<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>';
	}
	else
	{
		$cur_bal = $cur_cha = $cur_pay = 0;
		$last_sd = '';
		$last_ed = '';
		while($myarray = mysqli_fetch_array($my))
		{
			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
			$tr_class = "tr_active";
                        if($myarray[0] == 'claim'){ $tr_class .= ' clickable_row'; }
			if($myarray[0] == 'ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){ $tr_class .= ' claimless clickable_row'; }
			if($myarray['status'] == 3 || $myarray['status'] == 5 || $myarray['status'] == 9){ $tr_class .= ' completed'; }
			$html .= '<tr class="'.$tr_class.' '. $myarray[0].'">';
				$html .= '<td valign="top">';
						$last_sd = $myarray["service_date"];
       					      	$html .= date('m-d-Y',strtotime(st($myarray["service_date"])));
				$html .= '</td>
				<td valign="top">';
                        $html .= st($myarray["name"]);
                              $html .=  '</td>
				<td valign="top">';
			$html .= ($myarray[0] == 'note' && $myarray['status']==1)?"(P) ":''; 
                        $html .= (($myarray[0] == 'ledger_paid'))?$dss_trxn_type_labels[$myarray['payer']]." - ":''; 
                	$html .= $myarray["description"]; 
			$html .= (($myarray[0] == 'ledger' || $myarray[0] =='claim') && $myarray['primary_claim_id'])?"(".$myarray['primary_claim_id'].") ":''; 
			$html .= ($myarray[0]=='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING)?' (Click to file)':''; 
			$html .= (($myarray[0] == 'ledger_payment'))?$dss_trxn_payer_labels[$myarray['payer']]." Payment - ":''; 
			$html .= (($myarray[0] == 'ledger_payment'))?$dss_trxn_pymt_type_labels[$myarray['payment_type']]." ":''; 
			$html .= (($myarray[0] == 'ledger_payment') && $myarray['primary_claim_id'])?"(".$myarray['primary_claim_id'].") ":''; 
				$html .= '</td>
				<td valign="top" align="right">';
					if(st($myarray["amount"]) <> 0 && $myarray[0]!='claim') {
	                	$html .= number_format(st($myarray["amount"]),2);
					 	if($myarray[0]!='claim'){
						$cur_bal += st($myarray["amount"]);
						$cur_cha += st($myarray["amount"]);	
						}
					}
				$html .= '</td>
				<td valign="top" align="right">';
					if(st($myarray["paid_amount"]) <> 0 && $myarray[0]!='claim') {
	                	$html .= number_format(st($myarray["paid_amount"]),2);
						if($myarray[0]!='claim'){
						$cur_bal -= st($myarray["paid_amount"]);
						$cur_pay += st($myarray["paid_amount"]);
						}
					}
				$html .= '</td>
				<td valign="top" align="right">';
					if($myarray[0]=='ledger' || $myarray[0] == 'ledger_paid' || $myarray[0] == 'ledger_paid' || $myarray[0] == 'ledger_payment')
					 $html .= number_format(st($cur_bal),2);
				$html .= '</td>
			</tr>';
	 	}
	}


$html .= '<tr>
	<td colspan="5" align="right">Balance Due</td>
	<td colspan="2" align="right">'.number_format(st($cur_bal),2).'</td></tr>';
$html .= '<tr>
        <td colspan="5" align="right">- Estimated Insurance:</td>
        <td colspan="2" align="right">0.00</td></tr>';
$html .= '<tr>
        <td colspan="5" align="right">>>>>>>>>>Balance Due Now:</td>
        <td colspan="2" align="right">'.number_format(st($cur_bal),2).'</td></tr>';
//echo $html;

$head = '<table><tr><td width="60%">';
$head .= '<div style="display:block; ">';
$head .= $docr['name'];
 if(st($docr['address']) <> '') {
        $head.='<br />' .
        st($docr['address']);
 }


$head .= '<br />'.st($docr['city']).', '.st($docr['state']).' '.st($docr['zip']);
$head .= '</div>';
$head .= '<br /><br />';
$head .= '<div style="display:block; ">';
$head .= $name;
 if(st($pat_myarray['add1']) <> '') {
        $head.='<br />' .
        st($pat_myarray['add1']);
 }

 if(st($pat_myarray['add2']) <> '') {
        $head .= '<br />' .
        st($pat_myarray['add2']);
 }

$head .= '<br />'.st($pat_myarray['city']).', '.st($pat_myarray['state']).' '.st($pat_myarray['zip']);
$head .= '</div>';
$head .= '<br /><br />';

$head .= 'Office: '.$docr['phone'];
$head .= '<br /><br />';
$head .= '</td>';
$head .= '<td>';
$head .= '*******STATEMENT********';
$head .= '<br />
<table cellspacing="2">
<tr><td align="right">Acct#:</td><td>'.$_GET['pid'].'</td></tr>
<tr><td align="right">Statement Date:</td><td>'.date('m/d/Y').'</td></tr>
<tr><td align="right">Balance Due:</td><td>'.number_format(st($cur_bal),2).'</td></tr>
<tr><td align="right">Due Date:</td><td>'.date('m/d/Y', strtotime("+30 days")).'</td></tr>
</table>';
$head .= '</td></tr></table>';
$html = $head.$html;

        // add new page for each user
        $pdf->AddPage();

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
}
}


//finish pdf
	$filename = '/manage/letterpdfs/unpaid_statement_'.date('YmdHis').'.pdf';
        $pdf->Output($_SERVER['DOCUMENT_ROOT'] . $filename, 'F');
//$pdf->Output('example_001.pdf', 'I');

/*	$state_sql = "INSERT INTO dental_ledger_statement SET
			producerid = '".mysqli_real_escape_string($con, $_SESSION['userid'])."',
			filename = '".mysqli_real_escape_string($con, $filename)."',
			service_date = CURDATE(),
			entry_date = CURDATE(),
			patientid = '".mysqli_real_escape_string($con, $_GET['pid'])."',
			adddate = now(),
			ip_address = '".$_SERVER['REMOTE_ADDR']."'";
	mysqli_query($con, $state_sql);
*/
?>
<script type="text/javascript">
  window.location = "<?= $filename; ?>";
</script>
<?php
// Extend the TCPDF class to create custom Header and Footer
/*class STATEMENTPDF extends TCPDF {

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
*/
?>
<script type="text/javascript">
function concat_checked(ids){
var s = '';
var first = true;
for(var i = 0; i < ids.length; i++){
if(ids[i].checked) {
if(first){
first=false;
}else{
s+=',';
}
s += ids[i].value;
}
}
return s;
}

</script>


