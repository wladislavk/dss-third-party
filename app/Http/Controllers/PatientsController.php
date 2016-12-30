<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
use DentalSleepSolutions\Helpers\LetterHelper;
use DentalSleepSolutions\Helpers\PreauthHelper;
use DentalSleepSolutions\Helpers\EmailHelper;
use DentalSleepSolutions\Helpers\SimilarHelper;
use DentalSleepSolutions\Http\Requests\PatientStore;
use DentalSleepSolutions\Http\Requests\PatientUpdate;
use DentalSleepSolutions\Http\Requests\PatientDestroy;
use DentalSleepSolutions\Http\Controllers\Controller;
use DentalSleepSolutions\Contracts\Resources\Patient;
use DentalSleepSolutions\Contracts\Repositories\Patients;
use DentalSleepSolutions\Contracts\Resources\InsurancePreauth;
use DentalSleepSolutions\Contracts\Repositories\Summaries;
use DentalSleepSolutions\Contracts\Resources\Letter;
use DentalSleepSolutions\Contracts\Resources\Contact;
use DentalSleepSolutions\Contracts\Resources\PatientSummary;
use DentalSleepSolutions\Contracts\Resources\ProfileImage;
use DentalSleepSolutions\Contracts\Repositories\HomeSleepTests;
use DentalSleepSolutions\Contracts\Repositories\Notifications;
use DentalSleepSolutions\Contracts\Resources\User;
use DentalSleepSolutions\Http\Requests\PatientSummaryUpdate;
use DentalSleepSolutions\Libraries\Password;
use Illuminate\Http\Request;

/**
 * API controller that handles single resource endpoints. It depends heavily
 * on the IoC dependency injection and routes model binding in that each
 * method gets resource instance injected, rather than its identifier.
 *
 * @see \DentalSleepSolutions\Providers\RouteServiceProvider::boot
 * @link http://laravel.com/docs/5.1/routing#route-model-binding
 */
class PatientsController extends Controller
{
    const DSS_REFERRED_PATIENT = 1;
    const DSS_REFERRED_PHYSICIAN = 2;
    const DSS_REFERRED_MEDIA = 3;
    const DSS_REFERRED_FRANCHISE = 4;
    const DSS_REFERRED_DSSOFFICE = 5;
    const DSS_REFERRED_OTHER = 6;

