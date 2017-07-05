<?php

namespace DentalSleepSolutions\Http\Controllers;

class ChargesController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/charges",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/Charge"))
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
     *     path="/charges/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Charge"))
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
     *     path="/charges",
     *     @SWG\Parameter(name="amount", in="formData", type="string", required=true, pattern="^\d*(\.\d{2})?$"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="adminid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="charge_date", in="formData", type="string", format="dateTime", required=true),
     *     @SWG\Parameter(name="stripe_customer", in="formData", type="string"),
     *     @SWG\Parameter(name="stripe_charge", in="formData", type="string"),
     *     @SWG\Parameter(name="stripe_card_fingerprint", in="formData", type="string"),
     *     @SWG\Parameter(name="invoice_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 ref="#/definitions/common_response_fields",
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/Charge"))
     *             }
     *         )
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
     *     path="/charges/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="amount", in="formData", type="string", pattern="^\d*(\.\d{2})?$"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="adminid", in="formData", type="integer"),
     *     @SWG\Parameter(name="charge_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="stripe_customer", in="formData", type="string"),
     *     @SWG\Parameter(name="stripe_charge", in="formData", type="string"),
     *     @SWG\Parameter(name="stripe_card_fingerprint", in="formData", type="string"),
     *     @SWG\Parameter(name="invoice_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
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
     *     path="/charges/{id}",
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
