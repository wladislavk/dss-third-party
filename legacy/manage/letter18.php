<?php namespace Ds3\Libraries\Legacy; ?><?php

include('admin/includes/main_include.php');

$letterid = '18';
$patientid = $_GET['pid'];
$letter = create_letter($letterid, $patientid, '', '', '', '');
if (!is_numeric($letter)) {
  print $letter . "<br />";
}

?>

<script type="text/javascript">
  window.location = '/manage/index.php';
</script>
