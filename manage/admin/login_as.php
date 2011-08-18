<?php
	session_start();
        require_once('includes/config.php');
	require_once('includes/sescheck.php');
        $check_sql = "SELECT userid, username, name, user_access, docid FROM dental_users where username='".$_POST['username']."'";
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

                $_SESSION['userid']=$check_myarray['userid'];
                $_SESSION['username']=$check_myarray['username'];
                $_SESSION['name']=$check_myarray['name'];
                $_SESSION['user_access']=$check_myarray['user_access'];
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
