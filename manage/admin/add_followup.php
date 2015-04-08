<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");

if($_POST["mult_followupsub"] == 1)
{
	$op_arr = split("\n",trim($_POST['followup']));
				
	foreach($op_arr as $i=>$val)
	{
		if($val <> '')
		{
			$sel_check = "select * from dental_followup where followup = '".s_for($val)."'";
			$query_check=mysqli_query($con, $sel_check);
			
			if(mysqli_num_rows($query_check) == 0)
			{
				$ins_sql = "insert into dental_followup set followup = '".s_for($val)."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
				mysqli_query($con, $ins_sql) or die($ins_sql.mysqli_error($con));
			}
			
		}
	}
	
	$msg = "Added Successfully";
	?>
	<script type="text/javascript">
		//alert("<?=$msg;?>");
		parent.window.location='manage_followup.php?msg=<?=$msg;?>';
	</script>
	<?
	die();
}

if($_POST["followupsub"] == 1)
{
	$sel_check = "select * from dental_followup where followup = '".s_for($_POST["followup"])."' and followupid <> '".s_for($_POST['ed'])."'";
	$query_check=mysqli_query($con, $sel_check);
	
	if(mysqli_num_rows($query_check)>0)
	{
		$msg="Follow Up already exist. So please give another Follow Up.";
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
			$ed_sql = "update dental_followup set followup = '".s_for($_POST["followup"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."' where followupid='".$_POST["ed"]."'";
			mysqli_query($con, $ed_sql) or die($ed_sql." | ".mysqli_error($con));
			
			//echo $ed_sql.mysqli_error($con);
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_followup.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into dental_followup set followup = '".s_for($_POST["followup"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysqli_query($con, $ins_sql) or die($ins_sql.mysqli_error($con));
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_followup.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
	}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_followup where followupid='".$_REQUEST["ed"]."'";
	$themy = mysqli_query($con, $thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if($msg != '')
	{
		$followup = $_POST['followup'];
		$sortby = $_POST['sortby'];
		$status = $_POST['status'];
		$description = $_POST['description'];
	}
	else
	{
		$followup = st($themyarray['followup']);
		$sortby = st($themyarray['sortby']);
		$status = st($themyarray['status']);
		$description = st($themyarray['description']);
		$but_text = "Add ";
	}
	
	if($themyarray["followupid"] != '')
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
    <form name="followupfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return followupabc(this)">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Follow Up 
               <? if($followup <> "") {?>
               		&quot;<?=$followup;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Follow Up
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="followup" value="<?=$followup?>" class="form-control" /> 
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
                <input type="hidden" name="followupsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["followupid"]?>" />
                <input type="submit" value="<?=$but_text?> Follow Up" class="btn btn-primary">
		<?php if($themyarray["followupid"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_followup.php?delid=<?=$themyarray["followupid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent"class="editdel btn btn-danger pull-right" title="DELETE">
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
		<form name="followupfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return followupabc(this)">
        <table class="table table-bordered table-hover">
            <tr>
                <td colspan="2" class="cat_head">
                   Add Multiple Follow Up 
                   <span class="red">
	                   (Type Each New Follow Up on New Line)
                   </span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmdata">
                    <textarea class="form-control" name="followup" style="width:100%; height:150px;"></textarea>
                </td>
            </tr>
            <tr>
                <td  colspan="2" align="center">
                    <span class="red">
                        * Required Fields					
                    </span><br />
                    <input type="hidden" name="mult_followupsub" value="1" />
                    <input type="submit" value="Add Multiple Follow Up" class="btn btn-primary">
                </td>
            </tr>
        </table>
        </form>
    
    <? }?>
</body>
</html>
