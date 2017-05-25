<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';

$claimId = intval($_GET['id']);

?>
<h1>
    Claim history for claim ID <code><?= $claimId ?></code>
</h1>
<?php

require_once __DIR__ . '/../claim_history_data.php';
require_once __DIR__ . '/includes/bottom.htm';
