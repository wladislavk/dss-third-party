<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Contracts\Resources\Contact;
use DentalSleepSolutions\Contracts\Repositories\Contacts;
use DentalSleepSolutions\Contracts\Repositories\Patients;
use Illuminate\Http\Request;

class ContactsController extends Controller
{
    const DSS_REFERRED_PHYSICIAN = 2;

    public function index()
    {
        return parent::index();
    }

    public function show($id)
    {
        return parent::show($id);
    }

    public function store()
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = array_merge($this->request->all(), [
            'ip_address' => $this->request->ip(),
            'docid' => $docId,
        ]);

        $resource = $this->resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    public function update($id)
    {
        return parent::update($id);
    }

    public function destroy($id)
    {
        return parent::destroy($id);
    }

    public function find(Contacts $resources, Request $request)
    {
        $docId = $this->currentUser->docid ?: 0;

        $contactType     = $request->input('contacttype', 0);
        $status          = $request->input('status', 0);
        $letter          = $request->input('letter', '');
        $sortBy          = $request->input('sort_column', '');
        $sortDir         = $request->input('sort_direction', '');
        $page            = $request->input('page', 0);
        $contactsPerPage = $request->input('contacts_per_page', 0);

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

        $partial = '';
        if ($request->has('partial_name')) {
            $partial = preg_replace("[^ A-Za-z'\-]", "", $request->input('partial_name'));
        }

        $searchForCompanies = true;
        if ($request->has('without_companies') && $request->input('without_companies')) {
            $searchForCompanies = false;
        }

        $names = explode(' ', $partial);

        $contactsAndCompanies = $resources->getListContactsAndCompanies(
            $docId, $partial, $names, self::DSS_REFERRED_PHYSICIAN, $searchForCompanies
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

    public function getWithContactType(Contact $resource, Request $request)
    {
        $contactId = $request->input('contact_id', 0);
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

        $page = $request->input('page', 0);
        $sort = $request->input('sort');
        $sortDir = $request->input('sortdir');
        $contactsPerPage = $request->input('contacts_per_page', 0);
        $isDetailed = $request->input('detailed', false);

        $referredByContacts = $resource->getReferredByContacts($docId, $sort, $sortDir, $page);

        $referredByContactsTotalNumber = count($referredByContacts);
        if ($contactsPerPage > 0) {
            $referredByContacts = [];
            if (count($referredByContacts)) {
                $referredByContacts = array_slice($referredByContacts, $page * $contactsPerPage, $contactsPerPage);
            }
        }

        $referredByContacts = array_map(function ($contact) use ($patients, $isDetailed) {
            $counters = $this->getReferralCountersForContact(
                $patients,
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
        }, $referredByContacts);

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
            $referredByContacts = array_sort( $referredByContacts, function ($first, $second) use ($sortColumn, $sortDir) {
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

    public function getCorporateContacts(Contacts $resource, Request $request)
    {
        $page = $request->input('page', 0);
        $rowsPerPage = $request->input('rows_per_page', 10);
        $sort = $request->input('sort');
        $sortDir = $request->input('sort_dir', 'asc');

        $contacts = $resource->getCorporate($page, $rowsPerPage, $sort, $sortDir);

        return ApiResponse::responseOk('', $contacts);
    }

    private function getReferralCountersForContact(Patients $patients, $contactId, $contactType, $isDetailed)
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
                $dateConditional,
                $isDetailed
            );
        }

        return $counters;
    }
}
