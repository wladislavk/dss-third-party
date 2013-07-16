<?php
session_start();
require_once('../admin/includes/main_include.php');
require_once('../includes/constants.inc');
include("../includes/sescheck.php");
require_once('../includes/general_functions.php');
?>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.1/themes/base/jquery-ui.css" />
<?php
if(isset($_REQUEST['submit']))
{
$sql = "SELECT * FROM dental_ex_page5 where patientid='".$_GET['pid']."'";
$q = mysql_query($sql);
if(mysql_num_rows($q)==0){
  $sqlex = "INSERT INTO dental_ex_page5 set 
                dentaldevice='".mysql_real_escape_string($_REQUEST['dentaldevice'])."', 
                patientid='".$_GET['pid']."',
                userid = '".s_for($_SESSION['userid'])."',
                docid = '".s_for($_SESSION['docid'])."',
                adddate = now(),
                ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
}else{

  $sqlex = "update dental_ex_page5 set dentaldevice='".mysql_real_escape_string($_REQUEST['dentaldevice'])."' where patientid='".$_GET['pid']."'";
}
$qex = mysql_query($sqlex);
$flow_sql = "UPDATE dental_flow_pg2_info SET
                device_id='".mysql_real_escape_string($_REQUEST['dentaldevice'])."'
                WHERE id='".mysql_real_escape_string($_GET['id'])."'";
mysql_query($flow_sql);
?>
<script type="text/javascript">
parent.updateDentalDevice('<?= $_GET['id']; ?>', '<?= $_REQUEST['dentaldevice']; ?>');
parent.disablePopup1();
</script>

<?php
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="css/admin.css" rel="stylesheet" type="text/css" />
<script language="javascript" type="text/javascript" src="script/validation.js"></script>
<link rel="stylesheet" href="../css/admin.css" type="text/css" />

<link rel="stylesheet" href="css/form.css" type="text/css" />
<script type="text/javascript" src="script/wufoo.js"></script>
<style type="text/css">
  .slider{
    float: left;
    width: 80%;
    margin-right: 5%;
  }

</style>
</head>
<body style="background:none;">

<div style="margin-left: 30px;">
<a href="#" onclick="$('#instructions').show('200');$(this).hide();return false;" id="ins_show">Instructions</a>
<div id="instructions" style="display:none;">
  <strong>Instructions</strong> <a href="#" onclick="$('#instructions').hide('200');$('#ins_show').show();">hide</a>
  <ol>
    <li>Evaluate pt for each category using sliding bar</li>
    <li>Choose the three most important categories (if needed)</li>
    <li>Click on Sort Devices</li>
    <li>Click the device to add to Pt chart, or click "Reset" to start over.</li>
  </ol>
</div>

</div>
</div>

<?php
  $s = "SELECT * FROM dental_patients where patientid='".mysql_real_escape_string($_GET['pid'])."'";
  $q = mysql_query($s);
  $r = mysql_fetch_assoc($q);
?>

<h2 style="margin-top:20px;">Device C-Lect for <?= $r['firstname']." ".$r['lastname']; ?>?</h2>
<?php
$s_sql = "select * FROM dental_device_guide_settings order by rank ASC";
$s_q = mysql_query($s_sql);
?>
<form action="device_guide_results.php" method="post" id="device_form" style="border:solid 2px #cce3fc;padding:0 10px 0 25px; width:24%; margin-left:2%; float:left;">
<input type="hidden" name="id" value="<?= $_GET['id']; ?>" />
<input type="hidden" name="pid" value="<?= $_GET['pid']; ?>" />
    <?php while($s_r = mysql_fetch_assoc($s_q)){ ?>
      <div class="setting" id="setting_<?= $s_r['id']; ?>" style="padding: 5px 0;">
        <strong style="padding: 5px 0;display:block;"><?= $s_r['name']; ?></strong>
	<?php if($s_r['setting_type']==DSS_DEVICE_SETTING_TYPE_RANGE){ ?>
<div class="slider" id="slider_<?= $s_r['id'];?>"></div>
<input type="checkbox" class="imp_chk" value="1" name="setting_imp_<?= $s_r['id'];?>" id="setting_imp_<?= $s_r['id'];?>" />
<div class="label" id="label_<?= $s_r['id'];?>" style="padding: 5px 0;display: block;"></div>
<input type="hidden" name="setting<?= $s_r['id'];?>" id="input_opt_<?= $s_r['id'];?>" />
<?php
$o_sql = "SELECT * FROM dental_device_guide_setting_options WHERE setting_id='".mysql_real_escape_string($s_r['id'])."' ORDER BY option_id ASC";
$o_q = mysql_query($o_sql);
$setting_options = mysql_num_rows($o_q);
$range_step = ($s_r['range_end']-$s_r['range_start'])/($setting_options-1);
?>
		<script type="text/javascript">
 $(function() {
  
   var labelArr = new Array(''<?php while($o_r = mysql_fetch_assoc($o_q)){ 
	  echo ',"'.$o_r['label'].'"';
	 } ?> );
   $( "#slider_<?= $s_r['id'];?>" ).slider({
      value:<?= $s_r['range_start'];?>,
      min: <?= $s_r['range_start'];?>,
      max: <?= $s_r['range_end'];?>,
      step: <?= $range_step;?>,
      slide: function( event, ui ) {
          $( "#input_opt_<?= $s_r['id'];?>" ).val( ui.value );
          $("#label_<?= $s_r['id'];?>").html(labelArr[ui.value]);
	  $('#results li').remove();
      }
  });
  $( "#input_opt_<?= $s_r['id'];?>" ).val($( "#slider_<?= $s_r['id'];?>" ).slider( "value" ) );
  $("#label_<?= $s_r['id'];?>").html(labelArr[$( "#slider_<?= $s_r['id'];?>" ).slider( "value" )]);
  $("#label_<?= $s_r['id'];?>").attr('data-init', labelArr[$( "#slider_<?= $s_r['id'];?>" ).slider( "value" )]);
 });
</script>
	<?php }else{ ?>
		<input type="checkbox" />
	<?php } ?>
      </div>
    <?php } ?>
</form>


<div style="float:left; width: 13%; margin-left:2%;">
  <a href="#" style="border:1px solid #000; padding: 5px;" class="device_submit addButton">Sort Devices</a>
</div>


<div style="float:left; width:50%;">

<ul id="results" style="border:solid 2px #a7cefa;">


</ul>
<a href="#" class="addButton" onclick="reset_form();return false;">Reset</a>
</div>

<script type="text/javascript">

function reset_form(){
$(".setting").each(function(){
	$(this).find(".slider").slider("value", $(this).find(".slider").slider("option", "min") );
	$(this).find(".label").html( $(this).find('.label').attr('data-init'));
        $(this).find(".imp_chk").prop("checked", false);
  });
          $('#results li').remove();
}


$('.imp_chk').click( function(){
  if($(this).is(':checked')){
    if($('.imp_chk:checked').length > 3){
      $(this).prop("checked", false);
    }
  }
});

$('.device_submit').click(function(){

$.ajax({
                                        url: "device_guide_results.php",
                                        type: "post",
                                        data: $('#device_form').serialize(),
                                        success: function(data){
						$('#results li').remove();
                                                var r = $.parseJSON(data);
						$.each( r,  function(i, v){
							if(v.image_path!=''){
							  $('#results').append("<li class='box_go'><div class='ico'><img src='"+v.image_path+"' /></div><a href='#' onclick=\"update_device("+v.id+", '"+v.name+"');return false();\">"+v['name']+" ("+ v.value +")</a></li>");
							}else{
                                                          $('#results').append("<li><a href='#' onclick=\"update_device("+v.id+", '"+v.name+"');return false();\">"+v['name']+" ("+ v.value +")</a></li>");
							}
						});



                                                if(r.error){
                                                }else{
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });


});

function update_device(device, name){
<?php
  if(isset($_GET['id'])&&isset($_GET['pid'])){
?>
 if(confirm("Do you want to select "+name+" for <?= $r['firstname']." ".$r['lastname']; ?>?")){
 $.ajax({
                                        url: "flow_device_update.php",
                                        type: "post",
                                        data: {id: <?= $_GET['id']; ?>, device: device, pid: <?= $_GET['pid']; ?>},
                                        success: function(data){
                                                //alert(data);
                                                var r = $.parseJSON(data);
                                                if(r.error){
                                                }else{
						  parent.updateDentalDevice(<?= $_GET['id']; ?>, device)
						  parent.disablePopupClean();
                                                }
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });
 }
 <?php } ?>
}

</script>

</body>
</html>

