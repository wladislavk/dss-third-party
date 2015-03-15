<?php namespace Ds3\Libraries\Legacy; ?><h2 class="fullwidth"><?php echo  (!empty($producer['first_name']) ? $producer['first_name'] : '')." ".(!empty($producer['last_name']) ? $producer['last_name'] : ''); ?></h2>

<table class="ledger" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head <?php echo  (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'service_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="ledger_report.php?dailysub=<?php echo (!empty($_REQUEST['dailysub']) ? $_REQUEST['dailysub'] : '');?>&monthlysub=<?php echo (!empty($_REQUEST['monthlysub']) ? $_REQUEST['monthlysub'] : '');?>&start_date=<?php echo (isset($start_date) ? $start_date : '');?>&end_date=<?php echo (isset($end_date) ? $end_date : '');?>&rangesub=<?php echo (!empty($_REQUEST['rangesub']) ? $_REQUEST['rangesub'] : '');?>&weeklysub=<?php echo (!empty($_REQUEST['weeklysub']) ? $_REQUEST['weeklysub'] : '');?><?php echo  (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=service_date&sortdir=<?php echo (isset($_REQUEST['sort']) && $_REQUEST['sort']=='service_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Svc Date</a>
		</td>
		<td valign="top" class="col_head <?php echo  (isset($_REQUEST['sort']) && $_REQUEST['sort'] == 'entry_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="ledger_report.php?dailysub=<?php echo (!empty($_REQUEST['dailysub']) ? $_REQUEST['dailysub'] : '');?>&monthlysub=<?php echo (!empty($_REQUEST['monthlysub']) ? $_REQUEST['monthlysub'] : '');?>&start_date=<?php echo (isset($start_date) ? $start_date : '');?>&end_date=<?php echo (isset($end_date) ? $end_date : '');?>&rangesub=<?php echo (!empty($_REQUEST['rangesub']) ? $_REQUEST['rangesub'] : '');?>&weeklysub=<?php echo (!empty($_REQUEST['weeklysub']) ? $_REQUEST['weeklysub'] : '');?><?php echo  (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=entry_date&sortdir=<?php echo (isset($_REQUEST['sort']) && $_REQUEST['sort']=='entry_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Entry Date</a>
		</td>
		<td valign="top" class="col_head <?php echo  (isset($_REQUEST['sort']) && $_REQUEST['sort'] == 'patient')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="ledger_report.php?dailysub=<?php echo (!empty($_REQUEST['dailysub']) ? $_REQUEST['dailysub'] : '');?>&monthlysub=<?php echo (!empty($_REQUEST['monthlysub']) ? $_REQUEST['monthlysub'] : '');?>&start_date=<?php echo (isset($start_date) ? $start_date : '');?>&end_date=<?php echo (isset($end_date) ? $end_date : '');?>&rangesub=<?php echo (!empty($_REQUEST['rangesub']) ? $_REQUEST['rangesub'] : '');?>&weeklysub=<?php echo (!empty($_REQUEST['weeklysub']) ? $_REQUEST['weeklysub'] : '');?><?php echo  (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=patient&sortdir=<?php echo (isset($_REQUEST['sort']) && $_REQUEST['sort']=='patient'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Patient</a>
		</td>
		<td valign="top" class="col_head <?php echo  (isset($_REQUEST['sort']) && $_REQUEST['sort'] == 'producer')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="ledger_report.php?dailysub=<?php echo (!empty($_REQUEST['dailysub']) ? $_REQUEST['dailysub'] : '');?>&monthlysub=<?php echo (!empty($_REQUEST['monthlysub']) ? $_REQUEST['monthlysub'] : '');?>&start_date=<?php echo (isset($start_date) ? $start_date : '');?>&end_date=<?php echo (isset($end_date) ? $end_date : '');?>&rangesub=<?php echo (!empty($_REQUEST['rangesub']) ? $_REQUEST['rangesub'] : '');?>&weeklysub=<?php echo (!empty($_REQUEST['weeklysub']) ? $_REQUEST['weeklysub'] : '');?><?php echo  (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=producer&sortdir=<?php echo (isset($_REQUEST['sort']) && $_REQUEST['sort']=='producer'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Producer</a>
		</td>
		<td valign="top" class="col_head <?php echo  (isset($_REQUEST['sort']) && $_REQUEST['sort'] == 'description')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="30%">
			<a href="ledger_report.php?dailysub=<?php echo (!empty($_REQUEST['dailysub']) ? $_REQUEST['dailysub'] : '');?>&monthlysub=<?php echo (!empty($_REQUEST['monthlysub']) ? $_REQUEST['monthlysub'] : '');?>&start_date=<?php echo (isset($start_date) ? $start_date : '');?>&end_date=<?php echo (isset($end_date) ? $end_date : '');?>&rangesub=<?php echo (!empty($_REQUEST['rangesub']) ? $_REQUEST['rangesub'] : '');?>&weeklysub=<?php echo (!empty($_REQUEST['weeklysub']) ? $_REQUEST['weeklysub'] : '');?><?php echo  (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=description&sortdir=<?php echo (isset($_REQUEST['sort']) && $_REQUEST['sort']=='description'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Description</a>
		</td>
		<td valign="top" class="col_head <?php echo  (isset($_REQUEST['sort']) && $_REQUEST['sort'] == 'amount')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="ledger_report.php?dailysub=<?php echo (!empty($_REQUEST['dailysub']) ? $_REQUEST['dailysub'] : '');?>&monthlysub=<?php echo (!empty($_REQUEST['monthlysub']) ? $_REQUEST['monthlysub'] : '');?>&start_date=<?php echo (isset($start_date) ? $start_date : '');?>&end_date=<?php echo (isset($end_date) ? $end_date : '');?>&rangesub=<?php echo (!empty($_REQUEST['rangesub']) ? $_REQUEST['rangesub'] : '');?>&weeklysub=<?php echo (!empty($_REQUEST['weeklysub']) ? $_REQUEST['weeklysub'] : '');?><?php echo  (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=amount&sortdir=<?php echo (isset($_REQUEST['sort']) && $_REQUEST['sort']=='amount'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Charges</a>
		</td>
		<td valign="top" class="col_head <?php echo  (isset($_REQUEST['sort']) && $_REQUEST['sort'] == 'paid_amount')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="ledger_report.php?dailysub=<?php echo (!empty($_REQUEST['dailysub']) ? $_REQUEST['dailysub'] : '');?>&monthlysub=<?php echo (!empty($_REQUEST['monthlysub']) ? $_REQUEST['monthlysub'] : '');?>&start_date=<?php echo (isset($start_date) ? $start_date : '');?>&end_date=<?php echo (isset($end_date) ? $end_date : '');?>&rangesub=<?php echo (!empty($_REQUEST['rangesub']) ? $_REQUEST['rangesub'] : '');?>&weeklysub=<?php echo (!empty($_REQUEST['weeklysub']) ? $_REQUEST['weeklysub'] : '');?><?php echo  (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=paid_amount&sortdir=<?php echo (isset($_REQUEST['sort']) && $_REQUEST['sort']=='paid_amount'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Credits</a>
		</td>
		<td valign="top" class="col_head <?php echo  (isset($_REQUEST['sort']) && $_REQUEST['sort'] == 'status')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="5%">
			<a href="ledger_report.php?dailysub=<?php echo (!empty($_REQUEST['dailysub']) ? $_REQUEST['dailysub'] : '');?>&monthlysub=<?php echo (!empty($_REQUEST['monthlysub']) ? $_REQUEST['monthlysub'] : '');?>&start_date=<?php echo (isset($start_date) ? $start_date : '');?>&end_date=<?php echo (isset($end_date) ? $end_date : '');?>&rangesub=<?php echo (!empty($_REQUEST['rangesub']) ? $_REQUEST['rangesub'] : '');?>&weeklysub=<?php echo (!empty($_REQUEST['weeklysub']) ? $_REQUEST['weeklysub'] : '');?><?php echo  (isset($_GET['pid']))?'&pid='.$_GET['pid']:'';?>&sort=status&sortdir=<?php echo (isset($_REQUEST['sort']) && $_REQUEST['sort']=='status'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Ins</a>
		</td>
	</tr>

	<?php if(!empty($num_users)) { ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<?php } else {
		$tot_charge = 0;
		$tot_credit = 0;

        if(isset($_GET['pid'])){
            $lpsql = " AND dl.patientid = '".$_GET['pid']."'";
            $npsql = " AND n.patientid = '".$_GET['pid']."'";
            $ipsql = " AND i.patientid = '".$_GET['pid']."'";
        }else{
            $ipsql = $lpsql = $npsql= "";
        }

        if(!empty($start_date)){
           $l_date = " AND dl.service_date BETWEEN '".$start_date."' AND '".$end_date."'";
           $n_date = " AND n.entry_date BETWEEN '".$start_date."' AND '".$end_date."'";
           $i_date = " AND i.adddate  BETWEEN '".$start_date."' AND '".$end_date."'";
   		   $p_date = " AND dlp.payment_date BETWEEN '".$start_date."' AND '".$end_date."'";
           $newquery .= " AND service_date BETWEEN '".$start_date."' AND '".$end_date."'";
        } else {
           $p_date = $i_date = $n_date = $l_date = '';
        }

		$newquery = "
			select 
            'ledger',
            dl.ledgerid,
            dl.service_date,
            dl.entry_date,
            dl.amount,
            dl.paid_amount,
            dl.status, 
            dl.description,
            CONCAT(p.first_name,' ',p.last_name) as name,
            pat.patientid,
            pat.firstname, 
            pat.lastname,
            '' as payer,
            '' as payment_type,
			dl.primary_claim_id
	        from dental_ledger dl 
            JOIN dental_patients as pat ON dl.patientid = pat.patientid
            LEFT JOIN dental_users as p ON dl.producerid=p.userid 
	        where dl.docid='".$_SESSION['docid']."' ".$lpsql." 
			AND dl.producerid='".mysqli_real_escape_string($con, (!empty($producer['userid']) ? $producer['userid'] : ''))."'
			".$l_date."
 			UNION
        	select 
            'ledger_payment',
            dlp.id,
            dlp.payment_date,
            dlp.entry_date,
            '',
            dlp.amount,
            '',
            '',
            CONCAT(p.first_name,' ',p.last_name),
            pat.patientid,
            pat.firstname,
            pat.lastname,
            dlp.payer,
            dlp.payment_type,
			''
        	from dental_ledger dl 
            JOIN dental_patients pat on dl.patientid = pat.patientid
            LEFT JOIN dental_users p ON dl.producerid=p.userid 
            LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
            where dl.docid='".$_SESSION['docid']."' ".$lpsql."
			AND dl.producerid='".mysqli_real_escape_string($con,(!empty($producer['userid']) ? $producer['userid'] : ''))."'
            AND dlp.amount != 0
			".$p_date."
			";
/*
		if($_REQUEST['dailysub'] || $_REQUEST['weeklysub'] || $_REQUEST['monthlysub'] || $_REQUEST['rangesub'])
		//$newquery .= " AND service_date BETWEEN '".$start_date."' AND '".$end_date."'";
*/
		if(isset($_REQUEST['sort'])){
			if($_REQUEST['sort'] == 'patient'){
				$newquery .= " ORDER BY lastname ".$_REQUEST['sortdir'].", dp.firstname ".$_REQUEST['sortdir'];
			}elseif($_REQUEST['sort'] == 'producer'){
				$newquery .= " ORDER BY name ".$_REQUEST['sortdir'];
			}else{
				$newquery .= " ORDER BY ".$_REQUEST['sort']." ".$_REQUEST['sortdir'];	
			}
		}

		$runquery = $db->getResults($newquery);
		if ($runquery) foreach ($runquery as $myarray) {
			$pat_sql = "select * from dental_patients where patientid='".$myarray['patientid']."'";
			
			$pat_myarray = $db->getRow($pat_sql);		
			$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename'])." ".st($pat_myarray['firstname']);
			
			if($myarray["status"] == 1) {
				$tr_class = "tr_active";
			} else {
				$tr_class = "tr_inactive";
			}
			$tr_class = "tr_active";
	?>
			<tr onclick="window.location = 'manage_ledger.php?pid=<?php echo  $myarray['patientid']; ?>'" class="clickable_row <?php echo $tr_class;?> <?php echo  $myarray['ledger']; ?>">
				<td valign="top" width="10%">
                	<?php echo date('m-d-Y',strtotime(st($myarray["service_date"])));?>
				</td>
				<td valign="top" width="10%">
                	<?php echo date('m-d-Y',strtotime(st($myarray["entry_date"])));?>
				</td>
				<td valign="top" width="10%">
                	<?php echo st($name);?>
				</td>
				<td valign="top" width="10%">
                	<?php echo st($myarray["name"]);?>
				</td>
				<td valign="top" width="30%">
					<?php if($myarray['ledger']=='ledger_payment'){ ?>
						<?php echo  $dss_trxn_payer_labels[$myarray['payer']]; ?> Payment - <?php echo  $dss_trxn_pymt_type_labels[$myarray['payment_type']]; ?>
					<?php }else{ ?>
		                	<?php echo st($myarray["description"]);?>
		                        <?php echo  ($myarray['primary_claim_id'])?" (".$myarray['primary_claim_id'].")":'';?>
					<?php } ?>
				</td>
				<td valign="top" align="right" width="10%">
		          	<?php
		          	echo number_format($myarray["amount"],2);
		          	$tot_charge += $myarray["amount"];
		          	?>
					&nbsp;
				</td>
				<td valign="top" align="right" width="10%">
					<?php if(st($myarray["paid_amount"]) <> 0) {?>
	                	<?php echo number_format(st($myarray["paid_amount"]),2);?>
					<?php 
						$tot_credit += st($myarray["paid_amount"]);
					}?>
					&nbsp;
				</td>
				<td valign="top" width="5%">&nbsp;
			 		<?php if($myarray['ledger'] == 'ledger'){
                  		echo (!empty($dss_trxn_status_labels) ? $dss_trxn_status_labels[$myarray["status"]] : '');
        			}elseif($myarray['ledger'] == 'claim'){
                  		echo (!empty($dss_claim_status_labels) ? $dss_claim_status_labels[$myarray["status"]] : '');
        			}
	
		}			?>       	
				</td>
			</tr>
	<?php
	}
	?> 
	
	<tr>
		<td valign="top" colspan="5" align="right">
			<b>Total</b>
		</td>
		<td valign="top" align="right">
			<?php
				if(isset($_GET['pid'])){
					$ledgerquery = "SELECT * FROM dental_ledger WHERE `patientid` =".$_GET['pid']." AND `transaction_type` = 'Charge'";
				}else{
					$ledgerquery = "SELECT * FROM dental_ledger WHERE `docid` =".$_SESSION['docid']." AND `transaction_type` = 'Charge'";
				}

				$myarray = $db->getRow($ledgerquery);
				if(isset($_GET['pid'])){
					$ledgerquery2 = "SELECT * FROM dental_ledger WHERE `patientid` =".$_GET['pid']." and `transaction_type`='Credit'";
				}else{
					$ledgerquery2 = "SELECT * FROM dental_ledger WHERE `docid` =".$_SESSION['docid']." and `transaction_type`='Credit'";
				}

				$ledgerres2 = $db->getResults($ledgerquery2);
				$myarray2 = $ledgerres2[0];

				if (!isset($cur_bal)) {
					$cur_bal = '';
				}

				if(st($myarray["amount"]) <> 0) {
					$cur_bal += st($myarray["amount"]);
				}
	          	$i = 0;
	                    
	          	if($i < count($ledgerres2)){
	                $cur_bal2 = $myarray2['paid_amount'];
	            }
	            $i++;
	          			
	            $cur_balfinal = $cur_bal - $cur_bal2;

	            if (!isset($tot_charge)) {
	            	$tot_charge = 0;
	            }

	            if (!isset($tot_credit)) {
	            	$tot_credit = 0;
	            }
	    	?>      
	                    
			<b>
				<?php echo "$".number_format($tot_charge,2); ?>
				&nbsp;
			</b>
		</td>
		<td valign="top" align="right">
			<b>
				<?php echo "$".number_format($tot_credit,2);?>
				&nbsp;
			</b>
		</td>
		<td valign="top">&nbsp;
			
		</td>
	</tr>
	<tr>
        <td valign="top" colspan="5" align="right">
            <b>Balance</b>
        </td>
        <td valign="top" align="right">
            <b>
	            <?php echo "$".number_format($tot_charge-$tot_credit,2); ?>
	            &nbsp;
            </b>
        </td>
        <td valign="top" align="right">
        </td>
        <td valign="top">&nbsp;

        </td>
    </tr>

</table>
