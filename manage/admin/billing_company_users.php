<?
include "includes/top.htm";

if(isset($_POST['user_sub'])){
  $d_sql = "UPDATE dental_users SET billing_company_id=NULL WHERE billing_company_id='".mysql_real_escape_string($_POST['id'])."'";
  mysql_query($d_sql);
  $u = implode(',',$_POST['user']);
  $up_sql = "UPDATE dental_users set billing_company_id='".mysql_real_escape_string($_POST['id'])."' WHERE userid IN (".$u.")";
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
$u_sql = "SELECT u.*, c.name as billing_company FROM dental_users u 
		LEFT JOIN companies c on c.id=u.billing_company_id
		WHERE
		u.docid=0
		ORDER BY u.first_name ASC, u.last_name ASC, u.username ASC";
$u_q = mysql_query($u_sql);
while($user = mysql_fetch_assoc($u_q)){
?>

  <input type="checkbox" value="<?= $user['userid'];?>" name="user[]" <?= ($user['billing_company_id']==$_REQUEST['id'])?'checked="checked"':''; ?> <?= ($user['billing_company_id']!='' && $user['billing_company_id']!='0' && $user['billing_company_id']!=$_REQUEST['id'])?'disabled="disabled"':''; ?> />
  <?= $user['first_name']. " " .$user['last_name'] . " - " . $user['username'] ." - ".$user['billing_company']; ?><br />
<?php
  }
?>
<input type="hidden" name="id" value="<?= $_REQUEST['id']; ?>" />
<input type="submit" name="user_sub" value="Update" class="btn btn-primary">
</form>









<?php
include 'includes/bottom.htm';
?>
