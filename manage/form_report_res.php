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
$sql = "select * from dental_forms where docid='".$_SESSION['docid']."' ";

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

$sql .= " order by adddate";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

//echo $sql; 
?>

<span class="admin_head">
	Form Report
</span>
<div>
&nbsp;&nbsp;
<a href="form_report.php" class="editlink" title="EDIT">
	<b>&lt;&lt;Back</b></a>
</div>

<br />

<div align="right">
	<form name="formreportfrm" action="form_report_print.php" method="post" target="_blank">
		<input type="hidden" name="d_mm" value="<?=$_POST['d_mm']?>" />
		<input type="hidden" name="d_dd" value="<?=$_POST['d_dd']?>" />
		<input type="hidden" name="d_yy" value="<?=$_POST['d_yy']?>" />
		<input type="hidden" name="d_mm1" value="<?=$_POST['d_mm1']?>" />
		<input type="hidden" name="d_dd1" value="<?=$_POST['d_dd1']?>" />
		<input type="hidden" name="d_yy1" value="<?=$_POST['d_yy1']?>" />
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
			<?=$total_rec;?> Form(s) found for 
			
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
		<td valign="top" class="col_head" width="30%">
			Date
		</td>
		<td valign="top" class="col_head" width="30%">
			Form ID
		</td>
		<td valign="top" class="col_head" width="40%">
			Patient Name
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
			
			$patient_sql = "select * from dental_patients where patientid='".$myarray['patientid']."'";
			$patient_my = mysql_query($patient_sql) or die(mysql_error()." | ".$patient_sql);
			$patient_myarray = mysql_fetch_array($patient_my);
			$pat_name = st($patient_myarray['lastname'])." ".st($patient_myarray['middlename'])." ".st($patient_myarray['firstname']);
			
			
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
					<?=date('m-d-Y H:m',strtotime(st($myarray["adddate"])));?>
				</td>
				<td valign="top">
					<?=st($myarray["formid"]);?>
				</td>
				<td valign="top">
                	<?=st($pat_name);?>
				</td>
			</tr>
	<? 	}
	}?>
</table>

<br /><br />	
<? include "includes/bottom.htm";?>