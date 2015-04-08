<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");

if($_POST["intensitysub"] == 1)
{
	$sel_check = "select * from spine_intensity where intensity = '".s_for($_POST["intensity"])."' and intensityid <> '".s_for($_POST['ed'])."'";
	$query_check=mysqli_query($con, $sel_check);
	
	if(mysqli_num_rows($query_check)>0)
	{
		$msg="Intensity already exist. So please give another Intensity.";
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
			$ed_sql = "update spine_intensity set intensity = '".s_for($_POST["intensity"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."' where intensityid='".$_POST["ed"]."'";
			mysqli_query($con, $ed_sql) or die($ed_sql." | ".mysqli_error($con));
			
			//echo $ed_sql.mysqli_error($con);
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_intensity.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into spine_intensity set intensity = '".s_for($_POST["intensity"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysqli_query($con, $ins_sql) or die($ins_sql.mysqli_error($con));
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_intensity.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
	}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <br />
    <?
    $thesql = "select * from spine_intensity where intensityid='".$_REQUEST["ed"]."'";
	$themy = mysqli_query($con, $thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if($msg != '')
	{
		$intensity = $_POST['intensity'];
		$sortby = $_POST['sortby'];
		$status = $_POST['status'];
		$description = $_POST['description'];
	}
	else
	{
		$intensity = st($themyarray['intensity']);
		$sortby = st($themyarray['sortby']);
		$status = st($themyarray['status']);
		$description = st($themyarray['description']);
		$but_text = "Add ";
	}
	
	if($themyarray["intensityid"] != '')
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
    <form name="intensityfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return intensityabc(this)">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Intensity 
               <? if($intensity <> "") {?>
               		&quot;<?=$intensity;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Intensity
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="intensity" value="<?=$intensity?>" class="form-control" /> 
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
                <input type="hidden" name="intensitysub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["intensityid"]?>" />
                <input type="submit" value="<?=$but_text?> Intensity" class="btn btn-primary">
            </td>
        </tr>
    </table>
    </form>
</body>
</html>