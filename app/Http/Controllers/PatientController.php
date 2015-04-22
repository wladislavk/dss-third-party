<?php
namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Session;
use Request;
use Response;
use Mail;

use Ds3\Libraries\Constants;
use Ds3\Libraries\Password;
use Ds3\Libraries\MDReferralFilter;
use Ds3\Libraries\GeneralFunctions;

use Ds3\Contracts\CompanyInterface;
use Ds3\Contracts\UserInterface;
use Ds3\Contracts\LetterInterface;
use Ds3\Contracts\ContactInterface;
use Ds3\Contracts\PatientInterface;
use Ds3\Contracts\SummaryInterface;
use Ds3\Contracts\InsurancePreauthInterface;
use Ds3\Contracts\SummSleeplabInterface;
use Ds3\Contracts\FlowPg2Interface;
use Ds3\Contracts\FaxInterface;
use Ds3\Contracts\FlowPg1Interface;
use Ds3\Contracts\FlowPg2InfoInterface;
use Ds3\Contracts\PatientSummaryInterface;
use Ds3\Contracts\NotificationInterface;
use Ds3\Contracts\QImageInterface;
use Ds3\Contracts\LocationInterface;
use Ds3\Contracts\LetterTemplateInterface;

class PatientController extends Controller
{
    private $company;
    private $user;
    private $letter;
    private $contact;
    private $patient;
    private $summary;
    private $insurancePreauth;
    private $summSleeplab;
    private $flowPg2;
    private $fax;
    private $flowPg1;
    private $flowPg2Info;
    private $patientSummary;
    private $notification;
    private $qImage;
    private $location;
    private $letterTemplate;
    
    private $request;
    private $ed;
    private $preview;
    private $addtopat;

    private $patientData;

    public function __construct(
        CompanyInterface $company,
        UserInterface $user,
        LetterInterface $letter,
        ContactInterface $contact,
        PatientInterface $patient,
        SummaryInterface $summary,
        InsurancePreauthInterface $insurancePreauth,
        SummSleeplabInterface $summSleeplab,
        FlowPg2Interface $flowPg2,
        FaxInterface $fax,
        FlowPg1Interface $flowPg1,
        FlowPg2InfoInterface $flowPg2Info,
        PatientSummaryInterface $patientSummary,
        NotificationInterface $notification,
        QImageInterface $qImage,
        LocationInterface $location,
        LetterTemplateInterface $letterTemplate
    ) {
        $this->company          = $company;
        $this->user             = $user;
        $this->letter           = $letter;
        $this->contact          = $contact;
        $this->patient          = $patient;
        $this->summary          = $summary;
        $this->insurancePreauth = $insurancePreauth;
        $this->summSleeplab     = $summSleeplab;
        $this->flowPg2          = $flowPg2;
        $this->fax              = $fax;
        $this->flowPg1          = $flowPg1;
        $this->flowPg2Info      = $flowPg2Info;
        $this->patientSummary   = $patientSummary;
        $this->notification     = $notification;
        $this->qImage           = $qImage;
        $this->location         = $location;
        $this->letterTemplate   = $letterTemplate;

        $this->request = Request::all();

        $this->ed = GeneralFunctions::getRouteParameter('ed');
        $this->preview = GeneralFunctions::getRouteParameter('preview');
        $this->addtopat = GeneralFunctions::getRouteParameter('addtopat');

        $this->patientData = array('firstname', 'lastname', 'middlename', 'preferred_name', 'salutation', 'member_no',
            'group_no', 'plan_no', 'add1', 'add2', 'city', 'state',
            'zip', 'dob', 'gender', 'marital_status', 'feet', 'inches', 'weight', 'bmi',
            'best_time', 'best_number', 'email', 'patient_notes', 'p_d_party', 'p_d_relation',
            'p_d_other', 'p_d_employer', 'p_d_ins_co', 'p_d_ins_id', 's_d_party', 's_d_relation',
            's_d_other', 's_d_employer', 's_d_ins_co', 's_d_ins_id', 'p_m_partyfname',
            'p_m_partymname', 'p_m_partylname', 'p_m_gender', 'p_m_ins_grp', 's_m_ins_grp',
            'p_m_dss_file', 's_m_dss_file', 'p_m_same_address', 's_m_same_address', 'p_m_address',
            'p_m_city', 'p_m_state', 'p_m_zip', 's_m_address', 's_m_city', 's_m_state',
            's_m_zip', 'p_m_ins_type', 's_m_ins_type', 'p_m_ins_ass', 's_m_ins_ass', 'ins_dob',
            'ins2_dob', 'p_m_relation', 'p_m_other', 'p_m_employer', 'p_m_ins_co', 'p_m_ins_id',
            's_m_partyfname', 's_m_partymname', 's_m_partylname', 's_m_gender',
            's_m_relation', 's_m_other', 's_m_employer', 's_m_ins_co', 's_m_ins_id', 'p_m_ins_plan',
            's_m_ins_plan', 'employer', 'emp_add1', 'emp_add2', 'emp_city', 'emp_state', 'emp_zip',
            'plan_name', 'group_number', 'ins_type', 'accept_assignment', 'print_signature',
            'medical_insurance', 'mark_yes', 'inactive', 'partner_name', 'docsleep', 'docpcp',
            'docdentist', 'docent', 'docmdother', 'docmdother2', 'docmdother3', 'emergency_name',
            'emergency_relationship', 'referred_source', 'referred_by', 'referred_notes',
            'copyreqdate', 'status', 'use_patient_portal', 'preferredcontact'
        );
    }

