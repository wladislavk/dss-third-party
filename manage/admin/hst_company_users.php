<?php namespace Ds3\Libraries\Legacy; ?><?
include "includes/top.htm";

if(isset($_POST['user_sub'])){
  $d_sql = "UPDATE dental_users SET hst_company_id=NULL WHERE hst_company_id='".mysqli_real_escape_string($con,$_POST['id'])."'";
  mysqli_query($con,$d_sql);
  $u = implode(',',$_POST['user']);
  $up_sql = "UPDATE dental_users set hst_company_id='".mysqli_real_escape_string($con,$_POST['id'])."' WHERE userid IN (".$u.")";
  mysqli_query($con,$up_sql);
  ?>
  <script type="text/javascript">
    window.location='manage_companies.php';
  </script>
  <?php
}
?>

<form method="post">

<?php
$u_sql = "SELECT * FROM dental_users WHERE
		docid=0
		ORDER BY first_name ASC, last_name ASC, username ASC";
$u_q = mysqli_query($con,$u_sql);
while($user = mysqli_fetch_assoc($u_q)){
?>

  <input type="checkbox" value="<?php echo  $user['userid'];?>" name="user[]" <?php echo  (!empty($user['hst_company_id']) && $user['hst_company_id']==$_REQUEST['id'])?'checked="checked"':''; ?> <?php echo  (!empty($user['hst_company_id']) && $user['hst_company_id']!=$_REQUEST['id'])?'disabled="disabled"':''; ?> />
  <?php echo  $user['first_name']. " " .$user['last_name'] . " - " . $user['username']; ?><br />
<?php
  }
?>
<input type="hidden" name="id" value="<?php echo  $_REQUEST['id']; ?>" />
<input type="submit" name="user_sub" value="Update" class="btn btn-primary">
</form>









<?php
include 'includes/bottom.htm';
?>
