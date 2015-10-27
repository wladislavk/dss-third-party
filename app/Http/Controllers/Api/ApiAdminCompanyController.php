<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\AdminCompanyInterface;

class ApiAdminCompanyController extends ApiBaseController
{
    /**
     * References the admin company interface
     * 
     * @var $adminCompany
     */
    protected $adminCompany;

    /**
     * Validation rules for the store method
     * 
     * @var $rulesForStore
     */
    private $rulesForStore = [
        'adminid'   => 'integer|required',
        'companyid' => 'integer|required'
    ];

    /**
     * Validation rules for the update method
     * 
     * @var $rulesForUpdate
     */
    private $rulesForUpdate = [
        'adminid'   => 'integer',
        'companyid' => 'integer'
    ];

    /**
     * 
     * @param AdminCompanyInterface $adminCompany 
     */
    public function __construct(AdminCompanyInterface $adminCompany)
    {
        $this->adminCompany = $adminCompany;
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
            'message' => 'Admin companies list.',
            'data'    => []
        ];

        try {
            $retrievedAdminCompanies = $this->adminCompany->all();

            if (!count($retrievedAdminCompanies)) {
                throw new Exception('The table is empty.');
            }

            $response['data']   = $retrievedAdminCompanies;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $status   = null;
        $response = [
            'status'  => null,
            'message' => 'Admin company was added successfully.',
            'data'    => []
        ];

        try {
            $postValues = Input::all();
            $validator  = \Validator::make($postValues, $this->rulesForStore);

            if ($validator->fails()) {
                throw new Exception($validator->errors());
            }

            $postValues['adddate']    = Carbon::now();
            $postValues['ip_address'] = \Request::ip();

            $this->adminCompany->store($postValues);
            $response['data']   = $this->adminCompany->all();
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
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $status   = null;
        $response = [
            'status'  => null,
            'message' => 'Admin company was updated successfully.',
            'data'    => []
        ];

        try {
            $validator = \Validator::make(Input::all(), $this->rulesForUpdate);

            if ($validator->fails()) {
                throw new Exception($validator->errors());
            }

            $this->adminCompany->update($id, Input::all());
            $response['data']   = $this->adminCompany->all();
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
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $status   = null;
        $response = [
            'status'  => null,
            'message' => 'Retrieved admin company by id.',
            'data'    => []
        ];

        try {
            $retrievedAdminCompany = $this->adminCompany->find($id);

            if (empty($retrievedAdminCompany)) {
                throw new Exception('Admin company not found.');
            }

            $response['data']   = $retrievedAdminCompany;
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
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $status   = null;
        $response = [
            'status'  => null,
            'message' => 'Admin company was edited successfully.',
            'data'    => []
        ];

        try {

        } catch (Exception $ex) {

        } finally {

        }
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $status   = null;
        $response = [
            'status'  => null,
            'message' => 'Admin company was deleted successfully.',
            'data'    => []
        ];

        try {
            $deletedAdminCompany = $this->adminCompany->destroy($id);
            $response['data']    = $this->adminCompany->all();

            if (empty($deletedAdminCompany)) {
                throw new Exception('Admin company not found.');
            }

            $response['status'] = true;
            $status             = 200;
        } catch (Exception $e) {
            $response['message'] = $ex->getMessage();
            $response['status']  = false;
            $status              = 404;
        } finally {
            return response()->json($response, $status);
        }
    }
}