    public function index()
    {
        $patientId = $this->request['patientId'];

        $billing = $this->company->getBilling(array(
            'u.userid' => Session::get('docId')
        ));

        if (count($billing)) {
            $exclusiveBilling = $billing[0]->exclusive;
            $nameBilling = $billing[0]->name;
        } else {
            $exclusiveBilling = 0;
            $nameBilling = 'DSS';
        }

        $docPatientPortal = $this->user->findUser(Session::get('docId'))->use_patient_portal;

        $ptReferralId = $this->getPtReferralIds($patientId);
        if ($ptReferralId) {
            $letters = $this->letter->getLetters(array(
                'patientid'          => $patientId,
                'templateid'         => 20,
                'pat_referral_list'  => $ptReferralId
            ));

            if (count($letters) == 0) {
                $this->triggerLetter20($patientId);
            }
        }

        $requestEd = (!empty($this->ed)) ? $this->ed : '-1';

        $status = Constants::DSS_PREAUTH_PENDING . ',' . Constants::DSS_PREAUTH_PREAUTH_PENDING;

        $vob = $this->insurancePreauth->getInsurancePreauth(array(
            'patient_id' => $requestEd
        ), $status, 'front_office_request_date');

        $pendingVob = count($vob);

        if ($pendingVob) {
            $vob = $vob[0];
            $pendingVobStatus = $vob->status;
        }

        $patient = $this->patient->getPatients(array(
            'patientid' => $requestEd
        ));

        $patient = count($patient) ? $patient[0] : null;

        $patientInfo = array();

        if (!empty($message)) {
            foreach ($this->patientData as $attribute) {
                if (isset($this->request[$attribute])) {
                    $patientInfo[$attribute] = $this->request[$attribute];
                } else {
                    $patientInfo[$attribute] = '';
                }                
            }

            $patientInfo['ssn']               = $this->request['ssn'];
            $patientInfo['p_m_ins_payer_id']  = $this->request['p_m_ins_payer_id'];
            $patientInfo['location']          = $this->request['location'];
            $patientInfo['home_phone']        = $this->request['home_phone'];
            $patientInfo['work_phone']        = $this->request['work_phone'];
            $patientInfo['cell_phone']        = $this->request['cell_phone'];
        } else {
            if (!empty($patient)) {
                foreach ($this->patientData as $attribute) {
                    if (isset($patient->$attribute)) {
                        $patientInfo[$attribute] = $patient->$attribute;
                    } else {
                        $patientInfo[$attribute] = '';
                    }
                }

                $patientInfo['ssn']               = $patient->ssn;
                $patientInfo['p_m_ins_payer_id']  = $patient->p_m_ins_payer_id;
                $patientInfo['location']          = $patient->location;
                $patientInfo['home_phone']        = $patient->home_phone;
                $patientInfo['work_phone']        = $patient->work_phone;
                $patientInfo['cell_phone']        = $patient->cell_phone;
                $patientInfo['has_s_m_ins']       = $patient->has_s_m_ins;
            } else {
                foreach ($this->patientData as $attribute) {
                    $patientInfo[$attribute] = '';
                }

                $patientInfo['has_s_m_ins'] = '';
            }

            if (!empty($patientInfo['docsleep']) && $patientInfo['docsleep'] != 'Not Set') {
                $contact = $this->contact->getDocsleep($patientInfo['docsleep']);

                $docsleepName = $contact->lastname . ', ' . $contact->firstname . ' ' . (($contact->contacttype != '') ? ' - ' . $contact->contacttype : '');
            } else {
                $docsleepName = '';
            }

            $patientInfo['docpcp'] = !empty($patient) ? $patient->docpcp : null;
            if ($patientInfo['docpcp'] && $patientInfo['docpcp'] != 'Not Set') {
                $contact = $this->contact->getDocsleep($patientInfo['docpcp']);

                $docpcpName = $contact->lastname . ', ' . $contact->firstname . ' ' . $contact->middlename . (($contact->contacttype != '') ? ' - ' . $contact->contacttype : '');
            } else {
                $docpcpName = '';
            }

            $patientInfo['docdentist'] = !empty($patient) ? $patient->docdentist : null;
            if ($patientInfo['docdentist'] && $patientInfo['docdentist'] != 'Not Set') {
                $contact = $this->contact->getDocsleep($patientInfo['docdentist']);

                $docdentistName = $contact->lastname . ', ' . $contact->firstname . ' ' . $contact->middlename . (($contact->contacttype != '') ? ' - ' . $contact->contacttype : '');
            } else {
                $docdentistName = '';
            }

            $patientInfo['docent'] = !empty($patient) ? $patient->docent : null;
            if ($patientInfo['docent'] && $patientInfo['docent'] != 'Not Set') {
                $contact = $this->contact->getDocsleep($patientInfo['docent']);

                $docentName = $contact->lastname . ', ' . $contact->firstname . ' ' . $contact->middlename . (($contact->contacttype != '') ? ' - ' . $contact->contacttype : '');
            } else {
                $docentName = '';
            }

            $patientInfo['docmdother'] = !empty($patient) ? $patient->docmdother : null;
            if ($patientInfo['docmdother'] && $patientInfo['docmdother'] != 'Not Set') {
                $contact = $this->contact->getDocsleep($patientInfo['docmdother']);

                $docmdotherName = $contact->lastname . ', ' . $contact->firstname . ' ' . $contact->middlename . (($contact->contacttype != '') ? ' - ' . $contact->contacttype : '');
            } else {
                $docmdotherName = '';
            }

            $patientInfo['docmdother2'] = !empty($patient) ? $patient->docmdother2 : null;
            if ($patientInfo['docmdother2'] && $patientInfo['docmdother2'] != 'Not Set') {
                $contact = $this->contact->getDocsleep($patientInfo['docmdother2']);

                $docmdother2Name = $contact->lastname . ', ' . $contact->firstname . ' ' . $contact->middlename . (($contact->contacttype != '') ? ' - ' . $contact->contacttype : '');
            } else {
                $docmdother2Name = '';
            }

            $patientInfo['docmdother3'] = !empty($patient) ? $patient->docmdother3 : null;
            if ($patientInfo['docmdother3'] && $patientInfo['docmdother3'] != 'Not Set') {
                $contact = $this->contact->getDocsleep($patientInfo['docmdother3']);

                $docmdother3Name = $contact->lastname . ', ' . $contact->firstname . ' ' . $contact->middlename . (($contact->contacttype != '') ? ' - ' . $contact->contacttype : '');
            } else {
                $docmdother3Name = '';
            }

            if (!empty($patient)) {
                $patientInfo['inactive']               = $patient->inactive;
                $patientInfo['partner_name']           = $patient->partner_name;
                $patientInfo['emergency_name']         = $patient->emergency_name;
                $patientInfo['emergencyrelationship']  = $patient->emergency_relationship;
                $patientInfo['emergency_number']       = $patient->emergency_number;
                $patientInfo['referred_source']        = $patient->referred_source;
                $patientInfo['referred_by']            = $patient->referred_by;
                $patientInfo['referred_notes']         = $patient->referred_notes;
            } else {
                $patientInfo['referred_source'] = -1;
            }

            if (isset($patientInfo['referred_source'])) {
                if ($patientInfo['referred_source'] == Constants::DSS_REFERRED_PATIENT) {
                    $patient = $this->patient->getPatients(array(
                        'patientid' => $referredBy
                    ));

                    $referredName = $patient->lastname . ', ' . $patient->firstname . ' ' . $patient->middlename . ' - Patient';
                } elseif ($patientInfo['referred_source'] == Constants::DSS_REFERRED_PHYSICIAN) {
                    $contact = $this->contact->getDocsleep($patientInfo['referred_by']);

                    $referredName = $contact->lastname . ', ' . $contact->firstname . ' ' . $contact->middlename;
                    if (!empty($contact->contacttype)) {
                        $referredName .= ' - ' . $contact->contacttype;
                    }
                }
            }

            if (!empty($patient)) {
                $copyReqDate = $patient->copyreqdate;
                $preferredContact = $patient->preferredcontact;
                $referredNotes = $patient->referred_notes;
                $name = $patient->lastname . ' ' . $patient->middlename . ', ' . $patient->firstname;
            }

            $summary = $this->summary->getSummary($patientId);

            if (count($summary)) {
                $summary = $summary[0];
                $patientInfo['location'] = $summary->location;
            }

            $butText = 'Add ';
        }

        if (!empty($patient->userid)) {
            $butText = 'Save/Update ';
        } else {
            $butText = 'Add ';
        }

        // Check if required information is filled out
        $completeInfo = 0;
        if (!empty($patientInfo['home_phone']) || !empty($patientInfo['work_phone']) || !empty($patientInfo['cell_phone'])) {
            $patientphone = true;
        }

        if (!empty($patientInfo['email'])) {
            $patientemail = true;
        }

        if ((!empty($patientemail) || !empty($patientphone)) && !empty($patientInfo['add1']) && !empty($patientInfo['city']) && !empty($patientInfo['state']) && !empty($patientInfo['zip']) && !empty($patientInfo['dob']) && !empty($patientInfo['gender'])) {
            $completeInfo = 1;
        }

        // Determine Whether Patient Info has been set
        if (!empty($this->ed)) {
            $this->updatePatientSummary($this->ed, 'patient_info', $completeInfo);
        }

        $showBlock = array();

        $notifications = $this->findPatientNotifications($patientId);

        if (!empty($this->request['search'])) {
            if (strpos($this->request['search'], ' ')) {
                $firstname = ucfirst(substr($this->request['search'], 0, strpos($this->request['search'], ' ')));
                $lastname = ucfirst(substr($this->request['search'], strpos($this->request['search'],' ') + 1));
            } else {
                $firstname = ucfirst($this->request['search']);
            }
        }

        if (!empty($patient) && ($patient->registration_status == 1 || $patient->registration_status == 0)) {
            $showBlock['buttonSendReg'] = true;
        } else {
            $showBlock['buttonSendReg'] = false;
        }

        $companies = $this->company->getJoin(Session::get('docId'), Constants::DSS_COMPANY_TYPE_HST);

        if (count($companies)) {
            if (!empty($patHstNumUncompleted) && $patHstNumUncompleted > 0) {
                $showBlock['orderHst'] = true;
            } else {
                $showBlock['orderHst'] = false;
            }
        }

        $imageType4 = $this->qImage->getImage(4, $patientId, 'adddate');

        if (count($imageType4) == 0) {
            $showBlock['patientPhoto'] = true;
        } else {
            $showBlock['patientPhoto'] = false;
        }

        $registrationStatus = !empty($patient) ? $patient->registration_status : null;
        $accessCode = !empty($patient) ? $patient->access_code : null;

        if (!empty($patient) && $patient->use_patient_portal == 1) {
            switch ($registrationStatus) {
                case 0:
                    $showBlock['registrationStatus'] = 'Unregistered';
                    break;
                case 1:
                    $showBlock['registrationStatus'] = 'Registration Emailed ' . date('m/d/Y h:i a', strtotime($patient->registration_senton)) . ' ET';
                    break;
                case 2:
                    $showBlock['registrationStatus'] = 'Registered';
                    break;
            }
        } else {
            $showBlock['registrationStatus'] = 'Patient Portal In-active';
        }

        $locations = $this->location->getLocations(array(
            'docid' => Session::get('docId')
        ));

        if (empty($patientId)) {
            $copyReqDate = date('m/d/Y');
        }

        $user = $this->user->findUser(Session::get('docId'));

        if ($user->use_eligible_api == 1) {
            $showBlock['insuranceCo'] = true;
        } else {
            $showBlock['insuranceCo'] = false;
        }

        $imageType10 = $this->qImage->getImage(10, $patientId, 'adddate');

        if (count($imageType10) == 0) {
            $showBlock['insuranceCardImage10'] = false;
        } else {
            $showBlock['insuranceCardImage10'] = true;
            $image10 = $imageType10[0];
        }

        $insuranceContacts = $this->contact->getInsuranceContact(Session::get('docId'));

        if (!empty($insuranceContacts)) foreach ($insuranceContacts as $insuranceContact) {
            $insContactsJson[$insuranceContact->contactid] = $insuranceContact->add1 . '\n'
                                                           . $insuranceContact->add2
                                                           . (!empty($insuranceContact->add2) ? '\n' : '')
                                                           . $insuranceContact->city . ' '
                                                           . $insuranceContact->state . ' '
                                                           . $insuranceContact->zip . '\n'
                                                           . GeneralFunctions::formatPhone($insuranceContact->phone1);
        }

        $imageType12 = $this->qImage->getImage(12, $patientId, 'adddate');

        if (count($imageType12) == 0) {
            $showBlock['insuranceCardImage12'] = false;
        } else {
            $showBlock['insuranceCardImage12'] = true;
            $image12 = $imageType12[0];
        }

        if (!empty($docPatientPortal)) {
            $showBlock['portalStatus'] = true;
        } else {
            $showBlock['portalStatus'] = false;
        }

        $letter = $this->letter->getLetters(array(
            'templateid'  => 3,
            'deleted'     => 0,
            'patientid'   => !empty($patientId) ? $patientId : ''
        ), 'generated_date');

        if (count($letter) == 0) {
            $showBlock['introLetter'] = false;
        } else {
            $letter = $letter[0];
            $showBlock['introLetter'] = 'DSS Intro Letter Sent to Patient ' . $letter->generated_date;
        }

        if (empty($this->request['noheaders'])) {
            $showBlock['noHeaders'] = true;
        }

        if (!empty($this->request['readonly'])) {
            $showBlock['readOnly'] = true;
        }

        // send data to view

        foreach ($this->request as $name => $value) {
            $data[$name] = $value;
        }

        $data = array_merge($data, array(
            'showBlock'               => $showBlock,
            'accessCode'              => $accessCode,
            'registrationStatus'      => $registrationStatus,
            'imageType4'              => $imageType4,
            'patientInfo'             => $patientInfo,
            'exclusiveBilling'        => $exclusiveBilling,
            'nameBilling'             => $nameBilling,
            'patientRequestId'        => !empty($patient) ? $patient->patientid : null,
            'butText'                 => $butText,
            'docPatientPortal'        => $docPatientPortal,
            'locations'               => $locations,
            'insuranceContacts'       => $insuranceContacts,
            'docsleepName'            => $docsleepName,
            'docpcpName'              => $docpcpName,
            'docdentistName'          => $docdentistName,
            'docentName'              => $docentName,
            'docmdotherName'          => $docmdotherName,
            'docmdother2Name'         => $docmdother2Name,
            'docmdother3Name'         => $docmdother3Name,
            'referredName'            => !empty($referredName) ? $referredName : '',
            'insContactsJson'         => json_encode($insContactsJson),
            'DSS_REFERRED_MEDIA'      => Constants::DSS_REFERRED_MEDIA,
            'DSS_REFERRED_FRANCHISE'  => Constants::DSS_REFERRED_FRANCHISE,
            'DSS_REFERRED_DSSOFFICE'  => Constants::DSS_REFERRED_DSSOFFICE,
            'DSS_REFERRED_OTHER'      => Constants::DSS_REFERRED_OTHER,
            'DSS_REFERRED_PATIENT'    => Constants::DSS_REFERRED_PATIENT,
            'DSS_REFERRED_PHYSICIAN'  => Constants::DSS_REFERRED_PHYSICIAN,
            'DSS_REFERRED_MEDIA'      => Constants::DSS_REFERRED_MEDIA,
            'DSS_REFERRED_DSSOFFICE'  => Constants::DSS_REFERRED_DSSOFFICE,
            'dssReferredLabels'       => Constants::$dss_referred_labels,
            'path'                    => '/' . Request::segment(1) . '/' . Request::segment(2)
        ));

        // dd($data);

        return view('manage.add_patient', $data);
    }

