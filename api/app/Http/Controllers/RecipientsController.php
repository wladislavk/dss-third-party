<?php

namespace DentalSleepSolutions\Http\Controllers;

/**
 * @todo: restore API tests if needed or delete the controller
 */
class RecipientsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/recipients",
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
     *                         @SWG\Items(ref="#/definitions/Recipient")
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
     *     path="/recipients/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Recipient")
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
     *     path="/recipients",
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="referring_physician", in="formData", type="string"),
     *     @SWG\Parameter(name="dentist", in="formData", type="string"),
     *     @SWG\Parameter(name="physicians_other", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_info", in="formData", type="string"),
     *     @SWG\Parameter(name="q_file1", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="q_file2", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="q_file3", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="q_file4", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="q_file5", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="docid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="q_file6", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="q_file7", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="q_file8", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="q_file9", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="q_file10", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Recipient")
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
     *     path="/recipients/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="formid", in="formData", type="integer"),
     *     @SWG\Parameter(name="patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="referring_physician", in="formData", type="string"),
     *     @SWG\Parameter(name="dentist", in="formData", type="string"),
     *     @SWG\Parameter(name="physicians_other", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_info", in="formData", type="string"),
     *     @SWG\Parameter(name="q_file1", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="q_file2", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="q_file3", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="q_file4", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="q_file5", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="q_file6", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="q_file7", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="q_file8", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="q_file9", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
     *     @SWG\Parameter(name="q_file10", in="formData", type="string", pattern="^[a-z0-9]{12}\.(gif|png|jpg)$"),
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
     *     path="/recipients/{id}",
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
