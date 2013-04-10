<? 
include "includes/top.htm";

if(isset($_POST['update_btn'])){

  $s = "UPDATE dental_letter_templates SET
		body='".mysql_real_escape_string($_POST['body'])."'
		WHERE id='".mysql_real_escape_string($_POST['letterid'])."'";
  mysql_query($s);


}

if(is_super($_SESSION['admin_access'])){ 
$sql = "select * from dental_letter_templates WHERE default_letter=1 ORDER BY id ASC";
}elseif(is_admin($_SESSION['admin_access'])){
$sql = "select * from dental_letter_templates WHERE companyid='".mysql_real_escape_string($_SESSION['admincompanyid'])."' ORDER BY id ASC";
}else{
?>
You do not have permission to edit default letters.
<?php 
die();
} 


$my = mysql_query($sql);
?>
<script language="javascript" type="text/javascript" src="../3rdParty/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

<span class="admin_head">
	Manage Default Letters 
</span>
<br />
<br />

<form action="" method="post">
<select id="letterid" name="letterid">
  <option value="">Select Letter</option>
  <?php while($r = mysql_fetch_assoc($my)){ ?>
	<option value="<?= $r['id']; ?>" <?= ($_REQUEST['lid']==$r['id'])?'selected=-"selected"':''; ?>><?= $r['id']." - ".$r['name']; ?></option>
  <?php } ?>
</select>
<br /><br />
<?php if($_GET['lid']){
if(is_super($_SESSION['admin_access'])){
$sql = "SELECT body from dental_letter_templates where id='".mysql_real_escape_string($_REQUEST['lid'])."'";
}else{
  $sql = "SELECT body from dental_letter_templates where id='".mysql_real_escape_string($_REQUEST['lid'])."'
		AND companyid='".mysql_real_escape_string($_SESSION['admincompanyid'])."'";
}
$q = mysql_query($sql);
$row = mysql_fetch_assoc($q);

?>
<div style="width:710px;float:left;">
<textarea id="body" name="body" style="width:700px; height:400px;"><?= $row['body']; ?></textarea>
<input type="submit" name="update_btn" value="Save" />
</div>
</form>
<div style="float:left;">
<strong>Variables</strong>
<ul style="list-style:none;">
  <li>%todays_date%</li>
  <li>%contact_salutation%</li>
  <li>%contact_fullname%</li>
  <li>%contact_firstname%</li>
  <li>%contact_lastname%</li>
  <li>%salutation%</li>
  <li>%practice%</li>
  <li>%contact_email%</li>
  <li>%addr1%</li>
  <li>%addr2%</li>
  <li>%insurance_id%</li>
  <li>%city%</li>
  <li>%state%</li>
  <li>%zip%</li>
  <li>%referral_fullname%</li>
  <li>%by_referral_fullname%</li>
  <li>%referral_lastname%</li>
  <li>%referral_practice%</li>
  <li>%ref_addr1%</li>
  <li>%ref_addr2%</li>
  <li>%ref_city%</li>
  <li>%ref_state%</li>
  <li>%ref_zip%</li>
  <li>%ptreferral_fullname%</li>
  <li>%ptreferral_firstname%</li>
  <li>%ptreferral_lastname%</li>
  <li>%ptreferral_practice%</li>
  <li>%ptref_addr1%</li>
  <li>%ptref_addr2%</li>
  <li>%ptref_city%</li>
  <li>%ptref_state%</li>
  <li>%ptref_zip%</li>
  <li>%company%</li>
  <li>%company_addr%</li>
  <li>%franchisee_fullname%</li>
  <li>%franchisee_lastname%</li>
  <li>%franchisee_practice%</li>
  <li>%franchisee_phone%</li>
  <li>%franchisee_addr%</li>
  <li>%patient_fullname%</li>
  <li>%patient_lastname%</li>
  <li>%ccpatient_fullname%</li>
  <li>%patient_dob%</li>
  <li>%patient_firstname%</li>
  <li>%patient_age%</li>
  <li>%patient_gender%</li>
  <li>%His/Her%</li>
  <li>%his/her%</li>
  <li>%he/she%</li>
  <li>%him/her%</li>
  <li>%He/She%</li>
  <li>%history%</li>
  <li>%historysentence%</li>
  <li>%medications%</li>
  <li>%medicationssentence%</li>
  <li>%1st_sleeplab_name%</li>
  <li>%2nd_sleeplab_name%</li>
  <li>%type_study%</li>
  <li>%ahi%</li>
  <li>%diagnosis%</li>
  <li>%1ststudy_date%</li>
  <li>%completed_sleeplab_name%</li>
  <li>%completed_type_study%</li>
  <li>%completed_ahi%</li>
  <li>%completed_diagnosis%</li>
  <li>%completed_study_date%</li>
  <li>%1stRDI%</li>
  <li>%1stRDI/AHI%</li>
  <li>%1stLowO2%</li>
  <li>%1stTO290%</li>
  <li>%2ndtype_study%</li>
  <li>%2ndahi%</li>
  <li>%2ndahisupine%</li>
  <li>%2ndrdi%</li>
  <li>%2ndO2Sat90%</li>
  <li>%2ndstudy_date%</li>
  <li>%2ndRDI/AHI%</li>
  <li>%2ndLowO2%</li>
  <li>%2ndTO290%</li>
  <li>%2nddiagnosis%</li>
  <li>%delivery_date%</li>
  <li>%dental_device%</li>
  <li>%1stESS%</li>
  <li>%1stSnoring%</li>
  <li>%1stEnergy%</li>
  <li>%1stQuality%</li>
  <li>%2ndESS%</li>
  <li>%2ndSnoring%</li>
  <li>%2ndEnergy%</li>
  <li>%2ndQuality%</li>
  <li>%bmi%</li>
  <li>%reason_seeking_tx%</li>
  <li>%patprogress%</li>
  <li>%tyreferred%</li>
  <li>%symptoms%</li>
  <li>%nightsperweek%</li>
  <li>%esstssupdate%</li>
  <li>%currESS/TSS%</li>
  <li>%initESS/TSS%</li>
  <li>%patient_email%</li>
  <li>%consult_date%</li>
  <li>%impressions_date%</li>
  <li>%sleeplab_name%</li>
  <li>%delay_reason%</li>
  <li>%noncomp_reason%</li>
  <li>%other_mds%</li>
  <li>%nonpcp_mds%</li>
</ul>


</div>
<?php } ?>
<br /><br />	
<? include "includes/bottom.htm";?>


<script type="text/javascript">

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

$('#letterid').change(function(){
  id = $(this).val();
  window.location = "manage_default_letters.php?lid="+id;
/*
  $.ajax({
    url: "includes/letters_get_body.php",
    type: "post",
    data: {id: id},
    success: function(data){
      var r = $.parseJSON(data);
      if(r.error){
      }else{
	$('#tinymce').html(r.body);
      }
    },
    failure: function(data){
      //alert('fail');
    }
  }); 
*/
});



</script>
