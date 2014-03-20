<? 
include "includes/top.htm";

$sort_dir = strtolower($_REQUEST['sort_dir']);
$sort_dir = (empty($sort_dir) || ($sort_dir != 'asc' && $sort_dir != 'desc')) ? 'asc' : $sort_dir;

$sort_by  = (isset($_REQUEST['sort_by'])) ? $_REQUEST['sort_by'] : 'insuranceid';
$sort_by_sql = '';
$sort_by_sql .= " ". $sort_by." ".$sort_dir." ";
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
	  order by ". $sort_by_sql;
}elseif(is_billing($_SESSION['admin_access'])){
  $sql = "SELECT e.*
		FROM dental_claim_electronic e
		INNER JOIN dental_user_company uc ON uc.userid = e.userid
		INNER JOIN companies c ON c.id=uc.companyid
		WHERE uc.companyid='".mysql_real_escape_string($_SESSION['admincompanyid'])."'
		ORDER BY ".$sort_by_sql;
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
          order by ".$sort_by_sql;
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

<div class="page-header">
	Electronic Claim History 
</div>
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
				 paging($no_pages,$index_val,"sort_by=".$sort_by."&sort_dir=".$sort_dir);
			?>
		</TD>        
	</TR>
	<? }?>
<?php
    $sort_qs = $_SERVER['PHP_SELF'] . "?sort_by=%s&sort_dir=%s";
?>
	<tr class="tr_bg_h">
<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, 'insuranceid', $sort_dir) ?>" width="10%">
                        <a href="<?=sprintf($sort_qs, 'insuranceid', get_sort_dir($sort_by, 'insuranceid', $sort_dir))?>">
			Claim ID</a>
		</td>
<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, 'adddate', $sort_dir) ?>" width="20%">
                        <a href="<?=sprintf($sort_qs, 'adddate', get_sort_dir($sort_by, 'adddate', $sort_dir))?>">
			Added
		</td>
<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, 'last_action', $sort_dir) ?>" width="20%">
                        <a href="<?=sprintf($sort_qs, 'last_action', get_sort_dir($sort_by, 'last_action', $sort_dir))?>">
			Last Action
		</td>
<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, 'status', $sort_dir) ?>" width="20%">
                        <a href="<?=sprintf($sort_qs, 'status', get_sort_dir($sort_by, 'status', $sort_dir))?>">
			Status	
		</td>       
<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, 'pat_name', $sort_dir) ?>" width="20%">
                        <a href="<?=sprintf($sort_qs, 'pat_name', get_sort_dir($sort_by, 'pat_name', $sort_dir))?>">
			Patient Name
		</td>
<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, 'account_name', $sort_dir) ?>" width="20%">
                        <a href="<?=sprintf($sort_qs, 'account_name', get_sort_dir($sort_by, 'account_name', $sort_dir))?>">
                        Account 
                </td>
<td valign="top" class="col_head <?= get_sort_arrow_class($sort_by, 'company_name', $sort_dir) ?>" width="20%">
                        <a href="<?=sprintf($sort_qs, 'company_name', get_sort_dir($sort_by, 'company_name', $sort_dir))?>">
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

					<a href="../insurance_check_status.php?id=<?= $myarray['id']; ?>" class="btn btn-info" title="payment status">
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
