<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
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
        $data = array_merge($this->request->all(), [
            'ip_address' => $this->request->ip(),
            'docid' => $this->user->docid,
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
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function find(Request $request)
    {
        $contactType     = $request->input('contacttype', 0);
        $status          = $request->input('status', 0);
        $letter          = $request->input('letter', '');
        $sortBy          = $request->input('sort_column', '');
        $sortDir         = $request->input('sort_direction', '');
        $page            = $request->input('page', 0);
        $contactsPerPage = $request->input('contacts_per_page', 0);

        $data = $this->repository->findContact(
            $contactType,
            $status,
            $this->user->docid,
            $letter,
            $sortBy,
            $sortDir,
            $page,
            $contactsPerPage
        );

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/contacts/list-contacts-and-companies",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListContactsAndCompanies(Request $request)
    {
        $partial = '';
        if ($request->has('partial_name')) {
            $partial = preg_replace("[^ A-Za-z'\-]", "", $request->input('partial_name'));
        }

        $searchForCompanies = true;
        if ($request->has('without_companies') && $request->input('without_companies')) {
            $searchForCompanies = false;
        }

        $names = explode(' ', $partial);

        $contactsAndCompanies = $this->repository->getListContactsAndCompanies(
            $this->user->docid, $partial, $names, self::DSS_REFERRED_PHYSICIAN, $searchForCompanies
        );

        $response = [
            'error' => 'Error: No match found for this criteria.'
        ];
        if (count($contactsAndCompanies)) {
            foreach ($contactsAndCompanies as $item) {
                $response[] = [
                    'id'     => $item->contactid,
                    'name'   => ($searchForCompanies ? $item->company . ' - ' : '') . $item->lastname . ', ' . $item->firstname . ' ' . $item->middlename . ' - ' . $item->contacttype,
                    'source' => $item->referral_type,
                ];
            }
        }

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
        $data = $this->repository->getInsuranceContacts($this->user->docid);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/contacts/referred-by",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param PatientRepository $patientRepository
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReferredByContacts(PatientRepository $patientRepository, Request $request)
    {
        $page = $request->input('page', 0);
        $sort = $request->input('sort');
        $sortDir = $request->input('sortdir');
        $contactsPerPage = $request->input('contacts_per_page', 0);
        $isDetailed = $request->input('detailed', false);

        $referredByContacts = $this->repository->getReferredByContacts($this->user->docid, $sort, $sortDir);

        $referredByContactsTotalNumber = count($referredByContacts);
        if ($contactsPerPage > 0) {
            if (count($referredByContacts)) {
                $referredByContacts = $referredByContacts->slice($page * $contactsPerPage, $contactsPerPage);
            }
        }

        $referredByContacts->map(function ($contact) use ($patientRepository, $isDetailed) {
            $counters = $this->getReferralCountersForContact(
                $patientRepository,
                $contact->contactid,
                $contact->referral_type,
                $isDetailed
            );

            foreach ($counters as $field => $value) {
                $contact[$field] = $value;
            }

            $name = ($contact->salutation ?: '')
                . (!empty($contact->firstname) ? ' ' . $contact->firstname : '')
                . (!empty($contact->middlename) ? ' ' . $contact->middlename : '')
                . (!empty($contact->lastname) ? ' ' . $contact->lastname : '');

            $contact['name'] = $name;

            return $contact;
        });

        switch ($sort) {
            case 'thirty':
                $sortColumn = 'num_ref30';
                break;

            case 'sixty':
                $sortColumn = 'num_ref60';
                break;

            case 'ninty':
                $sortColumn = 'num_ref90';
                break;

            case 'nintyplus':
                $sortColumn = 'num_ref90plus';
                break;

            default:
                $sortColumn = '';
                break;
        }

        if (!empty($sortColumn)) {
            $referredByContacts->sort(function ($first, $second) use ($sortColumn, $sortDir) {
                if ($first->$sortColumn == $second->$sortColumn) {
                    return 0;
                }

                if (strtolower($sortDir) === 'desc') {
                    return ($first->$sortColumn < $second->$sortColumn) ? -1 : 1;
                }

                return ($first->$sortColumn > $second->$sortColumn) ? -1 : 1;
            });
        }

        $response = [
            'total'    => $referredByContactsTotalNumber,
            'contacts' => $referredByContacts->values()->all()
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCorporateContacts(Request $request)
    {
        $page = $request->input('page', 0);
        $rowsPerPage = $request->input('rows_per_page', 10);
        $sort = $request->input('sort');
        $sortDir = $request->input('sort_dir', 'asc');

        $contacts = $this->repository->getCorporate($page, $rowsPerPage, $sort, $sortDir);

        return ApiResponse::responseOk('', $contacts);
    }

    /**
     * @param PatientRepository $patientRepository
     * @param int $contactId
     * @param int $contactType
     * @param bool $isDetailed
     * @return array
     */
    private function getReferralCountersForContact(
        PatientRepository $patientRepository,
        $contactId,
        $contactType,
        $isDetailed
    ) {
        $counters = [];
        $ranges = [
            [0, 30],
            [30, 60],
            [60, 90],
            [90, 0],
        ];

        foreach ($ranges as $range) {
            if ($range[1]) {
                $key = "num_ref{$range[1]}";
                $dateConditional = "BETWEEN DATE_SUB(CURDATE(), INTERVAL {$range[1]} DAY) AND " .
                    ($range[0] ? "DATE_SUB(CURDATE(), INTERVAL {$range[0]} DAY)" : 'CURDATE()');
            } else {
                $key = "num_ref{$range[0]}plus";
                $dateConditional = "< DATE_SUB(CURDATE(), INTERVAL {$range[0]} DAY)";
            }

            $counters[$key] = $patientRepository->getReferralCountersForContact(
                $contactId, $contactType, $dateConditional, $isDetailed
            );
        }

        return $counters;
    }
}
