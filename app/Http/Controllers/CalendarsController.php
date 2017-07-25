<?php

namespace DentalSleepSolutions\Http\Controllers;

class CalendarsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/calendars",
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
     *                         @SWG\Items(ref="#/definitions/Calendar")
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
     *     path="/calendars/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Calendar")
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
     *     path="/calendars",
     *     @SWG\Parameter(name="start_date", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="end_date", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="description", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="event_id", in="formData", type="string", required=true, pattern="^[0-9]{13}$"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="category", in="formData", type="string"),
     *     @SWG\Parameter(name="producer_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="rec_type", in="formData", type="string"),
     *     @SWG\Parameter(name="event_length", in="formData", type="integer"),
     *     @SWG\Parameter(name="event_pid", in="formData", type="integer"),
     *     @SWG\Parameter(name="res_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="rec_pattern", in="formData", type="string"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Calendar")
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
     *     path="/calendars/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="start_date", in="formData", type="string"),
     *     @SWG\Parameter(name="end_date", in="formData", type="string"),
     *     @SWG\Parameter(name="description", in="formData", type="string"),
     *     @SWG\Parameter(name="event_id", in="formData", type="string", pattern="^[0-9]{13}$"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="category", in="formData", type="string"),
     *     @SWG\Parameter(name="producer_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="rec_type", in="formData", type="string"),
     *     @SWG\Parameter(name="event_length", in="formData", type="integer"),
     *     @SWG\Parameter(name="event_pid", in="formData", type="integer"),
     *     @SWG\Parameter(name="res_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="rec_pattern", in="formData", type="string"),
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
     *     path="/calendars/{id}",
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
