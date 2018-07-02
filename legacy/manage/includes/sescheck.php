<?php
namespace Ds3\Libraries\Legacy;

include_once __DIR__ . '/../admin/includes/main_include.php';
include_once __DIR__ . '/../../config.php';

if (!function_exists('getUserByToken')) {
    function getUserByToken($token)
    {
        $handle = curl_init(API_URL . 'users/current');
        curl_setopt($handle, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token]);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $result = json_decode(curl_exec($handle), true);
        curl_close($handle);
        return $result;
    }

    function setSessionData(array $data)
    {
        $_SESSION['userid'] = intval($data['userid']);
        $_SESSION['docid'] = intval($data['docid']);
        $_SESSION['username'] = $data['username'];
    }
}

$loggedIn = false;

if (
    isset($_SESSION['userid']) &&
    isset($_SESSION['docid']) &&
    isset($_SESSION['username']) &&
    $_SESSION['username']
) {
    if (isset($_GET['token'])) {
        $_SESSION['token'] = $_GET['token'];
    }
    $loggedIn = true;
} elseif (isset($_GET['token'])) {
    $result = getUserByToken($_GET['token']);
    if (isset($result['data']['userid'])) {
        $_SESSION['token'] = $_GET['token'];
        setSessionData($result['data']);
        $loggedIn = true;
    }
} elseif (isset($_SESSION['token'])) {
    $result = getUserByToken($_SESSION['token']);
    if (isset($result['data']['userid'])) {
        setSessionData($result['data']);
        $loggedIn = true;
    }
}

if ($loggedIn) {
    $db = new Db();
    $db->query("UPDATE dental_users SET last_accessed_date = NOW() WHERE userid='" . $db->escape($_SESSION['userid']) . "'");
} else {
    header('Location: login.php?goto=' . urlencode($_SERVER['REQUEST_URI']));
    trigger_error("Die called", E_USER_ERROR);
}
