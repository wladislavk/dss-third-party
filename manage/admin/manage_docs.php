<?php
include "includes/top.htm";
include_once('../includes/constants.inc');
include_once "includes/general.htm";
if(isset($_GET['delid']) && is_super($_SESSION['admin_access'])){
$del = "DELETE FROM dental_document WHERE documentid='".mysqli_real_escape_string($con,$_GET['delid'])."'";
mysqli_query($con,$del);


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
        '".mysqli_real_escape_string($con,$_POST['name'])."',
        '".mysqli_real_escape_string($con,$_POST['category'])."',
        '".$banner1."',
        now(),
        '".$_SERVER['REMOTE_ADDR']."'
      );";
  mysqli_query($con,$ins);
?>
<script type="text/javascript">
  window.location = 'manage_docs.php<?php echo  (isset($_GET['cat']))?'?cat='.$_GET['cat']:''; ?>';
</script>
<?php

}

?>

<div class="page-header">Documents</div>

<?php if(is_super($_SESSION['admin_access'])){ ?>
<strong>Add Document</strong> 
<form action="#" method="post" enctype="multipart/form-data" onsubmit="return check_add()">
<label>Name:</label> <input type="text" name="name" id="name" />
 <?php
  if(isset($_GET['cat'])){ ?>
    <input type="hidden" name="category" value="<?php echo  $_GET['cat']; ?>" />
  <?php }else{ 
    $cs = "SELECT * FROM dental_document_category ORDER BY name ASC";
    $cq = mysqli_query($con,$cs);
    ?><label>Category:</label> <select name="category"><?php
    while($c = mysqli_fetch_assoc($cq)){ ?>
	<option value="<?php echo  $c['categoryid']; ?>"><?php echo  $c['name']; ?></option>
    <?php } ?>	
    </select>
  <?php } ?>

<label>File:</label> <input type="file" id="attachment" name="attachment" />
<input type="submit" name="add_doc" value="Add" class="btn btn-success">
</form>

<script type="text/javascript">
  function check_add(){
    if($("#name").val()=="" || $("#attachment").val()==""){
      alert("Name and File are required.");
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
    $sql .= " WHERE d.categoryid=".mysqli_real_escape_string($con,$_GET['cat'])." ";
  }
  $sql .= " ORDER BY d.name ASC";
  $q = mysqli_query($con,$sql);
  while($doc = mysqli_fetch_assoc($q)){
        ?>
        <tr class="tr_active">
                <td>
                        <?php echo  $doc['name']; ?>
                </td>
                <?php if(!isset($_GET['cat'])){ ?>
                <td>
                        <?php echo  $doc['categoryname']; ?>
                </td>
		<?php } ?>
                <td>
			<?php if(is_super($_SESSION['admin_access'])){ ?>
                        <a href="manage_docs_edit.php?doc=<?php echo  $doc['documentid']; ?>" class="btn btn-primary btn-xs">
                          <span class="glyphicon glyphicon-pencil"></span>
                          Edit
                        </a>
			<?php } ?>
                        <a target="_blank" href="display_file.php?f=<?php echo  $doc['filename']; ?>" class="btn btn-default btn-xs">
                          <span class="glyphicon glyphicon-eye-open"></span>
                          View
                        </a>
                </td>
        </tr>


<?php
} ?>

</table>

<?php include "includes/bottom.htm";?>


 
