<?php namespace Ds3\Libraries\Legacy; ?><?php 

include_once('includes/main_include.php');
include("includes/sescheck.php");

if(!empty($_POST["mult_maxillasub"]) && $_POST["mult_maxillasub"] == 1)
{
	$op_arr = explode("\n",trim($_POST['maxilla']));
				
	foreach($op_arr as $i=>$val)
	{
		if($val != '')
		{
			$sel_check = "select * from dental_maxilla where maxilla = '".s_for($val)."'";
			$query_check=mysqli_query($con,$sel_check);
			
			if(mysqli_num_rows($query_check) == 0)
			{
				$ins_sql = "insert into dental_maxilla set maxilla = '".s_for($val)."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
				mysqli_query($con,$ins_sql);
			}
			
		}
	}
	
	$msg = "Added Successfully";
	?>
	<script type="text/javascript">
		parent.window.location='manage_maxilla.php?msg=<?php echo $msg;?>';
	</script>
	<?php
	trigger_error("Die called", E_USER_ERROR);
}

if(!empty($_POST["maxillasub"]) && $_POST["maxillasub"] == 1)
{
	$sel_check = "select * from dental_maxilla where maxilla = '".s_for($_POST["maxilla"])."' and maxillaid != '".s_for($_POST['ed'])."'";
	$query_check=mysqli_query($con,$sel_check);
	
	if(mysqli_num_rows($query_check)>0)
	{
		$msg="Maxilla already exist. So please give another Maxilla.";
		?>
		<script type="text/javascript">
			alert("<?php echo $msg;?>");
			window.location="#add";
		</script>
		<?php
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
			$ed_sql = "update dental_maxilla set maxilla = '".s_for($_POST["maxilla"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."' where maxillaid='".$_POST["ed"]."'";
			mysqli_query($con,$ed_sql);

			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_maxilla.php?msg=<?php echo $msg;?>';
			</script>
			<?php
			trigger_error("Die called", E_USER_ERROR);
		}
		else
		{
			$ins_sql = "insert into dental_maxilla set maxilla = '".s_for($_POST["maxilla"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysqli_query($con,$ins_sql);
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				parent.window.location='manage_maxilla.php?msg=<?php echo $msg;?>';
			</script>
			<?php
			trigger_error("Die called", E_USER_ERROR);
		}
	}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?php
    $thesql = "select * from dental_maxilla where maxillaid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
	$themy = mysqli_query($con,$thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if(!empty($msg))
	{
		$maxilla = $_POST['maxilla'];
		$sortby = $_POST['sortby'];
		$status = $_POST['status'];
		$description = $_POST['description'];
	}
	else
	{
		$maxilla = st($themyarray['maxilla']);
		$sortby = st($themyarray['sortby']);
		$status = st($themyarray['status']);
		$description = st($themyarray['description']);
		$but_text = "Add ";
	}
	
	if($themyarray["maxillaid"] != '')
	{
		$but_text = "Edit ";
	}
	else
	{
		$but_text = "Add ";
	}
	?>
	
	<br /><br />
	
	<?php if(!empty($msg)) {?>
    <div class="alert alert-danger text-center">
        <?php echo $msg;?>
    </div>
    <?php }?>
    <form name="maxillafrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return maxillaabc(this)">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?php echo $but_text?> Maxilla 
               <?php if($maxilla != "") {?>
               		&quot;<?php echo $maxilla;?>&quot;
               <?php }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Maxilla
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="maxilla" value="<?php echo $maxilla?>" class="form-control" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Sort By
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="sortby" value="<?php echo $sortby;?>" class="form-control" style="width:30px"/>		
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="form-control">
                	<option value="1" <?php if($status == 1) echo " selected";?>>Active</option>
                	<option value="2" <?php if($status == 2) echo " selected";?>>In-Active</option>
                </select>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Description
            </td>
            <td valign="top" class="frmdata">
            	<textarea class="form-control" name="description" style="width:100%;"><?php echo $description;?></textarea>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="maxillasub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $themyarray["maxillaid"]?>" />
                <input type="submit" value="<?php echo $but_text?> Maxilla" class="btn btn-primary">
		<?php if($themyarray["maxillaid"] != ''  && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_maxilla.php?delid=<?php echo $themyarray["maxillaid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel btn btn-danger pull-right" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
    
    <?php if(empty($_GET['ed']))
	{?>
    	<div class="alert alert-danger text-center">
    		<b>--------------------------------- OR ---------------------------------</b>
        </div>
		<form name="maxillafrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return maxillaabc(this)">
        <table class="table table-bordered table-hover">
            <tr>
                <td colspan="2" class="cat_head">
                   Add Multiple Maxilla 
                   <span class="red">
	                   (Type Each New Maxilla on New Line)
                   </span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmdata">
                    <textarea class="form-control" name="maxilla" style="width:100%; height:150px;"></textarea>
                </td>
            </tr>
            <tr>
                <td  colspan="2" align="center">
                    <span class="red">
                        * Required Fields					
                    </span><br />
                    <input type="hidden" name="mult_maxillasub" value="1" />
                    <input type="submit" value="Add Multiple Maxilla" class="btn btn-primary">
                </td>
            </tr>
        </table>
        </form>
    
    <?php }?>
</body>
</html>
