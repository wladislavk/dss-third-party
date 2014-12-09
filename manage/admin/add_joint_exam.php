<?php 

include_once('includes/main_include.php');
include("includes/sescheck.php");

if(!empty($_POST["mult_joint_examsub"]) && $_POST["mult_joint_examsub"] == 1)
{
	$op_arr = explode("\n",trim($_POST['joint_exam']));
				
	foreach($op_arr as $i=>$val)
	{
		if($val <> '')
		{
			$sel_check = "select * from dental_joint_exam where joint_exam = '".s_for($val)."'";
			$query_check=mysqli_query($con,$sel_check);
			
			if(mysqli_num_rows($query_check) == 0)
			{
				$ins_sql = "insert into dental_joint_exam set joint_exam = '".s_for($val)."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
				mysqli_query($con,$ins_sql);
			}
			
		}
	}
	
	$msg = "Added Successfully";
	?>
	<script type="text/javascript">
		//alert("<?=$msg;?>");
		parent.window.location='manage_joint_exam.php?msg=<?=$msg;?>';
	</script>
	<?
	die();
}

if(!empty($_POST["joint_examsub"]) && $_POST["joint_examsub"] == 1)
{
	$sel_check = "select * from dental_joint_exam where joint_exam = '".s_for($_POST["joint_exam"])."' and joint_examid <> '".s_for($_POST['ed'])."'";
	$query_check=mysqli_query($con,$sel_check);
	
	if(mysqli_num_rows($query_check)>0)
	{
		$msg="Joint Examination already exist. So please give another Joint Examination.";
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
			$ed_sql = "update dental_joint_exam set joint_exam = '".s_for($_POST["joint_exam"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."' where joint_examid='".$_POST["ed"]."'";
			mysqli_query($con,$ed_sql);

			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_joint_exam.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into dental_joint_exam set joint_exam = '".s_for($_POST["joint_exam"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysqli_query($con,$ins_sql);
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_joint_exam.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
	}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_joint_exam where joint_examid='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
	$themy = mysqli_query($con,$thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if(!empty($msg))
	{
		$joint_exam = $_POST['joint_exam'];
		$sortby = $_POST['sortby'];
		$status = $_POST['status'];
		$description = $_POST['description'];
	}
	else
	{
		$joint_exam = st($themyarray['joint_exam']);
		$sortby = st($themyarray['sortby']);
		$status = st($themyarray['status']);
		$description = st($themyarray['description']);
		$but_text = "Add ";
	}
	
	if($themyarray["joint_examid"] != '')
	{
		$but_text = "Edit ";
	}
	else
	{
		$but_text = "Add ";
	}
	?>
	
	<br /><br />
	
	<? if(!empty($msg)) {?>
    <div class="alert alert-danger text-center">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="joint_examfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return joint_examabc(this)">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Joint Examination 
               <? if($joint_exam <> "") {?>
               		&quot;<?=$joint_exam;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Joint Examination
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="joint_exam" value="<?=$joint_exam?>" class="form-control" /> 
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
                <input type="hidden" name="joint_examsub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["joint_examid"]?>" />
                <input type="submit" value="<?=$but_text?> Joint Examination" class="btn btn-primary">
		<?php if($themyarray["joint_examid"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_joint_exam.php?delid=<?=$themyarray["joint_examid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel btn btn-danger pull-right" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
    
    <? if(empty($_GET['ed']))
	{?>
    	<div class="alert alert-danger text-center">
    		<b>--------------------------------- OR ---------------------------------</b>
        </div>
		<form name="joint_examfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return joint_examabc(this)">
        <table class="table table-bordered table-hover">
            <tr>
                <td colspan="2" class="cat_head">
                   Add Multiple Joint Examination 
                   <span class="red">
	                   (Type Each New Joint Examination on New Line)
                   </span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmdata">
                    <textarea class="form-control" name="joint_exam" style="width:100%; height:150px;"></textarea>
                </td>
            </tr>
            <tr>
                <td  colspan="2" align="center">
                    <span class="red">
                        * Required Fields					
                    </span><br />
                    <input type="hidden" name="mult_joint_examsub" value="1" />
                    <input type="submit" value="Add Multiple Joint Examination" class="btn btn-primary">
                </td>
            </tr>
        </table>
        </form>
    
    <? }?>
</body>
</html>
