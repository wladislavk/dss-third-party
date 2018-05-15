<?php

namespace DentalSleepSolutions\Http\Controllers;

/**
 * @todo: restore API tests if needed or delete the controller
 */
class SleepStudiesController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/sleep-studies",
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
     *                         @SWG\Items(ref="#/definitions/SleepStudy")
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
     *     path="/sleep-studies/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/SleepStudy")
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
     *     path="/sleep-studies",
     *     @SWG\Parameter(name="testnumber", in="formData", type="string", required=true, pattern="^[0-9]{9}$"),
     *     @SWG\Parameter(name="docid", in="formData", type="string", required=true, pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="patientid", in="formData", type="string", required=true, pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="needed", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="scheddate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="sleeplabwheresched", in="formData", type="string", required=true, pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="completed", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="interpolation", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="labtype", in="formData", type="string", required=true, pattern="^(?:PSG|HST)$"),
     *     @SWG\Parameter(name="copyreqdate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="sleeplab", in="formData", type="string", required=true, pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="scanext", in="formData", type="string", pattern="^(?:jpg|docx|rtf|pdf)$"),
     *     @SWG\Parameter(name="date", in="formData", type="string", required=true, pattern="^[0-9]{8}$"),
     *     @SWG\Parameter(name="filename", in="formData", type="string", pattern="^[a-z0-9_]{15}$"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/SleepStudy")
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
     *     path="/sleep-studies/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="testnumber", in="formData", type="string", pattern="^[0-9]{9}$"),
     *     @SWG\Parameter(name="docid", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="patientid", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="needed", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="scheddate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="sleeplabwheresched", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="completed", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="interpolation", in="formData", type="string", pattern="^(?:Yes|No)$"),
     *     @SWG\Parameter(name="labtype", in="formData", type="string", pattern="^(?:PSG|HST)$"),
     *     @SWG\Parameter(name="copyreqdate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="sleeplab", in="formData", type="string", pattern="^[0-9]+$"),
     *     @SWG\Parameter(name="scanext", in="formData", type="string", pattern="^(?:jpg|docx|rtf|pdf)$"),
     *     @SWG\Parameter(name="date", in="formData", type="string", pattern="^[0-9]{8}$"),
     *     @SWG\Parameter(name="filename", in="formData", type="string", pattern="^[a-z0-9_]{15}$"),
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
     *     path="/sleep-studies/{id}",
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
