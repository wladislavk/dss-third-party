<?php 
session_start();
require_once('includes/config.php');
include("includes/sescheck.php");

if($_POST["mult_transaction_codesub"] == 1)
{
	$op_arr = split("\n",trim($_POST['transaction_code']));
				
	foreach($op_arr as $i=>$val)
	{
		if($val <> '')
		{
			$sel_check = "select * from dental_transaction_code where transaction_code = '".s_for($val)."'";
			$query_check=mysql_query($sel_check);
			
			if(mysql_num_rows($query_check) == 0)
			{
				$ins_sql = "insert into dental_transaction_code set transaction_code = '".s_for($val)."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
				mysql_query($ins_sql) or die($ins_sql.mysql_error());
			}
			
		}
	}
	
	$msg = "Added Successfully";
	?>
	<script type="text/javascript">
		//alert("<?=$msg;?>");
		parent.window.location='manage_transaction_code.php?msg=<?=$msg;?>';
	</script>
	<?
	die();
}

if($_POST["transaction_codesub"] == 1)
{
	$sel_check = "select * from dental_transaction_code where default_code=1 transaction_code = '".s_for($_POST["transaction_code"])."' and transaction_codeid <> '".s_for($_POST['ed'])."'";
	$query_check=mysql_query($sel_check);
	
	if(mysql_num_rows($query_check)>0)
	{
		$msg="Transaction Code already exist. So please give another Transaction Code.";
		?>
		<script type="text/javascript">
			alert("<?=$msg;?>");
			window.location="#add";
		</script>
		<?
	} 
	else
	{
		if(s_for($_POST["sortby"]) == '' || is_numeric(s_for($_POST["sortby"])) === false)
		{
			$sby = 999;
		}
		else
		{
			$sby = s_for($_POST["sortby"]);
		}
		
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_transaction_code set transaction_code = '".s_for($_POST["transaction_code"])."', place= '".s_for($_POST['place'])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."', type = '".s_for($_POST["type"])."' where transaction_codeid='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_transaction_code.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into dental_transaction_code set transaction_code = '".s_for($_POST["transaction_code"])."', place='".s_for($_POST['place'])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."', type = '".s_for($_POST["type"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."', default_code = 1";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_transaction_code.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
</head>
<body>

    <?
    $thesql = "select * from dental_transaction_code where transaction_codeid='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$transaction_code = $_POST['transaction_code'];
    $type = $_POST['type'];		
		$place = $_POST['place'];
		$sortby = $_POST['sortby'];
		$status = $_POST['status'];
		$description = $_POST['description'];
	}
	else
	{
		$transaction_code = st($themyarray['transaction_code']);
		$type = st($themyarray['type']);
		$place = st($themyarray['place']);
		$sortby = st($themyarray['sortby']);
		$status = st($themyarray['status']);
		$description = st($themyarray['description']);
		$but_text = "Add ";
	}
	
	if($themyarray["transaction_codeid"] != '')
	{
		$but_text = "Edit ";
	}
	else
	{
		$but_text = "Add ";
	}
	?>
	
	<br /><br />
	
	<? if($msg != '') {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="transaction_codefrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return transaction_codeabc(this)">
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Transaction Code 
               <? if($transaction_code <> "") {?>
               		&quot;<?=$transaction_code;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Transaction Code
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="transaction_code" value="<?=$transaction_code?>" class="tbox" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Transaction Type
            </td>
            <td valign="top" class="frmdata">
                <select name="type" class="tbox" />
                  <option value="1" <?php if($type == "1"){echo " selected='selected'";} ?>> Medical Code </option>
                  <option value="2" <?php if($type == "2"){echo " selected='selected'";} ?>> Patient Payment Code </option>
                  <option value="3" <?php if($type == "3"){echo " selected='selected'";} ?>> Insurance Payment Code </option>
                  <option value="4" <?php if($type == "4"){echo " selected='selected'";} ?>> Diagnostic Code </option>
                  <option value="5" <?php if($type == "5"){echo " selected='selected'";} ?>> Modifier Code </option>
                  <option value="6" <?php if($type == "6"){echo " selected='selected'";} ?>> Adjustment Code </option>              
                </select> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
               Place 
            </td>
            <td valign="top" class="frmdata">
                <select name="place" class="tbox" />
		  <option value=""></option>
		  <?php 
			$psql = "select * from dental_place_service order by sortby";
			$pmy = mysql_query($psql);
			while($prow = mysql_fetch_assoc($pmy)){
		  ?>
                  <option value="<?= $prow['place_serviceid']; ?>" <?php if($place == $prow['place_serviceid']){echo " selected='selected'";} ?>><?= $prow['place_service']." ".$prow['description']; ?></option>
		  <?php } ?>
                </select>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Sort By
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="sortby" value="<?=$sortby;?>" class="tbox" style="width:30px"/>		
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="tbox">
                	<option value="1" <? if($status == 1) echo " selected";?>>Active</option>
                	<option value="2" <? if($status == 2) echo " selected";?>>In-Active</option>
                </select>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Description
            </td>
            <td valign="top" class="frmdata">
            	<textarea class="tbox" name="description" style="width:100%;"><?=$description;?></textarea>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="transaction_codesub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["transaction_codeid"]?>" />
                <input type="submit" value=" <?=$but_text?> Transaction Code" class="button" />
		<?php if($themyarray["transaction_codeid"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_transaction_code.php?delid=<?=$themyarray["transaction_codeid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel dellink" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>

            </td>
        </tr>
    </table>
    </form>
  
</body>
</html>
