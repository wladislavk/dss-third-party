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
        // access only to own directory
        $userId     = $this->currentUser->id;
        $pathToFile = 'user_' . $userId . '/' . $filename;

        if (Storage::has($pathToFile)) {
            $imageContent = Storage::get($pathToFile);
            $mime         = Storage::mimeType($pathToFile);

            $data = [
                'image' => 'data:' . $mime . ';base64,' . base64_encode($imageContent)
            ];

            return ApiResponse::responseOk('', $data);
        } else {
            return ApiResponse::responseError();
        }
    }
}
