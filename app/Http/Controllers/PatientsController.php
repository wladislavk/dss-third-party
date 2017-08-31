<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Repositories\Dental\HomeSleepTestRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\InsurancePreauthRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\LetterRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\NotificationRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\PatientSummaryRepository;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ProfileImageRepository;
use DentalSleepSolutions\Exceptions\GeneralException;
use DentalSleepSolutions\Exceptions\IncorrectEmailException;
use DentalSleepSolutions\Factories\PatientEditorFactory;
use DentalSleepSolutions\Helpers\AccessCodeResetter;
use DentalSleepSolutions\Helpers\EmailChecker;
use DentalSleepSolutions\Helpers\FullNameComposer;
use DentalSleepSolutions\Helpers\NameSetter;
use DentalSleepSolutions\Helpers\PatientFinder;
use DentalSleepSolutions\Helpers\PatientLocationRetriever;
use DentalSleepSolutions\Helpers\PatientRuleRetriever;
use DentalSleepSolutions\Helpers\TempPinDocumentCreator;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Structs\EditPatientIntendedActions;
use DentalSleepSolutions\Structs\EditPatientRequestData;
use DentalSleepSolutions\Structs\PatientFinderData;
use DentalSleepSolutions\Structs\RequestedEmails;
use DentalSleepSolutions\Temporary\PatientFormDataUpdater;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PatientsController extends BaseRestController
{
    const UNREGISTERED_STATUS = 0;
    const REGISTRATION_EMAILED_STATUS = 1;
    const REGISTERED_STATUS = 2;

    const DSS_REFERRED_PATIENT = 1;
    const DSS_REFERRED_PHYSICIAN = 2;
    const DSS_REFERRED_MEDIA = 3;
    const DSS_REFERRED_FRANCHISE = 4;
    const DSS_REFERRED_DSSOFFICE = 5;
    const DSS_REFERRED_OTHER = 6;

    /** @var PatientRepository */
    protected $repository;

    /**
     * @SWG\Get(
     *     path="/patients",
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
     *                         @SWG\Items(ref="#/definitions/Patient")
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
     *     path="/patients/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource retrieved",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Patient")
     *                 )
     *             }
     *         )
     *     ),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        return parent::show($id);
    }

    /**
     * @SWG\Post(
     *     path="/patients",
     *     @SWG\Parameter(name="lastname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="firstname", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="middlename", in="formData", type="string"),
     *     @SWG\Parameter(name="salutation", in="formData", type="string"),
     *     @SWG\Parameter(name="member_no", in="formData", type="string"),
     *     @SWG\Parameter(name="group_no", in="formData", type="string"),
     *     @SWG\Parameter(name="plan_no", in="formData", type="string"),
     *     @SWG\Parameter(name="dob", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="add1", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="add2", in="formData", type="string"),
     *     @SWG\Parameter(name="city", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="state", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="zip", in="formData", type="string", required=true, pattern="[0-9]{5}"),
     *     @SWG\Parameter(name="gender", in="formData", type="string", required=true, pattern="^(?:Male|Female)$"),
     *     @SWG\Parameter(name="marital_status", in="formData", type="string", pattern="^(?:Married|Un-Married|Single)$"),
     *     @SWG\Parameter(name="ssn", in="formData", type="string", required=true),
     *     @SWG\Parameter(name="internal_patient", in="formData", type="string"),
     *     @SWG\Parameter(name="home_phone", in="formData", type="string", required=true, pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="work_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="cell_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email", required=true),
     *     @SWG\Parameter(name="patient_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="alert_text", in="formData", type="string"),
     *     @SWG\Parameter(name="display_alert", in="formData", type="integer"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="p_d_party", in="formData", type="string"),
     *     @SWG\Parameter(name="p_d_relation", in="formData", type="string"),
     *     @SWG\Parameter(name="p_d_other", in="formData", type="string"),
     *     @SWG\Parameter(name="p_d_employer", in="formData", type="string"),
     *     @SWG\Parameter(name="p_d_ins_co", in="formData", type="string"),
     *     @SWG\Parameter(name="p_d_ins_id", in="formData", type="string"),
     *     @SWG\Parameter(name="s_d_party", in="formData", type="string"),
     *     @SWG\Parameter(name="s_d_relation", in="formData", type="string"),
     *     @SWG\Parameter(name="s_d_other", in="formData", type="string"),
     *     @SWG\Parameter(name="s_d_employer", in="formData", type="string"),
     *     @SWG\Parameter(name="s_d_ins_co", in="formData", type="string"),
     *     @SWG\Parameter(name="s_d_ins_id", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_partyfname", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_partymname", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_partylname", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_relation", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_other", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_employer", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_ins_co", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_ins_id", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_partyfname", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_partymname", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_partylname", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_relation", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_other", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_employer", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_ins_co", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_ins_id", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_ins_grp", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_ins_grp", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_ins_plan", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_ins_plan", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_dss_file", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_dss_file", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_ins_type", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_ins_type", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_ins_ass", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_ins_ass", in="formData", type="string"),
     *     @SWG\Parameter(name="ins_dob", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ins2_dob", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="employer", in="formData", type="string"),
     *     @SWG\Parameter(name="emp_add1", in="formData", type="string"),
     *     @SWG\Parameter(name="emp_add2", in="formData", type="string"),
     *     @SWG\Parameter(name="emp_city", in="formData", type="string"),
     *     @SWG\Parameter(name="emp_state", in="formData", type="string"),
     *     @SWG\Parameter(name="emp_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="emp_phone", in="formData", type="string"),
     *     @SWG\Parameter(name="emp_fax", in="formData", type="string"),
     *     @SWG\Parameter(name="plan_name", in="formData", type="string"),
     *     @SWG\Parameter(name="group_number", in="formData", type="string"),
     *     @SWG\Parameter(name="ins_type", in="formData", type="string"),
     *     @SWG\Parameter(name="accept_assignment", in="formData", type="string"),
     *     @SWG\Parameter(name="print_signature", in="formData", type="string"),
     *     @SWG\Parameter(name="medical_insurance", in="formData", type="string"),
     *     @SWG\Parameter(name="mark_yes", in="formData", type="string"),
     *     @SWG\Parameter(name="inactive", in="formData", type="string"),
     *     @SWG\Parameter(name="partner_name", in="formData", type="string"),
     *     @SWG\Parameter(name="emergency_name", in="formData", type="string"),
     *     @SWG\Parameter(name="emergency_number", in="formData", type="string"),
     *     @SWG\Parameter(name="referred_source", in="formData", type="integer"),
     *     @SWG\Parameter(name="referred_by", in="formData", type="integer"),
     *     @SWG\Parameter(name="premedcheck", in="formData", type="integer"),
     *     @SWG\Parameter(name="premed", in="formData", type="string"),
     *     @SWG\Parameter(name="docsleep", in="formData", type="string"),
     *     @SWG\Parameter(name="docpcp", in="formData", type="string"),
     *     @SWG\Parameter(name="docdentist", in="formData", type="string"),
     *     @SWG\Parameter(name="docent", in="formData", type="string"),
     *     @SWG\Parameter(name="docmdother", in="formData", type="string"),
     *     @SWG\Parameter(name="preferredcontact", in="formData", type="string", pattern="^(?:email|paper)$"),
     *     @SWG\Parameter(name="copyreqdate", in="formData", type="string"),
     *     @SWG\Parameter(name="best_time", in="formData", type="string", pattern="^(?:morning|midday|evening)$"),
     *     @SWG\Parameter(name="best_number", in="formData", type="string", pattern="^(?:home|work)$"),
     *     @SWG\Parameter(name="emergency_relationship", in="formData", type="string"),
     *     @SWG\Parameter(name="has_s_m_ins", in="formData", type="string", pattern="^(?:No|Yes)$"),
     *     @SWG\Parameter(name="referred_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="login", in="formData", type="string"),
     *     @SWG\Parameter(name="password", in="formData", type="string"),
     *     @SWG\Parameter(name="salt", in="formData", type="string"),
     *     @SWG\Parameter(name="recover_hash", in="formData", type="string"),
     *     @SWG\Parameter(name="recover_time", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="registered", in="formData", type="integer"),
     *     @SWG\Parameter(name="access_code", in="formData", type="string"),
     *     @SWG\Parameter(name="parent_patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="has_p_m_ins", in="formData", type="string"),
     *     @SWG\Parameter(name="registration_status", in="formData", type="integer"),
     *     @SWG\Parameter(name="text_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="text_num", in="formData", type="integer"),
     *     @SWG\Parameter(name="use_patient_portal", in="formData", type="integer"),
     *     @SWG\Parameter(name="registration_senton", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="preferred_name", in="formData", type="string"),
     *     @SWG\Parameter(name="feet", in="formData", type="string"),
     *     @SWG\Parameter(name="inches", in="formData", type="string"),
     *     @SWG\Parameter(name="weight", in="formData", type="string"),
     *     @SWG\Parameter(name="bmi", in="formData", type="string"),
     *     @SWG\Parameter(name="symptoms_status", in="formData", type="integer"),
     *     @SWG\Parameter(name="sleep_status", in="formData", type="integer"),
     *     @SWG\Parameter(name="treatments_status", in="formData", type="integer"),
     *     @SWG\Parameter(name="history_status", in="formData", type="integer"),
     *     @SWG\Parameter(name="access_code_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="email_bounce", in="formData", type="integer"),
     *     @SWG\Parameter(name="docmdother2", in="formData", type="string"),
     *     @SWG\Parameter(name="docmdother3", in="formData", type="string"),
     *     @SWG\Parameter(name="last_reg_sect", in="formData", type="integer"),
     *     @SWG\Parameter(name="access_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="p_m_eligible_id", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_eligible_payer_id", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_eligible_payer_name", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_gender", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_gender", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_same_address", in="formData", type="integer"),
     *     @SWG\Parameter(name="p_m_address", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_state", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_city", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="s_m_same_address", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_address", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_city", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_state", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="new_fee_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="new_fee_amount", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="new_fee_desc", in="formData", type="string"),
     *     @SWG\Parameter(name="new_fee_invoice_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="s_m_eligible_payer_id", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_eligible_payer_name", in="formData", type="string"),
     *     @SWG\Response(
     *         response="200",
     *         description="Resource created",
     *         @SWG\Schema(
     *             allOf={
     *                 @SWG\Schema(ref="#/definitions/common_response_fields"),
     *                 @SWG\Schema(
     *                     @SWG\Property(property="data", ref="#/definitions/Patient")
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
        return parent::store();
    }

    /**
     * @SWG\Put(
     *     path="/patients/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Parameter(name="lastname", in="formData", type="string"),
     *     @SWG\Parameter(name="firstname", in="formData", type="string"),
     *     @SWG\Parameter(name="middlename", in="formData", type="string"),
     *     @SWG\Parameter(name="salutation", in="formData", type="string"),
     *     @SWG\Parameter(name="member_no", in="formData", type="string"),
     *     @SWG\Parameter(name="group_no", in="formData", type="string"),
     *     @SWG\Parameter(name="plan_no", in="formData", type="string"),
     *     @SWG\Parameter(name="dob", in="formData", type="string"),
     *     @SWG\Parameter(name="add1", in="formData", type="string"),
     *     @SWG\Parameter(name="add2", in="formData", type="string"),
     *     @SWG\Parameter(name="city", in="formData", type="string"),
     *     @SWG\Parameter(name="state", in="formData", type="string"),
     *     @SWG\Parameter(name="zip", in="formData", type="string", pattern="[0-9]{5}"),
     *     @SWG\Parameter(name="gender", in="formData", type="string", pattern="^(?:Male|Female)$"),
     *     @SWG\Parameter(name="marital_status", in="formData", type="string", pattern="^(?:Married|Un-Married|Single)$"),
     *     @SWG\Parameter(name="ssn", in="formData", type="string"),
     *     @SWG\Parameter(name="internal_patient", in="formData", type="string"),
     *     @SWG\Parameter(name="home_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="work_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="cell_phone", in="formData", type="string", pattern="^[0-9]{10}$"),
     *     @SWG\Parameter(name="email", in="formData", type="string", format="email"),
     *     @SWG\Parameter(name="patient_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="alert_text", in="formData", type="string"),
     *     @SWG\Parameter(name="display_alert", in="formData", type="integer"),
     *     @SWG\Parameter(name="userid", in="formData", type="integer"),
     *     @SWG\Parameter(name="docid", in="formData", type="integer"),
     *     @SWG\Parameter(name="status", in="formData", type="integer"),
     *     @SWG\Parameter(name="p_d_party", in="formData", type="string"),
     *     @SWG\Parameter(name="p_d_relation", in="formData", type="string"),
     *     @SWG\Parameter(name="p_d_other", in="formData", type="string"),
     *     @SWG\Parameter(name="p_d_employer", in="formData", type="string"),
     *     @SWG\Parameter(name="p_d_ins_co", in="formData", type="string"),
     *     @SWG\Parameter(name="p_d_ins_id", in="formData", type="string"),
     *     @SWG\Parameter(name="s_d_party", in="formData", type="string"),
     *     @SWG\Parameter(name="s_d_relation", in="formData", type="string"),
     *     @SWG\Parameter(name="s_d_other", in="formData", type="string"),
     *     @SWG\Parameter(name="s_d_employer", in="formData", type="string"),
     *     @SWG\Parameter(name="s_d_ins_co", in="formData", type="string"),
     *     @SWG\Parameter(name="s_d_ins_id", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_partyfname", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_partymname", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_partylname", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_relation", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_other", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_employer", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_ins_co", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_ins_id", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_partyfname", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_partymname", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_partylname", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_relation", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_other", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_employer", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_ins_co", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_ins_id", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_ins_grp", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_ins_grp", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_ins_plan", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_ins_plan", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_dss_file", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_dss_file", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_ins_type", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_ins_type", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_ins_ass", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_ins_ass", in="formData", type="string"),
     *     @SWG\Parameter(name="ins_dob", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="ins2_dob", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="employer", in="formData", type="string"),
     *     @SWG\Parameter(name="emp_add1", in="formData", type="string"),
     *     @SWG\Parameter(name="emp_add2", in="formData", type="string"),
     *     @SWG\Parameter(name="emp_city", in="formData", type="string"),
     *     @SWG\Parameter(name="emp_state", in="formData", type="string"),
     *     @SWG\Parameter(name="emp_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="emp_phone", in="formData", type="string"),
     *     @SWG\Parameter(name="emp_fax", in="formData", type="string"),
     *     @SWG\Parameter(name="plan_name", in="formData", type="string"),
     *     @SWG\Parameter(name="group_number", in="formData", type="string"),
     *     @SWG\Parameter(name="ins_type", in="formData", type="string"),
     *     @SWG\Parameter(name="accept_assignment", in="formData", type="string"),
     *     @SWG\Parameter(name="print_signature", in="formData", type="string"),
     *     @SWG\Parameter(name="medical_insurance", in="formData", type="string"),
     *     @SWG\Parameter(name="mark_yes", in="formData", type="string"),
     *     @SWG\Parameter(name="inactive", in="formData", type="string"),
     *     @SWG\Parameter(name="partner_name", in="formData", type="string"),
     *     @SWG\Parameter(name="emergency_name", in="formData", type="string"),
     *     @SWG\Parameter(name="emergency_number", in="formData", type="string"),
     *     @SWG\Parameter(name="referred_source", in="formData", type="integer"),
     *     @SWG\Parameter(name="referred_by", in="formData", type="integer"),
     *     @SWG\Parameter(name="premedcheck", in="formData", type="integer"),
     *     @SWG\Parameter(name="premed", in="formData", type="string"),
     *     @SWG\Parameter(name="docsleep", in="formData", type="string"),
     *     @SWG\Parameter(name="docpcp", in="formData", type="string"),
     *     @SWG\Parameter(name="docdentist", in="formData", type="string"),
     *     @SWG\Parameter(name="docent", in="formData", type="string"),
     *     @SWG\Parameter(name="docmdother", in="formData", type="string"),
     *     @SWG\Parameter(name="preferredcontact", in="formData", type="string", pattern="^(?:email|paper)$"),
     *     @SWG\Parameter(name="copyreqdate", in="formData", type="string"),
     *     @SWG\Parameter(name="best_time", in="formData", type="string", pattern="^(?:morning|midday|evening)$"),
     *     @SWG\Parameter(name="best_number", in="formData", type="string", pattern="^(?:home|work)$"),
     *     @SWG\Parameter(name="emergency_relationship", in="formData", type="string"),
     *     @SWG\Parameter(name="has_s_m_ins", in="formData", type="string", pattern="^(?:No|Yes)$"),
     *     @SWG\Parameter(name="referred_notes", in="formData", type="string"),
     *     @SWG\Parameter(name="login", in="formData", type="string"),
     *     @SWG\Parameter(name="password", in="formData", type="string"),
     *     @SWG\Parameter(name="salt", in="formData", type="string"),
     *     @SWG\Parameter(name="recover_hash", in="formData", type="string"),
     *     @SWG\Parameter(name="recover_time", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="registered", in="formData", type="integer"),
     *     @SWG\Parameter(name="access_code", in="formData", type="string"),
     *     @SWG\Parameter(name="parent_patientid", in="formData", type="integer"),
     *     @SWG\Parameter(name="has_p_m_ins", in="formData", type="string"),
     *     @SWG\Parameter(name="registration_status", in="formData", type="integer"),
     *     @SWG\Parameter(name="text_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="text_num", in="formData", type="integer"),
     *     @SWG\Parameter(name="use_patient_portal", in="formData", type="integer"),
     *     @SWG\Parameter(name="registration_senton", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="preferred_name", in="formData", type="string"),
     *     @SWG\Parameter(name="feet", in="formData", type="string"),
     *     @SWG\Parameter(name="inches", in="formData", type="string"),
     *     @SWG\Parameter(name="weight", in="formData", type="string"),
     *     @SWG\Parameter(name="bmi", in="formData", type="string"),
     *     @SWG\Parameter(name="symptoms_status", in="formData", type="integer"),
     *     @SWG\Parameter(name="sleep_status", in="formData", type="integer"),
     *     @SWG\Parameter(name="treatments_status", in="formData", type="integer"),
     *     @SWG\Parameter(name="history_status", in="formData", type="integer"),
     *     @SWG\Parameter(name="access_code_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="email_bounce", in="formData", type="integer"),
     *     @SWG\Parameter(name="docmdother2", in="formData", type="string"),
     *     @SWG\Parameter(name="docmdother3", in="formData", type="string"),
     *     @SWG\Parameter(name="last_reg_sect", in="formData", type="integer"),
     *     @SWG\Parameter(name="access_type", in="formData", type="integer"),
     *     @SWG\Parameter(name="p_m_eligible_id", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_eligible_payer_id", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_eligible_payer_name", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_gender", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_gender", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_same_address", in="formData", type="integer"),
     *     @SWG\Parameter(name="p_m_address", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_state", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_city", in="formData", type="string"),
     *     @SWG\Parameter(name="p_m_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="s_m_same_address", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_address", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_city", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_state", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_zip", in="formData", type="string", pattern="^[0-9]{5}$"),
     *     @SWG\Parameter(name="new_fee_date", in="formData", type="string", format="dateTime"),
     *     @SWG\Parameter(name="new_fee_amount", in="formData", type="string", pattern="^[0-9]+\.[0-9]{2}$"),
     *     @SWG\Parameter(name="new_fee_desc", in="formData", type="string"),
     *     @SWG\Parameter(name="new_fee_invoice_id", in="formData", type="integer"),
     *     @SWG\Parameter(name="s_m_eligible_payer_id", in="formData", type="string"),
     *     @SWG\Parameter(name="s_m_eligible_payer_name", in="formData", type="string"),
     *     @SWG\Response(response="200", description="Resource updated", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="422", ref="#/responses/422_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function update($id)
    {
        return parent::update($id);
    }

    /**
     * @SWG\Delete(
     *     path="/patients/{id}",
     *     @SWG\Parameter(ref="#/parameters/id_in_path"),
     *     @SWG\Response(response="200", description="Resource deleted", ref="#/responses/empty_ok_response"),
     *     @SWG\Response(response="404", ref="#/responses/404_response"),
     *     @SWG\Response(response="default", ref="#/responses/error_response")
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        return parent::destroy($id);
    }

    /**
     * @SWG\Post(
     *     path="/patients/with-filter",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * Get patients by filter.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithFilter(Request $request)
    {
        $fields = $request->input('fields', []);
        $where  = $request->input('where', []);

        $patients = $this->repository->getWithFilter($fields, $where);

        return ApiResponse::responseOk('', $patients);
    }

    /**
     * @SWG\Post(
     *     path="/patients/number",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNumber()
    {
        $data = $this->repository->getNumber($this->user->docid);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/patients/duplicates",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDuplicates()
    {
        $data = $this->repository->getDuplicates($this->user->docid);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/patients/bounces",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBounces()
    {
        $data = $this->repository->getBounces($this->user->docid);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/patients/list",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getListPatients(Request $request)
    {
        $partialName = $request->input('partial_name', '');
        $regExp = '/[^ A-Za-z\'\-]/';
        $partialName = preg_replace($regExp, '', $partialName);

        $names = explode(' ', $partialName);
        $data = $this->repository->getListPatients($this->user->docid, $names);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Delete(
     *     path="/patients-by-doctor/{patientId}",
     *     @SWG\Parameter(name="patientId", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $patientId
     * @return JsonResponse
     */
    public function destroyForDoctor($patientId)
    {
        $this->repository->deleteForDoctor($patientId, $this->user->docid);

        return ApiResponse::responseOk('Resource deleted');
    }

    /**
     * @SWG\Post(
     *     path="/patients/find",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @param PatientFinder $patientFinder
     * @return JsonResponse
     */
    public function find(Request $request, PatientFinder $patientFinder)
    {
        $patientFinderData = new PatientFinderData();
        $patientFinderData->docId = $this->user->docid;
        $patientFinderData->userType = $this->user->user_type;
        $patientFinderData->patientId = $request->input('patientId', 0);
        $patientFinderData->type = $request->input('type', 1);
        $patientFinderData->pageNumber = $request->input('page', 0);
        $patientFinderData->patientsPerPage = $request->input('patientsPerPage', 30);
        $patientFinderData->letter = $request->input('letter', '');
        $patientFinderData->sortColumn = $request->input('sortColumn', 'name');
        $patientFinderData->sortDir = $request->input('sortDir', '');

        $data = $patientFinder->findPatientBy($patientFinderData);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/patients/referred-by-contact",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getReferredByContact(Request $request)
    {
        $contactId = $request->input('contact_id', 0);
        $data = $this->repository->getReferredByContact($contactId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/patients/by-contact",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getByContact(Request $request)
    {
        $contactId = $request->input('contact_id', 0);
        $data = $this->repository->getByContact($contactId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/patients/edit/{patientId}",
     *     @SWG\Parameter(name="patientId", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @SWG\Post(
     *     path="/patients/edit",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param PatientEditorFactory $patientEditorFactory
     * @param PatientRuleRetriever $patientRuleRetriever
     * @param PatientFormDataUpdater $patientFormDataUpdater
     * @param PatientSummaryRepository $patientSummaryRepository
     * @param Request $request
     * @param int $patientId
     * @return JsonResponse
     */
    public function editingPatient(
        PatientEditorFactory $patientEditorFactory,
        PatientRuleRetriever $patientRuleRetriever,
        PatientFormDataUpdater $patientFormDataUpdater,
        PatientSummaryRepository $patientSummaryRepository,
        Request $request,
        $patientId = 0
    ) {
        // TODO: this block should be decoupled into a different controller action
        if ($request->has('tracker_notes')) {
            $trackerNotes = $request->input('tracker_notes');
            $this->validate($request, (new \DentalSleepSolutions\Http\Requests\PatientSummary())->updateRules());
            $patientSummaryRepository->updateTrackerNotes($patientId, $this->user->docid, $trackerNotes);
            return ApiResponse::responseOk('', ['tracker_notes' => 'Tracker notes were successfully updated.']);
        }

        if (!$request->has('patient_form_data')) {
            return ApiResponse::responseError('Patient data is empty.', 422);
        }
        $patientFormData = $request->input('patient_form_data', []);
        $patientFormDataUpdater->setPatientFormData($patientFormData);

        $requestData = new EditPatientRequestData();
        $requestData->requestedEmails = new RequestedEmails($request->input('requested_emails', []));
        $requestData->intendedActions = new EditPatientIntendedActions($request->input('pressed_buttons', []));
        $requestData->patientLocation = $patientFormDataUpdater->getPatientLocation();

        $patientEditor = $patientEditorFactory->getPatientEditor($patientId);
        $rules = $patientRuleRetriever->getValidationRules($patientId);
        $validator = $this->getValidationFactory()->make($patientFormData, $rules);
        if ($validator->fails()) {
            return ApiResponse::responseError('', 422, $validator->getMessageBag()->all());
        }

        try {
            /** @var Patient|null $unchangedPatient */
            $unchangedPatient = $this->repository->findByIdOrNull($patientId);
        } catch (GeneralException $e) {
            return ApiResponse::responseError($e->getMessage(), 422);
        }
        if ($unchangedPatient) {
            $patientFormDataUpdater->setEmailBounce($unchangedPatient);
            $patientFormDataUpdater->modifyLogin($unchangedPatient->login);
        }
        $requestData->hasPatientPortal = $patientFormDataUpdater->getHasPatientPortal($this->user->docid);
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
            $updatedFormData, $this->user, $requestData, $unchangedPatient
        );

        return ApiResponse::responseOk('', $responseData->toArray());
    }

    /**
     * @SWG\Post(
     *     path="/patients/filling-form",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param FullNameComposer $fullNameComposer
     * @param PatientLocationRetriever $patientLocationRetriever
     * @param InsurancePreauthRepository $insurancePreauthRepository
     * @param ProfileImageRepository $profileImageRepository
     * @param LetterRepository $letterRepository
     * @param HomeSleepTestRepository $homeSleepTestRepository
     * @param NotificationRepository $notificationRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function getDataForFillingPatientForm(
        FullNameComposer $fullNameComposer,
        PatientLocationRetriever $patientLocationRetriever,
        InsurancePreauthRepository $insurancePreauthRepository,
        ProfileImageRepository $profileImageRepository,
        LetterRepository $letterRepository,
        HomeSleepTestRepository $homeSleepTestRepository,
        NotificationRepository $notificationRepository,
        Request $request
    ) {
        $patientId = $request->input('patient_id', 0);
        /** @var Patient|null $foundPatient */
        $foundPatient = $this->repository->findOrNull($patientId);

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
            'pending_vob' => $insurancePreauthRepository->getPendingVob($patientId),
            'profile_photo' => $profileImageRepository->getProfilePhoto($patientId),
            'intro_letter' => $letterRepository->getGeneratedDateOfIntroLetter($patientId),
            'insurance_card_image' => $profileImageRepository->getInsuranceCardImage($patientId),
            'uncompleted_home_sleep_test' => $homeSleepTestRepository->getUncompleted($patientId),
            'patient_notification' => $notificationRepository->getWithFilter(null, $patientNotificationData),
            'patient' => ApiResponse::transform($foundPatient),
            'formed_full_names' => $formedFullNames,
            'patient_location' => $patientLocation,
        ];

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/patients/referrers",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param NameSetter $nameSetter
     * @param Request $request
     * @return JsonResponse
     */
    public function getReferrers(NameSetter $nameSetter, Request $request)
    {
        $partial = '';
        if ($request->has('partial_name')) {
            $regExp = '/[^ A-Za-z\'\-]/';
            $partial = preg_replace($regExp, '', $request->input('partial_name'));
        }

        $names = explode(' ', $partial);

        $contacts = $this->repository->getReferrers($this->user->docid, $names);

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

    /**
     * @SWG\Post(
     *     path="/patients/check-email",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @param EmailChecker $emailChecker
     * @return JsonResponse
     */
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
     * @SWG\Post(
     *     path="/patients/reset-access-code/{patientId}",
     *     @SWG\Parameter(name="patientId", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
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
     * @SWG\Post(
     *     path="/patients/temp-pin-document/{patientId}",
     *     @SWG\Parameter(name="patientId", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param TempPinDocumentCreator $tempPinDocumentCreator
     * @param int $patientId
     * @return JsonResponse
     */
    public function createTempPinDocument(
        TempPinDocumentCreator $tempPinDocumentCreator,
        $patientId
    ) {
        $url = '';
        if ($patientId) {
            $url = $tempPinDocumentCreator->createDocument($patientId, $this->user->docid);
        }

        return ApiResponse::responseOk('', ['path_to_pdf' => $url]);
    }
}
