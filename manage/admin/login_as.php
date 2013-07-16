<?php
	session_start();
        require_once('includes/main_include.php');
	require_once('includes/sescheck.php');
        //$check_sql = "SELECT userid, username, name, user_access, docid FROM dental_users where username='".$_POST['username']."'";
        $check_sql = "SELECT dental_users.userid, username, name, user_access, docid, user_type, uc.companyid FROM dental_users 
                        LEFT JOIN dental_user_company uc ON dental_users.userid=uc.userid
                        where username='".mysql_real_escape_string($_POST['username'])."'";
        $check_my = mysql_query($check_sql);
        if(mysql_num_rows($check_my) == 1)
        {
		echo('here');
                $check_myarray = mysql_fetch_array($check_my);

                /*$ins_sql = "insert into dental_log (userid,adddate,ip_address) values('".$check_myarray['userid']."',now(),'".$_SERVER['REMOTE_ADDR']."')";
                mysql_query($ins_sql);*/

                session_register("userid");
                session_register("username");
                session_register("name");
                session_register("user_access");
                session_register("docid");
                session_register("companyid");
                session_register("user_type");


                $_SESSION['userid']=$check_myarray['userid'];
                $_SESSION['username']=$check_myarray['username'];
                $_SESSION['name']=$check_myarray['name'];
                $_SESSION['user_access']=$check_myarray['user_access'];
                $_SESSION['companyid']=$check_myarray['companyid'];
                $_SESSION['user_type']=$check_myarray['user_type'];
                if($check_myarray['docid'] != 0)
                {
                        $_SESSION['docid']=$check_myarray['docid'];
                }
                else
                {
                        $_SESSION['docid']=$check_myarray['userid'];
                }


	}


?>

<script type="text/javascript">
	window.location = "../index.php";
</script>
