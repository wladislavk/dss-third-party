<?php
namespace Ds3\Libraries\Legacy;

$filename = !empty($_GET['f']) ? $_GET['f'] : '';

/**
 * @see DSS-337
 *
 * Don't check for session info if the file is a logo
 */
if (!preg_match('/^user_logo_\d+\.(gif|jpg|jpeg|png)$/', $filename)) {
    require_once __DIR__ . '/includes/sescheck.php';
}

$basepath = __DIR__ . '/../../../shared/q_file';

$filetype = '';
$exists = file_exists($basepath . '/' . $filename);

if ($exists) {
    $filetype = mime_content_type($basepath . '/' . $filename);
} else if (!empty($_GET['type']) && $_GET['type'] === 'image') {
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
        }
        else {
            echo base64_decode('R0lGODlhAQABAAAAACw=');
        }
        break;
    default:
        if ($exists) {
            header('Content-type: '.$filetype);
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            readfile($basepath . '/' . $filename);
        } else {
            header('HTTP/1.0 404 Not Found');
        }
        break;
}?>
