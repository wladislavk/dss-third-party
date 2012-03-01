<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "" && $_SESSION['admin_access']==1)
{
	$del_sql = "delete from dental_patients where patientid='".$_REQUEST["delid"]."'";
	mysql_query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?=$_SERVER['PHP_SELF']?>?msg=<?=$msg?>&docid=<?=$_GET['docid']?>";
	</script>
	<?
	die();
}

$doc_sql = "select * from dental_users where user_access=2 order by username";
$doc_my = mysql_query($doc_sql);

$doc_my1 = mysql_query($doc_sql) or die(mysql_error());
$doc_myarray1 = mysql_fetch_array($doc_my1);

if($_GET['docid'] == '')
{
	$_GET['docid'] = $doc_myarray1['userid'];
}

$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_patients where docid='".$_GET['docid']."' order by lastname, firstname";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_users=mysql_num_rows($my);

?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/jquery-1.2.6.min.js" type="text/javascript"></script>
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Patient
    -
    <select class="tbox" onchange="Javascript: window.location='<?=$_SERVER['PHP_SELF'];?>?docid='+this.value;">
        <? while($doc_myarray = mysql_fetch_array($doc_my))
		{?>
    		<option value="<?=st($doc_myarray['userid']);?>" <? if(st($doc_myarray['userid']) == $_GET['docid']) echo " selected";?>>
            	<?=st($doc_myarray['username']);?> [ <?=st($doc_myarray['name']);?> ]
            </option>
        <? }?>
    </select>
</span>
<br />
<br />
&nbsp;

<div align="right">
	<button onclick="Javascript: loadPopup('add_patient.php?docid=<?=$_GET['docid']?>');" class="addButton">
		Add New Patient
	</button>
	&nbsp;&nbsp;
</div>

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
				 paging($no_pages,$index_val,"docid=".$_GET['docid']);
			?>
		</TD>
	</TR>
	<? }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="90%">
			Name
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
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
					<?=st($myarray["firstname"]);?>&nbsp;
                    <?=st($myarray["middlename"]);?>.&nbsp;
                    <?=st($myarray["lastname"]);?> 
				</td>
				<td valign="top">
					<a href="Javascript:;" onclick="Javascript: loadPopup('add_patient.php?ed=<?=$myarray["patientid"];?>&docid=<?=$_GET['docid']?>');" class="editlink" title="EDIT">
						Edit
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
