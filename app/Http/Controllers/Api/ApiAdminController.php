<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreAdminRequest;
use DentalSleepSolutions\Http\Requests\UpdateAdminRequest;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\Repositories\AdminInterface;
use DentalSleepSolutions\Libraries\Password;

class ApiAdminController extends ApiBaseController
{
    /**
     * References the admin interface
     * 
     * @var $admin
     */
    protected $admin;

    /**
     * 
     * @param AdminInterface $admin 
     */
    public function __construct(AdminInterface $admin)
    {
        $this->admin = $admin;
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $retrievedAdmins = $this->admin->all();

        if (!count($retrievedAdmins)) {
            return ApiResponse::responseError('The table is empty.', 422);
        }

        return ApiResponse::responseOk('Admins list.', $retrievedAdmins);
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAdminRequest $request)
    {
        $salt       = Password::createSalt();
        $password   = Password::genPassword($request->input('password'), $salt);
        $postValues = array_merge($request->all(), [
            'salt'               => $salt,
            'password'           => $password,
            'adddate'            => Carbon::now(),
            'last_accessed_date' => Carbon::now(),
            'ip_address'         => $request->ip()
        ]);

        $this->admin->store($postValues);

        return ApiResponse::responseOk('Admin was added succesfully.', $this->admin->all());
    }

    /**
     * 
     * 
     * @param integer $adminId 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAdminRequest $request, $adminId)
    {
        $putValues = array_merge($request->all(), [
            'last_accessed_date' => Carbon::now(),
        ]);

        if ($request->has('password')) {
            $salt       = Password::createSalt();
            $password   = Password::genPassword($request->input('password'), $salt);

            $putValues = array_merge($putValues, [
                'salt'     => $salt,
                'password' => $password,
            ]);
        }

        $this->admin->update($adminId, $putValues);

        return ApiResponse::responseOk('Admin was updated succesfully.', $this->admin->all());
    }

    /**
     * 
     * 
     * @param integer $adminId 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($adminId)
    {
        $retrievedAdmin = $this->admin->find($adminId);

        if (empty($retrievedAdmin)) {
            return ApiResponse::responseError('Admin not found.', 422);
        }

        return ApiResponse::responseOk('Retrieved admin by id.', $retrievedAdmin);
    }

    /**
     * 
     * 
     * @param integer $adminId 
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($adminId)
    {
        return ApiResponse::responseOk('Admin was edited successfully.', []);
    }

    /**
     * 
     * 
     * @param integer $adminId 
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($adminId)
    {
        $deletedAdmin = $this->admin->destroy($adminId);

        if (empty($deletedAdmin)) {
            return ApiResponse::responseError('Admin not found.', 422);
        }

        return ApiResponse::responseOk('Admin was deleted successfully.', $this->admin->all());
    }
}
