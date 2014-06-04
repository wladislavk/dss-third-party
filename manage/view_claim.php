<? 
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
    window.location = "view_claim.php?claimid=<?= $id; ?>&pid=<?=$_GET['pid'];?>";
  </script>
  <?php
}

if(isset($_REQUEST['deleobid'])){
  $esql = "SELECT * FROM dental_insurance_file WHERE id=".mysql_real_escape_string($_GET['deleobid']);
  $eq = mysql_query($esql);
  $eob = mysql_fetch_assoc($eq);
  $isql = "SELECT * FROM dental_insurance WHERE insuranceid=".mysql_real_escape_string($_GET['claimid']);
  $iq = mysql_query($isql);
  $ins = mysql_fetch_assoc($iq);
  if( ($eob['status'] == DSS_CLAIM_DISPUTE && $ins['status']==DSS_CLAIM_DISPUTE) || ($eob['status'] == DSS_CLAIM_SEC_DISPUTE && $ins['status'] == DSS_CLAIM_SEC_DISPUTE)){
    $dsql = "DELETE FROM dental_insurance_file WHERE id=".mysql_real_escape_string($_GET['deleobid'])." AND claimid=".mysql_real_escape_string($_GET['claimid']);
    if(mysql_query($dsql)){
      if($eob['status']==DSS_CLAIM_DISPUTE){
        $del_pay = "DELETE FROM dental_ledger_payment 
		WHERE payer=".DSS_TRXN_PAYER_PRIMARY." AND 
			ledgerid in 
				(SELECT ledgerid FROM dental_ledger dl WHERE dl.primary_claim_id=".mysql_real_escape_string($_GET['claimid']).")";
	$up_claim = "UPDATE dental_insurance SET status=".DSS_CLAIM_SENT." WHERE insuranceid=".mysql_real_escape_string($_GET['claimid']);
      }elseif($eob['status']==DSS_CLAIM_SEC_DISPUTE){
        $del_pay = "DELETE FROM dental_ledger_payment  
                WHERE payer=".DSS_TRXN_PAYER_SECONDARY." AND 
                        ledgerid in 
                                (SELECT ledgerid FROM dental_ledger dl WHERE dl.primary_claim_id=".mysql_real_escape_string($_GET['claimid']).")";
        $up_claim = "UPDATE dental_insurance SET status=".DSS_CLAIM_SEC_SENT." WHERE insuranceid=".mysql_real_escape_string($_GET['claimid']);
      }
      mysql_query($del_pay);
      mysql_query($up_claim);
      $msg = "Deleted succesfully.";
      ?>
	<script type="text/javascript">
          window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>&claimid=<?= $_GET['claimid']; ?>&pid=<?=$_GET['pid'];?>";    
 	</script>
      <?php
    }else{
	$msg = "Error deleting EOB.";
    ?>
        <script type="text/javascript">
          alert("<?= $msg; ?>");
          window.location="<?=$_SERVER['PHP_SELF']?>?claimid=<?= $_GET['claimid']; ?>&pid=<?=$_GET['pid'];?>";    
        </script>
    <?php
    } 
  }else{
    $msg = "You cannot delete an EOB after it is processed.";
    ?>
        <script type="text/javascript">
	  alert("<?= $msg; ?>");
          window.location="<?=$_SERVER['PHP_SELF']?>?claimid=<?= $_GET['claimid']; ?>&pid=<?=$_GET['pid'];?>";    
        </script>
    <?php
  }
}

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
		p.name,
 		dl.description,
		dl.amount,
		'' as paid_amount,
		di.status,
		'' AS filename,
                '' as payer,
                '' as payment_type
	from dental_ledger dl 
		INNER JOIN dental_insurance di ON dl.primary_claim_id = di.insuranceid
		LEFT JOIN dental_users p ON dl.producerid=p.userid 
		LEFT JOIN dental_ledger_payment pay ON pay.ledgerid=dl.ledgerid
			where dl.primary_claim_id=".$_GET['claimid']."  AND dl.docid='".$_SESSION['docid']."' and dl.patientid='".s_for($_GET['pid'])."' 
		GROUP BY dl.ledgerid 
 UNION
        select 
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
        from dental_ledger dl 
                LEFT JOIN dental_users p ON dl.producerid=p.userid 
                LEFT JOIN dental_ledger_payment dlp on dlp.ledgerid=dl.ledgerid
                        where dl.docid='".$_SESSION['docid']."' and dl.patientid='".s_for($_GET['pid'])."' 
                        AND primary_claim_id=".$_GET['claimid']." 
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
	from dental_insurance_file dif
		JOIN dental_insurance di ON di.insuranceid=dif.claimid
		where dif.claimid=".mysql_real_escape_string($_GET['claimid'])."
