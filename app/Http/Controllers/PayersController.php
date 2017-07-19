<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Payer;
use Illuminate\Http\Request;
use DentalSleepSolutions\StaticClasses\ApiResponse;

class PayersController extends BaseRestController
{
    public function index()
    {
        return parent::index();
    }

    public function show($id)
    {
        return parent::show($id);
    }

    public function store()
    {
        $this->hasIp = false;
        return parent::store();
    }

    public function update($id)
    {
        return parent::update($id);
    }

    public function destroy($id)
    {
        return parent::destroy($id);
    }

    /**
     * Get array of enrollment required fields for a payer.
     *
     * @param Payer $payer
     * @return \Illuminate\Http\JsonResponse
     */
    public function requiredFields(Payer $payer, Request $request)
    {
        $fields = $payer->requiredFields($request->get('endpoint'));

        return ApiResponse::responseOk('', $fields);
    }
}
