<?php namespace Ds3\Legacy; ?><?php
include "includes/top.htm";
require_once('../includes/constants.inc');
require_once "includes/general.htm";

if(isset($_GET['delid']) && is_super($_SESSION['admin_access'])){

$del = "DELETE FROM dental_document_category WHERE categoryid='".mysqli_real_escape_string($con,$_GET['delid'])."'";
mysqli_query($con,$del);
$deldoc = "DELETE FROM dental_document WHERE categoryid='".mysqli_real_escape_string($con,$_GET['delid'])."'";
mysqli_query($con,$deldoc);
}


if(isset($_POST['add_cat'])){
  $ins = "INSERT INTO dental_document_category (
	name,
	status,
	adddate,
	ip_address
      ) VALUES (
	'".mysqli_real_escape_string($con,$_POST['name'])."',
	'".mysqli_real_escape_string($con,$_POST['status'])."',
        now(),
	'".$_SERVER['REMOTE_ADDR']."'
      );";
  mysqli_query($con,$ins);
?>
<script type="text/javascript">
  window.location = 'manage_doc_categories.php';
</script>
<?php

}

?>

<div class="page-header">Categories</div>

<?php if(is_super($_SESSION['admin_access'])){ ?>
<strong>Add a Category to the File Structure</strong>
<form action="#" method="post" onsubmit="return check_add();">
<label>Name:</label> <input type="text" id="name" name="name" />
<label>Active:</label> <input type="checkbox" name="status" value="1" checked="checked" />
<input type="submit" name="add_cat" value="Add" class="btn btn-success">
</form>

<script type="text/javascript">
  function check_add(){
    if($("#name").val()==""){
      alert("Name is required.");
      return false;
    }
    return true;
  }
</script>
<?php } ?>

<table class="table table-bordered table-hover">
        <tr class="tr_bg_h">
                <td valign="top" class="col_head" width="60%">
                       Name 
                </td>
		<td valign="top" class="col_head" width="20%">
			Status
		</td>
                <td valign="top" class="col_head" width="20%">
                        Action
                </td>
		
        </tr>

<?php
  $sql = "SELECT * FROM dental_document_category ORDER BY name ASC";
  $q = mysqli_query($con,$sql);
  while($cat = mysqli_fetch_assoc($q)){
	?>
	<tr class="<?php echo  ($cat['status'])?'tr_active':'tr_inactive'; ?>">
		<td>
			<?php echo  $cat['name']; ?>
                </td>
                <td>
			<?php echo  ($cat['status'])?'Active':'Inactive'; ?>
                </td>
		<td>
			<?php if(is_super($_SESSION['admin_access'])){ ?>
			<a href="manage_doc_cat_edit.php?cat=<?php echo  $cat['categoryid'];?>" class="btn btn-primary btn-xs">
                <span class="glyphicon glyphicon-pencil"></span>
                Edit
            </a>
			<?php } ?>
			<a href="manage_docs.php?cat=<?php echo  $cat['categoryid']; ?>" class="btn btn-default btn-xs">
                <span class="glyphicon glyphicon-eye-open"></span>
                View
            </a>
		</td>
        </tr>


<?php



  }
 ?>

</table>

<?php include "includes/bottom.htm";?>

