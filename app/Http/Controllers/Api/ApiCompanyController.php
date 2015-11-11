<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\Request;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\Repositories\CompanyInterface;

class ApiCompanyController extends ApiBaseController
{
    /**
     * References the company interface
     * 
     * @var $company
     */
    protected $company;

    private $response;

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
        $retrievedCompanies = $this->company->all();

        if (!count($retrievedCompanies)) {
            throw new Exception('The table is empty.');
        }

        $this->response['message'] = 'Companies list.';
        $this->response['data']    = $retrievedCompanies;

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
        $validator  = \Validator::make($postValues, $this->rules);

        if ($validator->fails()) {
            throw new Exception($validator->errors());
        }

        $postValues = array_merge($postValues, [
            'adddate'    => Carbon::now(),
            'ip_address' => \Request::ip()
        ]);

        $this->company->store($postValues);

        $this->response['message'] = 'Company was added successfully.';
        $this->response['data']    = $this->company->all();

        return response()->json($this->response, 200);
    }

    /**
     * 
     * 
     * @param integer $id 
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $putValues = Input::all();
        $validator = \Validator::make($putValues, $this->rules);

        if ($validator->fails()) {
            throw new Exception($validator->errors());
        }

        $this->company->update($id, $putValues);

        $this->response['message'] = 'Company was updated successfully.';
        $this->response['data']    = $this->company->all();

        return response()->json($this->response, 200);
    }

    /**
     * 
     * 
     * @param integer $id 
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $retrievedCompany = $this->company->find($id);

        if (empty($retrievedCompany)) {
            throw new Exception('Company not found.');
        }

        $this->response['message'] = 'Retrieved company by id.';
        $this->response['data']    = $retrievedCompany;

        return response()->json($this->response, 200);
    }

    /**
     * 
     * 
     * @param integer $id 
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        $this->response['message'] = 'Company was edited successfully.';
        $this->response['data']    = [];

        return response()->json($this->response, 200);
    }

    /**
     * 
     * 
     * @param integer $id 
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deletedCompany   = $this->company->destroy($id);

        if (empty($deletedCompany)) {
            throw new Exception('Company not found.');
        }

        $this->response['message'] = 'Company was deleted successfully.';
        $this->response['data']    = $this->company->all();

        return response()->json($this->response, 200);
    }
}
