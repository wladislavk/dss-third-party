<? 
include "includes/top.htm";

if($_REQUEST["delid"] != "")
{
	$del_sql = "delete from dental_referredby where referredbyid='".$_REQUEST["delid"]."'";
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
//$sql = "select * from dental_referredby where docid='".$_SESSION['docid']."' order by firstname";
$sql = "select 
		dc.contactid,
		dc.salutation,
		dc.firstname,
		dc.middlename,
		dc.lastname, 
		count(p.patientid) as num_ref, 
		'".DSS_REFERRED_PHYSICIAN."' as referral_type
	from dental_contact dc 
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
		count(p.patientid),
		'".DSS_REFERRED_PATIENT."'
	from dental_patients dp
		INNER JOIN dental_patients p ON dp.patientid=p.referred_by
	where p.docid='".$_SESSION['docid']."'
                AND p.referred_source=".DSS_REFERRED_PATIENT."
		GROUP BY dp.patientid
  ORDER BY lastname ASC, firstname ASC
";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my=mysql_query($sql) or die(mysql_error());
$num_referredby=mysql_num_rows($my);

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
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
		<td valign="top" class="col_head" width="20%">
			Name
		</td>
		<td valign="top" class="col_head" width="62%">
			User Type	
		</td>
		<td valign="top" class="col_head" width="10%">
			Patients
		</td>
	</tr>
	</table>
	<div style="overflow:auto; height:400px; overflow-x:hidden; overflow-y:scroll;">
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
			$pat_sql = "select * from dental_patients where docid='".$_SESSION['docid']."' and referred_by='".$myarray["referredbyid"]."'";
			$pat_my = mysql_query($pat_sql);
			
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
				<td valign="top" width="20%">
					<?=$name;?>
				</td>
				<td valign="top" width="62%">
					<?=st($dss_referred_labels[$myarray["referral_type"]]);?>
				</td>
				<td valign="top" width="10%">
					<a href="referredby_patient.php?rid=<?=$myarray["contactid"];?>&rsource=<?=$myarray["referral_type"];?>" class="editlink">
						<?=$myarray['num_ref'];?>
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