";

if(isset($_REQUEST['sort'])){
  if($_REQUEST['sort']=='producer'){
    $sql .= " ORDER BY name ".$_REQUEST['sortdir']; 
  }else{
    $sql .= " ORDER BY ".$_REQUEST['sort']." ".$_REQUEST['sortdir'];
  }
}

$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

$csql = "SELECT * FROM dental_insurance i WHERE i.insuranceid = ".mysql_real_escape_string($_GET['claimid']);
$cq = mysql_query($csql);
$claim = mysql_fetch_assoc($cq);

$psql = "SELECT * FROM dental_patients WHERE patientid=".mysql_real_escape_string($_GET['pid']);
$pq = mysql_query($psql);
$pat = mysql_fetch_assoc($pq);
?>
<span style="float:right; font-size: 26px; margin-right: 20px; font-weight: bold; color:#f00;">Claim <?= $_GET['claimid']." - ".$thename; ?></span>

<span class="admin_head">
	Ledger Card
</span>
&nbsp;&nbsp;&nbsp;
<?=$name;?>
<? if(st($pat_myarray['add1']) <> '') {?>
	<br />
	&nbsp;&nbsp;&nbsp;
	<?=st($pat_myarray['add1']);?>	
<? }?>

<? if(st($pat_myarray['add2']) <> '') {?>
	<br />
	&nbsp;&nbsp;&nbsp;
	<?=st($pat_myarray['add2']);?>	
<? }?>

&nbsp;&nbsp;&nbsp;
<?=st($pat_myarray['city']);?>	

&nbsp;&nbsp;&nbsp;
<?=st($pat_myarray['state']);?>	

&nbsp;&nbsp;&nbsp;
<?=st($pat_myarray['zip']);?>	

<br />
&nbsp;&nbsp;&nbsp;
D: <?=st($pat_myarray['work_phone']);?>

&nbsp;&nbsp;&nbsp;
H: <?=st($pat_myarray['home_phone']);?>

<br />
&nbsp;&nbsp;&nbsp;
W1: <?=st($pat_myarray['cell_phone']);?>



<br />
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
<br />
<div style="float:left; margin-left:20px;">
<?php if(
(($claim['status'] == DSS_CLAIM_PENDING || $claim['status'] == DSS_CLAIM_REJECTED ||$claim['status'] == DSS_CLAIM_DISPUTE)
&&
$pat['p_m_dss_file']=='2'
)
||
 (($claim['status'] == DSS_CLAIM_SEC_PENDING || $claim['status'] == DSS_CLAIM_SEC_REJECTED ||$claim['status'] == DSS_CLAIM_SEC_DISPUTE)
&&
$pat['s_m_dss_file']=='2'
)
){ ?>	
        <button onclick="Javascript: window.location='insurance_v2.php?insid=<?=$_GET["claimid"];?>&pid=<?=$_GET["pid"];?>';" class="addButton">
                <?php if($claim['status'] == DSS_CLAIM_REJECTED ||$claim['status'] == DSS_CLAIM_SEC_REJECTED){ ?>
                Refile Paper
                <?php }else{ ?>
                Paper File
                <?php } ?>
        </button>
        <button onclick="Javascript: window.location='insurance_eligible.php?insid=<?=$_GET["claimid"];?>&pid=<?=$_GET["pid"];?>';" class="addButton">
		<?php if($claim['status'] == DSS_CLAIM_REJECTED ||$claim['status'] == DSS_CLAIM_SEC_REJECTED){ ?>
                Refile E-File
		<?php }else{ ?>
                E-File
		<?php } ?>
        </button>
	<?php }else{ ?>
        <button onclick="Javascript: window.location='insurance_v2.php?insid=<?=$_GET["claimid"];?>&pid=<?=$_GET["pid"];?>';" class="addButton">
		View CMS 1500
        </button>
	<?php } ?>