    /**
     * Display a listing of the resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Patients $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Patients $resources)
    {
        $data = $resources->all();

        return ApiResponse::responseOk('', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Patient $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Patient $resource)
    {
        return ApiResponse::responseOk('', $resource);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Repositories\Patients $resources
     * @param  \DentalSleepSolutions\Http\Requests\PatientStore $request
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
     * Update the specified resource in storage.
     *
     * @param  \DentalSleepSolutions\Contracts\Resources\Patient $resource
     * @param  \DentalSleepSolutions\Http\Requests\PatientUpdate $request
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
     * @param  \DentalSleepSolutions\Contracts\Resources\Patient $resource
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
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getNumber($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getDuplicates(Patients $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getDuplicates($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getBounces(Patients $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getBounces($docId);

        return ApiResponse::responseOk('', $data);
    }

    public function getListPatients(Patients $resources, Request $request)
    {
        $partialName = $request->input('partial_name') ?: '';
        $partialName = preg_replace("[^ A-Za-z'\-]", '', $partialName);

        $names = explode(' ', $partialName);

        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getListPatients($docId, $names);

        return ApiResponse::responseOk('', $data);
    }

    public function destroyForDoctor($patientId, Patient $resource)
    {
        $docId = $this->currentUser->docid ?: 0;

        $resource->deleteForDoctor($patientId, $docId);

        return ApiResponse::responseOk('Resource deleted');
    }

    public function find(Patients $resources, Request $request)
    {
        $docId           = $this->currentUser->docid ?: 0;
        $userType        = $this->currentUser->user_type ?: 0;

        $patientId       = $request->input('patientId') ?: 0;
        $type            = $request->input('type') ?: 1;
        $pageNumber      = $request->input('page') ?: 0;
        $patientsPerPage = $request->input('patientsPerPage') ?: 30;
        $letter          = $request->input('letter') ?: '';
        $sortColumn      = $request->input('sortColumn') ?: 'name';
        $sortDir         = $request->input('sortDir') ?: '';

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
        $contactId = $request->input('contact_id') ?: 0;
        $data = $resources->getReferredByContact($contactId);

        return ApiResponse::responseOk('', $data);
    }

    public function getByContact(Patients $resources, Request $request)
    {
        $contactId = $request->input('contact_id') ?: 0;
        $data = $resources->getByContact($contactId);

        return ApiResponse::responseOk('', $data);
    }

    public function editingPatient(
        $patientId,
        LetterHelper $letterHelper,
        EmailHelper $emailHelper,
        PreauthHelper $preauthHelper,
        SimilarHelper $similarHelper,
        Patient $patientResource,
        PatientSummary $patientSummaryResource,
        InsurancePreauth $insurancePreauthResource,
        Summaries $summariesResource,
        Letter $letterResource,
        User $userResource,
        Request $request,
        PatientSummaryUpdate $patientSummaryValidator
        PatientStore $patientStoreValidator,
        PatientUpdate $patientUpdateValidator,
    ) {
        $docId = $this->currentUser->docid ?: 0;
        $userType = $this->currentUser->user_type ?: 0;

        // check if the request has emails for sending
        $emailTypesForSending = $request->has('requested_emails') ? $request->input('requested_emails') : false;

        $usePatientPortal = $request->input('use_patient_portal');
        // get doc info by id
        $docInfo = $userResource->getWithFilter('use_patient_portal', ['userid' => $docId]);

        if (count($docInfo)) {
            $docPatientPortal = $docInfo[0]->use_patient_portal;
        } else {
            $docPatientPortal = false;
        }

        // get form data for a current patient
        $patientFormData = $request->input('patient_form_data');

        // validate input patient form data
        if (patientId) {
            $this->validate($patientFormData, $patientUpdateValidator->rules());
        } else {
            $this->validate($patientFormData, $patientStoreValidator->rules());
        }

        // check if the request contains tracker notes
        if ($request->has('tracker_notes')) {
            $this->validate($request->input('tracker_notes'), $patientSummaryValidator->rules());

            $patientSummaryResource->updateTrackerNotes($patientId, $docId, $request->input('tracker_notes'));

            return ApiResponse::responseOk('', ['tracker_notes' => 'Tracker notes were successfully updated.']);
        }

        // $letterHelpers = new LetterHelper($docId, $patientId);

        $letterHelper->triggerPatientTreatmentComplete();

        // need to add logic for logging actions
        // linkRequestData

        // generation an unique patient login
        $uniqueLogin = strtolower(substr($patientFormData["firstname"], 0, 1) . $patientFormData["lastname"]);

        $similarPatientLogin = $patientResource->getSimilarPatientLogin($uniqueLogin);

        if ($similarPatientLogin) {
            $number = str_replace($uniqueLogin, '', $similarPatientLogin->login);

            $uniqueLogin = $uniqueLogin . ++$number;
        }

        $responseData = [];
        $isUpdateAction = true;
        if ($patientId) {
            // find an unchanged patient by id
            $unchangedPatient = $patientResource->find($patientId);

            // check registration status:
            // Unregistered - 0
            // Registration Emailed - 1
            // Registered - 2
            if ($unchangedPatient->registration_status == 2 && $patientFormData['email'] != $unchangedPatient->email) {
                // need to notify the user about changing his email
                $emailHelper->sendUpdatedEmail($docId, $patientId, $patientFormData['email'], $unchangedPatient->email, 'doc');

                $responseData['mails'] = [
                    'updated_mail' => 'The mail about changing patient email was successfully sent.'
                ];
            } elseif ($emailTypesForSending && !empty($emailTypesForSending['reminder'])) {
                // send reminder email
                $emailHelper->sendRemEmail($patientId, $patientFormData['email']);

                $responseData['mails'] = [
                    'reminder_mail' => 'The reminding mail was successfully sent.'
                ];
            } elseif (
                $emailTypesForSending && empty($emailTypesForSending['registration']) &&
                $unchangedPatient->registration_status == 1 && $patientFormData['email'] != $unchangedPatient['email']
            ) {
                if ($docPatientPortal && $usePatientPortal) {
                    // send registration email if email is updated and not registered
                    $emailHelper->sendRegEmail($patientId, $patientFormData['email'], '');
                }

                $responseData['mails'] = [
                    'registration_mail' => 'Your email address was updated and not registered. The registration mail was successfully sent.'
                ];
            }

            if ($patientFormData['email'] != $unchangedPatient->email) {
                $patientFormData['email_bounce'] = 0;
            }

            // update patient
            $patientResource->updatePatient($patientId, $patientFormData);
            // update email of parent patient for all his children
            $patientResource->updateChildrenPatients($patientId, ['email' => $patientFormData['email']]);

            // remove pending vobs if insurance info has changed
            $insuranceInfoFieldsArray = [
                'p_m_relation', 'p_m_partyfname', 'p_m_partylname',
                'ins_dob', 'p_m_ins_type', 'p_m_ins_ass',
                'p_m_ins_id', 'p_m_ins_grp', 'p_m_ins_plan'
            ];

            $hasInsuranceInfoChanged = false;

            // check if any field has been changed
            foreach ($insuranceInfoFieldsArray as $field) {
                if ($unchangedPatient->$field != $patientFormData[$field]) {
                    $hasInsuranceInfoChanged = true;
                    break;
                }
            }

            if ($hasInsuranceInfoChanged) {
                $userName = $this->currentUser->name ?: '';

                $updatedVob = $insurancePreauthResource->updateVob($patientId, $userName);

                if ($updatedVob) {
                    $insurancePreauthId = $preauthHelper->createVob($patientId);
                }
            }

            // update patient summary if location is set
            if ($patientFormData['location']) {
                $summaries = $summariesResource->getWithFilter(null, ['patientid' => $patientId]);

                if (count($summaries)) {
                    $summaries->updateForPatient($patientId, [
                        'location' => $patientFormData['location']
                    ]);
                } else {
                    $summaries->create([
                        'location'  => $patientFormData['location'],
                        'patientid' => $patientId
                    ]);
                }
            }

            if ($unchangedPatient->login == '') {
                $patientResource->updatePatient($patientId, ['login' => $uniqueLogin]);
            }

            // if it is required need to do:
            /*
            if (!empty($_POST['copyreqdate'])) {
              $dateCompleted = date('Y-m-d', strtotime($_POST['copyreqdate']));
            } else {
              $dateCompleted = date('Y-m-d');
            }

            $s1 = "UPDATE dental_flow_pg2_info SET date_completed = '" . $dateCompleted . "' WHERE patientid='".intval($_POST['ed'])."' AND stepid='1';";
            $db->query($s1);
            */

