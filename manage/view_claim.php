<?php namespace Ds3\Libraries\Legacy; ?><?php 
  include "includes/top.htm";
?>
  <link rel="stylesheet" href="css/ledger.css" />
<?php
  if(!isset($_REQUEST['sort'])){
    $_REQUEST['sort'] = 'service_date';
    $_REQUEST['sortdir'] = 'desc';
  }

  if(isset($_REQUEST['file']) && $_REQUEST['file']==1){
    $id = claim_create_sec($_GET['pid'], $_GET['claimid'], '0', false);
?>
    <script type="text/javascript">
      window.location = "view_claim.php?claimid=<?php echo  $id; ?>&pid=<?php echo $_GET['pid'];?>";
    </script>
<?php
  }

  if(isset($_REQUEST['deleobid'])){
    $esql = "SELECT * FROM dental_insurance_file WHERE id=".mysqli_real_escape_string($con,$_GET['deleobid']);
    $eob = $db->getRow($esql);

    $isql = "SELECT * FROM dental_insurance WHERE insuranceid=".mysqli_real_escape_string($con,$_GET['claimid']);
    $ins = $db->getRow($isql);

    if (($eob['status'] == DSS_CLAIM_DISPUTE && $ins['status']==DSS_CLAIM_DISPUTE) || ($eob['status'] == DSS_CLAIM_SEC_DISPUTE && $ins['status'] == DSS_CLAIM_SEC_DISPUTE)){
      $dsql = "DELETE FROM dental_insurance_file WHERE id=".mysqli_real_escape_string($con,$_GET['deleobid'])." AND claimid=".mysqli_real_escape_string($con,$_GET['claimid']);
      if ($db->query($dsql)) {
        if ($eob['status'] == DSS_CLAIM_DISPUTE) {
          $del_pay = "DELETE FROM dental_ledger_payment 
                      WHERE payer=".DSS_TRXN_PAYER_PRIMARY." AND 
                      ledgerid in (SELECT ledgerid FROM dental_ledger dl WHERE dl.primary_claim_id=".mysqli_real_escape_string($con,$_GET['claimid']).")";
          $up_claim = "UPDATE dental_insurance SET status=".DSS_CLAIM_SENT." WHERE insuranceid=".mysqli_real_escape_string($con,$_GET['claimid']);
        } elseif ($eob['status'] == DSS_CLAIM_SEC_DISPUTE) {
          $del_pay = "DELETE FROM dental_ledger_payment  
                      WHERE payer=".DSS_TRXN_PAYER_SECONDARY." AND 
                      ledgerid in (SELECT ledgerid FROM dental_ledger dl WHERE dl.primary_claim_id=".mysqli_real_escape_string($con,$_GET['claimid']).")";
          $up_claim = "UPDATE dental_insurance SET status=".DSS_CLAIM_SEC_SENT." WHERE insuranceid=".mysqli_real_escape_string($con,$_GET['claimid']);
        }
        $db->query($del_pay);
        $db->query($up_claim);
        $msg = "Deleted succesfully.";
?>
  <script type="text/javascript">
    window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>&claimid=<?php echo  $_GET['claimid']; ?>&pid=<?php echo $_GET['pid'];?>";    
  </script>
<?php
      } else {
        $msg = "Error deleting EOB.";
?>
        <script type="text/javascript">
          alert("<?php echo  $msg; ?>");
          window.location="<?php echo $_SERVER['PHP_SELF']?>?claimid=<?php echo  $_GET['claimid']; ?>&pid=<?php echo $_GET['pid'];?>";    
        </script>
<?php
      } 
    } else {
      $msg = "You cannot delete an EOB after it is processed.";
?>
      <script type="text/javascript">
        alert("<?php echo  $msg; ?>");
        window.location="<?php echo $_SERVER['PHP_SELF']?>?claimid=<?php echo  $_GET['claimid']; ?>&pid=<?php echo $_GET['pid'];?>";    
      </script>
<?php
    }
  }
  $rec_disp = 200;

  if(!empty($_REQUEST["page"])) {
    $index_val = $_REQUEST["page"];
  } else {
    $index_val = 0;
  }
  
  $i_val = $index_val * $rec_disp;

