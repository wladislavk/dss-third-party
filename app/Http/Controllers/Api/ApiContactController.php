<?php
namespace DentalSleepSolutions\Http\Controllers\Api;

use DentalSleepSolutions\Http\Requests\StoreContactRequest;
use DentalSleepSolutions\Http\Requests\UpdateContactRequest;
use DentalSleepSolutions\Helpers\ApiResponse;
use Illuminate\Support\Facades\Input;
use Mockery\CountValidator\Exception;
use Carbon\Carbon;

use DentalSleepSolutions\Interfaces\Repositories\ContactInterface;

class ApiContactController extends ApiBaseController
{
    /**
     * References the contact interface
     * 
     * @var $contact
     */
    protected $contact;

    /**
     * 
     * @param ContactInterface $contact
     */
    public function __construct(ContactInterface $contact)
    {
        $this->contact = $contact;
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $retrievedContacts = $this->contact->all();

        if (!count($retrievedContacts)) {
            return ApiResponse::responseError('The table is empty.', 422);
        }

        return ApiResponse::responseOk('Contacts list.', $retrievedContacts);
    }

    /**
     * 
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreContactRequest $request)
    {
        $postValues = array_merge($request->all(), [
            'adddate'    => Carbon::now(),
            'ip_address' => $request->ip()
        ]);

        $this->contact->store($postValues);

        return ApiResponse::responseOk('Contact was added successfully.', $this->contact->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateContactRequest $request, $id)
    {
        $this->contact->update($id, $request->all());

        return ApiResponse::responseOk('Contact was updated successfully.', $this->contact->all());
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $retrievedContact = $this->contact->find($id);

        if (empty($retrievedContact)) {
            return ApiResponse::responseError('Contact not found.', 422);
        }

        return ApiResponse::responseOk('Retrieved contact by id.', $retrievedContact);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit($id)
    {
        return ApiResponse::responseOk('Contact was edited successfully.', []);
    }

    /**
     * 
     * 
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $deletedContact = $this->contact->destroy($id);

        if (empty($deletedContact)) {
            return ApiResponse::responseError('Contact not found.', 422);
        }

        return ApiResponse::responseOk('Contact was deleted successfully.', $this->contact->all());
    }
}
