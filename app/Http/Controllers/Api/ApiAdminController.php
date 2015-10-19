<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;

use \DentalSleepSolutions\Interfaces\AdminInterface;

class ApiAdminController extends ApiBaseController
{
    protected $admin;

    private $rules = [
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
            'message' => 'Admins list',
            'data'    => []
        ];

        try {
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
     * @param integer $adminId 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($adminId)
    {
        $status = null;
        $response = [
            'status'  => null,
            'message' => 'Admin was updated succesfully',
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
     * @param integer $adminId 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($adminId)
    {
        $status = null;
        $response = [
            'status'  => null,
            'message' => '',
            'data'    => []
        ];

        try {
            $response['data']   = $this->admin->find($adminId);
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
     * @param integer $adminId 
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($adminId)
    {
        $status = null;
        $response = [
            'status'  => null,
            'message' => 'Admin was edited successfully',
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
            $this->admin->destroy($adminId);
            $response['data']   = $this->admin->all();
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
