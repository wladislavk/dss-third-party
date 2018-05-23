<?php
namespace Ds3\Libraries\Legacy;
set_time_limit(0);
require_once __DIR__ . '/includes/top.htm';
?>

    <link rel="stylesheet" href="css/manage_profile.css" type="text/css" />

    <span class="admin_head">
  Update Stripe Information
</span>
    <br />
    <br />
    &nbsp;
    <a href="manage_profile.php"> Back to Manage Profile</a>
    <br />


    <div class="fullwidth">
        <hr />
        <?php require_once __DIR__ . '/stripe_card_info.php'; ?>
    </div>

    <?php
require_once __DIR__ . '/signature_test.php';
require_once __DIR__ . '/includes/bottom.htm';
