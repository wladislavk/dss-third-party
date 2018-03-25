<!--
<script type="text/javascript">
  $('#dentaldevice_' + deviceId).val('<?php echo  $_REQUEST[\'dentaldevice\']; ?>')
  parent.disablePopup1();
</script>
<?php } ?>
<?php
  $s = "SELECT * FROM dental_patients where patientid='".mysqli_real_escape_string($con,(!empty($_GET['pid']) ? $_GET['pid'] : ''))."'";
  $r = $db->getRow($s);
?>
<template>
    <h2 style="margin-top:20px;">What device will you make for <?php echo  $r['firstname']." ".$r['lastname']; ?>?</h2>
    <a v-legacy-href="'device_guide.php?pid=' + this.patientId + '&id=' + this.deviceId">Help me decide</a>
    <?php
      $sqlex = "select * from dental_ex_page5 where patientid='".(!empty($_GET['pid']) ? $_GET['pid'] : '')."'";
      $myarrayex = $db->getRow($sqlex);
      $dentaldevice = st($myarrayex['dentaldevice']);
    ?>
    <form action="#">
        Device
        <select name="dentaldevice" style="width:250px">
            <option value=""></option>
            <?php
              $device_sql = "select deviceid, device from dental_device where status=1 order by sortby;";
              $device_my = $db->getResults($device_sql);
              foreach ($device_my as $device_myarray) {
            ?>
            <option <?php echo  ($device_myarray['deviceid']==$dentaldevice)?'selected="selected"':''; ?>value="<?php echo st($device_myarray['deviceid'])?>"><?php echo st($device_myarray['device']);?></option>
            <?php } ?>
        </select>
        <input type="submit" name="submit" value="Submit" />
    </form>
</template>
-->
