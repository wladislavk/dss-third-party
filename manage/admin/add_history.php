<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");

if($_POST["mult_historysub"] == 1)
{
	$op_arr = split("\n",trim($_POST['history']));
				
	foreach($op_arr as $i=>$val)
	{
		if($val <> '')
		{
			$sel_check = "select * from dental_history where history = '".s_for($val)."'";
			$query_check=mysql_query($sel_check);
			
			if(mysql_num_rows($query_check) == 0)
			{
				$ins_sql = "insert into dental_history set history = '".s_for($val)."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
				mysql_query($ins_sql) or die($ins_sql.mysql_error());
			}
			
		}
	}
	
	$msg = "Added Successfully";
	?>
	<script type="text/javascript">
		//alert("<?=$msg;?>");
		parent.window.location='manage_history.php?msg=<?=$msg;?>';
	</script>
	<?
	die();
}

if($_POST["historysub"] == 1)
{
	$sel_check = "select * from dental_history where history = '".s_for($_POST["history"])."' and historyid <> '".s_for($_POST['ed'])."'";
	$query_check=mysql_query($sel_check);
	
	if(mysql_num_rows($query_check)>0)
	{
		$msg="Medical History already exist. So please give another Medical History.";
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
			$ed_sql = "update dental_history set history = '".s_for($_POST["history"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."' where historyid='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_history.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into dental_history set history = '".s_for($_POST["history"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_history.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
	}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_history where historyid='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$history = $_POST['history'];
		$sortby = $_POST['sortby'];
		$status = $_POST['status'];
		$description = $_POST['description'];
	}
	else
	{
		$history = st($themyarray['history']);
		$sortby = st($themyarray['sortby']);
		$status = st($themyarray['status']);
		$description = st($themyarray['description']);
		$but_text = "Add ";
	}
	
	if($themyarray["historyid"] != '')
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
    <div class="alert alert-danger text-center">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="historyfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return historyabc(this)">
    <table class="table table-bordered">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Medical History 
               <? if($history <> "") {?>
               		&quot;<?=$history;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Medical History
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="history" value="<?=$history?>" class="form-control" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Sort By
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="sortby" value="<?=$sortby;?>" class="form-control" style="width:30px"/>		
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="form-control">
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
            	<textarea class="form-control" name="description" style="width:100%;"><?=$description;?></textarea>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="historysub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["historyid"]?>" />
                <input type="submit" value="<?=$but_text?> Medical History" class="btn btn-primary">
		<?php if($themyarray["historyid"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_history.php?delid=<?=$themyarray["historyid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel dellink" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
    
    <? if($_GET['ed'] == '')
	{?>
    	<div class="alert alert-danger text-center">
    		<b>--------------------------------- OR ---------------------------------</b>
        </div>
		<form name="historyfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return historyabc(this)">
        <table class="table table-bordered">
            <tr>
                <td colspan="2" class="cat_head">
                   Add Multiple Medical History 
                   <span class="red">
	                   (Type Each New Medical History on New Line)
                   </span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmdata">
                    <textarea class="form-control" name="history" style="width:100%; height:150px;"></textarea>
                </td>
            </tr>
            <tr>
                <td  colspan="2" align="center">
                    <span class="red">
                        * Required Fields					
                    </span><br />
                    <input type="hidden" name="mult_historysub" value="1" />
                    <input type="submit" value="Add Multiple Medical History" class="btn btn-primary">
                </td>
            </tr>
        </table>
        </form>
    
    <? }?>
</body>
</html>
