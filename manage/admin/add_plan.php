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
				producer_fee = '".mysql_real_escape_string($_POST['producer_fee'])."',
				user_fee = '".mysql_real_escape_string($_POST['user_fee'])."',
				patient_fee = '".mysql_real_escape_string($_POST['patient_fee'])."',
				duration = '".mysql_real_escape_string($_POST['duration'])."',
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
				producer_fee = '".mysql_real_escape_string($_POST['producer_fee'])."',
				user_fee = '".mysql_real_escape_string($_POST['user_fee'])."',
				patient_fee = '".mysql_real_escape_string($_POST['patient_fee'])."',
				duration = '".mysql_real_escape_string($_POST['duration'])."',
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
                $vob_fee = $themyarray['vob_fee'];
                $free_vob = $themyarray['free_vob'];
		$producer_fee = $themyarray['producer_fee'];
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
	
	<? if($msg != '') {?>
    <div class="alert alert-danger text-center">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="planfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1" method="post" onsubmit="return check_add();">
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
                <input type="text" name="trial_period" value="<?=$trial_period?>" class="numbermask form-control validate" />          
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
                <input type="text" name="free_fax" value="<?=$free_fax?>" class="numbermask form-control validate" />          
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
                <input type="text" name="free_eligibility" value="<?=$free_eligibility?>" class="numbermask form-control validate" />
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
                <input type="text" name="free_enrollment" value="<?=$free_enrollment?>" class="numbermask form-control validate" />
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
                <input type="text" name="free_claim" value="<?=$free_claim?>" class="numbermask form-control validate" />
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
                <input type="text" name="free_vob" value="<?=$free_vob?>" class="numbermask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Plan Length (months)
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="duration" value="<?=$duration?>" class="numbermask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Producer Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="producer_fee" value="<?=$producer_fee?>" class="moneymask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                User Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="user_fee" value="<?=$user_fee?>" class="moneymask form-control validate" />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                New Patient Fee
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_fee" value="<?=$patient_fee?>" class="moneymask form-control validate" />
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
			<option <?= ($office_type==1)?'selected="selected"':''; ?> value="1">Super->FO</option>
			<option <?= ($office_type==2)?'selected="selected"':''; ?> value="2">Super->BO</option>
			<option <?= ($office_type==3)?'selected="selected"':''; ?> value="3">BO Ins Co->FO</option>
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
		<?php $u_sql = "SELECT userid, first_name, last_name FROM dental_users where plan_id='".mysql_real_escape_string($themyarray["id"])."'";
		      $u_q = mysql_query($u_sql);
		      if(mysql_num_rows($u_q)>0){ 
			$names == '';
			while($u_r = mysql_fetch_assoc($u_q)){
			  $names .= $u_r['first_name']." ".$u_r['last_name'].", ";
			}
			?>
                    <a href="#" onclick="javascript: alert('This plan is associated with the following users and cannot be deleted: <?= $names; ?>'); return false;" class="editdel btn btn-danger pull-right" title="DELETE">
						Delete
					</a>
		  <?php }else{ ?>
                    <a href="manage_plans.php?delid=<?=$themyarray["id"];?>" onclick="javascript: return confirm('Do Your Really want to Delete?.');" target="_parent" class="editdel btn btn-danger pull-right" title="DELETE">
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
