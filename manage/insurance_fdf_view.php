<?php namespace Ds3\Legacy; ?><?php
header("Content-type: application/vnd.fdf");
header('Content-Disposition: attachment; filename="file.fdf"');
$f = $_GET['file'];
$handle = fopen('../../../shared/q_file/'.$f, 'r');
$contents = '';
while (!feof($handle)) {
  $contents .= fread($handle, 8192);
}
fclose($handle);
echo $contents;

?>
