<?php
namespace Ds3\Libraries\Legacy;

require_once 'main_include.php';

$db = new Db();

$ac_id = $_REQUEST['ac_id'];
$s = "select plan_id 
    FROM dental_access_codes
    WHERE id='".$db->escape( $ac_id)."'";
$q = mysqli_query($con, $s);

if (mysqli_num_rows($q) > 0) {
    $r = mysqli_fetch_assoc($q);
    echo '{"plan_id":"'.$r['plan_id'].'"}';
} else {
    echo '{"error":true}';
}
