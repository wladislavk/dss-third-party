<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DB;

/**
 * @SWG\Definition(
 *     definition="User",
 *     type="object",
 *     required={"userid", "npi", "city", "state", "zip", "use_digital_fax", "fax", "use_letters", "sign_notes", "use_eligible_api", "text_num", "producer_files", "use_course", "use_course_staff", "manage_staff"},
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="user_access", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="username", type="string"),
 *     @SWG\Property(property="npi", type="string"),
 *     @SWG\Property(property="password", type="string"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="email", type="string"),
 *     @SWG\Property(property="address", type="string"),
 *     @SWG\Property(property="city", type="string"),
 *     @SWG\Property(property="state", type="string"),
 *     @SWG\Property(property="zip", type="string"),
 *     @SWG\Property(property="phone", type="string"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="medicare_npi", type="string"),
 *     @SWG\Property(property="tax_id_or_ssn", type="string"),
 *     @SWG\Property(property="producer", type="integer"),
 *     @SWG\Property(property="practice", type="string"),
 *     @SWG\Property(property="email_header", type="string"),
 *     @SWG\Property(property="email_footer", type="string"),
 *     @SWG\Property(property="fax_header", type="string"),
 *     @SWG\Property(property="fax_footer", type="string"),
 *     @SWG\Property(property="salt", type="string"),
 *     @SWG\Property(property="recover_hash", type="string"),
 *     @SWG\Property(property="recover_time", type="string", format="dateTime"),
 *     @SWG\Property(property="ssn", type="integer"),
 *     @SWG\Property(property="ein", type="integer"),
 *     @SWG\Property(property="use_patient_portal", type="integer"),
 *     @SWG\Property(property="mailing_practice", type="string"),
 *     @SWG\Property(property="mailing_name", type="string"),
 *     @SWG\Property(property="mailing_address", type="string"),
 *     @SWG\Property(property="mailing_city", type="string"),
 *     @SWG\Property(property="mailing_state", type="string"),
 *     @SWG\Property(property="mailing_zip", type="string"),
 *     @SWG\Property(property="mailing_phone", type="string"),
 *     @SWG\Property(property="last_accessed_date", type="string", format="dateTime"),
 *     @SWG\Property(property="use_digital_fax", type="integer"),
 *     @SWG\Property(property="fax", type="string"),
 *     @SWG\Property(property="use_letters", type="integer"),
 *     @SWG\Property(property="sign_notes", type="integer"),
 *     @SWG\Property(property="use_eligible_api", type="integer"),
 *     @SWG\Property(property="access_code", type="string"),
 *     @SWG\Property(property="text_date", type="string", format="dateTime"),
 *     @SWG\Property(property="text_num", type="integer"),
 *     @SWG\Property(property="access_code_date", type="string", format="dateTime"),
 *     @SWG\Property(property="registration_email_date", type="string", format="dateTime"),
 *     @SWG\Property(property="producer_files", type="integer"),
 *     @SWG\Property(property="medicare_ptan", type="string"),
 *     @SWG\Property(property="use_course", type="integer"),
 *     @SWG\Property(property="use_course_staff", type="integer"),
 *     @SWG\Property(property="manage_staff", type="integer"),
 *     @SWG\Property(property="cc_id", type="string"),
 *     @SWG\Property(property="user_type", type="integer"),
 *     @SWG\Property(property="letter_margin_header", type="integer"),
 *     @SWG\Property(property="letter_margin_footer", type="integer"),
 *     @SWG\Property(property="letter_margin_top", type="integer"),
 *     @SWG\Property(property="letter_margin_bottom", type="integer"),
 *     @SWG\Property(property="letter_margin_left", type="integer"),
 *     @SWG\Property(property="letter_margin_right", type="integer"),
 *     @SWG\Property(property="claim_margin_top", type="integer"),
 *     @SWG\Property(property="claim_margin_left", type="integer"),
 *     @SWG\Property(property="logo", type="string"),
 *     @SWG\Property(property="homepage", type="integer"),
 *     @SWG\Property(property="use_letter_header", type="integer"),
 *     @SWG\Property(property="access_code_id", type="integer"),
 *     @SWG\Property(property="first_name", type="string"),
 *     @SWG\Property(property="last_name", type="string"),
 *     @SWG\Property(property="indent_address", type="integer"),
 *     @SWG\Property(property="registration_date", type="string", format="dateTime"),
 *     @SWG\Property(property="header_space", type="integer"),
 *     @SWG\Property(property="billing_company_id", type="integer"),
 *     @SWG\Property(property="edx_id", type="integer"),
 *     @SWG\Property(property="help_id", type="integer"),
 *     @SWG\Property(property="tracker_letters", type="integer"),
 *     @SWG\Property(property="intro_letters", type="integer"),
 *     @SWG\Property(property="plan_id", type="integer"),
 *     @SWG\Property(property="suspended_reason", type="string"),
 *     @SWG\Property(property="suspended_date", type="string", format="dateTime"),
 *     @SWG\Property(property="updated_at", type="string", format="dateTime"),
 *     @SWG\Property(property="signature_file", type="string"),
 *     @SWG\Property(property="signature_json", type="string"),
 *     @SWG\Property(property="use_service_npi", type="integer"),
 *     @SWG\Property(property="service_name", type="string"),
 *     @SWG\Property(property="service_address", type="string"),
 *     @SWG\Property(property="service_city", type="string"),
 *     @SWG\Property(property="service_state", type="string"),
 *     @SWG\Property(property="service_zip", type="string"),
 *     @SWG\Property(property="service_phone", type="string"),
 *     @SWG\Property(property="service_fax", type="string"),
 *     @SWG\Property(property="service_npi", type="string"),
 *     @SWG\Property(property="service_medicare_npi", type="string"),
 *     @SWG\Property(property="service_medicare_ptan", type="string"),
 *     @SWG\Property(property="service_tax_id_or_ssn", type="string"),
 *     @SWG\Property(property="service_ssn", type="integer"),
 *     @SWG\Property(property="service_ein", type="integer"),
 *     @SWG\Property(property="eligible_test", type="integer"),
 *     @SWG\Property(property="billing_plan_id", type="integer"),
 *     @SWG\Property(property="post_ledger_adjustments", type="integer"),
 *     @SWG\Property(property="edit_ledger_entries", type="integer"),
 *     @SWG\Property(property="use_payment_reports", type="integer"),
 *     @SWG\Property(property="externalCompanyPivot", ref="#/definitions/ExternalCompanyUser")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\User
 *
 * @property int $userid
 * @property int|null $user_access
 * @property int|null $docid
 * @property string|null $username
 * @property string $npi
 * @property string|null $password
 * @property string|null $name
 * @property string|null $email
 * @property string|null $address
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string|null $phone
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $medicare_npi
 * @property string|null $tax_id_or_ssn
 * @property int|null $producer
 * @property string|null $practice
 * @property string|null $email_header
 * @property string|null $email_footer
 * @property string|null $fax_header
 * @property string|null $fax_footer
 * @property string|null $salt
 * @property string|null $recover_hash
 * @property \Carbon\Carbon|null $recover_time
 * @property int|null $ssn
 * @property int|null $ein
 * @property int|null $use_patient_portal
 * @property string|null $mailing_practice
 * @property string|null $mailing_name
 * @property string|null $mailing_address
 * @property string|null $mailing_city
 * @property string|null $mailing_state
 * @property string|null $mailing_zip
 * @property string|null $mailing_phone
 * @property \Carbon\Carbon|null $last_accessed_date
 * @property int $use_digital_fax
 * @property string $fax
 * @property int $use_letters
 * @property int $sign_notes
 * @property int $use_eligible_api
 * @property string|null $access_code
 * @property \Carbon\Carbon|null $text_date
 * @property int $text_num
 * @property \Carbon\Carbon|null $access_code_date
 * @property \Carbon\Carbon|null $registration_email_date
 * @property int $producer_files
 * @property string|null $medicare_ptan
 * @property int $use_course
 * @property int $use_course_staff
 * @property int $manage_staff
 * @property string|null $cc_id
 * @property int|null $user_type
 * @property int|null $letter_margin_header
 * @property int|null $letter_margin_footer
 * @property int|null $letter_margin_top
 * @property int|null $letter_margin_bottom
 * @property int|null $letter_margin_left
 * @property int|null $letter_margin_right
 * @property int|null $claim_margin_top
 * @property int|null $claim_margin_left
 * @property string|null $logo
 * @property int|null $homepage
 * @property int|null $use_letter_header
 * @property int|null $access_code_id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property int|null $indent_address
 * @property \Carbon\Carbon|null $registration_date
 * @property int|null $header_space
 * @property int|null $billing_company_id
 * @property int|null $edx_id
 * @property int|null $help_id
 * @property int|null $tracker_letters
 * @property int|null $intro_letters
 * @property int|null $plan_id
 * @property string|null $suspended_reason
 * @property \Carbon\Carbon|null $suspended_date
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $signature_file
 * @property string|null $signature_json
 * @property int|null $use_service_npi
 * @property string|null $service_name
 * @property string|null $service_address
 * @property string|null $service_city
 * @property string|null $service_state
 * @property string|null $service_zip
 * @property string|null $service_phone
 * @property string|null $service_fax
 * @property string|null $service_npi
 * @property string|null $service_medicare_npi
 * @property string|null $service_medicare_ptan
 * @property string|null $service_tax_id_or_ssn
 * @property int|null $service_ssn
 * @property int|null $service_ein
 * @property int|null $eligible_test
 * @property int|null $billing_plan_id
 * @property int|null $post_ledger_adjustments
 * @property int|null $edit_ledger_entries
 * @property int|null $use_payment_reports
 * @property-read \DentalSleepSolutions\Eloquent\Models\Dental\ExternalCompanyUser $externalCompanyPivot
 * @mixin \Eloquent
 */
