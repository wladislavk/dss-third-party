<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Helpers\ApiResponse;
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

    public function addNewPatient(
        Patient $patientResource,
        InsurancePreauth $insurancePreauthResource,
        Summaries $summariesResource,
        Letter $letterResource,
        PatientStore $request
    ) {
        $patient = $request->all();

        if ($patient['p_m_eligible_payer'] != '') {
            $patient['p_m_eligible_payer_id'] = substr($patient['p_m_eligible_payer'], 0, strpos($patient['p_m_eligible_payer'], '-'));
            $patient['p_m_eligible_payer_name'] = substr($patient['p_m_eligible_payer'], (strpos($patient['p_m_eligible_payer'], '-') + 1));
        } else {
            $patient['p_m_eligible_payer_id'] = '';
            $patient['p_m_eligible_payer_name'] = '';
        }

        if ($patient['s_m_eligible_payer'] != '') {
            $patient['s_m_eligible_payer_id'] = substr($patient['s_m_eligible_payer'], 0, strpos($patient['s_m_eligible_payer'], '-'));
            $patient['s_m_eligible_payer_name'] = substr($patient['s_m_eligible_payer'], (strpos($patient['s_m_eligible_payer'], '-') + 1));
        } else {
            $patient['s_m_eligible_payer_id'] = '';
            $patient['s_m_eligible_payer_name'] = '';
        }

        // generation an unique patient login
        $cLogin = strtolower(substr($patient["firstname"], 0, 1) . $patient["lastname"]);

        $similarPatientLogin = $patientResource->getSimilarPatientLogin($cLogin);

        if ($similarPatientLogin) {
            $number = str_replace($cLogin, '', $similarPatientLogin->login);

            $cLogin = $cLogin . ++$number;
        }

        $triggerLetters = false;

        $errors = [];
        $data = [];

        if (true/* existing patient (update) */) {
            $oldPatient = $patientResource->find($patientId);

            if ($oldPatient->registration_status == 2 && $patient['email'] != $oldPatient->email) {
                sendUpdatedEmail($patientId, $patient['email'], $oldPatient->email, 'doc');
            } elseif (isset($patient['sendRem'])) {
                // send reminder email
                sendRemEmail($newPatientId, $patient['email']);
            } elseif (!isset($patient['sendReg']) && $oldPatient->registration_status == 1 && trim($patient['email']) != trim($oldPatient['email'])) {
                if ($docPatientPortal && $usePatientPortal) {
                    // send reg email if email is updated and not registered
                    sendRegEmail($newPatientId, $patient['email'], '');
                }
            }

            if ($patient['email'] != $oldPatient['email']) {
                $patient['email_bounce'] = 0;
            }

            $patientResource->update($patient);
            $patientResource->updateChildrenPatients($patientId, ['email' => $patient['email']]);

            $insuranceInfoFieldsArray = [
                'p_m_relation', 'p_m_partyfname', 'p_m_partylname',
                'ins_dob', 'p_m_ins_type', 'p_m_ins_ass',
                'p_m_ins_id', 'p_m_ins_grp', 'p_m_ins_plan'
            ];

            $hasInsuranceInfoChanged = false;

            foreach ($insuranceInfoFieldsArray as $field) {
                if ($oldPatient[$field] != $patient[$field]) {
                    $hasInsuranceInfoChanged = true;
                    break;
                }
            }

            if ($hasInsuranceInfoChanged) {
                $userName = $this->currentUser->name ?: '';

                $updatedVob = $insurancePreauthResource->updateVob($newPatientId, $userName);

                if ($updatedVob) {
                    $c = create_vob($newPatientId);

                    if (isset($patient['location'])) {
                        $summaries = $summariesResource->getWithFilter(null, ['patientid' => $patientId]);

                        if (count($summaries)) {
                            $summaries->updateForPatient($patientId, [
                                'location' => $patient['location']
                            ]);
                        } else {
                            $summaries->create([
                                'location'  => $patient['location'],
                                'patientid' => $patientId
                            ]);
                        }
                    }

                    if ($oldPatient->login == '') {
                        $patientResource->updatePatient($newPatientId, ['login' => $cLogin]);
                    }

                    if (isset($patient['sendReg']) && $patient['doc_patient_portal'] && $patient['use_patient_portal']) {
                        if (trim($patient['email']) != '' && trim($patient['cell_phone']) != '') {
                            sendRegEmail($newPatientId, $patient['email'], $cLogin, $oldPatient['email']);
                        } else {
                            $message = 'Unable to send registration email because no cell_phone is set. Please enter a cell_phone and try again.';
                        }
                    }

                    /*
                    if (!empty($_POST['copyreqdate'])) {
                        $dateCompleted = date('Y-m-d', strtotime($_POST['copyreqdate']));
                    } else {
                        $dateCompleted = date('Y-m-d');
                    }

                    $s1 = "UPDATE dental_flow_pg2_info SET date_completed = '" . $dateCompleted . "' WHERE patientid='".intval($_POST['ed'])."' AND stepid='1';";
                    $db->query($s1);
                    */

                    if ($oldPatient['referred_by'] != $patient['referred_by'] ||
                        $oldPatient['referred_source'] != $patient['referred_source']
                    ) {
                        if ($oldPatient['referred_source'] == 2 && $patient['referred_source'] == 2) {
                            //PHYSICIAN -> PHYSICIAN

                            $letterResource->updatePendingLettersToNewReferrer(
                                $oldPatient['referred_by'],
                                $patient['referred_by'],
                                $newPatientId,
                                'physician'
                            );
                        } elseif ($oldPatient['referred_source'] == 1 && $patient['referred_source'] == 1) {
                            //PATIENT -> PATIENT

                            $letterResource->updatePendingLettersToNewReferrer(
                                $oldPatient['referred_by'],
                                $patient['referred_by'],
                                $newPatientId,
                                'patient'
                            );
                        } elseif ($oldPatient['referred_source'] == 2 && $patient['referred_source'] != 2) {
                            //PHYSICIAN -> NOT PHYSICIAN

                            $letters = $letterResource->getPhysicianOrPatientPendingLetters(
                                $oldPatient['referred_by'],
                                $newPatientId
                            );

                            if (count($letters)) {
                                foreach ($letters as $letter) {
                                    $this->deleteLetter($letter->letterid, null, 'md_referral', $oldPatient['referred_by']);
                                }
                            }
                        } elseif ($oldPatient['referred_source'] == 1 && $patient['referred_source'] != 1) {
                            //PATIENT -> NOT PATIENT

                            $letters = $letterResource->getPhysicianOrPatientPendingLetters(
                                $oldPatient['referred_by'],
                                $newPatientId,
                                'patient'
                            );

                            if (count($letters)) {
                                foreach ($letters as $letter) {
                                    $this->deleteLetter($letter->letterid, null, 'pat_referral', $oldPatient['referred_by']);
                                }
                            }
                        }
                    }

                    $triggerLetters = true;
                    $message = 'Edited Successfully';
                }
            }
        } else {
            if ($patient['ssn'] != '') {
                $salt = Password::createSalt();
                $password = preg_replace('/\D/', '', $patient['ssn']);
                $password = Password::genPassword($password, $salt);
            } else {
                $salt = '';
                $password = '';
            }

            $patient['salt'] = $salt;
            $patient['password'] = $password;
            $patient['salt'] = $salt;
            $patient['userid'] = $this->currentUser->userid ?: 0;
            $patient['docid'] = $this->currentUser->docid ?: 0;
            $patient['ip_address'] = $request->ip();

            // filters
            $patient['firstname'] = ucfirst($patient['firstname']);
            $patient['lastname'] = ucfirst($patient['lastname']);
            $patient['middlename'] = ucfirst($patient['middlename']);

            $createdPatientId = $patientResource->create($patient);

            if (isset($patient['location'])) {
                $summariesResource->create([
                    'location'  => $patient['location'],
                    'patientid' => $createdPatientId
                ]);
            }

            $triggerLetters = true;

            if (isset($patient['sendReg']) && $patient["use_patient_portal"]) {
                if (trim($patient['email']) != '' && trim($patient['cell_phone']) != '') {
                    sendRegEmail($newPatientId, $patient['email'], '');
                } else {
                    $errors[] = 'Unable to send registration email because no cell_phone is set. Please enter a cell_phone and try again.';
                }
            }

            $similarPatient = $this->getSimilarPatients($patientId);

            if (count($similarPatient)) {
                $data['similar_patients'] = true;
            } else {
                $data['alert_message'] = 'Patient' . $patient['firstname'] . ' ' . $patient['lastname'] . ' added Successfully';
            }
        }

        // check if required information is filled out
        $completeInfo = 0;
        if (
            !empty($patient['home_phone'])
            || !empty($patient['work_phone'])
            || !empty($patient['cell_phone'])
        ) {
            $patientPhone = true;
        }

        if (!empty($patient['email'])) {
            $patientEmail = true;
        }

        if (
            (!empty($patientEmail) || !empty($patientPhone))
            && !empty($patient['add1']) && !empty($patient['city'])
            && !empty($patient['state']) && !empty($patient['zip'])
            && !empty($patient['dob']) && !empty($patient['gender'])
        ) {
            $completeInfo = 1;
        }

        // determine whether patient info has been set
        $this->updatePatientSummary($patientId, 'patient_info', $completeInfo);

        $data = array_merge($data, [
            'message'            => $message,
            'is_trigger_letters' => $triggerLetters,
            'errors'             => $errors
        ]);

        return ApiResponse::responseOk('', $data);
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
