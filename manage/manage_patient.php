<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "")
{
	$del_sql = "delete from dental_patients where patientid='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>";
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
$sql = "select * from dental_patients where docid='".$_SESSION['docid']."'";
if(isset($_GET['pid']))
{
	$sql .= " and patientid = ".$_GET['pid'];
}
if($_GET['sh'] != 2)
{
	$sql .= " and status = 1";
}
$sql .= " order by lastname, firstname";
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
	Manage Patient
	-
	<select name="show" onchange="Javascript: window.location ='<?=$_SERVER['PHP_SELF'];?>?sh='+this.value;">
		<option value="1">Active Patients</option>
		<option value="2" <? if($_GET['sh'] == 2) echo " selected";?> >All Patients</option>
	</select>

</span>
<br />
<br />
&nbsp;

<div align="right">
		<div style="float:left;margin-right:386px;width:140px;padding-left:4px;"><script type="text/javascript" language="JavaScript" src="script/find.js">
</script>
</div>

	<button onclick="Javascript: parent.location='add_patient.php';" class="addButton">
		Add New Patient
	</button>
	&nbsp;&nbsp;
	
	<button onclick="Javascript: loadPopup('print_patient.php?st=1');" class="addButton">
		Print Active Patient
	</button>
	&nbsp;&nbsp;
	
	<button onclick="Javascript: loadPopup('print_patient.php?st=2');" class="addButton">
		Print In-Active Patient
	</button>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>
<style>
#contentMain tr:hover{
background:#cccccc;
}

#contentMain td:hover{
background:#999999;
}
</style>
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
		<td valign="top" class="col_head" width="17%">
			Name
		</td>
		<td valign="top" class="col_head" width="10%">
			Questionnaire
		</td>
		<td valign="top" class="col_head" width="11%">
			Clinical Exam
		</td>
		<td valign="top" class="col_head" width="12%">
			Summary Sheet
		</td>
		<td valign="top" class="col_head" width="6%">
			Ledger
		</td>
		<td valign="top" class="col_head" width="12%">
			Progress Notes
		</td>
		<td valign="top" class="col_head" width="8%">
			Insurance
		</td>
		<? if(st($_SESSION['adminuserid'] <> '')) {?>
		<td valign="top" class="col_head" width="7%">
			Letters
		</td>
		<? }?>
		<td valign="top" class="col_head" width="10%">
			Flow Sheet
		</td>
		<td valign="top" class="col_head" width="14%">
			Pt. Contact Info
		</td>
	</tr>
	</table>
	<div style="overflow:auto; height:400px; overflow-x:hidden;">
<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 10px;" >
	
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
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top" width="17%">
					<?=st($myarray["lastname"]);?>&nbsp;
                    <?=st($myarray["middlename"]);?>,&nbsp;
                    <?=st($myarray["firstname"]);
                    if($myarray["premedcheck"] == 1){
                    echo "&nbsp;&nbsp;&nbsp;<font style=\"font-weight:bold; color:#FF0000;\">*PM";
                    }
                    ?> 
				</td>
				<td valign="top" width="10%">
                	<a href="q_page1.php?pid=<?=$myarray["patientid"];?>" class="dellink" title="DELETE">
						Manage
					</a>
                </td>
                <td valign="top" width="11%">
                	<a href="ex_page4.php?pid=<?=$myarray["patientid"];?>" class="dellink" title="DELETE">
						Manage
					</a>
                </td>
                <td valign="top" width="12%">
                	<a href="dss_summ.php?pid=<?=$myarray["patientid"];?>" class="dellink" title="DELETE">
						Manage
					</a>
                </td>
                <td valign="top" width="6%">
                	<a href="manage_ledger.php?pid=<?=$myarray["patientid"];?>" class="dellink" title="DELETE">
						Manage
					</a>
                </td>
				<td valign="top" width="12%">
                	<a href="manage_progress_notes.php?pid=<?=$myarray["patientid"];?>" class="dellink" title="DELETE">
						Manage
					</a>
                </td>
                <td valign="top" width="8%">
                	<a href="manage_insurance.php?pid=<?=$myarray["patientid"];?>" class="dellink" title="DELETE">
						Manage
					</a>
                </td>
				<? if(st($_SESSION['adminuserid'] <> '')) {?>
                <td valign="top" width="7%">
                	<a href="dss_letters.php?pid=<?=$myarray["patientid"];?>" class="dellink" title="DELETE">
						Manage
					</a>
                </td>
				<? }?>
                <td valign="top" width="10%">
                	<a href="manage_flowsheet3.php?pid=<?=$myarray["patientid"];?>" class="dellink" title="DELETE">
						Manage
					</a>
                </td>
				<td valign="top" width="14%">
					<a href="add_patient.php?ed=<?=$myarray["patientid"];?>&pid=<?=$myarray["patientid"];?>" class="editlink" title="EDIT">
						Edit 
					</a>
                    
                    <a href="<?=$_SERVER['PHP_SELF']?>?delid=<?=$myarray["patientid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" class="dellink" title="DELETE">
						 Delete 
					</a>
				</td>
			</tr>
	<? 	}
	}?>
</table>
</div>
</form>


<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<? include "includes/bottom.htm";?>