    public function add()
    {
        $patientId = $this->request['patientId'];

        if (!empty($this->request['patientsub']) && $this->request['patientsub'] == 1) {
            if(!empty($this->request['p_m_eligible_payer'])){
                $patientInfo['p_m_eligible_payer_id'] = substr($this->request['p_m_eligible_payer'], 0, strpos($this->request['p_m_eligible_payer'], '-'));
                $patientInfo['p_m_eligible_payer_name'] = substr($this->request['p_m_eligible_payer'], (strpos($this->request['p_m_eligible_payer'], '-') + 1));
            }else{
                $patientInfo['p_m_eligible_payer_id'] = '';
                $patientInfo['p_m_eligible_payer_name'] = '';
            }

            if(!empty($this->request['s_m_eligible_payer'])){
                $patientInfo['s_m_eligible_payer_id'] = substr($this->request['s_m_eligible_payer'],0,strpos($this->request['s_m_eligible_payer'], '-'));
                $patientInfo['s_m_eligible_payer_name'] = substr($this->request['s_m_eligible_payer'],(strpos($this->request['s_m_eligible_payer'], '-')+1));
            }else{
                $patientInfo['s_m_eligible_payer_id'] = '';
                $patientInfo['s_m_eligible_payer_name'] = '';
            }

            $patientInfo['use_patient_portal'] = $this->request['use_patient_portal'];

            if (!empty($this->ed)) {
                $patient = $this->patient->getPatients(array(
                    'patientid' => $patientId
                ))[0];

                $oldReferredBy = $patient->referred_by;
                $oldReferredSource = $patient->referred_source;
                $oldPMInsCo = $patient->p_m_ins_co;

                if ($patient->registration_status == 2 && $this->request['email'] != $patient->email) {
                    sendUpdatedEmail($patientId, $this->request['email'], $patient->email, 'doc');
                } elseif (isset($this->request['sendRem'])) {
                    sendReminderEmail($this->ed, $this->request['email']);
                } elseif (!isset($this->request['sendReg']) && $patient->registration_status == 1 && trim($this->request['email']) != trim($patient->email)) {
                    if (!empty($docPatientPortal) && !empty($patientInfo['use_patient_portal'])) {
                        sendRegistrationEmail($this->ed, $this->request['email'], '');
                    }
                }

                foreach ($this->patientData as $attribute) {
                    $data[$attribute] = $this->request[$attribute];
                }

                $data = array_merge($data, array(
                    'ssn'                      => $this->num($this->request['ssn'], false), 
                    'home_phone'               => $this->num($this->request['home_phone']), 
                    'work_phone'               => $this->num($this->request['work_phone']), 
                    'cell_phone'               => $this->num($this->request['cell_phone']),
                    'p_m_eligible_payer_id'    => $patientInfo['s_m_eligible_payer_id'],
                    'p_m_eligible_payer_name'  => $patientInfo['s_m_eligible_payer_name'],
                    'emp_phone'                => $this->num($this->request['emp_phone']), 
                    'emp_fax'                  => $this->num($this->request['emp_fax']), 
                    'emergency_number'         => $this->num($this->request['emergency_number']),
                    'emergency_number'         => $this->num($this->request['emergency_number'])
                ));

                if ($this->request['email'] != $patient->email) {
                    $data['email_bounce'] = 0;
                }

                $this->patient->updateData(array(
                    'patientid' => $this->ed
                ), $data);

                $data = array(
                    'email' => $this->request['email']
                );

                $this->patient->updateData(array(
                    'parent_patientid' => $this->ed
                ), $data);

                if (
                    $oldPMInsCo != $this->request['p_m_ins_co'] || $patient->p_m_relation != $this->request['p_m_relation'] ||
                    $patient->p_m_partyfname != $this->request['p_m_partyfname'] || $patient->p_m_partylname != $this->request['p_m_partylname'] ||
                    $patient->ins_dob != $this->request['ins_dob'] || $patient->p_m_ins_type != $this->request['p_m_ins_type'] ||
                    $patient->p_m_ins_ass != $this->request['p_m_ins_ass'] || $patient->p_m_ins_id != $this->request['p_m_ins_id'] ||
                    $patient->p_m_ins_grp != $this->request['p_m_ins_grp'] || $patient->p_m_ins_plan != $this->request['p_m_ins_plan']
                ) {
                    $data = array(
                        'status'         => Constants::DSS_PREAUTH_REJECTED,
                        'reject_reason'  => Session::get('name') . ' altered patient insurance information requiring VOB resubmission on ' . date('m/d/Y h:i'),
                        'viewed'         => 1
                    );

                    $countOfAffectedRows = $this->insurancePreauth->updateData($this->ed, Constants::DSS_PREAUTH_PENDING, Constants::DSS_PREAUTH_PREAUTH_PENDING, $data);

                    if ($countOfAffectedRows >= 1) {
                        $vob = $this->createVob($this->ed);
                    }
                }

                if (!empty($this->request['location'])) {
                    $summary = $this->summary->getSummary($patientId);

                    if (!empty($summary)) {
                        $data = array(
                            'location' => $this->request['location']
                        );

                        $this->summary->updateData(array(
                            'patientid' => $patientId
                        ), $data);
                    } else {
                        $data = array(
                            'location'   => $this->request['location'],
                            'patientid'  => $patientId
                        );

                        $this->summary->insertData($data);
                    }
                }

                $patient = $this->patient->getPatients(array(
                    'patientid' => $this->ed
                ))[0];

                $login = $patient->login;
                $password = $patient->password;

                if (empty($login)) {
                    $cLogin = strtolower(substr($this->request["firstname"], 0, 1) . $this->request["lastname"]);
                    $cLogin = ereg_replace('[^A-Za-z]', '', $cLogin);

                    $loginsResponse = $this->patient->getLogins($cLogin);

                    $logins = array();
                    if ($loginsResponse) foreach ($loginsResponse as $login) {
                        array_push($logins, $login->login);
                    }

                    if (in_array($cLogin, $logins)) {
                        $count = 1;
                        while (in_array($cLogin . $count, $logins)) {
                            $count++;
                        }

                        $login = strtolower($cLogin . $count);
                    } else {
                        $login = strtolower($cLogin);
                    }

                    $data = array(
                        'login' => $login
                    );

                    $this->patient->updateData(array(
                        'patientid' => $this->ed
                    ), $data);
                }

                $showWarningCellPhone = false;

                if (!empty($this->request['sendReg']) && $docPatientPortal && $this->request['use_patient_portal']) {
                    if (trim($this->request['email']) != '' && trim($this->request['cell_phone']) != '') {
                        sendRegistrationEmail($this->ed, $this->request['email'], $login, $patient->email);
                    } else {
                        $showWarningCellPhone = true;
                    }
                }

                $data = array(
                    'date_completed' => date('Y-m-d', strtotime($this->request['copyreqdate']))
                );

                $this->flowPg2->updateData($this->ed, $data);

                if ($oldReferredBy != $this->request['referred_by'] || $oldReferredSource != $this->request["referred_source"]) {
                    if ($oldReferredSource == 2 && $this->request['referred_source'] == 2) {
                        // PHYSICIAN -> PHYSICIAN
                        // change pending letters to new referrer

                        $data = array(
                            'template'          => null,
                            'md_referral_list'  => $this->request["referred_by"]
                        );

                        $this->letter->updateData(array(
                            'status'            => 0,
                            'md_referral_list'  => $oldReferredBy,
                            'patientid'         => $this->ed
                        ), $data);
                    } elseif ($oldReferredSource == 1 && $this->request['referred_source'] == 1) {
                        // PATIENT -> PATIENT
                        // change pending letters to new referrer

                        $data = array(
                            'template'          => null,
                            'md_referral_list'  => $this->request["referred_by"]
                        );

                        $this->letter->updateData(array(
                            'status'             => 0,
                            'pat_referral_list'  => $oldReferredBy,
                            'patientid'          => $this->ed
                        ), $data);
                    } elseif ($oldReferredSource == 2 && $this->request['referred_source'] != 2) {
                        // PHYSICIAN -> NOT PHYSICIAN

                        $letters = $this->letter->getLetters(array(
                            'md_referral_list'  => $oldReferredBy,
                            'patientid'         => $this->reuqest['ed'],
                            'status'            => 0
                        ));

                        if (count($letters)) foreach ($letters as $letter) {
                            deleteLetter($letter->letterid, null, 'mdReferral', $oldReferredBy);
                        }
                    } elseif ($oldReferredSource == 1 && $this->request['referred_source'] != 1) {
                        //PHYSICIAN -> NOT PHYSICIAN

                        $letters = $this->letter->getLetters(array(
                            'pat_referral_list'  => $oldReferredBy,
                            'patientid'          => $this->reuqest['ed'],
                            'status'             => 0
                        ));

                        if (count($letters)) foreach ($letters as $letter) {
                            deleteLetter($letter->letterid, null, 'patReferral', $oldReferredBy);    
                        }
                    }
                }

                $this->triggerLetter1and2($this->ed, array(
                    $this->request['docsleep'], $this->request['docpcp'], $this->request['docdentist'],
                    $this->request['docent'], $this->request['docmdother'], $this->request['docmdother2'],
                    $this->request['docmdother3']
                ));

                if (!empty($this->request['introletter']) && $this->request['introletter'] == 1) {
                    $this->triggerLetter3($this->ed);
                }

                if (!empty($this->request['add_ref_but'])) {
                    return redirect('add_referredby/addtopat/$patientId');
                }

                if (!empty($this->request['add_ins_but'])) {
                    if (!empty($patientId)) {
                        $redirect = '/pid/$patientId/type/11/ctypeeq/1/activePat/$patientId';
                    }

                    return redirect('add_contact/ctype/ins' . $redirect);
                }

                if (!empty($this->request['add_contact_but'])) {
                    return redirect('add_patient_to/ed/$patientId');
                }

                if (!empty($this->request['sendHST'])) {
                    return redirect('hst_request_co/ed/$patientId');
                }

                $message = 'Edited Successfully';

                if (!empty($this->request['sendPin'])) {
                    $sendPin = '/sendPin/1';
                } else {
                    $sendPin = '';
                }

                return redirect('add_patient/ed/$patientId/preview/1/addtopat/1/pid/$patientId/msg/$msg $sendPin');
            } else {
                $cLogin = strtolower(substr($this->request['firstname'], 0, 1) . $this->request['lastname']);
                $cLogin = preg_replace('[^A-Za-z]', '', $cLogin);

                $loginsResponse = $this->patient->getLogins($cLogin);

                $logins = array();
                if ($loginsResponse) foreach ($loginsResponse as $login) {
                    array_push($logins, $login->login);
                }

                if (in_array($cLogin, $logins)) {
                    $count = 1;
                    while (in_array($cLogin . $count, $logins)) {
                        $count++;
                    }

                    $login = strtolower($cLogin . $count);
                } else {
                    $login = strtolower($cLogin);
                }

                if (!empty($this->request['ssn'])) {
                    $salt = Password::createSalt();
                    $password = preg_replace('/\D/', '', $this->request['ssn']);
                    $password = Password::genPassword($password , $salt);
                } else {
                    $salt = '';
                    $password = '';
                }

                foreach ($this->patientData as $attribute) {
                    if (!empty($this->request[$attribute])) { 
                        $data[$attribute] = $this->request[$attribute];
                    } else {
                        $data[$attribute] = 0;
                    }
                }

                $data = array_merge($data, array(
                    'firstname'                => ucfirst($this->request['firstname']),
                    'lastname'                 => ucfirst($this->request['lastname']),
                    'middlename'               => ucfirst($this->request['middlename']),
                    'login'                    => $login,
                    'salt'                     => $salt,
                    'password'                 => $password,
                    'ssn'                      => $this->num($this->request['ssn'], false), 
                    'home_phone'               => $this->num($this->request['home_phone']), 
                    'work_phone'               => $this->num($this->request['work_phone']), 
                    'cell_phone'               => $this->num($this->request['cell_phone']),
                    'p_m_eligible_payer_id'    => $patientInfo['p_m_eligible_payer_id'],
                    'p_m_eligible_payer_name'  => $patientInfo['p_m_eligible_payer_name'],
                    'emp_phone'                => $this->num($this->request['emp_phone']), 
                    'emp_fax'                  => $this->num($this->request['emp_fax']), 
                    'emergency_number'         => $this->num($this->request['emergency_number']),
                    'emergency_number'         => $this->num($this->request['emergency_number']),
                    'ip_address'               => Request::ip()
                ));

                $insertedPatientId = $this->patient->insertData($data);

                if (!empty($this->request['location'])) {
                    $data = array(
                        'location'   => $this->request['location'],
                        'patientid'  => $this->request['pid']
                    );

                    $this->summary->insertData($data);
                }

                $this->triggerLetter1and2($insertedPatientId, array(
                    $this->request['docsleep'], $this->request['docpcp'], $this->request['docdentist'],
                    $this->request['docent'], $this->request['docmdother'], $this->request['docmdother2'],
                    $this->request['docmdother3']
                ));

                if (!empty($this->request['sendReg']) && $docPatientPortal && $this->request['use_patient_portal']) {
                    if (trim($this->request['email']) != '' && trim($this->request['cell_phone']) != '') {
                        sendRegistrationEmail($insertedPatientId, $this->request['email'], $login);
                    } else {
                        $showWarningCellPhone = true;
                    }
                }

                if (!empty($this->request['introletter']) && $this->request['introletter'] == 1) {
                    $this->triggerLetter3($this->ed);
                }

                $data = array(
                    'id'           => null,
                    'copyreqdate'  => $this->request['copyreqdate'],
                    'pid'          => $insertedPatientId
                );

                $insertedFlowPg1Id = $this->flowPg1->insertData($data);

                if (!empty($insertedFlowPg1Id)) {
                    // code...
                } else {
                    if (!empty($referredByQuery)) {
                        $referredResult = $db->query($referredByQuery);
                        $message = 'Successfully updated flowsheet!2';
                    }
                }

                $stepId = '1';
                $segmentId = '1';
                $scheduled = strtotime(!empty($copyReqDate) ? $copyReqDate : '');
                $genDate = date('Y-m-d H:i:s', strtotime($this->request['copyreqdate']));

                $data = array(
                    'patientid'       => $insertedPatientId,
                    'stepid'          => $stepId,
                    'segmentid'       => $segmentId,
                    'date_scheduled'  => $scheduled,
                    'date_completed'  => $genDate
                );

                $insertedFlowPg2InfoId = $this->flowPg2Info->insertData($data);

                if (empty($insertedFlowPg2InfoId)) {
                    $message = "Error inserting Initial Contact Information to Flowsheet Page 2";
                }

                $similarPatients = $this->similarPatients($insertedPatientId);

                if (count($similarPatients)) {
                    return redirect('/manage/duplicate_patient/' . $insertedPatientId);
                } else {
                    $message = 'Patient' . $this->request['firstname'] . ' ' . $this->request['lastname'] . ' added Successfully';

                    if (!empty($this->request['sendPin'])) {
                        $sendPin = '/sendPin/1';
                    } else {
                        $sendPin = '';
                    }

                    return redirect('add_patient/' . $insertedPatientId. '/ed/' . $insertedPatientId . '/addtopat/1' . $sendPin);
                }
            }
        }
    }

