<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use Illuminate\Database\Query\Builder;

/**
 * @SWG\Definition(
 *     definition="Patient",
 *     type="object",
 *     required={"patientid", "member_no", "group_no", "plan_no", "p_m_partymname", "p_m_partylname", "s_m_partymname", "s_m_partylname", "p_m_ins_grp", "s_m_ins_grp", "p_m_ins_plan", "s_m_ins_plan", "p_m_dss_file", "s_m_dss_file", "p_m_ins_type", "s_m_ins_type", "p_m_ins_ass", "s_m_ins_ass", "ins_dob", "ins2_dob", "premedcheck", "premed", "docsleep", "docpcp", "docdentist", "docent", "docmdother", "text_num", "use_patient_portal", "email_bounce", "docmdother2", "docmdother3", "last_reg_sect"},
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="lastname", type="string"),
 *     @SWG\Property(property="firstname", type="string"),
 *     @SWG\Property(property="middlename", type="string"),
 *     @SWG\Property(property="salutation", type="string"),
 *     @SWG\Property(property="member_no", type="string"),
 *     @SWG\Property(property="group_no", type="string"),
 *     @SWG\Property(property="plan_no", type="string"),
 *     @SWG\Property(property="dob", type="string"),
 *     @SWG\Property(property="add1", type="string"),
 *     @SWG\Property(property="add2", type="string"),
 *     @SWG\Property(property="city", type="string"),
 *     @SWG\Property(property="state", type="string"),
 *     @SWG\Property(property="zip", type="string"),
 *     @SWG\Property(property="gender", type="string"),
 *     @SWG\Property(property="marital_status", type="string"),
 *     @SWG\Property(property="ssn", type="string"),
 *     @SWG\Property(property="internal_patient", type="string"),
 *     @SWG\Property(property="home_phone", type="string"),
 *     @SWG\Property(property="work_phone", type="string"),
 *     @SWG\Property(property="cell_phone", type="string"),
 *     @SWG\Property(property="email", type="string"),
 *     @SWG\Property(property="patient_notes", type="string"),
 *     @SWG\Property(property="alert_text", type="string"),
 *     @SWG\Property(property="display_alert", type="integer"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="p_d_party", type="string"),
 *     @SWG\Property(property="p_d_relation", type="string"),
 *     @SWG\Property(property="p_d_other", type="string"),
 *     @SWG\Property(property="p_d_employer", type="string"),
 *     @SWG\Property(property="p_d_ins_co", type="string"),
 *     @SWG\Property(property="p_d_ins_id", type="string"),
 *     @SWG\Property(property="s_d_party", type="string"),
 *     @SWG\Property(property="s_d_relation", type="string"),
 *     @SWG\Property(property="s_d_other", type="string"),
 *     @SWG\Property(property="s_d_employer", type="string"),
 *     @SWG\Property(property="s_d_ins_co", type="string"),
 *     @SWG\Property(property="s_d_ins_id", type="string"),
 *     @SWG\Property(property="p_m_partyfname", type="string"),
 *     @SWG\Property(property="p_m_partymname", type="string"),
 *     @SWG\Property(property="p_m_partylname", type="string"),
 *     @SWG\Property(property="p_m_relation", type="string"),
 *     @SWG\Property(property="p_m_other", type="string"),
 *     @SWG\Property(property="p_m_employer", type="string"),
 *     @SWG\Property(property="p_m_ins_co", type="string"),
 *     @SWG\Property(property="p_m_ins_id", type="string"),
 *     @SWG\Property(property="s_m_partyfname", type="string"),
 *     @SWG\Property(property="s_m_partymname", type="string"),
 *     @SWG\Property(property="s_m_partylname", type="string"),
 *     @SWG\Property(property="s_m_relation", type="string"),
 *     @SWG\Property(property="s_m_other", type="string"),
 *     @SWG\Property(property="s_m_employer", type="string"),
 *     @SWG\Property(property="s_m_ins_co", type="string"),
 *     @SWG\Property(property="s_m_ins_id", type="string"),
 *     @SWG\Property(property="p_m_ins_grp", type="string"),
 *     @SWG\Property(property="s_m_ins_grp", type="string"),
 *     @SWG\Property(property="p_m_ins_plan", type="string"),
 *     @SWG\Property(property="s_m_ins_plan", type="string"),
 *     @SWG\Property(property="p_m_dss_file", type="string"),
 *     @SWG\Property(property="s_m_dss_file", type="string"),
 *     @SWG\Property(property="p_m_ins_type", type="string"),
 *     @SWG\Property(property="s_m_ins_type", type="string"),
 *     @SWG\Property(property="p_m_ins_ass", type="string"),
 *     @SWG\Property(property="s_m_ins_ass", type="string"),
 *     @SWG\Property(property="ins_dob", type="string"),
 *     @SWG\Property(property="ins2_dob", type="string"),
 *     @SWG\Property(property="employer", type="string"),
 *     @SWG\Property(property="emp_add1", type="string"),
 *     @SWG\Property(property="emp_add2", type="string"),
 *     @SWG\Property(property="emp_city", type="string"),
 *     @SWG\Property(property="emp_state", type="string"),
 *     @SWG\Property(property="emp_zip", type="string"),
 *     @SWG\Property(property="emp_phone", type="string"),
 *     @SWG\Property(property="emp_fax", type="string"),
 *     @SWG\Property(property="plan_name", type="string"),
 *     @SWG\Property(property="group_number", type="string"),
 *     @SWG\Property(property="ins_type", type="string"),
 *     @SWG\Property(property="accept_assignment", type="string"),
 *     @SWG\Property(property="print_signature", type="string"),
 *     @SWG\Property(property="medical_insurance", type="string"),
 *     @SWG\Property(property="mark_yes", type="string"),
 *     @SWG\Property(property="inactive", type="string"),
 *     @SWG\Property(property="partner_name", type="string"),
 *     @SWG\Property(property="emergency_name", type="string"),
 *     @SWG\Property(property="emergency_number", type="string"),
 *     @SWG\Property(property="referred_source", type="string"),
 *     @SWG\Property(property="referred_by", type="string"),
 *     @SWG\Property(property="premedcheck", type="integer"),
 *     @SWG\Property(property="premed", type="string"),
 *     @SWG\Property(property="docsleep", type="string"),
 *     @SWG\Property(property="docpcp", type="string"),
 *     @SWG\Property(property="docdentist", type="string"),
 *     @SWG\Property(property="docent", type="string"),
 *     @SWG\Property(property="docmdother", type="string"),
 *     @SWG\Property(property="preferredcontact", type="string"),
 *     @SWG\Property(property="copyreqdate", type="string"),
 *     @SWG\Property(property="best_time", type="string"),
 *     @SWG\Property(property="best_number", type="string"),
 *     @SWG\Property(property="emergency_relationship", type="string"),
 *     @SWG\Property(property="has_s_m_ins", type="string"),
 *     @SWG\Property(property="referred_notes", type="string"),
 *     @SWG\Property(property="login", type="string"),
 *     @SWG\Property(property="password", type="string"),
 *     @SWG\Property(property="salt", type="string"),
 *     @SWG\Property(property="recover_hash", type="string"),
 *     @SWG\Property(property="recover_time", type="string", format="dateTime"),
 *     @SWG\Property(property="registered", type="integer"),
 *     @SWG\Property(property="access_code", type="string"),
 *     @SWG\Property(property="parent_patientid", type="integer"),
 *     @SWG\Property(property="has_p_m_ins", type="string"),
 *     @SWG\Property(property="registration_status", type="integer"),
 *     @SWG\Property(property="text_date", type="string", format="dateTime"),
 *     @SWG\Property(property="text_num", type="integer"),
 *     @SWG\Property(property="use_patient_portal", type="integer"),
 *     @SWG\Property(property="registration_senton", type="string", format="dateTime"),
 *     @SWG\Property(property="preferred_name", type="string"),
 *     @SWG\Property(property="feet", type="string"),
 *     @SWG\Property(property="inches", type="string"),
 *     @SWG\Property(property="weight", type="string"),
 *     @SWG\Property(property="bmi", type="string"),
 *     @SWG\Property(property="symptoms_status", type="integer"),
 *     @SWG\Property(property="sleep_status", type="integer"),
 *     @SWG\Property(property="treatments_status", type="integer"),
 *     @SWG\Property(property="history_status", type="integer"),
 *     @SWG\Property(property="access_code_date", type="string", format="dateTime"),
 *     @SWG\Property(property="email_bounce", type="integer"),
 *     @SWG\Property(property="docmdother2", type="string"),
 *     @SWG\Property(property="docmdother3", type="string"),
 *     @SWG\Property(property="last_reg_sect", type="integer"),
 *     @SWG\Property(property="access_type", type="integer"),
 *     @SWG\Property(property="p_m_eligible_id", type="string"),
 *     @SWG\Property(property="p_m_eligible_payer_id", type="string"),
 *     @SWG\Property(property="p_m_eligible_payer_name", type="string"),
 *     @SWG\Property(property="p_m_gender", type="string"),
 *     @SWG\Property(property="s_m_gender", type="string"),
 *     @SWG\Property(property="p_m_same_address", type="integer"),
 *     @SWG\Property(property="p_m_address", type="string"),
 *     @SWG\Property(property="p_m_state", type="string"),
 *     @SWG\Property(property="p_m_city", type="string"),
 *     @SWG\Property(property="p_m_zip", type="string"),
 *     @SWG\Property(property="s_m_same_address", type="integer"),
 *     @SWG\Property(property="s_m_address", type="string"),
 *     @SWG\Property(property="s_m_city", type="string"),
 *     @SWG\Property(property="s_m_state", type="string"),
 *     @SWG\Property(property="s_m_zip", type="string"),
 *     @SWG\Property(property="new_fee_date", type="string", format="dateTime"),
 *     @SWG\Property(property="new_fee_amount", type="float"),
 *     @SWG\Property(property="new_fee_desc", type="string"),
 *     @SWG\Property(property="new_fee_invoice_id", type="integer"),
 *     @SWG\Property(property="s_m_eligible_payer_id", type="string"),
 *     @SWG\Property(property="s_m_eligible_payer_name", type="string"),
 *     @SWG\Property(property="airwayEvaluation", ref="#/definitions/AirwayEvaluation"),
 *     @SWG\Property(property="dentalClinicalExam", ref="#/definitions/DentalClinicalExam"),
 *     @SWG\Property(property="tmjClinicalExam", ref="#/definitions/TmjClinicalExam"),
 *     @SWG\Property(property="tongueClinicalExam", ref="#/definitions/TongueClinicalExam"),
 *     @SWG\Property(property="tonsilsClinicalExam", ref="#/definitions/TonsilsClinicalExam")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Patient
 *
 * @property int $patientid
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $salutation
 * @property string $member_no
 * @property string $group_no
 * @property string $plan_no
 * @property string|null $dob
 * @property string|null $add1
 * @property string|null $add2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip
 * @property string|null $gender
 * @property string|null $marital_status
 * @property string|null $ssn
 * @property string|null $internal_patient
 * @property string|null $home_phone
 * @property string|null $work_phone
 * @property string|null $cell_phone
 * @property string|null $email
 * @property string|null $patient_notes
 * @property string|null $alert_text
 * @property int|null $display_alert
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $p_d_party
 * @property string|null $p_d_relation
 * @property string|null $p_d_other
 * @property string|null $p_d_employer
 * @property string|null $p_d_ins_co
 * @property string|null $p_d_ins_id
 * @property string|null $s_d_party
 * @property string|null $s_d_relation
 * @property string|null $s_d_other
 * @property string|null $s_d_employer
 * @property string|null $s_d_ins_co
 * @property string|null $s_d_ins_id
 * @property string|null $p_m_partyfname
 * @property string $p_m_partymname
 * @property string $p_m_partylname
 * @property string|null $p_m_relation
 * @property string|null $p_m_other
 * @property string|null $p_m_employer
 * @property string|null $p_m_ins_co
 * @property string|null $p_m_ins_id
 * @property string|null $s_m_partyfname
 * @property string $s_m_partymname
 * @property string $s_m_partylname
 * @property string|null $s_m_relation
 * @property string|null $s_m_other
 * @property string|null $s_m_employer
 * @property string|null $s_m_ins_co
 * @property string|null $s_m_ins_id
 * @property string $p_m_ins_grp
 * @property string $s_m_ins_grp
 * @property string $p_m_ins_plan
 * @property string $s_m_ins_plan
 * @property string $p_m_dss_file
 * @property string $s_m_dss_file
 * @property string $p_m_ins_type
 * @property string $s_m_ins_type
 * @property string $p_m_ins_ass
 * @property string $s_m_ins_ass
 * @property string $ins_dob
 * @property string $ins2_dob
 * @property string|null $employer
 * @property string|null $emp_add1
 * @property string|null $emp_add2
 * @property string|null $emp_city
 * @property string|null $emp_state
 * @property string|null $emp_zip
 * @property string|null $emp_phone
 * @property string|null $emp_fax
 * @property string|null $plan_name
 * @property string|null $group_number
 * @property string|null $ins_type
 * @property string|null $accept_assignment
 * @property string|null $print_signature
 * @property string|null $medical_insurance
 * @property string|null $mark_yes
 * @property string|null $inactive
 * @property string|null $partner_name
 * @property string|null $emergency_name
 * @property string|null $emergency_number
 * @property string|null $referred_source
 * @property string|null $referred_by
 * @property int $premedcheck
 * @property string $premed
 * @property string $docsleep
 * @property string $docpcp
 * @property string $docdentist
 * @property string $docent
 * @property string $docmdother
 * @property string|null $preferredcontact
 * @property string|null $copyreqdate
 * @property string|null $best_time
 * @property string|null $best_number
 * @property string|null $emergency_relationship
 * @property string|null $has_s_m_ins
 * @property string|null $referred_notes
 * @property string|null $login
 * @property string|null $password
 * @property string|null $salt
 * @property string|null $recover_hash
 * @property \Carbon\Carbon|null $recover_time
 * @property int|null $registered
 * @property string|null $access_code
 * @property int|null $parent_patientid
 * @property string|null $has_p_m_ins
 * @property int|null $registration_status
 * @property \Carbon\Carbon|null $text_date
 * @property int $text_num
 * @property int $use_patient_portal
 * @property \Carbon\Carbon|null $registration_senton
 * @property string|null $preferred_name
 * @property string|null $feet
 * @property string|null $inches
 * @property string|null $weight
 * @property string|null $bmi
 * @property int|null $symptoms_status
 * @property int|null $sleep_status
 * @property int|null $treatments_status
 * @property int|null $history_status
 * @property \Carbon\Carbon|null $access_code_date
 * @property int $email_bounce
 * @property string $docmdother2
 * @property string $docmdother3
 * @property int $last_reg_sect
 * @property int|null $access_type
 * @property string|null $p_m_eligible_id
 * @property string|null $p_m_eligible_payer_id
 * @property string|null $p_m_eligible_payer_name
 * @property string|null $p_m_gender
 * @property string|null $s_m_gender
 * @property int|null $p_m_same_address
 * @property string|null $p_m_address
 * @property string|null $p_m_state
 * @property string|null $p_m_city
 * @property string|null $p_m_zip
 * @property int|null $s_m_same_address
 * @property string|null $s_m_address
 * @property string|null $s_m_city
 * @property string|null $s_m_state
 * @property string|null $s_m_zip
 * @property \Carbon\Carbon|null $new_fee_date
 * @property float|null $new_fee_amount
 * @property string|null $new_fee_desc
 * @property int|null $new_fee_invoice_id
 * @property string|null $s_m_eligible_payer_id
 * @property string|null $s_m_eligible_payer_name
 * @property-read \DentalSleepSolutions\Eloquent\Models\Dental\AirwayEvaluation $airwayEvaluation
 * @property-read \DentalSleepSolutions\Eloquent\Models\Dental\DentalClinicalExam $dentalClinicalExam
 * @property-read \DentalSleepSolutions\Eloquent\Models\Dental\TmjClinicalExam $tmjClinicalExam
 * @property-read \DentalSleepSolutions\Eloquent\Models\Dental\TongueClinicalExam $tongueClinicalExam
 * @property-read \DentalSleepSolutions\Eloquent\Models\Dental\TonsilsClinicalExam $tonsilsClinicalExam
 * @mixin \Eloquent
 */
class Patient extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    const DSS_REFERRED_PATIENT = 1;
    const DSS_REFERRED_PHYSICIAN = 2;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['patientid', 'password', 'salt'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_patients';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'patientid';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'recover_time',
        'text_date',
        'registration_senton',
        'access_code_date',
        'new_fee_date',
    ];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tongueClinicalExam()
    {
        return $this->hasOne(TongueClinicalExam::class, 'patientid', 'patientid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tonsilsClinicalExam()
    {
        return $this->hasOne(TonsilsClinicalExam::class, 'patientid', 'patientid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function airwayEvaluation()
    {
        return $this->hasOne(AirwayEvaluation::class, 'patientid', 'patientid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dentalClinicalExam()
    {
        return $this->hasOne(DentalClinicalExam::class, 'patientid', 'patientid');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tmjClinicalExam()
    {
        return $this->hasOne(TmjClinicalExam::class, 'patientid', 'patientid');
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('p.status', 1);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeAll(Builder $query)
    {
        return $query->where(function($query) {
            $query->where('p.status', 1)
                ->orWhere('p.status', 2);
        });
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeInactive(Builder $query)
    {
        return $query->where('p.status', 2);
    }
}
