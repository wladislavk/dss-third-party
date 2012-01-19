<?php session_start();
  if(!isset($_SESSION['pid'])){
    ?><script type="text/javascript">window.location = "login.php";</script><?php
    die();
  }

include 'includes/header.php';
?>
Patient Home

<ul>
  <li><a href="symptoms.php">Symptoms</a></li>
  <li><a href="treatments.php">Previous Treatments</a></li>
  <li><a href="history.php">Social Health History</a></li>
</ul>

<?php
include 'includes/footer.php';
?>