            // if referrer was changed need to update certain letters
            if ($unchangedPatient->referred_by != $patientFormData['referred_by'] ||
                $unchangedPatient->referred_source != $patientFormData['referred_source']
            ) {
                if ($unchangedPatient->referred_source == 2 && $patientFormData['referred_source'] == 2) {
                    // physician -> physician

                    $letterResource->updatePendingLettersToNewReferrer(
                        $unchangedPatient->referred_by,
                        $patientFormData['referred_by'],
                        $patientId,
                        'physician'
                    );
                } elseif ($unchangedPatient->referred_source == 1 && $patientFormData['referred_source'] == 1) {
                    // patient -> patient

                    $letterResource->updatePendingLettersToNewReferrer(
                        $unchangedPatient->referred_by,
                        $patientFormData['referred_by'],
                        $patientId,
                        'patient'
                    );
                } elseif ($unchangedPatient->referred_source == 2 && $patientFormData['referred_source'] != 2) {
                    // physician -> not physician

                    $letters = $letterResource->getPhysicianOrPatientPendingLetters(
                        $unchangedPatient->referred_by,
                        $patientId
                    );

                    if (count($letters)) {
                        foreach ($letters as $letter) {
                            $letterHelper->deleteLetter($letter->letterid, null, 'md_referral', $unchangedPatient->referred_by);
                        }
                    }
                } elseif ($unchangedPatient->referred_source == 1 && $patientFormData['referred_source'] != 1) {
                    // patient -> not patient

                    $letters = $letterResource->getPhysicianOrPatientPendingLetters(
                        $unchangedPatient->referred_by,
                        $patientId,
                        'patient'
                    );

                    if (count($letters)) {
                        foreach ($letters as $letter) {
                            $letterHelper->deleteLetter($letter->letterid, null, 'pat_referral', $unchangedPatient->referred_by);
                        }
                    }
                }
            }

