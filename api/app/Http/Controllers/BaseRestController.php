<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Contracts\SingularAndPluralInterface;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\NamingConventions\BindingNamingConvention;
use DentalSleepSolutions\Facades\ApiResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;
use Illuminate\Contracts\Auth\Factory as Auth;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Config\Repository as Config;

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

    /** @var Auth */
    protected $auth;

    /** @var bool */
    protected $hasIp = true;

    /** @var AbstractRepository */
    protected $repository;

    /** @var string */
    protected $ipAddressKey;

    /** @var string */
    protected $doctorKey;

    /** @var string */
    protected $userKey;

    /** @var string */
    protected $patientKey;

    /** @var string */
    protected $createdByUserKey;

    /** @var string */
    protected $createdByAdminKey;

    /** @var string */
    protected $updatedByUserKey;

    /** @var string */
    protected $updatedByAdminKey;

    /** @var string */
    protected $filterByAdminKey;

    /** @var string */
    protected $filterByUserKey;

    /** @var string */
    protected $filterByDoctorKey;

    /** @var string */
    protected $filterByPatientKey;

    /**
     * @param Auth $auth
     * @param Config $config
     * @param BaseRepository $repository
     * @param Request $request
     */
    public function __construct(
        Auth $auth,
        Config $config,
        AbstractRepository $repository,
        Request $request
    ) {
        parent::__construct($auth, $config, $request);
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $filter = $this->getIndexConditionals();
        $fields = $this->request->query('fields', '*');
        $fields = explode(',', $fields);
        $data = $this->repository->getWithFilter($fields, $filter);
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
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store()
    {
        $this->validate($this->request, $this->request->storeRules());
        $data = $this->request->payload();
        $createData = $this->getCreateAttributes();
        $data = array_merge($data, $createData);

        /** @var \DentalSleepSolutions\Eloquent\Models\AbstractModel $resource */
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
        $data = $this->request->payload();
        $updateData = $this->getUpdateAttributes();
        $data = array_merge($data, $updateData);

        /** @var \DentalSleepSolutions\Eloquent\Models\AbstractModel $resource */
        $resource = $this->repository->find($id);
        $resource->update($data);

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        /** @var Model $resource */
        $resource = $this->repository->find($id);
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    /**
     * Display most recent entry
     *
     * @return JsonResponse
     */
    public function latest()
    {
        $filter = $this->getIndexConditionals();
        $fields = $this->request->query('fields', '*');
        $fields = explode(',', $fields);
        $data = $this->repository
            ->getWithFilter($fields, $filter)
        ;
        if (!sizeof($data)) {
            throw (new ModelNotFoundException())->setModel($this->repository->model());
        }

        return ApiResponse::responseOk('', $data[0]);
    }

    /**
     * @return string
     * @throws \ReflectionException
     */
    public function getSingular()
    {
        $reflection = new \ReflectionClass($this);
        $shortName = $reflection->getShortName();
        return str_singular(str_replace('Controller', '', $shortName));
    }

    /**
     * @return string
     * @throws \ReflectionException
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

    /**
     * @return array
     */
    protected function getCreateAttributes()
    {
        $attributes = [];

        if ($this->hasIp) {
            $attributes['ip_address'] = $this->request->ip();
        }

        if ($this->doctorKey) {
            $attributes[$this->doctorKey] = $this->user()->normalizedDocId();
        }

        if ($this->userKey) {
            $attributes[$this->userKey] = $this->user()->userid;
        }

        if ($this->patientKey) {
            $attributes[$this->patientKey] = $this->patient()->patientid;
        }

        if ($this->createdByUserKey) {
            $attributes[$this->createdByUserKey] = $this->user()->userid;
        }

        if ($this->createdByAdminKey) {
            $attributes[$this->createdByAdminKey] = $this->admin()->adminid;
        }

        return $attributes;
    }

    /**
     * @return array
     */
    protected function getUpdateAttributes()
    {
        $attributes = [];

        if ($this->updatedByUserKey) {
            $attributes[$this->updatedByUserKey] = $this->user()->userid;
        }

        if ($this->updatedByAdminKey) {
            $attributes[$this->updatedByAdminKey] = $this->admin()->adminid;
        }

        return $attributes;
    }

    /**
     * @return array
     */
    protected function getIndexConditionals()
    {
        $attributes = [];

        if ($this->filterByAdminKey) {
            $attributes[$this->filterByAdminKey] = $this->admin()->adminid;
        }

        if ($this->filterByDoctorKey) {
            $attributes[$this->filterByDoctorKey] = $this->user()->normalizedDocId();
        }

        if ($this->filterByUserKey) {
            $attributes[$this->filterByUserKey] = $this->user()->userid;
        }

        // Patient ID can be zero, in which case it is not taken into account
        if ($this->filterByPatientKey && $this->patient()->patientid) {
            $attributes[$this->filterByPatientKey] = $this->patient()->patientid;
        }

        return $attributes;
    }
}
