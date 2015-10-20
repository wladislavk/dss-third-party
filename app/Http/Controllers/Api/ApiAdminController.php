<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;

use DentalSleepSolutions\Interfaces\AdminInterface;

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
        'username'           => 'required|max:250',
        'password'           => 'required|max:250',
        'adddate'            => 'required|date_format:Y-m-d H:i:s',
        'salt'               => 'required|max:100',
        'last_accessed_date' => 'required|date_format:Y-m-d H:i:s',
        'email'              => 'max:100',
        'first_name'         => 'max:50',
        'last_name'          => 'max:50'
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
        $status = null;
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
        $status = null;
        $response = [
            'status'  => null,
            'message' => 'Admin was added succesfully.',
            'data'    => []
        ];

        try {
            $validator = \Validator::make(Input::all(), $this->rules);

            if ($validator->fails()) {
                throw new Exception($validator->errors);
            }

            $this->admin->store(Input::all());
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
        $status = null;
        $response = [
            'status'  => null,
            'message' => 'Admin was updated succesfully.',
            'data'    => []
        ];

        try {
            $validator = \Validator::make(Input::all(), $this->rules);

            if ($validator->fails()) {
                throw new Exception($validator->errors());
            }

            $this->admin->update($adminId, Input::all());
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
        $status = null;
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
        $status = null;
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
        $status = null;
        $response = [
            'status'  => null,
            'message' => 'Admin was deleted successfully.',
            'data'    => []
        ];

        try {
            $deletedAdmin = $this->admin->destroy($adminId);
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
