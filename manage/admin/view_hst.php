<?php namespace Ds3\Libraries\Legacy; ?><?
include "includes/top.htm";
require_once('../includes/constants.inc');
require_once "includes/general.htm";

if (isset($_REQUEST['ed'])) {
    // load hst
    $sql = "SELECT "
         . "  hst.* "
         . "FROM "
         . "  dental_hst hst "
         . "  JOIN dental_patients p ON p.patientid = hst.patient_id "
         . "WHERE "
         . "  hst.id = " . $_REQUEST['ed'];
		$my = mysqli_query($con, $sql);
		$hst = mysqli_fetch_array($my);
    $pat_sql = "SELECT * FROM dental_patients WHERE patientid='".mysqli_real_escape_string($con,$hst['patient_id'])."'";
    $pat_q = mysqli_query($con,$pat_sql);
    $pat = mysqli_fetch_assoc($pat_q);

} else {
    $sql = "SELECT "
         . "  hst.* "
         . "FROM "
         . "  dental_hst hst "
         . "  JOIN dental_patients p ON p.patientid = hst.patient_id "
         . "WHERE "
         . "  hst.id = '" . $_POST['hst_id'] . "'";
                $my = mysqli_query($con,$sql) or trigger_error(mysqli_error($con), E_USER_ERROR);
                $hst = mysqli_fetch_array($my);





  //SAVE SLEEP TEST
if($_POST['status'] == DSS_HST_COMPLETE){
  $date = s_for($_POST['date']);
  $sleeptesttype = s_for($_POST['sleeptesttype']);
  $place = s_for($_POST['place']);
  $diagnosising_doc = s_for($_POST['diagnosising_doc']);
  $diagnosising_npi = s_for($_POST['diagnosising_npi']);
  $apnea = s_for($_POST['apnea']);
  $hypopnea = s_for($_POST['hypopnea']);
  $ahi = s_for($_POST['ahi']);
  $ahisupine = s_for($_POST['ahisupine']);
  $rdi = s_for($_POST['rdi']);
  $rdisupine = s_for($_POST['rdisupine']);
  $o2nadir = s_for($_POST['o2nadir']);
  $t9002 = s_for($_POST['t9002']);
  $sleepefficiency = s_for($_POST['sleepefficiency']);
  $cpaplevel = s_for($_POST['cpaplevel']);
  $dentaldevice = s_for($_POST['dentaldevice']);
  $devicesetting = s_for($_POST['devicesetting']);
  $diagnosis = s_for($_POST['diagnosis']);
  $notes = s_for($_POST['notes']);
  $testnumber = s_for($_POST['testnumber']);
  $needed = s_for($_POST['needed']);
  $scheddate = s_for($_POST['scheddate']);
  $completed = s_for($_POST['completed']);
  $interpolation = s_for($_POST['interpolation']);
  $copyreqdate = s_for($_POST['copyreqdate']);
  $sleeplab = s_for($_POST['sleeplab']);
  $patientid = $hst['patient_id'];
                if($_FILES["ss_file"]["name"] <> '')
                {
                        $fname = $_FILES["ss_file"]["name"];
                        $lastdot = strrpos($fname,".");
                        $name = substr($fname,0,$lastdot);
                        $extension = substr($fname,$lastdot+1);
                        $banner1 = $name.'_'.date('dmy_Hi');
                        $banner1 = str_replace(" ","_",$banner1);
                        $banner1 = str_replace(".","_",$banner1);
                        $banner1 = str_replace("'","_",$banner1);
                        $banner1 = str_replace("&","amp",$banner1);
                        $banner1 .= ".".$extension;

                        $uploaded = uploadImage($_FILES['ss_file'], "../../../../shared/q_file/".$banner1);

                }
                else
                {
                        $banner1 = '';
                }
if($hst['sleep_study_id']){
  $sleepid=$hst['sleep_study_id'];
  $q = "update `dental_summ_sleeplab` set
`date` = '".mysqli_real_escape_string($con,$date)."',
`sleeptesttype`  = '".mysqli_real_escape_string($con,$sleeptesttype)."',
`place`  = '".mysqli_real_escape_string($con,$place)."',
`diagnosising_doc` = '".mysqli_real_escape_string($con,$diagnosising_doc)."',
`diagnosising_npi` = '".mysqli_real_escape_string($con,$diagnosising_npi)."',
`ahi` = '".mysqli_real_escape_string($con,$ahi)."',
`ahisupine` = '".mysqli_real_escape_string($con,$ahisupine)."',
`rdi` = '".mysqli_real_escape_string($con,$rdi)."',
`rdisupine` = '".mysqli_real_escape_string($con,$rdisupine)."',
`o2nadir` = '".mysqli_real_escape_string($con,$o2nadir)."',
`t9002` = '".mysqli_real_escape_string($con,$t9002)."',
`dentaldevice` = '".mysqli_real_escape_string($con,$dentaldevice)."',
`devicesetting` = '".mysqli_real_escape_string($con,$devicesetting)."',
`diagnosis` = '".mysqli_real_escape_string($con,$diagnosis)."',
`filename` = '".mysqli_real_escape_string($con,$banner1)."',
`notes` = '".mysqli_real_escape_string($con,$notes)."',
`testnumber` = '".mysqli_real_escape_string($con,$testnumber)."',
`sleeplab` = '".mysqli_real_escape_string($con,$sleeplab)."'
WHERE id='".mysqli_real_escape_string($con,$sleepid)."'";
mysqli_query($con,$q);
}else{
  $q = "INSERT INTO `dental_summ_sleeplab` (
`id` ,
`date` ,
`sleeptesttype` ,
`place` ,
`diagnosising_doc`,
`diagnosising_npi`,
`ahi` ,
`ahisupine` ,
`rdi` ,
`rdisupine` ,
`o2nadir` ,
`t9002` ,
`dentaldevice` ,
`devicesetting` ,
`diagnosis` ,
`filename` ,
`notes`,
`testnumber`,
`sleeplab`,
`patiendid`
)
VALUES (NULL,'".$date."','".$sleeptesttype."','".$place."','".$diagnosising_doc."','".$diagnosising_npi."','".$ahi."','".$ahisupine."','".$rdi."','".$rdisupine."','".$o2nadir."','".$t9002."','".$dentaldevice."','".$devicesetting."','".$diagnosis."','".$banner1."', '".$notes."', '".$testnumber."', '".$sleeplab."', '".$patientid."')";
  $run_q = mysqli_query($con,$q);
  if(!$run_q){
   echo "Could not add sleep lab... Please try again.";
  }else{
        if($uploaded){
                $sleepid = mysqli_insert_id($con);
                                        $ins_sql = " insert into dental_q_image set 
                                        patientid = '".s_for($_GET['pid'])."',
                                        title = 'Sleep Study ".$sleepid."',
                                        imagetypeid = '1',
                                        image_file = '".s_for($banner1)."',
                                        userid = '".s_for($_SESSION['userid'])."',
                                        docid = '".s_for($_SESSION['docid'])."',
                                        adddate = now(),
                                        ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";

                                        mysqli_query($con,$ins_sql) or trigger_error($ins_sql." | ".mysqli_error($con), E_USER_ERROR);
	}

   }

}
}else{
  $sleepid='';
}
















    // update hst
    $sql = "UPDATE dental_hst SET "
				 . " office_notes = '".s_for($_POST['office_notes'])."', "
				 . " rejected_reason = '".s_for($_POST['rejected_reason'])."', "
				 . " sleep_study_id = '".s_for($sleepid)."', "
         			 . " status = '" . s_for($_POST['status']) . "' ";
    if($hst['status'] != $_POST['status']){
      $sql .= ", updatedate=now() ";
	if($_POST['status']==DSS_HST_REJECTED){
    	  $sql .= ", rejecteddate=now() ";
	}
    }
    $sql .= "WHERE id = '" . $_POST["hst_id"] . "'";
    mysqli_query($con,$sql) or trigger_error($sql." | ".mysqli_error($con), E_USER_ERROR);
    
    //echo $ed_sql.mysqli_error($con);
    $msg = "HST Updated Successfully";
    ?>
    <script type='text/javascript'>
    parent.window.location='manage_hsts.php?msg=<?= $msg; ?><?= (isset($_POST['ret_status']) && $_POST['ret_status'] != '')?"&status=".$_POST['ret_status']."&from=view":'';?>';
    </script>
  <?php
}


