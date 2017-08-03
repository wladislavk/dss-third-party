<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Contracts\Repositories\Repository;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Eloquent\AbstractModel;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Contracts\Repositories\Users;
use DentalSleepSolutions\Contracts\TransformerInterface;
use EventHomes\Api\FractalHelper;

abstract class BaseReferencedRestController extends Controller
{
    use FractalHelper;

    /** @var bool */
    protected $hasIp = false;

    /** @var AbstractModel|Repository */
    protected $resources;

    /** @var Request */
    protected $request;

    /** @var TransformerInterface */
    protected $transformer;

    /** @var bool */
    protected $canBackup = true;

    /** @var string */
    protected $ipAddressKey;

    /** @var string */
    protected $referenceKey = 'patient_id';

    /** @var string */
    protected $doctorKey;

    /** @var string */
    protected $userKey;

    /** @var string */
    protected $createdByUserKey;

    /** @var string */
    protected $createdByAdminKey;

    /** @var string */
    protected $updatedByUserKey;

    /** @var string */
    protected $updatedByAdminKey;

    public function __construct(
        JWTAuth $auth,
        Users $usersRepository,
        Repository $resources,
        Request $request,
        TransformerInterface $transformer
    ) {
        parent::__construct($auth, $usersRepository);
        $this->resources = $resources;
        $this->request = $request;
        $this->transformer = $transformer;
    }

    /**
     * Display a listing of the resource for the specified patient.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function index($id)
    {
        $resources = $this->resources->where($this->referenceKey, $id)->get();
        return ApiResponse::responseOk('', $resources);
    }

    /**
     * Display the resource from the specified patient.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        /** @var Resource */
        $resource = $this->resources->firstOrNew([$this->referenceKey => $id]);
        $createData = $this->getCreateAttributes($id);

        if ($resource->getAttribute($this->referenceKey) !== $id && count($createData)) {
            $resource->forceFill($createData);
        }

        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function store($id)
    {
        return self::update($id);
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
        $data = $this->transformer->inverseTransform($this->request->all());
        $createData = $this->getCreateAttributes($id);
        $updateData = $this->getUpdateAttributes();

        /** @var Resource */
        $resource = $this->resources->firstOrCreate([$this->referenceKey => $id]);

        if ($resource->getAttribute($this->referenceKey) !== $id && count($createData)) {
            $resource->forceFill($createData);
        }

        if (count($updateData)) {
            $resource->forceFill($updateData);
        }

        $resource->fill($data);
        $resource->save();

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return ApiResponse::responseError('Method not allowed', 405);
    }

    public function backup($id)
    {
        if (!$this->canBackup) {
            return ApiResponse::responseError('Method not allowed', 405);
        }

        $resource = $this->resources->where([$this->referenceKey => $id])->firstOrFail();
        $resource->doBackup($this->getUserId(), $this->getAdminId(), $this->request->ip());

        return ApiResponse::responseOk('Resource updated');
    }

    protected function getCreateAttributes($id)
    {
        $attributes = [
            $this->referenceKey => $id,
        ];

        if ($this->hasIp) {
            $attributes['ip_address'] = $this->request->ip();
        }

        if ($this->ipAddressKey) {
            $attributes[$this->ipAddressKey] = $this->request->ip();
        }

        if ($this->doctorKey) {
            $attributes[$this->doctorKey] = $this->getDoctorId();
        }

        if ($this->userKey) {
            $attributes[$this->userKey] = $this->getUserId();
        }

        if ($this->createdByUserKey) {
            $attributes[$this->createdByUserKey] = $this->getUserId();
        }

        if ($this->createdByAdminKey) {
            $attributes[$this->createdByAdminKey] = $this->getAdminId();
        }

        return $attributes;
    }

    protected function getUpdateAttributes()
    {
        $attributes = [];

        if ($this->updatedByUserKey) {
            $attributes[$this->updatedByUserKey] = $this->getUserId();
        }

        if ($this->updatedByAdminKey) {
            $attributes[$this->updatedByAdminKey] = $this->getAdminId();
        }

        return $attributes;
    }

    protected function getUserId()
    {
        if (!$this->currentUser) {
            return 0;
        }

        return $this->currentUser->id;
    }

    protected function getDoctorId()
    {
        if (!$this->currentUser) {
            return 0;
        }

        return $this->currentUser->docid;
    }

    protected function getAdminId()
    {
        if (!$this->currentAdmin) {
            return 0;
        }

        return $this->currentAdmin->id;
    }
}