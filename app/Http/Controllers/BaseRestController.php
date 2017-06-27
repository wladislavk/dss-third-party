<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Contracts\Repositories\Repository;
use DentalSleepSolutions\Contracts\SingularAndPluralInterface;
use DentalSleepSolutions\Eloquent\Dental\User;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\NamingConventions\BindingNamingConvention;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\JWTAuth;

abstract class BaseRestController extends Controller implements SingularAndPluralInterface
{
    const BASE_MODEL_NAMESPACE = BindingNamingConvention::BASE_NAMESPACE . '\\Eloquent';
    const DEFAULT_MODEL_NAMESPACE = self::BASE_MODEL_NAMESPACE . '\\Dental';

    /** @var bool */
    protected $hasIp = true;

    /** @var Model|Repository */
    protected $resources;

    /** @var Request */
    protected $request;

    public function __construct(
        JWTAuth $auth,
        User $userModel,
        Repository $resources,
        Request $request
    ) {
        parent::__construct($auth, $userModel);
        $this->resources = $resources;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = $this->resources->all();

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
        $resource = $this->resources->findOrFail($id);
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
        $resource = $this->resources->create($data);

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
        /** @var Resource $resource */
        $resource = $this->resources->findOrFail($id);
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
        /** @var Resource $resource */
        $resource = $this->resources->findOrFail($id);
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

    public function getModelNamespace()
    {
        return self::DEFAULT_MODEL_NAMESPACE;
    }
}
