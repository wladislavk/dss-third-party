<?php namespace Ds3\Libraries\Legacy; ?><?php 
include "includes/top.htm";

	if(is_billing($_SESSION['admin_access'])){
?>
		<h2>You are not authorized to view this page.</h2>
<?php
  		die();
	}


if(!empty($_REQUEST["delid"]) && $_SESSION['admin_access']==1)
{
	$del_sql = "delete from dental_transaction_code where transaction_codeid='".$_REQUEST["delid"]."'";
	mysqli_query($con,$del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
	</script>
	<?
	die();
}

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
/*$sql = "select du.name, du.userid, du.username, count(dl.ledgerid) as num_trxn from dental_users du 
    LEFT JOIN dental_ledger dl 
	ON dl.docid=du.userid 
		AND dl.status = '".DSS_PERCASE_PENDING."' 
WHERE du.docid=0
 group by du.name, du.username, du.userid";
echo $sql;
*/
if(is_super($_SESSION['admin_access'])){
  $sql = "SELECT du.*, c.name AS company_name 
                FROM dental_users du 
                JOIN dental_user_company uc ON uc.userid = du.userid
                JOIN companies c ON c.id=uc.companyid
                WHERE du.docid=0";
}else{
  $sql = "SELECT du.*, c.name AS company_name 
		FROM dental_users du 
		JOIN dental_user_company uc ON uc.userid = du.userid
		JOIN companies c ON c.id=uc.companyid
		WHERE du.docid=0 AND uc.companyid='".mysqli_real_escape_string($con,$_SESSION['admincompanyid'])."'";
}
$my = mysqli_query($con,$sql);
$total_rec = mysqli_num_rows($my);
$no_pages = $total_rec/$rec_disp;

//$sql .= " limit ".$i_val.",".$rec_disp;
$my = mysqli_query($con,$sql);
$num_users = mysqli_num_rows($my);

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Invoicing	
</div>
<br />


<?php if(!empty($_GET['msg'])) {?>
<div class="alert alert-danger text-center">
    <?php echo $_GET['msg'];?>
</div>
<?php } ?>

&nbsp;
<b>Total Records: <?php echo $total_rec;?></b>
<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table class="sort_table table table-bordered table-hover" id="fax_table">
<thead>
	<tr class="tr_bg_h">
		<th valign="top" class="col_head" width="14%">
			Username		
		</th>
                <th valign="top" class="col_head" width="20%">
                        Company
                </th>
		<th valign="top" class="col_head" width="15%">
			Name		
		</th>
                <th valign="top" class="col_head" width="15%">
                        Faxes (Last 30 days)
                </th>
		<th valign="top" class="col_head" width="10%">
			Unbilled Faxes		
		</th>
		<th valign="top" class="col_head" width="10%">
			Pages (Last 30 days)
		</th>
		<th valign="top" class="col_head" width="16%">
			Unbilled Pages
		</th>
	</tr>
</thead>
<tbody>
	<?php if(mysqli_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<?php 
	}
	else
	{
		while($myarray = mysqli_fetch_array($my))
		{
		$fax_sql = "SELECT COUNT(*) AS num_faxes, SUM(pages) AS pages FROM dental_faxes df 
        WHERE 
                df.docid='".$myarray['userid']."' AND
                df.status = '0'
";
$fax_q = mysqli_query($con,$fax_sql);
		$fax = mysqli_fetch_assoc($fax_q);
                $fax30_sql = "SELECT COUNT(*) AS num_faxes, SUM(pages) AS pages FROM dental_faxes df 
        WHERE 
                df.docid='".$myarray['userid']."' AND
                df.sent_date > DATE_SUB(now(), INTERVAL 30 DAY) 
";
$fax30_q = mysqli_query($con,$fax30_sql);
                $fax30 = mysqli_fetch_assoc($fax30_q);
		?>
			<tr>
				<td valign="top">
					<?php echo st($myarray["username"]);?>
				</td>
                                <td valign="top">
                                        <?php echo st($myarray["company_name"]);?>
                                </td>
                                <td valign="top">
                                        <?php echo st($myarray["name"]);?>
                                </td>
				<td valign="top" style="color:#f00;font-weight:bold;text-align:center;">
					<?php echo st($fax30["num_faxes"]);?>
				</td>
				<td valign="top" style="color:#f00;font-weight:bold;text-align:center;">
					<?php
         				    echo st($fax["num_faxes"]); ?>
				</td>
				<td valign="top" align="center">
					<?php
					    echo st($fax30["pages"]); ?>
				</td>	
						
				<td valign="top">
					<?php
					    echo st($fax["pages"]); ?>
				</td>
			</tr>
	<?php 	}

	}?>
</tbody>
</table>
</form>

<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<script type="text/javascript">
$(document).ready(function() 
    { 
    } 
); 
</script>

<?php include "includes/bottom.htm";?>
