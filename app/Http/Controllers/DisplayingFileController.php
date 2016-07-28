<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Storage;

class DisplayingFileController extends Controller
{
    public function getFile($filename)
    {
        if (Storage::has($filename)) {
            $imageContent = Storage::get($filename);
            $mime         = Storage::mimeType($filename);

            return response($imageContent, 200)
                ->header('Content-Type', $mime);
        } else {
            return response(null, 404);
        }
    }
}