    public function duplicate()
    {
        if (!empty($this->request['deleteId'])) {
            $this->patient->deleteData(array(
                'docid'      => Session::get('docId'),
                'patientid'  => $this->request['deleteId']
            ));

            return redirect('add_patient/' . $this->request['useid'])->with(array(
                'ed'        => $this->request['useId'],
                'preview'   => 1,
                'addtopat'  => 1
            ));
        } elseif (!empty($this->request['createId'])) {
            return redirect('add_patient/' . $this->request['createId'])->with('ed', $this->request['createId']);
        }

        $duplicates = $this->patient->getPendingDuplicates(array(
            'patientid'  => !empty($this->request['patientId']) ? $this->request['patientId'] : null,
            'docid'      => Session::get('docId')
        ), null, 'p.lastname');

        if (count($duplicates)) {
            $duplicate = $duplicates[0];
            $similarPatients = $this->similarPatients($duplicate->patientid);
        } else {
            $duplicate = null;
            $similarPatients = null;
        }

        foreach ($this->request as $name => $value) {
            $data[$name] = $value;
        }

        $data = array_merge($data, array(
            'path'             => '/' . Request::segment(1) . '/' . Request::segment(2),
            'duplicate'        => $duplicate,
            'similarPatients'  => $similarPatients,
            'deleteId'         => !empty($this->request['deleteid']) ? $this->request['deleteid'] : null,
            'link'             => Request::path()
        ));

        return view('manage.duplicate', $data);
    }

