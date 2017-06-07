<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Exceptions\IncorrectEmailException;
use DentalSleepSolutions\Factories\PatientEditorFactory;
use DentalSleepSolutions\Helpers\AccessCodeResetter;
use DentalSleepSolutions\Helpers\EmailChecker;
use DentalSleepSolutions\Helpers\FullNameComposer;
use DentalSleepSolutions\Helpers\NameSetter;
use DentalSleepSolutions\Helpers\PatientLocationRetriever;
use DentalSleepSolutions\Helpers\TempPinDocumentCreator;
use DentalSleepSolutions\Temporary\PatientFormDataUpdater;
use DentalSleepSolutions\Helpers\PatientRuleRetriever;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Http\Requests\PatientStore;
use DentalSleepSolutions\Http\Requests\PatientUpdate;
use DentalSleepSolutions\Http\Requests\PatientDestroy;
use DentalSleepSolutions\Contracts\Repositories\Patients;
use DentalSleepSolutions\Http\Requests\PatientSummaryUpdate;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Eloquent\Dental\HomeSleepTest;
use DentalSleepSolutions\Eloquent\Dental\InsurancePreauth;
use DentalSleepSolutions\Eloquent\Dental\Letter;
use DentalSleepSolutions\Eloquent\Dental\Notification;
use DentalSleepSolutions\Eloquent\Dental\Patient;
use DentalSleepSolutions\Eloquent\Dental\PatientSummary;
use DentalSleepSolutions\Eloquent\Dental\ProfileImage;
use DentalSleepSolutions\Structs\PressedButtons;
use DentalSleepSolutions\Structs\RequestedEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientsController extends Controller
{
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
     * @param  \DentalSleepSolutions\Contracts\Repositories\Patients $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithFilter(Patients $resources, Request $request)
    {
        $fields = $request->input('fields', []);
        $where  = $request->input('where', []);

        $patients = $resources->getWithFilter($fields, $where);

        return ApiResponse::responseOk('', $patients);
    }

    public function getNumber(Patient $patientModel)
    {
        $docId = $this->currentUser->getDocIdOrZero();
        $data = $patientModel->getNumber($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getDuplicates(Patient $patientModel)
    {
        $docId = $this->currentUser->getDocIdOrZero();
        $data = $patientModel->getDuplicates($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getBounces(Patient $patientModel)
    {
        $docId = $this->currentUser->getDocIdOrZero();
        $data = $patientModel->getBounces($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getListPatients(Patient $patientModel, Request $request)
    {
        $partialName = $request->input('partial_name', '');
        // TODO: there must not be whitespaces in regexp. is it a typo?
        $regExp = '/[^ A-Za-z\'\-]/';
        $partialName = preg_replace($regExp, '', $partialName);

        $names = explode(' ', $partialName);

        $docId = $this->currentUser->getDocIdOrZero();
        $data = $patientModel->getListPatients($docId, $names);

        return ApiResponse::responseOk('', $data);
    }

    public function destroyForDoctor($patientId, Patient $resource)
    {
        $docId = $this->currentUser->getDocIdOrZero();
        $resource->deleteForDoctor($patientId, $docId);

        return ApiResponse::responseOk('Resource deleted');
    }

    public function find(Patient $patientModel, Request $request)
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

        $data = $patientModel->findBy(
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

    public function getReferredByContact(Patient $patientModel, Request $request)
    {
        $contactId = $request->input('contact_id', 0);
        $data = $patientModel->getReferredByContact($contactId);

        return ApiResponse::responseOk('', $data);
    }

    public function getByContact(Patient $patientModel, Request $request)
    {
        $contactId = $request->input('contact_id', 0);
        $data = $patientModel->getByContact($contactId);

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

    /**
     * @param FullNameComposer $fullNameComposer
     * @param PatientLocationRetriever $patientLocationRetriever
     * @param InsurancePreauth $insPreauthModel
     * @param Patient $patientModel
     * @param ProfileImage $profileImageModel
     * @param Letter $letterModel
     * @param HomeSleepTest $homeSleepTestModel
     * @param Notification $notificationModel
     * @param Request $request
     * @return JsonResponse
     */
    public function getDataForFillingPatientForm(
        FullNameComposer $fullNameComposer,
        PatientLocationRetriever $patientLocationRetriever,
        InsurancePreauth $insPreauthModel,
        Patient $patientModel,
        ProfileImage $profileImageModel,
        Letter $letterModel,
        HomeSleepTest $homeSleepTestModel,
        Notification $notificationModel,
        Request $request
    ) {
        $patientId = $request->input('patient_id', 0);
        /** @var Patient|null $foundPatient */
        $foundPatient = $patientModel->find($patientId);

        if (!$foundPatient) {
            return ApiResponse::responseOk('', []);
        }
        $formedFullNames = $fullNameComposer->getFormedFullNames($foundPatient);
        $patientLocation = $patientLocationRetriever->getPatientLocation($patientId);

        $patientNotificationData = [
            'patientid' => $patientId,
            'status' => 1,
        ];
        $data = [
            'pending_vob' => $insPreauthModel->getPendingVob($patientId),
            'profile_photo' => $profileImageModel->getProfilePhoto($patientId),
            'intro_letter' => $letterModel->getGeneratedDateOfIntroLetter($patientId),
            'insurance_card_image' => $profileImageModel->getInsuranceCardImage($patientId),
            'uncompleted_home_sleep_test' => $homeSleepTestModel->getUncompleted($patientId),
            'patient_notification' => $notificationModel->getWithFilter(null, $patientNotificationData),
            'patient' => ApiResponse::transform($foundPatient),
            'formed_full_names' => $formedFullNames,
            'patient_location' => $patientLocation,
        ];

        return ApiResponse::responseOk('', $data);
    }

    public function getReferrers(NameSetter $nameSetter, Patient $patientModel, Request $request)
    {
        $docId = $this->currentUser->getDocIdOrZero();

        $partial = '';
        if ($request->has('partial_name')) {
            // TODO: there must not be whitespaces in regexp. is it a typo?
            $regExp = '/[^ A-Za-z\'\-]/';
            $partial = preg_replace($regExp, '', $request->input('partial_name'));
        }

        $names = explode(' ', $partial);

        $contacts = $patientModel->getReferrers($docId, $names);

        $response = [];
        if (!count($contacts)) {
            $response = [
                'error' => 'Error: No match found for this criteria.',
            ];
            // TODO: 200 should not be returned on error
            return ApiResponse::responseOk('', $response);
        }
        foreach ($contacts as $item) {
            // TODO: does property "label" exist on the model?
            $fullName = $nameSetter->formFullName(
                $item->firstname,
                $item->middlename,
                $item->lastname,
                $item->label
            );
            $response[] = [
                'id'     => $item->patientid,
                'name'   => $fullName,
                'source' => $item->referral_type,
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
}
