<?php
include "admin/includes/main_include.php";

$rec_disp = 40;

if($_REQUEST["page"] != "")
	$index_val = $_REQUEST["page"];
else
	$index_val = 0;
	
$i_val = $index_val * $rec_disp;
$sql = "select * from dental_contact where docid='".$_SESSION['docid']."' order by lastname";
$total_rec = $db->getNumberRows($sql);
$no_pages = $total_rec/$rec_disp;

$sql .= " limit ".$i_val.",".$rec_disp;
$my = $db->getResults($sql);
$num_contact = count($my);?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?php echo st($page_myarray['keywords']);?>" />
<title><?php echo $sitename;?></title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body>

<table width="100%" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
    <tr bgcolor="#FFFFFF">
	    <td> 
<br />
<span class="admin_head">
	Select Contact
</span>
<br />&nbsp;

<form name="selfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<?php if($total_rec > $rec_disp) {?>
	<TR bgColor="#ffffff">
		<TD  align="right" colspan="15" class="bp">
			Pages:
			<?php paging($no_pages,$index_val,"");?>
		</TD>        
	</TR>
	<?php }?>
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="20%">
			Name
		</td>
		<td valign="top" class="col_head" width="20%">
			Company
		</td>
		<td valign="top" class="col_head" width="50%">
			Type
		</td>
		<td valign="top" class="col_head" width="10%">
			Select
		</td>
	</tr>
<?php 
if($num_contact == 0){ ?>
	<tr class="tr_bg">
		<td valign="top" class="col_head" colspan="10" align="center">
			No Records
		</td>
	</tr>
<?php 
}else{
	foreach ($my as $myarray) {
		$contype_sql = "SELECT * FROM dental_contacttype where status=1 and contacttypeid='".s_for($myarray['contacttypeid'])."' ";
		$contype_myarray = $db->getRow($contype_sql);
		
		if($myarray["status"] == 1){
			$tr_class = "tr_active";
		} else {
			$tr_class = "tr_inactive";
		}
		$name = st($myarray['lastname'])." ".st($myarray['middlename']).", ".st($myarray['firstname']);
			
		$sel_val = st($name);
		if(st($myarray['company']) <> ''){
			$sel_val .= "
		".st($myarray['company']);
		}
		if(st($myarray['add1']) <> ''){
			$sel_val .= "
		".st($myarray['add1']);
		}
		if(st($myarray['add2']) <> ''){
			$sel_val .= "
		".st($myarray['add2']);
		}
		if(st($myarray['city']) <> ''){
			$sel_val .= "
		".st($myarray['city']);
		}
		if(st($myarray['state']) <> ''){
			$sel_val .= " ".st($myarray['state']);
		}
		if(st($myarray['zip']) <> ''){
			$sel_val .= " ".st($myarray['zip']);
		}?>
	<tr class="<?php echo $tr_class;?>">
		<td valign="top">
        	<?php echo $name;?>
		</td>
		<td valign="top">
			<?php echo st($myarray["company"]);?>
		</td>
		<td valign="top">
			<?php echo st($contype_myarray["contacttype"]);?>
		</td>
		<td valign="top" align="center">
			<input type="radio" name="sel_con" value="<?php echo st($sel_val);?>" onclick="fill_up(this.value)" />
		</td>
	</tr>
<?php
	}
}?>
</table>
</form>
<script type="text/javascript">
function fill_up(fa){
	parent.document.q_recipientsfrm.<?php echo $_GET['tx']?>.value = fa;
	parent.disablePopup1();
}
</script>

<br /><br />	

			</td>
		</tr>
	</table>
    

</body>
</html>