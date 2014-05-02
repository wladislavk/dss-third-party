<?php 
session_start();
require_once('includes/main_include.php');
include("includes/sescheck.php");

if($_POST["plansub"] == 1)
{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_plans set 
				name = '".mysql_real_escape_string($_POST['name'])."',
                                monthly_fee = '".mysql_real_escape_string($_POST['monthly_fee'])."',
                                trial_period = '".mysql_real_escape_string($_POST['trial_period'])."',
                                fax_fee = '".mysql_real_escape_string($_POST['fax_fee'])."',
                                free_fax = '".mysql_real_escape_string($_POST['free_fax'])."',
                		eligibility_fee = '".mysql_real_escape_string($_POST['eligibility_fee'])."',
                		free_eligibility = '".mysql_real_escape_string($_POST['free_eligibility'])."',
               	 		enrollment_fee = '".mysql_real_escape_string($_POST['enrollment_fee'])."',
                		free_enrollment = '".mysql_real_escape_string($_POST['free_enrollment'])."',
                		claim_fee = '".mysql_real_escape_string($_POST['claim_fee'])."',
                		free_claim = '".mysql_real_escape_string($_POST['free_claim'])."',
                		efile_fee = '".mysql_real_escape_string($_POST['efile_fee'])."',
                		free_efile = '".mysql_real_escape_string($_POST['free_efile'])."',
                		vob_fee = '".mysql_real_escape_string($_POST['vob_fee'])."',
                		free_vob = '".mysql_real_escape_string($_POST['free_vob'])."',
                		office_type = '".mysql_real_escape_string($_POST['office_type'])."',
                                status = '".mysql_real_escape_string($_POST['status'])."'
				WHERE id = '".mysql_real_escape_string($_POST['ed'])."'";
			mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());
			
			//echo $ed_sql.mysql_error();
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_plans.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
		else
		{
			$ins_sql = "insert into dental_plans SET
                                name = '".mysql_real_escape_string($_POST['name'])."',
                                monthly_fee = '".mysql_real_escape_string($_POST['monthly_fee'])."',
                                trial_period = '".mysql_real_escape_string($_POST['trial_period'])."',
                                fax_fee = '".mysql_real_escape_string($_POST['fax_fee'])."',
                                free_fax = '".mysql_real_escape_string($_POST['free_fax'])."',
                                eligibility_fee = '".mysql_real_escape_string($_POST['eligibility_fee'])."',
                                free_eligibility = '".mysql_real_escape_string($_POST['free_eligibility'])."',
                                enrollment_fee = '".mysql_real_escape_string($_POST['enrollment_fee'])."',
                                free_enrollment = '".mysql_real_escape_string($_POST['free_enrollment'])."',
                                claim_fee = '".mysql_real_escape_string($_POST['claim_fee'])."',
                                free_claim = '".mysql_real_escape_string($_POST['free_claim'])."',
                                efile_fee = '".mysql_real_escape_string($_POST['efile_fee'])."',
                                free_efile = '".mysql_real_escape_string($_POST['free_efile'])."',
                                vob_fee = '".mysql_real_escape_string($_POST['vob_fee'])."',
                                free_vob = '".mysql_real_escape_string($_POST['free_vob'])."',
                                office_type = '".mysql_real_escape_string($_POST['office_type'])."',
                                status = '".mysql_real_escape_string($_POST['status'])."',
				adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysql_query($ins_sql) or die($ins_sql.mysql_error());
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?=$msg;?>");
				parent.window.location='manage_plans.php?msg=<?=$msg;?>';
			</script>
			<?
			die();
		}
	}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
