<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreCompanyRequest;
use DentalSleepSolutions\Http\Requests\UpdateCompanyRequest;
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
    public function store(StoreCompanyRequest $request)
    {
        $postValues = array_merge($request->all(), [
            'adddate'    => Carbon::now(),
            'ip_address' => $request->ip()
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
    public function update(UpdateCompanyRequest $request, $id)
    {
        $this->company->update($id, $request->all());

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
        $deletedCompany = $this->company->destroy($id);

        if (empty($deletedCompany)) {
            return ApiResponse::responseError('Company not found.', 422);
        }

        return ApiResponse::responseOk('Company was deleted successfully.', $this->company->all());
    }
}
