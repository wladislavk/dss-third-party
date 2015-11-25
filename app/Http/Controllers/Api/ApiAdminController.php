<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\Request;
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

    private $rules = [
        'name'               => 'max:250',
        'username'           => 'required|max:250|unique:admin',
        'password'           => 'required|max:250',
        'status'             => 'integer',
        'admin_access'       => 'integer',
        'email'              => 'email|max:100',
        'first_name'         => 'string|max:50',
        'last_name'          => 'string|max:50'
    ];

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
    public function store()
    {
        $postValues = Input::all();
        $validator  = \Validator::make($postValues, $this->rules);

        if ($validator->fails()) {
            return ApiResponse::responseError($validator->errors(), 422);
        }

        $salt       = Password::createSalt();
        $password   = Password::genPassword($postValues['password'], $salt);
        $postValues = array_merge($postValues, [
            'salt'               => $salt,
            'password'           => $password,
            'adddate'            => Carbon::now(),
            'last_accessed_date' => Carbon::now(),
            'ip_address'         => \Request::ip()
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
    public function update($adminId)
    {
        $putValues = Input::all();

        // if input data has a username and a password then these will be validated
        $this->rules['username'] = 'sometimes|' . $this->rules['username'];
        $this->rules['password'] = 'sometimes|' . $this->rules['password'];

        $validator = \Validator::make($putValues, $this->rules);

        if ($validator->fails()) {
            return ApiResponse::responseError($validator->errors(), 422);
        }

        $putValues = array_merge($putValues, [
            'last_accessed_date' => Carbon::now(),
        ]);

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
