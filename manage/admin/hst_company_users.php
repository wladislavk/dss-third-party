<?
include "includes/top.htm";

if(isset($_POST['user_sub'])){
  $d_sql = "UPDATE dental_users SET hst_company_id=NULL WHERE hst_company_id='".mysql_real_escape_string($_POST['id'])."'";
  mysql_query($d_sql);
  $u = implode(',',$_POST['user']);
  $up_sql = "UPDATE dental_users set hst_company_id='".mysql_real_escape_string($_POST['id'])."' WHERE userid IN (".$u.")";
  mysql_query($up_sql);
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
$u_q = mysql_query($u_sql);
while($user = mysql_fetch_assoc($u_q)){
?>

  <input type="checkbox" value="<?= $user['userid'];?>" name="user[]" <?= ($user['hst_company_id']==$_REQUEST['id'])?'checked="checked"':''; ?> <?= ($user['hst_company_id']!='' && $user['hst_company_id']!=$_REQUEST['id'])?'disabled="disabled"':''; ?> />
  <?= $user['first_name']. " " .$user['last_name'] . " - " . $user['username']; ?><br />
<?php
  }
?>
<input type="hidden" name="id" value="<?= $_REQUEST['id']; ?>" />
<input type="submit" name="user_sub" value="Update" />
</form>









<?php
include 'includes/bottom.htm';
?>
