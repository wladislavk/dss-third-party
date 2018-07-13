<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/main_include.php';
require_once __DIR__ . '/../includes/constants.inc';

$db = new Db();

$userId = intval($_GET['id']);
$validInterval = 'DATE_ADD(recover_time, INTERVAL 1 HOUR)';
$check_sql = "SELECT
        userid, username, email,
        first_name, last_name,
        recover_hash,
        NOW() <= $validInterval AS valid
    FROM dental_users
    WHERE userid = '$userId'";
$check_myarray = $db->getRow($check_sql);

if ($check_myarray) {
    if (!$check_myarray['valid']) {
        $recover_hash = hash('sha256', $check_myarray['userid'] . $check_myarray['email'] . rand());
        $check_myarray['recover_hash'] = $recover_hash;
        $db->query("UPDATE dental_users
            SET recover_hash = '$recover_hash', recover_time = NOW()
            WHERE userid = '" . intval($check_myarray['userid']) . "'");
    }

    $from = 'Dental Sleep Solutions <patient@dentalsleepsolutions.com>';
    $to = "{$check_myarray['first_name']} {$check_myarray['last_name']} <{$check_myarray['email']}>";
    $subject = "Dental Sleep Solutions Password Reset";
    $template = getTemplate('user/reset-password');

    sendEmail($from, $to, $subject, $template, $check_myarray);
    ?>
    <br />
    <h3>Password reset and user has been emailed.</h3>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}
