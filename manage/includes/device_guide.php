<?php namespace Ds3\Libraries\Legacy; ?><?php
  include_once('../admin/includes/main_include.php');
  include_once('../includes/constants.inc');
  include("../includes/sescheck.php");
  include_once('../includes/general_functions.php');
?>

  <script type="text/javascript" src="/manage/js/device/jquery-1.9.1.js"></script>
  <script type="text/javascript" src="/manage/js/device/jquery-ui.js"></script>
  <script type="text/javascript" src="../js/device_guide.js"></script>
  <link rel="stylesheet" href="/manage/js/device/jquery-ui.css" />

  <?php
    if(isset($_REQUEST['submit'])) {
      $sql = "SELECT * FROM dental_ex_page5 where patientid='".$_GET['pid']."'";
      
      if($db->getNumberRows($sql) == 0) {
        $sqlex = "INSERT INTO dental_ex_page5 set 
                  dentaldevice='".mysqli_real_escape_string($con,$_REQUEST['dentaldevice'])."', 
                  patientid='".$_GET['pid']."',
                  userid = '".s_for($_SESSION['userid'])."',
                  docid = '".s_for($_SESSION['docid'])."',
                  adddate = now(),
                  ip_address = '".s_for($_SERVER['REMOTE_ADDR'])."'";
      }else{
        $sqlex = "update dental_ex_page5 set dentaldevice='".mysqli_real_escape_string($con,$_REQUEST['dentaldevice'])."' where patientid='".$_GET['pid']."'";
      }

      $qex = $db->query($sqlex);
      $flow_sql = "UPDATE dental_flow_pg2_info SET
                   device_id='".mysqli_real_escape_string($con,$_REQUEST['dentaldevice'])."'
                   WHERE id='".mysqli_real_escape_string($con,$_GET['id'])."'";

      $db->query($flow_sql);
?>
      <script type="text/javascript">
        parent.updateDentalDevice('<?php echo  $_GET['id']; ?>', '<?php echo  $_REQUEST['dentaldevice']; ?>');
        parent.disablePopup1();
      </script>
<?php } ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="../css/admin.css" rel="stylesheet" type="text/css" />
    <script language="javascript" type="text/javascript" src="../script/validation.js"></script>
    <link rel="stylesheet" href="../css/admin.css" type="text/css" />
    <link rel="stylesheet" href="../css/form.css" type="text/css" />
    <script type="text/javascript" src="../script/wufoo.js"></script>
    <link rel="stylesheet" href="../css/device_guide.css" type="text/css" />
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
    $s = "SELECT * FROM dental_patients where patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
    $r = $db->getRow($s);
  ?>

  <script>
    var firstname = "<?php echo $r['firstname']; ?>";
    var lastname = "<?php echo $r['lastname']; ?>";
    var valId = <?php if ($_GET['id']) {echo $_GET['id'];} else {echo 0;} ?>;
    var valPid = <?php if ($_GET['pid']) {echo $_GET['pid'];} else {echo 0;} ?>;
  </script>

  <h2 style="margin-top:20px;">Device C-Lect for <?php echo  $r['firstname']." ".$r['lastname']; ?>?</h2>
  
  <?php
    $s_sql = "select * FROM dental_device_guide_settings order by rank ASC";
    $s_q = $db->getResults($s_sql);
  ?>

  <form action="device_guide_results.php" method="post" id="device_form" style="border:solid 2px #cce3fc;padding:0 10px 0 25px; width:24%; margin-left:2%; float:left;">
    <input type="hidden" name="id" value="<?php echo  (!empty($_GET['id']) ? $_GET['id'] : ''); ?>" />
    <input type="hidden" name="pid" value="<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" />
    <?php if ($s_q) foreach ($s_q as $s_r){ ?>
      <div class="setting" id="setting_<?php echo  $s_r['id']; ?>" style="padding: 5px 0;">
        <strong style="padding: 5px 0;display:block;"><?php echo  $s_r['name']; ?></strong>
        <?php if($s_r['setting_type']==DSS_DEVICE_SETTING_TYPE_RANGE){ ?>
          <div class="slider" id="slider_<?php echo  $s_r['id'];?>"></div>
          <input type="checkbox" class="imp_chk" value="1" name="setting_imp_<?php echo  $s_r['id'];?>" id="setting_imp_<?php echo  $s_r['id'];?>" />
          <div class="label" id="label_<?php echo  $s_r['id'];?>" style="padding: 5px 0;display: block;"></div>
          <input type="hidden" name="setting<?php echo  $s_r['id'];?>" id="input_opt_<?php echo  $s_r['id'];?>" />
          
          <?php
            $o_sql = "SELECT * FROM dental_device_guide_setting_options WHERE setting_id='".mysqli_real_escape_string($con,$s_r['id'])."' ORDER BY option_id ASC";
            
            $o_q = $db->getResults($o_sql);
            $setting_options = count($o_q);
            $setting_options = (($setting_options != 1) ? $setting_options : 2);
            $range_step = ($s_r['range_end']-$s_r['range_start'])/($setting_options-1);
          ?>

          <?php
            $labelArray = ""; 
            if ($o_q) foreach ($o_q as $o_r){ 
              $labelArray .= ',' . $o_r['label'] . '';
            }
          ?>

          <script type="text/javascript">
            setSlider("<?php echo $labelArray; ?>", <?php echo  $s_r['id']; ?>, <?php echo  $s_r['range_start']; ?>, <?php echo $s_r['range_end']; ?>, <?php echo $range_step; ?>);
          </script>
        <?php } else { ?>
  		    <input type="checkbox" name="setting<?php echo  $s_r['id'];?>" value="1" />
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

  </body>
</html>

