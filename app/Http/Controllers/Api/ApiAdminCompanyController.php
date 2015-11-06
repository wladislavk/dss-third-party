<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\Request;
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

    private $response;

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
        $retrievedAdminCompanies = $this->adminCompany->all();

        if (!count($retrievedAdminCompanies)) {
            throw new Exception('The table is empty.');
        }

        $this->response['message'] = 'Admin companies list.';
        $this->response['data']    = $retrievedAdminCompanies;

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
        $validator  = \Validator::make($postValues, $this->rulesForStore);

        if ($validator->fails()) {
            throw new Exception($validator->errors());
        }

        $postValues['adddate']    = Carbon::now();
        $postValues['ip_address'] = \Request::ip();

        $this->adminCompany->store($postValues);

        $this->response['message'] = 'Admin company was added successfully.';
        $this->response['data']    = $this->adminCompany->all();

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
        $validator = \Validator::make(Input::all(), $this->rulesForUpdate);

        if ($validator->fails()) {
            throw new Exception($validator->errors());
        }

        $this->adminCompany->update($id, Input::all());

        $this->response['message'] = 'Admin company was updated successfully.';
        $this->response['data']    = $this->adminCompany->all();

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
        $retrievedAdminCompany = $this->adminCompany->find($id);

        if (empty($retrievedAdminCompany)) {
            throw new Exception('Admin company not found.');
        }

        $this->response['message'] = 'Retrieved admin company by id.';
        $this->response['data']    = $retrievedAdminCompany;

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
        $this->response['message'] = 'Admin company was edited successfully.';
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
        $deletedAdminCompany = $this->adminCompany->destroy($id);

        if (empty($deletedAdminCompany)) {
            throw new Exception('Admin company not found.');
        }

        $this->response['message'] = 'Admin company was deleted successfully.';
        $this->response['data']    = $this->adminCompany->all();

        return response()->json($this->response, 200);
    }
}