?>


<style>
.readonly {
  background-color: #cccccc;
}

.sub-question {
  border: 1px black solid;
  margin-top: 10px;
  margin-left: 20px;
  padding: 10px;
  display: none;
}

.question-indent {
  margin-top: 10px;
  margin-left: 20px;
}
</style>
<script language="javascript" type="text/javascript" src="script/preauth_validation.js"></script>
<script language="javascript" type="text/javascript" src="script/preauth_form_logic.js"></script>

<a href="Javascript:;" onclick="Javascript: loadPopup('/manage/admin/hst_view.php?hst_id=<?= $hst['id'] ?>');"
   title="View HST Form" class="btn btn-primary btn-sm">
    HST Form
    <span class="glyphicon glyphicon-eye-open"></span>
</a>

	<br /><br />
	
	<? if(!empty($msg)) {?>
    <div align="center" class="red">
        <? echo $msg;?>
    </div>
    <? }?>
    <form name="preauth_form" action="<?=$_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data">
    <table class="table table-bordered table-hover">
        <tr>
            <td class="cat_head" width="30%">
               HST for <?= $hst['patient_firstname']; ?> <?= $hst['patient_lastname']; ?> 
            </td>
	    <td class="cat_head" width="35%">
		HST
	    </td>
	    <td class="cat_head" width="35%">
 		Patient
	    </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Insurance Company
            </td>
            <td valign="top" class="frmdata">
	  <select name="ins_co_id" class="readonly" onclick="return false;" readonly="readonly">
