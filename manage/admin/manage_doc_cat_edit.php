<?php namespace Ds3\Legacy; ?><?
include "includes/top.htm";
include_once('../includes/constants.inc');
include_once "includes/general.htm";

if(isset($_POST['edit_cat'])){
  $ins = "UPDATE dental_document_category SET
	name = '".mysqli_real_escape_string($con,$_POST['name'])."',
	status = '".mysqli_real_escape_string($con,$_POST['status'])."'
        WHERE categoryid='".mysqli_real_escape_string($con,$_POST['categoryid'])."'
      ;";
  mysqli_query($con,$ins);
  ?>
  <script type="text/javascript">
  window.location = 'manage_doc_categories.php?cat=<?php echo  $_POST['categoryid']; ?>';
  </script>
  <?php
}

?>
<?php
  $sql = "SELECT * FROM dental_document_category WHERE categoryid=".$_GET['cat']." ORDER BY name ASC";
  $q = mysqli_query($con,$sql);
  $cat = mysqli_fetch_assoc($q);

 ?>

<div class="page-header">Edit Category</div>

<form action="#" method="post">
<input type="hidden" name="categoryid" value="<?php echo  $_GET['cat'];?>" />
<label>Name:</label>
<input type="text" name="name" value="<?php echo  $cat['name']; ?>" />
<br />
<label>Active:</label>
<input type="checkbox" name="status" value="1" <?php echo  ($cat['status'])?'checked="checked"':''; ?> />
<br />
<input type="submit" name="edit_cat" value="Edit" class="btn btn-primary">
<?php if( $_SESSION['admin_access']==1 ){ ?>
<a class="editdel" href="manage_doc_categories.php?delid=<?php echo  $cat['categoryid']; ?>" onclick="return confirm('Are you sure you want to delete <?php echo  $cat['name']; ?> and the documents in this category?');">Delete</a>
<?php } ?>
</form>



<?php include "includes/bottom.htm";?>

