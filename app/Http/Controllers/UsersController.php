<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Resources\User;
use DentalSleepSolutions\Contracts\Repositories\Users;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UsersController extends Controller
{
    const DSS_USER_STATUS_ACTIVE    = 1;
    const DSS_USER_STATUS_INACTIVE  = 2;
    const DSS_USER_STATUS_SUSPENDED = 3;

    private $statusLabels = [
        self::DSS_USER_STATUS_ACTIVE    => 'Active',
        self::DSS_USER_STATUS_INACTIVE  => 'In-Active',
        self::DSS_USER_STATUS_SUSPENDED => 'Suspended'
    ];

    public function index()
    {
        return parent::index();
    }

    public function show($id)
    {
        return parent::show($id);
    }

    public function store()
    {
        return parent::store();
    }

    public function update($id)
    {
        return parent::update($id);
    }

    public function destroy($id)
    {
        return parent::destroy($id);
    }

    /**
     * Get the account status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function check()
    {
        $accountStatuses = [
            self::DSS_USER_STATUS_ACTIVE,
            self::DSS_USER_STATUS_INACTIVE,
            self::DSS_USER_STATUS_SUSPENDED
        ];

        $data = [];

        if ($this->currentUser && in_array($this->currentUser->status, $accountStatuses)) {
            $data['type'] = $this->statusLabels[$this->currentUser->status];
        }

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Get info about current logined user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrentUserInfo(User $resource)
    {
        return ApiResponse::responseOk('', $this->currentUser);
    }

    /**
     * Get course staff of current logined user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCourseStaff(User $resource)
    {
        $userId = $this->currentUser->id ?: 0;

        $data = $resource->getCourseStaff($userId);

        return ApiResponse::responseOk('', $data);
    }

    public function getPaymentReports(Users $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getPaymentReports($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function checkLogout(User $resource)
    {
        $userId = $this->currentUser->id ?: 0;
        $logoutTime = 60 * 60;

        $data = $resource->getLastAccessedDate($userId);

        $lastAccessedDate = strtotime($data->last_accessed_date);
        $now = strtotime(Carbon::now());

        if ($lastAccessedDate > $now - $logoutTime) {
            $resetTime = ($logoutTime - ($now - $lastAccessedDate)) * 1000;

            return ApiResponse::responseOk('', ['resetTime' => $resetTime]);
        } else {
            return ApiResponse::responseOk('', ['logout' => true]);
        }
    }

    public function getLetterInfo(User $resource, Request $request)
    {
        $docId = $this->currentUser->docid ?: 0;
        $data = $resource->getLetterInfo($docId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Get users by filter.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Users $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithFilter(Users $resources, Request $request)
    {
        $fields = $request->input('fields', []);
        $where  = $request->input('where', []);

        $patients = $resources->getWithFilter($fields, $where);

        return ApiResponse::responseOk('', $patients);
    }
}
