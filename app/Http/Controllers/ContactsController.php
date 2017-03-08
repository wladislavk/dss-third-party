<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\ContactStore;
use DentalSleepSolutions\Http\Requests\ContactUpdate;
use DentalSleepSolutions\Http\Requests\ContactDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Contact;
use DentalSleepSolutions\Contracts\Repositories\Contacts;
use DentalSleepSolutions\Contracts\Repositories\Patients;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ContactsController extends Controller
{
    const DSS_REFERRED_PHYSICIAN = 2;

    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Contacts $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Contacts $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Contact $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Contact $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Contacts $resources
     * @param  \DentalSleepSolutions\Http\Requests\ContactStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Contacts $resources, ContactStore $request)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = array_merge($request->all(), [
            'ip_address' => $request->ip(),
            'docid'      => $docId
        ]);

        $resource = $resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Contact $resource
     * @param  \DentalSleepSolutions\Http\Requests\ContactUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Contact $resource, ContactUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Contact $resource
     * @param  \DentalSleepSolutions\Http\Requests\ContactDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Contact $resource, ContactDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    public function find(Contacts $resources, Request $request)
    {
        $docId = $this->currentUser->docid ?: 0;

        $contactType     = $request->input('contacttype') ?: 0;
        $status          = $request->input('status') ?: 0;
        $letter          = $request->input('letter') ?: '';
        $sortBy          = $request->input('sort_column') ?: '';
        $sortDir         = $request->input('sort_direction') ?: '';
        $page            = $request->input('page') ?: 0;
        $contactsPerPage = $request->input('contacts_per_page') ?: 0;

        $data = $resources->find(
            $contactType,
            $status,
            $docId,
            $letter,
            $sortBy,
            $sortDir,
            $page,
            $contactsPerPage
        );

        return ApiResponse::responseOk('', $data);
    }

    public function getListContactsAndCompanies(Contacts $resources, Request $request)
    {
        $docId = $this->currentUser->docid ?: 0;

        if ($request->has('partial_name')) {
            $partial = preg_replace("[^ A-Za-z'\-]", "", $request->input('partial_name'));
        } else {
            $partial = '';
        }

        if ($request->has('without_companies') && $request->input('without_companies')) {
            $searchForCompanies = false;
        } else {
            $searchForCompanies = true;
        }

        $names = explode(' ', $partial);

        $contactsAndCompanies = $resources->getListContactsAndCompanies($docId, $partial, $names, self::DSS_REFERRED_PHYSICIAN, $searchForCompanies);

        if (count($contactsAndCompanies)) {
            foreach ($contactsAndCompanies as $item) {
                $response[] = [
                    'id'     => $item->contactid,
                    'name'   => ($searchForCompanies ? $item->company . ' - ' : '') . $item->lastname . ', ' . $item->firstname . ' ' . $item->middlename . ' - ' . $item->contacttype,
                    'source' => $item->referral_type
                ];
            }
        } else {
            $response = [
                'error' => 'Error: No match found for this criteria.'
            ];
        }

        return ApiResponse::responseOk('', $response);
    }

    public function getWithContactType(Contact $resource, Request $request)
    {
        $contactId = $request->input('contact_id') ?: 0;
        $data = $resource->getWithContactType($contactId);

        return ApiResponse::responseOk('', $data);
    }

    public function getInsuranceContacts(Contacts $resource, Request $request)
    {
        $docId = $this->currentUser->docid ?: 0;
        $data = $resource->getInsuranceContacts($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getReferredByContacts(Contacts $resource, Patients $patients, Request $request)
    {
        $docId = $this->currentUser->docid ?: 0;

        $sort = $request->input('sort');
        $sortDir = $request->input('sortdir');
        $contactsPerPage = $request->input('contacts_per_page') ?: 10;

        $referredByContacts = $resource->getReferredByContacts($docId, $sort, $sortDir);

        if (count($referredByContacts) > 0) {
            $referredByContacts = $referredByContacts->toArray();
        } else {
            $referredByContacts = [];
        }

        for ($index = 0; $index < count($referredByContacts) && $index < $contactsPerPage; $index++) {
            $counters = $this->getReferralCountersForContact(
                $patients,
                $referredByContacts[$index]['contactid'],
                $referredByContacts[$index]['referral_type']
            );

            $name = ($referredByContacts[$index]['salutation'] ?: '')
                . (!empty($referredByContacts[$index]['firstname']) ? ' ' . $referredByContacts[$index]['firstname'] : '')
                . (!empty($referredByContacts[$index]['middlename']) ? ' ' . $referredByContacts[$index]['middlename'] : '')
                . (!empty($referredByContacts[$index]['lastname']) ? ' ' . $referredByContacts[$index]['lastname'] : '');

            $referredByContacts[$index] += $counters;
            $referredByContacts[$index]['name'] = $name;
        }

        $referredByContactsCollection = collect($referredByContacts);

        $sortColumn = '';
        $sortDirectionDesc = false;
        if (!empty($sort)) {
            $sortDirectionDesc = strtolower($sortDir) == 'desc';

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

            $referredByContactsCollection = $referredByContactsCollection->sort(
                function ($first, $second) use ($sortColumn, $sortDirectionDesc) {
                    if ($first->$sortColumn == $second->$sortColumn) {
                        return 0;
                    }

                    if ($sortDirectionDesc) {
                        return ($first < $second) ? -1 : 1;
                    }

                    return ($first > $second) ? -1 : 1;
                }
            );
        }

        return ApiResponse::responseOk('', $referredByContactsCollection);
    }

    private function getReferralCountersForContact(Patients $patients, $contactId, $contactType)
    {
        $counters = [];
        $ranges = [
            [0, 30],
            [30, 60],
            [60, 90],
            [90, 0]
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

            $counters[$key] = $patients->getReferralCountersForContact(
                $contactId,
                $contactType,
                $dateConditional
            );
        }

        return $counters;
    }
}