    public function searchPatients()
    {
        if (Request::ajax()) {
            $partial = '';

            if (Request::has('partial_name')) {
                $partial = $this->request['partial_name'];
                $partial = preg_replace("[^ A-Za-z'\-]", "", $partial);
            }

            $names = explode(" ", $partial);

            if (empty($names[1])) {
                $names[1] = '';
            }

            if (empty($names[2])) {
                $names[2] = '';
            }

            $patients = $this->patient->searchPatients($names, Session::get('docId'));

            $patientsInfo = array();
            $i = 0;
            if (count($patients)) {
                foreach ($patients as $patient) {
                    $patientsInfo[$i]['patientId'] = $patient->patientid;
                    $patientsInfo[$i]['lastname'] = $patient->lastname;
                    $patientsInfo[$i]['firstname'] = $patient->firstname;
                    $patientsInfo[$i]['middlename'] = $patient->middlename;
                    $patientsInfo[$i]['patientInfo'] = $patient->patient_info;
                    $i++;
                }
            } else {
                $patientsInfo = array('error' => 'Could not select patients from database');
            }

            return Response::json($patientsInfo);
        } else {
            return null;
        }
    }

    private function triggerLetter1and2($patientId, $mdContacts)
    {
        $user = $this->user->findUser(Session::get('docId'));

        if ($user->use_letters && $user->intro_letters) {
            $letter1Id = '1';
            $letter2Id = '2';

            $recipients = array();
            foreach ($mdContacts as $contact) {
                if ($contact != 'Not Set') {
                    $mdList = $this->letter->getMdList($contact, $letter1Id, $letter2Id);

                    $numMdList = count($mdList);

                    if (empty($numMdList)) {
                        return 'Error Selecting Letters from Database';
                    }

                    if ($numMdList == 0 && $contact != '') {
                        $contact = $this->contact->find(array(
                            'contactid'  => $contact,
                            'status'     => 1
                        ));

                        if (count($contact)) {
                            $recipients[] = $contact;
                        }
                    }
                }
            }

            if (count($recipients)) {
                $recipientsList = implode(',', $recipients);
                $letter2 = $this->createLetter($letter2id, $patientId, '', '', $recipientsList);

                if (Session::get('userType') != Constants::DSS_USER_TYPE_SOFTWARE) {
                    $letter1 = $this->createLetter($letter1id, $patientId, '', '', $recipientsList);

                    if (!is_numeric($letter1)) {
                        return $letter1;
                    }
                }

                if (!is_numeric($letter2)) {
                    return $letter2;
                }
            }
        }
    }

