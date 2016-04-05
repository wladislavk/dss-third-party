<?php namespace Ds3\Libraries\Legacy; ?><?php
include_once('includes/main_include.php');
include("includes/sescheck.php");
include_once('includes/password.php');
//include('includes/general_functions.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <link href="css/admin.css?v=20160404" rel="stylesheet" type="text/css" />
  <link href="../eligible_check/css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link href="../eligible_check/css/cupertino/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" media="screen">
  <link href="../eligible_check/css/sample_1.css" rel="stylesheet" media="screen">
  <link rel="stylesheet" href="/manage/admin/css/jquery-ui-1.8.22.custom.css" />
  <link rel="stylesheet" href="../css/modal.css" />
  <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
  <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
  <script src="../eligible_check/js/lib/jquery-1.10.2.min.js"></script>
  <script src="../eligible_check/js/lib/jquery-ui-1.10.3.custom.min.js"></script>
  <script type="text/javascript" src="script/validation.js"></script>
  <script src="../eligible_check/js/eligible.js"></script>
  <script src="../eligible_check/js/sample_1.js?v=20160404"></script>
  <script type="text/javascript" src="/manage/includes/modal.js"></script>
  <script type="text/javascript" src="/manage/3rdParty/jscolor/jscolor.js"></script>
</head>
<body>
<div id="coverage_container"></div>
    <?
    $thesql = "select e.*, CONCAT(p.firstname,' ',p.lastname) as pat_name 
                        from dental_eligibility e 
                        JOIN dental_patients p on p.patientid=e.patientid
                        where e.id='".$_REQUEST["id"]."'";
        $themy = mysqli_query($con,$thesql);
        $themyarray = mysqli_fetch_array($themy);
?>
  <h2>Eligibility for <?php echo  $themyarray['pat_name']; ?> - <?php echo  date('m/d/Y h:ia', strtotime($themyarray['adddate'])); ?></h2>
    <a href="patient_eligibility.php?pid=<?=$themyarray['patientid'];?>" class="btn btn-primary" style="margin-bottom:10px;">Return to chart</a>
    <section class="coverage-section"></section>
    <a href="patient_eligibility.php?pid=<?=$themyarray['patientid'];?>" class="btn btn-primary" style="margin-bottom:10px;">Return to chart</a>

<script type="text/javascript">
$(document).ready(function(){
  var coverage = new Coverage(<?php echo  $themyarray['response']; ?>);
  if (coverage.hasError()) {
    buildError(coverage.parseError());
  } else {
    buildCoverageHTML(coverage);
  }
});
</script>
        
</body>
</html>
