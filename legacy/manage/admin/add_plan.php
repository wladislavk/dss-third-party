<?php namespace Ds3\Libraries\Legacy; ?><?php 

include_once('includes/main_include.php');
include("includes/sescheck.php");

if(!empty($_POST["plansub"]) && $_POST["plansub"] == 1)
{
		if($_POST["ed"] != "")
		{
			$ed_sql = "update dental_plans set 
				name = '".mysqli_real_escape_string($con,$_POST['name'])."',
                                monthly_fee = '".mysqli_real_escape_string($con,$_POST['monthly_fee'])."',
                                trial_period = '".mysqli_real_escape_string($con,$_POST['trial_period'])."',
                                fax_fee = '".mysqli_real_escape_string($con,$_POST['fax_fee'])."',
                                free_fax = '".mysqli_real_escape_string($con,$_POST['free_fax'])."',
                		eligibility_fee = '".mysqli_real_escape_string($con,$_POST['eligibility_fee'])."',
                		free_eligibility = '".mysqli_real_escape_string($con,$_POST['free_eligibility'])."',
               	 		enrollment_fee = '".mysqli_real_escape_string($con,$_POST['enrollment_fee'])."',
                		free_enrollment = '".mysqli_real_escape_string($con,$_POST['free_enrollment'])."',
                		claim_fee = '".mysqli_real_escape_string($con,$_POST['claim_fee'])."',
                		free_claim = '".mysqli_real_escape_string($con,$_POST['free_claim'])."',
                		efile_fee = '".mysqli_real_escape_string($con,$_POST['efile_fee'])."',
                		free_efile = '".mysqli_real_escape_string($con,$_POST['free_efile'])."',
                        e0486_bill = '".mysqli_real_escape_string($con,$_POST['e0486_bill'])."',
                        e0486_fee = '".mysqli_real_escape_string($con,$_POST['e0486_fee'])."',
                		vob_fee = '".mysqli_real_escape_string($con,$_POST['vob_fee'])."',
                		free_vob = '".mysqli_real_escape_string($con,$_POST['free_vob'])."',
				producer_fee = '".mysqli_real_escape_string($con,$_POST['producer_fee'])."',
				user_fee = '".mysqli_real_escape_string($con,$_POST['user_fee'])."',
				patient_fee = '".mysqli_real_escape_string($con,$_POST['patient_fee'])."',
				duration = '".mysqli_real_escape_string($con,$_POST['duration'])."',
                		office_type = '".mysqli_real_escape_string($con,$_POST['office_type'])."',
                                status = '".mysqli_real_escape_string($con,$_POST['status'])."'
				WHERE id = '".mysqli_real_escape_string($con,$_POST['ed'])."'";
			mysqli_query($con,$ed_sql);
			
			$msg = "Edited Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location='manage_plans.php?msg=<?php echo $msg;?>';
			</script>
			<?
			trigger_error("Die called", E_USER_ERROR);
		}
		else
		{
			$ins_sql = "insert into dental_plans SET
                                name = '".mysqli_real_escape_string($con,$_POST['name'])."',
                                monthly_fee = '".mysqli_real_escape_string($con,$_POST['monthly_fee'])."',
                                trial_period = '".mysqli_real_escape_string($con,$_POST['trial_period'])."',
                                fax_fee = '".mysqli_real_escape_string($con,$_POST['fax_fee'])."',
                                free_fax = '".mysqli_real_escape_string($con,$_POST['free_fax'])."',
                                eligibility_fee = '".mysqli_real_escape_string($con,$_POST['eligibility_fee'])."',
                                free_eligibility = '".mysqli_real_escape_string($con,$_POST['free_eligibility'])."',
                                enrollment_fee = '".mysqli_real_escape_string($con,$_POST['enrollment_fee'])."',
                                free_enrollment = '".mysqli_real_escape_string($con,$_POST['free_enrollment'])."',
                                claim_fee = '".mysqli_real_escape_string($con,$_POST['claim_fee'])."',
                                free_claim = '".mysqli_real_escape_string($con,$_POST['free_claim'])."',
                                efile_fee = '".mysqli_real_escape_string($con,$_POST['efile_fee'])."',
                                free_efile = '".mysqli_real_escape_string($con,$_POST['free_efile'])."',
                                e0486_bill = '".mysqli_real_escape_string($con,$_POST['e0486_bill'])."',
                                e0486_fee = '".mysqli_real_escape_string($con,$_POST['e0486_fee'])."',
                                vob_fee = '".mysqli_real_escape_string($con,$_POST['vob_fee'])."',
                                free_vob = '".mysqli_real_escape_string($con,$_POST['free_vob'])."',
				producer_fee = '".mysqli_real_escape_string($con,$_POST['producer_fee'])."',
				user_fee = '".mysqli_real_escape_string($con,$_POST['user_fee'])."',
				patient_fee = '".mysqli_real_escape_string($con,$_POST['patient_fee'])."',
				duration = '".mysqli_real_escape_string($con,$_POST['duration'])."',
                                office_type = '".mysqli_real_escape_string($con,$_POST['office_type'])."',
                                status = '".mysqli_real_escape_string($con,$_POST['status'])."',
				adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
			mysqli_query($con,$ins_sql);
			
			$msg = "Added Successfully";
			?>
			<script type="text/javascript">
				//alert("<?php echo $msg;?>");
				parent.window.location = 'manage_plans.php?msg=<?php echo $msg;?>';
			</script>
			<?
			trigger_error("Die called", E_USER_ERROR);
		}
	}

