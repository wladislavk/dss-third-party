<?php

namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Eloquent\Repositories\Dental\UserRepository;
use DentalSleepSolutions\Eloquent\Repositories\MemoAdminRepository;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Tymon\JWTAuth\JWTAuth;

class ApiAdminMemoController extends ApiBaseController
{
    /** @var MemoAdminRepository */
    protected $repository;

    /** @var array */
    private $rules = [
        'memo' => 'required',
        'off_date' => 'required|date_format:Y-m-d',
        'last_update' => 'required',
    ];

    public function __construct(
        JWTAuth $auth,
        UserRepository $userRepository,
        MemoAdminRepository $memoAdminRepository
    ) {
        parent::__construct($auth, $userRepository);
        $this->repository = $memoAdminRepository;
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
        $response = ['status' => null, 'message' => 'Memo list', 'data' => []];
        try {
            $response['data'] = $this->repository->allWithOrder('memo_id');
            $response['status'] = true;
            $status = 200;
        } catch (Exception $ex) {
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
            $validator = \Validator::make(Input::all(), $this->rules);
            if ($validator->fails()) {
                throw new Exception($validator->errors());
            }
            $this->repository->create(Input::all());
            $response['data'] = $this->repository->allWithOrder('memo_id');
            $response['status'] = true;
            $status = 200;
        } catch (Exception $ex) {
            $status = 404;
            $response['status'] = false;
            $response['message'] = $ex->getMessage();
        } finally {
            return response()->json($response, $status);
        }
    }

    /**
     * @SWG\Put(
     *     path="/memo/{memoId}",
     *     @SWG\Parameter(name="memoId", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $memoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($memoId)
    {
        $status = null;
        $response = ['status' => null, 'message' => 'Memo updated successfully.', 'data' => []];
        try {
            $validator = \Validator::make(Input::all(), $this->rules);
            if ($validator->fails()) {
                // @todo: uncaught exceptions should not be thrown in controller actions
                throw new Exception($validator->errors());
            }
            $this->repository->update(Input::all(), $memoId);
            $response['data'] = $this->repository->allWithOrder('memo_id');
            $response['status'] = true;
            $status = 200;
        } catch (Exception $ex) {
            $status = 404;
            $response['status'] = false;
            $response['message'] = $ex->getMessage();
        } finally {
            return response()->json($response,$status);
        }
    }

    /**
     * @SWG\Get(
     *     path="/memo/{memoId}",
     *     @SWG\Parameter(name="memoId", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $memoId
     */
    public function show($memoId)
    {
        $status = null;
        $response = [];
        try {
            // @todo: complete this code
        } catch (Exception $ex) {
            $status = 200;
            $response['status'] = false;
        } finally {
            // @todo: complete this code
        }
    }

    /**
     * @SWG\Delete(
     *     path="/memo/{memo_id}",
     *     @SWG\Parameter(name="memo_id", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $memoId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($memoId)
    {
        $status = null;
        $response = ['status' => null, 'message' => 'Memo deleted successfully.', 'data' => []];
        try {
            $this->repository->delete($memoId);
            $response['data'] = $this->repository->allWithOrder('memo_id');
            $response['status'] = true;
            $status = 200;
        } catch (Exception $ex) {
            $status = 404;
            $response['status'] = false;
            $response['message'] = $ex->getMessage();
        } finally {
            return response()->json($response, $status);
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
        $data = $this->repository->getCurrent();
        return ApiResponse::responseOk('', $data);
    }
}