<?php
                            $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contacttypeid = '11' AND docid='".$hst['doc_id']."'";
                            $ins_contact_qry_run = mysqli_query($con,$ins_contact_qry);
                            while($ins_contact_res = mysqli_fetch_array($ins_contact_qry_run)){
                            ?>
                                <option value="<?php echo $ins_contact_res['contactid']; ?>" <?php if($hst['ins_co_id'] == $ins_contact_res['contactid']){echo "selected=\"selected\"";} ?>><?php echo addslashes($ins_contact_res['company']); ?></option>;
                                
                                <?php } ?>
</select>
                <span class="red">*</span>
            </td>
            <td valign="top" class="frmdata">
          <select name="pat_ins_co_id" class="readonly" onclick="return false;" readonly="readonly">
<?php
                            $ins_contact_qry = "SELECT * FROM `dental_contact` WHERE contacttypeid = '11' AND docid='".$hst['doc_id']."'";
                            $ins_contact_qry_run = mysqli_query($con,$ins_contact_qry);
                            while($ins_contact_res = mysqli_fetch_array($ins_contact_qry_run)){
                            ?>
                                <option value="<?php echo $ins_contact_res['contactid']; ?>" <?php if($pat['p_m_ins_co'] == $ins_contact_res['contactid']){echo "selected=\"selected\"";} ?>><?php echo addslashes($ins_contact_res['company']); ?></option>;

                                <?php } ?>