            $responseData['status'] = 'Edited Successfully';
        } else { // patientId = 0 -> creating a new patient
            $isUpdateAction = false;

            if ($patientFormData['ssn']) {
                $salt = Password::createSalt();
                $password = preg_replace('/\D/', '', $patientFormData['ssn']);
                $password = Password::genPassword($password, $salt);
            } else {
                $salt = '';
                $password = '';
            }

            $patientFormData = array_merge($patientFormData, [
                'salt'       => $salt,
                'password'   => $password,
                'salt'       => $salt,
                'userid'     => $this->currentUser->userid ?: 0,
                'docid'      => $docId,
                'ip_address' => $request->ip(),
                // set filters
                'firstname'  => ucfirst($patientFormData['firstname']),
                'lastname'   => ucfirst($patientFormData['lastname']),
                'middlename' => ucfirst($patientFormData['middlename'])
            ]);

            $createdPatientId = $patientResource->create($patientFormData);

            if ($patientFormData['location']) {
                $summariesResource->create([
                    'location'  => $patientFormData['location'],
                    'patientid' => $createdPatientId
                ]);
            }

            $similarPatient = $similarHelper->getSimilarPatients($createdPatientId);

            if (count($similarPatient)) {
                $responseData['redirect_to'] = 'duplicate_patients.php?pid=' . $createdPatientId;
            } else {
                $responseData['status'] = 'Patient "' . $patientFormData['firstname'] . ' ' . $patientFormData['lastname'] . '" was added successfully.';
            }

            $patientId = $createdPatientId;
        }

        $letterHelper->triggerIntroLettersOf12Types($patientId);

        if (!empty($patientFormData['introletter']) && $patientFormData['introletter'] == 1) {
            $letterHelper->triggerIntroLetterOf3Type($patientId);
        }

        if (
            $emailTypesForSending && !empty($emailTypesForSending['registration']) &&
            $docPatientPortal && $usePatientPortal
        ) {
            if ($patientFormData['email'] && $patientFormData['cell_phone']) {
                if ($isUpdateAction) {
                    $emailHelper->sendRegEmail($patientId, $patientFormData['email'], $uniqueLogin, $unchangedPatient->email);
                } else {
                    $emailHelper->sendRegEmail($patientId, $patientFormData['email'], $uniqueLogin);
                }

                $message = 'The registration mail was successfully sent.';
            } else {
                $message = 'Unable to send registration email because no cell_phone is set. Please enter a cell_phone and try again.';
            }

            $responseData['mails'] = [
                'registration_mail' => $message
            ];
        }

        // check if required information is filled out
        $completeInfo = 0;
        if (!empty($patientFormData['home_phone']) || !empty($patientFormData['work_phone']) || !empty($patientFormData['cell_phone'])) {
            $patientPhone = true;
        } else {
            $patientPhone = false;
        }

        if (!empty($patientFormData['email'])) {
            $patientEmail = true;
        } else {
            $patientEmail = false;
        }

        if (
            (!empty($patientEmail) || !empty($patientPhone))
            && !empty($patientFormData['add1']) && !empty($patientFormData['city'])
            && !empty($patientFormData['state']) && !empty($patientFormData['zip'])
            && !empty($patientFormData['dob']) && !empty($patientFormData['gender'])
        ) {
            $completeInfo = 1;
        }

        // determine whether patient info has been set
        $this->updatePatientSummary($patientId, 'patient_info', $completeInfo);

        return ApiResponse::responseOk('', $responseData);
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
        $patientId = $request->has('patient_id') ? $request->input('patient_id') : 0;
        $foundPatient = $patientResource->find($patientId);

        if (!empty($foundPatient)) {
            $formedFullNames = [];
            // fields for getting certain short info and forming full name 
            $docFields = [
                'docsleep', 'docpcp', 'docdentist', 'docent',
                'docmdother', 'docmdother2', 'docmdother3'
            ];

            foreach ($docFields as $field) {
                $shortInfo = $contactResource->getDocShortInfo($foundPatient->$field);
                $formedFullNames[$field . '_name'] = $this->getDocNameFromShortInfo($foundPatient->$field, $shortInfo);
            }

            $formedFullNames['ins_payer_name'] = $foundPatient->p_m_eligible_payer_id . ' - ' . $foundPatient->p_m_eligible_payer_name;
            
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

            $foundLocation = $summariesResource->getWithFilter(['location'], ['patientid' => $patientId])[0];

            // data for response
            $data = [
                // check if user has pending VOB
                'pending_vob'                 => $insPreauthResource->getPendingVob($patientId),
                'profile_photo'               => $profileImageResource->getProfilePhoto($patientId),
                'intro_letter'                => $letterResource->getGeneratedDateOfIntroLetter($patientId),
                'insurance_card_image'        => $profileImageResource->getInsuranceCardImage($patientId),
                'uncompleted_home_sleep_test' => $homeSleepTestResource->getUncompleted($patientId),
                'patient_notification'        => $notificationResource->getWithFilter(null, [
                                                     'patientid' => $patientId,
                                                     'status'    => 1
                                                 ]),
                'patient'                     => ApiResponse::transform($foundPatient),
                'formed_full_names'           => $formedFullNames,
                'patient_location'            => $foundLocation ? $foundLocation->location : ''
            ];
        } else {
            $data = [];
        }

        return ApiResponse::responseOk('', $data);
    }

    public function getReferrers(Patients $patientResource, Request $request)
    {
        $docId = $this->currentUser->docid ?: 0;

        if ($request->has('partial_name')) {
            $partial = preg_replace("[^ A-Za-z'\-]", "", $request->input('partial_name'));
        } else {
            $partial = '';
        }

        $names = explode(' ', $partial);

        $contacts = $patientResource->getReferrers($docId, $names);

        if (count($contacts)) {
            foreach ($contacts as $item) {
                $response[] = [
                    'id'     => $item->patientid,
                    'name'   => $item->lastname . ', ' . $item->firstname . ' ' . $item->middlename . ' - ' . $item->label,
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

    private function getDocNameFromShortInfo($field, $shortInfo)
    {
        if ($field != 'Not Set' && $shortInfo) {
            $name = $shortInfo->lastname . ', ' . $shortInfo->firstname . ' '
                    . $shortInfo->middlename
                    . ($shortInfo->contacttype != '' ? ' - ' . $shortInfo->contacttype : '');
        } else {
            $name = '';
        }

        return $name;
    }

    private function updatePatientSummary(
        PatientSummary $patientSummaryResource,
        $patientId,
        $column,
        $value
    ) {
        if (empty($patientId) || empty($column)) {
            return false;
        }

        $patientSummary = $patientSummaryResource->find($patientId);

        if ($patientSummary) {
            $patientSummary->$column = $value;
            $patientSummary->save();
        } else {
            $patientSummary->create([
                'pid'   => $patientId,
                $column => $value
            ]);
        }

        return true;
    }
}
