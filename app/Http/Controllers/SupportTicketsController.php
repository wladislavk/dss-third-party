<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\SupportTicket;
use DentalSleepSolutions\Eloquent\Repositories\Dental\SupportTicketRepository;
use DentalSleepSolutions\StaticClasses\ApiResponse;

class SupportTicketsController extends BaseRestController
{
    /** @var SupportTicketRepository */
    protected $repository;

    /**
     * @SWG\Get(
     *     path="/support-tickets",
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
     *                         @SWG\Items(ref="#/definitions/SupportTicket")
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
     *     path="/support-tickets/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/SupportTicket")
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
     *     path="/support-tickets",
     *     @SWG\Parameter(name="title", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="body", in="formData", type="string"),
     *     @SWG\Parameter(name="category_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="attachment", in="formData", type="string"),
     *     @SWG\Parameter(name="viewed", in="formData", type="boolean"),
     *     @SWG\Parameter(name="creator_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="create_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="company_id", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/SupportTicket")
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
        return parent::store();
    }

    /**
     * @SWG\Put(
     *     path="/support-tickets/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="title", in="formData", type="string"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="body", in="formData", type="string"),
     *     @SWG\Parameter(name="category_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="attachment", in="formData", type="string"),
     *     @SWG\Parameter(name="viewed", in="formData", type="boolean"),
     *     @SWG\Parameter(name="creator_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="create_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="company_id", in="formData", type="integer"),
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
     *     path="/support-tickets/{id}",
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

    /**
     * @SWG\Post(
     *     path="/support-tickets/number",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNumber()
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $this->repository->getNumber($docId);

        return ApiResponse::responseOk('', $data);
    }
}
