<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Contracts\Repositories\Repository;
use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\JWTAuth;
use DentalSleepSolutions\Contracts\Repositories\Users;

abstract class BaseVersionedRestController extends Controller
{
    /** @var Model|Repository */
    protected $resources;

    /** @var Request */
    protected $request;

    /** @var string */
    protected $referenceKey = 'patient_id';

    public function __construct(
        JWTAuth $auth,
        Users $usersRepository,
        Repository $resources,
        Request $request
    ) {
        parent::__construct($auth, $usersRepository);
        $this->resources = $resources;
        $this->request = $request;
    }

    /**
     * Display a listing of the resource for the specified patient.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function index($id)
    {
        $data = $this->resources
            ->where($this->referenceKey, $id)
            ->orderBy('history_id', 'desc')
            ->get(['history_id', 'history_created_at', 'updated_at'])
        ;

        if (!$data || !count($data)) {
            $data = [];
        }

        return ApiResponse::responseOk('', ['historyList' => $data]);
    }

    /**
     * Display the resource from the specified patient.
     *
     * @param int $id
     * @param int $version
     * @return JsonResponse
     */
    public function show($id, $version)
    {
        $data = $this->resources
            ->where($this->referenceKey, $id)
            ->where('history_id', $version)
            ->firstOrFail()
        ;

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function store($id)
    {
        return ApiResponse::responseError('Method not allowed', 405);
    }

    /**
     * @param int $id
     * @param int $version
     * @return JsonResponse
     */
    public function update($id, $version)
    {
        return ApiResponse::responseError('Method not allowed', 405);
    }

    /**
     * @param int $id
     * @param int $version
     * @return JsonResponse
     */
    public function destroy($id, $version)
    {
        return ApiResponse::responseError('Method not allowed', 405);
    }
}