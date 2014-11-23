<?php
include "includes/top.htm";

if(isset($_GET['delid']) && $_GET['delid']){

  $d = "UPDATE dental_letter_templates_custom SET status=2 WHERE docid='".$_SESSION['docid']."'
  		AND id='".mysqli_real_escape_string($con,$_GET['delid'])."'";
  $db->query($d);
}

$sql = "select * from dental_letter_templates_custom where docid='".$_SESSION['docid']."' AND status=1";
$total_rec = $db->getNumberRows($sql);

$my = $db->getResults($sql);
$num_contact = count($my);
?>

<link rel="stylesheet" href="popup/popup.css" type="text/css" media="screen" />
<script src="popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Custom Letter Templates
</span>
<br />
<br />
&nbsp;

<div align="right">
	<button onclick="Javascript: loadPopup('select_custom_letter_template.php')" class="addButton">
		Add New Template
	</button>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="60%">
			Name
		</td>
		<td valign="top" class="col_head" width="10%">
			Action
		</td>
	</tr>
	<?php if($num_contact == 0)
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
		if (!empty($my)) foreach ($my as $myarray)
		{
		?>
			<tr class="<?php echo (!empty($tr_class) ? $tr_class : '');?>">
				<td valign="top">
					<?php echo st($myarray["name"]);?>
				</td>
				<td valign="top">
					<a href="Javascript:;"  onclick="Javascript: window.location='add_custom_letter_template.php?ed=<?php echo $myarray["id"];?>';" class="editlink" title="EDIT">
						Edit
					</a>
				</td>
			</tr>
	<?php 	}
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