?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
<script type="text/javascript" src="../3rdParty/input_mask/jquery.maskedinput.min.js"></script>
	<script type="text/javascript" src="/manage/script/masks.js"></script>
    <?
    $thesql = "select * from dental_plans where id='".(!empty($_REQUEST["ed"]) ? $_REQUEST["ed"] : '')."'";
	$themy = mysqli_query($con,$thesql);
	$themyarray = mysqli_fetch_array($themy);
	
	if(!empty($msg))
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
		$e0486_bill = $_POST['e0486_bill'];
		$e0486_fee = $_POST['e0486_fee'];
		$vob_fee = $_POST['vob_fee'];
		$free_vob = $_POST['free_vob'];
		$producer_fee = $_POST['producer_fee'];
		$user_fee = $_POST['user_fee'];
		$patient_fee = $_POST['patient_fee'];
		$duration = $_POST['duration'];
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
		$efile_fee = $themyarray['efile_fee'];
		$free_efile = $themyarray['free_efile'];
                $e0486_bill = $themyarray['e0486_bill'];
                $e0486_fee = $themyarray['e0486_fee'];
                $vob_fee = $themyarray['vob_fee'];
                $free_vob = $themyarray['free_vob'];
		$producer_fee = $themyarray['producer_fee'];
		$user_fee = $themyarray['user_fee'];
		$patient_fee = $themyarray['patient_fee'];
		$duration = $themyarray['duration'];
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
	
	<?php if(!empty($msg)) {?>
    <div class="alert alert-danger text-center">
        <?php echo $msg;?>
    </div>
    <?php }?>
    <form name="planfrm" action="<?php echo $_SERVER['PHP_SELF'];?>?add=1" method="post" onsubmit="return check_add();">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               <?php echo $but_text?> Plan
               <?php if($name <> "") {?>
               		&quot;<?php echo $name;?>&quot;
               <?php }?>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="name" value="<?php echo $name?>" class="form-control validate" /> 
                <span class="red">*</span>				
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Monthly Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="monthly_fee" value="<?php echo $monthly_fee?>" class="moneymask form-control validate" />          
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Trial Period (days)
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="trial_period" value="<?php echo $trial_period?>" class="numbermask form-control validate" />          
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Fax Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="fax_fee" value="<?php echo $fax_fee?>" class="moneymask form-control validate" />          
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Free Fax (Monthly)
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="free_fax" value="<?php echo $free_fax?>" class="numbermask form-control validate" />          
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Eligibility Check Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="eligibility_fee" value="<?php echo $eligibility_fee?>" class="moneymask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Free Eligibility Checks (Monthly)
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="free_eligibility" value="<?php echo $free_eligibility?>" class="numbermask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Enrollment Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="enrollment_fee" value="<?php echo $enrollment_fee?>" class="moneymask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Free Enrollments (Monthly)
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="free_enrollment" value="<?php echo $free_enrollment?>" class="numbermask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
	<!-- new -->
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Claim E-File Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="efile_fee" value="<?php echo $efile_fee?>" class="moneymask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
	<!-- new -->
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Free E-Claims (Monthly)
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="free_efile" value="<?php echo $free_efile?>" class="moneymask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Claim Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="claim_fee" value="<?php echo $claim_fee?>" class="moneymask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Free Claims (Lifetime)
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="free_claim" value="<?php echo $free_claim?>" class="numbermask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Always Bill e0486?
            </td>
            <td valign="top" class="frmdata">
                <input type="checkbox" name="e0486_bill" value="1" <?php if($e0486_bill==1){ echo ' checked="checked" '; } ?> class="form-control" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                e0486 Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="e0486_fee" value="<?=$e0486_fee?>" class="moneymask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                VOB Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="vob_fee" value="<?php echo $vob_fee?>" class="moneymask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Free VOBs (Lifetime)
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="free_vob" value="<?php echo $free_vob?>" class="numbermask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Plan Length (months)
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="duration" value="<?php echo $duration?>" class="numbermask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Producer Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="producer_fee" value="<?php echo $producer_fee?>" class="moneymask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                User Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="user_fee" value="<?php echo (!empty($user_fee) ? $user_fee : ''); ?>" class="moneymask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                New Patient Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_fee" value="<?php echo $patient_fee?>" class="moneymask form-control validate" />
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
			<option <?php echo  ($office_type==1)?'selected="selected"':''; ?> value="1">Super->FO</option>
			<option <?php echo  ($office_type==2)?'selected="selected"':''; ?> value="2">Super->BO</option>
			<option <?php echo  ($office_type==3)?'selected="selected"':''; ?> value="3">BO Ins Co->FO</option>
		</select>
            </td>
        </tr>


        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Status
            </td>
            <td valign="top" class="frmdata">
            	<select name="status" class="form-control validate">
                	<option value="1" <?php if($status == 1) echo " selected";?>>Active</option>
                	<option value="2" <?php if($status == 2) echo " selected";?>>In-Active</option>
                </select>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
                <input type="hidden" name="plansub" value="1" />
                <input type="hidden" name="ed" value="<?php echo $themyarray["id"]?>" />
                <input type="submit" value="<?php echo $but_text?> Plan" class="btn btn-primary">
		<?php if($themyarray["id"] != '' && $_SESSION['admin_access']==1){ ?>
		<?php $u_sql = "SELECT userid, first_name, last_name FROM dental_users where plan_id='".mysqli_real_escape_string($con,$themyarray["id"])."'";
		      $u_q = mysqli_query($con,$u_sql);
		      if(mysqli_num_rows($u_q)>0){ 
			$names = '';
			while($u_r = mysqli_fetch_assoc($u_q)){
			  $names .= $u_r['first_name']." ".$u_r['last_name'].", ";
			}
			?>
                    <a href="#" onclick="javascript: alert('This plan is associated with the following users and cannot be deleted: <?php echo  $names; ?>'); return false;" class="editdel btn btn-danger pull-right" title="DELETE">
						Delete
					</a>
		  <?php }else{ ?>
                    <a href="manage_plans.php?delid=<?php echo $themyarray["id"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel btn btn-danger pull-right" title="DELETE">
                                                Delete
                                        </a>
		<?php }
			} ?>
            </td>
        </tr>
    </table>
    </form>
<script type="text/javascript">
function check_add(){
        var isValid = true;
	var isNumber = true;
        $('input[type="text"]').each(function() {
            if ($.trim($(this).val()) == '') {
                isValid = false;
            }
        });
        $('input.moneymask, input.numbermask').each(function() {
    var intRegex = /^[\.\d]+$/;
    if(!intRegex.test($.trim($(this).val()))) {
                isNumber = false;
            }
        });

        if (isValid == false){ 
	    alert('All fields are required.');
	    return false;
	}else if(isNumber == false){
	    alert('Fee and free amount fields must be numeric.');
	    return false;
        }else{ 
	    return true;
	}
}
</script>
    
</body>
</html>
