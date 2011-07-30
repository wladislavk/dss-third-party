<? 
include "admin/includes/config.php";

if($_POST['selsub'] == 1)
{
	?>
	<script type="text/javascript">
		parent.document.<?=$_GET['fr'];?>.<?=$_GET['tx'];?>.value = '<?=addslashes($_POST['description']);?>';
		parent.disablePopup1();
		//alert("Hello");
		//window.opener.location = '#add_para';
	</script>
	<?
	die();
}

$sql = "select * from dental_custom where docid='".$_SESSION['docid']."' order by Title";
$my = mysql_query($sql);
$total_rec = mysql_num_rows($my);
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
	Select Custom Text
</span>
<br />&nbsp;

<script type="text/javascript">
	function change_desc(fa)
	{
		if(fa != '')
		{
			var title_arr = new Array();
			var desc_arr = new Array();
			
			<? $i=0;
                        //$sql = "select * from dental_custom where docid='".$_SESSION['docid']."' order by Title";
                        //$my = mysql_query($sql);
			while($myarray = mysql_fetch_array($my))
			{?>
				title_arr[<?=$i;?>] = "<?=st(addslashes($myarray['title']));?>";
				desc_arr[<?=$i;?>] = "<?=st(trim( preg_replace( '/\n\r|\r\n/',' ',addslashes($myarray['description']))));?>";
			<? 
				$i++;
			}?>
			document.getElementById("description").value = desc_arr[fa];
		}
		else
		{
			document.getElementById("description").value = "";
		}
	}
	
</script>

<form name="selfrm" action="<?=$_SERVER['PHP_SELF']?>?fr=<?=$_GET['fr'];?>&tx=<?=$_GET['tx'];?>" method="post" onSubmit="return selabc(this)">
<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" >
			Title: 
            <select name="title" class="tbox" onChange="change_desc(this.value)">
            	<option value="">Select</option>
                <? 
				$j=0;
				$my = mysql_query($sql);
				while($myarray = mysql_fetch_array($my))
				{?>
					<option value="<?=$j;?>">
                    	<?=st($myarray['title']);?>
                    </option>
				<? 
					$j++;
				}?>
            </select>
		</td>
	</tr>
    <tr class="tr_bg_h">
		<td valign="top" class="col_data" >
        	<textarea name="description" id="description" class="tbox" style="width:98%; height:150px;"></textarea>
		</td>
	</tr>
    <tr class="tr_bg_h">
		<td valign="top" class="col_head" >
        	<input type="hidden" name="selsub" value="1" />
        	<input type="submit" name="selbtn" value="Insert into Form" />
		</td>
	</tr>
</table>
</form>

<br /><br />	

			</td>
		</tr>
	</table>
    

</body>
</html>
