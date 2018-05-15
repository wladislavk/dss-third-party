<?php
include_once __DIR__ . '/../../config.php';
function dualAppRedirect($path)
{
    if (!DUAL_APP) {
        return;
    }
    $vueUrl = HEADLESS_VUE_URL;
    if ($_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        $vueUrl = VUE_URL;
    }
    session_start();
    header("HTTP/1.1 301 Moved Permanently");
    $separator = '?';
    if (strstr($path, '?')) {
        $separator = '&';
    }
    $token = (isset($_SESSION['token']) ? $_SESSION['token'] : '');
    header("Location: {$vueUrl}{$path}{$separator}token={$token}");
    exit;
}
