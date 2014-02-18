<? 
include "includes/top.htm";

$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
if(is_super($_SESSION['admin_access'])){
$sql = "select e.*,
 	CONCAT(p.firstname, ' ', p.lastname) AS pat_name,
	CONCAT(u.first_name, ' ', u.last_name) AS account_name,
	c.name AS company_name,
	(SELECT MAX(r.adddate) FROM dental_eligible_response r WHERE r.reference_id = e.reference_id) AS last_action,
	i.status
	FROM dental_claim_electronic e
	  JOIN dental_insurance i ON i.insuranceid=e.claimid
	  LEFT JOIN dental_users u ON u.userid=i.docid
	  LEFT JOIN dental_patients p ON p.patientid=i.patientid
	  LEFT JOIN dental_user_company uc ON uc.userid=i.docid
	  LEFT JOIN companies c ON uc.companyid=c.id
	  order by e.adddate DESC";
}elseif(is_billing($_SESSION['admin_access'])){
  $sql = "SELECT e.*
		FROM dental_claim_electronic e
		INNER JOIN dental_user_company uc ON uc.userid = e.userid
		INNER JOIN companies c ON c.id=uc.companyid
		WHERE uc.companyid='".mysql_real_escape_string($_SESSION['admincompanyid'])."'
		ORDER BY username";
$sql = "select e.*,
        CONCAT(p.firstname, ' ', p.lastname) AS pat_name,
        CONCAT(u.first_name, ' ', u.last_name) AS account_name,
        c.name AS company_name,
        (SELECT MAX(r.adddate) FROM dental_eligible_response r WHERE r.reference_id = e.reference_id) AS last_action,
        i.status
        FROM dental_claim_electronic e
          JOIN dental_insurance i ON i.insuranceid=e.claimid
          LEFT JOIN dental_users u ON u.userid=i.docid
          LEFT JOIN dental_patients p ON p.patientid=i.patientid
          LEFT JOIN dental_user_company uc ON uc.userid=i.docid
          LEFT JOIN companies c ON uc.companyid=c.id
	  WHERE u.billing_company_id='".mysql_real_escape_string($_SESSION['admincompanyid'])."'
          order by e.adddate DESC";
}

$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Electronic Claim History 
</span>
<br />
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
			Claim ID
		</td>
		<td valign="top" class="col_head" width="20%">
			Added
		</td>
		<td valign="top" class="col_head" width="20%">
			Last Action
		</td>
		<td valign="top" class="col_head" width="20%">
			Status	
		</td>       
		<td valign="top" class="col_head" width="10%">
			Patient Name
		</td>
                <td valign="top" class="col_head" width="10%">
                        Account 
                </td>
		<td valign="top" class="col_head" width="10%">
			Company		
		</td>
		<td valign="top" class="col_head" width="10%">
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
		?>
			<tr>
				<td valign="top">
					<?= $myarray['claimid']; ?>
				</td>
				<td valign="top">
					<?= $myarray['adddate']; ?>
				</td>
				<td valign="top">
					<?=st($myarray["last_action"]);?>
				</td>
				<td valign="top">
					<?= $dss_claim_status_labels[$myarray['status']]; ?>
				</td>
				
				<td valign="top">
					<?= $myarray['pat_name']; ?>
				</td>
                                <td valign="top" align="center">
                                        <?= $myarray["account_name"]; ?>
                                </td>
			 	<td valign="top" align="center">
                                        <?= $myarray["company_name"]; ?>
				</td>			
				<td valign="top">
					<a href="view_claim_history.php?id=<?= $myarray['id']; ?>" title="Edit" class="btn btn-primary btn-sm">
						View
					 <span class="glyphicon glyphicon-pencil"></span></a>

					<a href="../insurance_check_status.php?id=<?= $myarray['id']; ?>" class="editlink" title="payment status">
						Payment Status
					</a>
                    
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
