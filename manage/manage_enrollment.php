<? 
include "includes/top.htm";
require_once('includes/constants.inc');

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Enrollment
</span>
<br />
<br />
&nbsp;

<?php
  $sql = "SELECT e.*, CONCAT(t.transaction_type,' - ',t.description) as transaction_type 
	FROM dental_eligible_enrollment e
	LEFT JOIN dental_enrollment_transaction_type t ON e.transaction_type_id = t.id
	WHERE e.user_id = '".mysql_real_escape_string($_SESSION['docid'])."'";
  $my = mysql_query($sql);

  $api_key = DSS_DEFAULT_ELIGIBLE_API_KEY;
  $api_key_sql = "SELECT eligible_api_key FROM dental_user_company LEFT JOIN companies ON dental_user_company.companyid = companies.id WHERE dental_user_company.userid = '".mysql_real_escape_string($_SESSION['docid'])."'";
  $api_key_query = mysql_query($api_key_sql);
  $api_key_result = mysql_fetch_assoc($api_key_query);
  if($api_key_result){
    if(!empty(trim($api_key_result['eligible_api_key'])){
      $api_key = $api_key_result['eligible_api_key'];
    }
  }
?>
<div style="margin-left:10px;margin-right:10px;">
	<button style="margin-right:10px; float:right;" onclick="loadPopup('add_enrollment.php')" class="addButton">
		Add New Enrollment
	</button>
	&nbsp;&nbsp;
</div>
<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table class="sort_table" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
  <thead>
    <tr class="tr_bg_h">
      <th class="col_head">Provider</th>
      <th class="col_head">NPI</th>
      <th class="col_head">Payer ID</th>
      <th class="col_head">Service Type</th>
      <th class="col_head">Payer Name</th>
      <th class="col_head">Status</th>
      <th class="col_head">Response</th>	  
      <th class="col_head">Get Form</th>
  </thead>
		<?php
		while($myarray = mysql_fetch_array($my))
		{
		?>
			<tr >
				<td valign="top">
					<?=$myarray['provider_name']?>
				</td>
				<td valign="top">
					<?=$myarray['npi']?>
				</td>
				<td valign="top">
					<?=$myarray['payer_id']?>
				</td>
				<td valign="top">
					<?= $myarray['transaction_type']; ?>
				</td>
				<td valign="top">
					<?=$myarray['payer_name']?>
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
				<td valign="top">
					<a href="#" onclick="$('#response_<?= $myarray['id']; ?>').toggle();return false;" style="display:block;">View</a>
					<span id="response_<?= $myarray['id']; ?>" style="display:none;">
                   			  <?= $myarray["response"]; ?> 
					</span>
				</td>
				<td valign="top">
					<a href="https://gds.eligibleapi.com/v1.3/payers/<?=$myarray['payer_id']; ?>/enrollment_form?api_key=<?php echo $api_key ?>&transaction_type=837P" target="_blank">PDF</a>
				</td>
			</tr>
	<? 	}
	?>
</table>
</form>
<div class="fullwidth">
<?php //include 'eligible_enrollment/index.php'; ?>
</div>
<!--
<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>
<div id="popupRefer" style="height:550px; width:750px;">
    <a id="popupReferClose"><button>X</button></a>
    <iframe id="aj_ref" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopupRef"></div>-->
<br /><br />	
<? include "includes/bottom.htm";?>
