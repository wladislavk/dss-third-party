<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/admin/includes/main_include.php';
require_once __DIR__ . '/includes/sescheck.php';
require_once __DIR__ . '/includes/edx_functions.php';

$userId = intval($_SESSION['userid']);

edx_user_update($userId);
$sessionId = edx_user_login($userId);
$expire = time() + 60 * 60 * 2;

switch ($_SERVER['HTTP_HOST']) {
    case 'dentalsleepsolutions.com':
    case 'www.dentalsleepsolutions.com':
        $domain = 'dentalsleepsolutions.com';
        $redirection = 'http://education.dentalsleepsolutions.com';
        break;
    case 'xforty.com':
    case 'preprod.dss.xforty.com':
    case 'staging.dss-rh.xforty.com':
        $domain = 'xforty.com';
        $redirection = 'http://preprod.edx.dss.xforty.com';
        break;
    default:
        $domain = 'xforty.com';
        $redirection = 'http://staging1.edx.dss.xforty.com';
}

setcookie('edxloggin', 'true', $expire, '/', $domain, false);
setcookie('sessionid', $sessionId, $expire, '/', $domain, false);

?>
<script type="text/javascript">
    window.location = '<?= $redirection ?>/dashboard';
</script>