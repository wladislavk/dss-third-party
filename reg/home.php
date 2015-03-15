<?php namespace Ds3\Libraries\Legacy; ?><?php session_start();
  if(!isset($_SESSION['pid'])){
    ?><script type="text/javascript">window.location = "login.php";</script><?php
    die();
  }

include 'includes/header.php';
include 'includes/completed.php';
?>
Patient Home <?= $_SESSION['pid']; ?>

<div style="font-size:20px;"><?= $comp_perc; ?>% completed</div>
<ul>
  <li><a href="register.php" <?= ($comp['registered'])?'':'class="incomplete"'; ?>>Registration</a></li>
  <li><a href="symptoms.php" <?= ($comp['symptoms'])?'':'class="incomplete"'; ?>>Symptoms</a></li>
  <li><a href="sleep.php" <?= ($comp['epworth'])?'':'class="incomplete"'; ?>>Epworth/Thornton Scale</a></li>
  <li><a href="treatments.php" <?= ($comp['treatments'])?'':'class="incomplete"'; ?>>Previous Treatments</a></li>
  <li><a href="history.php" <?= ($comp['history'])?'':'class="incomplete"'; ?>>Social Health History</a></li>
</ul>

<?php
include 'includes/footer.php';
?>
