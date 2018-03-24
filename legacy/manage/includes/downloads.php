<?php namespace Ds3\Libraries\Legacy; ?><?php
	include_once('../admin/includes/main_include.php');
	include("sescheck.php");

	if(isset($_GET['id'])) {
		// if id is set then get the file with the id from database
		$id    = $_GET['id'];
		$query = "SELECT name, type, size, content FROM filemanager WHERE id = '$id'";

		$list_result = $db->getRow($query);
		$name = $list_result['name'];
		$type = $list_result['type'];
		$size = $list_result['size'];
		$content = $list_result['content'];

		header("Content-length: $size");
		header("Content-type: $type");
		header("Content-Disposition: attachment; filename=$name");
		echo $content;
		trigger_error("Exit called", E_USER_ERROR);
	}
?>
