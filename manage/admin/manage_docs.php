<?
include "includes/top.htm";
require_once('../includes/constants.inc');
require_once "includes/general.htm";
if(isset($_GET['delid']) && is_super($_SESSION['admin_access'])){
$del = "DELETE FROM dental_document WHERE documentid='".mysql_real_escape_string($_GET['delid'])."'";
mysql_query($del);


}


if(isset($_POST['add_doc'])){
                        $fname = $_FILES["attachment"]["name"];
                        $lastdot = strrpos($fname,".");
                        $name = substr($fname,0,$lastdot);
                        $extension = substr($fname,$lastdot+1);
                        $banner1 = $name.'_'.date('dmy_Hi');
                        $banner1 = str_replace(" ","_",$banner1);
                        $banner1 = str_replace(".","_",$banner1);
                        $banner1 .= ".".$extension;

                        @move_uploaded_file($_FILES["attachment"]["tmp_name"],"../../../../shared/q_file/".$banner1);
                        @chmod("../../../../shared/q_file/".$banner1,0777);


  $ins = "INSERT INTO dental_document (
        name,
        categoryid,
        filename,
        adddate,
        ip_address
      ) VALUES (
        '".mysql_real_escape_string($_POST['name'])."',
        '".mysql_real_escape_string($_POST['category'])."',
        '".$banner1."',
        now(),
        '".$_SERVER['REMOTE_ADDR']."'
      );";
  mysql_query($ins);
?>
<script type="text/javascript">
  window.location = 'manage_docs.php<?= (isset($_GET['cat']))?'?cat='.$_GET['cat']:''; ?>';
</script>
<?php

}

?>

<div class="page-header">Documents</div>

<?php if(is_super($_SESSION['admin_access'])){ ?>
<strong>Add Document</strong> 
<form action="#" method="post" enctype="multipart/form-data">
<label>Name:</label> <input type="text" name="name" />
 <?php
  if(isset($_GET['cat'])){ ?>
    <input type="hidden" name="category" value="<?= $_GET['cat']; ?>" />
  <?php }else{ 
    $cs = "SELECT * FROM dental_document_category ORDER BY name ASC";
    $cq = mysql_query($cs);
    ?><label>Category:</label> <select name="category"><?php
    while($c = mysql_fetch_assoc($cq)){ ?>
	<option value="<?= $c['categoryid']; ?>"><?= $c['name']; ?></option>
    <?php } ?>	
    </select>
  <?php } ?>

<label>File:</label> <input type="file" name="attachment" />
<input type="submit" name="add_doc" value="Add" />
</form>
<?php } ?>

<table class="table table-bordered table-hover">
        <tr class="tr_bg_h">
                <td valign="top" class="col_head" width="60%">
                       Name
                </td>
                <?php if(!isset($_GET['cat'])){ ?>
                  <td valign="top" class="col_head" width="20%">
                        Category 
                  </td>
                <?php } ?>
                <td valign="top" class="col_head" width="20%">
                        Action
                </td>
                
        </tr>

<?php
  $sql = "SELECT d.*, c.name as categoryname FROM dental_document d INNER JOIN dental_document_category c ON d.categoryid=c.categoryid";
  if(isset($_GET['cat'])){
    $sql .= " WHERE d.categoryid=".mysql_real_escape_string($_GET['cat'])." ";
  }
  $sql .= " ORDER BY d.name ASC";
  $q = mysql_query($sql);
  while($doc = mysql_fetch_assoc($q)){
        ?>
        <tr class="tr_active">
                <td>
                        <?= $doc['name']; ?>
                </td>
                <?php if(!isset($_GET['cat'])){ ?>
                <td>
                        <?= $doc['categoryname']; ?>
                </td>
		<?php } ?>
                <td>
			<?php if(is_super($_SESSION['admin_access'])){ ?>
                        <a href="manage_docs_edit.php?doc=<?= $doc['documentid']; ?>" />Edit</a>
			<?php } ?>
                        <a target="_blank" href="display_file.php?f=<?= $doc['filename']; ?>">View</a>
                </td>
        </tr>


<?php
} ?>

</table>

<? include "includes/bottom.htm";?>


 
