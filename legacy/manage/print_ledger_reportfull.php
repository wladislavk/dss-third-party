<?php namespace Ds3\Libraries\Legacy; ?><?php
	include "admin/includes/main_include.php";
	include "includes/constants.inc";

	$rec_disp = 200;
	if(isset($_REQUEST["page"]) && $_REQUEST["page"] != "") {
		$index_val = $_REQUEST["page"];
	} else {
		$index_val = 0;
	}
		
	$i_val = $index_val * $rec_disp;
	$sql = "select * from dental_ledger where docid='".$_SESSION['docid']."' order by service_date limit 0, 10;";
	
	if((!isset($_POST['dailysub']) || $_POST['dailysub'] != 1) && (!isset($_POST['monthlysub']) || $_POST['monthlysub'] != 1)){
		$sql = "select dl.*, p.name from dental_ledger AS dl LEFT JOIN dental_users as p ON dl.producerid=p.userid where dl.docid='".$_SESSION['docid']."' AND dl.service_date=CURDATE() order by dl.service_date;";

		$sql = "select 
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
                '' as payment_type
        		from dental_ledger dl 
                JOIN dental_patients as pat ON dl.patientid = pat.patientid
                LEFT JOIN dental_users as p ON dl.producerid=p.userid 
		        where dl.docid='".$_SESSION['docid']."' 
		        AND dl.service_date=CURDATE()
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
                dlp.payment_type
        		from dental_ledger dl 
                JOIN dental_patients pat on dl.patientid = pat.patientid
                LEFT JOIN dental_users p ON dl.producerid=p.userid 
                LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                where dl.docid='".$_SESSION['docid']."' 
                AND dlp.amount != 0
                AND dlp.payment_date=CURDATE()
				";
    }

	$my = $db->getResults($sql);
	$num_users = count($my);
?>

	<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
	<script src="admin/popup/popup.js" type="text/javascript"></script>

	<span class="admin_head">
		Ledger Report
		<?php if(isset($_POST['dailysub']) && $_POST['dailysub'] == 1) { ?>
		    (<i><?php echo $_POST['d_mm']?>-<?php echo $_POST['d_dd']?>-<?php echo $_POST['d_yy']?></i>)
		<?php }
		
		if(isset($_POST['monthlysub']) && $_POST['monthlysub'] == 1) { ?>
			(<i><?php echo $_POST['d_mm']?>-<?php echo $_POST['d_yy']?></i>)
		<?php }
		
		if($_GET['pid'] <> '') { ?>
			(<i><?php echo isset($thename) ? $thename : '';?></i>)
		<?php } ?>
	</span>

	<link rel="stylesheet" href="css/manage.css" type="text/css" media="screen" />

	<div align="center" class="red">
		<b><?php echo isset($_GET['msg']) ? $_GET['msg'] : '';?></b>
	</div>
	<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
		<?php if(isset($total_rec) && ($total_rec > $rec_disp)) { ?>
			<tr bgColor="#ffffff">
				<td  align="right" colspan="15" class="bp">
					Pages:
					<?php
						paging($no_pages,$index_val,"");
					?>
				</td>        
			</tr>
		<?php } ?>
		<tr class="tr_bg_h">
			<td valign="top" class="col_head" width="10%">
				Svc Date
			</td>
			<td valign="top" class="col_head" width="10%">
				Entry Date
			</td>
			<td valign="top" class="col_head" width="10%">
				Patient
			</td>
			<td valign="top" class="col_head" width="10%">
				Producer
			</td>
			<td valign="top" class="col_head" width="30%">
				Description
			</td>
			<td valign="top" class="col_head" width="10%">
				Charges
			</td>
			<td valign="top" class="col_head" width="10%">
				Credits
			</td>
			<td valign="top" class="col_head" width="10%">
				Adjustments	
			</td>
			<td valign="top" class="col_head" width="5%">
				Ins
			</td>
		</tr>
		<?php if($num_users == 0) { ?>
			<tr class="tr_bg">
				<td valign="top" class="col_head" colspan="10" align="center">
					No Records
				</td>
			</tr>
		<?php } else {
				$tot_charges = 0;
				$tot_credit = 0;
				$tot_adj = 0;
				foreach ($my as $myarray) {
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
					<tr class="<?php echo $tr_class;?>">
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
							<?php echo (($myarray[0] == 'ledger_payment'))?$dss_trxn_payer_labels[$myarray['payer']]." Payment - ":''; ?>
	                        <?php echo (($myarray[0] == 'ledger_payment'))?$dss_trxn_pymt_type_labels[$myarray['payment_type']]." ":''; ?>
	                        <?php echo (($myarray[0] == 'ledger'))?$myarray["description"]:'';?>
						</td>
						<td valign="top" align="right" width="10%">
	        				<?php
	          					echo $myarray["amount"];
		  						$tot_charges += $myarray["amount"];
	          				?>
							&nbsp;
						</td>
                        <?php if($myarray[0] == 'ledger_paid' && $myarray['payer'] == DSS_TRXN_TYPE_ADJ) { ?>
                            <td></td>
                            <?php
                                if($myarray[0]!='claim'){
                                    $tot_adj += st($myarray["paid_amount"]);
                                }
                            ?>
                        <?php } ?>
						<td valign="top" align="right" width="10%">
							<?php if(st($myarray["paid_amount"]) <> 0) { ?>
			                	<?php echo number_format(st($myarray["paid_amount"]),2); ?>
							<?php } ?>
							&nbsp;
						</td>
                        <?php if(!($myarray[0] == 'ledger_paid' && $myarray['payer']==DSS_TRXN_TYPE_ADJ)) { ?>
	                        <?php
		                        if($myarray[0]!='claim') {
		                        	$tot_credit += st($myarray["paid_amount"]);
		                        }
	                        ?>
	                        <td></td>
                       	<?php } ?>
						<td valign="top" width="5%">&nbsp;
         					<?php if($myarray["status"] == 1) {
	           					echo "Sent";
	          				} elseif($myarray["status"] == 2) {
             					echo "Filed";
            				} else {
             					echo "Pend";
            				}
				}
		?>       	
						</td>
					</tr>
		<?php 
			}
		?> 
					<tr>
                        <td valign="top" colspan="5" align="right">
                            <b>Daily Balance</b>
                        </td>
                        <td valign="top" align="right">
                            <b>
                            <?php echo "$".number_format(isset($tot_charges) ? $tot_charges : 0,2); ?>
                            &nbsp;
                            </b>
                        </td>
                        <td valign="top" align="right">
                            <b>
                            <?php echo "$".number_format(isset($tot_credit) ? $tot_credit : 0,2);?>
                            &nbsp;
                            </b>
                        </td>
                        <td valign="top" align="right">
                            <b>
                            <?php echo "$".number_format(isset($tot_adj) ? $tot_adj : 0,2);?>
                            &nbsp;
                            </b>
                        </td>
                        <td valign="top">&nbsp;</td>
                	</tr>
	</table>

	<?php include 'ledger_summary_reportfull.php'; ?>

	<br /><br />

	<script type="text/javascript">
		window.print();
	</script>
