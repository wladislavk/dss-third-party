<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\Request;
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
     * Validation rules
     * 
     * @var $rules
     */
    private $rules = [
        'adminid'   => 'integer|required',
        'companyid' => 'integer|required'
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
    public function store()
    {
        $postValues = Input::all();
        $validator  = \Validator::make($postValues, $this->rules);

        if ($validator->fails()) {
            return ApiResponse::responseError($validator->errors(), 422);
        }

        $postValues['adddate']    = Carbon::now();
        $postValues['ip_address'] = \Request::ip();

        $this->adminCompany->store($postValues);

        return ApiResponse::responseOk('Admin company was added successfully.', $this->adminCompany->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        // if input data has an adminid and a companyid then these will be validated
        $this->rules['adminid']   = 'sometimes|' . $this->rules['adminid'];
        $this->rules['companyid'] = 'sometimes|' . $this->rules['companyid'];

        $validator = \Validator::make(Input::all(), $this->rules);

        if ($validator->fails()) {
            return ApiResponse::responseError($validator->errors(), 422);
        }

        $this->adminCompany->update($id, Input::all());

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
