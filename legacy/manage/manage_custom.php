<?php namespace Ds3\Libraries\Legacy; ?><?php
include "includes/top.htm";

$db = new Db();

if(!empty($_REQUEST["delid"]))
{
	$del_sql = "delete from dental_custom where customid='".$_REQUEST["delid"]."'";
	$db->query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
	</script>
	<?php
	trigger_error("Die called", E_USER_ERROR);
}

$docId = (int)$_SESSION['docid'];
$isSoapAuthorized = $db->getNumberRows("SELECT doc_id
    FROM dental_api_permissions permission
        LEFT JOIN dental_api_permission_resource_groups api_group ON api_group.id = permission.group_id
    WHERE permission.doc_id = '$docId'
");

$conditionalNot = 'NOT';

if (!empty($_GET['soap']) && $isSoapAuthorized) {
    $conditionalNot = '';
}

$rec_disp = 20;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "SELECT *
    FROM dental_custom
    WHERE docid = '$docId'
        AND description $conditionalNot LIKE '%\"is_soap\":\"1\",%'
    ORDER BY title
";
$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);
$num_custom = count($my);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/manage.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Custom <?= $isSoapAuthorized ? 'SOAP Note' : 'Text' ?>
</span>
<br />
<br />
&nbsp;

<div align="right">
	<button onclick="Javascript: loadPopup('add_custom.php?soap=<?= $isSoapAuthorized ?>');" class="addButton">
		Add New Custom <?= $isSoapAuthorized ? 'SOAP Note' : 'Text' ?>
	</button>
	&nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
	<b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<?php if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?php
				 paging($no_pages,$index_val,"");
			?>
		</TD>        
	</TR>
	<?php }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="80%">
			Title
		</td>
		<td valign="top" class="col_head" width="20%">
			Action
		</td>
	</tr>
</table>
	<div style="overflow:auto; height:400px; overflow-x:hidden; overflow-y:scroll;">
<table width="100%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 10px;" >
	<?php if($num_custom == 0)
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
		foreach ($my as $myarray) {

			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
		?>
			<tr class="<?php echo $tr_class;?>">
				<td valign="top" width="80%">
					<?php echo st($myarray["title"]);?>
				</td>
				<td valign="top" width="20%">
					<a href="Javascript:;"  onclick="Javascript: loadPopup('add_custom.php?ed=<?php echo $myarray["customid"];?>&soap=<?= $isSoapAuthorized ?>');" class="editlink" title="EDIT">
						Edit 
					</a>
                    
				</td>
			</tr>
	<?php 	}
	}?>
</table>
</div>
</form>

<div id="popupContact" style="width:750px;height:460px">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />	
<?php include "includes/bottom.htm";?>