</div>
<?php 
/*
if($claim['status'] == DSS_CLAIM_SEC_PENDING || $claim['status'] == DSS_CLAIM_SEC_SENT ||$claim['status'] == DSS_CLAIM_SEC_REJECTED ||$claim['status'] == DSS_CLAIM_SEC_DISPUTED){ ?>
<div style="float:left; margin-left:20px;">
  <?php if( $claim['secondary_claim_version'] == "1"){ ?>
        <button onclick="Javascript: window.location='insurance.php?insid=<?=$_GET["claimid"];?>&pid=<?=$_GET["pid"];?>&instype=2';" class="addButton">
                View Secondary 1500
        </button>
	<?php }else{ ?>
        <button onclick="Javascript: window.location='insurance_v2.php?insid=<?=$_GET["claimid"];?>&pid=<?=$_GET["pid"];?>&instype=2';" class="addButton">
                View Secondary 1500
        </button>
	<?php } ?>
</div>
<?php } ?>
*/ ?>
<div align="right" style="clear: right;">
<?php
  if(
	($claim['status'] == DSS_CLAIM_PAID_INSURANCE || $claim['status']== DSS_CLAIM_PAID_PATIENT) &&
	$pat['s_m_relation']!='' &&
        $pat['s_m_partyfname'] != "" && 
        $pat['s_m_partylname'] != "" &&
        $pat['s_m_relation'] != "" &&
        $pat['ins2_dob'] != "" &&
        $pat['s_m_gender'] != "" &&
        $pat['s_m_ins_co'] != "" &&
        $pat['s_m_ins_grp'] != "" &&
        $pat['s_m_ins_type'] != '')
{

	$s_sql = "SELECT * FROM dental_insurance WHERE primary_claim_id='".$claim['insuranceid']."'";
	$s_q = mysql_query($s_sql);
	if(mysql_num_rows($s_q)==0){
?>
        <button onclick="Javascript: window.location='view_claim.php?claimid=<?=$_GET["claimid"];?>&pid=<?=$_GET['pid'];?>&file=1';" class="addButton">
               File Secondary
        </button>
        &nbsp;&nbsp;
<?php } 
	} ?>
<?php
  $api_sql = "SELECT use_eligible_api FROM dental_users
                WHERE userid='".mysql_real_escape_string($_SESSION['docid'])."'";
  $api_q = mysql_query($api_sql);
  $api_r = mysql_fetch_assoc($api_q);
  if($api_r['use_eligible_api']==1){
?>
        <button onclick="Javascript: window.location='claim_history.php?cid=<?=$_GET["claimid"];?>&pid=<?=$_GET['pid'];?>';" class="addButton">
               View History 
        </button>
        &nbsp;&nbsp;
<?php } ?>
        <button onclick="Javascript: window.location = 'add_ledger_payments.php?cid=<?=$_GET["claimid"];?>&pid=<?=$_GET['pid'];?>';" class="addButton">
               Make Payment 
        </button>
        &nbsp;&nbsp;

<button onclick="Javascript: window.location='print_ledger_report.php?<?= (isset($_GET['pid']))?'pid='.$_GET['pid']:'';?>';" class="addButton">
                Print Ledger
        </button>
	&nbsp;&nbsp;&nbsp;&nbsp;
	
        <button onclick="Javascript: loadPopup('add_ledger_note.php?pid=<?=$_GET['pid'];?>');" class="addButton">
                Add Note 
        </button>
        &nbsp;&nbsp;
      
        <?php if($claim['status'] == DSS_CLAIM_DISPUTE){
            $s = "SELECT filename FROM dental_insurance_file f WHERE f.claimtype='primary' AND f.claimid='".mysql_real_escape_string($_GET['claimid'])."'";
            $sq = mysql_query($s);
            $file = mysql_fetch_assoc($sq);
            ?>
           
           <a href='display_file.php?f=<?= $file['filename']; ?>' target="_blank" class="button">
               View EOB
           </a>
           &nbsp;&nbsp;
 
        <?php }elseif($claim['status'] == DSS_CLAIM_SEC_DISPUTE){ 
            $s = "SELECT filename FROM dental_insurance_file f WHERE f.claimtype='secondary' AND f.claimid='".mysql_real_escape_string($_GET['claimid'])."'";
            $sq = mysql_query($s);
            $file = mysql_fetch_assoc($sq);
            ?>
           
           <a href='display_file.php?f=<?= $file['filename']; ?>' target="_blank" class="button">
               View EOB
           </a>
           &nbsp;&nbsp;
 
        <?php } ?> 

        <button onclick="javascript: loadPopup('edit_ledger_entries.php?pid=<?=$_GET['pid'];?>&ids='+concat_checked(document.forms['edit_mult_form'].elements['edit_mult[]']));" class="addButton">
               Edit Multiple
        </button>
        &nbsp;&nbsp;