</select>
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's First Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_firstname" value="<?=$hst['patient_firstname']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_firstname" value="<?=$pat['firstname']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Last Name
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_lastname" value="<?=$hst['patient_lastname']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_lastname" value="<?=$pat['lastname']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Address
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_add1" class="tbox readonly" value="<?=$hst['patient_add1'];?>" readonly />
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_add1" class="tbox readonly" value="<?=$pat['add1'];?>" readonly />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Address 2
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_add2" class="tbox readonly" value="<?=$hst['patient_add2'];?>" readonly />
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_add2" class="tbox readonly" value="<?=$pat['add2'];?>" readonly />
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's City
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?=$hst['patient_city']?>" name="patient_city" class="tbox readonly" readonly />
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?=$pat['city']?>" name="pat_patient_city" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>

        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's State
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?=$hst['patient_state']?>" name="patient_state" class="tbox readonly" readonly />
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" value="<?=$pat['state']?>" name="pat_patient_state" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>

        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Zip
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_zip" value="<?= $hst['patient_zip']?>" class="tbox readonly" readonly />
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_zip" value="<?= $pat['zip']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Home Phone
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_home_phone" value="<?= $hst['patient_home_phone']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_home_phone" value="<?= $pat['home_phone']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Cell Phone
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_cell_phone" value="<?= $hst['patient_cell_phone']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_cell_phone" value="<?= $pat['cell_phone']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Work Phone
            </td>
            <td valign="top" class="frmdata">
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_work_phone" value="<?= $pat['work_phone']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>
        </tr>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead">
                Patient's Email
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_email" value="<?= $hst['patient_email']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_email" value="<?= $pat['email']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>
        </tr>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Group Insurance #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_ins_group_id" value="<?=$hst['patient_ins_group_id']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_ins_group_id" value="<?=$pat['p_m_ins_grp']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>

        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's Insurance ID #
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_ins_id" value="<?=$hst['patient_ins_id']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_ins_id" value="<?=$pat['p_m_ins_id']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Patient's DOB
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="patient_dob" value="<?=$hst['patient_dob']?>" class="tbox readonly" readonly /> 
                <span class="red">*</span>				
            </td>
            <td valign="top" class="frmdata">
                <input type="text" name="pat_patient_dob" value="<?=$pat['dob']?>" class="tbox readonly" readonly />
                <span class="red">*</span>
            </td>

        </tr>
        <tr>
            <td valign="top" class="frmhead" width="30%">
                Notes to Office
            </td>
            <td valign="top" class="frmdata">
                <textarea name="office_notes"><?= $hst['office_notes']; ?></textarea>
            </td>
        </tr>

        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                Status
            </td>
            <td valign="top" class="frmdata">
                <select id="status" name="status" class="tbox">
			<option value="<?= DSS_HST_PENDING; ?>" <?= ($hst['status']==DSS_HST_PENDING)?'selected="selected"':''; ?>><?= $dss_hst_status_labels[DSS_HST_PENDING]; ?></option>
			<option value="<?= DSS_HST_CONTACTED; ?>" <?= ($hst['status']==DSS_HST_CONTACTED)?'selected="selected"':''; ?>><?= $dss_hst_status_labels[DSS_HST_CONTACTED]; ?></option>
                        <option value="<?= DSS_HST_SCHEDULED; ?>" <?= ($hst['status']==DSS_HST_SCHEDULED)?'selected="selected"':''; ?>><?= $dss_hst_status_labels[DSS_HST_SCHEDULED]; ?></option>
                        <option value="<?= DSS_HST_COMPLETE; ?>" <?= ($hst['status']==DSS_HST_COMPLETE)?'selected="selected"':''; ?>><?= $dss_hst_status_labels[DSS_HST_COMPLETE]; ?></option>
                        <option value="<?= DSS_HST_REJECTED; ?>" <?= ($hst['status']==DSS_HST_REJECTED)?'selected="selected"':''; ?>><?= $dss_hst_status_labels[DSS_HST_REJECTED]; ?></option>
                <span class="red">*</span>
            </td>
        </tr>
        <tr class="status_<?= DSS_HST_REJECTED; ?> status">
            <td valign="top" class="frmhead" width="30%">
                Rejected Reason
            </td>
            <td valign="top" class="frmdata">
                <textarea name="rejected_reason"><?= $hst['rejected_reason']; ?></textarea>
            </td>
        </tr>
        <tr class="status_<?= DSS_HST_COMPLETE; ?> status">
            <td valign="top" class="frmhead" width="30%">
                HST
            </td>
            <td valign="top" colspan="2" class="frmdata">
		<?php include 'view_hst_sleep_study.php'; ?>
            </td>
        </tr>
        <tr>
            <td  colspan="2" align="center">
                <span class="red">
                    * Required Fields					
                </span><br />
		<?php
		if(isset($_REQUEST['ret_status']) && $_REQUEST['ret_status'] != ''){
		?><input type="hidden" name="ret_status" value="<?= $_REQUEST['ret_status'] ?>"/><?php
		}
		?>
                <input type="hidden" name="hst_id" value="<?= $_REQUEST['ed'] ?>"/>
                  <input type="submit" value="Save HST" <?= ($hst['status']==DSS_HST_REQUESTED)?'onclick="alert(\'HST must be authorized by user before edits are permitted.\');return false;"':''; ?> class="btn btn-primary">
	  </td><td align="right">
		<a href="hst_print.php?hst=<?= $_REQUEST['ed'] ?>" class="btn btn-info" target="_blank">Print HST</a>
            </td>
        </tr>
    </table>
    </form>
  <script type="text/javascript">
    $('#status').change( function() {
      s = $(this).val();
      $('.status').hide();
      $('.status_'+s).show();
    });

    $(document).ready(function(){
      $('.status').hide();
      $('.status_<?=$hst['status'];?>').show();
    });
  </script>
<?php include 'includes/bottom.htm'; ?>
