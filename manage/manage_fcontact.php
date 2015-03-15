<?php namespace Ds3\Legacy; ?><?php
include "includes/top.htm";

if(!empty($_REQUEST["delid"]))
{
	$del_sql = "delete from dental_fcontact where contactid='".$_REQUEST["delid"]."'";
	$db->query($del_sql);
	
	$msg= "Deleted Successfully";
	?>
	<script type="text/javascript">
		//alert("Deleted Successfully");
		window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
	</script>
	<?php
	die();
}

$rec_disp = 10;

if(!empty($_REQUEST["page"]))
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select c.*, ct.contacttype from dental_contact c
	LEFT JOIN dental_contacttype ct ON ct.contacttypeid=c.contacttypeid
	WHERE c.corporate=1 ";

if (!empty($_GET['sort'])) {
	switch($_GET['sort']){
	  case 'company':
	    $sql .= " ORDER BY company ".$_GET['sortdir'];
	    break;
	  case 'type':
	    $sql .= " ORDER BY ct.contacttype ".$_GET['sortdir'];
	    break;
	  default:
	    $sql .= " ORDER BY lastname ".$_GET['sortdir'].", firstname ".$_GET['sortdir'];
	    break;
	}
}

$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);
$num_contact = count($my);
?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/manage.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Corporate Contacts
</span>
<br />
<br />
&nbsp;



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
        <td valign="top" class="col_head  <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'company')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="30%">
	        <a href="manage_fcontact.php?sort=company&sortdir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='company'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Company</a>
		</td>
        <td valign="top" class="col_head  <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'type')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="20%">
            <a href="manage_fcontact.php?sort=type&sortdir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='type'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Type</a>
		</td>
        <td valign="top" class="col_head  <?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort'] == 'name')?'arrow_'.strtolower($_REQUEST['sortdir']):''; ?>" width="30%">
            <a href="manage_fcontact.php?sort=name&sortdir=<?php echo (!empty($_REQUEST['sort']) && $_REQUEST['sort']=='name'&&$_REQUEST['sortdir']=='ASC')?'DESC':'ASC'; ?>">Name</a>
		</td>
		<td valign="top" class="col_head" width="20%">
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
		foreach ($my as $myarray) {

			if($myarray["status"] == 1)
			{
				$tr_class = "tr_active";
			}
			else
			{
				$tr_class = "tr_inactive";
			}
			
			$name = st($myarray['lastname'])." ".st($myarray['middlename']).", ".st($myarray['firstname']);
		?>
	<tr class="<?php echo $tr_class;?>">
		<td valign="top" >
			<?php echo st($myarray["company"]);?>
		</td>
		<td valign="top" >
			<?php echo st($myarray["contacttype"]);?>
		</td>
		<td valign="top">
			<?php echo $name;?>
		</td>
		<td valign="top">
			<a href="Javascript:;"  onclick="Javascript: loadPopup('view_contact.php?ed=<?php echo $myarray["contactid"];?>&corp=1');" class="editlink" title="EDIT">
				Quick View 
			</a>
			|
			<a href="Javascript:;"  onclick="Javascript: loadPopup('view_fcontact.php?ed=<?php echo $myarray["contactid"];?>');" class="editlink" title="EDIT">
				View Full 
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
