<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\AdminInterface;
use DentalSleepSolutions\Libraries\Password;

class ApiAdminController extends ApiBaseController
{
    /**
     * References the admin interface
     * 
     * @var $admin
     */
    protected $admin;

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
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $status   = null;
        $response = [
            'status'  => null,
            'message' => 'Admins list.',
            'data'    => []
        ];

        try {
            $retrievedAdmins = $this->admin->all();

            if (!count($retrievedAdmins)) {
                throw new Exception('The table is empty.');
            }

            $response['data']   = $retrievedAdmins;
            $response['status'] = true;
            $status             = 200;
        } catch (Exception $ex) {
            $status              = 404;
            $response['status']  = false;
            $response['message'] = $ex->getMessage();
        } finally {
            return response()->json($response, $status);
        }
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $status   = null;
        $response = [
            'status'  => null,
            'message' => 'Admin was added succesfully.',
            'data'    => []
        ];

        try {
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
            $response['data']   = $this->admin->all();
            $response['status'] = true;
            $status             = 200;
        } catch (Exception $ex) {
            $status              = 404;
            $response['status']  = false;
            $response['message'] = $ex->getMessage();
        } finally {
            return response()->json($response, $status);
        }
    }

    /**
     * 
     * 
     * @param integer $adminId 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($adminId)
    {
        $status   = null;
        $response = [
            'status'  => null,
            'message' => 'Admin was updated succesfully.',
            'data'    => []
        ];

        try {
            $putValues = Input::all();
            $validator = \Validator::make($putValues, $this->rulesForUpdate);

            if ($validator->fails()) {
                throw new Exception($validator->errors());
            }

            $putValues = array_merge($putValues, [
                'last_accessed_date' => Carbon::now(),
            ]);

            $this->admin->update($adminId, $putValues);
            $response['data']   = $this->admin->all();
            $response['status'] = true;
            $status             = 200;
        } catch (Exception $ex) {
            $response['message'] = $ex->getMessage();
            $response['status']  = false;
            $status              = 404;
        } finally {
            return response()->json($response, $status);
        }
    }

    /**
     * 
     * 
     * @param integer $adminId 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($adminId)
    {
        $status   = null;
        $response = [
            'status'  => null,
            'message' => 'Retrieved admin by id.',
            'data'    => []
        ];

        try {
            $retrievedAdmin = $this->admin->find($adminId);

            if (empty($retrievedAdmin)) {
                throw new Exception('Admin not found.');
            }

            $response['data']   = $retrievedAdmin;
            $response['status'] = true;
            $status             = 200;
        } catch (Exception $ex) {
            $response['message'] = $ex->getMessage();
            $response['status']  = false;
            $status              = 404;
        } finally {
            return response()->json($response, $status);
        }
    }

    /**
     * 
     * 
     * @param integer $adminId 
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($adminId)
    {
        $status   = null;
        $response = [
            'status'  => null,
            'message' => 'Admin was edited successfully.',
            'data'    => []
        ];

        try {

        } catch (Exception $ex) {

        } finally {
            return response()->json($response, $status);
        }
    }

    /**
     * 
     * 
     * @param integer $adminId 
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($adminId)
    {
        $status   = null;
        $response = [
            'status'  => null,
            'message' => 'Admin was deleted successfully.',
            'data'    => []
        ];

        try {
            $deletedAdmin     = $this->admin->destroy($adminId);
            $response['data'] = $this->admin->all();

            if (empty($deletedAdmin)) {
                throw new Exception('Admin not found.');
            }

            $response['status'] = true;
            $status             = 200;
        } catch (Exception $ex) {
            $response['message'] = $ex->getMessage();
            $response['status']  = false;
            $status              = 404;
        } finally {
            return response($response, $status);
        }
    }
}
