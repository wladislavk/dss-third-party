<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/admin/includes/main_include.php';
require_once __DIR__ . '/includes/sescheck.php';
require_once __DIR__ . '/includes/claim_functions.php';
require_once __DIR__ . '/admin/includes/claim_functions.php';
require_once __DIR__ . '/admin/includes/ledger-functions.php';

insertLedgerPayments(0, $_POST['payments'], 0, 0, $_SESSION['userid'], $_SESSION['adminid']);

?>
<script type="text/javascript">
    parent.window.location = parent.window.location;
</script>
