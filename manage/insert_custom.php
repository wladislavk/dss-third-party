<?php namespace Ds3\Libraries\Legacy; ?><?php
    include_once('admin/includes/main_include.php');
    include("includes/sescheck.php");

    if($_POST["ed"] != "") {
        $ed_sql = "update dental_custom set title = '".s_for($_POST["title"])."', description = '".s_for($_POST["description"])."', status = '".s_for($_POST["status"])."' where customid='".$_POST["ed"]."'";
        
        $db->query($ed_sql);
        $msg = "Edited Successfully";
?>
        <script type="text/javascript">
            parent.window.location = parent.window.location;
        </script>
<?php
        trigger_error("Die called", E_USER_ERROR);
    } else {
        $ins_sql = "insert into dental_custom set title = '".s_for($_POST["title"])."', description = '".s_for($_POST["description"])."', docid='".$_SESSION['docid']."', status = '".s_for($_POST["st
                    atus"])."',adddate=now(),ip_address='".$_SERVER['REMOTE_ADDR']."'";
        
        $db->query($ins_sql);
        $msg = "Added Successfully";
?>
        <script type="text/javascript">
            parent.window.location = parent.window.location;
        </script>
<?
        trigger_error("Die called", E_USER_ERROR);
    }
?>
