<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Facades\ApiResponse;
use Storage;

class DisplayingFileController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/display-file/{filename}",
     *     @SWG\Parameter(name="filename", in="path", type="string", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param string $filename
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getFile($filename)
    {
        // access only to own directory
        $pathToFile = 'user_' . $this->user()->userid . '/' . $filename;

        if (Storage::has($pathToFile)) {
            $imageContent = Storage::get($pathToFile);
            $mime         = Storage::mimeType($pathToFile);

            $data = [
                'image' => 'data:' . $mime . ';base64,' . base64_encode($imageContent)
            ];

            return ApiResponse::responseOk('', $data);
        }
        return ApiResponse::responseError();
    }
}
