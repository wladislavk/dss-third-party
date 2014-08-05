<? 
include "includes/top.htm";
include_once "includes/constants.inc";
if(!isset($_GET['sort1'])){
$_GET['sort1']='oldest';
$_GET['dir1']='ASC';
}
if(!isset($_GET['sort2'])){
$_GET['sort2']='adddate';
$_GET['dir2']='ASC';
}
if(!isset($_GET['filter'])){
$_GET['filter']=100;
}

if(isset($_REQUEST["vid"]))
{
        $del_sql = "UPDATE dental_insurance SET fo_paid_viewed=1 where insuranceid='".$_REQUEST["claimid"]."'";
	
        mysql_query($del_sql);

        $msg= "Claim marked viewed";
        ?>
        <script type="text/javascript">
                //alert("Deleted Successfully");
                window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>";
        </script>
        <?
        die();
}


$pend_sql = "select i.*, p.firstname, p.lastname,
	(SELECT SUM(amount) FROM dental_ledger WHERE primary_claim_id = i.insuranceid) billed,
	(SELECT SUM(p.amount) FROM dental_ledger_payment p JOIN dental_ledger dl ON p.ledgerid=dl.ledgerid WHERE dl.primary_claim_id = i.insuranceid) paid,
        (SELECT e.adddate FROM dental_claim_electronic e WHERE e.claimid=i.insuranceid ORDER by e.adddate DESC LIMIT 1) electronic_adddate
 from dental_insurance i left join dental_patients p on i.patientid=p.patientid 
	where i.docid='".$_SESSION['docid']."' ";
if(isset($_GET['paid_viewed'])){ 
	$pend_sql .= " AND fo_paid_viewed=0 ";
}
$pend_sql .= " AND (i.status IN (".DSS_CLAIM_PAID_INSURANCE.", ".DSS_CLAIM_PAID_SEC_INSURANCE.", ".DSS_CLAIM_PAID_PATIENT.", ".DSS_CLAIM_PAID_SEC_PATIENT."))" ;
if(isset($_GET['sort2'])){
  if($_GET['sort2']=='patient'){
    $sort = "p.lastname ".$_GET['dir2'].", p.firstname ".$_GET['dir2'];
  }else{
    $sort = $_GET['sort2']." ".$_GET['dir2'];
  }

}
$pend_sql .= " ORDER BY " . mysql_real_escape_string($sort);
$pend_my=mysql_query($pend_sql) or die(mysql_error());



?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Paid Claims 
</span>
<br />
&nbsp;&nbsp;
<div style="float: right; margin-right: 20px;">
<?php if(!isset($_GET['paid_viewed'])){ ?>
<a href="manage_claims_paid.php?paid_viewed=0" class="addButton">Show Not-Yet Viewed</a>
<?php }

