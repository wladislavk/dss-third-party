<?php namespace Ds3\Libraries\Legacy; ?><? 
include "admin/includes/main_include.php";

if(!empty($_POST['selsub']) && $_POST['selsub'] == 1)
{
	$t_text = $_POST['general'];
	?>
	<script type="text/javascript">
		var old = parent.document.ex_page4frm.<?php echo $_GET['tx']?>.value;
		parent.document.ex_page4frm.<?php echo $_GET['tx']?>.value = 'Generalized - <?php echo $t_text; ?>';
		if(old != 'Generalized - <?php echo  $t_text; ?>'){
			parent.edited = true;
		}
		//parent.disablePopup1();
		parent.disablePopupRefClean();
		if("<?php echo  $_GET['tx']; ?>" == "missing"){
			parent.reloadPerio("<?php echo $t_text; ?>");
		}
	</script>
	<?
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="keywords" content="<?php echo st(!empty($page_myarray['keywords']) ? $page_myarray['keywords'] : '');?>" />
	<title><?php echo $sitename;?></title>
	<link href="css/admin.css?v=20160404" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
	<script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
	<script type="text/javascript" src="admin/script/jquery-1.6.2.min.js"></script>
	<script type="text/javascript" src="script/validation.js"></script>
</head>
<body>

<table width="100%" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
    <tr bgcolor="#FFFFFF">
	    <td> 
<br />
<form name="selfrm" action="<?php echo $_SERVER['PHP_SELF']?>?tx=<?php echo (!empty($_GET['tx']) ? $_GET['tx'] : '');?>" method="post">
<span class="admin_head">
	<?php echo ucwords(!empty($_GET['tx']) ? $_GET['tx'] : '');?> Teeth # <input type="submit" value="save" />
</span>
<div style="clear:both"></div>
	<input <?php echo  (!empty($_GET['fval']) && $_GET['fval']=="Generalized - Mild")?'checked="checked"':'';?> name="general" type="radio" value="Mild" /> Mild<br />
        <input <?php echo  (!empty($_GET['fval']) && $_GET['fval']=="Generalized - Moderate")?'checked="checked"':'';?> name="general" type="radio" value="Moderate" /> Moderate<br />
        <input <?php echo  (!empty($_GET['fval']) && $_GET['fval']=="Generalized - Severe")?'checked="checked"':'';?> name="general" type="radio" value="Severe" /> Severe<br />
            <input type="hidden" name="selsub" value="1" />
</form>
<script type="text/javascript">
	function fill_up(fa)
	{
		parent.document.q_recipientsfrm.<?php echo $_GET['tx']?>.value = fa;
		//parent.disablePopup1();
		parent.disablePopupRefClean();
	}
</script>

<br /><br />	

			</td>
		</tr>
	</table>
    

</body>
</html>
