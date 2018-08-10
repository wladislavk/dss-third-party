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

    /**
     * @param array $data
     * @return bool
     */
    function setSessionData(array $data)
    {
        if ((int)$data['status'] !== DSS_USER_STATUS_ACTIVE
            || (int)$data['doc_info']['status'] !== DSS_USER_STATUS_ACTIVE) {
            return false;
        }
        $_SESSION['userid'] = $data['userid'];
        $_SESSION['docid'] = $data['doc_info']['userid'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['name'] = $data['name'];
        $_SESSION['user_access'] = $data['user_access'];
        $_SESSION['user_type'] = $data['user_type'];
        return true;
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
        $_SESSION['api_token'] = $_GET['token'];
    }
    $loggedIn = true;
} elseif (isset($_GET['token'])) {
    $result = getUserByToken($_GET['token']);
    if (isset($result['data']['userid'])) {
        $_SESSION['api_token'] = $_GET['token'];
        $loggedIn = setSessionData($result['data']);
    }
} elseif (isset($_SESSION['api_token'])) {
    $result = getUserByToken($_SESSION['api_token']);
    if (isset($result['data']['userid'])) {
        $loggedIn = setSessionData($result['data']);
    }
}

if (!$loggedIn) {
    header('Location: login.php?goto=' . urlencode($_SERVER['REQUEST_URI']));
    trigger_error("Die called", E_USER_ERROR);
}
$db = new Db();
$userId = (int)$_SESSION['userid'];
$docId = (int)$_SESSION['docid'];
$remoteIp = $db->escape($_SERVER['REMOTE_ADDR']);
$db->query("UPDATE dental_users SET last_accessed_date = NOW() WHERE userid = $userId");
$_SESSION['companyid'] = $db->getColumn("SELECT companyid FROM dental_user_company WHERE userid = $docId", 'companyid', 0);
$_SESSION['loginid'] = $db->getInsertId("INSERT INTO dental_login (docid, userid, login_date, ip_address)
        VALUES ($docId, $userId, NOW(), '$remoteIp')");
