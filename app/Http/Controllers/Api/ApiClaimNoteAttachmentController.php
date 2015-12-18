<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreClaimNoteAttachmentRequest;
use DentalSleepSolutions\Http\Requests\UpdateClaimNoteAttachmentRequest;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\Repositories\ClaimNoteAttachmentInterface;

class ApiClaimNoteAttachmentController extends ApiBaseController
{
    /**
     * References the claim note attachment interface
     * 
     * @var $claimNoteAttachment
     */
    protected $claimNoteAttachment;

    /**
     * 
     * @param ClaimNoteAttachmentInterface $claimNoteAttachment
     */
    public function __construct(ClaimNoteAttachmentInterface $claimNoteAttachment)
    {
        $this->claimNoteAttachment = $claimNoteAttachment;
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $retrievedClaimNoteAttachments = $this->claimNoteAttachment->all();

        if (!count($retrievedClaimNoteAttachments)) {
            return ApiResponse::responseError('The table is empty.', 422);
        }

        return ApiResponse::responseOk('Claim note attachments list.', $retrievedClaimNoteAttachments);
    }

     /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreClaimNoteAttachmentRequest $request)
    {
        $postValues = array_merge($request->all(), [
            'adddate'    => Carbon::now(),
            'ip_address' => $request->ip()
        ]);

        $this->claimNoteAttachment->store($postValues);

        return ApiResponse::responseOk('Claim not attachment was added successfully.', $this->claimNoteAttachment->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateClaimNoteAttachmentRequest $request, $id)
    {
        $this->claimNoteAttachment->update($id, $request->all());

        return ApiResponse::responseOk('Claim note attachment was updated successfully.', $this->claimNoteAttachment->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $retrievedClaimNoteAttachment = $this->claimNoteAttachment->find($id);

        if (empty($retrievedClaimNoteAttachment)) {
            return ApiResponse::responseError('Claim note attachment not found.', 422);
        }

        return ApiResponse::responseOk('Retrieved claim note attachment by id.', $retrievedClaimNoteAttachment);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return ApiResponse::responseOk('Claim note attachment was edited successfully.', []);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deletedClaimNoteAttachment = $this->claimNoteAttachment->destroy($id);

        if (empty($deletedClaimNoteAttachment)) {
            return ApiResponse::responseError('Claim note attachment not found.', 422);
        }

        return ApiResponse::responseOk('Claim note attachment was deleted successfully.', $this->claimNoteAttachment->all());
    }
}
