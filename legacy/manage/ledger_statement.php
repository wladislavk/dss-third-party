<?php namespace Ds3\Libraries\Legacy; ?><?php
	//header("Content-type:application/pdf");

	// It will be called downloaded.pdf
	//header("Content-Disposition:attachment;filename='downloaded.pdf'");
	include_once('3rdParty/tcpdf/config/lang/eng.php');
	include_once('3rdParty/tcpdf/tcpdf.php');

	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");
	//include "includes/general_functions.php";
	include_once('includes/dental_patient_summary.php');
	include_once('includes/patient_info.php');
	include_once('includes/constants.inc');

    $sql = "SELECT  "
         . "  dl.amount, sum(pay.amount) as paid_amount "
         . "FROM dental_ledger dl  "
         . "LEFT JOIN dental_ledger_payment pay on pay.ledgerid = dl.ledgerid  "
         . "WHERE dl.docid='".$_SESSION['docid']."' AND dl.patientid='".s_for($_GET['pid'])."'  "
         . "GROUP BY dl.ledgerid";

    $result = $db->getResults($sql);

	$docr = array();
	if ($patient_info || count($result)) {
		$docsql = "SELECT * FROM dental_users where userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
		
		$docr = $db->getRow($docsql);
		$ledger_balance = 0;
		if ($result) foreach ($result as $row) {
			$ledger_balance -= $row['amount'];
			$ledger_balance += $row['paid_amount'];
		}

		update_patient_summary($_GET['pid'], 'ledger', $ledger_balance);
?>
<?php
		if(!isset($_REQUEST['sort'])){
			$_REQUEST['sort'] = 'service_date';
			$_REQUEST['sortdir'] = 'desc';
		}

		if(isset($_REQUEST["delid"]) && $_REQUEST["delid"] != "") {
			$pat_sql2 = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
			
			$pat_my2 = $db->getResults($pat_sql2);
			if ($pat_my2) foreach ($pat_my2 as $pat_myarray2){ 
				$pat_sql3 = $db->query("INSERT INTO dental_ledger_rec (userid, patientid, service_date, description, amount, paid_amount,transaction_code, ip_address, transaction_type) VALUES ('".$_SESSION['username']."','".$_GET['pid']."','".$pat_myarray2['service_date']."','".$pat_myarray2['description']."','".$pat_myarray2['amount']."','".$pat_myarray2['paid_amount']."','".$pat_myarray2['transaction_code']."','".$pat_myarray2['ip_address']."','".$pat_myarray2['transaction_type']."');");
				if(!$pat_sql3){
					echo "There was an error updating the ledger record.  Please contact your system administrator.";
				}
  			}  

			$del_sql = "delete from dental_ledger where ledgerid='".$_REQUEST["delid"]."'";
			
			$db->query($del_sql);
			$msg = "Deleted Successfully";
?>			
			<?php if($_GET['popup']==1) { ?>
				<script type="text/javascript">
  					parent.window.location.reload();
  				</script>
			<?php }else{ ?>
				<script type="text/javascript">
					window.location = "<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>&pid=<?php echo $_GET['pid'];?>";
				</script>
			<?php } ?>
<?php
			trigger_error("Die called", E_USER_ERROR);
		}

		if(isset($_REQUEST["delclaimid"]) && $_REQUEST["delclaimid"] != "") {
            deleteClaim($_REQUEST['delclaimid'], DSS_CLAIM_PENDING);
            $msg = "Deleted Successfully";
?>
        	<?php if($_GET['popup']==1) { ?>
        		<script type="text/javascript">
                	parent.window.location.reload();
                </script>
            <?php }else{ ?>
            	<script type="text/javascript">
                	window.location = "<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>&pid=<?php echo $_GET['pid'];?>";
                </script>
            <?php } ?>
<?php
        	trigger_error("Die called", E_USER_ERROR);
		}

		$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
		
		$pat_myarray = $db->getRow($pat_sql); 
		$name = st($pat_myarray['firstname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['lastname']);

		if($pat_myarray['patientid'] == '') {
?>
			<script type="text/javascript">
				window.location = 'manage_patient.php';
			</script>
<?php
			trigger_error("Die called", E_USER_ERROR);
		}

		$rec_disp = 200;
		if(isset($_REQUEST["page"]) && $_REQUEST["page"] != "") {
			$index_val = $_REQUEST["page"];
		} else {
			$index_val = 0;
		}
	
		$i_val = $index_val * $rec_disp;
		if(isset($_GET['openclaims']) && $_GET['openclaims']==1){
			$sql = "select
                'claim',
                i.insuranceid as ledgerid,
                i.adddate as service_date,
                i.adddate as entry_date,
                'Claim' as name,
                'Insurance Claim' as description,
                (select sum(dl2.amount) FROM dental_ledger dl2
                INNER JOIN dental_insurance i2 on dl2.primary_claim_id=i2.insuranceid
                where i2.insuranceid=i.insuranceid) as amount,
                sum(pay.amount) as paid_amount,
                i.status,
                i.insuranceid as primary_claim_id
        		from dental_insurance i
                LEFT JOIN dental_ledger dl ON dl.primary_claim_id=i.insuranceid
                LEFT JOIN dental_ledger_payment pay on dl.ledgerid=pay.ledgerid
                where i.patientid='".s_for($_GET['pid'])."'
				AND i.status NOT IN (".DSS_CLAIM_PAID_INSURANCE.", ".DSS_CLAIM_PAID_SEC_INSURANCE.", ".DSS_CLAIM_PAID_PATIENT.")
		        GROUP BY i.insuranceid
				";
		}else{
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
				LEFT JOIN dental_transaction_code tc on tc.transaction_code = dl.transaction_code AND tc.docid='".$_SESSION['docid']."'
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
		}

		if(isset($_REQUEST['sort'])){
			if($_REQUEST['sort']=='producer'){
				$sql .= " ORDER BY name ".$_REQUEST['sortdir']; 
			}else{
				$sql .= " ORDER BY ".$_REQUEST['sort']." ".$_REQUEST['sortdir'];
			}
		}

		$my = $db->getResults($sql);
		$num_users = count($my);
?>
		<!--
		<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
		<script src="admin/popup/popup.js" type="text/javascript"></script>
		-->
<?php
		$html = '';
?>

	<script type="text/javascript" src="/manage/js/ledger_statement.js"></script>

<?php
	$html .=' <table width="98%">
		<tr class="tr_bg_h">
			<td valign="top" class="col_head" width="15%">
				Date
			</td>
            <td valign="top" class="col_head" width="20%">
                Producer
            </td>
			<td valign="top" class="col_head" width="20%">
				Description
			</td>
			<td valign="top" width="12%">
				Charges
			</td>
			<td valign="top" width="11%">
				Credits
			</td>
            <td valign="top" width="10%">
                Adj.
            </td>
			<td valign="top" width="12%">
				Balance
			</td>
		</tr>';

	if($num_users == 0) {
		$html .= '<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>';
	} else {
		$cur_bal = $cur_cha = $cur_pay = $cur_adj = 0;
		$my2 = $db->getResults($sql);

		foreach ($my2 as $myarray){
			if($myarray['ledger'] !='claim'){
				$cur_bal += st($myarray["amount"]);
			}
			if($myarray['ledger'] !='claim'){
				$cur_bal -= st($myarray["paid_amount"]);
			}
			$orig_bal = $cur_bal;
		}

		$last_sd = '';
		$last_ed = '';
		foreach ($my as $myarray)
		{
			if($myarray["status"] == 1) {
				$tr_class = "tr_active";
			} else {
				$tr_class = "tr_inactive";
			}

			$tr_class = "tr_active";
            if($myarray['ledger']  == 'claim'){
            	$tr_class .= ' clickable_row';
            }

			if($myarray['ledger']  == 'ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING){
				$tr_class .= ' claimless clickable_row';
			}

			if($myarray['status'] == 3 || $myarray['status'] == 5 || $myarray['status'] == 9){
				$tr_class .= ' completed';
			}

			$html .= '<tr class="'.$tr_class.' '. $myarray['ledger'] .'">';
			$html .= '<td valign="top">';
			$last_sd = $myarray["service_date"];
       		$html .= date('m-d-Y',strtotime(st($myarray["service_date"])));
			$html .= '</td>
				<td valign="top">';
            $html .= st($myarray["name"]);
            $html .=  '</td>
				<td valign="top">';
			$html .= ($myarray['ledger']  == 'note' && $myarray['status']==1)?"(P) ":''; 
            $html .= (($myarray['ledger']  == 'ledger_paid'))?$dss_trxn_type_labels[$myarray['payer']]." - ":''; 
            $html .= $myarray["description"]; 
			$html .= (($myarray['ledger']  == 'ledger' || $myarray['ledger']  =='claim') && $myarray['primary_claim_id'])?"(".$myarray['primary_claim_id'].") ":''; 
			$html .= ($myarray['ledger'] =='ledger' && !$myarray['primary_claim_id'] && $myarray['status'] == DSS_TRXN_PENDING)?' (Click to file)':''; 
			$html .= (($myarray['ledger']  == 'ledger_payment'))?$dss_trxn_payer_labels[$myarray['payer']]." Payment - ":''; 
			$html .= (($myarray['ledger']  == 'ledger_payment'))?$dss_trxn_pymt_type_labels[$myarray['payment_type']]." ":''; 
			$html .= (($myarray['ledger']  == 'ledger_payment') && $myarray['primary_claim_id'])?"(".$myarray['primary_claim_id'].") ":''; 
			$html .= '</td>
				<td valign="top" align="right">';

			if(st($myarray["amount"]) <> 0 && $myarray['ledger'] !='claim') {
            	$html .= number_format(st($myarray["amount"]),2);
			 	if($myarray['ledger'] !='claim'){
					$cur_bal -= st($myarray["amount"]);
					$cur_cha += st($myarray["amount"]);	
				}
			}

			$html .= '</td>';
		    if($myarray['ledger']  == 'ledger_paid' && $myarray['payer']==DSS_TRXN_TYPE_ADJ){
	        	$html .= '<td></td>';
	        }

			$html .= '<td valign="top" align="right">';
			if(st($myarray["paid_amount"]) <> 0 && $myarray['ledger'] !='claim') {
				$html .= number_format(st($myarray["paid_amount"]),2);
				if($myarray['ledger'] !='claim'){
					$cur_bal += st($myarray["paid_amount"]);
					$cur_pay += st($myarray["paid_amount"]);
				}
			}
				
			$html .= '</td>';
			if(!($myarray['ledger']  == 'ledger_paid' && $myarray['payer']==DSS_TRXN_TYPE_ADJ)){ 
                $html .= '<td></td>';
			}

			$html .= '<td valign="top" align="right">';
			if($myarray['ledger'] =='ledger' || $myarray['ledger']  == 'ledger_paid' || $myarray['ledger']  == 'ledger_paid' || $myarray['ledger']  == 'ledger_payment')
				$html .= number_format(st($cur_bal),2);
			$html .= '</td>
			</tr>';
	 	}
	}

	$html .= '<tr>
		<td colspan="5" align="right">Balance Due</td>
		<td colspan="2" align="right">'.number_format(st(!empty($orig_bal) ? $orig_bal : 0),2).'</td></tr>';
	$html .= '<tr>
        <td colspan="5" align="right">- Estimated Insurance:</td>
        <td colspan="2" align="right">0.00</td></tr>';
	$html .= '<tr>
        <td colspan="5" align="right">>>>>>>>>>Balance Due Now:</td>
        <td colspan="2" align="right">'.number_format(st(!empty($orig_bal) ? $orig_bal : 0),2).'</td></tr>';
}

	$head = '<table><tr><td width="60%">';
	$head .= '<div style="display:block; ">';
	$head .= (!empty($docr['practice']) ? $docr['practice'] : '');
	$head.='<br />'; 
	$head .= (!empty($docr['first_name']) ? $docr['first_name'] : '')." ".(!empty($docr['last_name']) ? $docr['last_name'] : '');
	
	if(isset($docr['address']) && st($docr['address']) <> '') {
	    $head.='<br />' .
	    st($docr['address']);
	}

	$head .= '<br />'.st((!empty($docr['city']) ? $docr['city'] : '')).', '.st((!empty($docr['state']) ? $docr['state'] : '')).' '.st((!empty($docr['zip']) ? $docr['zip'] : ''));
	$head .= '</div>';
	$head .= '<br /><br /><br /><br />';
	$head .= '<div style="display:block; ">';
	$head .= (isset($name) ? $name : '');

	if(isset($pat_myarray['add1']) && st($pat_myarray['add1']) <> '') {
		$head.='<br />' .
		st($pat_myarray['add1']);
	}

	if(isset($pat_myarray['add2']) && st($pat_myarray['add2']) <> '') {
	    $head .= '<br />' .
	    st($pat_myarray['add2']);
	}

	$head .= '<br />'.st((!empty($pat_myarray['city']) ? $pat_myarray['city'] : '')).', '.st((!empty($pat_myarray['state']) ? $pat_myarray['state'] : '')).' '.st((!empty($pat_myarray['zip']) ? $pat_myarray['zip'] : ''));
	$head .= '</div>';
	$head .= '<br /><br />';
	$head .= 'Office: '.format_phone((!empty($docr['phone']) ? $docr['phone'] : ''));
	$head .= '<br /><br />';
	$head .= '</td>';
	$head .= '<td>';
	$head .= '*******STATEMENT********';
	$head .= '<br />
		<table cellspacing="2">
		<tr><td align="right">Acct#:</td><td>'.(!empty($_GET['pid']) ? $_GET['pid'] : '').'</td></tr>
		<tr><td align="right">Statement Date:</td><td>'.date('m/d/Y').'</td></tr>
		<tr><td align="right">Balance Due:</td><td>'.number_format(st((isset($orig_bal) ? $orig_bal : 0)),2).'</td></tr>
		<tr><td align="right">Due Date:</td><td>'.date('m/d/Y', strtotime("+30 days")).'</td></tr>
		</table>';
	$head .= '</td></tr></table>';
	$html = $head . (!empty($html) ? $html : '');

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

    // add a page
    $pdf->AddPage();

    // output the HTML content
    $pdf->writeHTML($html, true, false, true, false, '');

	$filename = '/manage/letterpdfs/statement_'.(!empty($_GET['pid']) ? $_GET['pid'] : '').'_'.date('YmdHis').'.pdf';

	$state_sql = "INSERT INTO dental_ledger_statement SET
				  producerid = '".mysqli_real_escape_string($con,$_SESSION['userid'])."',
				  filename = '".mysqli_real_escape_string($con,$filename)."',
				  service_date = CURDATE(),
				  entry_date = CURDATE(),
				  patientid = '".mysqli_real_escape_string($con,$_GET['pid'])."',
				  adddate = now(),
				  ip_address = '".$_SERVER['REMOTE_ADDR']."'";

	$db->query($state_sql);
    $pdf->Output($_SERVER['DOCUMENT_ROOT'] . $filename, 'F');

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $filename)) {
        ?>
		<script type="text/javascript">
			window.location = "<?php echo  $filename; ?>";
		</script>
<?php } else {
        header('HTTP/1.0 404 Not Found');

        ?>
        <h2>Ledger Not Found</h2>
        <p>The statement you are looking for could not be found. If you think this is a mistake, please contact the site administrator for help.</p>
<?php }
