<?php
include "includes/top.htm";
include "admin/classes/Db.php";

$db = new Db();

if($_REQUEST["delid"] != "")
{
	$del_sql = "delete from dental_referredby where referredbyid='".$_REQUEST["delid"]."'";
	$db->query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
	</script>
	<?php
	die();
}


//$sql = "select * from dental_referredby where docid='".$_SESSION['docid']."' order by firstname";
$sql = "select 
		dc.contactid,
		dc.salutation,
		dc.firstname,
		dc.middlename,
		dc.lastname, 
		p.referred_source,
		dc.referredby_notes,
		count(p.patientid) as num_ref, 
		GROUP_CONCAT(CONCAT(p.firstname,' ',p.lastname)) as patients_list,
		(SELECT count(*) FROM dental_patients p30 WHERE p30.referred_source=".DSS_REFERRED_PHYSICIAN." AND dc.contactid=p30.referred_by AND STR_TO_DATE(p30.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()) as num_ref30,
                (SELECT count(*) FROM dental_patients p60 WHERE p60.referred_source=".DSS_REFERRED_PHYSICIAN." AND dc.contactid=p60.referred_by AND STR_TO_DATE(p60.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND DATE_SUB(CURDATE(), INTERVAL 30 DAY)) as num_ref60,
                (SELECT count(*) FROM dental_patients p90 WHERE p90.referred_source=".DSS_REFERRED_PHYSICIAN." AND dc.contactid=p90.referred_by AND STR_TO_DATE(p90.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND DATE_SUB(CURDATE(), INTERVAL 60 DAY)) as num_ref90,
                (SELECT count(*) FROM dental_patients p90plus WHERE p90plus.referred_source=".DSS_REFERRED_PHYSICIAN." AND dc.contactid=p90plus.referred_by AND STR_TO_DATE(p90plus.copyreqdate, '%m/%d/%Y') < DATE_SUB(CURDATE(), INTERVAL 90 DAY)) as num_ref90plus,

		'".DSS_REFERRED_PHYSICIAN."' as referral_type,
		ct.contacttype
	from dental_contact dc 
		INNER JOIN dental_contacttype ct ON ct.contacttypeid = dc.contacttypeid
		INNER JOIN dental_patients p on dc.contactid=p.referred_by
	where dc.docid='".$_SESSION['docid']."'
		AND p.referred_source=".DSS_REFERRED_PHYSICIAN."
		GROUP BY dc.contactid
  UNION
	select
		dp.patientid,
		dp.salutation,
		dp.firstname,
		dp.middlename,
		dp.lastname,
		p.referred_source,
		'',
		count(p.patientid),
		GROUP_CONCAT(CONCAT(p.firstname,' ',p.lastname)) as patients_list,
                (SELECT count(*) FROM dental_patients p30 WHERE p30.referred_source=".DSS_REFERRED_PATIENT." AND dp.patientid=p30.referred_by AND STR_TO_DATE(p30.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE()) as num_ref30,
                (SELECT count(*) FROM dental_patients p60 WHERE p60.referred_source=".DSS_REFERRED_PATIENT." AND dp.patientid=p60.referred_by AND STR_TO_DATE(p60.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 60 DAY) AND DATE_SUB(CURDATE(), INTERVAL 30 DAY)) as num_ref60,
                (SELECT count(*) FROM dental_patients p90 WHERE p90.referred_source=".DSS_REFERRED_PATIENT." AND dp.patientid=p90.referred_by AND STR_TO_DATE(p90.copyreqdate, '%m/%d/%Y') BETWEEN DATE_SUB(CURDATE(), INTERVAL 90 DAY) AND DATE_SUB(CURDATE(), INTERVAL 60 DAY)) as num_ref90,
                (SELECT count(*) FROM dental_patients p90plus WHERE p90plus.referred_source=".DSS_REFERRED_PATIENT." AND dp.patientid=p90plus.referred_by AND STR_TO_DATE(p90plus.copyreqdate, '%m/%d/%Y') < DATE_SUB(CURDATE(), INTERVAL 90 DAY)) as num_ref90plus,
		'".DSS_REFERRED_PATIENT."',
		'Patient'
	from dental_patients dp
		INNER JOIN dental_patients p ON dp.patientid=p.referred_by
	where p.docid='".$_SESSION['docid']."'
                AND p.referred_source=".DSS_REFERRED_PATIENT."
		GROUP BY dp.patientid
";
switch($_GET['sort']){
  case 'type':
    $sql .= " ORDER BY referral_type ".$_GET['sortdir'];
    break;
  case 'total':
    $sql .= " ORDER BY num_ref ".$_GET['sortdir'];
    break;
  case 'thirty':
    $sql .= " ORDER BY num_ref30 ".$_GET['sortdir'];
    break;
  case 'sixty':
    $sql .= " ORDER BY num_ref60 ".$_GET['sortdir'];
    break;
  case 'ninty':
    $sql .= " ORDER BY num_ref90 ".$_GET['sortdir'];
    break;
  case 'nintyplus':
    $sql .= " ORDER BY num_ref90plus ".$_GET['sortdir'];
    break;
  default:
    $sql .= " ORDER BY lastname ".$_GET['sortdir'].", firstname ".$_GET['sortdir'];
    break;
}

$my = $db->getResults($sql);
$num_referredby = count($my);

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/manage.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Referred By
</span>
<br />
<br />
&nbsp;

<div align="right">
	<button onclick="Javascript: loadPopup('add_referredby.php');" class="addButton">
		Add New Referred By
	</button>
	&nbsp;&nbsp;
	<a href="manage_referredby_print.php" class="button">Print List</a>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><?php echo $_GET['msg'];?></b>
</div>

<div id="pager" class="pager">
    <form>
        <img src="images/first.png" class="first">
        <img src="images/prev.png" class="prev">
        <input class="pagedisplay" style="width:75px;" type="text">
        <img src="images/next.png" class="next">
        <img src="images/last.png" class="last">
    </form>
</div>

<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
	<table id="sort_table" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
		<thead>
		<tr class="tr_bg_h">
			<th valign="top" class="col_head" width="20%">
			  Name
			</th>
			<th valign="top" class="col_head" width="20%">
				Physician Type	
			</th>
			<th valign="top" class="col_head" width="20%">
				Total Referrals
			</th>
	                <th valign="top" class="col_head">
	                        30 Days
	                </th>
	                <th valign="top" class="col_head">
	                        60 Days 
	                </th>
	                <th valign="top" class="col_head">
	                        90 Days
	                </th>
	                <th valign="top" class="col_head">
	                        90+ Days
	                </th>

	                <th valign="top" class="col_head">
	                        Notes
	                </th>
			<th valign="top" class="col_head">
				Expand
			</th>
		</tr>
		</thead>
		<tbody>
		<?php if($num_referredby == 0)
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
			foreach ($my as $myarray) {
				$pat_sql = "select * from dental_patients where docid='".$_SESSION['docid']."' and referred_by='".$myarray["referredbyid"]."'";
				$pat_my = $db->getResults($pat_sql);
				
				if($myarray["status"] == 1)
				{
					$tr_class = "tr_active";
				}
				else
				{
					$tr_class = "tr_inactive";
				}
				
				$name = st($myarray['salutation'])." ".st($myarray['firstname'])." ".st($myarray['middlename'])." ".st($myarray['lastname']);
			?>
			<tr >
				<td valign="top" width="20%">
					<?php if($myarray['referred_source']==DSS_REFERRED_PHYSICIAN){
						?><a href="#" onclick="loadPopup('view_contact.php?ed=<?php echo  $myarray['contactid'];?>');return false;"><?php echo $name;?></a><?php
					}else{
						echo $name;
					} ?>
				</td>
				<td valign="top" width="30%">
					<?php echo st($myarray['contacttype']);?>
				</td>
				<td valign="top" width="10%">
					<a href="referredby_patient.php?rid=<?php echo $myarray["contactid"];?>&rsource=<?php echo $myarray["referral_type"];?>" class="editlink">
						<?php echo $myarray['num_ref'];?>
					</a>
				</td>
	            <td valign="top" width="10%">
	                <a href="referredby_patient.php?rid=<?php echo $myarray["contactid"];?>&rsource=<?php echo $myarray["referral_type"];?>" class="editlink">
	                    <?php echo $myarray['num_ref30'];?>
	                </a>
	            </td>
	            <td valign="top" width="10%">
	                <a href="referredby_patient.php?rid=<?php echo $myarray["contactid"];?>&rsource=<?php echo $myarray["referral_type"];?>" class="editlink">
	                    <?php echo $myarray['num_ref60'];?>
	                </a>
	            </td>
	            <td valign="top" width="10%">
	                <a href="referredby_patient.php?rid=<?php echo $myarray["contactid"];?>&rsource=<?php echo $myarray["referral_type"];?>" class="editlink">
	                    <?php echo $myarray['num_ref90'];?>
	                </a>
	            </td>
	            <td valign="top" width="10%">
	                <a href="referredby_patient.php?rid=<?php echo $myarray["contactid"];?>&rsource=<?php echo $myarray["referral_type"];?>" class="editlink">
	                    <?php echo $myarray['num_ref90plus'];?>
	                </a>
	            </td>
				<td valign="top" width="10%">
	                <a href="#" onclick="loadPopup('add_referredby_notes.php?rid=<?php echo $myarray["contactid"];?>')" class="editlink" title="<?php echo ($myarray['referredby_notes'])?$myarray['referredby_notes']:'No Notes'; ?>">
						View
	                </a>
		        </td>
				<td valign="top"> 
					<a href="referredby_patient.php?rid=<?php echo $myarray["contactid"];?>&rsource=<?php echo $myarray["referral_type"];?>" class="editlink" title="<?php echo $myarray['patients_list']; ?>">
					List
					</a>
				</td>
			</tr>
		<?php }
		}?>
		</tbody>
	</table>
</form>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
