<?php
namespace Ds3\Libraries\Legacy;

session_start();

require_once 'main_include.php';
require_once '../../includes/constants.inc';
require 'access.php';

$oid = $db->escape($_REQUEST['oid']);
$nid = $db->escape($_REQUEST['nid']);
$cur = $db->escape($_REQUEST['cur']);

$old = $db->getRow("SELECT company_type from companies where id = '$oid'");
$new = $db->getRow("SELECT company_type from companies where id = '$nid'");

$admin_access = $cur ?: $_SESSION['admin_access'];

if ($old == $new) {
    $fields = '';
} else {
    ob_start();

    ?>
    <option value="">Select Access</option>
    <?php if (is_super($_SESSION['admin_access'])) { ?>
        <option value="<?= DSS_ADMIN_ACCESS_SUPER ?>"
            <?= $admin_access == DSS_ADMIN_ACCESS_SUPER ? 'selected' : '' ?>>Super</option>
    <?php } ?>
    <?php if (is_admin($_SESSION['admin_access'])) { ?>
        <option value="<?= DSS_ADMIN_ACCESS_ADMIN ?>"
            <?= $admin_access == DSS_ADMIN_ACCESS_ADMIN ? 'selected' : '' ?>>Admin</option>
    <?php } ?>
    <?php if (is_super($_SESSION['admin_access']) || is_software($_SESSION['admin_access'])) { ?>
        <option value="<?= DSS_ADMIN_ACCESS_BASIC ?>"
            <?= $admin_access == DSS_ADMIN_ACCESS_BASIC ? 'selected' : '' ?>>Basic</option>
    <?php } ?>
    <?php if (is_super($_SESSION['admin_access']) || is_billing_admin($_SESSION['admin_access'])) { ?>
        <option value="<?= DSS_ADMIN_ACCESS_BILLING_ADMIN ?>"
            <?= $admin_access == DSS_ADMIN_ACCESS_BILLING_ADMIN ? 'selected' : '' ?>>Billing Admin</option>
    <?php } ?>
    <?php if (is_super($_SESSION['admin_access']) || is_billing($_SESSION['admin_access'])) { ?>
        <option value="<?= DSS_ADMIN_ACCESS_BILLING_BASIC ?>"
            <?= $admin_access == DSS_ADMIN_ACCESS_BILLING_BASIC ? 'selected' : '' ?>>Billing Basic</option>
    <?php } ?>
    <?php if (is_super($_SESSION['admin_access']) || is_hst_admin($_SESSION['admin_access'])) { ?>
        <option value="<?= DSS_ADMIN_ACCESS_HST_ADMIN ?>"
            <?= $admin_access == DSS_ADMIN_ACCESS_HST_ADMIN ? 'selected' : '' ?>>HST Admin</option>
    <?php } ?>
    <?php if (is_super($_SESSION['admin_access']) || is_hst($_SESSION['admin_access'])) { ?>
        <option value="<?= DSS_ADMIN_ACCESS_HST_BASIC ?>"
            <?= $admin_access == DSS_ADMIN_ACCESS_HST_BASIC ? 'selected' : '' ?>>HST Basic</option>
    <?php } ?>
    <?php

    $fields = ob_get_clean();
}

echo @json_encode(['change' => $fields]);
