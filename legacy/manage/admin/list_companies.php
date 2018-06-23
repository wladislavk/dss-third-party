<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/main_include.php';
require_once __DIR__ . '/includes/sescheck.php';
require_once __DIR__ . '/includes/access.php';

$partial = trim(array_get($_POST, 'partial_name', ''));

if (!is_super($_SESSION['admin_access']) || !strlen($partial)) {
    returnJson(['error' => 'No companies found']);
}

$db = new Db();

$partial = $db->escape($partial);

$sql = "SELECT id, name
    FROM companies
    WHERE name LIKE '$partial%' OR name LIKE '%$partial'
    ORDER BY name ASC";
$results = $db->getResults($sql);

if (!$results) {
    returnJson(['error' => 'No companies found']);
}

returnJson($results);

function returnJson ($data)
{
    echo json_encode($data);
    trigger_error('Die called', E_USER_ERROR);
}
