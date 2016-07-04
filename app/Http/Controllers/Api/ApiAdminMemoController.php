<?php
/**
 * Created by PhpStorm.
 * User: Brendan
 * Date: 7/23/2015
 * Time: 10:27 AM
 */

namespace DentalSleepSolutions\Http\Controllers\Api;
use DentalSleepSolutions\Http\Requests\Request;
use \DentalSleepSolutions\Interfaces\MemoAdminInterface;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use DentalSleepSolutions\Helpers\ApiResponse;

class ApiAdminMemoController extends ApiBaseController
{

    /**
     * References the memo interface
     * @var $memo
     */
    protected $memo;

    private $rules = [
        'memo' => 'required',
        'off_date' => 'required|date_format:Y-m-d',
        'last_update' => 'required',
    ];

    /**
     *
     * @param MemoAdminInterface $memo
     */
    public function __construct(MemoAdminInterface $memo)
    {
        $this->memo = $memo;
    }

    public function index()
    {

        $status = null;
        $response = ['status' => null,'message' => 'Memo list','data' => []];
        try {
            $response['data'] = $this->memo->all();
            $response['status'] = true;
            $status = 200;
        } catch(Exception $ex) {
            $status = 404;
            $response['status'] = false;
        } finally {
            return response()->json($response,$status);
        }

    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store()
    {
        $status = null;
        $response = ['status' => null,'message' => 'Memo added successfully.','data' => []];

        try {

            $validator = \Validator::make(Input::all(),$this->rules);

            if($validator->fails())
            {
                throw new Exception($validator->errors());
            }

            $this->memo->store(Input::all());
            $response['data'] = $this->memo->all();
            $response['status'] = true;
            $status = 200;

        } catch(Exception $ex) {
            $status = 404;
            $response['status'] = false;
            $response['message'] = $ex->getMessage();
        } finally {
            return response()->json($response,$status);
        }

    }

    public function update($memo_id)
    {
        $status = null;
        $response = ['status' => null,'message' => 'Memo updated successfully.','data' => []];

        try {

            $validator = \Validator::make(Input::all(),$this->rules);

            if($validator->fails())
            {
                throw new Exception($validator->errors());
            }

            $this->memo->update($memo_id,Input::all());
            $response['data'] = $this->memo->all();
            $response['status'] = true;
            $status = 200;

        } catch(Exception $ex) {
            $status = 404;
            $response['status'] = false;
            $response['message'] = $ex->getMessage();
        } finally {
            return response()->json($response,$status);
        }

    }

    public function show($memo_id)
    {
        $status = null;
        $response = [];
        try {

        } catch(Exception $ex) {
            $status = 200;
            $response['status'] = false;
        } finally {

        }
    }

    public function edit($memo_id)
    {
        $status = null;
        $response = [];
        try {

        } catch(Exception $ex) {

        } finally {

        }
    }

    public function destroy($memo_id)
    {
        $status = null;
        $response = ['status' => null,'message' => 'Memo deleted successfully.','data' => []];
        try {
            $this->memo->destroy($memo_id);
            $response['data'] = $this->memo->all();
            $response['status'] = true;
            $status = 200;
        } catch(Exception $ex) {
            $status = 404;
            $response['status'] = false;
            $response['message'] = $ex->getMessage();
        } finally {
            return response()->json($response,$status);
        }

    }

    public function getCurrent()
    {
        $data = $this->memo->getCurrent();

        return ApiResponse::responseOk('', $data);
    }
}