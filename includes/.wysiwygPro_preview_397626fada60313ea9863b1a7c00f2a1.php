<?php namespace Ds3\Libraries\Legacy; ?><?php
if ($_GET['randomId'] != "4xWPwTcHoQRM8pjq3_RiotCgpauc7bkhwK0YVzOhQFBsISHuUb8wWMMwC8On2XVO") {
    echo "Access Denied";
    trigger_error("Exit called", E_USER_ERROR);
}

// display the HTML code:
echo stripslashes($_POST['wproPreviewHTML']);

?>  
