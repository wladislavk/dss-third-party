<?php

namespace DentalSleepSolutions\Http\Controllers;

class FaxInvoicesController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/fax-invoices",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/FaxInvoice"))
     *                 )
     *             )
     *         }
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
     *     path="/fax-invoices/{fax_invoices}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/FaxInvoice"))
     *             )
     *         }
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
     *     path="/fax-invoices",
     *     @SWG\Parameter(name="invoice_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="description", in="formData", type="string"),
     *     @SWG\Parameter(name="start_date", in="formData", type="string", format="dateTime", required=true),
     *     @SWG\Parameter(name="end_date", in="formData", type="string", format="dateTime", required=true),
     *     @SWG\Parameter(name="amount", in="formData", type="string", pattern="^\d*(\.\d{2})?$"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/FaxInvoice"))
     *             )
     *         }
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function store()
    {
        return parent::store();
    }

    /**
     * @SWG\Put(
     *     path="/fax-invoices/{fax_invoices}",
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
     *     path="/fax-invoices/{fax_invoices}",
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
}
