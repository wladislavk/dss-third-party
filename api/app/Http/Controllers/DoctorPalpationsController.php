<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Facades\ApiResponse;

class DoctorPalpationsController extends BaseRestController
{
    /** @var string */
    protected $ipAddressKey = 'ip_address';

    /** @var string */
    protected $doctorKey = 'doc_id';

    /** @var string */
    protected $updatedByUserKey = 'updated_by_user';

    /** @var string */
    protected $updatedByAdminKey = 'updated_by_admin';

    /** @var string */
    protected $filterByDoctorKey = 'doc_id';

    /**
     * @SWG\Get(
     *     path="/doctor-palpations",
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
     *                         @SWG\Items(ref="#/definitions/DoctorPalpation")
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
     *     path="/doctor-palpations/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/DoctorPalpations")
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
     *     path="/doctor-palpations",
     *     @SWG\Parameter(name="palpationid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="sortby", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/DoctorPalpations")
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

    public function bulkStore()
    {
        $this->validate($this->request, $this->request->storeRules());
        $dataArray = $this->request->payload();
        $docId = $this->user()->normalizedDocId();
        $this->repository
            ->deleteWhere([$this->filterByDoctorKey => $docId])
        ;

        foreach ($dataArray['palpation'] as $each) {
            $data = [
                'palpationid' => $each['palpationid'],
                'doc_id' => $docId,
                'sortby' => $each['sortby'],
            ];
            /** @var \DentalSleepSolutions\Eloquent\Models\AbstractModel $resource */
            $resource = $this->repository->create($data);
            $createData = $this->getCreateAttributes();

            if (count($createData)) {
                $resource->forceFill($createData)->save();
            }
        }

        return ApiResponse::responseOk('Resources created');
    }

    /**
     * @SWG\Put(
     *     path="/doctor-palpations/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="palpationid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="sortby", in="formData", type="integer"),
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
     *     path="/doctor-palpations/{id}",
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
