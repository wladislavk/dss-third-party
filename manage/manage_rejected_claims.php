<? 
include "includes/top.htm";
include_once "includes/constants.inc";

	
$sql = "select i.*, p.firstname, p.lastname from dental_insurance i left join dental_patients p on i.patientid=p.patientid 
	where i.docid='".$_SESSION['docid']."' ";
$sql .= " AND i.status IN (".DSS_CLAIM_REJECTED.", ".DSS_CLAIM_SEC_REJECTED.")";

$my=mysql_query($sql) or die(mysql_error());

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

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

<span class="admin_head">Rejected Claims</span>
<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" style="clear:both" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head <?= ($_GET['sort2'] == 'adddate')?'arrow_'.strtolower($_GET['dir2']):''; ?>" width="40%">
			<a href="?filter=<?= $_GET['filter']; ?>&sort1=<?= $_GET['sort1']; ?>&dir1=<?=$_GET['dir1']; ?>&sort2=adddate&dir2=<?= ($_GET['sort2']=='adddate' && $_GET['dir2']=='ASC')?'DESC':'ASC'; ?>">Date</a>
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

			$e_sql = "SELECT * FROM dental_claim_electronic where claimid='".$myarray['insuranceid']."' ORDER BY adddate DESC LIMIT 1";
			$e_q = mysql_query($e_sql);
			$e_r = mysql_fetch_assoc($e_q);
			$last_date = ($e_r['adddate']!='')?$e_r['adddate']:$myarray['adddate'];

		?>
			<tr class="<?=$tr_class;?> status_<?= $myarray['status']; ?> claim">
				<td valign="top">
                	<?=date('m-d-Y H:i',strtotime(st($last_date)));?>
				</td>
				<td valign="top">
					<?= $myarray['firstname'].' '.$myarray['lastname']; ?>	
				</td>
				<td valign="top">
				    <?=$dss_claim_status_labels[$myarray['status']];?>
				</td>
				<td valign="top">
<a href="view_claim.php?claimid=<?=$myarray["insuranceid"];?>&pid=<?= $myarray['patientid']; ?>" class="editlink" title="EDIT">
                                                Fix 
                                        </a>
				</td>
			</tr>
			<tr><td colspan="4">
			    <?php 

				$e_sql = "SELECT * FROM dental_claim_electronic WHERE claimid='".mysql_real_escape_string($myarray['insuranceid'])."' ORDER BY adddate DESC LIMIT 1";
				$e_q = mysql_query($e_sql);
				while($electronic = mysql_fetch_assoc($e_q)){
					$r = json_decode($electronic['response']);
					$errors = $r->{"errors"}->{"messages"};
					foreach($errors as $error){
					  echo $error."<br />";
					}
					$r_sql = "SELECT * FROM dental_eligible_response WHERE reference_id !='' AND reference_id='".mysql_real_escape_string($electronic['reference_id'])."'";
					$r_q = mysql_query($r_sql);
					while($response = mysql_fetch_assoc($r_q)){
						$r = json_decode($response['response']);
						$codes = $r->{"details"}->{"codes"};
						echo $codes->{"category_code"}." - ";
						echo $codes->{"category_label"}."<br />";
                                                echo $codes->{"status_code"}." - ";
                                                echo $codes->{"status_label"};
					}
				}

				?>
			</td>
			</tr>
	<? 	}
	}?>
</table>
</form>

<br/><br/>


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
                                   $.ajax({
                                        url: "includes/claim_mail.php",
                                        type: "post",
                                        data: {lid: lid, mailed: c},
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