<script type="text/javascript" src="../3rdParty/input_mask/jquery.maskedinput.min.js"></script>
	<script type="text/javascript" src="/manage/script/masks.js"></script>
    <?
    $thesql = "select * from dental_plans where id='".$_REQUEST["ed"]."'";
	$themy = mysql_query($thesql);
	$themyarray = mysql_fetch_array($themy);
	
	if($msg != '')
	{
		$name = $_POST['name'];
		$monthly_fee = $_POST['monthly_fee'];
		$trial_period = $_POST['trial_period'];
		$fax_fee = $_POST['fax_fee'];
		$free_fax = $_POST['free_fax'];
		$eligibility_fee = $_POST['eligibility_fee'];
		$free_eligibility = $_POST['free_eligibility'];
		$enrollment_fee = $_POST['enrollment_fee'];
		$free_enrollment = $_POST['free_enrollment'];
		$claim_fee = $_POST['claim_fee'];
		$free_claim = $_POST['free_claim'];
		$efile_fee = $_POST['efile_fee'];
		$free_efile = $_POST['free_efile'];
		$vob_fee = $_POST['vob_fee'];
		$free_vob = $_POST['free_vob'];
		$office_type = $_POST['office_type'];
		$status = $_POST['status'];
	}
	else
	{
                $name = st($themyarray['name']);
                $monthly_fee = st($themyarray['monthly_fee']);
                $trial_period = st($themyarray['trial_period']);
                $fax_fee = st($themyarray['fax_fee']);
                $free_fax = st($themyarray['free_fax']);
                $eligibility_fee = $themyarray['eligibility_fee'];
                $free_eligibility = $themyarray['free_eligibility'];
                $enrollment_fee = $themyarray['enrollment_fee'];
                $free_enrollment = $themyarray['free_enrollment'];
                $claim_fee = $themyarray['claim_fee'];
                $free_claim = $themyarray['free_claim'];
                $vob_fee = $themyarray['vob_fee'];
                $free_vob = $themyarray['free_vob'];
                $office_type = $themyarray['office_type'];
		$status = st($themyarray['status']);
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
    <form name="planfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" ><!--onsubmit="return check_add();">-->
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?=$but_text?> Plan
               <? if($name <> "") {?>
               		&quot;<?=$name;?>&quot;
               <? }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="name" value="<?=$name?>" class="form-control validate" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Monthly Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="monthly_fee" value="<?=$monthly_fee?>" class="moneymask form-control validate" />          
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Trial Period (days)
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="trial_period" value="<?=$trial_period?>" class="form-control validate" />          
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Fax Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="fax_fee" value="<?=$fax_fee?>" class="moneymask form-control validate" />          
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Free Fax (Monthly)
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="free_fax" value="<?=$free_fax?>" class="form-control validate" />          
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Eligibility Check Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="eligibility_fee" value="<?=$eligibility_fee?>" class="moneymask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Free Eligibility Checks (Monthly)
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="free_eligibility" value="<?=$free_eligibility?>" class="form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Enrollment Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="enrollment_fee" value="<?=$enrollment_fee?>" class="moneymask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Free Enrollments (Monthly)
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="free_enrollment" value="<?=$free_enrollment?>" class="form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
	<!-- new -->
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Claim E-File Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="efile_fee" value="<?=$efile_fee?>" class="moneymask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
	<!-- new -->
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Free E-Claims (Monthly)
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="free_efile" value="<?=$free_efile?>" class="moneymask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Claim Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="claim_fee" value="<?=$claim_fee?>" class="moneymask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Free Claims (Lifetime)
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="free_claim" value="<?=$free_claim?>" class="form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                VOB Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="vob_fee" value="<?=$vob_fee?>" class="moneymask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Free VOBs (Lifetime)
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="free_vob" value="<?=$free_vob?>" class="form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>

	<!-- NEW -->
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
		Type                
            </td>
            <td valign="top" class="frmdata">
                <select name="office_type" class="form-control validate" />
			<option <?= ($office_type==1)?'selected="selected"':''; ?> value="1">Front-office</option>
			<option <?= ($office_type==2)?'selected="selected"':''; ?> value="2">Back-office</option>
		</select>
            </td>
        </tr>


        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="form-control validate">
                	<option value="1" <? if($status == 1) echo " selected";?>>Active</option>
                	<option value="2" <? if($status == 2) echo " selected";?>>In-Active</option>
                </select>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="plansub" value="1" />
                <input type="hidden" name="ed" value="<?=$themyarray["id"]?>" />
                <input type="submit" value="<?=$but_text?> Plan" class="btn btn-primary">
		<?php if($themyarray["id"] != '' && $_SESSION['admin_access']==1){ ?>
                    <a href="manage_plans.php?delid=<?=$themyarray["id"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel btn btn-danger pull-right" title="DELETE">
                                                Delete
                                        </a>
		<?php } ?>
            </td>
        </tr>
    </table>
    </form>
<script type="text/javascript">
function check_add(){
  if($('.validate[value=""]').length>0){
	
      alert('All fields are required.');
    return false;
  }
  return true;
}
</script>
    
</body>
</html>
