<? 
include "includes/top.htm";

if(isset($_POST['update_btn'])){
  if($_GET['ed']!= ''){
    $s = "UPDATE dental_letter_templates_custom SET
		name='".mysql_real_escape_string($_POST['name'])."',
		body='".mysql_real_escape_string($_POST['body'])."'
		WHERE 
			docid='".mysql_real_escape_string($_SESSION['docid'])."' AND
			id='".mysql_real_escape_string($_GET['ed'])."'";
    mysql_query($s);
  }else{
    $s = "INSERT INTO dental_letter_templates_custom SET
                name='".mysql_real_escape_string($_POST['name'])."',
                body='".mysql_real_escape_string($_POST['body'])."',
                docid='".mysql_real_escape_string($_SESSION['docid'])."',
		adddate=now(),
		ip_address = '".mysql_real_escape_string($_SERVER['REMOTE_ADDR'])."'";
    mysql_query($s);
  }

    error_log($s);
    ?>
	<script type="text/javascript">
	  window.location = "manage_custom_letters.php";
	</script>
    <?php


}

$sql = "select * from dental_letter_templates_custom WHERE id='".mysql_real_escape_string($_GET['ed'])."' ";
$my = mysql_query($sql);
$r = mysql_fetch_assoc($my);


if(isset($_GET['cid'])){
  if($_GET['cid'][0]!='C'){
    $c_sql = "SELECT body FROM dental_letter_templates WHERE id = ".mysql_real_escape_string($_GET['cid']).";";
  }else{
    $c_sql = "SELECT body FROM dental_letter_templates_custom WHERE id = ".mysql_real_escape_string(substr($_GET['cid'],1)).";";
  }
  $c_q = mysql_query($c_sql);
  $c_r = mysql_fetch_assoc($c_q);
  $body = $c_r['body'];
  //To replace franchisee to doctor so software users don't get confused.
  $body = str_replace('%franchisee_', '%doctor_', $body);

}else{
  $body = $r['body'];
}


?>
<script language="javascript" type="text/javascript" src="3rdParty/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>

<span class="admin_head">
	Manage Custom Letter Templates 
</span>
<br />
<br />

<form action="?ed=<?= $_GET['ed'];?>" method="post">
<br /><br />
<div style="margin-left:20px;width:710px;float:left;">
Name: <input type="text" id="name" name="name" value="<?= $r['name']; ?>" />
<br /><br />
<textarea id="body" name="body" style="width:700px; height:400px;"><?= $body; ?></textarea>
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
  <li>%doctor_fullname%</li>
  <li>%doctor_lastname%</li>
  <li>%doctor_practice%</li>
  <li>%doctor_phone%</li>
  <li>%doctor_addr%</li>
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
<div style="clear:both;"></div>
<br /><br />	
<? include "includes/bottom.htm";?>


<script type="text/javascript">
/***
* generate font size select list
***/
function fontSizeList()
{
    var str = '';
    var step = 1;
    var n = 0;
    for (n=8; n<=36; n+=step)
    {
        str += String(n) + 'px,';
        step = parseInt((n / 12) + 1);
    }
    return str.substring(0,str.length-1); // strip last comma
}
                tinyMCE.init({
                        mode : "textareas",
                        theme : "advanced",
                        theme_advanced_buttons1 : "bold,italic,underline, separator, bullist ,numlist, separator,justifyleft, justifycenter,justifyright,  justifyfull, fontsizeselect, separator,help",
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