</div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<form name="edit_mult_form" id="edit_mult_form" />
<table  class="ledger" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<? if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"");
			?>
		</TD>        
	</TR>
	<? }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'service_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_ledger.php?pid=<?= $_GET['pid'] ?>&sort=service_date&sortdir=<?php echo ($_REQUEST['sort']=='service_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Svc Date</a>
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'entry_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_ledger.php?pid=<?= $_GET['pid'] ?>&sort=entry_date&sortdir=<?php echo ($_REQUEST['sort']=='entry_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Entry Date</a>
		</td>
                <td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'producer')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="30%">
                        <a href="manage_ledger.php?pid=<?= $_GET['pid'] ?>&sort=producer&sortdir=<?php echo ($_REQUEST['sort']=='producer'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Producer</a>
                </td>

		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'description')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="30%">
			<a href="manage_ledger.php?pid=<?= $_GET['pid'] ?>&sort=description&sortdir=<?php echo ($_REQUEST['sort']=='description'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Description</a>
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'amount')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_ledger.php?pid=<?= $_GET['pid'] ?>&sort=amount&sortdir=<?php echo ($_REQUEST['sort']=='amount'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Charges</a>
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'paid_amount')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_ledger.php?pid=<?= $_GET['pid'] ?>&sort=paid_amount&sortdir=<?php echo ($_REQUEST['sort']=='paid_amount'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Credits</a>
		</td>
		<td valign="top" class="col_head" width="10%">
			Balance
		</td>
		<td valign="top" class="col_head <?= ($_REQUEST['sort'] == 'status')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="5%">
			<a href="manage_ledger.php?pid=<?= $_GET['pid'] ?>&sort=status&sortdir=<?php echo ($_REQUEST['sort']=='status'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Ins</a>
		</td>
                <td valign="top" class="col_head" width="5%">
                       Action 
                </td>
		<!--
		<td valign="top" class="col_head" width="20%">
			Action
		</td>-->
	</tr>

	<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<? 
	}
	else
	{
		$cur_bal = 0;
		$last_sd = '';
		$last_ed = '';
		while($myarray = mysql_fetch_array($my))
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
			if($myarray['status']==DSS_CLAIM_REJECTED && $myarray[0]=='ledger'){
			  $style='style="background:#f46;"';
			}else{
			  $style="";
			}
                        if($myarray[0] == 'eob'){ $tr_class .= ' clickable_row'; }
			if($myarray[0] == 'eob' && ($myarray['status']!=DSS_CLAIM_DISPUTE && $myarray['status']!=DSS_CLAIM_SEC_DISPUTE)){ $tr_class .= ' eob_text'; }
                        if($myarray[0] == 'eob' && ($myarray['status']==DSS_CLAIM_DISPUTE || $myarray['status']==DSS_CLAIM_SEC_DISPUTE)){ $tr_class .= ' eob_dispute_text'; }


		?>
			<tr 
			class="<?=$tr_class;?> <?= $myarray[0]; ?>" <?=$style; ?>>
				<td <?php if($myarray[0]=="eob"){ echo 'onclick="window.location=\'display_file.php?f='.$myarray['filename'].'\'"'; } ?> valign="top">
					<?php if($myarray["service_date"]!=$last_sd){
						$last_sd = $myarray["service_date"];
       					      	echo date('m-d-Y',strtotime(st($myarray["service_date"])));
                                        } ?>
				</td>
				<td <?php if($myarray[0]=="eob"){ echo 'onclick="window.location=\'display_file.php?f='.$myarray['filename'].'\'"'; } ?> valign="top">
					<?php if($myarray["entry_date"]!=$last_ed){
                                                $last_ed = $myarray["entry_date"];
                                                echo date('m-d-Y',strtotime(st($myarray["entry_date"])));
                                        } ?>
				</td>
                                <td <?php if($myarray[0]=="eob"){ echo 'onclick="window.location=\'display_file.php?f='.$myarray['filename'].'\'"'; } ?> valign="top">
                        <?=st($myarray["name"]);?>
                              <?php if($myarray[0]=='eob' && ($myarray['status']==DSS_CLAIM_DISPUTE || $myarray['status']==DSS_CLAIM_SEC_DISPUTE)){
				echo " (".$dss_claim_status_labels[$myarray['status']].")";
			      } ?>
                                </td>

				<td <?php if($myarray[0]=="eob"){ echo 'onclick="window.location=\'display_file.php?f='.$myarray['filename'].'\'"'; } ?> valign="top">
                	<?=st(ucWords($myarray["description"]));?>
                        <?= (($myarray[0] == 'ledger_payment'))?$dss_trxn_payer_labels[$myarray['payer']]." Payment - ":''; ?>
                        <?= (($myarray[0] == 'ledger_payment'))?$dss_trxn_pymt_type_labels[$myarray['payment_type']]." ":''; ?>

				</td>
				<td <?php if($myarray[0]=="eob"){ echo 'onclick="window.location=\'display_file.php?f='.$myarray['filename'].'\'"'; } ?> valign="top" align="right">
					<? if(st($myarray["amount"]) <> 0) {?>
	                	<?=number_format(st($myarray["amount"]),2);?>
					<? 
						$cur_bal += st($myarray["amount"]);
					}?>
					&nbsp;
				</td>
				<td <?php if($myarray[0]=="eob"){ echo 'onclick="window.location=\'display_file.php?f='.$myarray['filename'].'\'"'; } ?> valign="top" align="right">
					<? if(st($myarray["paid_amount"]) <> 0) {?>
	                	<?=number_format(st($myarray["paid_amount"]),2);?>
					<? 
						$cur_bal -= st($myarray["paid_amount"]);
					}?>
					&nbsp;
				</td>
				<td <?php if($myarray[0]=="eob"){ echo 'onclick="window.location=\'display_file.php?f='.$myarray['filename'].'\'"'; } ?> valign="top" align="right">
					<?=number_format(st($cur_bal),2);?>
                	&nbsp;
				</td>
				<td <?php if($myarray[0]=="eob"){ echo 'onclick="window.location=\'display_file.php?f='.$myarray['filename'].'\'"'; } ?> valign="top">
          <?php
             echo $dss_claim_status_labels[$myarray["status"]]; 
             /*
               if($myarray["status"] == '0'){echo "Pend.";}
               if($myarray["status"] == '1'){echo "Sent ";}
               if($myarray["status"] == '2'){echo "Filed";}
            */
          ?>       	
				</td>
				<td valign="top">
					<?php if($myarray[0]=='ledger_payment'){ ?>
                                           <a href="Javascript:;" onclick="javascript: loadPopup('edit_ledger_payment.php?ed=<?=$myarray["ledgerid"];?>&pid=<?=$_GET['pid'];?>');" class="editlink" title="PAYMENT">
                                                 Edit 
                                        </a>
					<?php } ?>
				</td>
				<!--<td valign="top">
                                   <?php if($myarray[0]=='ledger'){ ?>
					<a href="Javascript:;" onclick="Javascript: loadPopup('add_ledger.php?ed=<?=$myarray["ledgerid"];?>&pid=<?=$_GET['pid'];?>');" class="editlink" title="EDIT">
						Edit 
					</a>
                    
                    <a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$myarray["ledgerid"];?>&pid=<?=$_GET['pid'];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
						 Delete 
					</a>
                                           <a href="Javascript:;" onclick="javascript: loadPopup('add_ledger_payment.php?ed=<?=$myarray["ledgerid"];?>&pid=<?=$_GET['pid'];?>');" class="editlink" title="PAYMENT">
                                                 Payment 
                                        </a>

                                  <input type="checkbox" name="edit_mult[]" value="<?=$myarray["ledgerid"]; ?>" />
                                  <?php }elseif($myarray[0]=='note'){ ?>
 
					<a href="Javascript:;" onclick="Javascript: loadPopup('edit_ledger_note.php?ed=<?=$myarray["ledgerid"];?>&pid=<?=$_GET['pid'];?>');" class="editlink" title="EDIT">
                                                Edit 
                                        </a>
                                  <?php }elseif($myarray[0]=='claim'){ ?>
<a href="insurance.php?insid=<?=$myarray["ledgerid"];?>&pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
                                                Edit 
                                        </a>

                    <a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$myarray["ledgerid"];?>&pid=<?=$_GET['pid'];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
                                                 Delete 
                                        </a>
  				<?php }elseif($myarray[0]=='eob'){ ?>
                    <a href="q_file/<?= $myarray["filename"]; ?>" target="_blank" class="editlink" title="VIEW">
                                                View 
                                        </a>

                    <a href="<?=$_SERVER['PHP_SELF']?>?deleobid=<?=$myarray["ledgerid"];?>&claimid=<?= $_GET["claimid"];?>&pid=<?=$_GET['pid'];?>" onclick="javascript: return confirm('Do Your Really want to Delete? WARNING: This will delete all associated payments.');" class="dellink" title="DELETE">
                                                 Delete 
                                        </a>

				<?php } ?>
				</td>-->
			</tr>
	<? 	}
	}?>
  
  <tr>
      <td colspan="8">
	<center>
		<button onclick="Javascript: window.location='manage_ledger.php?pid=<?= $_GET['pid'];?>';return false;" class="addButton">

               Return to Patient Ledger
        </button></center>

      </td>
  </tr> 
</table>
</form> 


<?php 
  if($api_r['use_eligible_api']==1){

$_GET['cid'] = $_GET['claimid'];
include 'claim_history_data.php'; 
}

include 'claim_notes.php';
?>



<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
