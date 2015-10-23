<?php namespace Ds3\Libraries\Legacy; ?><?php 
include "includes/top.htm";

$sort_dir = strtolower(!empty($_REQUEST['sort_dir']) ? $_REQUEST['sort_dir'] : '');
$sort_dir = (empty($sort_dir) || ($sort_dir != 'asc' && $sort_dir != 'desc')) ? 'asc' : $sort_dir;

$sort_by  = (isset($_REQUEST['sort_by'])) ? $_REQUEST['sort_by'] : 'insuranceid';
$sort_by_sql = '';
$sort_by_sql .= " ". $sort_by." ".$sort_dir." ";
$rec_disp = 20;

/**
 * Only include this subquery if requested in ordering
 * This query returns wrong values for some reference ids
 */
$lastActionColumnWithComma = $sort_by === 'last_action' ?
    '(SELECT MAX(r.adddate) FROM dental_eligible_response r WHERE r.reference_id = e.reference_id) AS last_action,' :
    '';

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;

$sql = "SELECT e.*,
    CONCAT(p.firstname, ' ', p.lastname) AS pat_name,
    CONCAT(u.first_name, ' ', u.last_name) AS account_name,
    c.name AS company_name,
    $lastActionColumnWithComma
    i.status
    FROM dental_claim_electronic e
        JOIN dental_insurance i ON i.insuranceid = e.claimid
        LEFT JOIN dental_users u ON u.userid = i.docid
        LEFT JOIN dental_patients p ON p.patientid = i.patientid
        LEFT JOIN dental_user_company uc ON uc.userid = i.docid
        LEFT JOIN companies c ON uc.companyid = c.id
    ";

if (is_billing($_SESSION['admin_access'])) {
    $sql .= " WHERE u.billing_company_id = '" . $db->escape($_SESSION['admincompanyid']) . "'";
}

$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec/$rec_disp;

$sql .= " ORDER BY $sort_by_sql LIMIT $i_val, $rec_disp";

$my = $db->getResults($sql);
$num_users = count($my);

$references = array_pluck($my, 'reference_id');
$references = array_filter(array_unique($references));
array_walk($references, function(&$each)use($db){ $each = '"' . $db->escape($each) . '"'; });
$references = join(',', $references);

$lastActions = [];

if ($references) {
    $lastActions = $db->getResults("SELECT reference_id, MAX(adddate) AS last_action
        FROM dental_eligible_response
        WHERE reference_id IN ($references)
        GROUP BY reference_id");
    $lastActions = array_combine(array_pluck($lastActions, 'reference_id'), array_pluck($lastActions, 'last_action'));
}

?>
<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<div class="page-header">
	Electronic Claim History 
</div>
<br />
<br />

<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<table class="table table-bordered table-hover">
	<?php if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?
				 paging($no_pages,$index_val,"sort_by=".$sort_by."&sort_dir=".$sort_dir);
			?>
		</TD>        
	</TR>
	<?php }?>
<?php
    $sort_qs = $_SERVER['PHP_SELF'] . "?sort_by=%s&sort_dir=%s";
?>
	<tr class="tr_bg_h">
<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, 'insuranceid', $sort_dir) ?>" width="10%">
                        <a href="<?php echo sprintf($sort_qs, 'insuranceid', get_sort_dir($sort_by, 'insuranceid', $sort_dir))?>">
			Claim ID</a>
		</td>
<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, 'adddate', $sort_dir) ?>" width="20%">
                        <a href="<?php echo sprintf($sort_qs, 'adddate', get_sort_dir($sort_by, 'adddate', $sort_dir))?>">
			Added
		</td>
<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, 'last_action', $sort_dir) ?>" width="20%">
                        <a href="<?php echo sprintf($sort_qs, 'last_action', get_sort_dir($sort_by, 'last_action', $sort_dir))?>">
			Last Action
		</td>
<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, 'status', $sort_dir) ?>" width="20%">
                        <a href="<?php echo sprintf($sort_qs, 'status', get_sort_dir($sort_by, 'status', $sort_dir))?>">
			Status	
		</td>       
<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, 'pat_name', $sort_dir) ?>" width="20%">
                        <a href="<?php echo sprintf($sort_qs, 'pat_name', get_sort_dir($sort_by, 'pat_name', $sort_dir))?>">
			Patient Name
		</td>
<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, 'account_name', $sort_dir) ?>" width="20%">
                        <a href="<?php echo sprintf($sort_qs, 'account_name', get_sort_dir($sort_by, 'account_name', $sort_dir))?>">
                        Account 
                </td>
<td valign="top" class="col_head <?php echo  get_sort_arrow_class($sort_by, 'company_name', $sort_dir) ?>" width="20%">
                        <a href="<?php echo sprintf($sort_qs, 'company_name', get_sort_dir($sort_by, 'company_name', $sort_dir))?>">
			Company		
		</td>
		<td valign="top" class="col_head" width="10%">
			Action
		</td>
	</tr>
	<?php if(!count($my))
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
		foreach($my as $myarray)
		{
		?>
			<tr>
				<td valign="top">
					<?php echo  $myarray['claimid']; ?>
				</td>
				<td valign="top">
					<?php echo  $myarray['adddate']; ?>
				</td>
				<td valign="top">
					<?= st(
                        isset($myarray['last_action']) ?
                            $myarray['last_action'] : (
                                isset($lastActions[$myarray['reference_id']]) ?
                                    $lastActions[$myarray['last_action']] : ''
                            )
                    ) ?>
				</td>
				<td valign="top">
					<?php echo  $dss_claim_status_labels[$myarray['status']]; ?>
				</td>
				
				<td valign="top">
					<?php echo  $myarray['pat_name']; ?>
				</td>
                                <td valign="top" align="center">
                                        <?php echo  $myarray["account_name"]; ?>
                                </td>
			 	<td valign="top" align="center">
                                        <?php echo  $myarray["company_name"]; ?>
				</td>			
				<td valign="top">
					<a href="view_claim_history.php?id=<?php echo  $myarray['id']; ?>" title="Edit" class="btn btn-primary btn-sm">
						View
					 <span class="glyphicon glyphicon-pencil"></span></a>

					<a href="../insurance_check_status.php?id=<?php echo  $myarray['id']; ?>" class="btn btn-info" title="payment status">
						Payment Status
					</a>
                    
				</td>
			</tr>
	<?php 	}
	}?>
</table>


<div id="popupContact">
    <a id="popupContactClose"><span class="glyphicon glyphicon-remove"></span></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
