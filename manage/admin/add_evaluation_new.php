<?php 

include_once('includes/main_include.php');
include("includes/sescheck.php");

if(!empty($_POST["mult_evaluation_newsub"]) && $_POST["mult_evaluation_newsub"] == 1)
{
	$op_arr = explode("\n",trim($_POST['evaluation_new']));
				
	foreach($op_arr as $i=>$val)
	{
		if($val <> '')
		{
			$sel_check = "select * from dental_evaluation_new where evaluation_new = '".s_for($val)."'";
			$query_check=mysqli_query($con,$sel_check);
			
			if(mysqli_num_rows($query_check) == 0)
			{
				$ins_sql = "insert into dental_evaluation_new set evaluation_new = '".s_for($val)."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
				mysqli_query($con,$ins_sql);
			}
			
		}
	}
	
	$msg = "Added Successfully";
	?>
	<script type="text/javascript">
		//alert("<?php echo $msg;?>");
		parent.window.location='manage_evaluation_new.php?msg=<?php echo $msg;?>';
	</script>
	<?
	die();
}

if(!empty($_POST["evaluation_newsub"]) && $_POST["evaluation_newsub"] == 1)
{
	$sel_check = "select * from dental_evaluation_new where evaluation_new = '".s_for($_POST["evaluation_new"])."' and evaluation_newid <> '".s_for($_POST['ed'])."'";
	$query_check=mysqli_query($con,$sel_check);
	
	if(mysqli_num_rows($query_check)>0)
	{
		$msg="Evaluation Newalready exist. So please give another Assessment Addition.";
		?>
		<script type="text/javascript">
			alert("<?php echo $msg;?>");
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
			$ed_sql = "update dental_evaluation_new set evaluation_new = '".s_for($_POST["evaluation_new"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."' where evaluation_newid='".$_POST["ed"]."'";
			mysqli_query($con,$ed_sql);

			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_evaluation_new.php?msg=<?php echo $msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into dental_evaluation_new set evaluation_new = '".s_for($_POST["evaluation_new"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysqli_query($con,$ins_sql);
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_evaluation_new.php?msg=<?php echo $msg;?>';
			</script>
			<?
			die();
		}
	}
}

?>

<?php include_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_evaluation_new where evaluation_newid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
	$themy = mysqli_query($con,$thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if(!empty($msg))
	{
		$evaluation_new = $_POST['evaluation_new'];
		$sortby = $_POST['sortby'];
		$status = $_POST['status'];
		$description = $_POST['description'];
	}
	else
	{
		$evaluation_new = st($themyarray['evaluation_new']);
		$sortby = st($themyarray['sortby']);
		$status = st($themyarray['status']);
		$description = st($themyarray['description']);
		$but_text = "Add ";
	}
	
	if($themyarray["evaluation_newid"] != '')
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
    <form name="evaluation_newfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return evaluation_newabc(this)">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?php echo $but_text?> Evaluation New
               <?php if($evaluation_new <> "") {?>
               		&quot;<?php echo $evaluation_new;?>&quot;
               <?php }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Assessment Addition
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="evaluation_new" value="<?php echo $evaluation_new?>" class="form-control" /> 
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
                <input type="hidden" name="evaluation_newsub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $themyarray["evaluation_newid"]?>" />
                <input type="submit" value="<?php echo $but_text?> Assessment Addition" class="btn btn-primary">
		<?php if($themyarray["evaluation_newid"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_evaluation_new.php?delid=<?php echo $themyarray["evaluation_newid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel btn btn-danger pull-right" title="DELETE">
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
		<form name="evaluation_newfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return evaluation_newabc(this)">
        <table class="table table-bordered table-hover">
            <tr>
                <td colspan="2" class="cat_head">
                   Add Multiple Evaluation New
                   <span class="red">
	                   (Type Each New Evaluation Newon New Line)
                   </span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmdata">
                    <textarea class="form-control" name="evaluation_new" style="width:100%; height:150px;"></textarea>
                </td>
            </tr>
            <tr>
                <td  colspan="2" align="center">
                    <span class="red">
                        * Required Fields					
                    </span><br />
                    <input type="hidden" name="mult_evaluation_newsub" value="1" />
                    <input type="submit" value="Add Multiple Assessment Addition" class="btn btn-primary">
                </td>
            </tr>
        </table>
        </form>
    
    <?php }?>
</body>
</html>
