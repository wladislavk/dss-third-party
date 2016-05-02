<?php
namespace Ds3\Libraries\Legacy;

function edx_command ($instruction, Array $parameters) {
    $instructions = [
      'login' => 'edxScript.sh',
        'new' => 'edxNewUser.sh',
        'edit' => 'edxEditUser.sh',
        'delete' => 'edxDeleteUser.sh'
    ];

    if (!array_key_exists($instruction, $instructions)) {
        return false;
    }

    array_walk($parameters, function (&$each) {
        $each = '"' . urlencode($each) . '"';
    });

    $baseDir = __DIR__ . '/../..';
    $command = "sh $baseDir/edx_scripts/{$instructions[$instruction]} " . join(' ', $parameters);
    $lastLine = exec($command, $output, $returnCode);

    return $lastLine;
}

function edx_user_update ($userId) {
    $db = new Db();
    $id = intval($userId);

    $sql = "SELECT username, email, first_name, last_name, edx_id
          FROM dental_users
          WHERE userid = '$userId'";

    $user = $db->getRow($sql);
    $edxId = $user['edx_id'];
    $password = sha1($user['username'] . 'ed&$s8e' . $user['email'] . rand());

    if (!$edxId) {
        $parameters = [
            $user['username'],
            $user['email'],
            $password,
            "{$user['first_name']} {$user['last_name']}"
        ];

        $response = edx_command('new', $parameters);

        if (preg_match('/^(User already exists: )?(?P<edx_id>\d+)$/', $response, $match)) {
            $edxId = $match['edx_id'];

            $sql = "UPDATE dental_users
                SET edx_id = '" . $db->escape($edxId) . "'
                WHERE userid = '$userId'";
            $db->query($sql);
        }
    }

    if ($edxId) {
        $parameters = [
            $edxId,
            $user['username'],
            $user['email'],
            $password,
            "{$user['first_name']} {$user['last_name']}"
        ];

        edx_command('edit', $parameters);
    }
}

function edx_user_delete ($edxId) {
    if ($edxId) {
        edx_command('delete', [$edxId]);
    }
}

function edx_user_login ($userId) {
    $db = new Db();

    $userId = intval($userId);
    $edxId = $db->getColumn("SELECT edx_id
        FROM dental_users
        WHERE userid = '$userId'", 'edx_id', 0);

    $sessionId = edx_command('login', [$edxId]);
    return $sessionId;
}
