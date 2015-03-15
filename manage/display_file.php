<?php namespace Ds3\Legacy; ?><?php
include_once dirname(__FILE__) . '/includes/sescheck.php';

$basepath = dirname(__FILE__) . '/../../../shared/q_file';

$filename = (!empty($_GET['f']) ? $_GET['f'] : '');
//$filename = preg_replace('@[\./\\]+@','_',$filename);

$filetype = '';

if (file_exists($basepath . '/' . $filename)) {
    $filetype = mime_content_type($basepath . '/' . $filename);
} else {
    if (!empty($_GET['type']) && $_GET['type'] === 'image') {
        $filetype = 'image/gif';
    }
}

switch ($filetype) {
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
        header('Content-type: '.$filetype);
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        if (file_exists($basepath . '/' . $filename)) {
            readfile($basepath . '/' . $filename);
        }
        break;
}?>
