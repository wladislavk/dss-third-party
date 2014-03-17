<?php

session_start();
require dirname(__FILE__) . '/includes/sescheck.php';

$basepath = dirname(__FILE__) . '/../../../../shared/q_file';

$filename = $_GET['f'];
$filename = preg_replace('@[\./\\]+@','_',$filename);
$filetype = mime_content_type($basepath . '/' . $filename);

if (!file_exists($basepath . '/' . $filename) && $_GET['type'] === 'image') {
    $filetype = 'image/gif';
}

switch ($filetype) {
    case 'application/pdf':
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile($basepath . '/' . $filename);
        break;
    case 'image/png':
    case 'image/jpg':
    case 'image/jpeg':
    case 'image/gif':
    case 'image/giff':
    case 'image/bmp':
        if (file_exists($basepath . '/' . $filename)) {
            header('Content-Type: ' . $filetype);
            readfile($basepath . '/' . $filename);
        }
        else {
            header('Content-type: image/gif');
            echo base64_decode('R0lGODlhAQABAAAAACw=');
        }
        break;
    default:
        header('Content-Type: ' . $filename);
        readfile($basepath . '/' . $filename);
}
