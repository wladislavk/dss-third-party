<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\Request;
use DentalSleepSolutions\Helpers\ApiResponse;
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
        $retrievedCompanies = $this->company->all();

        if (!count($retrievedCompanies)) {
            return ApiResponse::responseError('The table is empty.', 422);
        }

        return ApiResponse::responseOk('Companies list.', $retrievedCompanies);
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

        $postValues = array_merge($postValues, [
            'adddate'    => Carbon::now(),
            'ip_address' => \Request::ip()
        ]);

        $this->company->store($postValues);

        return ApiResponse::responseOk('Company was added successfully.', $this->company->all());
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
            return ApiResponse::responseError($validator->errors(), 422);
        }

        $this->company->update($id, $putValues);

        return ApiResponse::responseOk('Company was updated successfully.', $this->company->all());
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
            return ApiResponse::responseError('Company not found.', 422);
        }

        return ApiResponse::responseOk('Retrieved company by id.', $retrievedCompany);
    }

    /**
     * 
     * 
     * @param integer $id 
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return ApiResponse::responseOk('Company was edited successfully.', []);
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
            return ApiResponse::responseError('Company not found.', 422);
        }

        return ApiResponse::responseOk('Company was deleted successfully.', $this->company->all());
    }
}
