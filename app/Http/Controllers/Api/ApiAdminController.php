<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\Request;
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

    private $response;

    private $rulesForStore = [
        'name'               => 'max:250',
        'username'           => 'required|max:250',
        'password'           => 'required|max:250',
        'status'             => 'integer',
        'admin_access'       => 'integer',
        'email'              => 'email|max:100',
        'first_name'         => 'string|max:50',
        'last_name'          => 'string|max:50'
    ];

    private $rulesForUpdate = [
        'name'               => 'max:250',
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
        $this->response = [
            'status'  => true,
            'message' => '',
            'data'    => []
        ];
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
            throw new Exception('The table is empty.');
        }

        $this->response['message'] = 'Admins list.';
        $this->response['data']    = $retrievedAdmins;

        return response()->json($this->response, 200);
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $postValues = Input::all();
        $validator  = \Validator::make($postValues, $this->rulesForStore);

        if ($validator->fails()) {
            throw new Exception($validator->errors());
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

        $this->response['message'] = 'Admin was added succesfully.';
        $this->response['data']    = $this->admin->all();

        return response()->json($this->response, 200);
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
        $validator = \Validator::make($putValues, $this->rulesForUpdate);

        if ($validator->fails()) {
            throw new Exception($validator->errors());
        }

        $putValues = array_merge($putValues, [
            'last_accessed_date' => Carbon::now(),
        ]);

        $this->admin->update($adminId, $putValues);

        $this->response['message'] = 'Admin was updated succesfully.';
        $this->response['data']    = $this->admin->all();

        return response()->json($this->response, 200);
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
            throw new Exception('Admin not found.');
        }

        $this->response['message'] = 'Retrieved admin by id.';
        $this->response['data']    = $retrievedAdmin;

        return response()->json($this->response, 200);
    }

    /**
     * 
     * 
     * @param integer $adminId 
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($adminId)
    {
        $this->response['message'] = 'Admin was edited successfully.';
        $this->response['data']    = [];

        return response()->json($this->response, 200);
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
            throw new Exception('Admin not found.');
        }

        $this->response['message'] = 'Admin was deleted successfully.';
        $this->response['data']    = $this->admin->all();

        return response($this->response, 200);
    }
}
