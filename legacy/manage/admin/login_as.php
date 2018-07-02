<?php
namespace Ds3\Libraries\Legacy;

include_once('includes/main_include.php');
include_once('includes/sescheck.php');

$check_sql = "SELECT dental_users.userid, username, name, user_access, docid, user_type, uc.companyid FROM dental_users 
                LEFT JOIN dental_user_company uc ON dental_users.userid=uc.userid
                where username='".$db->escape($_POST['username'])."'";
$check_my = mysqli_query($con,$check_sql);
if (mysqli_num_rows($check_my) == 1) {
    echo('here');
    $check_myarray = mysqli_fetch_array($check_my);

    $_SESSION['userid']=$check_myarray['userid'];
    $_SESSION['username']=$check_myarray['username'];
    $_SESSION['name']=$check_myarray['name'];
    $_SESSION['user_access']=$check_myarray['user_access'];
    $_SESSION['companyid']=$check_myarray['companyid'];
    $_SESSION['user_type']=$check_myarray['user_type'];

    $_SESSION['api_token'] = generateApiToken('u_'.$check_myarray['userid']);

    if($check_myarray['docid'] != 0) {
        $_SESSION['docid']=$check_myarray['docid'];
    } else {
        $_SESSION['docid']=$check_myarray['userid'];
    }
}
?>
<script type="text/javascript">
	window.location = "../index.php";
</script>
