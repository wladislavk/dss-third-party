<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/main_include.php';

logoutBO();

?>
<script type="text/javascript">
    alert('Logged out');
    window.location = 'index.php';
</script>
<?php

trigger_error('Die called', E_USER_ERROR);