$docId = intval($_SESSION['docid']);
$claimId = intval($_GET['claimid']);
$patientId = intval($_GET['pid']);

  $sql = "SELECT
        'ledger',
        dl.ledgerid,
        dl.service_date,
        dl.entry_date,
        p.name,
        dl.description,
        dl.amount,
        '' AS paid_amount,
        di.status,
        '' AS filename,
        '' AS payer,
        '' AS payment_type
    FROM dental_ledger dl
        INNER JOIN dental_insurance di ON dl.primary_claim_id = di.insuranceid
        LEFT JOIN dental_users p ON dl.producerid = p.userid
        LEFT JOIN dental_ledger_payment pay ON pay.ledgerid = dl.ledgerid
    WHERE dl.primary_claim_id = $claimId
        AND dl.docid = $docId
        AND dl.patientid = $patientId
    GROUP BY dl.ledgerid
UNION
    SELECT
        'ledger_payment',
        dlp.id,
        dlp.payment_date,
        dlp.entry_date,
        p.name,
        '',
        '',
        dlp.amount,
        '',
        dl.primary_claim_id,
        dlp.payer,
        dlp.payment_type
    FROM dental_ledger dl
        JOIN dental_users p ON dl.producerid = p.userid
        JOIN dental_ledger_payment dlp ON dlp.ledgerid = dl.ledgerid
    WHERE (dl.primary_claim_id = $claimId OR dl.secondary_claim_id = $claimId)
        AND dl.docid = $docId
        AND dl.patientid = $patientId
        AND (primary_claim_id = $claimId OR secondary_claim_id = $claimId)
        AND dlp.amount != 0
UNION
    SELECT
        'eob',
        dif.id,
        dif.adddate,
        dif.adddate,
        'EOB',
        CONCAT('EOB - ', dif.claimtype, ' Insurance'),
        '',
        '',
        di.status,
        dif.filename,
        '',
        ''
    FROM dental_insurance_file dif
        JOIN dental_insurance di ON di.insuranceid = dif.claimid
    WHERE dif.claimid = $claimId";

  if (isset($_REQUEST['sort'])) {
    if ($_REQUEST['sort'] == 'producer') {
      $sql .= " ORDER BY name ".$_REQUEST['sortdir']; 
    } else {
      $sql .= " ORDER BY ".$_REQUEST['sort']." ".$_REQUEST['sortdir'];
    }
  }

  $total_rec = $db->getNumberRows($sql);
  $no_pages = $total_rec/$rec_disp;

  $sql .= " limit ".$i_val.",".$rec_disp;
  $my = $db->getResults($sql);
  $num_users = count($my);

  $csql = "SELECT * FROM dental_insurance i WHERE i.insuranceid = ".mysqli_real_escape_string($con,(!empty($_GET['claimid']) ? $_GET['claimid'] : ''));
  $claim = $db->getRow($csql);

  $psql = "SELECT * FROM dental_patients WHERE patientid=".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''));
  $pat = $db->getRow($psql);
?>
<span style="float:right; font-size: 26px; margin-right: 20px; font-weight: bold; color:#f00;">
<?php
  $sec_sql = "SELECT insuranceid from dental_insurance where primary_claim_id='".mysqli_real_escape_string($con,$_GET['claimid'])."'";
  $sec_r = $db->getRow($sec_sql);
  if(!empty($sec_r)){
?>
Primary Claim <?= $_GET['claimid']; ?> - (<a href="view_claim.php?claimid=<?php echo $sec_r['insuranceid']; ?>&pid=<?php echo $_GET['pid']; ?>">Secondary is <?php echo $sec_r['insuranceid']; ?></a>) 
<?php
  }else{
?>
Claim <?= $_GET['claimid']; ?>
<?php echo (($claim['primary_claim_id'])?' - (<a href="view_claim.php?claimid='.$claim['primary_claim_id'].'&pid='.$_GET['pid'].'">Secondary to '.$claim['primary_claim_id'].'</a>)':''); ?>
  <?php } ?>
<?= " - ".$thename; ?></span>

  <span class="admin_head">
    Ledger Card
  </span>
  &nbsp;&nbsp;&nbsp;

