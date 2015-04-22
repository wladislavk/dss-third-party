<?php
namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use File;
use Illuminate\Filesystem\FileNotFoundException;

class FileController extends Controller
{
    public function display($fileName = null)
    {
        $basePath = 'shared/q_file/';

        if (File::exists($basePath . $fileName)) {
            $extension = File::extension($basePath . $fileName);
            $contents = File::get($basePath . $fileName);

            switch ($extension) {
                case 'png': 
                    $contentType = 'image/png';
                    break;
                case 'jpg':
                    $contentType = 'image/jpg';
                    break;
                case 'jpeg':
                    $contentType = 'image/jpeg';
                    break;
                case 'gif':
                    $contentType = 'image/gif';
                    break;
                case 'bmp':
                    $contentType = 'image/bmp';
                    break;
                default:
                    $contentType = '';
                    break;
            }

            return response($contents)->header('Content-Type', $contentType);
        }
    }
}
