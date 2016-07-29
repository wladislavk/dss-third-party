<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Http\Response;
use Storage;

class DisplayingFileController extends Controller
{
    public function getFile($filename)
    {
        if (Storage::has($filename)) {
            $imageContent = Storage::get($filename);
            $mime         = Storage::mimeType($filename);

            $data = [
                'image' => 'data:' . $mime . ';base64,' . base64_encode($imageContent)
            ];

            return ApiResponse::responseOk('', $data);
        } else {
            return ApiResponse::responseError();
        }
    }
}
