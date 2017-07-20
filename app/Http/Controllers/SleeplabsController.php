<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\Sleeplab;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Http\Request;

class SleeplabsController extends BaseRestController
{
    /**
     * @SWG\Get(
     *     path="/sleeplabs",
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
     *                         @SWG\Items(ref="#/definitions/Sleeplab")
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
     *     path="/sleeplabs/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Sleeplab")
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
     *     path="/sleeplabs",
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="salutation", in="formData", type="string"),
     *     @SWG\Parameter(name="lastname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="firstname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="middlename", in="formData", type="string"),
     *     @SWG\Parameter(name="company", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="add1", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="add2", in="formData", type="string"),
     *     @SWG\Parameter(name="city", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="state", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="zip", in="formData", type="string", required=true, pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="phone1", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="phone2", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="fax", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email"),
     *     @SWG\Parameter(name="greeting", in="formData", type="string"),
     *     @SWG\Parameter(name="sincerely", in="formData", type="string"),
     *     @SWG\Parameter(name="notes", in="formData", type="string"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Sleeplab")
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
     *     path="/sleeplabs/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="salutation", in="formData", type="string"),
     *     @SWG\Parameter(name="lastname", in="formData", type="string"),
     *     @SWG\Parameter(name="firstname", in="formData", type="string"),
     *     @SWG\Parameter(name="middlename", in="formData", type="string"),
     *     @SWG\Parameter(name="company", in="formData", type="string"),
     *     @SWG\Parameter(name="add1", in="formData", type="string"),
     *     @SWG\Parameter(name="add2", in="formData", type="string"),
     *     @SWG\Parameter(name="city", in="formData", type="string"),
     *     @SWG\Parameter(name="state", in="formData", type="string"),
     *     @SWG\Parameter(name="zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="phone1", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="phone2", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="fax", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email"),
     *     @SWG\Parameter(name="greeting", in="formData", type="string"),
     *     @SWG\Parameter(name="sincerely", in="formData", type="string"),
     *     @SWG\Parameter(name="notes", in="formData", type="string"),
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
     *     path="/sleeplabs/{id}",
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
     *     path="/sleeplabs/list",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Sleeplabs $resources
     * @param Patients $patientResource
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListOfSleeplabs(
        Sleeplab $resources,
        Patient $patientResource,
        Request $request
    ) {
        $docId = $this->currentUser->docid ?: 0;

        $page = $request->input('page', 0);
        $rowsPerPage = $request->input('rows_per_page', 20);
        $sort = $request->input('sort');
        $sortDir = $request->input('sort_dir', 'asc');
        $letter = $request->input('letter');

        $sleeplabs = $resources->getList($docId, $page, $rowsPerPage, $sort, $sortDir, $letter);

        if ($sleeplabs['total'] > 0) {
            $sleeplabs['result']->map(function ($sleeplab) use ($patientResource) { 
                $sleeplab['patients'] = $patientResource->getRelatedToSleeplab($sleeplab->sleeplabid);
            
                return $sleeplab;
            });
        }

        return ApiResponse::responseOk('', $sleeplabs);
    }

    /**
     * @SWG\Post(
     *     path="/sleeplabs/edit/{sleeplabId}",
     *     @SWG\Parameter(name="sleeplabId", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @SWG\Post(
     *     path="/sleeplabs/edit",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Sleeplab $sleeplabResource
     * @param Request $request
     * @param int|null $sleeplabId
     * @return \Illuminate\Http\JsonResponse
     */
    public function editSleeplab(
        Sleeplab $sleeplabResource,
        Request $request,
        $sleeplabId = null
    ) {
        $docId = $this->currentUser->docid ?: 0;

        $sleeplabFormData = $request->input('sleeplab_form_data', []);

        if ($sleeplabId) {
            $validator = $this->getValidationFactory()->make(
                $sleeplabFormData, (new \DentalSleepSolutions\Http\Requests\Sleeplab())->updateRules()
            );
        } else {
            $validator = $this->getValidationFactory()->make(
                $sleeplabFormData, (new \DentalSleepSolutions\Http\Requests\Sleeplab())->storeRules()
            );
        }

        if ($validator->fails()) {
            return ApiResponse::responseError('', 422, $validator->messages());
        }
        if (count($sleeplabFormData) == 0) {
            return ApiResponse::responseError('Sleeplab data is empty.', 422);
        }

        $sleeplabFormData = array_merge($sleeplabFormData, [
            'docid' => $docId,
            'ip_address' => $request->ip(),
        ]);

        $responseData = [];
        if ($sleeplabId) {
            $sleeplabResource->updateSleeplab($sleeplabId, $sleeplabFormData);

            $responseData['status'] = 'Edited Successfully';
        } else { // sleeplabId = 0 -> creating a new sleeplab
            $sleeplabResource->create($sleeplabFormData);

            $responseData['status'] = 'Added Successfully';
        }

        return ApiResponse::responseOk('', $responseData);
    }
}
