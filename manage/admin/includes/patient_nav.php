<?php $file = basename($_SERVER['PHP_SELF']) ?>
<div class="page-header">
    <h1>Manage Patient</h1>
</div>
<div class="navbar navbar-default text-center">
    <a href="view_patient.php?pid=<?= $_GET['pid']; ?>" class="btn btn-default navbar-btn <?= ($file == 'view_patient.php' ? 'active' : '') ?>">Patient Info</a>
    <a href="patient_images.php?pid=<?= $_GET['pid']; ?>" class="btn btn-default navbar-btn <?= ($file == 'patient_images.php' ? 'active' : '') ?>">Images</a>
    <a href="patient_summary.php?pid=<?= $_GET['pid']; ?>" class="btn btn-default navbar-btn <?= ($file == 'patient_summary.php' ? 'active' : '') ?>">Summary Sheet</a>
    <a href="patient_full_summary.php?pid=<?= $_GET['pid']; ?>" class="btn btn-default navbar-btn <?= ($file == 'patient_full_summary.php' ? 'active' : '') ?>">Full Summary</a>
</div>
