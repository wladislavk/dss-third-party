<?php
$dualApp = getenv('DUAL_APP');
$vueUrl = getenv('VUE_URL');
$isDockerUsed = getenv('IS_DOCKER_USED');
$headlessVueUrl = $vueUrl;
$apiUrl = getenv('API_URL');
if ($isDockerUsed) {
    $apiContainer = getenv('API_CONTAINER');
    $vueContainer = getenv('VUE_CONTAINER');
    $headlessVueUrl = 'http://' . $vueContainer . '/';
    $apiUrl = 'http://' . $apiContainer . '/';
}

define('DUAL_APP', (int)$dualApp);
define('VUE_URL', $vueUrl . 'manage/');
define('HEADLESS_VUE_URL', $headlessVueUrl . 'manage/');
define('API_URL', $apiUrl . 'api/v1/');
