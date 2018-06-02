<?php
namespace Ds3\Libraries\Legacy;

include_once __DIR__ . '/../admin/includes/main_include.php';
include_once __DIR__ . '/../../config.php';

if (!attemptUserLogin($_GET)) {
    header('Location: login.php?goto=' . generateRedirectQuery());
    trigger_error('Die called', E_USER_ERROR);
}
$db = new Db();
$db->query("UPDATE dental_users SET last_accessed_date = NOW() WHERE userid=" . (int)$_SESSION['userid']);
