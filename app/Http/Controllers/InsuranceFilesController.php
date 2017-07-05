<?php

namespace DentalSleepSolutions\Http\Controllers;

class InsuranceFilesController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/insurance-files",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(
     *                     property="data",
     *                     type="array",
     *                     @SWG\Items(@SWG\Schema(ref="#/definitions/InsuranceFile"))
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
     *     path="/insurance-files/{insurance_files}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/InsuranceFile"))
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
     *     path="/insurance-files",
     *     @SWG\Parameter(name="claimid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="claimtype", in="formData", type="string", required=true, pattern="^(?:primary|secondary)$"),
     *     @SWG\Parameter(name="filename", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="description", in="formData", type="string"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         allOf={
     *             @SWG\Schema(ref="#/definitions/common_response_fields"),
     *             @SWG\Schema(
     *                 @SWG\Property(property="data", @SWG\Schema(ref="#/definitions/InsuranceFile"))
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
     *     path="/insurance-files/{insurance_files}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="claimid", in="formData", type="integer"),
     *     @SWG\Parameter(name="claimtype", in="formData", type="string", pattern="^(?:primary|secondary)$"),
     *     @SWG\Parameter(name="filename", in="formData", type="string"),
     *     @SWG\Parameter(name="description", in="formData", type="string"),
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
     *     path="/insurance-files/{insurance_files}",
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