if(isset($_GET['paid_viewed'])){ ?>
  <a href="manage_claims_paid.php" class="addButton">Show All</a>
<?php } ?>
</div>

  
<br />
<?php
if(isset($_GET['msg'])){
?>
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<?php
} 
?>
<table width="98%" style="clear:both" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr class="tr_bg_h">
                <td valign="top" class="col_head <?= ($_GET['sort2'] == 'electronic_adddate')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="40%">
                        <a href="?filter=<?= $_GET['filter']; ?>&sort1=<?= $_GET['sort1']; ?>&dir1=<?=$_GET['dir1']; ?>&sort2=electronic_adddate&dir2=<?= ($_GET['sort2']=='electronic_adddate' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Date</a>
                </td>
                <td valign="top" class="col_head <?= ($_GET['sort2'] == 'billed')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
                        <a href="?filter=<?= $_GET['filter']; ?>&sort1=<?= $_GET['sort1']; ?>&dir1=<?=$_GET['dir1']; ?>&sort2=billed&dir2=<?= ($_GET['sort2']=='billed' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Billed Amount</a>
                </td>
                <td valign="top" class="col_head <?= ($_GET['sort2'] == 'paid')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
                        <a href="?filter=<?= $_GET['filter']; ?>&sort1=<?= $_GET['sort1']; ?>&dir1=<?=$_GET['dir1']; ?>&sort2=paid&dir2=<?= ($_GET['sort2']=='paid' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Amount Paid</a>
                </td>
                <td valign="top" class="col_head <?= ($_GET['sort2'] == 'patient')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
                        <a href="?filter=<?= $_GET['filter']; ?>&sort1=<?= $_GET['sort1']; ?>&dir1=<?=$_GET['dir1']; ?>&sort2=patient&dir2=<?= ($_GET['sort2']=='patient' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Patient</a>
                </td>
                <td valign="top" class="col_head <?= ($_GET['sort2'] == 'status')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="20%">
                        <a href="?filter=<?= $_GET['filter']; ?>&sort1=<?= $_GET['sort1']; ?>&dir1=<?=$_GET['dir1']; ?>&sort2=status&dir2=<?= ($_GET['sort2']=='status' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Status</a>
                </td>
                <td valign="top" class="col_head" width="20%">
                        Action
                </td>
        </tr>
        <? if(mysql_num_rows($pend_my) == 0)
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
                while($pend_myarray = mysql_fetch_array($pend_my))
                {
                        if($pend_myarray["fo_paid_viewed"] != 1)
                        {
                                $tr_class = "unviewed";
                        }
                        else
                        {
                                $tr_class = "";
                        }
                ?>
                        <tr class="<?=$tr_class;?> status_<?= $pend_myarray['status']; ?> claim">
                                <td valign="top">
<?=date('m-d-Y H:i',strtotime((($pend_myarray["electronic_adddate"]!='')?$pend_myarray["electronic_adddate"]:$pend_myarray["adddate"])));?>
                                </td>
                                <td valign="top">
                                        $<?= number_format($pend_myarray['billed'],2); ?>
                                </td>
                                <td valign="top">
                                        $<?= number_format($pend_myarray['paid'],2); ?>
                                </td>
                                <td valign="top">
                                        <?= $pend_myarray['firstname'].' '.$pend_myarray['lastname']; ?>
                                </td>
                                <td valign="top">
                                    <?=$dss_claim_status_labels[$pend_myarray['status']];?>
                                </td>
                                <td valign="top">
			<?php
			if($pend_myarray["fo_paid_viewed"] != 1)
                        {
			?>
<a href="manage_claims_paid.php?claimid=<?=$pend_myarray["insuranceid"];?>&pid=<?= $pend_myarray['patientid']; ?>&vid=1" class="editlink" title="Mark Viewed">
                                                Mark Viewed 
                                        </a>
					|
			<?php } ?>
						<a href="view_claim.php?claimid=<?=$pend_myarray["insuranceid"];?>&pid=<?= $pend_myarray['patientid']; ?>" class="editlink" title="View">
                                                View 
                                        </a>

                                </td>
                        </tr>
        <?      }
        }?>
</table>


<br /><br /><br />

<script type="text/javascript">

function updateClaims(v){

window.location="?filter="+v+"&sort1=<?= $_GET['sort1']; ?>&dir1=<?=$_GET['dir1']; ?>&sort2=<?= $_GET['sort2']; ?>&dir2=<?= $_GET['dir2']; ?>";

}

$('document').ready( function(){
var v = '<?= $_GET['filter']; ?>';
if(v == '100'){
  $('.claim').show();
}else if(v == '<?= DSS_CLAIM_PENDING; ?>'){
  $('.claim').hide();
  $('.status_<?= DSS_CLAIM_PENDING; ?>').show();
  $('.status_<?= DSS_CLAIM_SEC_PENDING; ?>').show();
}else if(v == '<?= DSS_CLAIM_PAID_INSURANCE; ?>'){
  $('.claim').hide();
  $('.status_<?= DSS_CLAIM_PAID_INSURANCE; ?>').show();
  $('.status_<?= DSS_CLAIM_PAID_SEC_INSURANCE; ?>').show();
  $('.status_<?= DSS_CLAIM_PAID_PATIENT; ?>').show();
}else if(v == '<?= DSS_CLAIM_SENT; ?>'){
  $('.claim').hide();
  $('.status_<?= DSS_CLAIM_SENT; ?>').show();
  $('.status_<?= DSS_CLAIM_SEC_SENT; ?>').show();
}else if(v == '<?= DSS_CLAIM_DISPUTE; ?>'){
  $('.claim').hide();
  $('.status_<?= DSS_CLAIM_DISPUTE; ?>').show();
  $('.status_<?= DSS_CLAIM_SEC_DISPUTE; ?>').show();
}else if(v == '<?= DSS_CLAIM_REJECTED; ?>'){
  $('.claim').hide();
  $('.status_<?= DSS_CLAIM_REJECTED; ?>').show();
}

});
</script>



<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>

<script type="text/javascript">
  $('.mailed_chk').click( function(){
    lid = $(this).val();
    c = $(this).is(':checked');
    type = 'pri';
                                   $.ajax({
                                        url: "includes/claim_mail.php",
                                        type: "post",
                                        data: {lid: lid, mailed: c, type:type},
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
                                                        //window.location.reload();
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });

  });
  $('.sec_mailed_chk').click( function(){
    lid = $(this).val();
    c = $(this).is(':checked');
    type = 'sec';
                                   $.ajax({
                                        url: "includes/claim_mail.php",
                                        type: "post",
                                        data: {lid: lid, mailed: c, type:type},
                                        success: function(data){
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
                                                        //window.location.reload();
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });

  });

</script>
