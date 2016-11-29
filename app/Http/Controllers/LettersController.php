<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Http\Requests\LetterStore;
use DentalSleepSolutions\Http\Requests\LetterUpdate;
use DentalSleepSolutions\Http\Requests\LetterDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Letter;
use DentalSleepSolutions\Contracts\Repositories\Letters;
use DentalSleepSolutions\Contracts\Repositories\Patients;
use DentalSleepSolutions\Contracts\Resources\Contact;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class LettersController extends Controller
{
    const DSS_USER_TYPE_FRANCHISEE = 1;
    const DSS_USER_TYPE_SOFTWARE = 2;

    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Letters $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Letters $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Letter $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Letter $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Letters $resources
     * @param  \DentalSleepSolutions\Http\Requests\LetterStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Letters $resources, LetterStore $request)
    {
        $resource = $resources->create($request->all());

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Letter $resource
     * @param  \DentalSleepSolutions\Http\Requests\LetterUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Letter $resource, LetterUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Letter $resource
     * @param  \DentalSleepSolutions\Http\Requests\LetterDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Letter $resource, LetterDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    public function getPending(Letters $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getPending($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getUnmailed(Letters $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getUnmailed($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getGeneratedDateOfIntroLetter(Letter $resource, Request $request)
    {
        $patientId = $request->input('patient_id') ?: 0;

        $data = $resource->getGeneratedDateOfIntroLetter($patientId);

        return ApiResponse::responseOk('', $data);
    }

    public function triggerPatientTreatmentComplete(
        Letters $resources,
        Patients $patientsResource,
        Contact $contactResource,
        Request $request
    ) {
        $patientId = $request->input('patient_id') ?: 0;

        if ($patientId) {
            $currentPatient = $patientsResource->getWithFilter([
                'referred_source', 'docsleep', 'docpcp', 'docdentist',
                'docent', 'docmdother', 'docmdother2', 'docmdother3'
            ], [
                'patientid' => $patientId
            ]);
        }

        $patientReferralIds = $patientsResource->getPatientReferralIds($patientId, $currentPatient);

        $letterId = 0;

        if ($patientReferralIds) {
            $letters = $resources->getPatientTreatmentComplete($patientId, $patientReferralIds);

            if (!count($letters)) {
                $contactIds = $contactResource->getMdContactIds($patientId, $currentPatient);

                $letterId = $this->createLetter($letterid, $pid, '', '', '', '', $pt_referral_list);
            }
        }

        return ApiResponse::responseOk('', ['letter_id' => $letterId]);
    }

    public function triggerIntroLettersOf12Types(
        User $userResource,
        Letter $letterResource,
        Contact $contactResource,
        Request $request,
        $mdContacts = []
    ) {
        // trigger intro letter to MD from DSSFLLC and intro letter to MD from Franchisee

        $patientId = $request->input('patient_id') ?: 0;
        $docId = $this->currentUser->docid ?: 0;
        $userType = $this->currentUser->user_type ?: 0;

        $userLetterInfo = $userResource->getWithFilter(['use_letters', 'intro_letters'], [
            'userid' => $docId
        ]);

        if ($userLetterInfo && $userLetterInfo->use_letters && $userLetterInfo->intro_letters) {
            $letter1Id = 1;
            $letter2Id = 2;

            $recipients = [];
            if (count($mdContacts)) {
                foreach ($mdContacts as $contact) {
                    if ($contact != "Not Set") {
                        $mdLists = $letterResource->getMdList($contact, $letter1Id, $letter2Id);

                        if (count($mdLists) && $contact != "") {
                            $foundContact = $contactResource->getActiveContact($contact);

                            if ($foundContact) {
                                $recipients[] = $contact;
                            }
                        }
                    }
                }
            }

            $createdLetter1Id = 0;
            $createdLetter2Id = 0;

            if (count($recipients)) {
                $recipientsList = implode(',', $recipients);

                $createdLetter2Id = $this->createLetter($letter2Id, $patientId, '', '', $recipientsList);

                //DO NOT SENT LETTER 1 (FROM DSS) TO SOFTWARE USER
                if ($userType == self::DSS_USER_TYPE_SOFTWARE) {
                    $createdLetter1Id = $this->createLetter($letter1Id, $patientId, '', '', $recipientsList);
                }
            }

            $data = [
                'letter_1_id' => $createdLetter1Id,
                'letter_2_id' => $createdLetter2Id
            ];
        } else {
            $data = null;
        }

        return ApiResponse::responseOk('', $data);
    }

    public function triggerIntroLetterOf3Type(Request $request)
    {
        // trigger intro letter to DSS Patient of Record

        $patientId = $request->input('patient_id') ?: 0;
        $letterId = 3;
        $toPatient = 1;

        $letterId = $this->createLetter($letterId, $patientId, '', $toPatient);

        if ($letterId > 0) {
            $data = ['letter_id' => $letterId];
        } else {
            $data = null;
        }

        return ApiResponse::responseOk('', $data);
    }

    private function createLetter(User $userResource, Letter $letterResource, $data = []) {
        $docId = $this->currentUser->docid ?: 0;
        $userId = $this->currentUser->userid ?: 0;

        if ($docId > 0) {
            $user = $userResource->getWithFilter(['use_letters'], [
                'userid' => $docId
            ]);

            if ($user && $user->use_letters != 1) {
                return -1;
            }
        }

        if ((!$data['to_patient'] && !$data['md_referral_list'] && !$data['md_list'] && !$data['patient_referral_list']) ||
            ($data['check_recipient'] && !$data['md_referral_list'] && !$data['md_list'] &&
            ($data['templateid'] == 16 || $data['templateid'] == 19))
        ) {
            return false;
        }

        if (!isset($templateid)) {
            return "Error: Letter Template not specified";
        }

        //To remove referral source from md list if exists
        $mdArray = explode(',', $data['md_list']);
        $mdArray = array_filter($mdArray, [new MDReferralFilter($data['md_referral_list']), 'isReferrer']);
        $data['md_list'] = implode(',', $mdArray);

        $data['user_id'] = $userId;
        $data['doc_id'] = $docId;

        $createdLetter = $letterResource->createLetter($data);

        if ($createdLetter) {
            return $createdLetter->letterid;
        } else {
            return 0;
        }
    }
}
