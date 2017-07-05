<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\User as Resource;
use DentalSleepSolutions\Contracts\Repositories\Users as Repository;
use DB;

/**
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
 * @property-read \DentalSleepSolutions\Eloquent\Dental\ExternalCompanyUser $externalCompanyPivot
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereAccessCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereAccessCodeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereAccessCodeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereBillingCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereBillingPlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereCcId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereClaimMarginLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereClaimMarginTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereEditLedgerEntries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereEdxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereEin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereEligibleTest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereEmailFooter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereEmailHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereFaxFooter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereFaxHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereHeaderSpace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereHelpId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereHomepage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereIndentAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereIntroLetters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLastAccessedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLetterMarginBottom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLetterMarginFooter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLetterMarginHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLetterMarginLeft($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLetterMarginRight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLetterMarginTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMailingAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMailingCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMailingName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMailingPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMailingPractice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMailingState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMailingZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereManageStaff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMedicareNpi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMedicarePtan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereNpi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User wherePostLedgerAdjustments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User wherePractice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereProducer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereProducerFiles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereRecoverHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereRecoverTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereRegistrationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereRegistrationEmailDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereSalt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceEin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceMedicareNpi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceMedicarePtan($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceNpi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServicePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceSsn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceTaxIdOrSsn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereSignNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereSignatureFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereSignatureJson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereSsn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereSuspendedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereSuspendedReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereTaxIdOrSsn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereTextDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereTextNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereTrackerLetters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUseCourse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUseCourseStaff($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUseDigitalFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUseEligibleApi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUseLetterHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUseLetters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUsePatientPortal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUsePaymentReports($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUseServiceNpi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUserAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUserid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereZip($value)
 * @mixin \Eloquent
 */
/**
 * @SWG\Definition(
 *     definition="User",
 *     type="object",
 *     required={"userid", "npi", "city", "state", "zip", "use", "fax", "use", "sign", "use", "text", "producer", "use", "use", "manage"},
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="user", type="integer"),
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
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="medicare", type="string"),
 *     @SWG\Property(property="tax", type="string"),
 *     @SWG\Property(property="producer", type="integer"),
 *     @SWG\Property(property="practice", type="string"),
 *     @SWG\Property(property="email", type="string"),
 *     @SWG\Property(property="email", type="string"),
 *     @SWG\Property(property="fax", type="string"),
 *     @SWG\Property(property="fax", type="string"),
 *     @SWG\Property(property="salt", type="string"),
 *     @SWG\Property(property="recover", type="string"),
 *     @SWG\Property(property="recover", type="string", format="dateTime"),
 *     @SWG\Property(property="ssn", type="integer"),
 *     @SWG\Property(property="ein", type="integer"),
 *     @SWG\Property(property="use", type="integer"),
 *     @SWG\Property(property="mailing", type="string"),
 *     @SWG\Property(property="mailing", type="string"),
 *     @SWG\Property(property="mailing", type="string"),
 *     @SWG\Property(property="mailing", type="string"),
 *     @SWG\Property(property="mailing", type="string"),
 *     @SWG\Property(property="mailing", type="string"),
 *     @SWG\Property(property="mailing", type="string"),
 *     @SWG\Property(property="last", type="string", format="dateTime"),
 *     @SWG\Property(property="use", type="integer"),
 *     @SWG\Property(property="fax", type="string"),
 *     @SWG\Property(property="use", type="integer"),
 *     @SWG\Property(property="sign", type="integer"),
 *     @SWG\Property(property="use", type="integer"),
 *     @SWG\Property(property="access", type="string"),
 *     @SWG\Property(property="text", type="string", format="dateTime"),
 *     @SWG\Property(property="text", type="integer"),
 *     @SWG\Property(property="access", type="string", format="dateTime"),
 *     @SWG\Property(property="registration", type="string", format="dateTime"),
 *     @SWG\Property(property="producer", type="integer"),
 *     @SWG\Property(property="medicare", type="string"),
 *     @SWG\Property(property="use", type="integer"),
 *     @SWG\Property(property="use", type="integer"),
 *     @SWG\Property(property="manage", type="integer"),
 *     @SWG\Property(property="cc", type="string"),
 *     @SWG\Property(property="user", type="integer"),
 *     @SWG\Property(property="letter", type="integer"),
 *     @SWG\Property(property="letter", type="integer"),
 *     @SWG\Property(property="letter", type="integer"),
 *     @SWG\Property(property="letter", type="integer"),
 *     @SWG\Property(property="letter", type="integer"),
 *     @SWG\Property(property="letter", type="integer"),
 *     @SWG\Property(property="claim", type="integer"),
 *     @SWG\Property(property="claim", type="integer"),
 *     @SWG\Property(property="logo", type="string"),
 *     @SWG\Property(property="homepage", type="integer"),
 *     @SWG\Property(property="use", type="integer"),
 *     @SWG\Property(property="access", type="integer"),
 *     @SWG\Property(property="first", type="string"),
 *     @SWG\Property(property="last", type="string"),
 *     @SWG\Property(property="indent", type="integer"),
 *     @SWG\Property(property="registration", type="string", format="dateTime"),
 *     @SWG\Property(property="header", type="integer"),
 *     @SWG\Property(property="billing", type="integer"),
 *     @SWG\Property(property="edx", type="integer"),
 *     @SWG\Property(property="help", type="integer"),
 *     @SWG\Property(property="tracker", type="integer"),
 *     @SWG\Property(property="intro", type="integer"),
 *     @SWG\Property(property="plan", type="integer"),
 *     @SWG\Property(property="suspended", type="string"),
 *     @SWG\Property(property="suspended", type="string", format="dateTime"),
 *     @SWG\Property(property="updated", type="string", format="dateTime"),
 *     @SWG\Property(property="signature", type="string"),
 *     @SWG\Property(property="signature", type="string"),
 *     @SWG\Property(property="use", type="integer"),
 *     @SWG\Property(property="service", type="string"),
 *     @SWG\Property(property="service", type="string"),
 *     @SWG\Property(property="service", type="string"),
 *     @SWG\Property(property="service", type="string"),
 *     @SWG\Property(property="service", type="string"),
 *     @SWG\Property(property="service", type="string"),
 *     @SWG\Property(property="service", type="string"),
 *     @SWG\Property(property="service", type="string"),
 *     @SWG\Property(property="service", type="string"),
 *     @SWG\Property(property="service", type="string"),
 *     @SWG\Property(property="service", type="string"),
 *     @SWG\Property(property="service", type="integer"),
 *     @SWG\Property(property="service", type="integer"),
 *     @SWG\Property(property="eligible", type="integer"),
 *     @SWG\Property(property="billing", type="integer"),
 *     @SWG\Property(property="post", type="integer"),
 *     @SWG\Property(property="edit", type="integer"),
 *     @SWG\Property(property="use", type="integer"),
 *     @SWG\Property(property="externalCompanyPivot", ref="#/definitions/ExternalCompanyUser")
 * )
 */
/**
 * @SWG\Definition(
 *     definition="User",
 *     type="object",
 * 
 * )
 */
class User extends AbstractModel implements Resource, Repository
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
     * @return \DentalSleepSolutions\Eloquent\Dental\User
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
     * @return \DentalSleepSolutions\Eloquent\Dental\User
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
     * @return \DentalSleepSolutions\Eloquent\Dental\User
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
