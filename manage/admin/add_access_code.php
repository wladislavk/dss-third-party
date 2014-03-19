<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");

if(isset($_POST['accesscodedelete'])){
  $sql = "DELETE FROM dental_access_codes WHERE id='".mysql_real_escape_string($_POST['ed'])."'";
  mysql_query($sql);
                        ?>
                        <script type="text/javascript">
                                //alert("<?=$msg;?>");
                                parent.window.location='manage_access_codes.php?msg=<?=$msg;?>';
                        </script>
                        <?
                        die();
}

if(isset($_POST["accesscodesub"]))
{
	$sel_check = "select * from dental_access_codes where access_code = '".s_for($_POST["access_code"])."' and id <> '".s_for($_POST['ed'])."'";
	$query_check=mysql_query($sel_check);
	
	if(mysql_num_rows($query_check)>0)
	{
		$msg="Access code already exist. So please give another access code.";
		?>
		<script type="text/javascript">
			alert("<?=$msg;?>");
			window.location="#add";
		</script>
		<?
	} 
	else
	{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_access_codes set 
				access_code = '".mysql_real_escape_string($_POST['access_code'])."',
				notes = '".mysql_real_escape_string($_POST['notes'])."',
				status = '".mysql_real_escape_string($_POST['status'])."',
				plan_id = '".mysql_real_escape_string($_POST['plan_id'])."'
				where id='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_access_codes.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
                        $ins_sql = "INSERT INTO dental_access_codes set 
                                access_code = '".mysql_real_escape_string($_POST['access_code'])."',
                                notes = '".mysql_real_escape_string($_POST['notes'])."',
				plan_id = '".mysql_real_escape_string($_POST['plan_id'])."',
                                status = '".mysql_real_escape_string($_POST['status'])."'";

			mysql_query($ins_sql) or die($ins_sql.mysql_error());
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_access_codes.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
	}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_access_codes where id='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
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
	
	<? if($msg != '') {?>
    <div class="alert alert-danger text-center">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="contacttypefrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return accesscodeabc(this)">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Access Code
               <? if($access_code <> "") {?>
               		&quot;<?=$access_code;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Access Code
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="access_code" value="<?=$access_code;?>" class="form-control" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Notes
            </td>
            <td valign="top" class="frmdata">
		<textarea name="notes"><?= $notes; ?></textarea>
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
                          $p_q = mysql_query($p_sql);
                          while($p_r = mysql_fetch_assoc($p_q)){ ?>
                            <option value="<?= $p_r['id']; ?>" <?= ($p_r['id'] == $plan_id)?'selected="selected"':''; ?>><?= $p_r['name']; ?></option>
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
			<option value="1" <?= ($status==1)?'selected="selected"':''; ?>>Active</option>
                        <option value="2" <?= ($status==2)?'selected="selected"':''; ?>>In-Active</option>
            </td>
        </tr>

        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="ed" value="<?=$themyarray["id"]?>" />
                <input type="submit" name="accesscodesub" value=" <?=$but_text?> Access Code" class="btn btn-primary" />
		<?php		
		if($themyarray['id']!=''){  
		$c_sql = "SELECT * FROM dental_users WHERE access_code_id='".$themyarray["id"]."'";
		$c_q = mysql_query($c_sql);
		if(mysql_num_rows($c_q)==0){ ?>
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
