<?php

include('admin/includes/config.php');

$letterid = '12';
$patientid = $_GET['pid'];
$md_list = get_mdcontactids($patientid);
$md_referral_list = get_mdreferralids($patientid);
if ($md_referral_list != "") {
	$letter = create_letter($letterid, $patientid, '', '', $md_list, $md_referral_list);
	if (!is_numeric($letter)) {
		print $letter . "<br />";
	}
}

?>

<script type="text/javascript">
  window.location = '/manage/index.php';
</script>
