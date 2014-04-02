<?php 
require_once('classes/tc_calendar.php');
include 'includes/top.htm';?>
<?php if(is_billing($_SESSION['admin_access']) || is_hst($_SESSION['admin_access'])){ ?>

<h1>Welcome to the DS3 backoffice system.</h1>
<p>Any unauthorized use of this system is strictly prohibited. By accessing this system you are bound to the user agreement terms as well as all applicable HIPAA-HiTECH regulations. Please take all possible measures to ensure patient data is protected at all times.</p>


<?php }else{ ?>
                <center><B>Welcome</B></center> <p>&nbsp;</p>
		
<br /><br />
<?php } ?>
<? include 'includes/bottom.htm';?>