    private function triggerLetter3($patientId)
    {
        $letterId = '3';
        $toPatient = '1';

        $letter = $this->createLetter($letterid, $pid, '', $topatient);

        return $letter;
    }

    private function sendRegistrationEmail($patientId, $email, $login, $oldEmail = '')
    {
        $patient = $this->patient->getPatients(array(
            'patientid' => $patientId
        ))[0];

        if ($patient->recover_hash == '' || $e != $oldEmail) {
            $recoverHash = hash('sha256', $patient->patientid . $patient->email . rand());
            $data = array(
                'text_num'             => 0,
                'access_type'          => 1,
                'text_date'            => date('Y-m-d H:i:s'),
                'access_code'          => '',
                'registration_senton'  => date('Y-m-d H:i:s'),
                'registration_status'  => 1,
                'recover_hash'         => $recoverHash,
                'recover_time'         => date('Y-m-d H:i:s')
            );

            $this->patient->updateData(array(
                'patientid' => $patient->patientId
            ), $data);
        } else {
            $data = array(
                'access_type'          => 1,
                'registration_senton'  => date('Y-m-d H:i:s'),
                'registration_status'  => 1
            );

            $this->patient->updateData(array(
                'patientid' => $patient->patientId
            ), $data);

            $recoverHash = $patient->recover_hash;
        }

        // not used anywhere
        /*
        $location = $this->user->getLocation(array(
            'p.patientid' => $patient->patientid
        ), true);
        */

        $location = $this->summary->getSummary($patient->patientid)[0];

        if (!empty($location->location)) {
            $location = $this->user->getLocation(array(
                'l.id'     => $location->location,
                'l.docid'  => $patient->docid
            ));
        } else {
            $location = $this->user->getLocation(array(
                'p.patientid' => $patient->patientid
            ), true);
        }

        $mailingPhone = $location->mailing_phone;

        if ($location->user_type == Constants::DSS_USER_TYPE_SOFTWARE) {
            $logo = "/manage/q_file/" . $location->logo;
        } else {
            $logo = "/reg/images/email/reg_logo.gif";
        }

        $data = array(
            'mailingPractice'  => $location->mailing_practice,
            'mailingAddress'   => $location->mailing_address,
            'mailingCity'      => $location->mailing_city,
            'mailingState'     => $location->mailing_state,
            'mailingZip'       => $location->mailing_zip,
            'email'            => $email,
            'link'             => Request::root() . '/reg/activate/id/' . $patient->patientid . '/hash/' . $recoverHash,
            'contactUs'        => GeneralFunctions::formatPhone($mailingPhone),
            'imgHeaderFo'      => Request::root() . '/img/email/email_header_fo.png',
            'linkLogo'         => Request::root() . $logo,
            'emailFooter'      => Constants::DSS_EMAIL_FOOTER
        );

        Mail::send('emails.registration', $data, function($message) use ($email){
            $message->from('patient@dentalsleepsolutions.com', 'Dental Sleep Solutions');
            $message->to($email, '')->subject('Online Patient Registration');
        });
    }

    private function sendReminderEmail($patientId, $email)
    {
        $patient = $this->patient->getPatients(array(
            'patientid' => $patientId
        ))[0];

        $location = $this->summary->getSummary($patient->patientid)[0];

        if (!empty($location->location)) {
            $location = $this->user->getLocation(array(
                'l.id'     => $location->location,
                'l.docid'  => $patient->docid
            ));
        } else {
            $location = $this->user->getLocation(array(
                'p.patientid' => $patient->patientid
            ), true);
        }

        $mailingPhone = $location->mailing_phone;

        if ($location->user_type == Constants::DSS_USER_TYPE_SOFTWARE) {
            $logo = "/manage/q_file/" . $location->logo;
        } else {
            $logo = "/reg/images/email/reg_logo.gif";
        }

        $headers = 'From: Dental Sleep Solutions <patient@dentalsleepsolutions.com>' . "\r\n"
                 . 'Content-type: text/html' . "\r\n"
                 . 'Reply-To: patient@dentalsleepsolutions.com' . "\r\n"
                 . 'X-Mailer: PHP/' . phpversion();

        $subject = "Online Patient Registration";

        $data = array(
            'mailingPractice'  => $location->mailing_practice,
            'mailingAddress'   => $location->mailing_address,
            'mailingCity'      => $location->mailing_city,
            'mailingState'     => $location->mailing_state,
            'mailingZip'       => $location->mailing_zip,
            'email'            => $email,
            'contactUs'        => GeneralFunctions::formatPhone($mailingPhone),
            'imgHeaderFo'      => Request::root() . '/img/email/email_header_fo.png',
            'linkLogo'         => Request::root() . $logo,
            'link'             => Request::root() . '/reg/login/email/' . str_replace('+', '%2B', $email),
            'emailFooter'      => Constants::DSS_EMAIL_FOOTER
        );

        Mail::send('emails.registration', $data, function($message) use ($email){
            $message->from('patient@dentalsleepsolutions.com', 'Dental Sleep Solutions');
            $message->to($email, '')->subject('Online Patient Registration');
        });
    }

    private function num($n, $phone = true)
    {
        $n = preg_replace('/\D/', '', $n);

        if (!$phone) {
            return $n;
        }

        $pattern = '/([1]*)(.*)/'; 
        preg_match($pattern, $n, $matches);

        return $matches[2];
    }

