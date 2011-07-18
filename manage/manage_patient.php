<?php 
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

if(!isset($_REQUEST['sort'])){
  $_REQUEST['sort'] = 'lastname';
  $_REQUEST['sortdir'] = 'ASC';
}

$sql = "SELECT "
		 . "  p.patientid, p.status, p.lastname, p.firstname, p.middlename, p.premedcheck, "
     . "  s.fspage1_complete, s.next_visit, s.last_visit, s.last_treatment, s.appliance, "
		 . "  s.delivery_date, s.vob, s.ledger "
		 . "FROM "
		 . "  dental_patients p  "
		 . "  LEFT JOIN dental_patient_summary s ON p.patientid = s.pid  "
		 . "WHERE "
		 . " p.docid='".$_SESSION['docid']."'";
if(isset($_GET['pid']))
{
	$sql .= " AND patientid = ".$_GET['pid'];
}
if($_GET['sh'] != 2)
{
	$sql .= " AND status = 1";
}
if(isset($_REQUEST['sort'])){
  if ($_REQUEST['sort'] == 'lastname') {
  	$sql .= " ORDER BY p.lastname ".$_REQUEST['sortdir'].", p.firstname ".$_REQUEST['sortdir'];
  } else {
	  $sql .= " ORDER BY ".$_REQUEST['sort']." ".$_REQUEST['sortdir'];
	}
}

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
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 'lastname')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=lastname&sortdir=<?php echo ($_REQUEST['sort']=='lastname'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Name</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 's.fspage1_complete')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=s.fspage1_complete&sortdir=<?php echo ($_REQUEST['sort']=='s.fspage1_complete'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Flow Sheet</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 's.next_visit')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=s.next_visit&sortdir=<?php echo ($_REQUEST['sort']=='s.next_visit'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Next Visit</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 's.last_visit')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=s.last_visit&sortdir=<?php echo ($_REQUEST['sort']=='s.last_visit'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Last Visit</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 's.last_treatment')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=s.last_treatment&sortdir=<?php echo ($_REQUEST['sort']=='s.last_treatment'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Last Treatment</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 's.appliance')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=s.appliance&sortdir=<?php echo ($_REQUEST['sort']=='s.appliance'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Appliance</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 's.delivery_date')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=s.delivery_date&sortdir=<?php echo ($_REQUEST['sort']=='s.delivery_date'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Appliance Since</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 's.vob')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=s.vob&sortdir=<?php echo ($_REQUEST['sort']=='s.vob'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">VOB</a>
		</td>
		<td valign="top" class="col_head  <?= ($_REQUEST['sort'] == 's.ledger')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="10%">
			<a href="manage_patient.php?<?= isset($_GET['pid'])?"pid=".$_GET['pid']."&":''; ?>sort=s.ledger&sortdir=<?php echo ($_REQUEST['sort']=='s.ledger'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Ledger</a>
		</td>
	</tr>
<? if(mysql_num_rows($my) == 0)
	{ ?>
		<tr class="tr_bg">
			<td valign="top" class="col_head" colspan="9" align="center">
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
			<tr class="<?=$tr_class;?> initial_list">
				<td valign="top">
					<?=st($myarray["lastname"]);?>,&nbsp;
										<?=st($myarray["firstname"]); ?>&nbsp;
                    <?= (!empty($myarray["middlename"]) ? st($myarray["middlename"]) : "");
                    
                    if($myarray["premedcheck"] == 1){
                    echo "&nbsp;&nbsp;&nbsp;<font style=\"font-weight:bold; color:#FF0000;\">*PM</font>";
                    }
                    ?> 
				</td>
				<td valign="top">
        	<a href="manage_flowsheet3.php?pid=<?=$myarray["patientid"];?>"><?= $myarray['fspage1_complete'] ?></a>
        </td>
        <td valign="top">
        	<a href="manage_flowsheet3.php?pid=<?=$myarray["patientid"];?>&page=page2"><?= $myarray['next_visit'] ?></a>
        </td>
        <td valign="top">
        	<a href="manage_flowsheet3.php?pid=<?=$myarray["patientid"];?>&page=page2"><?= $myarray['last_visit'] ?></a>
        </td>
        <td valign="top">
          <a href="manage_flowsheet3.php?pid=<?=$myarray["patientid"];?>&page=page2"><?= $myarray['last_treatment'] ?></a>
        </td>
				<td valign="top">
	       	<a href="dss_summ.php?pid=<?=$myarray["patientid"];?>"><?= $myarray['appliance'] ?></a>
        </td>
        <td valign="top">
	       	<a href="manage_flowsheet3.php?pid=<?=$myarray["patientid"];?>&page=page2"><?= $myarray['delivery_date'] ?></a>
	      </td>
        <td valign="top">
	       	<a href="manage_insurance.php?pid=<?=$myarray["patientid"];?>"><?= $myarray['vob'] ?></a>
        </td>
        <td valign="top">
	       	<a href="manage_ledger.php?pid=<?=$myarray["patientid"];?>"><?= $myarray['ledger'] ?></a>
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
