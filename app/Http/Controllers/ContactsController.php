<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactRepository;
use DentalSleepSolutions\Helpers\ContactOrderRetriever;
use DentalSleepSolutions\Helpers\ContactsAndCompaniesRetriever;
use DentalSleepSolutions\Helpers\Paginator;
use DentalSleepSolutions\Helpers\QueryComposers\ContactsQueryComposer;
use DentalSleepSolutions\Helpers\ReferredContactParser;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use Illuminate\Http\Request;

class ContactsController extends BaseRestController
{
    const DSS_REFERRED_PHYSICIAN = 2;

    /** @var ContactRepository */
    protected $repository;

    /**
     * @SWG\Get(
     *     path="/contacts",
     *     @SWG\Response(
     *         response="200",
     *         description="Resources retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(
     *                         property="data",
     *                         type="array",
     *                         @SWG\Items(ref="#/definitions/Contact")
     *                     )
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function index()
    {
        return parent::index();
    }

    /**
     * @SWG\Get(
     *     path="/contacts/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Contact")
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function show($id)
    {
        return parent::show($id);
    }

    /**
     * @SWG\Post(
     *     path="/contacts",
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="salutation", in="formData", type="string"),
     *     @SWG\Parameter(name="lastname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="firstname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="middlename", in="formData", type="string"),
     *     @SWG\Parameter(name="company", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="add1", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="add2", in="formData", type="string"),
     *     @SWG\Parameter(name="city", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="state", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="zip", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="phone1", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="phone2", in="formData", type="string"),
     *     @SWG\Parameter(name="fax", in="formData", type="string"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email", required=true),
     *     @SWG\Parameter(name="national_provider_id", in="formData", type="string"),
     *     @SWG\Parameter(name="qualifier", in="formData", type="string"),
     *     @SWG\Parameter(name="qualifierid", in="formData", type="string"),
     *     @SWG\Parameter(name="greeting", in="formData", type="string"),
     *     @SWG\Parameter(name="sincerely", in="formData", type="string"),
     *     @SWG\Parameter(name="contacttypeid", in="formData", type="integer", required=true),
     *     @SWG\Parameter(name="notes", in="formData", type="string"),
     *     @SWG\Parameter(name="preferredcontact", in="formData", type="string"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="referredby_info", in="formData", type="integer"),
     *     @SWG\Parameter(name="referredby_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="merge_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="merge_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="corporate", in="formData", type="integer"),
     *     @SWG\Parameter(name="dea_number", in="formData", type="string"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Contact")
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function store()
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = array_merge($this->request->all(), [
            'ip_address' => $this->request->ip(),
            'docid' => $docId,
        ]);

        $resource = $this->repository->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * @SWG\Put(
     *     path="/contacts/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="salutation", in="formData", type="string"),
     *     @SWG\Parameter(name="lastname", in="formData", type="string"),
     *     @SWG\Parameter(name="firstname", in="formData", type="string"),
     *     @SWG\Parameter(name="middlename", in="formData", type="string"),
     *     @SWG\Parameter(name="company", in="formData", type="string"),
     *     @SWG\Parameter(name="add1", in="formData", type="string"),
     *     @SWG\Parameter(name="add2", in="formData", type="string"),
     *     @SWG\Parameter(name="city", in="formData", type="string"),
     *     @SWG\Parameter(name="state", in="formData", type="string"),
     *     @SWG\Parameter(name="zip", in="formData", type="string"),
     *     @SWG\Parameter(name="phone1", in="formData", type="string"),
     *     @SWG\Parameter(name="phone2", in="formData", type="string"),
     *     @SWG\Parameter(name="fax", in="formData", type="string"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email"),
     *     @SWG\Parameter(name="national_provider_id", in="formData", type="string"),
     *     @SWG\Parameter(name="qualifier", in="formData", type="string"),
     *     @SWG\Parameter(name="qualifierid", in="formData", type="string"),
     *     @SWG\Parameter(name="greeting", in="formData", type="string"),
     *     @SWG\Parameter(name="sincerely", in="formData", type="string"),
     *     @SWG\Parameter(name="contacttypeid", in="formData", type="integer"),
     *     @SWG\Parameter(name="notes", in="formData", type="string"),
     *     @SWG\Parameter(name="preferredcontact", in="formData", type="string"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="referredby_info", in="formData", type="integer"),
     *     @SWG\Parameter(name="referredby_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="merge_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="merge_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="corporate", in="formData", type="integer"),
     *     @SWG\Parameter(name="dea_number", in="formData", type="string"),
     *     @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function update($id)
    {
        return parent::update($id);
    }

    /**
     * @SWG\Delete(
     *     path="/contacts/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="Resource deleted", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     */
    public function destroy($id)
    {
        return parent::destroy($id);
    }

