<?php
namespace Ds3\Libraries\Legacy;

$filename = !empty($_GET['f']) ? $_GET['f'] : '';
$isLetter = array_get($_GET, 'type') === 'letter';

/**
 * Don't check for session info if the file is a logo
 */
if (!preg_match('/^user_logo_\d+\.(gif|jpg|jpeg|png)$/', $filename)) {
    /**
     * Letters should allow BO users to access this script
     */
    session_start();

    if ($isLetter && isset($_SESSION['adminuserid'])) {
        require_once __DIR__ . '/admin/includes/sescheck.php';
    } else {
        require_once __DIR__ . '/includes/sescheck.php';
    }
}

if ($isLetter) {
    $basepath = __DIR__ . '/letterpdfs';
} else {
    $basepath = __DIR__ . '/../../../shared/q_file';
}

$filetype = '';
$exists = file_exists($basepath . '/' . $filename);

if ($exists) {
    $filetype = mime_content_type($basepath . '/' . $filename);
} elseif (!empty($_GET['type']) && $_GET['type'] === 'image') {
    $filetype = 'image/gif';
}

if (!$filetype) {
    $filetype = 'application/octet-stream';
}

switch ($filetype) {
    case 'image/png':
    case 'image/jpg':
    case 'image/jpeg':
    case 'image/gif':
    case 'image/giff':
    case 'image/bmp':
        header('Content-Type: ' . $filetype);

        if ($exists) {
            readfile($basepath . '/' . $filename);
        } else {
            echo base64_decode('R0lGODlhAQABAAAAACw=');
        }
        break;
    default:
        if ($exists) {
            header('Content-type: '.$filetype);
            header('Content-Disposition: ' . ($isLetter ? 'inline' : 'attachment') . '; filename="' . $filename . '"');
            readfile($basepath . '/' . $filename);
        } else {
            header('HTTP/1.0 404 Not Found');
        }
        break;
}