    private function createVob($patientId)
    {
        $e0486 = (count($this->patient->getTransactionCode0486($patientId)) > 0);

        $userInfo = (count($this->patient->getUserInfo($patientId)) > 0);

        if (!$e0486 && !$userInfo) {
            return 'e0486_user';
        } elseif (!$e0486) {
            return 'e0486';
        } elseif (!$userInfo) {
            return 'user';
        }

        $patient = $this->patient->getPreauthPatient($patientId);

        $sleepStudy = $this->summSleeplab->getPreauthSleepStudy($patientId);

        $diagnosis = $sleepStudy->diagnosis;

        $data = array(
            'patient_id'                 => $patientId,
            'doc_id'                     => $patient->doc_id,
            'ins_co'                     => $patient->ins_co,
            'ins_rank'                   => $patient->ins_rank,
            'ins_phone'                  => $patient->ins_phone,
            'patient_ins_group_id'       => $patient->patient_ins_group_id,
            'patient_ins_id'             => $patient->patient_ins_id,
            'patient_firstname'          => $patient->patient_firstname,
            'patient_lastname'           => $patient->patient_lastname,
            'patient_phone'              => $patient->patient_phone,
            'patient_add1'               => $patient->patient_add1,
            'patient_add2'               => $patient->patient_add2,
            'patient_city'               => $patient->patient_city,
            'patient_state'              => $patient->patient_state,
            'patient_zip'                => $patient->patient_zip,
            'patient_dob'                => $patient->patient_dob,
            'insured_first_name'         => $patient->insured_first_name,
            'insured_last_name'          => $patient->insured_last_name,
            'insured_dob'                => $patient->insured_dob,
            'doc_npi'                    => $patient->doc_npi,
            'referring_doc_npi'          => $patient->referring_doc_npi,
            'trxn_code_amount'           => $patient->trxn_code_amount,
            'diagnosis_code'             => $diagnosis,
            'doc_medicare_npi'           => $patient->doc_medicare_npi,
            'doc_tax_id_or_ssn'          => $patient->doc_tax_id_or_ssn,
            'front_office_request_date'  => date('Y-m-d H:i:s'),
            'status'                     => Constants::DSS_PREAUTH_PENDING,
            'userid'                     => Session::get('userId'),
            'viewed'                     => 1,
            'doc_name'                   => $patient->doc_name,
            'doc_practice'               => $patient->doc_practice,
            'doc_address'                => $patient->doc_address,
            'doc_phone'                  => $patient->doc_phone
        );

        $insurancePreauthId = $this->insurancePreauth->insertData($data);

        return $insurancePreauthId;
    }

    private function deleteLetter($letterId, $type, $recipientId, $parent = null, $template = null)
    {
        $letter = $this->letter->getLetters(array(
            'letterid' => $letterId
        ))[0];

        $contacts = $this->getContactInfo((($patient->topatient == '1') ? $patient->patientid : ''), $patient->md_list, $patient->md_referral_list, $patient->pat_referral_list);

        $totalContacts = count(!empty($contacts->patient) ? $contacts->patient : array()) + count($contacts->mds) + count(!empty($contacts->md_referrals) ? $contacts->md_referrals : array()) + count(!empty($contacts->pat_referrals) ? $contacts->pat_referrals : array());

        if (empty($letterId)) {
            return false;
        } elseif ($totalContacts == 1) {
            $data = array(
                'parentid'    => null,
                'deleted'     => 1,
                'deleted_by'  => Session::get('userId'),
                'deleted_on'  => date('Y-m-d H:i:s')
            );

            $letterResponse = $this->letter->updateData(array(
                'letterid' => $letterId
            ), $data);

            $data = array(
                'viewed' => 1
            );

            $faxResponse = $this->fax->updateData(array(
                'letterid' => $letterId
            ), $data);

            $data = array(
                'parentid' => null,
            );

            $parentResponse = $this->letter->updateData(array(
                'parentid' => $letterId
            ), $data);

            return $letterResponse;
        } else {
            $letter = $this->letter->getLetters(array(
                'letterid' => $letterId
            ));

            if (!empty($letter)) foreach ($letter as $attribute) {
                $deleted = '1';

                if ($type == 'patient') {
                    $toPatient = '1';
                    $removePatient = '0';
                } elseif ($type == 'md') {
                    $mdList = $recipientId;
                    $mds = explode(",", $attribute->md_list);
                    $key = array_search($recipientId, $mds);
                    unset($mds[$key]);
                    $newMds = implode(",", $mds);
                    $ccMds = explode(",", $attribute->cc_md_list);
                    $ccKey = array_search($recipientId, $ccMds);
                    unset($ccMds[$ccKey]);
                    $newCcMds = implode(",", $ccMds);
                } elseif ($type == 'mdReferral') {
                    $mdReferralList = $recipientId;
                    $mdReferrals = explode(",", $attribute->md_referral_list);
                    $key = array_search($recipientId, $mdReferrals);
                    unset($mdReferrals[$key]);
                    $newMdReferrals = implode(",", $mdReferrals);
                    $ccMdReferrals = explode(",", $attribute->cc_md_referral_list);
                    $ccKey = array_search($recipientId, $ccMdReferrals);
                    unset($ccMdReferrals[$ccKey]);
                    $newCcMdReferrals = implode(",", $ccMdReferrals);
                } elseif ($type == 'patReferral') {
                    $patReferralList = $recipientId;
                    $patReferrals = explode(",", $attribute->pat_referral_list);
                    $key = array_search($recipientId, $patReferrals);
                    unset($patReferrals[$key]);
                    $newPatReferrals = implode(",", $patReferrals);
                    $ccPatReferrals = explode(",", $attribute->cc_pat_referral_list);
                    $ccKey = array_search($recipientId, $ccPatReferrals);
                    unset($ccPatReferrals[$ccKey]);
                    $newCcPatReferrals = implode(",", $ccPatReferrals);
                }

                $letter = $this->createLetter($attribute->templateid, $attribute->patientid, $attribute->info_id, $toPatient, $mdList, $mdReferralList, $patReferralList, $letterId, $template, $attribute->send_method, '', $deleted, false);
            }

            if (is_numeric($letter)) {
                if ($type == 'patient') {
                    $data = array(
                        'topatient'     => $removePatient,
                        'cc_topatient'  => $removePatient
                    );                    
                } elseif ($type == 'md') {
                    $data = array(
                        'md_list'     => $newMds,
                        'cc_md_list'  => $newCcMds
                    );
                } elseif ($type == 'mdReferral') {
                    $data = array(
                        'md_referral_list'     => $newMdReferrals,
                        'cc_md_referral_list'  => $newCcMdReferrals
                    );
                } elseif ($type == 'patReferral') {
                    $data = array(
                        'pat_referral_list'     => $newPatReferrals,
                        'cc_pat_referral_list'  => $newCcPatReferrals
                    );
                }

                $letterResponse = $this->letter->updateData(array(
                    'letterid' => $letterId
                ), $data);

                if (!empty($letterResponse)) {
                    return false;
                } else {
                    return $letter;
                }
            }
        }
    }

    // Retrieve Names Salutation and more from Database
    // Returns an array of the form [patient, mds, or md_referrals][id]['fieldname']
    private function getContactInfo($patientId, $mdList, $mdReferralList, $patientReferralList = null, $letterId = 0)
    {
        $contactInfo = array();

        if (!empty($patientId)) {
            $patient = $this->patient->getPatients(array(
                'patientid' => $patientId
            ))[0];

            if (!empty($patient)) {
                foreach ($patient as $attribute) {
                    $contactInfo['patient'][] = $attribute;
                }
            }
        }

        if (!empty($mdList)) {
            $contact = $this->contact->getDocsleep($mdList);

            if (!empty($contact)) {
                foreach ($contact as $attribute) {
                    $contactInfo['mds'][] = $attribute;
                }
            }
        }

        if (!empty($mdReferralList)) {
            $contact = $this->contact->getDocsleep($mdReferralList);

            if (!empty($contact)) {
                foreach ($contact as $attribute) {
                    $contactInfo['mdReferrals'][] = $attribute;
                }
            }
        }

        if (!empty($patientReferralList)) {
            $patient = $this->patient->getPatients(array(
                'patientid' => $patientReferralList
            ));

            if (!empty($patient)) {
                foreach ($patient as $attribute) {
                    $contactInfo['patReferrals'][] = $attribute;
                }
            }
        }

        return $contactInfo;
    }

