<?php

namespace DentalSleepSolutions\Http\Controllers;

/**
 * @todo: restore API tests if needed or delete the controller
 */
class SummarySleeplabsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/summary-sleeplabs",
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
     *                         @SWG\Items(ref="#/definitions/SummarySleeplab")
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
     *     path="/summary-sleeplabs/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/SummarySleeplab")
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
     *     path="/summary-sleeplabs",
     *     @SWG\Parameter(name="date", in="formData", type="string", format="dateTime", required=true),
     *     @SWG\Parameter(name="sleeptesttype", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="place", in="formData", type="string"),
     *     @SWG\Parameter(name="apnea", in="formData", type="string"),
     *     @SWG\Parameter(name="hypopnea", in="formData", type="string"),
     *     @SWG\Parameter(name="ahi", in="formData", type="string"),
     *     @SWG\Parameter(name="ahisupine", in="formData", type="string"),
     *     @SWG\Parameter(name="rdi", in="formData", type="string"),
     *     @SWG\Parameter(name="rdisupine", in="formData", type="string"),
     *     @SWG\Parameter(name="o2nadir", in="formData", type="string"),
     *     @SWG\Parameter(name="t9002", in="formData", type="string"),
     *     @SWG\Parameter(name="sleepefficiency", in="formData", type="string"),
     *     @SWG\Parameter(name="cpaplevel", in="formData", type="string"),
     *     @SWG\Parameter(name="dentaldevice", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="devicesetting", in="formData", type="string"),
     *     @SWG\Parameter(name="diagnosis", in="formData", type="string"),
     *     @SWG\Parameter(name="notes", in="formData", type="string"),
     *     @SWG\Parameter(name="patiendid", in="formData", type="string", required=true, pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="filename", in="formData", type="string", pattern="^[a-z0-9_]+\.(jpg|gif|png|bmp)$"),
     *     @SWG\Parameter(name="testnumber", in="formData", type="string", pattern="^[0-9]{9}$"),
     *     @SWG\Parameter(name="needed", in="formData", type="string", pattern="^(?:No|Yes)$"),
     *     @SWG\Parameter(name="scheddate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="completed", in="formData", type="string", pattern="^(?:No|Yes)$"),
     *     @SWG\Parameter(name="interpolation", in="formData", type="string", pattern="^(?:No|Yes)$"),
     *     @SWG\Parameter(name="copyreqdate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="sleeplab", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="diagnosising_doc", in="formData", type="string"),
     *     @SWG\Parameter(name="diagnosising_npi", in="formData", type="string"),
     *     @SWG\Parameter(name="image_id", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/SummarySleeplab")
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
     *     path="/summary-sleeplabs/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="sleeptesttype", in="formData", type="string"),
     *     @SWG\Parameter(name="place", in="formData", type="string"),
     *     @SWG\Parameter(name="apnea", in="formData", type="string"),
     *     @SWG\Parameter(name="hypopnea", in="formData", type="string"),
     *     @SWG\Parameter(name="ahi", in="formData", type="string"),
     *     @SWG\Parameter(name="ahisupine", in="formData", type="string"),
     *     @SWG\Parameter(name="rdi", in="formData", type="string"),
     *     @SWG\Parameter(name="rdisupine", in="formData", type="string"),
     *     @SWG\Parameter(name="o2nadir", in="formData", type="string"),
     *     @SWG\Parameter(name="t9002", in="formData", type="string"),
     *     @SWG\Parameter(name="sleepefficiency", in="formData", type="string"),
     *     @SWG\Parameter(name="cpaplevel", in="formData", type="string"),
     *     @SWG\Parameter(name="dentaldevice", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="devicesetting", in="formData", type="string"),
     *     @SWG\Parameter(name="diagnosis", in="formData", type="string"),
     *     @SWG\Parameter(name="notes", in="formData", type="string"),
     *     @SWG\Parameter(name="patiendid", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="filename", in="formData", type="string", pattern="^[a-z0-9_]+\.(jpg|gif|png|bmp)$"),
     *     @SWG\Parameter(name="testnumber", in="formData", type="string", pattern="^[0-9]{9}$"),
     *     @SWG\Parameter(name="needed", in="formData", type="string", pattern="^(?:No|Yes)$"),
     *     @SWG\Parameter(name="scheddate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="completed", in="formData", type="string", pattern="^(?:No|Yes)$"),
     *     @SWG\Parameter(name="interpolation", in="formData", type="string", pattern="^(?:No|Yes)$"),
     *     @SWG\Parameter(name="copyreqdate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="sleeplab", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="diagnosising_doc", in="formData", type="string"),
     *     @SWG\Parameter(name="diagnosising_npi", in="formData", type="string"),
     *     @SWG\Parameter(name="image_id", in="formData", type="string", pattern="^[0-9]+$"),
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
     *     path="/summary-sleeplabs/{id}",
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
