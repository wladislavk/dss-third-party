<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreAdminCompanyRequest;
use DentalSleepSolutions\Http\Requests\UpdateAdminCompanyRequest;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\Repositories\AdminCompanyInterface;

class ApiAdminCompanyController extends ApiBaseController
{
    /**
     * References the admin company interface
     * 
     * @var $adminCompany
     */
    protected $adminCompany;

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
        $retrievedAdminCompanies = $this->adminCompany->all();

        if (!count($retrievedAdminCompanies)) {
            return ApiResponse::responseError('The table is empty.', 422);
        }

        return ApiResponse::responseOk('Admin companies list.', $retrievedAdminCompanies);
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreAdminCompanyRequest $request)
    {
        $postValues = array_merge($request->all(), [
            'adddate'    => Carbon::now(),
            'ip_address' => $request->ip()
        ]);

        $this->adminCompany->store($postValues);

        return ApiResponse::responseOk('Admin company was added successfully.', $this->adminCompany->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAdminCompanyRequest $request, $id)
    {
        $this->adminCompany->update($id, $request->all());

        return ApiResponse::responseOk('Admin company was updated successfully.', $this->adminCompany->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $retrievedAdminCompany = $this->adminCompany->find($id);

        if (empty($retrievedAdminCompany)) {
            return ApiResponse::responseError('Admin company not found.', 422);
        }

        return ApiResponse::responseOk('Retrieved admin company by id.', $retrievedAdminCompany);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return ApiResponse::responseOk('Admin company was edited successfully.', []);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deletedAdminCompany = $this->adminCompany->destroy($id);

        if (empty($deletedAdminCompany)) {
            return ApiResponse::responseError('Admin company not found.', 422);
        }

        return ApiResponse::responseOk('Admin company was deleted successfully.', $this->adminCompany->all());
    }
}
