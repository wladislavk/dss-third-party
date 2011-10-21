<? 
include "includes/top.htm";
if($_GET['rsource']==DSS_REFERRED_PHYSICIAN){
$ref_sql = "select * from dental_contact where docid='".$_SESSION['docid']."' and contactid='".s_for($_GET['rid'])."'";
}elseif($_GET['rsource']==DSS_REFERRED_PATIENT){
$ref_sql = "select * from dental_patient where docid='".$_SESSION['docid']."' and patientid='".s_for($_GET['rid'])."'";
}
$ref_my = mysql_query($ref_sql);
$ref_myarray = mysql_fetch_array($ref_my);

/*if(st($ref_myarray['referredbyid']) == '')
{
	?>
	<script type="text/javascript">
		window.location = 'manage_referredby.php';
	</script>
	<?
	die();
}*/
$name = st($ref_myarray['salutation'])." ".st($ref_myarray['firstname'])." ".st($ref_myarray['middlename'])." ".st($ref_myarray['lastname']);


$rec_disp = 20;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_patients where docid='".$_SESSION['docid']."' and referred_by='".s_for($_GET['rid'])."' AND referred_source='".s_for($_GET['rsource'])."' order by adddate desc";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_referredby=mysql_num_rows($my);

?>

<span class="admin_head">
	Referred By Detail 
	-
    <i><?=$name;?></i>
</span>
<br>
&nbsp;&nbsp;
<a href="manage_referredby.php" class="editlink" title="EDIT">
	<b>&lt;&lt;Back </b></a>
<br />

<br />
<div align="center" class="red">
	<b><? echo $_GET['msg'];?></b>
</div>

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
		<td valign="top" class="col_head" width="40%">
			Name
		</td>
		<td valign="top" class="col_head" width="60%">
			Add Date
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
			
			$name = st($myarray['salutation'])." ".st($myarray['firstname'])." ".st($myarray['middlename'])." ".st($myarray['lastname']);
		?>
			<tr class="<?=$tr_class;?>">
				<td valign="top">
					<?=$name;?>
				</td>
				<td valign="top">
					<?=date('M d,Y H:i',strtotime(st($myarray["adddate"])));?>
				</td>
			</tr>
	<? 	}
	}?>
</table>


<br /><br />	
<? include "includes/bottom.htm";?>
