<?php 
include "includes/top.htm";

if(isset($_POST['update_btn'])){

  $s = "UPDATE dental_letter_templates SET
		body='".mysqli_real_escape_string($con,$_POST['body'])."'
		WHERE id='".mysqli_real_escape_string($con,$_POST['letterid'])."'";
  mysqli_query($con,$s);


}

if(is_super($_SESSION['admin_access'])){ 
$sql = "select * from dental_letter_templates WHERE default_letter=1 ORDER BY id ASC";
}elseif(is_admin($_SESSION['admin_access'])){
$sql = "select * from dental_letter_templates WHERE companyid='".mysqli_real_escape_string($con,$_SESSION['admincompanyid'])."' ORDER BY id ASC";
}else{
?>
You do not have permission to edit default letters.
<?php 
die();
} 


$my = mysqli_query($con,$sql);
?>

<div class="page-header">
    Manage Default Letters 
</div>
<br />
<br />

<div class="row">
    <p class="col-md-6 col-md-push-3">
        <select id="letterid" name="letterid" class="form-control">
            <option value="">Select Letter</option>
            <?php while ($r = mysqli_fetch_assoc($my)) { ?>
            <option value="<?php echo  (!empty($r['id']) ? $r['id'] : ''); ?>" <?php echo  (!empty($_REQUEST['lid']) && $_REQUEST['lid']==$r['id'])?'selected=-"selected"':''; ?>><?php echo  $r['id']." - ".$r['name']; ?></option>
            <?php } ?>
        </select>
    </p>
