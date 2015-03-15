<?php namespace Ds3\Legacy; ?><? 
include "admin/includes/main_include.php";

if($_POST['selsub'] == 1)
{
	$per_teeth = $_POST['per_teeth'];
	$pri_teeth = $_POST['pri_teeth'];
	
	$t_text = '';
	if(is_array($pri_teeth))
	{
		asort($pri_teeth);
		$t_text .= implode(', ',$pri_teeth);
	}
	
	if(is_array($per_teeth))
	{
		if($t_text <> '' )
			$t_text .= ', ';
		
		asort($per_teeth);
		$t_text .= implode(', ',$per_teeth);
	}
	
	?>
	<script type="text/javascript">
		parent.document.ex_page4frm.<?=$_GET['tx']?>.value = '<?=$t_text;?>';
		parent.disablePopup1();
	</script>
	<?
}

$mt_arr = explode(',',$_GET['mt']);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="keywords" content="<?=st($page_myarray['keywords']);?>" />
<title><?=$sitename;?></title>
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body>

<table width="100%" border="0" bgcolor="#929B70" cellpadding="1" cellspacing="1" align="center">
    <tr bgcolor="#FFFFFF">
	    <td> 
<br />
<span class="admin_head">
	<?=ucwords($_GET['tx']);?> Teeth #
</span>

<form name="selfrm" action="<?=$_SERVER['PHP_SELF']?>?tx=<?=$_GET['tx'];?>" method="post">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr>
		<td valign="top" colspan="2" width="50%" >
        	
            <table width="80%" cellpadding="3" cellspacing="1" border="0">
            	<tr class="tr_bg_h">
                	<td valign="top" class="col_head" colspan="2" class="col_head">
                    	Permanent Teeth
                    </td>
                </tr>
                <? 
				$j=17;
				for($i=1;$i<17;$i++)
				{
					if($i<10)
						$i = '0'.$i;
				?>
                    <tr>	
                        <td valign="top" width="50%">
                        	<input type="checkbox" name="per_teeth[]" value="<?=$i?>" <? if(strpos($_GET['fval'],$i) === false) {} else { echo " checked";}?> />
                            <?=$i;?>
                        </td>
                        <td valign="top" width="50%">
                        	<input type="checkbox" name="per_teeth[]" value="<?=$j?>" <? if(strpos($_GET['fval'],$j) === false) {} else { echo " checked";}?> />
                            <?=$j;?>
                        </td>
                    </tr>
                <? 
					$j++;
				}?>
            </table>
            
            
		</td>
		<td valign="top" colspan="2" width="50%">
			
             <table width="80%" cellpadding="3" cellspacing="1" border="0">
            	<tr class="tr_bg_h">
                	<td valign="top" class="col_head" colspan="2" class="col_head">
                    	Primary Teeth
                    </td>
                </tr>
                <? 
				$j="K";
				for($i='A';$i<'K';$i++)
				{
				?>
                    <tr bgcolor="#FFFFFF">	
                        <td valign="top" width="50%">
                        	<input type="checkbox" name="pri_teeth[]" value="<?=$i?>" <? if(strpos($_GET['fval'],$i) === false) {} else { echo " checked";}?> />
                            <?=$i;?>
                        </td>
                        <td valign="top" width="50%">
                        	<input type="checkbox" name="pri_teeth[]" value="<?=$j?>"  <? if(strpos($_GET['fval'],$j) === false) {} else { echo " checked";}?> />
                            <?=$j;?>
                        </td>
                    </tr>
                <? 
					$j++;
				}?>
            </table>
            <input type="hidden" name="selsub" value="1" />
            <input type="submit" value="Insert" />
		</td>
	</tr>
</table>
</form>
<script type="text/javascript">
	function fill_up(fa)
	{
		parent.document.q_recipientsfrm.<?=$_GET['tx']?>.value = fa;
		parent.disablePopup1();
	}
</script>

<br /><br />	

			</td>
		</tr>
	</table>
    

</body>
</html>
