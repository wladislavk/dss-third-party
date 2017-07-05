<?php

namespace DentalSleepSolutions\Http\Controllers\Api;

use \DentalSleepSolutions\Interfaces\MemoAdminInterface;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use DentalSleepSolutions\StaticClasses\ApiResponse;

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

    /**
     * @SWG\Get(
     *     path="/memo",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
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
     * @SWG\Post(
     *     path="/memo",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
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

    /**
     * @SWG\Put(
     *     path="/memo/{memo_id}",
     *     @SWG\Parameter(name="memo_id", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $memo_id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @SWG\Get(
     *     path="/memo/{memo_id}",
     *     @SWG\Parameter(name="memo_id", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param $memo_id
     */
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

    /**
     * @SWG\Delete(
     *     path="/memo/{memo_id}",
     *     @SWG\Parameter(name="memo_id", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $memo_id
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * @SWG\Post(
     *     path="/memos/current",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCurrent()
    {
        $data = $this->memo->getCurrent();

        return ApiResponse::responseOk('', $data);
    }
}
