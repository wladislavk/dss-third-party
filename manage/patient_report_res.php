<? 
include "includes/top.htm";

if($_POST['dailysub'] != 1 && $_POST['monthlysub'] != 1)
{?>
	<script type="text/javascript">
		window.location = 'patient_report.php';
	</script>
	<?
	die();
}

$rec_disp = 200;

if($_REQUEST["page"] != "")
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
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

//echo $sql; 
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
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
		<input type="hidden" name="d_mm" value="<?=$_POST['d_mm']?>" />
		<input type="hidden" name="d_dd" value="<?=$_POST['d_dd']?>" />
		<input type="hidden" name="d_yy" value="<?=$_POST['d_yy']?>" />
		<input type="hidden" name="d_mm1" value="<?=$_POST['d_mm1']?>" />
		<input type="hidden" name="d_dd1" value="<?=$_POST['d_dd1']?>" />
		<input type="hidden" name="d_yy1" value="<?=$_POST['d_yy1']?>" />
		<input type="hidden" name="referred_by" value="<?=$_POST['referred_by']?>" />
		<input type="hidden" name="monthlysub" value="1" />
		<input type="submit" class="addButton" value="Print Report" />
		&nbsp;&nbsp;
	</form>
</div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="cat_head">
			<?=$total_rec;?> Patient(s) found for 
			
			<? if($_POST['d_mm'] <> '') {?>
				&nbsp;&nbsp;
				<i>Date From :</i>
				<?=$_POST['d_mm'];?> - <?=$_POST['d_dd'];?> - <?=$_POST['d_yy'];?>
			<? }?>
			<? if($_POST['d_mm1'] <> '') {?>
				&nbsp;&nbsp;
				<i>Date To :</i>
				<?=$_POST['d_mm1'];?> - <?=$_POST['d_dd1'];?> - <?=$_POST['d_yy1'];?>
			<? }?>
			<? if($_POST['referred_by'] <> '') {
				$referredby_sql = "select * from dental_referredby where referredbyid='".$_POST['referred_by']."'";
				$referredby_my = mysql_query($referredby_sql) or die(mysql_error()." | ".$referredby_sql);
				$referredby_myarray = mysql_fetch_array($referredby_my);
				$ref_name = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
			?>
				&nbsp;&nbsp;
				<i>Referred By :</i>
				<?=$ref_name;?>
			<? }?>
		</TD>        
	</TR>
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
			Name
		</td>
		<td valign="top" class="col_head" width="30%">
			Referred By
		</td>
		<td valign="top" class="col_head" width="30%">
			Added Date
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
			$name = st($myarray['lastname'])." ".st($myarray['middlename'])." ".st($myarray['firstname']);
			
			$referredby_sql = "select * from dental_referredby where referredbyid='".$myarray['referred_by']."'";
			$referredby_my = mysql_query($referredby_sql) or die(mysql_error()." | ".$referredby_sql);
			$referredby_myarray = mysql_fetch_array($referredby_my);
			
			$ref_name = st($referredby_myarray['salutation'])." ".st($referredby_myarray['firstname'])." ".st($referredby_myarray['middlename'])." ".st($referredby_myarray['lastname']);
			
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
                	<?=st($name);?>
				</td>
				<td valign="top">
					<?=$ref_name;?>
				</td>
				<td valign="top">
                	<?=date('m-d-Y H:m',strtotime(st($myarray["adddate"])));?>
				</td>
			</tr>
	<? 	}
	}?>
</table>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>