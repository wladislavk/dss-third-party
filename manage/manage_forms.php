<? 
include "includes/top.htm";

?>
<script type="text/javascript">
	window.location = "manage_patient.php";
</script>
<?
die();
if($_REQUEST["delid"] != "")
{
	$del_sql = "delete from dental_forms where formid='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>&pid=<?=$_GET['pid'];?>";
	</script>
	<?
	die();
}

$pat_sql = "select * from dental_patients where patientid='".s_for($_GET['pid'])."'";
$pat_my = mysql_query($pat_sql);
$pat_myarray = mysql_fetch_array($pat_my);

$name = st($pat_myarray['lastname'])." ".st($pat_myarray['middlename']).", ".st($pat_myarray['firstname']);

if($pat_myarray['patientid'] == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_patient.php';
	</script>
	<?
	die();
}

$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_forms where docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['pid'])."' order by adddate";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<script src="admin/popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Exam
	-
    Patient <i><?=$name;?></i>
</span>
<br />
&nbsp;&nbsp;
<a href="manage_patient.php" class="editlink" title="EDIT">
	<b>&lt;&lt;Back</b></a>
<br />

<? if($num_users == 0) {?>
<div align="right">
	<button onclick="Javascript: window.location = 'add_form.php?pid=<?=$_GET['pid'];?>';" class="addButton">
		Add New Exam
	</button>
	&nbsp;&nbsp;
</div>
<? }?>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

<form name="sortfrm" action="<?=$_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
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
		<td valign="top" class="col_head" width="20%">
			Date
		</td>
		<td valign="top" class="col_head" width="40%">
			Type
		</td>
		<td valign="top" class="col_head" width="10%">
			ID
		</td>
		<td valign="top" class="col_head" width="10%">
			DSS Summary
		</td>
		<td valign="top" class="col_head" width="10%">
			Letters
		</td>
		<td valign="top" class="col_head" width="20%">
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
                	<?=date('m-d-Y H:i',strtotime(st($myarray["adddate"])));?>
				</td>
                <td valign="top">
                	Dental Sleep Dentistry Questionaire/Exam
                </td>
                <td valign="top">
                	<?=st($myarray["formid"]);?>
                </td>
				<td valign="top">
                	<a href="dss_summary.php?pid=<?=$_GET['pid'];?>" class="dellink" title="DELETE">
						Manage
					</a>
                </td>
				<td valign="top">
                	<a href="dss_letters.php?pid=<?=$_GET['pid'];?>" class="dellink" title="DELETE">
						Manage
					</a>
                </td>
				<td valign="top">
					<a href="q_page1.php?pid=<?=$_GET['pid'];?>" class="editlink" title="EDIT">
						Edit 
					</a>
                    
                    <a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$myarray["formid"];?>&pid=<?=$_GET['pid'];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
						 Delete 
					</a>
				</td>
			</tr>
	<? 	}
	}?>
</table>
</form>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>
