<?php
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");

        if($_POST["ed"] != "")
        {
                $ed_sql = "update dental_custom set title = '".s_for($_POST["title"])."', description = '".s_for($_POST["description"])."', status = '".s_for($_POST["status"])."' where customid='".$_POST["ed"]."'";
                mysql_query($ed_sql) or die($ed_sql." | ".mysql_error());

                //echo $ed_sql.mysql_error();
                $msg = "Edited Successfully";
                ?>
                <script type="text/javascript">
                        //alert("<?=$msg;?>");
                        parent.window.location = parent.window.location;
                </script>
                <?
                die();
        }
        else
        {
                $ins_sql = "insert into dental_custom set title = '".s_for($_POST["title"])."', description = '".s_for($_POST["description"])."', docid='".$_SESSION['docid']."', status = '".s_for($_POST["st
atus"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
                mysql_query($ins_sql) or die($ins_sql.mysql_error());

                $msg = "Added Successfully";
                ?>
                <script type="text/javascript">
                        //alert("<?=$msg;?>");
			parent.window.location = parent.window.location;
                </script>
                <?
                die();
        }

?>

