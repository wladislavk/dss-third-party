<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/admin/includes/main_include.php';
require_once __DIR__ . '/includes/sescheck.php';

$db = new Db();
$docId = (int)$_SESSION['docid'];

if (!empty($_POST["customsub"]) && $_POST["customsub"] == 1) {
    $description = $_POST['description'];

    if (!is_string($description)) {
        $description = json_encode($description);
    }

    $customId = (int)$_POST['ed'];
    $data = [
        'title' => $_POST['title'],
        'description' => $description,
        'status' => $_POST['status'],
    ];

    if ($customId) {
        $data = $db->escapeAssignmentList($data);
        $db->query("UPDATE dental_custom
            SET $data
            WHERE customid = '$customId'
        ");

        ?>
        <script type="text/javascript">
            parent.window.location = parent.window.location;
        </script>
        <?php
        trigger_error("Die called", E_USER_ERROR);
    }

    $data['docid'] = $docId;
    $data['ip_address'] = $_SERVER['REMOTE_ADDR'];
    $data = $db->escapeAssignmentList($data);

    $db->query("INSERT INTO dental_custom
            SET $data, adddate = NOW()
        ");

    ?>
    <script type="text/javascript">
        parent.window.location = parent.window.location;
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}