$(document).ready(function(){
 	setup_autocomplete('account_name', 'account_hints', 'fid', '', 'list_accounts.php', 'contact', '<?php echo  $_GET['pid']; ?>');
});