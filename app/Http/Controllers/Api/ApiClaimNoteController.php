<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreClaimNoteRequest;
use DentalSleepSolutions\Http\Requests\UpdateClaimNoteRequest;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\Repositories\ClaimNoteInterface;

class ApiClaimNoteController extends ApiBaseController
{
    /**
     * References the claim note interface
     * 
     * @var $claimNote
     */
    protected $claimNote;

     /**
     * 
     * @param ClaimNoteInterface $claimNote
     */
    public function __construct(ClaimNoteInterface $claimNote)
    {
        $this->claimNote = $claimNote;
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $retrievedClaimNotes = $this->claimNote->all();

        if (!count($retrievedClaimNotes)) {
            return ApiResponse::responseError('The table is empty.', 422);
        }

        return ApiResponse::responseOk('Claim notes list.', $retrievedClaimNotes);
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreClaimNoteRequest $request)
    {
        $postValues = array_merge($request->all(), [
            'adddate'    => Carbon::now(),
            'ip_address' => $request->ip()
        ]);

        $this->claimNote->store($postValues);

        return ApiResponse::responseOk('Claim note was added successfully.', $this->claimNote->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateClaimNoteRequest $request, $id)
    {
        $this->claimNote->update($id, $request->all());

        return ApiResponse::responseOk('Claim note was updated successfully.', $this->claimNote->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $retrievedClaimNote = $this->claimNote->find($id);

        if (empty($retrievedClaimNote)) {
            return ApiResponse::responseError('Claim note not found.', 422);
        }

        return ApiResponse::responseOk('Retrieved claim note by id.', $retrievedClaimNote);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return ApiResponse::responseOk('Claim note was edited successfully.', []);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deletedClaimNote = $this->claimNote->destroy($id);

        if (empty($deletedClaimNote)) {
            return ApiResponse::responseError('Claim note not found.', 422);
        }

        return ApiResponse::responseOk('Claim note was deleted successfully.', $this->claimNote->all());
    }
}
