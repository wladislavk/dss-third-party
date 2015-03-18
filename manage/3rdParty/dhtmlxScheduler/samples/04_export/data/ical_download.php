<?php namespace Ds3\Libraries\Legacy; ?><?php
if(empty($_POST['data'])) {
	trigger_error("Exit called", E_USER_ERROR);
}

$filename = "data.ical";

header("Cache-Control: ");
header("Content-type: text/plain");
header('Content-Disposition: attachment; filename="'.$filename.'"');

echo $_POST['data'];

?>