<?php echo (!empty($name) ? $name : '');?>
<?php if(!empty($pat_myarray['add1'])) {?>
  <br />
  &nbsp;&nbsp;&nbsp;
  <?php echo st($pat_myarray['add1']);?>  
<?php } ?>

<?php if(!empty($pat_myarray['add2'])) {?>
  <br />
  &nbsp;&nbsp;&nbsp;
  <?php echo st($pat_myarray['add2']);?>  
<?php } ?>

  &nbsp;&nbsp;&nbsp;
<?php echo (!empty($pat_myarray['city']) ? st($pat_myarray['city']) : '');?>  

  &nbsp;&nbsp;&nbsp;
<?php echo (!empty($pat_myarray['state']) ? st($pat_myarray['state']) : '');?> 

  &nbsp;&nbsp;&nbsp;
<?php echo (!empty($pat_myarray['zip']) ? st($pat_myarray['zip']) : '');?> 

  <br />
  &nbsp;&nbsp;&nbsp;
  D: <?php echo (!empty($pat_myarray['work_phone']) ? st($pat_myarray['work_phone']) : '');?>

  &nbsp;&nbsp;&nbsp;
  H: <?php echo (!empty($pat_myarray['home_phone']) ? st($pat_myarray['home_phone']) : '');?>

  <br />
  &nbsp;&nbsp;&nbsp;
  W1: <?php echo (!empty($pat_myarray['cell_phone']) ? st($pat_myarray['cell_phone']) : '');?>

  <br />

  <script type="text/javascript" src="js/view_claim.js"></script>

  <br />
  <div style="float:left; margin-left:20px;">
    <?php if (!empty($claim['status']) && (
        (
            (
                $claim['status'] == DSS_CLAIM_PENDING ||
                $claim['status'] == DSS_CLAIM_REJECTED ||
                $claim['status'] == DSS_CLAIM_DISPUTE
            ) &&
            $pat['p_m_dss_file'] == 2
        ) || (
            (
                $claim['status'] == DSS_CLAIM_SEC_PENDING ||
                $claim['status'] == DSS_CLAIM_SEC_REJECTED ||
                $claim['status'] == DSS_CLAIM_SEC_DISPUTE
            ) &&
            $pat['s_m_dss_file'] == 2
        )
    )) { ?>
              <button onclick="Javascript: window.location='insurance_v2.php?insid=<?php echo $_GET["claimid"];?>&pid=<?php echo (!empty($_GET["pid"]) ? $_GET["pid"] : '');?>';" class="addButton mainButton">
                <?php if($claim['status'] == DSS_CLAIM_REJECTED || $claim['status'] == DSS_CLAIM_SEC_REJECTED) { ?>
                  Refile Paper
                <?php } else { ?>
                  Paper File
                <?php } ?>
              </button>
    <?php
      $api_sql = "SELECT use_eligible_api FROM dental_users
                  WHERE userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
      
      $api_r = $db->getRow($api_sql);
      if ($api_r['use_eligible_api'] == 1) {
    ?>
        <button onclick="Javascript: window.location='insurance_eligible.php?insid=<?php echo $_GET["claimid"];?>&pid=<?php echo (!empty($_GET["pid"]) ? $_GET["pid"] : '');?>';" class="addButton mainButton">
		<?php if($claim['status'] == DSS_CLAIM_REJECTED ||$claim['status'] == DSS_CLAIM_SEC_REJECTED){ ?>
            Refile E-File
		<?php } else { ?>
            E-File
		<?php } ?>
        </button>

    <?php } ?>
  	<?php } else { ?>
          <button onclick="Javascript: window.location='insurance_v2.php?insid=<?php echo (!empty($_GET["claimid"]) ? $_GET["claimid"] : '');?>&pid=<?php echo (!empty($_GET["pid"]) ? $_GET["pid"] : '');?>';" class="addButton">
  		      View CMS 1500
          </button>
  	<?php } ?>
  </div>

  <div align="right" style="clear: right;">
    <button onclick="Javascript: window.location = 'add_ledger_payments.php?cid=<?php echo (!empty($_GET["claimid"]) ? $_GET["claimid"] : '');?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>';" class="addButton mainButton">
      Make Payment
    </button>
    &nbsp;&nbsp;

    <?php
      if(!empty($claim['status']) && ($claim['status'] == DSS_CLAIM_PAID_INSURANCE || $claim['status']== DSS_CLAIM_PAID_PATIENT) &&
    	    $pat['s_m_relation']!='' && $pat['s_m_partyfname'] != "" && $pat['s_m_partylname'] != "" &&
          $pat['s_m_relation'] != "" && $pat['ins2_dob'] != "" && $pat['s_m_gender'] != "" &&
          $pat['s_m_ins_co'] != "" && $pat['s_m_ins_grp'] != "" && $pat['s_m_ins_type'] != '')
      {
      	$s_sql = "SELECT * FROM dental_insurance WHERE primary_claim_id='".$claim['insuranceid']."'";
      	if($db->getNumberRows($s_sql)==0){
    ?>
          <button onclick="Javascript: window.location='view_claim.php?claimid=<?php echo $_GET["claimid"];?>&pid=<?php echo $_GET['pid'];?>&file=1';" class="addButton">
            File Secondary
          </button>
          &nbsp;&nbsp;
    <?php } 
    	}
    ?>

    <?php
      $api_sql = "SELECT use_eligible_api FROM dental_users
                  WHERE userid='".mysqli_real_escape_string($con,$_SESSION['docid'])."'";
      $api_r = $db->getRow($api_sql);

      if ($api_r['use_eligible_api']==1) {
    ?>
        <button onclick="Javascript: window.location='claim_history.php?cid=<?php echo (!empty($_GET["claimid"]) ? $_GET["claimid"] : '');?>&pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>';" class="addButton">
          View History 
        </button>
        &nbsp;&nbsp;
    <?php } ?>

      <button onclick="Javascript: window.location='print_ledger_report.php?<?php echo  (isset($_GET['pid']))?'pid='.$_GET['pid']:'';?>';" class="addButton">
        Print Ledger
      </button>
  	  &nbsp;&nbsp;&nbsp;&nbsp;
  	
      <button onclick="Javascript: loadPopup('add_ledger_note.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : '');?>');" class="addButton">
        Add Note 
      </button>
      &nbsp;&nbsp;
        
    <?php if(!empty($claim['status']) && $claim['status'] == DSS_CLAIM_DISPUTE) {
      $s = "SELECT filename FROM dental_insurance_file f WHERE f.claimtype='primary' AND f.claimid='".mysqli_real_escape_string($con,$_GET['claimid'])."'";
      $file = $db->getRow($s);
    ?>
             
      <a href='display_file.php?f=<?php echo  $file['filename']; ?>' target="_blank" class="button">
        View EOB
      </a>
      &nbsp;&nbsp;
   
    <?php } elseif (!empty($claim['status']) && $claim['status'] == DSS_CLAIM_SEC_DISPUTE) { 
            $s = "SELECT filename FROM dental_insurance_file f WHERE f.claimtype='secondary' AND f.claimid='".mysqli_real_escape_string($con,$_GET['claimid'])."'";
            $file = $db->getRow($s);
    ?> 
            <a href='display_file.php?f=<?php echo  $file['filename']; ?>' target="_blank" class="button">
              View EOB
            </a>
            &nbsp;&nbsp;
   
    <?php } ?> 
  </div>

  <br />
  <div align="center" class="red">
  	<b><? echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
  </div>

  <form name="edit_mult_form" id="edit_mult_form" />
    <table  class="ledger" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
    	<?php if($total_rec > $rec_disp) { ?>
      	<tr bgColor="#ffffff">
      		<td  align="right" colspan="15" class="bp">
      			Pages: <?php paging($no_pages,$index_val,""); ?>
      		</td>        
      	</tr>
    	<?php }?>

    	<tr class="tr_bg_h">
    		<td valign="top" class="col_head  <?php echo  ($_REQUEST['sort'] == 'service_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
    			<a href="manage_ledger.php?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : '') ?>&sort=service_date&sortdir=<?php echo ($_REQUEST['sort']=='service_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Svc Date</a>
    		</td>
    		<td valign="top" class="col_head <?php echo  ($_REQUEST['sort'] == 'entry_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
    			<a href="manage_ledger.php?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : '') ?>&sort=entry_date&sortdir=<?php echo ($_REQUEST['sort']=='entry_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Entry Date</a>
    		</td>
        <td valign="top" class="col_head  <?php echo  ($_REQUEST['sort'] == 'producer')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="30%">
          <a href="manage_ledger.php?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : '') ?>&sort=producer&sortdir=<?php echo ($_REQUEST['sort']=='producer'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Producer</a>
        </td>
    		<td valign="top" class="col_head  <?php echo  ($_REQUEST['sort'] == 'description')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="30%">
    			<a href="manage_ledger.php?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : '') ?>&sort=description&sortdir=<?php echo ($_REQUEST['sort']=='description'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Description</a>
    		</td>
    		<td valign="top" class="col_head <?php echo  ($_REQUEST['sort'] == 'amount')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
    			<a href="manage_ledger.php?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : '') ?>&sort=amount&sortdir=<?php echo ($_REQUEST['sort']=='amount'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Charges</a>
    		</td>
    		<td valign="top" class="col_head <?php echo  ($_REQUEST['sort'] == 'paid_amount')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
    			<a href="manage_ledger.php?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : '') ?>&sort=paid_amount&sortdir=<?php echo ($_REQUEST['sort']=='paid_amount'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Credits</a>
    		</td>
    		<td valign="top" class="col_head" width="10%">
    			Balance
    		</td>
    		<td valign="top" class="col_head <?php echo  ($_REQUEST['sort'] == 'status')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="5%">
    			<a href="manage_ledger.php?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : '') ?>&sort=status&sortdir=<?php echo ($_REQUEST['sort']=='status'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Ins</a>
    		</td>
        <td valign="top" class="col_head" width="5%">
          Action 
        </td>
    	</tr>

    	<?php if($num_users == 0) { ?>
    		<tr class="tr_bg">
    			<td valign="top" class="col_head" colspan="10" align="center">
    				No Records
    			</td>
    		</tr>
    	<?php } else {
            		$cur_bal = 0;
            		$last_sd = '';
            		$last_ed = '';

            		foreach ($my as $myarray) {
            			if($myarray["status"] == 1) {
            				$tr_class = "tr_active";
            			}	else {
            				$tr_class = "tr_inactive";
            			}

            			$tr_class = "tr_active";
            			if($myarray['status']==DSS_CLAIM_REJECTED && !empty($myarray[0]) && $myarray[0]=='ledger'){
            			  $style='style="background:#f46;"';
            			} else {
            			  $style="";
            			}
                  
                  if($myarray['ledger'] == 'eob'){ $tr_class .= ' clickable_row'; }
            			if($myarray['ledger'] == 'eob' && ($myarray['status']!=DSS_CLAIM_DISPUTE && $myarray['status']!=DSS_CLAIM_SEC_DISPUTE)){ $tr_class .= ' eob_text'; }
                  if($myarray['ledger'] == 'eob' && ($myarray['status']==DSS_CLAIM_DISPUTE || $myarray['status']==DSS_CLAIM_SEC_DISPUTE)){ $tr_class .= ' eob_dispute_text'; }
    	?>
    		<tr	class="<?php echo $tr_class;?> <?php echo  $myarray['ledger']; ?>" <?php echo $style; ?>>
  				<td <?php if($myarray['ledger'] == "eob"){ echo 'onclick="window.location=\'display_file.php?f='.$myarray['filename'].'\'"'; } ?> valign="top">
  					<?php
              if($myarray["service_date"]!=$last_sd){
  						  $last_sd = $myarray["service_date"];
         				echo date('m-d-Y',strtotime(st($myarray["service_date"])));
              }
            ?>
  				</td>
  				<td <?php if($myarray['ledger']=="eob"){ echo 'onclick="window.location=\'display_file.php?f='.$myarray['filename'].'\'"'; } ?> valign="top">
  					<?php
              if($myarray["entry_date"]!=$last_ed){
                $last_ed = $myarray["entry_date"];
                echo date('m-d-Y',strtotime(st($myarray["entry_date"])));
              }
            ?>
  				</td>
          <td <?php if($myarray['ledger']=="eob"){ echo 'onclick="window.location=\'display_file.php?f='.$myarray['filename'].'\'"'; } ?> valign="top">
            <?php echo st($myarray["name"]);?>
            <?php
              if($myarray['ledger']=='eob' && ($myarray['status']==DSS_CLAIM_DISPUTE || $myarray['status']==DSS_CLAIM_SEC_DISPUTE)){
    				    echo " (".$dss_claim_status_labels[$myarray['status']].")";
    			    }
            ?>
          </td>
  				<td <?php if($myarray['ledger']=="eob"){ echo 'onclick="window.location=\'display_file.php?f='.$myarray['filename'].'\'"'; } ?> valign="top">
            <?php echo st(ucWords($myarray["description"]));?>
            <?php echo  (($myarray['ledger'] == 'ledger_payment'))?$dss_trxn_payer_labels[$myarray['payer']]." Payment - ":''; ?>
            <?php echo  (($myarray['ledger'] == 'ledger_payment'))?$dss_trxn_pymt_type_labels[$myarray['payment_type']]." ":''; ?>
  				</td>
  				<td <?php if($myarray['ledger']=="eob"){ echo 'onclick="window.location=\'display_file.php?f='.$myarray['filename'].'\'"'; } ?> valign="top" align="right">
  					<?php if(st($myarray["amount"]) <> 0) {?>
      	            <?php echo number_format(st($myarray["amount"]),2);?>
      					    <?php	$cur_bal += st($myarray["amount"]);
                  }
            ?>
  					&nbsp;
  				</td>
  				<td <?php if($myarray['ledger']=="eob"){ echo 'onclick="window.location=\'display_file.php?f='.$myarray['filename'].'\'"'; } ?> valign="top" align="right">
  					<?php if(st($myarray["paid_amount"]) <> 0) { ?>
  	          <?php echo number_format(st($myarray["paid_amount"]),2);?>
  					<?php 
  						$cur_bal -= st($myarray["paid_amount"]);
  					}?>
  					&nbsp;
  				</td>
  				<td <?php if($myarray['ledger']=="eob"){ echo 'onclick="window.location=\'display_file.php?f='.$myarray['filename'].'\'"'; } ?> valign="top" align="right">
  					<?php echo number_format(st($cur_bal),2);?>
            &nbsp;
  				</td>
  				<td <?php if($myarray['ledger']=="eob"){ echo 'onclick="window.location=\'display_file.php?f='.$myarray['filename'].'\'"'; } ?> valign="top">
            <?php
               echo (!empty($dss_claim_status_labels[$myarray["status"]]) ? $dss_claim_status_labels[$myarray["status"]] : ''); 
            ?>       	
  				</td>
  				<td valign="top">
  					<?php if($myarray['ledger']=='ledger_payment'){ ?>
              <a href="Javascript:;" onclick="javascript: loadPopup('edit_ledger_payment.php?ed=<?php echo $myarray["ledgerid"];?>&pid=<?php echo $_GET['pid'];?>');" class="editlink" title="PAYMENT">
                Edit 
              </a>
  					<?php } ?>
  				</td>
    		</tr>
    	<?php	}
    	  }
      ?>
      
      <tr>
        <td colspan="8">
        	<center>
        		<button onclick="Javascript: window.location='manage_ledger.php?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : '');?>';return false;" class="addButton">
              Return to Patient Ledger
            </button>
          </center>
        </td>
      </tr> 
    </table>
  </form> 

<?php 
  if ($api_r['use_eligible_api'] == 1) {
    $_GET['cid'] = (!empty($_GET['claimid']) ? $_GET['claimid'] : '');
    include 'claim_history_data.php'; 
  }

  include 'claim_notes.php';
?>

  <div id="popupContact" style="width:750px;">
      <a id="popupContactClose">
        <button>X</button>
      </a>
      <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
  </div>

  <div id="backgroundPopup"></div>
  
<?php 
  if(isset($_GET['inspay']) && $_GET['inspay']==1){ ?>
    <script type="text/javascript">
    	window.location('add_ledger_payments.php?cid=<?=$_GET["claimid"];?>&pid=<?=$_GET['pid'];?>');
    </script>
<?php } ?>

  <br /><br />	

<?php include "includes/bottom.htm";?>
