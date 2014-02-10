<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");

if($_POST["mult_imagetypesub"] == 1)
{
	$op_arr = split("\n",trim($_POST['imagetype']));
				
	foreach($op_arr as $i=>$val)
	{
		if($val <> '')
		{
			$sel_check = "select * from dental_imagetype where imagetype = '".s_for($val)."'";
			$query_check=mysql_query($sel_check);
			
			if(mysql_num_rows($query_check) == 0)
			{
				$ins_sql = "insert into dental_imagetype set imagetype = '".s_for($val)."', adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
				mysql_query($ins_sql) or die($ins_sql.mysql_error());
			}
			
		}
	}
	
	$msg = "Added Successfully";
	?>
	<script type="text/javascript">
		//alert("<?=$msg;?>");
		parent.window.location='manage_imagetype.php?msg=<?=$msg;?>';
	</script>
	<?
	die();
}

if($_POST["imagetypesub"] == 1)
{
	$sel_check = "select * from dental_imagetype where imagetype = '".s_for($_POST["imagetype"])."' and imagetypeid <> '".s_for($_POST['ed'])."'";
	$query_check=mysql_query($sel_check);
	
	if(mysql_num_rows($query_check)>0)
	{
		$msg="Image Type already exist. So please give another Image Type.";
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
			$ed_sql = "update dental_imagetype set imagetype = '".s_for($_POST["imagetype"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."' where imagetypeid='".$_POST["ed"]."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_imagetype.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into dental_imagetype set imagetype = '".s_for($_POST["imagetype"])."', sortby = '".s_for($sby)."', status = '".s_for($_POST["status"])."', description = '".s_for($_POST["description"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_imagetype.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
	}
}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

    <?
    $thesql = "select * from dental_imagetype where imagetypeid='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$imagetype = $_POST['imagetype'];
		$sortby = $_POST['sortby'];
		$status = $_POST['status'];
		$description = $_POST['description'];
	}
	else
	{
		$imagetype = st($themyarray['imagetype']);
		$sortby = st($themyarray['sortby']);
		$status = st($themyarray['status']);
		$description = st($themyarray['description']);
		$but_text = "Add ";
	}
	
	if($themyarray["imagetypeid"] != '')
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
    <form name="imagetypefrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return imagetypeabc(this)">
    <table class="table table-bordered">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Image Type 
               <? if($imagetype <> "") {?>
               		&quot;<?=$imagetype;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Image Type
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="imagetype" value="<?=$imagetype?>" class="form-control" /> 
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
                <input type="hidden" name="imagetypesub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["imagetypeid"]?>" />
                <input type="submit" value="<?=$but_text?> Image Type" class="btn btn-primary">
		<?php if($themyarray["imagetypeid"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_imagetype.php?delid=<?=$themyarray["imagetypeid"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel dellink" title="DELETE">
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
		<form name="imagetypefrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onSubmit="return imagetypeabc(this)">
        <table class="table table-bordered">
            <tr>
                <td colspan="2" class="cat_head">
                   Add Multiple Image Type 
                   <span class="red">
	                   (Type Each New Image Type on New Line)
                   </span>
                </td>
            </tr>
            <tr bgcolor="#FFFFFF">
                <td valign="top" class="frmdata">
                    <textarea class="form-control" name="imagetype" style="width:100%; height:150px;"></textarea>
                </td>
            </tr>
            <tr>
                <td  colspan="2" align="center">
                    <span class="red">
                        * Required Fields					
                    </span><br />
                    <input type="hidden" name="mult_imagetypesub" value="1" />
                    <input type="submit" value="Add Multiple Image Type" class="btn btn-primary">
                </td>
            </tr>
        </table>
        </form>
    
    <? }?>
</body>
</html>
