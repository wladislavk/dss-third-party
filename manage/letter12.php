<?php

include('admin/includes/config.php');

$letterid = '12';
$patientid = $_GET['pid'];
$md_referral_list = get_mdreferralids($patientid);
$letter = create_letter($letterid, $patientid, '', '', '', $md_referral_list);
if (!is_numeric($letter)) {
  print $letter . "<br />";
}

?>

<script type="text/javascript">
  window.location = '/manage/index.php';
</script>
