<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Response;

class SessionController extends Controller
{
    /**
     * Get the requested values from the session.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function get(Request $request)
    {
        $requestedValues = $request->all();

        $retrievedData = [];

        foreach ($requestedValues as $value) {
            $retrievedData[$value] = $request->session()->get($value, '');
        }

        return Response::json($retrievedData);
    }

    /**
     * Pass a list of values to the session
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function set(Request $request)
    {
        $listOfValues = $request->all();

        foreach ($listOfValues as $key => $value) {
            $request->session()->put($key, $value);
        }

        return Response::json(['status' => 'All values were pushed to the session.']);
    }
}
