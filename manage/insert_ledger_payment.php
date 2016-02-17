<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/admin/includes/main_include.php';
require_once __DIR__ . '/includes/sescheck.php';
require_once __DIR__ . '/admin/includes/ledger-functions.php';

$paymentIds = [];

if (!empty($_POST['payments'])) {
    $paymentIds = insertLedgerPayments (0, $_POST['payments'], 0, 0, $_SESSION['userid'], $_SESSION['adminid']);
}

if (empty($paymentIds)) {
    $alertMessage = 'It was no possible to add any payments due technical reasons. Please verify the amounts and try again.';
} else {
    $alertMessage = count($paymentIds) . ' payment(s) added successfully.';
}

?>
<script>
    function eraseCookie (name) {
        var date = new Date();
        date.setTime(date.getTime() + (-24*60*60*1000));
        document.cookie = name + "=; expires=" + date.toGMTString() + "; path=/";
    }
    eraseCookie('tempforledgerentry');
    alert('<?= e($alertMessage) ?>');
    parent.window.location = parent.window.location;
</script>
