<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreClaimTextRequest;
use DentalSleepSolutions\Http\Requests\UpdateClaimTextRequest;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;
use DentalSleepSolutions\Interfaces\Repositories\ClaimTextInterface;

class ApiClaimTextController extends ApiBaseController
{
    /**
     * References the claim text interface
     * 
     * @var $claimText
     */
    protected $claimText;

    /**
     * 
     * @param ClaimTextInterface $claimText 
     */
    public function __construct(ClaimTextInterface $claimText)
    {
        $this->claimText = $claimText;
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $retrievedClaimTexts = $this->claimText->all();

        if (!count($retrievedClaimTexts)) {
            return ApiResponse::responseError('The table is empty.', 422);
        }

        return ApiResponse::responseOk('Claim texts list.', $retrievedClaimTexts);
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreClaimTextRequest $request)
    {
        $postValues = array_merge($request->all(), [
            'adddate'    => Carbon::now(),
            'ip_address' => $request->ip()
        ]);

        $this->claimText->store($postValues);

        return ApiResponse::responseOk('Claim text was added successfully.', $this->claimText->all());
    }
    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateClaimTextRequest $request, $id)
    {
        $this->claimText->update($id, $request->all());

        return ApiResponse::responseOk('Claim text was updated successfully.', $this->claimText->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $retrievedClaimTexts = $this->claimText->find($id);

        if (empty($retrievedClaimTexts)) {
            return ApiResponse::responseError('Claim text not found.', 422);
        }

        return ApiResponse::responseOk('Retrieved claim text by id.', $retrievedClaimTexts);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return ApiResponse::responseOk('Claim text was edited successfully.', []);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deletedClaimTexts = $this->claimText->destroy($id);

        if (empty($deletedClaimTexts)) {
            return ApiResponse::responseError('Claim text not found.', 422);
        }

        return ApiResponse::responseOk('Claim text was deleted successfully.', $this->claimText->all());
    }
}
