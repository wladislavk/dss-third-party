<?php 

include_once('includes/main_include.php');
include("includes/sescheck.php");

if(isset($_POST['accesscodedelete'])){
  $sql = "DELETE FROM dental_access_codes WHERE id='".mysqli_real_escape_string($con,$_POST['ed'])."'";
  mysqli_query($con,$sql);
                        ?>
                        <script type="text/javascript">
                                //alert("<?php echo $msg;?>");
                                parent.window.location='manage_access_codes.php?msg=<?php echo $msg;?>';
                        </script>
                        <?
                        die();
}

if(isset($_POST["accesscodesub"]))
{
	$sel_check = "select * from dental_access_codes where access_code = '".s_for($_POST["access_code"])."' and id <> '".s_for($_POST['ed'])."'";
	$query_check=mysqli_query($con,$sel_check);
	
	if(mysqli_num_rows( $query_check)>0)
	{
		$msg="Access code already exist. So please give another access code.";
		?>
		<script type="text/javascript">
			alert("<?php echo $msg;?>");
			window.location="#add";
		</script>
		<?
	} 
	else
	{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_access_codes set 
				access_code = '".mysqli_real_escape_string($con,$_POST['access_code'])."',
				notes = '".mysqli_real_escape_string($con,$_POST['notes'])."',
				status = '".mysqli_real_escape_string($con,$_POST['status'])."',
				plan_id = '".mysqli_real_escape_string($con,$_POST['plan_id'])."'
				where id='".$_POST["ed"]."'";
			mysqli_query($con,$ed_sql);
			
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_access_codes.php?msg=<?php echo $msg;?>';
			</script>
			<?
			die();
		}
		else
		{
                        $ins_sql = "INSERT INTO dental_access_codes set 
                                access_code = '".mysqli_real_escape_string($con,$_POST['access_code'])."',
                                notes = '".mysqli_real_escape_string($con,$_POST['notes'])."',
				plan_id = '".mysqli_real_escape_string($con,$_POST['plan_id'])."',
                                status = '".mysqli_real_escape_string($con,$_POST['status'])."'";

			mysqli_query($con,$ins_sql);
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_access_codes.php?msg=<?php echo $msg;?>';
			</script>
			<?
			die();
		}
	}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_access_codes where id='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
	$themy = mysqli_query($con,$thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if(!empty($msg))
	{
		$access_code = $_POST['access_code'];
		$notes = $_POST['notes'];
		$plan_id = $_POST['plan_id'];
		$status = $_POST['status'];
	}
	else
	{
		$access_code = $themyarray['access_code'];
		$notes = $themyarray['notes'];
		$plan_id = $themyarray['plan_id'];
		$status = $themyarray['status'];
		$but_text = "Add ";
	}
	
	if($themyarray["id"] != '')
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
    <form name="contacttypefrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return accesscodeabc(this)">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?php echo $but_text?> Access Code
               <?php if($access_code <> "") {?>
               		&quot;<?php echo $access_code;?>&quot;
               <?php }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Access Code
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="access_code" value="<?php echo $access_code;?>" class="form-control" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Notes
            </td>
            <td valign="top" class="frmdata">
		<textarea name="notes"><?php echo  $notes; ?></textarea>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                 Plan
            </td>
            <td valign="top" class="frmdata">
                <select name="plan_id" class="form-control">
                        <?php
                          $p_sql = "SELECT * FROM dental_plans ORDER BY name ASC";
                          $p_q = mysqli_query($con,$p_sql);
                          while($p_r = mysqli_fetch_assoc($p_q)){ ?>
                            <option value="<?php echo  $p_r['id']; ?>" <?php echo  ($p_r['id'] == $plan_id)?'selected="selected"':''; ?>><?php echo  $p_r['name']; ?></option>
                          <?php } ?>
                </select>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
               Status
            </td>
            <td valign="top" class="frmdata">
		<select name="status">
			<option value="1" <?php echo  ($status==1)?'selected="selected"':''; ?>>Active</option>
                        <option value="2" <?php echo  ($status==2)?'selected="selected"':''; ?>>In-Active</option>
            </td>
        </tr>

        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="ed" value="<?php echo $themyarray["id"]?>" />
                <input type="submit" name="accesscodesub" value=" <?php echo $but_text?> Access Code" class="btn btn-primary" />
		<?php		
		if($themyarray['id']!=''){  
		$c_sql = "SELECT * FROM dental_users WHERE access_code_id='".$themyarray["id"]."'";
		$c_q = mysqli_query($con,$c_sql);
		if(mysqli_num_rows( $c_q)==0){ ?>
		<input type="submit" name="accesscodedelete" value="Delete" class="btn btn-danger" />
		<?php }else{ ?>
		<input type="submit" onclick="alert('Error! There are users associated with this access code. You must reassign these users. Only access codes with no users may be deleted.');return false;" value="Delete" class="btn btn-danger">
		<?php } 
		}
		?>
            </td>
        </tr>
    </table>
    </form>
    
</body>
</html>
