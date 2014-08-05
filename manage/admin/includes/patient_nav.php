<?php $file = basename($_SERVER['PHP_SELF']) ?>
    <?
    $thesql = "select * from dental_patients where patientid='".$_REQUEST["pid"]."'";
        $themy = mysql_query($thesql);
        $themyarray = mysql_fetch_array($themy);
$docsql = "SELECT username, practice FROM dental_users WHERE userid='".mysql_real_escape_string($themyarray['docid'])."'";
$docq = mysql_query($docsql);
$docr = mysql_fetch_assoc($docq);

 ?>
<div class="page-header">
    <h1>Manage Patient - <?= $themyarray['firstname']." ".$themyarray['lastname']; ?> - <?= $docr['username']; ?> - <?= $docr['practice']; ?></h1>
</div>
<div class="navbar navbar-default text-center">
    <a href="view_patient.php?pid=<?= $_GET['pid']; ?>" class="btn btn-default navbar-btn <?= ($file == 'view_patient.php' ? 'active' : '') ?>">Patient Info</a>
    <a href="patient_images.php?pid=<?= $_GET['pid']; ?>" class="btn btn-default navbar-btn <?= ($file == 'patient_images.php' ? 'active' : '') ?>">Images</a>
    <a href="patient_summary.php?pid=<?= $_GET['pid']; ?>" class="btn btn-default navbar-btn <?= ($file == 'patient_summary.php' ? 'active' : '') ?>">Summary Sheet</a>
    <a href="patient_full_summary.php?pid=<?= $_GET['pid']; ?>" class="btn btn-default navbar-btn <?= ($file == 'patient_full_summary.php' ? 'active' : '') ?>">Full Summary</a>
    <a href="patient_claims.php?pid=<?= $_GET['pid']; ?>" class="btn btn-default navbar-btn <?= ($file == 'patient_claims.php' ? 'active' : '') ?>">Claims</a>
    <a href="patient_eligibility.php?pid=<?= $_GET['pid']; ?>" class="btn btn-default navbar-btn <?= ($file == 'patient_eligibility.php' ? 'active' : '') ?>">Eligibility</a>
    <a href="patient_questionnaire.php?pid=<?= $_GET['pid']; ?>" class="btn btn-default navbar-btn <?= ($file == 'patient_questionnaire.php' ? 'active' : '') ?>">Questionnaire</a>
    <a href="patient_clinical_exam.php?pid=<?= $_GET['pid']; ?>" class="btn btn-default navbar-btn <?= ($file == 'patient_clinical_exam.php' ? 'active' : '') ?>">Clinical Exam</a>
    <a href="patient_screener.php?pid=<?= $_GET['pid']; ?>" class="btn btn-default navbar-btn <?= ($file == 'patient_screener.php' ? 'active' : '') ?>">Screener</a>
</div>
