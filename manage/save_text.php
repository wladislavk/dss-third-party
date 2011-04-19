<?php 
if(isset($_GET['newText'])){
$newText= $_GET['newText'];
$insertText_sql = 'INSERT INTO `dentalsl_main`.`memo` (`memo`) VALUES('. $newText .')';
$insertText= mysql_query($insertText_sql);
echo $newText;
} else {
echo 'Error! Please fill all fileds!';
}
?>