</div>
<div class="row">
    <?php
    
    if (!empty($_GET['lid'])) {
        if (is_super($_SESSION['admin_access'])) {
            $sql = "SELECT body from dental_letter_templates where id='".mysqli_real_escape_string($con,$_REQUEST['lid'])."'";
        }
        else {
            $sql = "SELECT body from dental_letter_templates where id='".mysqli_real_escape_string($con,$_REQUEST['lid'])."' AND companyid='".mysqli_real_escape_string($con,$_SESSION['admincompanyid'])."'";
        }
        
        $q = mysqli_query($con,$sql);
        $row = mysqli_fetch_assoc($q);
        
        ?>
    <form action="" method="post" class="form-horizontal">
        <div class="col-md-9">
            <input type="hidden" name="letterid" value="<?php echo  $_REQUEST['lid'] ?>">
            <textarea id="body" name="body" class="form-control" rows="25"><?php echo  $row['body']; ?></textarea>
            <input type="submit" name="update_btn" value="Save" class="btn btn-success col-md-4 col-md-push-4">
        </div>
        <div class="col-md-3">
            <strong>Variables</strong>
            <ul class="list-group well">
                <li class="list-group-item"><code>%todays_date%</code></li>
                <li class="list-group-item"><code>%contact_salutation%</code></li>
                <li class="list-group-item"><code>%contact_fullname%</code></li>
                <li class="list-group-item"><code>%contact_firstname%</code></li>
                <li class="list-group-item"><code>%contact_lastname%</code></li>
                <li class="list-group-item"><code>%salutation%</code></li>
                <li class="list-group-item"><code>%practice%</code></li>
                <li class="list-group-item"><code>%contact_email%</code></li>
                <li class="list-group-item"><code>%addr1%</code></li>
                <li class="list-group-item"><code>%addr2%</code></li>
                <li class="list-group-item"><code>%insurance_id%</code></li>
                <li class="list-group-item"><code>%city%</code></li>
                <li class="list-group-item"><code>%state%</code></li>
                <li class="list-group-item"><code>%zip%</code></li>
                <li class="list-group-item"><code>%referral_fullname%</code></li>
                <li class="list-group-item"><code>%by_referral_fullname%</code></li>
                <li class="list-group-item"><code>%referral_lastname%</code></li>
                <li class="list-group-item"><code>%referral_practice%</code></li>
                <li class="list-group-item"><code>%ref_addr1%</code></li>
                <li class="list-group-item"><code>%ref_addr2%</code></li>
                <li class="list-group-item"><code>%ref_city%</code></li>
                <li class="list-group-item"><code>%ref_state%</code></li>
                <li class="list-group-item"><code>%ref_zip%</code></li>
                <li class="list-group-item"><code>%ptreferral_fullname%</code></li>
                <li class="list-group-item"><code>%ptreferral_firstname%</code></li>
                <li class="list-group-item"><code>%ptreferral_lastname%</code></li>
                <li class="list-group-item"><code>%ptreferral_practice%</code></li>
                <li class="list-group-item"><code>%ptref_addr1%</code></li>
                <li class="list-group-item"><code>%ptref_addr2%</code></li>
                <li class="list-group-item"><code>%ptref_city%</code></li>
                <li class="list-group-item"><code>%ptref_state%</code></li>
                <li class="list-group-item"><code>%ptref_zip%</code></li>
                <li class="list-group-item"><code>%company%</code></li>
                <li class="list-group-item"><code>%company_addr%</code></li>
                <li class="list-group-item"><code>%franchisee_fullname%</code></li>
                <li class="list-group-item"><code>%franchisee_lastname%</code></li>
                <li class="list-group-item"><code>%franchisee_practice%</code></li>
                <li class="list-group-item"><code>%franchisee_phone%</code></li>
                <li class="list-group-item"><code>%franchisee_addr%</code></li>
                <li class="list-group-item"><code>%patient_fullname%</code></li>
                <li class="list-group-item"><code>%patient_lastname%</code></li>
                <li class="list-group-item"><code>%ccpatient_fullname%</code></li>
                <li class="list-group-item"><code>%patient_dob%</code></li>
                <li class="list-group-item"><code>%patient_firstname%</code></li>
                <li class="list-group-item"><code>%patient_age%</code></li>
                <li class="list-group-item"><code>%patient_gender%</code></li>
                <li class="list-group-item"><code>%His/Her%</code></li>
                <li class="list-group-item"><code>%his/her%</code></li>
                <li class="list-group-item"><code>%he/she%</code></li>
                <li class="list-group-item"><code>%him/her%</code></li>
                <li class="list-group-item"><code>%He/She%</code></li>
                <li class="list-group-item"><code>%history%</code></li>
                <li class="list-group-item"><code>%historysentence%</code></li>
                <li class="list-group-item"><code>%medications%</code></li>
                <li class="list-group-item"><code>%medicationssentence%</code></li>
                <li class="list-group-item"><code>%1st_sleeplab_name%</code></li>
                <li class="list-group-item"><code>%2nd_sleeplab_name%</code></li>
                <li class="list-group-item"><code>%type_study%</code></li>
                <li class="list-group-item"><code>%ahi%</code></li>
                <li class="list-group-item"><code>%diagnosis%</code></li>
                <li class="list-group-item"><code>%1ststudy_date%</code></li>
                <li class="list-group-item"><code>%completed_sleeplab_name%</code></li>
                <li class="list-group-item"><code>%completed_type_study%</code></li>
                <li class="list-group-item"><code>%completed_ahi%</code></li>
                <li class="list-group-item"><code>%completed_diagnosis%</code></li>
                <li class="list-group-item"><code>%completed_study_date%</code></li>
                <li class="list-group-item"><code>%1stRDI%</code></li>
                <li class="list-group-item"><code>%1stRDI/AHI%</code></li>
                <li class="list-group-item"><code>%1stLowO2%</code></li>
                <li class="list-group-item"><code>%1stTO290%</code></li>
                <li class="list-group-item"><code>%2ndtype_study%</code></li>
                <li class="list-group-item"><code>%2ndahi%</code></li>
                <li class="list-group-item"><code>%2ndahisupine%</code></li>
                <li class="list-group-item"><code>%2ndrdi%</code></li>
                <li class="list-group-item"><code>%2ndO2Sat90%</code></li>
                <li class="list-group-item"><code>%2ndstudy_date%</code></li>
                <li class="list-group-item"><code>%2ndRDI/AHI%</code></li>
                <li class="list-group-item"><code>%2ndLowO2%</code></li>
                <li class="list-group-item"><code>%2ndTO290%</code></li>
                <li class="list-group-item"><code>%2nddiagnosis%</code></li>
                <li class="list-group-item"><code>%delivery_date%</code></li>
                <li class="list-group-item"><code>%dental_device%</code></li>
                <li class="list-group-item"><code>%1stESS%</code></li>
                <li class="list-group-item"><code>%1stSnoring%</code></li>
                <li class="list-group-item"><code>%1stEnergy%</code></li>
                <li class="list-group-item"><code>%1stQuality%</code></li>
                <li class="list-group-item"><code>%2ndESS%</code></li>
                <li class="list-group-item"><code>%2ndSnoring%</code></li>
                <li class="list-group-item"><code>%2ndEnergy%</code></li>
                <li class="list-group-item"><code>%2ndQuality%</code></li>
                <li class="list-group-item"><code>%bmi%</code></li>
                <li class="list-group-item"><code>%reason_seeking_tx%</code></li>
                <li class="list-group-item"><code>%patprogress%</code></li>
                <li class="list-group-item"><code>%tyreferred%</code></li>
                <li class="list-group-item"><code>%symptoms%</code></li>
                <li class="list-group-item"><code>%nightsperweek%</code></li>
                <li class="list-group-item"><code>%esstssupdate%</code></li>
                <li class="list-group-item"><code>%currESS/TSS%</code></li>
                <li class="list-group-item"><code>%initESS/TSS%</code></li>
                <li class="list-group-item"><code>%patient_email%</code></li>
                <li class="list-group-item"><code>%consult_date%</code></li>
                <li class="list-group-item"><code>%impressions_date%</code></li>
                <li class="list-group-item"><code>%sleeplab_name%</code></li>
                <li class="list-group-item"><code>%delay_reason%</code></li>
                <li class="list-group-item"><code>%noncomp_reason%</code></li>
                <li class="list-group-item"><code>%other_mds%</code></li>
                <li class="list-group-item"><code>%nonpcp_mds%</code></li>
            </ul>
        </div>
    </form>
    <?php } ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $('#letterid').on('change',function(){
        window.location = '?lid=' + $(this).val();
    });
    
    tinyMCE.init({
        mode : "textareas",
        theme : "advanced",
        theme_advanced_buttons1 : "bold,italic,underline, separator, bullist ,numlist, separator,justifyleft, justifycenter,justifyright,  justifyfull, separator,help",
        theme_advanced_buttons2 : "",
        theme_advanced_buttons3 : "",
        gecko_spellcheck : true,
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left"
    });
    
    $('ul.list-group')
        .css({ 'overflow-y': 'auto' })
        .height($('textarea').height());
});
</script>
<?php include "includes/bottom.htm";?>
