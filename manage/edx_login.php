<?php
session_start();
include 'admin/includes/main_include.php';
include("includes/sescheck.php");
$u_sql = "SELECT edx_id FROM dental_users WHERE userid='".mysql_real_escape_string($_SESSION['userid'])."'";
$u_q = mysql_query($u_sql);
$u = mysql_fetch_assoc($u_q);
$userid = $u['edx_id'];
error_log($userid);
$ses = shell_exec('sh edxScript.sh '.$userid);
error_log($ses);
$expire=time()+60*60*2;
if($_SERVER['HTTP_HOST']=='dentalsleepsolutions.com'){
  setcookie("edxloggin", "true", $expire, "/", "dentalsleepsolutions.com", false);
  setcookie("sessionid", $ses, $expire, "/", "dentalsleepsolutions.com", false);
}else{
  setcookie("edxloggin", "true", $expire, "/", "xforty.com", false);
  setcookie("sessionid", $ses, $expire, "/", "xforty.com", false);
}
?>
<script type="text/javascript">
<?php
                if($_SERVER['HTTP_HOST']=='dentalsleepsolutions.com' || $_SERVER['HTTP_HOST']=='stage.dss-rh.xforty.com'){
?>  window.location='http://edx.dss-rh.xforty.com/dashboard'; <?php
                }else{
?>  window.location='http://edx.dss-rh.xforty.com/dashboard'; <?php
                }
?>
</script>

