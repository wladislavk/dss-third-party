<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/admin/includes/main_include.php';

logoutFO();

?>
<script type="text/javascript">
    alert('Logout Successfully');
    window.location = 'login.php';
</script>
<?php

trigger_error('Die called', E_USER_ERROR);
