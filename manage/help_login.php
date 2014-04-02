<?php
session_start();
include 'admin/includes/main_include.php';
include("includes/sescheck.php");

  $username = $_SESSION['username'];
  $key = sha1(rand().'*&Tuvt7X'.$_SESSION['username'].rand());
  $pass = sha1($_SESSION['username'].'HNb%5#fc'.rand());

  $del_sql = "delete from help_wp.dss_wp_signon where user_name = '".mysql_real_escape_string($username)."'";
  mysql_query($del_sql, $help_con);
  $login_sql = "insert into help_wp.dss_wp_signon (user_name, user_temp_key) values ('".$username."', '".$key."');";
  mysql_query($login_sql, $help_con);

?><script type="text/javascript"><?php
if($_SERVER['HTTP_HOST']=='www.dentalsleepsolutions.com' || $_SERVER['HTTP_HOST']=='dentalsleepsolutions.com'){
?>  window.location='http://help.dentalsleepsolutions.com/?un=<?= $username; ?>&dsswpkey=<?= $key; ?>&dssup=<?= $pass; ?>'; <?php
                }else{
?>  window.location='http://help.dss-rh.xforty.com/?un=<?= $username; ?>&dsswpkey=<?= $key; ?>&dssup=<?= $pass; ?>'; <?php
                }
?>
</script>
