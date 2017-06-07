<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Exceptions\IncorrectEmailException;
use DentalSleepSolutions\Factories\PatientEditorFactory;
use DentalSleepSolutions\Helpers\AccessCodeResetter;
use DentalSleepSolutions\Helpers\EmailChecker;
use DentalSleepSolutions\Helpers\TempPinDocumentCreator;
use DentalSleepSolutions\Temporary\PatientFormDataUpdater;
use DentalSleepSolutions\Helpers\PatientRuleRetriever;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Requests\PatientStore;
use DentalSleepSolutions\Http\Requests\PatientUpdate;
use DentalSleepSolutions\Http\Requests\PatientDestroy;
use DentalSleepSolutions\Contracts\Repositories\Patients;
use DentalSleepSolutions\Contracts\Resources\InsurancePreauth;
use DentalSleepSolutions\Contracts\Repositories\Summaries;
use DentalSleepSolutions\Contracts\Resources\Letter;
use DentalSleepSolutions\Contracts\Resources\Contact;
use DentalSleepSolutions\Contracts\Resources\ProfileImage;
use DentalSleepSolutions\Contracts\Repositories\HomeSleepTests;
use DentalSleepSolutions\Contracts\Repositories\Notifications;
use DentalSleepSolutions\Http\Requests\PatientSummaryUpdate;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\PatientSummary;
use DentalSleepSolutions\Structs\PressedButtons;
use DentalSleepSolutions\Structs\RequestedEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PatientsController extends Controller
{
    const DSS_REFERRED_PATIENT = 1;
    const DSS_REFERRED_PHYSICIAN = 2;
    const DSS_REFERRED_MEDIA = 3;
    const DSS_REFERRED_FRANCHISE = 4;
    const DSS_REFERRED_DSSOFFICE = 5;
    const DSS_REFERRED_OTHER = 6;

    /**
     * @param Patients $resources
     * @return JsonResponse
     */
    public function index(Patients $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @param Patient $resource
     * @return JsonResponse
     */
    public function show(Patient $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * @param Patients $resources
     * @param PatientStore $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Patients $resources, PatientStore $request)
    {
        $data = array_merge($request->all(), [
            'ip_address' => $request->ip()
        ]);

        $resource = $resources->create($data);

        return ApiResponse::responseOk('Resource created', $resource);
    }

    /**
     * @param  Patient $resource
     * @param  PatientUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Patient $resource, PatientUpdate $request)
    {
        $resource->update($request->all());

        return ApiResponse::responseOk('Resource updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Patient $resource
     * @param  \DentalSleepSolutions\Http\Requests\PatientDestroy $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Patient $resource, PatientDestroy $request)
    {
        $resource->delete();

        return ApiResponse::responseOk('Resource deleted');
    }

    /**
     * Get patients by filter.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Patients $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithFilter(Patients $resources, Request $request)
    {
        $fields = $request->input('fields') ?: [];
        $where  = $request->input('where') ?: [];

        $patients = $resources->getWithFilter($fields, $where);

        return ApiResponse::responseOk('', $patients);
    }

    public function getNumber(Patients $resources)
    {
        $docId = $this->currentUser->getDocIdOrZero();
        $data = $resources->getNumber($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getDuplicates(Patients $resources)
    {
        $docId = $this->currentUser->getDocIdOrZero();
        $data = $resources->getDuplicates($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getBounces(Patients $resources)
    {
        $docId = $this->currentUser->getDocIdOrZero();
        $data = $resources->getBounces($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getListPatients(Patients $resources, Request $request)
    {
        $partialName = $request->input('partial_name', '');
        $partialName = preg_replace("[^ A-Za-z'\-]", '', $partialName);

        $names = explode(' ', $partialName);

        $docId = $this->currentUser->getDocIdOrZero();
        $data = $resources->getListPatients($docId, $names);

        return ApiResponse::responseOk('', $data);
    }

    public function destroyForDoctor($patientId, Patient $resource)
    {
        $docId = $this->currentUser->getDocIdOrZero();
        $resource->deleteForDoctor($patientId, $docId);

        return ApiResponse::responseOk('Resource deleted');
    }

    public function find(Patients $resources, Request $request)
    {
        $docId = $this->currentUser->getDocIdOrZero();
        $userType = $this->currentUser->getUserTypeOrZero();

        $patientId       = $request->input('patientId', 0);
        $type            = $request->input('type', 1);
        $pageNumber      = $request->input('page', 0);
        $patientsPerPage = $request->input('patientsPerPage', 30);
        $letter          = $request->input('letter', '');
        $sortColumn      = $request->input('sortColumn', 'name');
        $sortDir         = $request->input('sortDir', '');

        $data = $resources->findBy(
            $docId,
            $userType,
            $patientId,
            $type,
            $pageNumber,
            $patientsPerPage,
            $letter,
            $sortColumn,
            $sortDir
        );

        return ApiResponse::responseOk('', $data);
    }

    public function getReferredByContact(Patients $resources, Request $request)
    {
        $contactId = $request->input('contact_id', 0);
        $data = $resources->getReferredByContact($contactId);

        return ApiResponse::responseOk('', $data);
    }

    public function getByContact(Patients $resources, Request $request)
    {
        $contactId = $request->input('contact_id', 0);
        $data = $resources->getByContact($contactId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @param PatientEditorFactory $patientEditorFactory
     * @param PatientRuleRetriever $patientRuleRetriever
     * @param PatientFormDataUpdater $patientFormDataUpdater
     * @param Patient $patientModel
     * @param PatientSummary $patientSummaryModel
     * @param Request $request
     * @param int $patientId
     * @return JsonResponse
     */
    public function editingPatient(
        PatientEditorFactory $patientEditorFactory,
        PatientRuleRetriever $patientRuleRetriever,
        PatientFormDataUpdater $patientFormDataUpdater,
        Patient $patientModel,
        PatientSummary $patientSummaryModel,
        Request $request,
        $patientId = 0
    ) {
        $docId = $this->currentUser->getDocIdOrZero();
        // TODO: this block should be decoupled into a different controller action
        if ($request->has('tracker_notes')) {
            $trackerNotes = $request->input('tracker_notes');
            $this->validate($request, (new PatientSummaryUpdate())->rules());
            $patientSummaryModel->updateTrackerNotes($patientId, $docId, $trackerNotes);
            return ApiResponse::responseOk('', ['tracker_notes' => 'Tracker notes were successfully updated.']);
        }

        if (!$request->has('patient_form_data')) {
            return ApiResponse::responseError('Patient data is empty.', 422);
        }
        $patientFormData = $request->input('patient_form_data', []);
        $patientFormDataUpdater->setPatientFormData($patientFormData);

        $requestData = new EditPatientRequestData();
        $requestData->requestedEmails = new RequestedEmails($request->input('requested_emails', []));
        $requestData->pressedButtons = new PressedButtons($request->input('pressed_buttons', []));
        $requestData->patientLocation = $patientFormDataUpdater->getPatientLocation();

        $patientEditor = $patientEditorFactory->getPatientEditor($patientId);
        $rules = $patientRuleRetriever->getValidationRules($patientId);
        $validator = $this->getValidationFactory()->make($patientFormData, $rules);
        if ($validator->fails()) {
            return ApiResponse::responseError('', 422, $validator->getMessageBag()->all());
        }

        $unchangedPatient = null;
        try {
            $unchangedPatient = $patientModel->getUnchangedPatient($patientId);
        } catch (GeneralException $e) {
            return ApiResponse::responseError($e->getMessage(), 422);
        }
        if ($unchangedPatient) {
            $patientFormDataUpdater->setEmailBounce($unchangedPatient);
            $patientFormDataUpdater->modifyLogin($unchangedPatient->login);
        }
        $requestData->hasPatientPortal = $patientFormDataUpdater->getHasPatientPortal($docId);
        $requestData->shouldSendIntroLetter = $patientFormDataUpdater->shouldSendIntroLetter();
        $requestData->patientName = $patientFormDataUpdater->getPatientName();
        $requestData->mdContacts = $patientFormDataUpdater->setMDContacts();
        $requestData->ssn = $patientFormDataUpdater->getSSN();
        $requestData->newEmail = $patientFormDataUpdater->getNewEmail();
        $requestData->cellphone = $patientFormDataUpdater->getCellphone();
        $requestData->referrer = $patientFormDataUpdater->setReferrer();
        $requestData->isInfoComplete = $patientFormDataUpdater->isInfoComplete();
        $requestData->insuranceInfo = $patientFormDataUpdater->setInsuranceInfo();
        $requestData->ip = $request->ip();

        $updatedFormData = $patientFormDataUpdater->getPatientFormData();
        $responseData = $patientEditor->editPatient(
            $updatedFormData, $this->currentUser, $requestData, $unchangedPatient
        );

        return ApiResponse::responseOk('', $responseData->toArray());
    }

    public function getDataForFillingPatientForm(
        InsurancePreauth $insPreauthResource,
        Patient $patientResource,
        Contact $contactResource,
        Summaries $summariesResource,
        ProfileImage $profileImageResource,
        Letter $letterResource,
        HomeSleepTests $homeSleepTestResource,
        Notifications $notificationResource,
        Request $request
    ) {
        $patientId = $request->input('patient_id', 0);
        $foundPatient = $patientResource->find($patientId);

        $data = [];
        if (!empty($foundPatient)) {
            $formedFullNames = [];
            // fields for getting certain short info and forming full name 
            $docFields = [
                'docsleep',
                'docpcp',
                'docdentist',
                'docent',
                'docmdother',
                'docmdother2',
                'docmdother3',
            ];

            foreach ($docFields as $field) {
                $shortInfo = $contactResource->getDocShortInfo($foundPatient->$field);
                $formedFullNames[$field . '_name'] = $this->getDocNameFromShortInfo($foundPatient->$field, $shortInfo);
            }

            if (!empty($foundPatient->p_m_eligible_payer_id)) {
                $formedFullNames['ins_payer_name'] = $foundPatient->p_m_eligible_payer_id . ' - ' . $foundPatient->p_m_eligible_payer_name;
            } else {
                $formedFullNames['ins_payer_name'] = '';
            }

            if (!empty($foundPatient->s_m_eligible_payer_id)) {
                $formedFullNames['s_m_ins_payer_name'] = $foundPatient->s_m_eligible_payer_id . ' - ' . $foundPatient->s_m_eligible_payer_name;
            } else {
                $formedFullNames['s_m_ins_payer_name'] = '';
            }

            if ($foundPatient->referred_source == self::DSS_REFERRED_PATIENT) {
                $referredPatient = $patientResource->getWithFilter([
                    'lastname', 'firstname', 'middlename'
                ], ['patientid' => $foundPatient->referred_by])[0];

                $formedFullNames['referred_name'] = $referredPatient->lastname . ', ' . $referredPatient->firstname . ' '
                    . $referredPatient->middlename . ' - Patient';
            } elseif($foundPatient->referred_source == self::DSS_REFERRED_PHYSICIAN) {
                $shortInfo = $contactResource->getDocShortInfo($foundPatient->referred_by);

                $formedFullNames['referred_name'] = $shortInfo->lastname . ', ' . $shortInfo->firstname . ' '
                    . $shortInfo->middlename
                    . ($shortInfo->contacttype != '' ? ' - ' . $shortInfo->contacttype : '');
            }

            $foundLocations = $summariesResource->getWithFilter(['location'], ['patientid' => $patientId]);

            if (count($foundLocations)) {
                $foundLocation = $foundLocations[0];
            }

            $patientLocation = '';
            if (!empty($foundLocation)) {
                $patientLocation = $foundLocation->location;
            }
            $data = [
                'pending_vob'                 => $insPreauthResource->getPendingVob($patientId),
                'profile_photo'               => $profileImageResource->getProfilePhoto($patientId),
                'intro_letter'                => $letterResource->getGeneratedDateOfIntroLetter($patientId),
                'insurance_card_image'        => $profileImageResource->getInsuranceCardImage($patientId),
                'uncompleted_home_sleep_test' => $homeSleepTestResource->getUncompleted($patientId),
                'patient_notification'        => $notificationResource->getWithFilter(null, [
                                                     'patientid' => $patientId,
                                                     'status'    => 1,
                                                 ]),
                'patient'                     => ApiResponse::transform($foundPatient),
                'formed_full_names'           => $formedFullNames,
                'patient_location'            => $patientLocation,
            ];
        }
        return ApiResponse::responseOk('', $data);
    }

    public function getReferrers(Patients $patientResource, Request $request)
    {
        $docId = $this->currentUser->getDocIdOrZero();

        $partial = '';
        if ($request->has('partial_name')) {
            $partial = preg_replace("[^ A-Za-z'\-]", "", $request->input('partial_name'));
        }

        $names = explode(' ', $partial);

        $contacts = $patientResource->getReferrers($docId, $names);

        $response = [];
        if (count($contacts)) {
            foreach ($contacts as $item) {
                $fullName = $item->lastname . ', ' . $item->firstname . ' ' . $item->middlename . ' - ' . $item->label;
                $response[] = [
                    'id'     => $item->patientid,
                    'name'   => $fullName,
                    'source' => $item->referral_type,
                ];
            }
        } else {
            $response = [
                'error' => 'Error: No match found for this criteria.'
            ];
        }

        return ApiResponse::responseOk('', $response);
    }

    public function checkEmail(Request $request, EmailChecker $emailChecker)
    {
        $email = $request->input('email', '');
        $patientId = $request->input('patient_id', 0);

        try {
            $message = $emailChecker->checkEmail($email, $patientId);
        } catch (IncorrectEmailException $e) {
            return ApiResponse::responseError($e->getMessage(), 417);
        }

        return ApiResponse::responseOk('', ['confirm_message' => $message]);
    }

    /**
     * @param int $patientId
     * @param AccessCodeResetter $accessCodeResetter
     * @return JsonResponse
     */
    public function resetAccessCode($patientId, AccessCodeResetter $accessCodeResetter)
    {
        $responseData = $accessCodeResetter->resetAccessCode($patientId);

        return ApiResponse::responseOk('', $responseData);
    }

    /**
     * @param TempPinDocumentCreator $tempPinDocumentCreator
     * @param int $patientId
     * @return JsonResponse
     */
    public function createTempPinDocument(
        TempPinDocumentCreator $tempPinDocumentCreator,
        $patientId = 0
    ) {
        $url = '';
        if ($patientId) {
            $docId = $this->currentUser->getDocIdOrZero();
            $url = $tempPinDocumentCreator->createDocument($patientId, $docId);
        }

        return ApiResponse::responseOk('', ['path_to_pdf' => $url]);
    }

    private function getDocNameFromShortInfo($field, $shortInfo)
    {
        $name = '';
        if ($field != 'Not Set' && $shortInfo) {
            $name = $shortInfo->lastname;
            $name .= ', ';
            $name .= $shortInfo->firstname;
            $name .= ' ';
            $name .= $shortInfo->middlename;
            $contactType = '';
            if ($shortInfo->contacttype) {
                $contactType = ' - ' . $shortInfo->contacttype;
            }
            $name .= $contactType;
        }
        return $name;
    }
}
