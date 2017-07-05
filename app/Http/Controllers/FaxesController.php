<?php

namespace DentalSleepSolutions\Http\Controllers;

use Carbon\Carbon;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Repositories\Faxes;

class FaxesController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/faxes",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/Fax"))
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function index()
    {
        return parent::index();
    }

    /**
     * @SWG\Get(
     *     path="/faxes/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Fax"))
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function show($id)
    {
        return parent::show($id);
    }

    /**
     * @SWG\Post(
     *     path="/faxes",
     *     @SWG\Parameter(name="invoice_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="description", in="formData", type="string"),
     *     @SWG\Parameter(name="start_date", in="formData", type="string", format="dateTime", required=true),
     *     @SWG\Parameter(name="end_date", in="formData", type="string", format="dateTime", required=true),
     *     @SWG\Parameter(name="amount", in="formData", type="string", pattern="^\d*(\.\d{2})?$"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Fax"))
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function store()
    {
        $data = array_merge($this->request->all(), [
            'sent_date'  => Carbon::now(),
            'ip_address' => $this->request->ip(),
        ]);

        $resource = $this->resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * @SWG\Put(
     *     path="/faxes/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="invoice_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="description", in="formData", type="string"),
     *     @SWG\Parameter(name="start_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="end_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="amount", in="formData", type="string", pattern="^\d*(\.\d{2})?$"),
     *     @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function update($id)
    {
        return parent::update($id);
    }

    /**
     * @SWG\Delete(
     *     path="/faxes/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="Resource deleted", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function destroy($id)
    {
        return parent::destroy($id);
    }

    public function getAlerts(Faxes $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getAlerts($docId);

        return ApiResponse::responseOk('', $data);
    }
}
