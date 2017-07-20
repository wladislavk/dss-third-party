<?php

namespace DentalSleepSolutions\Http\Controllers;

use DentalSleepSolutions\Eloquent\Models\Dental\Contact;
use DentalSleepSolutions\Eloquent\Models\Dental\HomeSleepTest;
use DentalSleepSolutions\Eloquent\Models\Dental\InsurancePreauth;
use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Eloquent\Models\Dental\Notification;
use DentalSleepSolutions\Eloquent\Models\Dental\Patient;
use DentalSleepSolutions\Eloquent\Models\Dental\PatientSummary;
use DentalSleepSolutions\Eloquent\Models\Dental\ProfileImage;
use DentalSleepSolutions\Eloquent\Models\Dental\Summary;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Repositories\Dental\ContactRepository;
use DentalSleepSolutions\Helpers\LetterTriggers\LettersToMDTrigger;
use DentalSleepSolutions\Helpers\LetterTriggers\LetterToPatientTrigger;
use DentalSleepSolutions\Helpers\LetterTriggers\TreatmentCompleteTrigger;
use DentalSleepSolutions\StaticClasses\ApiResponse;
use DentalSleepSolutions\Helpers\EmailHandlers\RegistrationEmailHandler;
use DentalSleepSolutions\Helpers\EmailHandlers\RememberEmailHandler;
use DentalSleepSolutions\Helpers\EmailHandlers\UpdateEmailHandler;
use DentalSleepSolutions\Helpers\LetterDeleter;
use DentalSleepSolutions\Helpers\MailerDataRetriever;
use DentalSleepSolutions\Helpers\PreauthHelper;
use DentalSleepSolutions\Helpers\SimilarHelper;
use DentalSleepSolutions\Helpers\PdfHelper;
use DentalSleepSolutions\Libraries\Password;
use DentalSleepSolutions\Structs\PdfHeaderData;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
     * @param Patient $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function getWithFilter(Patient $resources, Request $request)
    {
        $fields = $request->input('fields') ?: [];
        $where  = $request->input('where') ?: [];

        $patients = $resources->getWithFilter($fields, $where);

        return ApiResponse::responseOk('', $patients);
    }

    /**
     * @SWG\Post(
     *     path="/patients/number",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Patient $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function getNumber(Patient $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getNumber($docId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/patients/duplicates",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Patient $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDuplicates(Patient $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getDuplicates($docId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/patients/bounces",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Patient $resources
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBounces(Patient $resources)
    {
        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getBounces($docId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/patients/list",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Patient $resources
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getListPatients(Patient $resources, Request $request)
    {
        $partialName = $request->input('partial_name') ?: '';
        $partialName = preg_replace("[^ A-Za-z'\-]", '', $partialName);

        $names = explode(' ', $partialName);

        $docId = $this->currentUser->docid ?: 0;

        $data = $resources->getListPatients($docId, $names);

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
     * @param Patient $resource
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyForDoctor($patientId, Patient $resource)
    {
        $docId = $this->currentUser->docid ?: 0;

        $resource->deleteForDoctor($patientId, $docId);

        return ApiResponse::responseOk('Resource deleted');
    }

    /**
     * @SWG\Post(
     *     path="/patients/find",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Patient $resources
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function find(Patient $resources, Request $request)
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

    /**
     * @SWG\Post(
     *     path="/patients/referred-by-contact",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Patient $resources
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReferredByContact(Patient $resources, Request $request)
    {
        $contactId = $request->input('contact_id') ?: 0;
        $data = $resources->getReferredByContact($contactId);

        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/patients/by-contact",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Patient $resources
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getByContact(Patient $resources, Request $request)
    {
        $contactId = $request->input('contact_id') ?: 0;
        $data = $resources->getByContact($contactId);

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
     * @param TreatmentCompleteTrigger $treatmentCompleteTrigger
     * @param LettersToMDTrigger $lettersToMDTrigger
     * @param LetterToPatientTrigger $letterToPatientTrigger
     * @param LetterDeleter $letterDeleter
     * @param UpdateEmailHandler $updateEmailHandler
     * @param RememberEmailHandler $rememberEmailHandler
     * @param RegistrationEmailHandler $registrationEmailHandler
     * @param PreauthHelper $preauthHelper
     * @param SimilarHelper $similarHelper
     * @param Patient $patientResource
     * @param PatientSummary $patientSummaryResource
     * @param InsurancePreauth $insurancePreauthResource
     * @param Summaries $summariesResource
     * @param Letter $letterResource
     * @param User $userResource
     * @param Request $request
     * @param int|null $patientId
     * @return \Illuminate\Http\JsonResponse
     */
    public function editingPatient(
        TreatmentCompleteTrigger $treatmentCompleteTrigger,
        LettersToMDTrigger $lettersToMDTrigger,
        LetterToPatientTrigger $letterToPatientTrigger,
        LetterDeleter $letterDeleter,
        UpdateEmailHandler $updateEmailHandler,
        RememberEmailHandler $rememberEmailHandler,
        RegistrationEmailHandler $registrationEmailHandler,
        PreauthHelper $preauthHelper,
        SimilarHelper $similarHelper,
        Patient $patientResource,
        PatientSummary $patientSummaryResource,
        InsurancePreauth $insurancePreauthResource,
        Summary $summariesResource,
        Letter $letterResource,
        User $userResource,
        Request $request,
        $patientId = null
    ) {
        $docId = $this->currentUser->docid ?: 0;
        $userType = $this->currentUser->user_type ?: 0;
        $userId = $this->currentUser->id ?: 0;

        // check if the request has emails for sending
        $emailTypesForSending = $request->has('requested_emails') ? $request->input('requested_emails') : false;

        // check if some buttons were pressed on the page
        $pressedButtons = $request->has('pressed_buttons') ? $request->input('pressed_buttons') : false;

        // get doc info by id
        $docInfo = $userResource->getWithFilter('use_patient_portal', ['userid' => $docId]);

        if (count($docInfo)) {
            $docPatientPortal = $docInfo[0]->use_patient_portal;
        } else {
            $docPatientPortal = false;
        }

        // get form data for a current patient
        $patientFormData = $request->input('patient_form_data') ?: [];
        $usePatientPortal = !empty($patientFormData['use_patient_portal']) ? $patientFormData['use_patient_portal'] : 0;
        $patientLocation = !empty($patientFormData['location']) ? $patientFormData['location'] : 0;
        unset($patientFormData['location']);

        // validate input patient form data
        if ($patientId) {
            $validator = $this->getValidationFactory()->make($patientFormData, (new \DentalSleepSolutions\Http\Requests\Patient())->updateRules());
        } else {
            $validator = $this->getValidationFactory()->make($patientFormData, (new \DentalSleepSolutions\Http\Requests\Patient())->storeRules());
        }

        if ($validator->fails()) {
            return ApiResponse::responseError('', 422, $validator->messages());
        } elseif (count($patientFormData) == 0) {
            return ApiResponse::responseError('Patient data is empty.', 422);
        }

        // check if the request contains tracker notes
        if ($request->has('tracker_notes')) {
            $this->validate($request->input('tracker_notes'), (new \DentalSleepSolutions\Http\Requests\PatientSummary())->updateRules());

            $patientSummaryResource->updateTrackerNotes($patientId, $docId, $request->input('tracker_notes'));

            return ApiResponse::responseOk('', ['tracker_notes' => 'Tracker notes were successfully updated.']);
        }

        $treatmentCompleteTrigger->trigger($patientId, $docId, $userId);

        // need to add logic for logging actions
        // linkRequestData

        // generation an unique patient login
        $uniqueLogin = strtolower(substr($patientFormData["firstname"], 0, 1) . $patientFormData["lastname"]);

        $similarPatientLogin = $patientResource->getSimilarPatientLogin($uniqueLogin);

        if ($similarPatientLogin) {
            $number = str_replace($uniqueLogin, '', $similarPatientLogin->login);
            $number = $number + 1;
            $uniqueLogin = $uniqueLogin . $number;
        }

        $responseData = [];
        $isUpdateAction = true;

        if ($patientId) {
            // find an unchanged patient by id
            $unchangedPatient = $patientResource->find($patientId);

            // TODO: need to rewrite this logic from legacy code to the new Laravel structure
            if (
                $unchangedPatient->registration_status == self::REGISTERED_STATUS
                &&
                $patientFormData['email'] != $unchangedPatient->email
            ) {
                // notify the user about changing his email
                $updateEmailHandler->handleEmail($patientId, $patientFormData['email'], $unchangedPatient->email);

                $responseData['mails'] = [
                    'updated_mail' => 'The mail about changing patient email was successfully sent.'
                ];
            } elseif ($emailTypesForSending && !empty($emailTypesForSending['reminder'])) {
                // send reminder email
                $rememberEmailHandler->handleEmail($patientId, $patientFormData['email']);

                $responseData['mails'] = [
                    'reminder_mail' => 'The reminding mail was successfully sent.'
                ];
            } elseif (
                $emailTypesForSending
                &&
                empty($emailTypesForSending['registration'])
                &&
                $unchangedPatient->registration_status == self::REGISTRATION_EMAILED_STATUS
                &&
                $patientFormData['email'] != $unchangedPatient['email']
            ) {
                if ($docPatientPortal && $usePatientPortal) {
                    // send registration email if email is updated and not registered
                    $registrationEmailHandler->handleEmail($patientId, $patientFormData['email']);
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
                'p_m_relation',
                'p_m_partyfname',
                'p_m_partylname',
                'ins_dob',
                'p_m_ins_type',
                'p_m_ins_ass',
                'p_m_ins_id',
                'p_m_ins_grp',
                'p_m_ins_plan',
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
                $userName = '';
                if ($this->currentUser->name) {
                    $userName = $this->currentUser->name;
                }
                $updatedVob = $insurancePreauthResource->updateVob($patientId, $userName);
                if ($updatedVob) {
                    $insurancePreauth = $preauthHelper->createVerificationOfBenefits($patientId, $userId);
                    if ($insurancePreauth) {
                        $insurancePreauth->save();
                    }
                }
            }

            // update patient summary if location is set
            if (!empty($patientLocation)) {
                $summaries = $summariesResource->getWithFilter(null, ['patientid' => $patientId]);

                if (count($summaries)) {
                    $summariesResource->updateForPatient($patientId, [
                        'location' => $patientLocation
                    ]);
                } else {
                    $summariesResource->create([
                        'location'  => $patientLocation,
                        'patientid' => $patientId
                    ]);
                }
            }

            if ($unchangedPatient->login == '') {
                $patientResource->updatePatient($patientId, ['login' => $uniqueLogin]);
            }

            // TODO: if it is required need to rewrite it to the new Laravel structure:
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
                            $type = 'md_referral';
                            $recipientId = $unchangedPatient->referred_by;
                            $letterDeleter->deleteLetter($letter->letterid, $type, $recipientId, $docId, $userId);
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
                            $type = 'pat_referral';
                            $recipientId = $unchangedPatient->referred_by;
                            $letterDeleter->deleteLetter($letter->letterid, $type, $recipientId, $docId, $userId);
                        }
                    }
                }
            }

            if ($pressedButtons) {
                if ($pressedButtons['send_hst']) {
                    $responseData['redirect_to'] = 'hst_request_co.php?ed=' . $patientId;
                } elseif ($pressedButtons['send_pin_code']) {
                    $responseData['send_pin_code'] = true;
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
                'login'      => $uniqueLogin,
                'password'   => $password,
                'salt'       => $salt,
                'userid'     => $userId,
                'docid'      => $docId,
                'ip_address' => $request->ip(),
                // set filters
                'firstname'  => ucfirst($patientFormData['firstname']),
                'lastname'   => ucfirst($patientFormData['lastname']),
                'middlename' => !empty($patientFormData['middlename']) ? ucfirst($patientFormData['middlename']) : ''
            ]);

            $createdPatientId = $patientResource->create($patientFormData)->patientid;
            $responseData['created_patient_id'] = $createdPatientId;

            if ($patientLocation) {
                $summariesResource->create([
                    'location'  => $patientLocation,
                    'patientid' => $createdPatientId
                ]);
            }

            $similarPatients = $similarHelper->getSimilarPatients($createdPatientId, $docId);

            if (count($similarPatients)) {
                $responseData['redirect_to'] = 'duplicate_patients.php?pid=' . $createdPatientId;
            } else {
                $responseData['status'] = 'Patient "' . $patientFormData['firstname'] . ' ' . $patientFormData['lastname'] . '" was added successfully.';
            }

            $patientId = $createdPatientId;
        }

        $docFields = [
            'docsleep',
            'docpcp',
            'docdentist',
            'docent',
            'docmdother',
            'docmdother2',
            'docmdother3',
        ];

        $mdContacts = [];
        foreach ($docFields as $field) {
            $mdContacts[] = !empty($patientFormData[$field]) ? $patientFormData[$field] : 0;
        }

        $params = [
            LettersToMDTrigger::MD_CONTACTS_PARAM => $mdContacts,
        ];
        $lettersToMDTrigger->trigger($patientId, $docId, $userId, $userType, $params);

        if (!empty($patientFormData['introletter']) && $patientFormData['introletter'] == 1) {
            $letterToPatientTrigger->trigger($patientId, $docId, $userId);
        }

        if (
            $emailTypesForSending
            &&
            !empty($emailTypesForSending['registration'])
            &&
            $docPatientPortal && $usePatientPortal
        ) {
            $message = 'Unable to send registration email because no cell_phone is set. Please enter a cell_phone and try again.';
            if ($patientFormData['email'] && $patientFormData['cell_phone']) {
                $oldEmail = '';
                if ($isUpdateAction) {
                    $oldEmail = $unchangedPatient->email;
                }
                $registrationEmailHandler->handleEmail($patientId, $patientFormData['email'], $oldEmail);
                $message = 'The registration mail was successfully sent.';
            }

            $responseData['mails'] = [
                'registration_mail' => $message
            ];
        }

        // check if required information is filled out
        $patientPhone = false;
        if (!empty($patientFormData['home_phone']) || !empty($patientFormData['work_phone']) || !empty($patientFormData['cell_phone'])) {
            $patientPhone = true;
        }

        $patientEmail = false;
        if (!empty($patientFormData['email'])) {
            $patientEmail = true;
        }

        $completeInfo = 0;
        if (($patientEmail || $patientPhone)
            && !empty($patientFormData['add1']) && !empty($patientFormData['city'])
            && !empty($patientFormData['state']) && !empty($patientFormData['zip'])
            && !empty($patientFormData['dob']) && !empty($patientFormData['gender'])
        ) {
            $completeInfo = 1;
        }

        // determine whether patient info has been completely set
        $this->updatePatientSummary($patientSummaryResource, $patientId, 'patient_info', $completeInfo);

        return ApiResponse::responseOk('', $responseData);
    }

    /**
     * @SWG\Post(
     *     path="/patients/filling-form",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param InsurancePreauth $insPreauthResource
     * @param Patient $patientResource
     * @param ContactRepository $contactRepository
     * @param Summaries $summariesResource
     * @param ProfileImage $profileImageResource
     * @param Letter $letterResource
     * @param HomeSleepTests $homeSleepTestResource
     * @param Notifications $notificationResource
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDataForFillingPatientForm(
        InsurancePreauth $insPreauthResource,
        Patient $patientResource,
        ContactRepository $contactRepository,
        Summary $summariesResource,
        ProfileImage $profileImageResource,
        Letter $letterResource,
        HomeSleepTest $homeSleepTestResource,
        Notification $notificationResource,
        Request $request
    ) {
        $patientId = 0;
        if ($request->has('patient_id')) {
            $patientId = $request->input('patient_id');
        }
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
                $shortInfo = $contactRepository->getDocShortInfo($foundPatient->$field);
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
                'patient_location'            => !empty($foundLocation) ? $foundLocation->location : ''
            ];
        }
        return ApiResponse::responseOk('', $data);
    }

    /**
     * @SWG\Post(
     *     path="/patients/referrers",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Patient $patientResource
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getReferrers(Patient $patientResource, Request $request)
    {
        $docId = 0;
        if ($this->currentUser->docid) {
            $docId = $this->currentUser->docid;
        }

        $partial = '';
        if ($request->has('partial_name')) {
            $partial = preg_replace("[^ A-Za-z'\-]", "", $request->input('partial_name'));
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

    /**
     * @SWG\Post(
     *     path="/patients/check-email",
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param Request $request
     * @param Patient $patientResource
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkEmail(Request $request, Patient $patientResource)
    {
        $email = $request->input('email', '');
        $patientId = $request->input('patient_id', 0);

        // check patient email address
        if (strlen($email) == 0) {
            return ApiResponse::responseError(
                $message = 'The email address you entered is empty.',
                $code = 417
            );
        } elseif ($this->isPatientEmailValid($patientResource, $email, $patientId)) {
            if ($this->confirmPatientEmail($patientResource, $email, $patientId)) {
                $message = "You have changed the patient's email address. The patient must be notified via email or he/she will not be able to access the Patient Portal. Send email notification and proceed?";
            } else {
                $message = '';
            }

            return ApiResponse::responseOk('', ['confirm_message' => $message]);
        } else {
            return ApiResponse::responseError(
                $message = 'The email address you entered is already associated with another patient. Please enter a different email address.',
                $code = 417
            );
        }
    }

    /**
     * @SWG\Post(
     *     path="/patients/reset-access-code/{patientId}",
     *     @SWG\Parameter(name="patientId", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $patientId
     * @param Patient $patientResource
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetAccessCode($patientId, Patient $patientResource)
    {
        $accessCode = 0;
        $accessCodeDate = null;

        if ($patientId > 0) {
            $accessCode = rand(100000, 999999);
            $accessCodeDate = Carbon::now();
            $patientResource->updatePatient($patientId, [
                'access_code'      => $accessCode,
                'access_code_date' => $accessCodeDate
            ]);
        }

        return ApiResponse::responseOk('', ['access_code' => $accessCode, 'access_code_date' => $accessCodeDate->toDateTimeString()]);
    }

    /**
     * @SWG\Post(
     *     path="/patients/temp-pin-document/{patientId}",
     *     @SWG\Parameter(name="patientId", in="path", type="integer", required=true),
     *     @SWG\Response(response="200", description="TODO: specify the response")
     * )
     *
     * @param int $patientId
     * @param RegistrationEmailHandler $registrationEmailHandler
     * @param PdfHelper $pdfHelper
     * @param MailerDataRetriever $mailerDataRetriever
     * @return \Illuminate\Http\JsonResponse
     */
    public function createTempPinDocument(
        $patientId,
        RegistrationEmailHandler $registrationEmailHandler,
        PdfHelper $pdfHelper,
        MailerDataRetriever $mailerDataRetriever
    ) {
        $url = '';
        if ($patientId > 0) {
            $docId = 0;
            if ($this->currentUser->docid) {
                $docId = $this->currentUser->docid;
            }
            $mailerData = $mailerDataRetriever->retrieveMailerData($patientId, $docId);
            $mailerData = array_merge($mailerData['patientData'], $mailerData['mailingData']);

            if (count($mailerData)) {
                $registrationEmailHandler->setAccessType(2);
                $registrationEmailHandler->handleEmail($patientId, $mailerData['email'], $mailerData['email']);

                $filename = 'user_pin_' . $patientId . '.pdf';
                $headerInfo = new PdfHeaderData();
                $headerInfo->title = 'User Temporary PIN';
                $headerInfo->subject = 'User Temporary PIN';

                $url = $pdfHelper->create('pdf.patient.pinInstructions', $mailerData, $filename, $headerInfo, $docId);
            }
        }

        return ApiResponse::responseOk('', ['path_to_pdf' => $url]);
    }

    private function getDocNameFromShortInfo($field, $shortInfo)
    {
        $name = '';
        if ($field != 'Not Set' && $shortInfo) {
            $name = $shortInfo->lastname . ', ' . $shortInfo->firstname . ' '
                    . $shortInfo->middlename
                    . ($shortInfo->contacttype != '' ? ' - ' . $shortInfo->contacttype : '');
        }
        return $name;
    }

    private function updatePatientSummary(
        PatientSummary $patientSummaryResource,
        $patientId = 0,
        $column = '',
        $value = null
    ) {
        if (empty($patientId) || empty($column)) {
            return false;
        }

        $patientSummary = $patientSummaryResource->find($patientId);

        if (!empty($patientSummary)) {
            $patientSummary->$column = $value;
            $patientSummary->save();
        } else {
            $patientSummaryResource->create([
                'pid'   => $patientId,
                $column => $value
            ]);
        }

        return true;
    }

    private function isPatientEmailValid(Patient $patientResource, $email, $patientId)
    {
        if ($patientResource->getSameEmails($email, $patientId) > 0) {
            return false;
        } else {
            return true;
        }
    }

    private function confirmPatientEmail(Patient $patientResource, $email, $patientId)
    {
        $patient = $patientResource->getPatientInfoWithDocInfo($patientId);

        $isConfirmed = false;
        if (
            $patient
            &&
            in_array($patient->registration_status, [1, 2])
            &&
            $patient->use_patient_portal == 1
            &&
            $patient->doc_use_patient_portal == 1
            &&
            $patient->email != $email
        ) {
            $isConfirmed = true;
        }
        return $isConfirmed;
    }
}
