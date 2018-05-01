<?php

namespace DentalSleepSolutions\Http\Controllers;

/**
 * @todo: restore API tests if needed or delete the controller
 */
class LedgerPaymentsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/ledger-payments",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(
     *                         property="data",
     *                         type="array",
     *                         @SWG\Items(ref="#/definitions/LedgerPayment")
     *                     )
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
     *     path="/ledger-payments/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/LedgerPayment")
     *                 )
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
     *     path="/ledger-payments",
     *     @SWG\Parameter(name="payer", in="formData", type="integer"),
     *     @SWG\Parameter(name="amount", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="payment_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="payment_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="entry_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ledgerid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="allowed", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="ins_paid", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="deductible", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="copay", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="coins", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="overpaid", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="followup", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="note", in="formData", type="string"),
     *     @SWG\Parameter(name="amount_allowed", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/LedgerPayment")
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function store()
    {
        $this->hasIp = false;
        return parent::store();
    }

    /**
     * @SWG\Put(
     *     path="/ledger-payments/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="payer", in="formData", type="integer"),
     *     @SWG\Parameter(name="amount", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="payment_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="payment_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="entry_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ledgerid", in="formData", type="integer"),
     *     @SWG\Parameter(name="allowed", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="ins_paid", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="deductible", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="copay", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="coins", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="overpaid", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
     *     @SWG\Parameter(name="followup", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="note", in="formData", type="string"),
     *     @SWG\Parameter(name="amount_allowed", in="formData", type="string", pattern="^[0-9]+\.[0-9]{1,2}$"),
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
     *     path="/ledger-payments/{id}",
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