    /**
     * @SWG\Post(
     *     path="/contacts/find",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param ContactsQueryComposer $contactsQueryComposer
     * @param ContactOrderRetriever $contactOrderRetriever
     * @param Paginator $paginator
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function find(
        ContactsQueryComposer $contactsQueryComposer,
        ContactOrderRetriever $contactOrderRetriever,
        Paginator $paginator,
        Request $request
    ) {
        $docId = $this->currentUser->getDocIdOrZero();

        $contactType     = $request->input('contacttype', 0);
        $status          = $request->input('status', 1);
        $letter          = $request->input('letter', '');
        $sort            = $request->input('sort_column', '');
        $sortDir         = $request->input('sort_direction', '');
        $page            = $request->input('page', 0);
        $contactsPerPage = $request->input('contacts_per_page', 0);

        $orderByColumns = $contactOrderRetriever->getOrderByColumns($sort);

        $contacts = $contactsQueryComposer->composeFindContactQuery(
            $contactType,
            $status,
            $docId,
            $letter,
            $sortDir,
            $orderByColumns
        )->toArray();

        $totalCount = count($contacts);
        $contacts = $paginator->limitResultToPage($contacts, $page, $contactsPerPage);

        $data = [
            'totalCount' => $totalCount,
            'result'     => $contacts,
        ];

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/contacts/list-contacts-and-companies",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param ContactsAndCompaniesRetriever $contactsAndCompaniesRetriever
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListContactsAndCompanies(
        ContactsAndCompaniesRetriever $contactsAndCompaniesRetriever,
        Request $request
    ) {
        $docId = $this->currentUser->docid ?: 0;
        $withoutCompanies = boolval($request->input('without_companies', false));

        $partial = $request->input('partial_name', '');

        $response = $contactsAndCompaniesRetriever
            ->retrieveContactsAndCompanies($docId, $partial, $withoutCompanies);

        return ApiResponse::responseOk('', $response);
    }

    /**
     * @SWG\Post(
     *     path="/contacts/with-contact-type",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithContactType(Request $request)
    {
        $contactId = $request->input('contact_id', 0);
        $data = $this->repository->getWithContactType($contactId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/contacts/insurance",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getInsuranceContacts(Request $request)
    {
        $docId = $this->currentUser->docid ?: 0;
        $data = $this->repository->getInsuranceContacts($docId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/contacts/referred-by",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param ContactOrderRetriever $contactOrderRetriever
     * @param ReferredContactParser $referredContactParser
     * @param Paginator $paginator
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReferredByContacts(
        ContactOrderRetriever $contactOrderRetriever,
        ReferredContactParser $referredContactParser,
        Paginator $paginator,
        Request $request
    ) {
        $docId = $this->currentUser->docid ?: 0;

        $page = $request->input('page', 0);
        $sort = $request->input('sort', '');
        $sortDir = $request->input('sortdir', 'asc');
        $contactsPerPage = $request->input('contacts_per_page', 0);
        $isDetailed = $request->input('detailed', false);

        $orderByColumns = $contactOrderRetriever->getContactsOrderByColumns($sort);
        $referredByContacts = $this->repository
            ->getReferredByContacts($docId, $orderByColumns, $sortDir);

        $referredByContacts = $paginator->limitResultToPage($referredByContacts, $page, $contactsPerPage);

        $newContacts = $referredContactParser
            ->parseReferredContacts($referredByContacts, $sort, $sortDir, $isDetailed);

        $response = [
            'total'    => count($newContacts),
            'contacts' => $newContacts,
        ];

        return ApiResponse::responseOk('', $response);
    }

    /**
     * @SWG\Post(
     *     path="/contacts/corporate",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @param ContactOrderRetriever $contactOrderRetriever
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCorporateContacts(Request $request, ContactOrderRetriever $contactOrderRetriever)
    {
        $page = $request->input('page', 0);
        $rowsPerPage = $request->input('rows_per_page', 10);
        $sort = $request->input('sort', '');
        $sortDir = $request->input('sort_dir', 'asc');

        $orderByColumns = $contactOrderRetriever->getCorporateOrderByColumns($sort);
        $contacts = $this->repository->getCorporate($page, $rowsPerPage, $orderByColumns, $sortDir);

        return ApiResponse::responseOk('', $contacts);
    }
}
