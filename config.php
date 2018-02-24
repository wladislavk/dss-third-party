<?php
$dualApp = getenv('DUAL_APP');
define('DUAL_APP', (int)$dualApp);
define('VUE_URL', 'https://vue.docker.localhost/manage/');
define('HEADLESS_VUE_URL', 'http://vue/manage/');
define('API_URL', 'http://api/api/v1/');
