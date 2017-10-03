<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Facades\ApiResponse;
use DentalSleepSolutions\Helpers\EpworthFinder;
use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Config\Repository as Config;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Eloquent\BaseRepository;

class EpworthSleepinessScaleController extends BaseRestController
{
    /** @var EpworthFinder */
    private $epworthFinder;

    public function __construct(
        Config $config,
        BaseRepository $repository,
        Request $request,
        EpworthFinder $epworthFinder
    ) {
        parent::__construct($config, $repository, $request);
        $this->epworthFinder = $epworthFinder;
    }

    /**
     * @SWG\Get(
     *     path="/epworth-sleepiness-scale",
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
     *                         @SWG\Items(ref="#/definitions/EpworthSleepinessScale")
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
        $status = $this->request->get('status', '');
        $order = $this->request->get('order', '');
        $data = $this->epworthFinder->findEpworth($status, $order);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Get(
     *     path="/epworth-sleepiness-scale/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/EpworthSleepinessScale")
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return parent::show($id);
    }

    /**
     * @SWG\Post(
     *     path="/epworth-sleepiness-scale",
     *     @SWG\Parameter(name="epworth", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="description", in="formData", type="string"),
     *     @SWG\Parameter(name="sortby", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/EpworthSleepinessScale")
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
     *     path="/epworth-sleepiness-scale/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="epworth", in="formData", type="string"),
     *     @SWG\Parameter(name="description", in="formData", type="string"),
     *     @SWG\Parameter(name="sortby", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function update($id)
    {
        return parent::update($id);
    }

    /**
     * @SWG\Delete(
     *     path="/epworth-sleepiness-scale/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="Resource deleted", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return parent::destroy($id);
    }

    /**
     * @return string
     */
    public function getSingular()
    {
        return 'EpworthSleepinessScale';
    }
}
