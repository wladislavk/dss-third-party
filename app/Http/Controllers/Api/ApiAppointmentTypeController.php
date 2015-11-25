<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Request\Request;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\Repositories\AppointmentTypeInterface;

class ApiAppointmentTypeController extends ApiBaseController
{
    /**
     * References the appointment type interface
     * 
     * @var $apptType
     */
    protected $apptType;

    /**
     * Validation rules
     * 
     * @var $rules
     */
    private $rules = [
        'name'      => 'string',
        'color'     => 'required|string',
        'classname' => 'required|string',
        'docid'     => 'required|integer'
    ];

    /**
     * 
     * @param AdminCompanyInterface $adminCompany 
     */
    public function __construct(AppointmentTypeInterface $apptType)
    {
        $this->apptType = $apptType;
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $retrievedApptTypes = $this->apptType->all();

        if (!count($retrievedApptTypes)) {
            return ApiResponse::responseError('The table is empty', 422);
        }

        return ApiResponse::responseOk('Appointment types list.', $retrievedApptTypes);
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

        $this->apptType->store($postValues);

        return ApiResponse::responseOk('Appointment type was added successfully.', $this->apptType->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        // if input data has a color, a classname, a docid then these values will be validated
        $this->rules['color']     = 'sometimes|' . $this->rules['color'];
        $this->rules['classname'] = 'sometimes|' . $this->rules['classname'];
        $this->rules['docid']     = 'sometimes|' . $this->rules['docid'];

        $validator = \Validator::make(Input::all(), $this->rules);

        if ($validator->fails()) {
            return ApiResponse::responseError($validator->errors(), 422);
        }

        $this->apptType->update($id, Input::all());

        return ApiResponse::responseOk('Appointment type was updated successfully.', $this->apptType->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $retrievedApptType = $this->apptType->find($id);

        if (empty($retrievedApptType)) {
            return ApiResponse::responseError('Appointment type not found.', 422);
        }

        return ApiResponse::responseOk('Retrieved appointment type by id.', $retrievedApptType);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return ApiResponse::responseOk('Appointment type was edited successfully.', []);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deletedApptType = $this->apptType->destroy($id);

        if (empty($deletedApptType)) {
            return ApiResponse::responseError('Appointment type not found.', 422);
        }

        return ApiResponse::responseOk('Appointment type was deleted successfully.', $this->apptType->all());
    }
}
