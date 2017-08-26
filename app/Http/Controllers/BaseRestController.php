<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Contracts\SingularAndPluralInterface;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\NamingConventions\BindingNamingConvention;
use DentalSleepSolutions\Facades\ApiResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Config\Repository as Config;
use DentalSleepSolutions\Helpers\AuthTokenParser;

/**
 * @SWG\Swagger(
 *     @SWG\Info(
 *         title="DSS-API",
 *         version="1.0"
 *     ),
 *     basePath="/api/v1",
 *     schemes={"http"},
 *     produces={"application/json"},
 *     consumes={"application/json"}
 * )
 *
 * Class BaseRestController
 */
abstract class BaseRestController extends Controller implements SingularAndPluralInterface
{
    /**
     * @SWG\Parameter(
     *     parameter="id_in_path",
     *     name="id",
     *     in="path",
     *     type="integer",
     *     required=true
     * ),
     * @SWG\Definition(
     *     definition="common_response_fields",
     *     @SWG\Property(property="status", type="string"),
     *     @SWG\Property(property="message", type="string"),
     * ),
     * @SWG\Definition(
     *     definition="common_error_fields",
     *     allOf={
     *         @SWG\Schema(ref="#/definitions/common_response_fields"),
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="data",
     *                 type="object",
     *                 @SWG\Property(
     *                     property="errorMessage",
     *                     type="string"
     *                 ),
     *                 @SWG\Property(
     *                     property="errors",
     *                     type="array",
     *                     @SWG\Items(
     *                         @SWG\Property(property="field", type="string"),
     *                         @SWG\Property(property="message", type="string")
     *                     )
     *                 )
     *             )
     *         )
     *     }
     * ),
     * @SWG\Definition(
     *     definition="empty_ok",
     *     @SWG\Schema(ref="#/definitions/common_response_fields")
     * ),
     * @SWG\Response(
     *     response="empty_ok_response",
     *     description="200 response without data",
     *     @SWG\Schema(ref="#/definitions/empty_ok")
     * ),
     * @SWG\Response(
     *     response="404_response",
     *     description="404 response",
     *     @SWG\Schema(ref="#/definitions/common_error_fields")
     * ),
     * @SWG\Response(
     *     response="422_response",
     *     description="422 response",
     *     @SWG\Schema(ref="#/definitions/common_error_fields")
     * ),
     * @SWG\Response(
     *     response="error_response",
     *     description="Unspecified error response",
     *     @SWG\Schema(ref="#/definitions/common_error_fields")
     * )
     */

    const BASE_MODEL_NAMESPACE = BindingNamingConvention::BASE_NAMESPACE . '\\Eloquent\\Models';
    const DEFAULT_MODEL_NAMESPACE = self::BASE_MODEL_NAMESPACE . '\\Dental';

    /** @var bool */
    protected $hasIp = true;

    /** @var BaseRepository */
    protected $repository;

    /** @var Request */
    protected $request;

    public function __construct(
        Config $config,
        AuthTokenParser $authTokenParser,
        BaseRepository $repository,
        Request $request
    ) {
        parent::__construct($config, $authTokenParser);
        $this->repository = $repository;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = $this->repository->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        /** @var Resource $resource */
        $resource = $this->repository->find($id);
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return JsonResponse
     */
    public function store()
    {
        $this->validate($this->request, $this->request->storeRules());
        $data = $this->request->all();
        if ($this->hasIp) {
            $data = array_merge($this->request->all(), ['ip_address' => $this->request->ip()]);
        }
        $resource = $this->repository->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function update($id)
    {
        $this->validate($this->request, $this->request->updateRules());
        /** @var Model $resource */
        $resource = $this->repository->find($id);
        $resource->update($this->request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        /** @var Model $resource */
        $resource = $this->repository->find($id);
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    /**
     * @return string
     */
    public function getSingular()
    {
        $reflection = new \ReflectionClass($this);
        $shortName = $reflection->getShortName();
        return str_singular(str_replace('Controller', '', $shortName));
    }

    /**
     * @return string
     */
    public function getPlural()
    {
        $reflection = new \ReflectionClass($this);
        $shortName = $reflection->getShortName();
        return str_replace('Controller', '', $shortName);
    }

    /**
     * @return string
     */
    public function getModelNamespace()
    {
        return self::DEFAULT_MODEL_NAMESPACE;
    }
}
