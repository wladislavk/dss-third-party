<? 
include "includes/top.htm";
require_once('../includes/constants.inc');

$rec_disp = 20;

if($_REQUEST["page"] != "")
        $index_val = $_REQUEST["page"];
else
        $index_val = 0;

$i_val = $index_val * $rec_disp;

  $sql = "SELECT e.*, CONCAT(t.transaction_type,' - ',t.description) as transaction_type 
        FROM dental_eligible_enrollment e
        LEFT JOIN dental_enrollment_transaction_type t ON e.transaction_type_id = t.id
        WHERE e.user_id = '".mysql_real_escape_string($_GET['ed'])."'";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

//$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);



?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Manage Enrollments
</div>
<br />
<br />

<?php
  if(isset($_GET['cid'])){
?>
<div style="float:left; margin-left:20px;">
        <a href="manage_users.php" class="btn btn-success">
                View All 
        </a>
        &nbsp;&nbsp;
</div>
<?php
  }
?>

<div align="right">
	<button onclick="Javascript: loadPopup('add_enrollment.php?docid=<?= $_GET['ed']; ?>');" class="btn btn-success">
		Add New Enrollment
		<span class="glyphicon glyphicon-plus">
	</button>
	&nbsp;&nbsp;
</div>
<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<table class="table table-bordered table-hover">
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
		<td valign="top" class="col_head" width="10%">
			Provider	
		</td>
		<td valign="top" class="col_head" width="10%">
			NPI	
		</td>
		<td valign="top" class="col_head" width="10%">
			Payer ID	
		</td>
		<td valign="top" class="col_head" width="20%">
			Service Type	
		</td>
		<td valign="top" class="col_head" width="20%">
			Payer Name
		</td>       
		<td valign="top" class="col_head" width="10%">
			Status
		</td>
		<td valign="top" class="col_head" width="20%">
			Response
		</td>
		<td valign="top" class="col_head" width="10%">
			Get Form
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
				$tr_class = "";
			}
			elseif($myarray["status"] == 2)
			{
				$tr_class = "info";
			}
                        elseif($myarray["status"] == 3)
                        {
                                $tr_class = "warning";
                        }
			else
			{
				$tr_class = "info";
			}
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
					<?=st($myarray["provider_name"]);?>
				</td>
				<td valign="top">
					<?=st($myarray["npi"]);?>
				</td>
				<td valign="top">
					<?=st($myarray["payer_id"]);?>
				</td>
				<td valign="top">
					<?=st($myarray["transaction_type"]);?>
				</td>
				<td valign="top">
					<?=st($myarray["payer_name"]);?>
				</td>
				
				<td valign="top">
 <?=st($dss_enrollment_labels[$myarray["status"]]);?>
                                        <?php
                                                $w_sql = "SELECT * from dental_eligible_response where reference_id='".mysql_real_escape_string($myarray['reference_id'])."' ORDER BY adddate DESC LIMIT 1";
                                                $w_q = mysql_query($w_sql);
                                                $w_r = mysql_fetch_assoc($w_q);
                                                if($w_r['adddate'] !=''){
                                                        echo " - ".date('m/d/Y h:i a', strtotime($w_r['adddate']));
                                                }else{
                                                        echo " - ".date('m/d/Y h:i a', strtotime($myarray['adddate']));
                                                }
                                        ?>
				</td>
			           <td valign="top" align="center">
					<a href="#" onclick="$('#response_<?= $myarray['id']; ?>').toggle();return false;" style="display:block;">View</a>
                                        <span id="response_<?= $myarray['id']; ?>" style="display:none;">
                                          <?= $myarray["response"]; ?>
                                        </span>

                                </td>	
                
				<td valign="top" align="center">
<a href="https://gds.eligibleapi.com/v1.3/payers/<?=$myarray['payer_id']; ?>/enrollment_form?api_key=".DSS_DEFAULT_ELIGIBLE_API_KEY."&transaction_type=837P" target="_blank">PDF</a>
				</td>	
                
			</tr>
	<? 	}
	}?>
</table>


<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
