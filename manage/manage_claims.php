<? 
include "includes/top.htm";
include_once "includes/constants.inc";

if($_REQUEST["delid"] != "")
{
        $del_sql = "delete from dental_insurance where insuranceid='".$_REQUEST["delid"]."'";
        mysql_query($del_sql);

        $msg= "Deleted Successfully";
        ?>
        <script type="text/javascript">
                //alert("Deleted Successfully");
                window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>";
        </script>
        <?
        die();
}


	
$sql = "select i.*, p.firstname, p.lastname from dental_insurance i left join dental_patients p on i.patientid=p.patientid where i.docid='".$_SESSION['docid']."' order by i.adddate";


$my=mysql_query($sql) or die(mysql_error());

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Claims 
</span>
<br />
&nbsp;&nbsp;

  
<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <tr class="tr_bg_h">
                <td valign="top" class="col_head" width="20%">
                        Patient
                </td>
                <td valign="top" class="col_head" width="20%">
                        Action
                </td>
        </tr>
<?php
$sqlp = "SELECT DISTINCT p.patientid, p.firstname, p.lastname FROM dental_ledger ledger
                         JOIN dental_transaction_code trxn_code ON trxn_code.transaction_code = ledger.transaction_code
                         JOIN dental_users user ON user.userid = ledger.docid
                         JOIN dental_patients p ON p.patientid = ledger.patientid
                  WHERE 
                         ledger.status = " . DSS_TRXN_PENDING ." 
                         AND ledger.docid = " . $_SESSION['docid'] . "
                         AND trxn_code.docid = " . $_SESSION['docid'] . "
                         AND trxn_code.type = " . DSS_TRXN_TYPE_MED;



$myp=mysql_query($sqlp) or die(mysql_error());

while($myarrayp = mysql_fetch_array($myp))
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
                ?>
                        <tr class="<?=$tr_class;?>">
                                <td valign="top">
                                        <?= $myarrayp['firstname'].' '.$myarrayp['lastname']; ?>
                                </td>
                                <td valign="top">
        <button onclick="Javascript: window.location = 'insurance.php?pid=<?=$myarrayp['patientid'];?>';" class="addButton">
                  Add New Claim
            </button>

                                </td>
                        </tr>
        <?      }
?>
</table>

<span class="admin_head">Claims</span>
<label style="margin-left:20px;">Filter by status</label> 
<select onchange="updateClaims(this.value)">
<option value="all">All</option>
<option value="<?= DSS_CLAIM_PENDING; ?>"><?= $dss_claim_status_labels[DSS_CLAIM_PENDING]; ?></option>
<option value="<?= DSS_CLAIM_PAID_INSURANCE; ?>"><?= $dss_claim_status_labels[DSS_CLAIM_PAID_INSURANCE]; ?></option>
<option value="<?= DSS_CLAIM_SENT; ?>"><?= $dss_claim_status_labels[DSS_CLAIM_SENT]; ?></option>
<option value="<?= DSS_CLAIM_DISPUTE; ?>"><?= $dss_claim_status_labels[DSS_CLAIM_DISPUTE]; ?></option>
<option value="<?= DSS_CLAIM_REJECTED; ?>"><?= $dss_claim_status_labels[DSS_CLAIM_REJECTED]; ?></option>
</select>

<script type="text/javascript">

function updateClaims(v){

if(v == 'all'){
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

}
</script>

<insurance name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
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
		<td valign="top" class="col_head" width="40%">
			Date
		</td>
		<td valign="top" class="col_head" width="20%">
			Patient
		</td>
		<td valign="top" class="col_head" width="20%">
			Status
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
		?>
			<tr class="<?=$tr_class;?> status_<?= $myarray['status']; ?> claim">
				<td valign="top">
                	<?=date('m-d-Y H:i',strtotime(st($myarray["adddate"])));?>
				</td>
				<td valign="top">
					<?= $myarray['firstname'].' '.$myarray['lastname']; ?>	
				</td>
				<td valign="top">
				    <?=$dss_claim_status_labels[$myarray['status']];?>
				</td>
				<td valign="top">
<a href="view_claim.php?claimid=<?=$myarray["insuranceid"];?>&pid=<?= $myarray['patientid']; ?>" class="editlink" title="EDIT">
                                                View 
                                        </a>

					<a href="insurance.php?insid=<?=$myarray["insuranceid"];?>&pid=<?= $myarray['patientid']; ?>" class="editlink" title="EDIT">
						Edit 
					</a>
                    
                    <a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$myarray["insuranceid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
						 Delete 
					</a>
				</td>
			</tr>
	<? 	}
	}?>
</table>
</insurance>

<br/><br/>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