class User extends AbstractModel
{
    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['userid', 'password', 'salt'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'salt'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
     protected $table = 'dental_users';

    /**
     * The primary key for the model.
     *
     * @var string
     */
     protected $primaryKey = 'userid';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'recover_time', 'last_accessed_date', 'text_date',
        'access_code_date', 'registration_email_date',
        'registration_date', 'suspended_date'
    ];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function externalCompanyPivot(){
        return $this->belongsTo(ExternalCompanyUser::class, 'userid', 'user_id');
    }

    public function externalCompany()
    {
        return $this->externalCompanyPivot->belongsTo(ExternalCompany::class, 'company_id', 'id');
    }

    /**
     * Get user type by user id
     *
     * @param integer $userId
     * @return \DentalSleepSolutions\Eloquent\Models\Dental\User
     */
    public function getUserType($userId)
    {
        return self::select('user_type')
            ->where('userid', $userId)
            ->first();
    }


    /**
     * Get doc id by user id
     *
     * @param integer $userId
     * @return \DentalSleepSolutions\Eloquent\Models\Dental\User
     */
    public function getDocId($userId)
    {
        return self::select(DB::raw('
            CASE docid
                WHEN 0 THEN userid
                ELSE docid
            END as docid'))
            ->where('userid', $userId)
            ->first();
    }

    /**
     * Get course staff by user id
     *
     * @param integer $userId
     * @return \DentalSleepSolutions\Eloquent\Models\Dental\User
     */
    public function getCourseStaff($userId)
    {
        return self::from(DB::raw('dental_users s'))
            ->select(DB::raw('s.use_course, d.use_course_staff'))
            ->join(DB::raw('dental_users d'), 'd.userid', '=', 's.docid')
            ->where('s.userid', $userId)
            ->first();
    }

    public function getPaymentReports($docId = 0)
    {
        return $this->select('use_payment_reports')
            ->where('userid', $docId)
            ->first();
    }

    public function getLastAccessedDate($userId = 0)
    {
        return $this->select('last_accessed_date')
            ->where('userid', $userId)
            ->first();
    }

    public function getLetterInfo($docId = 0)
    {
        return $this->select('use_letters', 'intro_letters')
            ->where('userid', $docId)
            ->first();
    }

    /**
     * @param array $fields
     * @param array $where
     * @return \Illuminate\Database\Eloquent\Collection|User[]
     */
    public function getWithFilter(array $fields = [], array $where = [])
    {
        $object = $this;

        if (count($fields)) {
            $object = $object->select($fields);
        }

        if (count($where)) {
            foreach ($where as $key => $value) {
                $object = $object->where($key, $value);
            }
        }

        return $object->get();
    }

    /**
     * @param $docId
     * @param $patientId
     * @param int $locationId
     * @return User|null
     */
    public function getMailingData($docId, $patientId, $locationId = 0)
    {
        $query = $this->select(
                'l.phone AS mailing_phone',
                'u.user_type',
                'u.logo',
                'l.location AS mailing_practice',
                'l.address AS mailing_address',
                'l.city AS mailing_city',
                'l.state AS mailing_state',
                'l.zip AS mailing_zip'
            )->from(DB::raw('dental_users u'))
            ->join(DB::raw('dental_patients p'), 'u.userid', '=', 'p.docid')
            ->leftJoin(DB::raw('dental_locations l'), 'l.docid', '=', 'u.userid');

        if ($locationId) {
            $query = $query->where('l.id', $locationId)
                ->where('l.docid', $docId);
        } else {
            $query = $query->where('l.default_location', 1)
                ->where('p.patientid', $patientId);
        }

        return $query->first();
    }
}
