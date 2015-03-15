<?php namespace Ds3\Libraries\Legacy; ?><?php  
include "includes/top.htm";

if(isset($_POST['dailysub']) && isset($_POST['monthlysub']) && $_POST['dailysub'] != 1 && $_POST['monthlysub'] != 1)
{?>
	<script type="text/javascript">
		window.location = 'patient_report.php';
	</script>
	<?php 
	die();
}

$rec_disp = 200;

if(isset($_REQUEST["page"]) && $_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_patients where docid='".$_SESSION['docid']."' ";

if($_POST['d_mm'] != '')
{
	$from_date = $_POST['d_yy']."-".$_POST['d_mm']."-".$_POST['d_dd'];
	$sql .= " and adddate >= '".s_for($from_date)."' ";
}

if($_POST['d_mm1'] != '')
{
	$to_date = $_POST['d_yy1']."-".$_POST['d_mm1']."-".$_POST['d_dd1'];
	$sql .= " and adddate <= '".s_for($to_date)."' ";
}

if($_POST['referred_by'] != '')
{
	$sql .= " and referred_by = '".s_for($_POST['referred_by'])."' ";
}

$sql .= " order by lastname";
$my = $db->getResults($sql);
$total_rec = count($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);
$num_users = count($my);

//echo $sql; 
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Patient Report
</span>
<div>
&nbsp;&nbsp;
<a href="patient_report.php" class="editlink" title="EDIT">
	<b>&lt;&lt;Back</b></a>
</div>

<br />

<div align="right">
	<form name="patientreportfrm" action="patient_report_print.php" method="post" target="_blank">
		<input type="hidden" name="d_mm" value="<?php echo $_POST['d_mm']?>" />
		<input type="hidden" name="d_dd" value="<?php echo $_POST['d_dd']?>" />
		<input type="hidden" name="d_yy" value="<?php echo $_POST['d_yy']?>" />
		<input type="hidden" name="d_mm1" value="<?php echo $_POST['d_mm1']?>" />
		<input type="hidden" name="d_dd1" value="<?php echo $_POST['d_dd1']?>" />
		<input type="hidden" name="d_yy1" value="<?php echo $_POST['d_yy1']?>" />
		<input type="hidden" name="referred_by" value="<?php echo $_POST['referred_by']?>" />
		<input type="hidden" name="monthlysub" value="1" />
		<input type="submit" class="addButton" value="Print Report" />
		&nbsp;&nbsp;
	</form>
</div>

<br />
<div align="center" class="red">
	<b><?php echo isset($_GET['msg']) ? $_GET['msg'] : '';?></b>
</div>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="cat_head">
			<?php echo $total_rec;?> Patient(s) found for 
			<?php  
			if($_POST['d_mm'] <> '') {?>
				&nbsp;&nbsp;
				<i>Date From :</i>
			<?php 
				echo $_POST['d_mm'] . ' - ' . $_POST['d_dd'] . ' - ' . $_POST['d_yy'];
			}
			if($_POST['d_mm1'] <> '') {?>
				&nbsp;&nbsp;
				<i>Date To :</i>
			<?php 
				echo $_POST['d_mm1'] . ' - ' . $_POST['d_dd1'] . ' - ' . $_POST['d_yy1'];
			}
			if($_POST['referred_by'] <> '') {
				$referredby_sql = "select * from dental_contact where contactid='".$_POST['referred_by']."'";
				$referredby_myarray = $DB->getRow($referredby_sql);
				$ref_name = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
			?>
				&nbsp;&nbsp;
				<i>Referred By :</i>
				<?php echo $ref_name;
			}?>
		</TD>        
	</TR>
	<?php if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?php paging($no_pages,$index_val,"");?>
		</TD>        
	</TR>
	<?php  }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="40%">
			Name
		</td>
		<td valign="top" class="col_head" width="30%">
			Referred By
		</td>
		<td valign="top" class="col_head" width="30%">
			Added Date
		</td>
	</tr>
	<?php  
	if($num_users == 0){ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="10" align="center">
				No Records
			</td>
		</tr>
	<?php  
	} else {
		foreach ($my as $myarray) {
			$name = st($myarray['lastname'])." ".st($myarray['middlename'])." ".st($myarray['firstname']);
			
			$referredby_sql = "select * from dental_contact where contactid='".$myarray['referred_by']."'";
			$referredby_myarray = $db->getRow($referredby_sql);
			$ref_name = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
			
			if($myarray["status"] == 1){
				$tr_class = "tr_active";
			} else {
				$tr_class = "tr_inactive";
			}
			$tr_class = "tr_active";
		?>
			<tr class="<?php echo $tr_class;?>">
				<td valign="top">
                	<?php echo st($name);?>
				</td>
				<td valign="top">
					<?php echo $ref_name;?>
				</td>
				<td valign="top">
                	<?php echo date('m-d-Y H:m',strtotime(st($myarray["adddate"])));?>
				</td>
			</tr>
	<?php  	}
	}?>
</table>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php  include "includes/bottom.htm";?>
