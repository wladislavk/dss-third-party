<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreChangeListRequest;
use DentalSleepSolutions\Http\Requests\UpdateChangeListRequest;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\Repositories\ChangeListInterface;

class ApiChangeListController extends ApiBaseController
{
    /**
     * References the change list interface
     * 
     * @var $changeList
     */
    protected $changeList;

    /**
     * 
     * @param ChangeListInterface $changeList
     */
    public function __construct(ChangeListInterface $changeList)
    {
        $this->changeList = $changeList;
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $retrievedChangeLists = $this->changeList->all();

        if (!count($retrievedChangeLists)) {
            return ApiResponse::responseError('The table is empty.', 422);
        }

        return ApiResponse::responseOk('Change lists list.', $retrievedChangeLists);
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreChangeListRequest $request)
    {
        $postValues = array_merge($request->all(), [
            'adddate'    => Carbon::now(),
            'ip_address' => $request->ip()
        ]);

        $this->changeList->store($postValues);

        return ApiResponse::responseOk('Change list was added successfully.', $this->changeList->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateChangeListRequest $request, $id)
    {
        $this->changeList->update($id, $request->all());

        return ApiResponse::responseOk('Change list was updated successfully.', $this->changeList->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $retrievedChangeList = $this->changeList->find($id);

        if (empty($retrievedChangeList)) {
            return ApiResponse::responseError('Change list not found.', 422);
        }

        return ApiResponse::responseOk('Retrieved change list by id.', $retrievedChangeList);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return ApiResponse::responseOk('Change list was edited successfully.', []);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deletedChangeList = $this->changeList->destroy($id);

        if (empty($deletedChangeList)) {
            return ApiResponse::responseError('Change list not found.', 422);
        }

        return ApiResponse::responseOk('Change list was deleted successfully.', $this->changeList->all());
    }
}
