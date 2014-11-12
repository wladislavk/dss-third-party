<?php
  include 'includes/main_include.php';

  if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['fromForm'] == 1 )
  {
    $users_sql = "SELECT userid, username, name, email FROM dental_users WHERE name IS NOT NULL;";
    $users_result = mysql_query($users_sql);
    while ($row = mysql_fetch_assoc($users_result))
    {
      $edx_id = shell_exec('sh ../edx_scripts/edxNewUser.sh '.urlencode($row["username"]).' '.urlencode($row["email"]).' '.urlencode('sdfgnliqwertyuilmcvxsdfdfvasdasd').' '.urlencode($row["name"]));
      echo $edx_id;
      $update_sql ="UPDATE dental_users SET edx_id=".$edx_id." WHERE userid=".$row["userid"].";";
      $update_result = mysql_query($update_sql);
    }

  }
  else
  {
?>

<html>
  <head>
    <title>My Page</title>
  </head>
  <body>
    Are you sure you want to reset all edX users? Make sure you have deleted all users from edX first.
    <form name="resetForm" method="POST">
      <input type="hidden" name="fromForm" value="1">
      <input type="submit" value="Yes">
      </form>
  </body>
</html>
<?php  } ?>
  