    private function similarPatients($patientId)
    {
        $patient = $this->patient->getPatients(array(
            'patientid' => $patientId
        ))[0];

        $data = array(
            'patientId'  => $patientId,
            'docId'      => Session::get('docId'),
            'firstname'  => $patient->firstname,
            'lastname'   => $patient->lastname,
            'add1'       => $patient->add1,
            'city'       => $patient->city,
            'state'      => $patient->state,
            'zip'        => $patient->zip
        );

        $similarPatients = $this->patient->getSimilarPatients($data);

        $docs = array();
        $counter = 0;

        foreach ($similarPatients as $patient) {
            $docs[$counter]['id'] = $patient->patientid;
            $docs[$counter]['name'] = $patient->firstname . ' ' . $patient->lastname;
            $docs[$counter]['address'] = $patient->add1 . ' ' . $patient->add2 . ' ' . $patient->city . ' ' . $patient->state . ' ' . $patient->zip;
            $docs[$counter]['phone'] = (!empty($patient->phone1) ? $patient->phone1 : '');

            $counter++;
        }

        return $docs;
    }

    private function updatePatientSummary($patientId = null, $column = null, $value = null)
    {
        if (empty($patientId) || empty($column)) {
            return 0;
        }

        $insert = false;
        $patientSummary = $this->patientSummary->getPatientSummary(array(
            'pid' => $patientId
        ));

        if (count($patientSummary) == 0) {
            $insert = true;
        }

        if ($insert) {
            $data = array(
                'pid'     => $patientId,
                $column => $value 
            );

            $result = $this->patientSummary->insertData($data);
        } else {
            $data = array(
                $column => $value
            );

            $result = $this->patientSummary->updateData($patientId, $data);
        }

        return $result;
    }

    private function findPatientNotifications($patientId)
    {
        $notifications = $this->notification->getNotifications(array(
            'patientid'  => $patientId,
            'status'     => 1
        ));

        return $notifications;
    }

    private function createLetter($templateId, $patientId = null, $infoId = null, $toPatient = null, $mdList = null, $mdReferralList = null, $patReferralList = null, $parentId = null, $template = null, $sendMethod = null, $status = null, $deleted = null, $checkRecipient = true, $templateType = null, $ccToPatient = null, $ccMdList = null, $ccMdReferralList = null, $ccPatReferral_list = null, $fontSize = null, $fontFamily = null)
    {
        if (!empty(Session::get('docId'))) {
            $user = $this->user->findUser(Session::get('docId'));

            if ($user->use_letters != '1') {
                return -1;
            }
        }

        if ((!$toPatient && !$mdReferralList && !$mdList && !$patReferral_list) || ($checkRecipient && !$mdReferralList && !$mdList && ($templateId == 16 || $templateId == 19))) {
            $letterTemplate = $this->letterTemplate->findLetterTemplate($templateId);

            return false;
        }

        $mdArray = explode(',', $mdList);
        $mdArray = array_filter($mdArray, array(new MDReferralFilter($mdReferralList), 'isReferrer'));
        $mdList = implode(',', $mdArray);

        $genDate = date('Y-m-d H:i:s');
        if ($status == null) {
            $status = '0';
        }

        $delivered = '0';
        if ($deleted == null) {
            $deleted = '0';
        }

        $data = array();

        if (!isset($templateid)) {
            return "Error: Letter Template not specified";
        } else {
            $data['templateid'] = $templateId;
        }

        if ($status == 1) {
            $data['date_sent'] = date('Y-m-d H:i:s');
        }

        if (isset($patientId)) {
            $data['patientid'] = $patientId;
        }

        if (isset($infoId)) {
            $data['info_id'] = $infoId;
        }

        if (isset($parentId) && $status != 1) {
            $data['parentid'] = $parentId;
        } elseif ($status == 1) {
            $data['parentid'] = '';
        }

        if (isset($toPatient)) {
            $data['topatient'] = $toPatient;

            if (!isset($ccToPatient)) {
                $data['cc_topatient'] = $toPatient;
            }
        }

        if (isset($ccToPatient)) {
            $data['cc_topatient'] = $ccToPatient;
        }

        if (isset($mdList)) {
            $data['md_list'] = $mdList;

            if (!isset($ccMdList)) {
                $data['cc_md_list'] = $mdList;
            }
        }

        if (isset($ccMdList)) {
            $data['cc_md_list'] = $ccMdList;
        }

        if (isset($mdReferralList)) {
            $data['md_referral_list'] = $mdReferralList;

            if (!isset($ccMdReferralList)) {
                $data['cc_md_referral_list'] = $mdReferralList;
            }
        }

        if (isset($ccMdReferralList)) {
            $data['cc_md_referral_list'] = $ccMdReferralList;
        }

        if (isset($patReferralList)) {
            $data['pat_referral_list'] = $patReferralList;

            if (!isset($ccPatReferralList)) {
                $data['cc_pat_referral_list'] = $patReferralList;
            }
        }

        if (isset($ccPatReferralList)) {
            $data['cc_pat_referral_list'] = $ccPatReferralList;
        }

        if (isset($template)) {
            $template = html_entity_decode(preg_replace('/(&Acirc;|&acirc;|&nbsp;)+/i', '', $template), ENT_COMPAT | ENT_IGNORE, "UTF-8");

            $data['template'] = $template;
        }

        if (isset($sendMethod)) {
            $data['send_method'] = $sendMethod;
        }

        if (isset($status)) {
            $data['status'] = $status;
        }

        if (isset($deleted)) {
            $data['deleted']     = $deleted;
            $data['deleted_by'] = Session::get('userid');
            $data['deleted_on'] = date('Y-m-d H:i:s');
        }

        if (isset($templateType)) {
            $data['template_type'] = $templateType;
        }

        if($fontSize){
            $data['font_size'] = $fontSize;
        }

        if($fontFamily){
            $data['font_family'] = $fontFamily;
        }

        $data['generated_date'] = $genDate;
        $data['delivered']  = $delivered;
        $data['docid']      = Session::get('docid');
        $data['userid']     = Session::get('userid');

        $letterId = $this->letter->insertData($data);

        if (empty($letterId)) {
            return 'Error inserting Letter to Database';
        } else {
            return $letterId;
        }
    }

    private function triggerLetter20($patientId)
    {
        $letterId = '20';
        $mdList = $this->getMdContactIds($patientId);
        $ptReferralList = $this->getPtReferralIds($patientId);
        $letter = $this->createLetter($letterId, $patientId, '', '', '', '', $ptReferralList);

        if (!is_numeric($letter)) {
            return "Can't send letter 20: " . $letter;
        } else {
            return $letter; 
        }
    }

    private function getMdContactIds($patientId, $active = true)
    {
        $patients = $this->patient->getPatients(array(
            'patientid' => $patientId
        ));

        if (count($patients)) {
            $patient = $patients[0];

            $contactIds = array();
            foreach ($patient as $field) {
                if ($field != 'Not Set') {
                    $contacts = explode(",", $field);

                    foreach ($contacts as $contact) {
                        if (!empty($contact)) {
                            if (!in_array($contact, $contactIds)) {
                                if ($active) {
                                    $contactResponse = $this->contact->find(array(
                                        'contactid' => $contact
                                    ));

                                    if ($contactResponse->status == 1) {
                                        $contactIds[] = $contact;
                                    }
                                } else {
                                    $contactIds[] = $contact;
                                }
                            }
                        }
                    }
                }
            }
        }

        $contactIdList = implode(',', $contactIds);

        return $contactIdList;
    }

    private function getPtReferralIds($patientId)
    {
        $patients = $this->patient->getPatients(array(
            'patientid' => $patientId
        ));

        $contactIdList = null;

        if (count($patients)) {
            $patient = $patients[0];

            if (!empty($patient->referred_source) && $patient->referred_source == 1) {
                $join = array('referred_by', 'patientid');

                $contacts = $this->patient->getJoinPatients(array(
                    'patientid' => $patientId
                ), $join);
            } elseif (!empty($patient->referred_source) && $patient->referred_source == 2) {
                $contacts = $this->contact->getPatientContacts($patientId);
            }

            $contactIds = array();

            if (!empty($contacts)) foreach ($contacts as $contact) {
                $contactIds[] = array_shift($contact->toArray());
            }

            $contactIdList = implode(',', $contactIds);
        }

        return $contactIdList;
    }
}
