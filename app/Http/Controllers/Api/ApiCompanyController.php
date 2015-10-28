<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\CompanyInterface;

class ApiCompanyController extends ApiBaseController
{
    /**
     * References the company interface
     * 
     * @var $company
     */
    protected $company;

    /**
     * Validation rules for the store and update methods
     * 
     * @var array
     */
    private $rules = [
        'name'             => 'string',
        'city'             => 'string',
        'state'            => 'string',
        'zip'              => 'integer',
        'status'           => 'integer',
        'default_new'      => 'integer',
        'free_fax'         => 'integer',
        'company_type'     => 'integer',
        'plan_id'          => 'integer',
        'use_support'      => 'integer',
        'exclusive'        => 'integer',
        'vob_require_test' => 'integer'
    ];

    /**
     * 
     * @param CompanyInterface $company 
     */
    public function __construct(CompanyInterface $company)
    {
        $this->company = $company;
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
            'message' => 'Companies list.',
            'data'    => []
        ];

        try {
            $retrievedCompanies = $this->company->all();

            if (!count($retrievedCompanies)) {
                throw new Exception('The table is empty.');
            }

            $response['data']   = $retrievedCompanies;
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
            'message' => 'Company was added successfully.',
            'data'    => []
        ];

        try {
            $postValues = Input::all();
            $validator  = \Validator::make($postValues, $this->rules);

            if ($validator->fails()) {
                throw new Exception($validator->errors());
            }

            $postValues = array_merge($postValues, [
                'adddate'    => Carbon::now(),
                'ip_address' => \Request::ip()
            ]);

            $this->company->store($postValues);
            $response['data']   = $this->company->all();
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
            'message' => 'Company was updated successfully.',
            'data'    => []
        ];

        try {
            $putValues = Input::all();
            $validator = \Validator::make($putValues, $this->rules);

            if ($validator->fails()) {
                throw new Exception($validator->errors());
            }

            $putValues = array_merge($putValues, [
                
            ]);

            $this->company->update($id, $putValues);
            $response['data']   = $this->company->all();
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
            'message' => 'Retrieved company by id.',
            'data'    => []
        ];

        try {
            $retrievedCompany = $this->company->find($id);

            if (empty($retrievedCompany)) {
                throw new Exception('Company not found.');
            }

            $response['data']   = $retrievedCompany;
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
            'message' => 'Company was edited successfully.',
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
     * @param integer $id 
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $status   = null;
        $response = [
            'status'  => null,
            'message' => 'Company was deleted successfully.',
            'data'    => []
        ];

        try {
            $deletedCompany   = $this->company->destroy($id);
            $response['data'] = $this->company->all();

            if (empty($deletedCompany)) {
                throw new Exception('Company not found.');
            }

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
}
