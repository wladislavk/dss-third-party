<?php 

include_once $_SERVER['DOCUMENT_ROOT'] . '/manage/admin/includes/config.php';
$db = new Db();

if(isset($_GET['newText'])){
	$newText= $_GET['newText'];
	$insertText_sql = 'INSERT INTO `memo` (`memo`) VALUES('. $newText .')';
	$insertText= $db->query($insertText_sql);
	echo $newText;
} else {
	echo 'Error! Please fill all fileds!';
} 
?>