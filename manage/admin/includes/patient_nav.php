<?php namespace Ds3\Libraries\Legacy; ?><?php $file = basename($_SERVER['PHP_SELF']) ?>
    <?
    $thesql = "select * from dental_patients where patientid='".(!empty($_GET["pid"]) ? $_GET["pid"] : '')."'";

        $themyarray = $db->getRow($thesql);
$docsql = "SELECT username, practice FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$themyarray['docid'])."'";

$docr = $db->getRow($docsql);

 ?>
<div class="page-header">
    <h1>Manage Patient - <?php echo  $themyarray['firstname']." ".$themyarray['lastname']; ?> - <?php echo  $docr['username']; ?> - <?php echo  $docr['practice']; ?></h1>
</div>
<div class="navbar navbar-default text-center">
    <a href="view_patient.php?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="btn btn-default navbar-btn <?php echo  ($file == 'view_patient.php' ? 'active' : '') ?>">Patient Info</a>
    <a href="patient_images.php?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="btn btn-default navbar-btn <?php echo  ($file == 'patient_images.php' ? 'active' : '') ?>">Images</a>
    <a href="patient_summary.php?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="btn btn-default navbar-btn <?php echo  ($file == 'patient_summary.php' ? 'active' : '') ?>">Summary Sheet</a>
    <a href="patient_full_summary.php?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="btn btn-default navbar-btn <?php echo  ($file == 'patient_full_summary.php' ? 'active' : '') ?>">Full Summary</a>
    <a href="patient_claims.php?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="btn btn-default navbar-btn <?php echo  ($file == 'patient_claims.php' ? 'active' : '') ?>">Claims</a>
    <a href="patient_eligibility.php?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="btn btn-default navbar-btn <?php echo  ($file == 'patient_eligibility.php' ? 'active' : '') ?>">Eligibility</a>
    <a href="patient_questionnaire.php?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="btn btn-default navbar-btn <?php echo  ($file == 'patient_questionnaire.php' ? 'active' : '') ?>">Questionnaire</a>
    <a href="patient_clinical_exam.php?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="btn btn-default navbar-btn <?php echo  ($file == 'patient_clinical_exam.php' ? 'active' : '') ?>">Clinical Exam</a>
    <a href="patient_screener.php?pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>" class="btn btn-default navbar-btn <?php echo  ($file == 'patient_screener.php' ? 'active' : '') ?>">Screener</a>
</div>
