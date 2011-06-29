<?
include "includes/top.htm";
require_once('../includes/constants.inc');
require_once "includes/general.htm";

if(isset($_POST['add_cat'])){
  $ins = "INSERT INTO dental_document_category (
	name,
	status,
	adddate,
	ip_address
      ) VALUES (
	'".mysql_real_escape_string($_POST['name'])."',
	'".mysql_real_escape_string($_POST['status'])."',
        now(),
	'".$_SERVER['REMOTE_ADDR']."'
      );";
  mysql_query($ins);
?>
<script type="text/javascript">
  window.location = 'manage_doc_categories.php';
</script>
<?php

}

?>

<span class="admin_head">Categories</span>

<strong>Add Category</strong>
<form action="#" method="post">
<label>Name:</label> <input type="text" name="name" />
<label>Active:</label> <input type="checkbox" name="status" value="1" checked="checked" />
<input type="submit" name="add_cat" value="Add" />
</form>


<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
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
  $q = mysql_query($sql);
  while($cat = mysql_fetch_assoc($q)){
	?>
	<tr class="<?= ($cat['status'])?'tr_active':'tr_inactive'; ?>">
		<td>
			<?= $cat['name']; ?>
                </td>
                <td>
			<?= ($cat['status'])?'Active':'Inactive'; ?>
                </td>
		<td>
			<a href="manage_doc_cat_edit.php?cat=<?= $cat['categoryid'];?>">Edit</a>
			<a href="manage_docs.php?cat=<?= $cat['categoryid']; ?>">View</a>
		</td>
        </tr>


<?php



  }
 ?>

</table>

<? include "includes/bottom.htm";?>

