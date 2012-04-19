<?
include "includes/top.htm";
require_once('../includes/constants.inc');
require_once "includes/general.htm";

if(isset($_POST['edit_cat'])){
  $ins = "UPDATE dental_document_category SET
	name = '".mysql_real_escape_string($_POST['name'])."',
	status = '".mysql_real_escape_string($_POST['status'])."'
        WHERE categoryid='".mysql_real_escape_string($_POST['categoryid'])."'
      ;";
  mysql_query($ins);
  ?>
  <script type="text/javascript">
  window.location = 'manage_doc_categories.php?cat=<?= $_POST['categoryid']; ?>';
  </script>
  <?php
}

?>
<?php
  $sql = "SELECT * FROM dental_document_category WHERE categoryid=".$_GET['cat']." ORDER BY name ASC";
  $q = mysql_query($sql);
  $cat = mysql_fetch_assoc($q);

 ?>

<span class="admin_head">Edit Category</span>

<form action="#" method="post">
<input type="hidden" name="categoryid" value="<?= $_GET['cat'];?>" />
<label>Name:</label>
<input type="text" name="name" value="<?= $cat['name']; ?>" />
<br />
<label>Active:</label>
<input type="checkbox" name="status" value="1" <?= ($cat['status'])?'checked="checked"':''; ?> />
<br />
<input type="submit" name="edit_cat" value="Edit" />
<? if( $_SESSION['admin_access']==1 ){ ?>
<a class="editdel" href="manage_doc_categories.php?delid=<?= $cat['categoryid']; ?>" onclick="return confirm('Are you sure you want to delete <?= $cat['name']; ?> and the documents in this category?');">Delete</a>
<? } ?>
</form>



<? include "includes/bottom.htm";?>

