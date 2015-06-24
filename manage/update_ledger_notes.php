<?php namespace Ds3\Libraries\Legacy; ?><?php 
	include_once('admin/includes/main_include.php');
	include("includes/sescheck.php");
?>

<html>
	<head>
	</head>

	<body>
		<?php
			if (!isset($sqlinsertqry)) {
				$sqlinsertqry = '';
			}
			$sqlinsertqry .= "UPDATE `dental_ledger_note` SET "; 
			$private = (!empty($_POST['private']) && $_POST['private'])?1:0;
			$sqlinsertqry .= "service_date = '".date('Y-m-d', strtotime((!empty($_POST['entry_date']) ? $_POST['entry_date'] : '')))."', entry_date = '".date('Y-m-d', strtotime((!empty($_POST['entry_date']) ? $_POST['entry_date'] : '')))."', note = '".(!empty($_POST['note']) ? $_POST['note'] : '')."', private = '".$private."', producerid = '".(!empty($_POST['producer']) ? $_POST['producer'] : '')."' WHERE id=".(!empty($_POST['id']) ? $_POST['id'] : '');

			$insqry = $db->query($sqlinsertqry);
			if (!$insqry) {
?>
				<script type="text/javascript">
					alert('Could not add ledger note, please close this window and contact your system administrator');
					eraseCookie('tempforledgerentry');
				</script>                               
				<?php echo  $sqlinsertqry; ?>
<?php
			} else {
?>
				<script type="text/javascript">
					alert('Note successfully added!');
					parent.window.location = parent.window.location;
				</script>
<?php
			}

			if (!isset($sqlinsertqry2)) {
				$sqlinsertqry2 = '';
			}

			$sqlinsertqry2 .= "INSERT INTO `dental_ledger_rec` (
								`ledgerid` ,
								`patientid` ,
								`service_date` ,
								`entry_date` ,
								`description` ,
								`producer` ,
								`amount` ,
								`transaction_type` ,
								`paid_amount` ,
								`userid` ,
								`docid` ,
								`status` ,
								`adddate` ,
								`ip_address` ,
								`transaction_code`
							   ) VALUES ";

        $txcode['description'] = mysql_real_escape_string($txcode['description']);
        
			if (!empty($_POST['form'])) foreach($_POST['form'] as $form) {
				if($d <= $i) {
					$descsql = "SELECT description, transaction_code FROM dental_transaction_code WHERE transaction_codeid='".$form['proccode']."' LIMIT 1;";
					
					$txcode = $db->getRow($descsql);

					if($form['procedure_code'] == '1' && $form['service_date'] != '' && $form['amount'] != ''){
						$sqlinsertqry2 .= "( NULL , '".$_POST['patientid']."', '".$form['service_date']."', '".$form['entry_date']."', '".$txcode['description']."', NULL, '".$form['amount']."', 'Charge', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form['status']."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."'),";
					} elseif($form['procedure_code'] == '2' && $form['service_date'] != '' && $form['amount'] != '' || $form['procedure_code'] == '3' && $form['service_date'] != '' && $form['amount'] != '') {
						$sqlinsertqry2 .= "( NULL , '".$_POST['patientid']."', '".$form['service_date']."', '".$form['entry_date']."', '".$txcode['description']."', NULL, NULL, 'Credit', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form['status']."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."'),";
					}elseif($form['procedure_code'] == '6' && $form['proccode'] == '100' && $form['service_date'] != '' && $form['amount'] != ''){
						$sqlinsertqry2 .= "( NULL , '".$_POST['patientid']."', '".$form['service_date']."', '".$form['entry_date']."', '".$txcode['description']."', NULL, NULL, 'Debit-Prod Adj', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form['status']."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."'),";
					}elseif($form['procedure_code'] == '6' && $form['proccode'] != '100' && $form['service_date'] != '' && $form['amount'] != ''){
						$sqlinsertqry2 .= "( NULL , '".$_POST['patientid']."', '".$form['service_date']."', '".$form['entry_date']."', '".$txcode['description']."', NULL, NULL, 'Credit-Coll Adj', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form['status']."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."'),";
					}else{
						$sqlinsertqry2 .= "( NULL , '".$_POST['patientid']."', '".$form['service_date']."', '".$form['entry_date']."', '".$txcode['description']."', NULL, NULL, 'None', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form['status']."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."'),";
					}
				} elseif($d == $i) {
					$descsql = "SELECT description, transaction_code FROM dental_transaction_code WHERE transaction_code='".$form['proccode']."' LIMIT 1;";
					
					$descquery = $db->getResults($descsql);
					if ($descquery) foreach ($descquery as $txcode) {
						if($form['procedure_code'] == '1' && $form['service_date'] != '' && $form['amount'] != ''){
							$service_date = $form['service_date'];
							$sqlinsertqry2 .= "( NULL , '".$_POST['patientid']."', '".$service_date."', '".$form['entry_date']."', '".$txcode['description']."', NULL, '".$form['amount']."', 'Charge', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form['status']."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."')";
						} elseif($form['procedure_code'] == '2' && $form['service_date'] != '' && $form['amount'] != '' || $form['procedure_code'] == '3' && $form['service_date'] != '' && $form['amount'] != '') {
							$sqlinsertqry2 .= "( NULL , '".$_POST['patientid']."', '".$form['service_date']."', '".$form['entry_date']."', '".$txcode['description']."', NULL, NULL, 'Credit', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form['status']."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."')";
						}elseif($form['procedure_code'] == '6' && $form['proccode'] == '100' && $form['service_date'] != '' && $form['amount'] != '') {
							$sqlinsertqry2 .= "( NULL , '".$_POST['patientid']."', '".$form['service_date']."', '".$form['entry_date']."', '".$txcode['description']."', NULL, NULL, 'Debit-Prod Adj', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form['status']."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."')";
						}elseif($form['procedure_code'] == '6' && $form['proccode'] != '100' && $form['service_date'] != '' && $form['amount'] != ''){
							$sqlinsertqry2 .= "( NULL , '".$_POST['patientid']."', '".$form['service_date']."', '".$form['entry_date']."', '".$txcode['description']."', NULL, NULL, 'Credit-Coll Adj', '".$form['amount']."', '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form['status']."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."')";
						}elseif($form['service_date'] != '' && $form['amount'] != ''){
							$sqlinsertqry2 .= "( NULL , '".$_POST['patientid']."', '".$form['service_date']."', '".$form['entry_date']."', '".$txcode['description']."', NULL, NULL, 'None', NULL, '".$_SESSION['userid']."', '".$_SESSION['docid']."', '".$form['status']."', '".date('m/d/Y')."', '".$_SERVER['REMOTE_ADDR']."', '".$txcode['transaction_code']."')";
						}
						$d++;
					}
				}

				if (strripos($sqlinsertqry2, ',') == (strlen($sqlinsertqry2) - 1)) {
					$sqlinsertqry2 = substr($sqlinsertqry2, 0, -1) . ";";
				}

				$insqry = $db->query($sqlinsertqry2);
			}
?>
	</body>
</html>
