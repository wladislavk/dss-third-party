<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\HomeSleepTestRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ScreenerEpworthRepository;
use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Http\Requests\Request;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Config\Repository as Config;

class HomeSleepTestsController extends BaseRestController
{
    /** @var HomeSleepTestRepository */
    protected $repository;

    /** @var ScreenerEpworthRepository */
    private $screenerEpworthRepository;

    public function __construct(
        Config $config,
        BaseRepository $repository,
        Request $request,
        ScreenerEpworthRepository $screenerEpworthRepository
    ) {
        parent::__construct($config, $repository, $request);
        $this->screenerEpworthRepository = $screenerEpworthRepository;
    }

    /**
     * @SWG\Get(
     *     path="/home-sleep-tests",
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
     *                         @SWG\Items(ref="#/definitions/HomeSleepTest")
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
     *     path="/home-sleep-tests/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/HomeSleepTest")
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
     *     path="/home-sleep-tests",
     *     @SWG\Parameter(name="doc_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="user_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="company_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="patient_id", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="screener_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="ins_co_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="ins_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="patient_ins_group_id", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_ins_id", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_firstname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="patient_lastname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="patient_add1", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_add2", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_city", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_state", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="patient_dob", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_cell_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="patient_home_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="patient_email", in="formData", type="string", format="email"),
     *     @SWG\Parameter(name="diagnosis_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="hst_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="provider_firstname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="provider_lastname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="provider_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="provider_address", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_city", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_state", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="provider_signature", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_date", in="formData", type="string"),
     *     @SWG\Parameter(name="snore_1", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_2", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_3", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_4", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_5", in="formData", type="integer"),
     *     @SWG\Parameter(name="viewed", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="office_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_study_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="authorized_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="authorizeddate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="updatedate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="rejected_reason", in="formData", type="string"),
     *     @SWG\Parameter(name="rejecteddate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="canceled_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="canceled_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="hst_nights", in="formData", type="integer"),
     *     @SWG\Parameter(name="hst_positions", in="formData", type="string"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/HomeSleepTest")
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
        $this->validate($this->request, $this->request->storeRules());
        $data = $this->request->all();
        $createData = $this->getCreateAttributes();

        if (count($createData)) {
            $data = array_merge($data, $createData);
        }

        $screenerId = $data['screener_id'];
        $epworthData = $this->screenerEpworthRepository->getWithFilter([], ['screener_id' => $screenerId]);
        $hst = $this->repository->createWithEpworth($data, $epworthData->toArray());

        return ApiResponse::responseOk('Resource created', $hst);
    }

    /**
     * @SWG\Put(
     *     path="/home-sleep-tests/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="doc_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="user_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="company_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="patient_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="screener_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="ins_co_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="ins_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="patient_ins_group_id", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_ins_id", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_firstname", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_lastname", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_add1", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_add2", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_city", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_state", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="patient_dob", in="formData", type="string"),
     *     @SWG\Parameter(name="patient_cell_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="patient_home_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="patient_email", in="formData", type="string", format="email"),
     *     @SWG\Parameter(name="diagnosis_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="hst_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="provider_firstname", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_lastname", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="provider_address", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_city", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_state", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="provider_signature", in="formData", type="string"),
     *     @SWG\Parameter(name="provider_date", in="formData", type="string"),
     *     @SWG\Parameter(name="snore_1", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_2", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_3", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_4", in="formData", type="integer"),
     *     @SWG\Parameter(name="snore_5", in="formData", type="integer"),
     *     @SWG\Parameter(name="viewed", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="office_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="sleep_study_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="authorized_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="authorizeddate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="updatedate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="rejected_reason", in="formData", type="string"),
     *     @SWG\Parameter(name="rejecteddate", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="canceled_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="canceled_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="hst_nights", in="formData", type="integer"),
     *     @SWG\Parameter(name="hst_positions", in="formData", type="string"),
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
     *     path="/home-sleep-tests/{id}",
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
