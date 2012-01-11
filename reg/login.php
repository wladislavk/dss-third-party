<?php session_start(); ?>
<?php include '../manage/admin/includes/config.php'; ?>
<?php include '../manage/admin/includes/password.php';
?>
<link href="../manage/css/login.css" rel="stylesheet" type="text/css" />
<?php
$e = '';
if(isset($_POST['loginbut'])){
        $salt_sql = "SELECT salt FROM dental_patients WHERE login='".mysql_real_escape_string($_POST['login'])."'";
        $salt_q = mysql_query($salt_sql);
        $salt_row = mysql_fetch_assoc($salt_q);

        $pass = gen_password(preg_replace('/\D/', '', $_POST['password']), $salt_row['salt']);

        $check_sql = "SELECT patientid, login, registered  FROM dental_patients where login='".mysql_real_escape_string($_POST['login'])."' and password='".$pass."' ";
        $check_my = mysql_query($check_sql);
  if(mysql_num_rows($check_my) > 0){
                session_register("pid");
    $p = mysql_fetch_assoc($check_my);
                $_SESSION['pid']=$p['patientid'];
    if($p['registered'] == 1){
    ?>  
      <script type="text/javascript">
        window.location = 'home.php';
      </script>
    <?php
    }else{
    ?>  
      <script type="text/javascript">
        window.location = 'register.php';
      </script>
    <?php
    }
  }else{
    $e = "Invalid login information";
  }
  
}

?>
<div id="login_container">
<FORM NAME="loginfrm" METHOD="POST" ACTION="<?=$_SERVER['PHP_SELF']?>" onSubmit="return loginabc(this)";>
<table border="0" cellpadding="3" cellspacing="1" bgcolor="#00457C" width="40%">
    <tr bgcolor="#FFFFFF">
        <td colspan="2" class="t_head">
               Please Enter Your Login Information
        </td>
    </tr>
        <? if($_GET['msg']!="")
    {
    ?>
        <tr bgcolor="#FFFFFF">
            <td colspan="2" >
                <span class="red">
                                        <?=$_GET['msg'];?>
                </span>
            </td>
        </tr>
    <? }?>
    <tr bgcolor="#FFFFFF">
        <td class="t_data">
                User name
        </td>
        <td class="t_data">
                <input type="text" name="login">
        </td>
    </tr>
    <tr bgcolor="#FFFFFF">
        <td class="t_data">
                Password
        </td>
        <td class="t_data">
                <input type="password" name="password">
        </td>
        </tr>
    <tr bgcolor="#FFFFFF">
        <td colspan="2" align="center" >
            <input type="submit" name="loginbut" value=" Login " class="addButton">
        </td>
    </tr>
</table>
</FORM>
</div>
<span id="siteseal"><script type="text/javascript" src="https://seal.godaddy.com/getSeal?sealID=3b7qIyHRrOjVQ3mCq2GohOZtQjzgc1JF4ccCXdR6VzEhui2863QRhf"></script>
<br/><a style="font-family: arial; font-size: 9px" href="http://www.godaddy.com/ssl/ssl-certificates.aspx" target="_blank">secure website</a></span>
<div style="clear:both;"></div>

