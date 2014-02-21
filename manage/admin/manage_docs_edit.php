<?
include "includes/top.htm";
require_once('../includes/constants.inc');
require_once "includes/general.htm";

if(isset($_POST['edit_doc'])){
      if($_FILES['attachment']['name']!=''){
                        $fname = $_FILES["attachment"]["name"];
                        $lastdot = strrpos($fname,".");
                        $name = substr($fname,0,$lastdot);
                        $extension = substr($fname,$lastdot+1);
                        $banner1 = $name.'_'.date('dmy_Hi');
                        $banner1 = str_replace(" ","_",$banner1);
                        $banner1 = str_replace(".","_",$banner1);
                        $banner1 .= ".".$extension;

                        @move_uploaded_file($_FILES["attachment"]["tmp_name"],"../q_file/".$banner1);
                        @chmod("../q_file/".$banner1,0777);
          $fsql = " filename='".$banner1."',";
      }else{
        $fsql = '';
      }
  $ed = "UPDATE dental_document SET
  	name = '".mysql_real_escape_string($_POST['name'])."',
        ".$fsql."
        categoryid = '".mysql_real_escape_string($_POST['category'])."'
        where documentid='".mysql_real_escape_string($_GET['doc'])."'
        ";
  mysql_query($ed);
?>
	<script type="text/javascript">
		window.location = "manage_docs.php?cat=<?= $_POST['category']; ?>"
	</script>

<?php

}


$ds = "SELECT * FROM dental_document WHERE documentid=".mysql_real_escape_string($_GET['doc']);
$dq = mysql_query($ds);
$doc = mysql_fetch_assoc($dq);
?>

<div class="page-header">Edit Document</div>

<form action="#" method="post" enctype="multipart/form-data">
<label>Name:</label> <input type="text" name="name" value="<?= $doc['name']; ?>" />
<br />
  <?php  
    $cs = "SELECT * FROM dental_document_category ORDER BY name ASC";
    $cq = mysql_query($cs);
    ?><label>Category:</label> <select name="category"><?php
    while($c = mysql_fetch_assoc($cq)){ ?>
	<option <?= ($c['categoryid']==$doc['categoryid'])?'selected="selected"':''; ?> value="<?= $c['categoryid']; ?>"><?= $c['name']; ?></option>
    <?php } ?>	
    </select>
<br />
<label>File:</label> <input type="file" name="attachment" />
<br />
<input type="submit" name="edit_doc" value="Edit" />
<a class="editdel" href="manage_docs.php?cat=<?= $_GET['cat']; ?>&delid=<?= $doc['documentid']; ?>" onclick="return confirm('Are you sure you want to delete <?= $doc['name']; ?>');">Delete</a>

</form>


                

<? include "includes/bottom.htm";?>


 
