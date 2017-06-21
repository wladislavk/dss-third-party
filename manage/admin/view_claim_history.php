<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';

$claimId = intval($_GET['id']);
$is_front_office = false;
$is_back_office = true;

?>
<div class="page-header">
    <h1>
        Claim History for claim ID <code><?= $claimId ?></code>
    </h1>
</div>
<?php

require_once __DIR__ . '/../claim_history_data.php';
require_once __DIR__ . '/includes/bottom.htm';
