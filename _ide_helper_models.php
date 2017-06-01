<?php
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace DentalSleepSolutions\Eloquent{
/**
 * DentalSleepSolutions\Eloquent\EligibleResponse
 *
 * @property int $id
 * @property string $claimid
 * @property StdObject $response
 * @property string $event_type
 * @property string $adddate
 * @property string $ip_address
 * @property string $reference_id
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\EligibleResponse whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\EligibleResponse whereClaimid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\EligibleResponse whereEventType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\EligibleResponse whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\EligibleResponse whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\EligibleResponse whereReferenceId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\EligibleResponse whereResponse($value)
 */
	class EligibleResponse extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent{
/**
 * DentalSleepSolutions\Eloquent\Company
 *
 * @property int $id
 * @property string $name
 * @property string $add1
 * @property string $add2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property bool $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $eligible_api_key
 * @property string $stripe_secret_key
 * @property string $stripe_publishable_key
 * @property string $logo
 * @property float $monthly_fee
 * @property bool $default_new
 * @property string $sfax_security_context
 * @property string $sfax_app_id
 * @property string $sfax_app_key
 * @property string $sfax_init_vector
 * @property float $fax_fee
 * @property int $free_fax
 * @property bool $company_type
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @property int $plan_id
 * @property string $sfax_encryption_key
 * @property bool $use_support
 * @property bool $exclusive
 * @property bool $vob_require_test
 * @property-read \Illuminate\Database\Eloquent\Collection|\DentalSleepSolutions\Eloquent\Dental\UserCompany[] $users
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereAdd1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereAdd2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereCompanyType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereDefaultNew($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereEligibleApiKey($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereExclusive($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereFaxFee($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereFreeFax($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereMonthlyFee($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company wherePlanId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereSfaxAppId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereSfaxAppKey($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereSfaxEncryptionKey($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereSfaxInitVector($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereSfaxSecurityContext($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereStripePublishableKey($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereStripeSecretKey($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereUseSupport($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereVobRequireTest($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Company whereZip($value)
 */
	class Company extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent{
/**
 * DentalSleepSolutions\Eloquent\UserSignature
 *
 * @property int $id
 * @property int $user_id
 * @property string $signature_json
 * @property string $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\UserSignature whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\UserSignature whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\UserSignature whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\UserSignature whereSignatureJson($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\UserSignature whereUserId($value)
 */
	class UserSignature extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent{
/**
 * DentalSleepSolutions\Eloquent\Payer
 *
 * @property string $payer_id           Eligible payer unique identifier.
 * @property array $names               Available names of a payer.
 * @property array $supported_endpoints Eligible endpoints supported by a payer.
 */
	class Payer extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent{
/**
 * DentalSleepSolutions\Eloquent\Admin
 *
 * @property int $adminid
 * @property string $name
 * @property string $username
 * @property string $password
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $salt
 * @property string $recover_hash
 * @property string $recover_time
 * @property int $admin_access
 * @property string $last_accessed_date
 * @property int $claim_margin_top
 * @property int $claim_margin_left
 * @property string $email
 * @property string $first_name
 * @property string $last_name
 * @property-read \DentalSleepSolutions\Eloquent\AdminCompany $adminCompany
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Admin whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Admin whereAdminAccess($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Admin whereAdminid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Admin whereClaimMarginLeft($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Admin whereClaimMarginTop($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Admin whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Admin whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Admin whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Admin whereLastAccessedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Admin whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Admin whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Admin wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Admin whereRecoverHash($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Admin whereRecoverTime($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Admin whereSalt($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Admin whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Admin whereUsername($value)
 */
	class Admin extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\GuideDeviceSetting
 *
 * @property int $id
 * @property int $device_id
 * @property int $setting_id
 * @property int $value
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideDeviceSetting whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideDeviceSetting whereDeviceId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideDeviceSetting whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideDeviceSetting whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideDeviceSetting whereSettingId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideDeviceSetting whereValue($value)
 */
	class GuideDeviceSetting extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\FaxErrorCode
 *
 * @property int $id
 * @property string $error_code
 * @property string $description
 * @property string $resolution
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\FaxErrorCode whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\FaxErrorCode whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\FaxErrorCode whereErrorCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\FaxErrorCode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\FaxErrorCode whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\FaxErrorCode whereResolution($value)
 */
	class FaxErrorCode extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\PatientInsurance
 *
 * @property int $id
 * @property int $patientid
 * @property int $insurancetype
 * @property string $company
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $phone
 * @property string $fax
 * @property string $email
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereAddress1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereAddress2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereCompany($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereInsurancetype($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientInsurance whereZip($value)
 */
	class PatientInsurance extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Mandible
 *
 * @property int $mandibleid
 * @property string $mandible
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Mandible whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Mandible whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Mandible whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Mandible whereMandible($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Mandible whereMandibleid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Mandible whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Mandible whereStatus($value)
 */
	class Mandible extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Charge
 *
 * @property int $id
 * @property float $amount
 * @property int $userid
 * @property int $adminid
 * @property string $charge_date
 * @property string $stripe_customer
 * @property string $stripe_charge
 * @property string $stripe_card_fingerprint
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property int $invoice_id
 * @property int $status
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereAdminid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereChargeDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereInvoiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereStripeCardFingerprint($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereStripeCharge($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereStripeCustomer($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Charge whereUserid($value)
 */
	class Charge extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Medicament
 *
 * @property int $medicationsid
 * @property string $medications
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Medicament whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Medicament whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Medicament whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Medicament whereMedications($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Medicament whereMedicationsid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Medicament whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Medicament whereStatus($value)
 */
	class Medicament extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\PreviousTreatment
 *
 * @property int $q_page2id
 * @property int $formid
 * @property int $patientid
 * @property int $polysomnographic
 * @property string $sleep_center_name
 * @property string $sleep_study_on
 * @property string $confirmed_diagnosis
 * @property string $rdi
 * @property string $ahi
 * @property string $cpap
 * @property string $intolerance
 * @property string $other_intolerance
 * @property string $other_therapy
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $other
 * @property string $affidavit
 * @property string $type_study
 * @property string $nights_wear_cpap
 * @property string $percent_night_cpap
 * @property string $custom_diagnosis
 * @property string $sleep_study_by
 * @property string $triedquittried
 * @property string $timesovertime
 * @property string $cur_cpap
 * @property string $sleep_center_name_text
 * @property string $dd_wearing
 * @property string $dd_prev
 * @property string $dd_otc
 * @property string $dd_fab
 * @property string $dd_who
 * @property string $dd_experience
 * @property string $surgery
 * @property int $parent_patientid
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereAffidavit($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereAhi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereConfirmedDiagnosis($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereCpap($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereCurCpap($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereCustomDiagnosis($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereDdExperience($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereDdFab($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereDdOtc($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereDdPrev($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereDdWearing($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereDdWho($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereIntolerance($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereNightsWearCpap($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereOther($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereOtherIntolerance($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereOtherTherapy($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereParentPatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment wherePercentNightCpap($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment wherePolysomnographic($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereQPage2id($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereRdi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereSleepCenterName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereSleepCenterNameText($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereSleepStudyBy($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereSleepStudyOn($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereSurgery($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereTimesovertime($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereTriedquittried($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereTypeStudy($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PreviousTreatment whereUserid($value)
 */
	class PreviousTreatment extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Recipient
 *
 * @property int $q_recipientsid
 * @property int $formid
 * @property int $patientid
 * @property string $referring_physician
 * @property string $dentist
 * @property string $physicians_other
 * @property string $patient_info
 * @property string $q_file1
 * @property string $q_file2
 * @property string $q_file3
 * @property string $q_file4
 * @property string $q_file5
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $q_file6
 * @property string $q_file7
 * @property string $q_file8
 * @property string $q_file9
 * @property string $q_file10
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereDentist($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient wherePatientInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient wherePhysiciansOther($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile10($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile7($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile8($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQFile9($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereQRecipientsid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereReferringPhysician($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Recipient whereUserid($value)
 */
	class Recipient extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\ImageType
 *
 * @property int $imagetypeid
 * @property string $imagetype
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ImageType whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ImageType whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ImageType whereImagetype($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ImageType whereImagetypeid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ImageType whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ImageType whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ImageType whereStatus($value)
 */
	class ImageType extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Calendar
 *
 * @property int $id
 * @property string $start_date
 * @property string $end_date
 * @property string $description
 * @property int $event_id
 * @property int $docid
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $category
 * @property int $producer_id
 * @property int $patientid
 * @property string $rec_type
 * @property int $event_length
 * @property int $event_pid
 * @property int $res_id
 * @property string $rec_pattern
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Calendar whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Calendar whereCategory($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Calendar whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Calendar whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Calendar whereEndDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Calendar whereEventId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Calendar whereEventLength($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Calendar whereEventPid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Calendar whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Calendar whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Calendar wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Calendar whereProducerId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Calendar whereRecPattern($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Calendar whereRecType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Calendar whereResId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Calendar whereStartDate($value)
 */
	class Calendar extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Allergen
 *
 * @property int $allergensid
 * @property string $allergens
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Allergen whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Allergen whereAllergens($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Allergen whereAllergensid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Allergen whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Allergen whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Allergen whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Allergen whereStatus($value)
 */
	class Allergen extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\ScreenerEpworth
 *
 * @property int $id
 * @property int $screener_id
 * @property int $epworth_id
 * @property bool $response
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ScreenerEpworth whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ScreenerEpworth whereEpworthId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ScreenerEpworth whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ScreenerEpworth whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ScreenerEpworth whereResponse($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ScreenerEpworth whereScreenerId($value)
 */
	class ScreenerEpworth extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice
 *
 * @property int $id
 * @property int $invoice_id
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 * @property float $amount
 * @property string $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice whereEndDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice whereInvoiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\EnrollmentInvoice whereStartDate($value)
 */
	class EnrollmentInvoice extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory
 *
 * @property int $paymentid
 * @property int $payer
 * @property float $amount
 * @property int $payment_type
 * @property \Carbon\Carbon $payment_date
 * @property \Carbon\Carbon $entry_date
 * @property int $ledgerid
 * @property float $allowed
 * @property float $ins_paid
 * @property float $deductible
 * @property float $copay
 * @property float $coins
 * @property float $overpaid
 * @property \Carbon\Carbon $followup
 * @property string $note
 * @property float $amount_allowed
 * @property int $updated_by_user
 * @property int $updated_by_admin
 * @property \Carbon\Carbon $updated_at
 * @property int $id
 * @property bool $is_secondary
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereAllowed($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereAmountAllowed($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereCoins($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereCopay($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereDeductible($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereEntryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereFollowup($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereInsPaid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereIsSecondary($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereLedgerid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereOverpaid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory wherePayer($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory wherePaymentDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory wherePaymentType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory wherePaymentid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereUpdatedByAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereUpdatedByUser($value)
 */
	class LedgerPaymentHistory extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\ChangeList
 *
 * @property int $id
 * @property string $content
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ChangeList whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ChangeList whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ChangeList whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ChangeList whereIpAddress($value)
 */
	class ChangeList extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Letter
 *
 * @property int $letterid
 * @property int $patientid
 * @property int $stepid
 * @property \Carbon\Carbon $generated_date
 * @property \Carbon\Carbon $delivery_date
 * @property string $send_method
 * @property string $template
 * @property string $pdf_path
 * @property bool $status
 * @property bool $delivered
 * @property bool $deleted
 * @property int $templateid
 * @property int $parentid
 * @property bool $topatient
 * @property string $md_list
 * @property string $md_referral_list
 * @property int $docid
 * @property int $userid
 * @property \Carbon\Carbon $date_sent
 * @property int $info_id
 * @property int $edit_userid
 * @property \Carbon\Carbon $edit_date
 * @property \Carbon\Carbon $mailed_date
 * @property bool $mailed_once
 * @property bool $template_type
 * @property bool $cc_topatient
 * @property string $cc_md_list
 * @property string $cc_md_referral_list
 * @property string $font_family
 * @property int $font_size
 * @property string $pat_referral_list
 * @property string $cc_pat_referral_list
 * @property int $deleted_by
 * @property \Carbon\Carbon $deleted_on
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter delivered()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter nonDeleted()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter nonDelivered()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter patientTreatmentComplete()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter pending()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereCcMdList($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereCcMdReferralList($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereCcPatReferralList($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereCcTopatient($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereDateSent($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereDeleted($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereDeletedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereDeletedOn($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereDelivered($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereDeliveryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereEditDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereEditUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereFontFamily($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereFontSize($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereGeneratedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereInfoId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereLetterid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereMailedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereMailedOnce($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereMdList($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereMdReferralList($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereParentid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter wherePatReferralList($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter wherePdfPath($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereSendMethod($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereStepid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereTemplate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereTemplateType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereTemplateid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereTopatient($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Letter whereUserid($value)
 */
	class Letter extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\InsuranceType
 *
 * @property int $ins_typeid
 * @property string $ins_type
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceType whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceType whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceType whereInsType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceType whereInsTypeid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceType whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceType whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceType whereStatus($value)
 */
	class InsuranceType extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\UserCompany
 *
 * @property int $id
 * @property int $userid
 * @property int $companyid
 * @property string $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\UserCompany whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\UserCompany whereCompanyid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\UserCompany whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\UserCompany whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\UserCompany whereUserid($value)
 */
	class UserCompany extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate
 *
 * @property int $id
 * @property string $name
 * @property string $body
 * @property int $docid
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property bool $status
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate whereStatus($value)
 */
	class CustomLetterTemplate extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory
 *
 * @property int $id
 * @property int $insuranceid
 * @property int $status
 * @property int $userid
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property int $adminid
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory whereAdminid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory whereInsuranceid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceStatusHistory whereUserid($value)
 */
	class InsuranceStatusHistory extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Symptom
 *
 * @property int $q_page1id
 * @property int $formid
 * @property int $patientid
 * @property string $member_no
 * @property string $group_no
 * @property string $plan_no
 * @property string $primary_care_physician
 * @property string $feet
 * @property string $inches
 * @property string $weight
 * @property string $bmi
 * @property string $sleep_qual
 * @property string $complaintid
 * @property string $other_complaint
 * @property string $additional_paragraph
 * @property string $energy_level
 * @property string $snoring_sound
 * @property string $wake_night
 * @property string $breathing_night
 * @property string $morning_headaches
 * @property string $hours_sleep
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $quit_breathing
 * @property string $bed_time_partner
 * @property string $sleep_same_room
 * @property string $told_you_snore
 * @property string $main_reason
 * @property string $main_reason_other
 * @property \Carbon\Carbon $exam_date
 * @property string $chief_complaint_text
 * @property string $tss
 * @property string $ess
 * @property int $parent_patientid
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereAdditionalParagraph($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereBedTimePartner($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereBmi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereBreathingNight($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereChiefComplaintText($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereComplaintid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereEnergyLevel($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereEss($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereExamDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereFeet($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereGroupNo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereHoursSleep($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereInches($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereMainReason($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereMainReasonOther($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereMemberNo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereMorningHeadaches($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereOtherComplaint($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereParentPatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom wherePlanNo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom wherePrimaryCarePhysician($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereQPage1id($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereQuitBreathing($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereSleepQual($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereSleepSameRoom($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereSnoringSound($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereToldYouSnore($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereTss($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereWakeNight($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Symptom whereWeight($value)
 */
	class Symptom extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\AppointmentType
 *
 * @property int $id
 * @property string $name
 * @property string $color
 * @property string $classname
 * @property int $docid
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AppointmentType whereClassname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AppointmentType whereColor($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AppointmentType whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AppointmentType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AppointmentType whereName($value)
 */
	class AppointmentType extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\InsuranceDocument
 *
 * @property int $doc_insuranceid
 * @property string $title
 * @property string $description
 * @property string $video_file
 * @property string $doc_file
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $docid
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceDocument whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceDocument whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceDocument whereDocFile($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceDocument whereDocInsuranceid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceDocument whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceDocument whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceDocument whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceDocument whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceDocument whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceDocument whereVideoFile($value)
 */
	class InsuranceDocument extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\HomeSleepTest
 *
 * @property int $id
 * @property int $doc_id
 * @property int $user_id
 * @property int $company_id
 * @property int $patient_id
 * @property int $screener_id
 * @property int $ins_co_id
 * @property string $ins_phone
 * @property string $patient_ins_group_id
 * @property string $patient_ins_id
 * @property string $patient_firstname
 * @property string $patient_lastname
 * @property string $patient_add1
 * @property string $patient_add2
 * @property string $patient_city
 * @property string $patient_state
 * @property string $patient_zip
 * @property \Carbon\Carbon $patient_dob
 * @property string $patient_cell_phone
 * @property string $patient_home_phone
 * @property string $patient_email
 * @property int $diagnosis_id
 * @property int $hst_type
 * @property string $provider_firstname
 * @property string $provider_lastname
 * @property string $provider_phone
 * @property string $provider_address
 * @property string $provider_city
 * @property string $provider_state
 * @property string $provider_zip
 * @property string $provider_signature
 * @property \Carbon\Carbon $provider_date
 * @property bool $snore_1
 * @property bool $snore_2
 * @property bool $snore_3
 * @property bool $snore_4
 * @property bool $snore_5
 * @property bool $viewed
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $office_notes
 * @property int $sleep_study_id
 * @property int $authorized_id
 * @property \Carbon\Carbon $authorizeddate
 * @property \Carbon\Carbon $updatedate
 * @property string $rejected_reason
 * @property \Carbon\Carbon $rejecteddate
 * @property int $canceled_id
 * @property \Carbon\Carbon $canceled_date
 * @property int $hst_nights
 * @property string $hst_positions
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest base($docId = 0)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest completed()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest orPending()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest orRejected()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest orScheduled()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest rejected()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest requested()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereAuthorizedId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereAuthorizeddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereCanceledDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereCanceledId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereDiagnosisId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereDocId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereHstNights($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereHstPositions($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereHstType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereInsCoId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereInsPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereOfficeNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientAdd1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientAdd2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientCellPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientDob($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientHomePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientInsGroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientInsId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientZip($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderSignature($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderZip($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereRejectedReason($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereRejecteddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereScreenerId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereSleepStudyId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereSnore1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereSnore2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereSnore3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereSnore4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereSnore5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereUpdatedate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereViewed($value)
 */
	class HomeSleepTest extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Notification
 *
 * @property int $id
 * @property int $patientid
 * @property int $docid
 * @property string $notification
 * @property string $notification_type
 * @property int $status
 * @property string $notification_date
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Notification whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Notification whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Notification whereNotification($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Notification whereNotificationDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Notification whereNotificationType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Notification wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Notification whereStatus($value)
 */
	class Notification extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Joint
 *
 * @property int $jointid
 * @property string $joint
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Joint whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Joint whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Joint whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Joint whereJoint($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Joint whereJointid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Joint whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Joint whereStatus($value)
 */
	class Joint extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Screener
 *
 * @property int $id
 * @property int $docid
 * @property int $userid
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property bool $epworth_reading
 * @property bool $epworth_public
 * @property bool $epworth_passenger
 * @property bool $epworth_lying
 * @property bool $epworth_talking
 * @property bool $epworth_lunch
 * @property bool $epworth_traffic
 * @property bool $snore_1
 * @property bool $snore_2
 * @property bool $snore_3
 * @property bool $snore_4
 * @property bool $snore_5
 * @property bool $breathing
 * @property bool $driving
 * @property bool $gasping
 * @property bool $sleepy
 * @property bool $snore
 * @property bool $weight_gain
 * @property bool $blood_pressure
 * @property bool $jerk
 * @property bool $burning
 * @property bool $headaches
 * @property bool $falling_asleep
 * @property bool $staying_asleep
 * @property bool $rx_blood_pressure
 * @property bool $rx_hypertension
 * @property bool $rx_heart_disease
 * @property bool $rx_stroke
 * @property bool $rx_apnea
 * @property bool $rx_diabetes
 * @property bool $rx_lung_disease
 * @property bool $rx_insomnia
 * @property bool $rx_depression
 * @property bool $rx_narcolepsy
 * @property bool $rx_medication
 * @property bool $rx_restless_leg
 * @property bool $rx_headaches
 * @property bool $rx_heartburn
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property bool $rx_cpap
 * @property string $phone
 * @property bool $contacted
 * @property int $patient_id
 * @property bool $rx_metabolic_syndrome
 * @property bool $rx_obesity
 * @property bool $rx_afib
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereBloodPressure($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereBreathing($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereBurning($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereContacted($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereDriving($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereEpworthLunch($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereEpworthLying($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereEpworthPassenger($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereEpworthPublic($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereEpworthReading($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereEpworthTalking($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereEpworthTraffic($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereFallingAsleep($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereGasping($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereHeadaches($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereJerk($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener wherePatientId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxAfib($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxApnea($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxBloodPressure($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxCpap($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxDepression($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxDiabetes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxHeadaches($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxHeartDisease($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxHeartburn($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxHypertension($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxInsomnia($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxLungDisease($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxMedication($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxMetabolicSyndrome($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxNarcolepsy($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxObesity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxRestlessLeg($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereRxStroke($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereSleepy($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereSnore($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereSnore1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereSnore2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereSnore3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereSnore4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereSnore5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereStayingAsleep($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Screener whereWeightGain($value)
 */
	class Screener extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\JointExam
 *
 * @property int $joint_examid
 * @property string $joint_exam
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\JointExam whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\JointExam whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\JointExam whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\JointExam whereJointExam($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\JointExam whereJointExamid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\JointExam whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\JointExam whereStatus($value)
 */
	class JointExam extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Task
 *
 * @property int $id
 * @property string $task
 * @property string $description
 * @property int $userid
 * @property int $responsibleid
 * @property int $status
 * @property string $due_date
 * @property int $recurring
 * @property bool $recurring_unit
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property int $patientid
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task forPatient()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task future()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task later()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task nextWeek()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task overdue()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task thisWeek()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task today()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task tomorrow()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereDueDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereRecurring($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereRecurringUnit($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereResponsibleid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereTask($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Task whereUserid($value)
 */
	class Task extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\DocumentCategory
 *
 * @property int $categoryid
 * @property string $name
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DocumentCategory active()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DocumentCategory whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DocumentCategory whereCategoryid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DocumentCategory whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DocumentCategory whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DocumentCategory whereStatus($value)
 */
	class DocumentCategory extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Location
 *
 * @property int $id
 * @property string $location
 * @property int $docid
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $name
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $phone
 * @property string $fax
 * @property bool $default_location
 * @property string $email
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Location whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Location whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Location whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Location whereDefaultLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Location whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Location whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Location whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Location whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Location whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Location whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Location whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Location wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Location whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Location whereZip($value)
 */
	class Location extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\GagReflex
 *
 * @property int $gag_reflexid
 * @property string $gag_reflex
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GagReflex whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GagReflex whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GagReflex whereGagReflex($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GagReflex whereGagReflexid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GagReflex whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GagReflex whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GagReflex whereStatus($value)
 */
	class GagReflex extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\SupportTicket
 *
 * @property int $id
 * @property string $title
 * @property int $userid
 * @property int $docid
 * @property string $body
 * @property int $category_id
 * @property \Carbon\Carbon $adddate
 * @property bool $status
 * @property string $ip_address
 * @property string $attachment
 * @property bool $viewed
 * @property int $creator_id
 * @property bool $create_type
 * @property int $company_id
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereAttachment($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereCreateType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereCreatorId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SupportTicket whereViewed($value)
 */
	class SupportTicket extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Summary
 *
 * @property int $summaryid
 * @property int $formid
 * @property int $patientid
 * @property string $patient_name
 * @property string $patient_dob
 * @property string $docpcp
 * @property string $docsmd
 * @property string $docomd1
 * @property string $docomd2
 * @property string $docdds
 * @property string $osite
 * @property string $referral_source
 * @property string $reason_seeking_tx
 * @property string $symptoms_osa
 * @property string $bed_time_partner
 * @property string $snoring
 * @property string $apnea
 * @property string $history_surgery
 * @property string $tried_cpap
 * @property int $cpap_totalnights
 * @property string $fna
 * @property string $cpap_date
 * @property string $problem_cpap
 * @property string $wearing_cpap
 * @property string $max_translation_from
 * @property string $max_translation_to
 * @property string $max_translation_equal
 * @property string $initial_device_titration_1
 * @property string $initial_device_titration_equal_h
 * @property string $initial_device_titration_equal_v
 * @property string $optimum_echovision_ver
 * @property string $optimum_echovision_hor
 * @property string $type_device
 * @property string $personal
 * @property string $lab_name
 * @property string $sti_test_1
 * @property string $sti_test_2
 * @property string $sti_test_3
 * @property string $sti_test_4
 * @property string $sti_date_1
 * @property string $sti_date_2
 * @property string $sti_date_3
 * @property string $sti_date_4
 * @property string $sti_ahi_1
 * @property string $sti_ahi_2
 * @property string $sti_ahi_3
 * @property string $sti_ahi_4
 * @property string $sti_rdi_1
 * @property string $sti_rdi_2
 * @property string $sti_rdi_3
 * @property string $sti_rdi_4
 * @property string $sti_supine_ahi_1
 * @property string $sti_supine_ahi_2
 * @property string $sti_supine_ahi_3
 * @property string $sti_supine_ahi_4
 * @property string $sti_supine_rdi_1
 * @property string $sti_supine_rdi_2
 * @property string $sti_supine_rdi_3
 * @property string $sti_supine_rdi_4
 * @property string $sti_lsat_1
 * @property string $sti_lsat_2
 * @property string $sti_lsat_3
 * @property string $sti_lsat_4
 * @property string $sti_titration_1
 * @property string $sti_titration_2
 * @property string $sti_titration_3
 * @property string $sti_titration_4
 * @property string $sti_cpap_p_1
 * @property string $sti_cpap_p_2
 * @property string $sti_cpap_p_3
 * @property string $sti_cpap_p_4
 * @property string $sti_apnea_1
 * @property string $sti_apnea_2
 * @property string $sti_apnea_3
 * @property string $sti_apnea_4
 * @property string $ep_date_1
 * @property string $ep_date_2
 * @property string $ep_date_3
 * @property string $ep_date_4
 * @property string $ep_date_5
 * @property string $dset1
 * @property string $dset2
 * @property string $dset3
 * @property string $dset4
 * @property string $dset5
 * @property string $ep_e_1
 * @property string $ep_e_2
 * @property string $ep_e_3
 * @property string $ep_e_4
 * @property string $ep_e_5
 * @property string $ep_s_1
 * @property string $ep_s_2
 * @property string $ep_s_3
 * @property string $ep_s_4
 * @property string $ep_s_5
 * @property string $ep_w_1
 * @property string $ep_w_2
 * @property string $ep_w_3
 * @property string $ep_w_4
 * @property string $ep_w_5
 * @property string $ep_a_1
 * @property string $ep_a_2
 * @property string $ep_a_3
 * @property string $ep_a_4
 * @property string $ep_a_5
 * @property string $ep_el_1
 * @property string $ep_el_2
 * @property string $ep_el_3
 * @property string $ep_el_4
 * @property string $ep_el_5
 * @property string $ep_h_1
 * @property string $ep_h_2
 * @property string $ep_h_3
 * @property string $ep_h_4
 * @property string $ep_h_5
 * @property string $ep_r_1
 * @property string $ep_r_2
 * @property string $ep_r_3
 * @property string $ep_r_4
 * @property string $ep_r_5
 * @property string $mini_consult
 * @property string $exam_impressions
 * @property string $oa_soap
 * @property string $fm_blue
 * @property string $oa_check_1
 * @property string $oa_check_2
 * @property string $oa_check_3
 * @property string $oa_check_4
 * @property string $oa_check_5
 * @property string $oa_check_6
 * @property string $month_check_1
 * @property string $month_check_2
 * @property string $month_check_3
 * @property string $month_check_4
 * @property string $oa_psg
 * @property string $year_check_1
 * @property string $year_check_2
 * @property string $year_check_3
 * @property string $year_check_4
 * @property string $additional_notes
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $office
 * @property string $sleep_same_room
 * @property string $currently_wearing
 * @property string $what_percentage
 * @property string $how_long
 * @property string $sleep_md
 * @property string $test_type_name
 * @property string $sti_sleep_efficiency_1
 * @property string $sti_sleep_efficiency_2
 * @property string $sti_sleep_efficiency_3
 * @property string $sti_sleep_efficiency_4
 * @property string $sti_rem_ahi_1
 * @property string $sti_rem_ahi_2
 * @property string $sti_rem_ahi_3
 * @property string $sti_rem_ahi_4
 * @property string $sti_o2_1
 * @property string $sti_o2_2
 * @property string $sti_o2_3
 * @property string $sti_o2_4
 * @property string $sti_other_1
 * @property string $sti_other_2
 * @property string $sti_other_3
 * @property string $sti_other_4
 * @property string $ep_ts_1
 * @property string $ep_ts_2
 * @property string $ep_ts_3
 * @property string $ep_ts_4
 * @property string $ep_ts_5
 * @property string $ep_tr_1
 * @property string $ep_tr_2
 * @property string $ep_tr_3
 * @property string $ep_tr_4
 * @property string $ep_tr_5
 * @property string $appt_notes_1
 * @property string $appt_notes_2
 * @property string $appt_notes_3
 * @property string $appt_notes_4
 * @property string $appt_notes_1p3
 * @property string $appt_notes_2p3
 * @property string $appt_notes_3p3
 * @property string $appt_notes_4p3
 * @property string $appt_notes_5p3
 * @property string $wapn1
 * @property string $wapn2
 * @property string $wapn3
 * @property string $wapn4
 * @property string $wapn5
 * @property string $patientphoto
 * @property string $sleep_qual1
 * @property string $sleep_qual2
 * @property string $sleep_qual3
 * @property string $sleep_qual4
 * @property string $sleep_qual5
 * @property int $location
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereAdditionalNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApnea($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes1p3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes2p3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes3p3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes4p3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereApptNotes5p3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereBedTimePartner($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereCpapDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereCpapTotalnights($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereCurrentlyWearing($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDocdds($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDocomd1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDocomd2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDocpcp($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDocsmd($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDset1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDset2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDset3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDset4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereDset5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpA1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpA2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpA3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpA4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpA5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpDate1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpDate2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpDate3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpDate4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpDate5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpE1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpE2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpE3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpE4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpE5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpEl1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpEl2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpEl3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpEl4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpEl5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpH1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpH2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpH3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpH4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpH5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpR1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpR2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpR3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpR4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpR5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpS1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpS2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpS3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpS4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpS5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTr1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTr2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTr3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTr4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTr5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTs1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTs2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTs3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTs4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpTs5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpW1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpW2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpW3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpW4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereEpW5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereExamImpressions($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereFmBlue($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereFna($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereHistorySurgery($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereHowLong($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereInitialDeviceTitration1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereInitialDeviceTitrationEqualH($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereInitialDeviceTitrationEqualV($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereLabName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereLocation($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereMaxTranslationEqual($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereMaxTranslationFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereMaxTranslationTo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereMiniConsult($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereMonthCheck1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereMonthCheck2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereMonthCheck3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereMonthCheck4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOaCheck1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOaCheck2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOaCheck3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOaCheck4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOaCheck5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOaCheck6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOaPsg($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOaSoap($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOffice($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOptimumEchovisionHor($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOptimumEchovisionVer($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereOsite($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary wherePatientDob($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary wherePatientName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary wherePatientphoto($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary wherePersonal($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereProblemCpap($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereReasonSeekingTx($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereReferralSource($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSleepMd($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSleepQual1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSleepQual2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSleepQual3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSleepQual4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSleepQual5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSleepSameRoom($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSnoring($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiAhi1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiAhi2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiAhi3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiAhi4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiApnea1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiApnea2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiApnea3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiApnea4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiCpapP1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiCpapP2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiCpapP3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiCpapP4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiDate1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiDate2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiDate3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiDate4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiLsat1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiLsat2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiLsat3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiLsat4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiO21($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiO22($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiO23($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiO24($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiOther1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiOther2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiOther3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiOther4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiRdi1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiRdi2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiRdi3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiRdi4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiRemAhi1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiRemAhi2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiRemAhi3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiRemAhi4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSleepEfficiency1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSleepEfficiency2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSleepEfficiency3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSleepEfficiency4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSupineAhi1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSupineAhi2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSupineAhi3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSupineAhi4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSupineRdi1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSupineRdi2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSupineRdi3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiSupineRdi4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiTest1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiTest2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiTest3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiTest4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiTitration1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiTitration2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiTitration3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereStiTitration4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSummaryid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereSymptomsOsa($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereTestTypeName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereTriedCpap($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereTypeDevice($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereWapn1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereWapn2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereWapn3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereWapn4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereWapn5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereWearingCpap($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereWhatPercentage($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereYearCheck1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereYearCheck2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereYearCheck3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Summary whereYearCheck4($value)
 */
	class Summary extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\InsurancePayer
 *
 * @property int $id
 * @property string $name
 * @property string $payer_id
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePayer whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePayer whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePayer whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePayer whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePayer wherePayerId($value)
 */
	class InsurancePayer extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Insurance
 *
 * @property int $insuranceid
 * @property int $formid
 * @property int $patientid
 * @property string $pica1
 * @property string $pica2
 * @property string $pica3
 * @property string $insurance_type
 * @property string $insured_id_number
 * @property string $patient_firstname
 * @property string $patient_lastname
 * @property string $patient_middle
 * @property string $patient_dob
 * @property string $patient_sex
 * @property string $insured_firstname
 * @property string $insured_lastname
 * @property string $insured_middle
 * @property string $patient_address
 * @property string $patient_relation_insured
 * @property string $insured_address
 * @property string $patient_city
 * @property string $patient_state
 * @property string $patient_status
 * @property string $insured_city
 * @property string $insured_state
 * @property string $patient_zip
 * @property string $patient_phone_code
 * @property string $patient_phone
 * @property string $insured_zip
 * @property string $insured_phone_code
 * @property string $insured_phone
 * @property string $other_insured_firstname
 * @property string $other_insured_lastname
 * @property string $other_insured_middle
 * @property string $employment
 * @property string $auto_accident
 * @property string $auto_accident_place
 * @property string $other_accident
 * @property string $insured_policy_group_feca
 * @property string $other_insured_policy_group_feca
 * @property string $insured_dob
 * @property string $insured_sex
 * @property string $other_insured_dob
 * @property string $other_insured_sex
 * @property string $insured_employer_school_name
 * @property string $other_insured_employer_school_name
 * @property string $insured_insurance_plan
 * @property string $other_insured_insurance_plan
 * @property string $reserved_local_use
 * @property string $another_plan
 * @property string $patient_signature
 * @property string $patient_signed_date
 * @property string $insured_signature
 * @property string $date_current
 * @property string $date_same_illness
 * @property string $unable_date_from
 * @property string $unable_date_to
 * @property string $referring_provider
 * @property string $field_17a_dd
 * @property string $field_17a
 * @property string $field_17b
 * @property string $hospitalization_date_from
 * @property string $hospitalization_date_to
 * @property string $reserved_local_use1
 * @property string $outside_lab
 * @property string $s_charges
 * @property string $diagnosis_1
 * @property string $diagnosis_2
 * @property string $diagnosis_3
 * @property string $diagnosis_4
 * @property string $medicaid_resubmission_code
 * @property string $original_ref_no
 * @property string $prior_authorization_number
 * @property string $service_date1_from
 * @property string $service_date1_to
 * @property string $place_of_service1
 * @property string $emg1
 * @property string $cpt_hcpcs1
 * @property string $modifier1_1
 * @property string $modifier1_2
 * @property string $modifier1_3
 * @property string $modifier1_4
 * @property string $diagnosis_pointer1
 * @property string $s_charges1_1
 * @property string $s_charges1_2
 * @property string $days_or_units1
 * @property string $epsdt_family_plan1
 * @property string $id_qua1
 * @property string $rendering_provider_id1
 * @property string $service_date2_from
 * @property string $service_date2_to
 * @property string $place_of_service2
 * @property string $emg2
 * @property string $cpt_hcpcs2
 * @property string $modifier2_1
 * @property string $modifier2_2
 * @property string $modifier2_3
 * @property string $modifier2_4
 * @property string $diagnosis_pointer2
 * @property string $s_charges2_1
 * @property string $s_charges2_2
 * @property string $days_or_units2
 * @property string $epsdt_family_plan2
 * @property string $id_qua2
 * @property string $rendering_provider_id2
 * @property string $service_date3_from
 * @property string $service_date3_to
 * @property string $place_of_service3
 * @property string $emg3
 * @property string $cpt_hcpcs3
 * @property string $modifier3_1
 * @property string $modifier3_2
 * @property string $modifier3_3
 * @property string $modifier3_4
 * @property string $diagnosis_pointer3
 * @property string $s_charges3_1
 * @property string $s_charges3_2
 * @property string $days_or_units3
 * @property string $epsdt_family_plan3
 * @property string $id_qua3
 * @property string $rendering_provider_id3
 * @property string $service_date4_from
 * @property string $service_date4_to
 * @property string $place_of_service4
 * @property string $emg4
 * @property string $cpt_hcpcs4
 * @property string $modifier4_1
 * @property string $modifier4_2
 * @property string $modifier4_3
 * @property string $modifier4_4
 * @property string $diagnosis_pointer4
 * @property string $s_charges4_1
 * @property string $s_charges4_2
 * @property string $days_or_units4
 * @property string $epsdt_family_plan4
 * @property string $id_qua4
 * @property string $rendering_provider_id4
 * @property string $service_date5_from
 * @property string $service_date5_to
 * @property string $place_of_service5
 * @property string $emg5
 * @property string $cpt_hcpcs5
 * @property string $modifier5_1
 * @property string $modifier5_2
 * @property string $modifier5_3
 * @property string $modifier5_4
 * @property string $diagnosis_pointer5
 * @property string $s_charges5_1
 * @property string $s_charges5_2
 * @property string $days_or_units5
 * @property string $epsdt_family_plan5
 * @property string $id_qua5
 * @property string $rendering_provider_id5
 * @property string $service_date6_from
 * @property string $service_date6_to
 * @property string $place_of_service6
 * @property string $emg6
 * @property string $cpt_hcpcs6
 * @property string $modifier6_1
 * @property string $modifier6_2
 * @property string $modifier6_3
 * @property string $modifier6_4
 * @property string $diagnosis_pointer6
 * @property string $s_charges6_1
 * @property string $s_charges6_2
 * @property string $days_or_units6
 * @property string $epsdt_family_plan6
 * @property string $id_qua6
 * @property string $rendering_provider_id6
 * @property string $federal_tax_id_number
 * @property string $ssn
 * @property string $ein
 * @property string $patient_account_no
 * @property string $accept_assignment
 * @property string $total_charge
 * @property string $amount_paid
 * @property string $balance_due
 * @property string $signature_physician
 * @property string $physician_signed_date
 * @property string $service_facility_info_name
 * @property string $service_facility_info_address
 * @property string $service_facility_info_city
 * @property string $service_info_a
 * @property string $service_info_dd
 * @property string $service_info_b_other
 * @property string $billing_provider_phone_code
 * @property string $billing_provider_phone
 * @property string $billing_provider_name
 * @property string $billing_provider_address
 * @property string $billing_provider_city
 * @property string $billing_provider_a
 * @property string $billing_provider_dd
 * @property string $billing_provider_b_other
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property bool $card
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $dispute_reason
 * @property string $sec_dispute_reason
 * @property string $reject_reason
 * @property string $primary_fdf
 * @property string $secondary_fdf
 * @property int $producer
 * @property \Carbon\Carbon $mailed_date
 * @property string $eligible_response
 * @property string $p_m_eligible_payer_id
 * @property string $p_m_eligible_payer_name
 * @property \Carbon\Carbon $sec_mailed_date
 * @property bool $other_insurance_type
 * @property string $patient_relation_other_insured
 * @property int $p_m_billing_id
 * @property bool $p_m_dss_file
 * @property int $s_m_billing_id
 * @property bool $s_m_dss_file
 * @property string $other_insured_address
 * @property string $other_insured_city
 * @property string $other_insured_state
 * @property string $other_insured_zip
 * @property string $eligible_token
 * @property \Carbon\Carbon $percase_date
 * @property string $percase_name
 * @property float $percase_amount
 * @property bool $percase_status
 * @property int $percase_invoice
 * @property int $primary_claim_id
 * @property bool $fo_paid_viewed
 * @property bool $bo_paid_viewed
 * @property bool $closed_by_office_type
 * @property string $s_m_eligible_payer_id
 * @property string $s_m_eligible_payer_name
 * @property string $other_insured_id_number
 * @property bool $primary_claim_version
 * @property bool $secondary_claim_version
 * @property string $nucc_8a
 * @property string $nucc_8b
 * @property string $nucc_9a
 * @property string $nucc_9b
 * @property string $nucc_9c
 * @property string $nucc_10d
 * @property string $nucc_30
 * @property string $claim_codes
 * @property string $other_claim_id
 * @property bool $icd_ind
 * @property string $name_referring_provider_qualifier
 * @property string $diagnosis_a
 * @property string $diagnosis_b
 * @property string $diagnosis_c
 * @property string $diagnosis_d
 * @property string $diagnosis_e
 * @property string $diagnosis_f
 * @property string $diagnosis_g
 * @property string $diagnosis_h
 * @property string $diagnosis_i
 * @property string $diagnosis_j
 * @property string $diagnosis_k
 * @property string $diagnosis_l
 * @property string $current_qual
 * @property string $same_illness_qual
 * @property string $resubmission_code
 * @property bool $resubmission_code_fill
 * @property string $responsibility_sequence
 * @property string $rendering_provider_entity_1
 * @property string $rendering_provider_first_name_1
 * @property string $rendering_provider_last_name_1
 * @property string $rendering_provider_org_1
 * @property string $rendering_provider_npi_1
 * @property string $rendering_provider_entity_2
 * @property string $rendering_provider_first_name_2
 * @property string $rendering_provider_last_name_2
 * @property string $rendering_provider_org_2
 * @property string $rendering_provider_npi_2
 * @property string $rendering_provider_entity_3
 * @property string $rendering_provider_first_name_3
 * @property string $rendering_provider_last_name_3
 * @property string $rendering_provider_org_3
 * @property string $rendering_provider_npi_3
 * @property string $rendering_provider_entity_4
 * @property string $rendering_provider_first_name_4
 * @property string $rendering_provider_last_name_4
 * @property string $rendering_provider_org_4
 * @property string $rendering_provider_npi_4
 * @property string $rendering_provider_entity_5
 * @property string $rendering_provider_first_name_5
 * @property string $rendering_provider_last_name_5
 * @property string $rendering_provider_org_5
 * @property string $rendering_provider_npi_5
 * @property string $rendering_provider_entity_6
 * @property string $rendering_provider_first_name_6
 * @property string $rendering_provider_last_name_6
 * @property string $rendering_provider_org_6
 * @property string $rendering_provider_npi_6
 * @property string $payer_id
 * @property string $payer_name
 * @property string $payer_address
 * @property string $payer_city
 * @property string $payer_state
 * @property string $payer_zip
 * @property string $billing_provider_taxonomy_code
 * @property string $other_insured_insurance_type
 * @property string $claim_info_code
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance countFrontOfficeClaims($docId = 0)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance filedByBackOfficeConditional($claimAlias = 'claim')
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance rejected()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereAcceptAssignment($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereAmountPaid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereAnotherPlan($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereAutoAccident($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereAutoAccidentPlace($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBalanceDue($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderA($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderBOther($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderDd($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderPhoneCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBillingProviderTaxonomyCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereBoPaidViewed($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereCard($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereClaimCodes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereClaimInfoCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereClosedByOfficeType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereCptHcpcs1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereCptHcpcs2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereCptHcpcs3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereCptHcpcs4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereCptHcpcs5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereCptHcpcs6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereCurrentQual($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDateCurrent($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDateSameIllness($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDaysOrUnits1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDaysOrUnits2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDaysOrUnits3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDaysOrUnits4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDaysOrUnits5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDaysOrUnits6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosis1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosis2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosis3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosis4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisA($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisB($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisC($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisD($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisE($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisF($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisG($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisH($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisI($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisJ($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisK($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisL($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisPointer1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisPointer2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisPointer3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisPointer4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisPointer5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDiagnosisPointer6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDisputeReason($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEin($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEligibleResponse($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEligibleToken($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEmg1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEmg2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEmg3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEmg4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEmg5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEmg6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEmployment($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEpsdtFamilyPlan1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEpsdtFamilyPlan2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEpsdtFamilyPlan3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEpsdtFamilyPlan4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEpsdtFamilyPlan5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereEpsdtFamilyPlan6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereFederalTaxIdNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereField17a($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereField17aDd($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereField17b($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereFoPaidViewed($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereHospitalizationDateFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereHospitalizationDateTo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereIcdInd($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereIdQua1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereIdQua2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereIdQua3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereIdQua4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereIdQua5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereIdQua6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuranceType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuranceid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredDob($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredEmployerSchoolName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredIdNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredInsurancePlan($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredMiddle($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredPhoneCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredPolicyGroupFeca($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredSex($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredSignature($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereInsuredZip($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereMailedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereMedicaidResubmissionCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier11($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier12($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier13($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier14($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier21($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier22($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier23($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier24($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier31($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier32($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier33($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier34($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier41($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier42($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier43($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier44($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier51($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier52($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier53($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier54($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier61($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier62($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier63($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereModifier64($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereNameReferringProviderQualifier($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereNucc10d($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereNucc30($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereNucc8a($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereNucc8b($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereNucc9a($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereNucc9b($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereNucc9c($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOriginalRefNo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherAccident($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherClaimId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuranceType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredDob($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredEmployerSchoolName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredIdNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredInsurancePlan($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredInsuranceType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredMiddle($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredPolicyGroupFeca($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredSex($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOtherInsuredZip($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereOutsideLab($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePMBillingId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePMDssFile($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePMEligiblePayerId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePMEligiblePayerName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientAccountNo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientDob($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientMiddle($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientPhoneCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientRelationInsured($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientRelationOtherInsured($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientSex($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientSignature($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientSignedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientZip($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePayerAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePayerCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePayerId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePayerName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePayerState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePayerZip($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePercaseAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePercaseDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePercaseInvoice($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePercaseName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePercaseStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePhysicianSignedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePica1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePica2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePica3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePlaceOfService1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePlaceOfService2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePlaceOfService3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePlaceOfService4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePlaceOfService5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePlaceOfService6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePrimaryClaimId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePrimaryClaimVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePrimaryFdf($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance wherePriorAuthorizationNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereProducer($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereReferringProvider($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRejectReason($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderEntity1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderEntity2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderEntity3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderEntity4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderEntity5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderEntity6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderFirstName1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderFirstName2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderFirstName3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderFirstName4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderFirstName5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderFirstName6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderId1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderId2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderId3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderId4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderId5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderId6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderLastName1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderLastName2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderLastName3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderLastName4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderLastName5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderLastName6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderNpi1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderNpi2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderNpi3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderNpi4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderNpi5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderNpi6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderOrg1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderOrg2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderOrg3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderOrg4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderOrg5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereRenderingProviderOrg6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereReservedLocalUse($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereReservedLocalUse1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereResponsibilitySequence($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereResubmissionCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereResubmissionCodeFill($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges11($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges12($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges21($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges22($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges31($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges32($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges41($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges42($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges51($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges52($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges61($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSCharges62($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSMBillingId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSMDssFile($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSMEligiblePayerId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSMEligiblePayerName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSameIllnessQual($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSecDisputeReason($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSecMailedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSecondaryClaimVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSecondaryFdf($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate1From($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate1To($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate2From($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate2To($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate3From($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate3To($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate4From($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate4To($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate5From($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate5To($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate6From($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceDate6To($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceFacilityInfoAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceFacilityInfoCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceFacilityInfoName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceInfoA($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceInfoBOther($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereServiceInfoDd($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSignaturePhysician($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereSsn($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereTotalCharge($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereUnableDateFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereUnableDateTo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Insurance whereUserid($value)
 */
	class Insurance extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\CorporateContact
 *
 * @property int $contactid
 * @property int $docid
 * @property string $salutation
 * @property string $lastname
 * @property string $firstname
 * @property string $middlename
 * @property string $company
 * @property string $add1
 * @property string $add2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $phone1
 * @property string $phone2
 * @property string $fax
 * @property string $email
 * @property string $greeting
 * @property string $sincerely
 * @property int $contacttypeid
 * @property string $notes
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereAdd1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereAdd2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereCompany($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereContactid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereContacttypeid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereGreeting($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereMiddlename($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact wherePhone1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact wherePhone2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereSalutation($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereSincerely($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CorporateContact whereZip($value)
 */
	class CorporateContact extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\LedgerHistory
 *
 * @property int $ledgerid
 * @property int $formid
 * @property int $patientid
 * @property string $service_date
 * @property string $entry_date
 * @property string $description
 * @property string $producer
 * @property float $amount
 * @property string $transaction_type
 * @property float $paid_amount
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property string $adddate
 * @property string $ip_address
 * @property string $transaction_code
 * @property string $placeofservice
 * @property string $emg
 * @property string $diagnosispointer
 * @property string $daysorunits
 * @property string $epsdt
 * @property string $idqual
 * @property string $modcode
 * @property int $producerid
 * @property int $primary_claim_id
 * @property string $primary_paper_claim_id
 * @property string $modcode2
 * @property string $modcode3
 * @property string $modcode4
 * @property \Carbon\Carbon $percase_date
 * @property string $percase_name
 * @property float $percase_amount
 * @property bool $percase_status
 * @property int $percase_invoice
 * @property bool $percase_free
 * @property int $updated_by_user
 * @property int $updated_by_admin
 * @property int $primary_claim_history_id
 * @property \Carbon\Carbon $updated_at
 * @property int $id
 * @property int $secondary_claim_id
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereDaysorunits($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereDiagnosispointer($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereEmg($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereEntryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereEpsdt($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereIdqual($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereLedgerid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereModcode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereModcode2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereModcode3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereModcode4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePaidAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePercaseAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePercaseDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePercaseFree($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePercaseInvoice($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePercaseName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePercaseStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePlaceofservice($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePrimaryClaimHistoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePrimaryClaimId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory wherePrimaryPaperClaimId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereProducer($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereProducerid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereSecondaryClaimId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereServiceDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereTransactionCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereTransactionType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereUpdatedByAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereUpdatedByUser($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerHistory whereUserid($value)
 */
	class LedgerHistory extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam
 *
 * @property int $ex_page4id
 * @property int $formid
 * @property int $patientid
 * @property string $exam_teeth
 * @property string $other_exam_teeth
 * @property string $caries
 * @property string $where_facets
 * @property string $cracked_fractured
 * @property string $old_worn_inadequate_restorations
 * @property string $dental_class_right
 * @property string $dental_division_right
 * @property string $dental_class_left
 * @property string $dental_division_left
 * @property string $additional_paragraph
 * @property string $initial_tooth
 * @property string $open_proximal
 * @property string $deistema
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $missing
 * @property string $crossbite
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereAdditionalParagraph($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereCaries($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereCrackedFractured($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereCrossbite($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereDeistema($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereDentalClassLeft($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereDentalClassRight($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereDentalDivisionLeft($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereDentalDivisionRight($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereExPage4id($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereExamTeeth($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereInitialTooth($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereMissing($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereOldWornInadequateRestorations($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereOpenProximal($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereOtherExamTeeth($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam whereWhereFacets($value)
 */
	class DentalClinicalExam extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Diagnostic
 *
 * @property int $diagnosticid
 * @property string $diagnostic
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Diagnostic whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Diagnostic whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Diagnostic whereDiagnostic($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Diagnostic whereDiagnosticid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Diagnostic whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Diagnostic whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Diagnostic whereStatus($value)
 */
	class Diagnostic extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\LoginDetail
 *
 * @property int $l_detailid
 * @property int $loginid
 * @property int $userid
 * @property string $cur_page
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LoginDetail whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LoginDetail whereCurPage($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LoginDetail whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LoginDetail whereLDetailid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LoginDetail whereLoginid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LoginDetail whereUserid($value)
 */
	class LoginDetail extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Intolerance
 *
 * @property int $intoleranceid
 * @property string $intolerance
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Intolerance whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Intolerance whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Intolerance whereIntolerance($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Intolerance whereIntoleranceid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Intolerance whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Intolerance whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Intolerance whereStatus($value)
 */
	class Intolerance extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\SleepTest
 *
 * @property int $q_sleepid
 * @property int $formid
 * @property int $patientid
 * @property string $epworthid
 * @property string $analysis
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property int $parent_patientid
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepTest whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepTest whereAnalysis($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepTest whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepTest whereEpworthid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepTest whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepTest whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepTest whereParentPatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepTest wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepTest whereQSleepid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepTest whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepTest whereUserid($value)
 */
	class SleepTest extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Device
 *
 * @property int $deviceid
 * @property string $device
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $image_path
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Device whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Device whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Device whereDevice($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Device whereDeviceid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Device whereImagePath($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Device whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Device whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Device whereStatus($value)
 */
	class Device extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Chair
 *
 * @property int $id
 * @property string $name
 * @property int $rank
 * @property int $docid
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Chair whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Chair whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Chair whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Chair whereRank($value)
 */
	class Chair extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\LedgerRecord
 *
 * @property int $ledgerid
 * @property int $formid
 * @property int $patientid
 * @property string $service_date
 * @property string $entry_date
 * @property string $description
 * @property string $producer
 * @property float $amount
 * @property string $transaction_type
 * @property float $paid_amount
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property string $adddate
 * @property string $ip_address
 * @property string $transaction_code
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereEntryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereLedgerid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord wherePaidAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereProducer($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereServiceDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereTransactionCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereTransactionType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereUserid($value)
 */
	class LedgerRecord extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\InsuranceFile
 *
 * @property int $id
 * @property int $claimid
 * @property string $claimtype
 * @property string $filename
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $description
 * @property int $status
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceFile whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceFile whereClaimid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceFile whereClaimtype($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceFile whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceFile whereFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceFile whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceFile whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceFile whereStatus($value)
 */
	class InsuranceFile extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\GuideDevice
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property-read \Illuminate\Database\Eloquent\Collection|\DentalSleepSolutions\Eloquent\Dental\GuideDeviceSetting[] $deviceSettings
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideDevice whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideDevice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideDevice whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideDevice whereName($value)
 */
	class GuideDevice extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\PaymentReport
 *
 * @property int $payment_id
 * @property int $claimid
 * @property string $reference_id
 * @property string $response
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property int $viewed
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PaymentReport whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PaymentReport whereClaimid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PaymentReport whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PaymentReport wherePaymentId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PaymentReport whereReferenceId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PaymentReport whereResponse($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PaymentReport whereViewed($value)
 */
	class PaymentReport extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\InsDiagnosis
 *
 * @property int $ins_diagnosisid
 * @property string $ins_diagnosis
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsDiagnosis whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsDiagnosis whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsDiagnosis whereInsDiagnosis($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsDiagnosis whereInsDiagnosisid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsDiagnosis whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsDiagnosis whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsDiagnosis whereStatus($value)
 */
	class InsDiagnosis extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation
 *
 * @property int $ex_page3id
 * @property int $formid
 * @property int $patientid
 * @property string $maxilla
 * @property string $other_maxilla
 * @property string $mandible
 * @property string $other_mandible
 * @property string $soft_palate
 * @property string $other_soft_palate
 * @property string $uvula
 * @property string $other_uvula
 * @property string $gag_reflex
 * @property string $other_gag_reflex
 * @property string $nasal_passages
 * @property string $other_nasal_passages
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereExPage3id($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereGagReflex($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereMandible($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereMaxilla($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereNasalPassages($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereOtherGagReflex($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereOtherMandible($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereOtherMaxilla($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereOtherNasalPassages($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereOtherSoftPalate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereOtherUvula($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereSoftPalate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation whereUvula($value)
 */
	class AirwayEvaluation extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\ReferredByContact
 *
 * @property int $referredbyid
 * @property int $docid
 * @property string $salutation
 * @property string $lastname
 * @property string $firstname
 * @property string $middlename
 * @property string $company
 * @property string $add1
 * @property string $add2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $phone1
 * @property string $phone2
 * @property string $fax
 * @property string $email
 * @property string $national_provider_id
 * @property string $qualifier
 * @property string $qualifierid
 * @property string $greeting
 * @property string $sincerely
 * @property int $contacttypeid
 * @property string $notes
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $preferredcontact
 * @property int $referredby_info
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereAdd1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereAdd2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereCompany($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereContacttypeid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereGreeting($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereMiddlename($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereNationalProviderId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact wherePhone1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact wherePhone2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact wherePreferredcontact($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereQualifier($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereQualifierid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereReferredbyInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereReferredbyid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereSalutation($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereSincerely($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ReferredByContact whereZip($value)
 */
	class ReferredByContact extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Procedure
 *
 * @property int $procedureid
 * @property int $patientid
 * @property int $insuranceid
 * @property string $service_date_from
 * @property string $service_date_to
 * @property string $place_service
 * @property string $type_service
 * @property string $cpt_code
 * @property string $units
 * @property string $charge
 * @property string $total_charge
 * @property string $applies_icd
 * @property string $npi
 * @property string $other_id
 * @property string $other_id_qualifier
 * @property string $modifier_code_1
 * @property string $modifier_code_2
 * @property string $modifier_code_3
 * @property string $modifier_code_4
 * @property string $epsdt
 * @property string $emg
 * @property string $supplemental_info
 * @property int $docid
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereAppliesIcd($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereCharge($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereCptCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereEmg($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereEpsdt($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereInsuranceid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereModifierCode1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereModifierCode2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereModifierCode3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereModifierCode4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereNpi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereOtherId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereOtherIdQualifier($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure wherePlaceService($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereProcedureid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereServiceDateFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereServiceDateTo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereSupplementalInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereTotalCharge($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereTypeService($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Procedure whereUnits($value)
 */
	class Procedure extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\TransactionCode
 *
 * @property int $transaction_codeid
 * @property string $transaction_code
 * @property string $description
 * @property string $type
 * @property int $sortby
 * @property int $status
 * @property string $adddate
 * @property string $ip_address
 * @property int $default_code
 * @property int $docid
 * @property float $amount
 * @property int $place
 * @property string $modifier_code_1
 * @property string $modifier_code_2
 * @property string $days_units
 * @property bool $amount_adjust
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereAmountAdjust($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereDaysUnits($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereDefaultCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereModifierCode1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereModifierCode2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode wherePlace($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereTransactionCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereTransactionCodeid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereType($value)
 */
	class TransactionCode extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\CustomText
 *
 * @property int $customid
 * @property string $title
 * @property string $description
 * @property int $docid
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property int $default_text
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomText whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomText whereCustomid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomText whereDefaultText($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomText whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomText whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomText whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomText whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomText whereTitle($value)
 */
	class CustomText extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam
 *
 * @property int $ex_page1id
 * @property int $formid
 * @property int $patientid
 * @property string $blood_pressure
 * @property string $pulse
 * @property string $neck_measurement
 * @property string $bmi
 * @property string $additional_paragraph
 * @property string $tongue
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam whereAdditionalParagraph($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam whereBloodPressure($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam whereBmi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam whereExPage1id($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam whereNeckMeasurement($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam wherePulse($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam whereTongue($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam whereUserid($value)
 */
	class TongueClinicalExam extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Contact
 *
 * @property int $contactid
 * @property int $docid
 * @property string $salutation
 * @property string $lastname
 * @property string $firstname
 * @property string $middlename
 * @property string $company
 * @property string $add1
 * @property string $add2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $phone1
 * @property string $phone2
 * @property string $fax
 * @property string $email
 * @property string $national_provider_id
 * @property string $qualifier
 * @property string $qualifierid
 * @property string $greeting
 * @property string $sincerely
 * @property int $contacttypeid
 * @property string $notes
 * @property string $preferredcontact
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property int $referredby_info
 * @property string $referredby_notes
 * @property int $merge_id
 * @property string $merge_date
 * @property bool $corporate
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact active()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereAdd1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereAdd2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereCompany($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereContactid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereContacttypeid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereCorporate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereGreeting($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereMergeDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereMergeId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereMiddlename($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereNationalProviderId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact wherePhone1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact wherePhone2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact wherePreferredcontact($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereQualifier($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereQualifierid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereReferredbyInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereReferredbyNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereSalutation($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereSincerely($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Contact whereZip($value)
 */
	class Contact extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\LedgerNote
 *
 * @property int $id
 * @property int $producerid
 * @property string $note
 * @property int $private
 * @property \Carbon\Carbon $service_date
 * @property \Carbon\Carbon $entry_date
 * @property int $patientid
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property int $docid
 * @property int $admin_producerid
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereAdminProducerid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereEntryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote wherePrivate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereProducerid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerNote whereServiceDate($value)
 */
	class LedgerNote extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\EpworthSleepinessScale
 *
 * @property int $epworthid
 * @property string $epworth
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\EpworthSleepinessScale whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\EpworthSleepinessScale whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\EpworthSleepinessScale whereEpworth($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\EpworthSleepinessScale whereEpworthid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\EpworthSleepinessScale whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\EpworthSleepinessScale whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\EpworthSleepinessScale whereStatus($value)
 */
	class EpworthSleepinessScale extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\ClaimNoteAttachment
 *
 * @property int $id
 * @property int $note_id
 * @property string $filename
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimNoteAttachment whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimNoteAttachment whereFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimNoteAttachment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimNoteAttachment whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimNoteAttachment whereNoteId($value)
 */
	class ClaimNoteAttachment extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Fax
 *
 * @property int $id
 * @property int $patientid
 * @property int $userid
 * @property int $docid
 * @property \Carbon\Carbon $sent_date
 * @property int $pages
 * @property int $contactid
 * @property string $to_number
 * @property string $to_name
 * @property int $letterid
 * @property string $filename
 * @property bool $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property int $fax_invoice_id
 * @property string $sfax_transmission_id
 * @property bool $sfax_completed
 * @property string $sfax_response
 * @property bool $sfax_status
 * @property string $sfax_error_code
 * @property string $letter_body
 * @property bool $viewed
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereContactid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereFaxInvoiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereLetterBody($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereLetterid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax wherePages($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereSentDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereSfaxCompleted($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereSfaxErrorCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereSfaxResponse($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereSfaxStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereSfaxTransmissionId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereToName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereToNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Fax whereViewed($value)
 */
	class Fax extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\GuideSettingOption
 *
 * @property int $id
 * @property int $option_id
 * @property int $setting_id
 * @property string $label
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSettingOption whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSettingOption whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSettingOption whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSettingOption whereLabel($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSettingOption whereOptionId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSettingOption whereSettingId($value)
 */
	class GuideSettingOption extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\InsurancePreauth
 *
 * @property int $id
 * @property int $doc_id
 * @property int $patient_id
 * @property string $ins_co
 * @property string $ins_rank
 * @property string $ins_phone
 * @property string $patient_ins_group_id
 * @property string $patient_ins_id
 * @property string $patient_firstname
 * @property string $patient_lastname
 * @property string $patient_add1
 * @property string $patient_add2
 * @property string $patient_city
 * @property string $patient_state
 * @property string $patient_zip
 * @property string $patient_dob
 * @property string $insured_first_name
 * @property string $insured_last_name
 * @property string $insured_dob
 * @property string $doc_npi
 * @property string $referring_doc_npi
 * @property float $trxn_code_amount
 * @property string $diagnosis_code
 * @property string $date_of_call
 * @property string $insurance_rep
 * @property string $call_reference_num
 * @property string $doc_medicare_npi
 * @property string $doc_tax_id_or_ssn
 * @property string $ins_effective_date
 * @property string $ins_cal_year_start
 * @property string $ins_cal_year_end
 * @property int $trxn_code_covered
 * @property string $code_covered_notes
 * @property int $has_out_of_network_benefits
 * @property int $out_of_network_percentage
 * @property int $is_hmo
 * @property string $hmo_date_called
 * @property string $hmo_date_received
 * @property int $hmo_needs_auth
 * @property string $hmo_auth_date_requested
 * @property string $hmo_auth_date_received
 * @property string $hmo_auth_notes
 * @property int $in_network_percentage
 * @property string $in_network_appeal_date_sent
 * @property string $in_network_appeal_date_received
 * @property int $is_pre_auth_required
 * @property string $verbal_pre_auth_name
 * @property string $verbal_pre_auth_ref_num
 * @property string $verbal_pre_auth_notes
 * @property string $written_pre_auth_notes
 * @property string $written_pre_auth_date_received
 * @property string $front_office_request_date
 * @property int $status
 * @property float $patient_deductible
 * @property float $patient_amount_met
 * @property float $family_deductible
 * @property float $family_amount_met
 * @property string $deductible_reset_date
 * @property int $out_of_pocket_met
 * @property float $patient_amount_left_to_meet
 * @property float $expected_insurance_payment
 * @property float $expected_patient_payment
 * @property int $network_benefits
 * @property int $viewed
 * @property string $date_completed
 * @property int $userid
 * @property string $how_often
 * @property string $patient_phone
 * @property string $pre_auth_num
 * @property float $family_amount_left_to_meet
 * @property int $deductible_from
 * @property string $reject_reason
 * @property string $invoice_date
 * @property float $invoice_amount
 * @property bool $invoice_status
 * @property int $invoice_id
 * @property \Carbon\Carbon $updated_at
 * @property int $updated_by
 * @property string $doc_name
 * @property string $doc_practice
 * @property string $doc_address
 * @property string $doc_phone
 * @property int $in_deductible_from
 * @property float $in_patient_deductible
 * @property float $in_patient_amount_met
 * @property float $in_patient_amount_left_to_meet
 * @property float $in_family_deductible
 * @property float $in_family_amount_met
 * @property float $in_family_amount_left_to_meet
 * @property string $in_deductible_reset_date
 * @property int $in_out_of_pocket_met
 * @property float $in_expected_insurance_payment
 * @property float $in_expected_patient_payment
 * @property string $in_call_reference_num
 * @property int $has_in_network_benefits
 * @property int $in_is_pre_auth_required
 * @property string $in_verbal_pre_auth_name
 * @property string $in_verbal_pre_auth_ref_num
 * @property string $in_verbal_pre_auth_notes
 * @property string $in_written_pre_auth_date_received
 * @property string $in_pre_auth_num
 * @property string $in_written_pre_auth_notes
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth basedPreauth($docId = 0)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth completed()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth pending()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth rejected()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereCallReferenceNum($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereCodeCoveredNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDateCompleted($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDateOfCall($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDeductibleFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDeductibleResetDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDiagnosisCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDocAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDocId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDocMedicareNpi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDocName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDocNpi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDocPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDocPractice($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereDocTaxIdOrSsn($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereExpectedInsurancePayment($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereExpectedPatientPayment($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereFamilyAmountLeftToMeet($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereFamilyAmountMet($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereFamilyDeductible($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereFrontOfficeRequestDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHasInNetworkBenefits($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHasOutOfNetworkBenefits($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHmoAuthDateReceived($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHmoAuthDateRequested($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHmoAuthNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHmoDateCalled($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHmoDateReceived($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHmoNeedsAuth($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereHowOften($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInCallReferenceNum($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInDeductibleFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInDeductibleResetDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInExpectedInsurancePayment($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInExpectedPatientPayment($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInFamilyAmountLeftToMeet($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInFamilyAmountMet($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInFamilyDeductible($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInIsPreAuthRequired($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInNetworkAppealDateReceived($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInNetworkAppealDateSent($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInNetworkPercentage($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInOutOfPocketMet($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInPatientAmountLeftToMeet($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInPatientAmountMet($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInPatientDeductible($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInPreAuthNum($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInVerbalPreAuthName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInVerbalPreAuthNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInVerbalPreAuthRefNum($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInWrittenPreAuthDateReceived($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInWrittenPreAuthNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsCalYearEnd($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsCalYearStart($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsCo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsEffectiveDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsRank($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsuranceRep($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsuredDob($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsuredFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInsuredLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInvoiceAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInvoiceDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInvoiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereInvoiceStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereIsHmo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereIsPreAuthRequired($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereNetworkBenefits($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereOutOfNetworkPercentage($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereOutOfPocketMet($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientAdd1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientAdd2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientAmountLeftToMeet($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientAmountMet($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientDeductible($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientDob($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientInsGroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientInsId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePatientZip($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth wherePreAuthNum($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereReferringDocNpi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereRejectReason($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereTrxnCodeAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereTrxnCodeCovered($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereUpdatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereVerbalPreAuthName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereVerbalPreAuthNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereVerbalPreAuthRefNum($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereViewed($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereWrittenPreAuthDateReceived($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsurancePreauth whereWrittenPreAuthNotes($value)
 */
	class InsurancePreauth extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\LetterTemplate
 *
 * @property int $id
 * @property string $name
 * @property string $template
 * @property string $body
 * @property bool $default_letter
 * @property int $companyid
 * @property int $triggerid
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LetterTemplate whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LetterTemplate whereCompanyid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LetterTemplate whereDefaultLetter($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LetterTemplate whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LetterTemplate whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LetterTemplate whereTemplate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LetterTemplate whereTriggerid($value)
 */
	class LetterTemplate extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Palpation
 *
 * @property int $palpationid
 * @property string $palpation
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Palpation whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Palpation whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Palpation whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Palpation wherePalpation($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Palpation wherePalpationid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Palpation whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Palpation whereStatus($value)
 */
	class Palpation extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Note
 *
 * @property int $notesid
 * @property int $patientid
 * @property string $notes
 * @property int $edited
 * @property string $editor_initials
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $procedure_date
 * @property string $ip_address
 * @property int $signed_id
 * @property \Carbon\Carbon $signed_on
 * @property int $parentid
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereEdited($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereEditorInitials($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereNotesid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereParentid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Note wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereProcedureDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereSignedId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereSignedOn($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Note whereUserid($value)
 */
	class Note extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Sleeplab
 *
 * @property int $sleeplabid
 * @property int $docid
 * @property string $salutation
 * @property string $lastname
 * @property string $firstname
 * @property string $middlename
 * @property string $company
 * @property string $add1
 * @property string $add2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $phone1
 * @property string $phone2
 * @property string $fax
 * @property string $email
 * @property string $greeting
 * @property string $sincerely
 * @property string $notes
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereAdd1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereAdd2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereCompany($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereGreeting($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereMiddlename($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab wherePhone1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab wherePhone2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereSalutation($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereSincerely($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereSleeplabid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereZip($value)
 */
	class Sleeplab extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\PercaseInvoice
 *
 * @property int $id
 * @property int $adminid
 * @property int $docid
 * @property string $adddate
 * @property string $ip_address
 * @property string $monthly_fee_date
 * @property float $monthly_fee_amount
 * @property bool $status
 * @property string $due_date
 * @property int $companyid
 * @property string $user_fee_date
 * @property float $user_fee_amount
 * @property string $producer_fee_date
 * @property float $producer_fee_amount
 * @property string $user_fee_desc
 * @property string $producer_fee_desc
 * @property bool $invoice_type
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereAdminid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereCompanyid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereDueDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereInvoiceType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereMonthlyFeeAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereMonthlyFeeDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereProducerFeeAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereProducerFeeDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereProducerFeeDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereUserFeeAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereUserFeeDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PercaseInvoice whereUserFeeDesc($value)
 */
	class PercaseInvoice extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\AccessCode
 *
 * @property int $id
 * @property string $access_code
 * @property string $notes
 * @property bool $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property int $plan_id
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AccessCode whereAccessCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AccessCode whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AccessCode whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AccessCode whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AccessCode whereNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AccessCode wherePlanId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\AccessCode whereStatus($value)
 */
	class AccessCode extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\GuideSetting
 *
 * @property int $id
 * @property string $name
 * @property bool $setting_type
 * @property int $range_start
 * @property int $range_end
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property int $rank
 * @property \Illuminate\Database\Eloquent\Collection|\DentalSleepSolutions\Eloquent\Dental\GuideSettingOption[] $options
 * @property string $range_start_label
 * @property string $range_end_label
 * @property-read \Illuminate\Database\Eloquent\Collection|\DentalSleepSolutions\Eloquent\Dental\GuideDeviceSetting[] $deviceSettings
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereOptions($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereRangeEnd($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereRangeEndLabel($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereRangeStart($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereRangeStartLabel($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereRank($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\GuideSetting whereSettingType($value)
 */
	class GuideSetting extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\PatientContact
 *
 * @property int $id
 * @property int $contacttype
 * @property int $patientid
 * @property string $firstname
 * @property string $lastname
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $phone
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereAddress1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereAddress2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereContacttype($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientContact whereZip($value)
 */
	class PatientContact extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\ContactType
 *
 * @property int $contacttypeid
 * @property string $contacttype
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property bool $physician
 * @property bool $corporate
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType active()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType nonCorporate()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType physician()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType whereContacttype($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType whereContacttypeid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType whereCorporate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType wherePhysician($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ContactType whereStatus($value)
 */
	class ContactType extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\ProfileImage
 *
 * @property int $imageid
 * @property int $formid
 * @property int $patientid
 * @property string $title
 * @property string $image_file
 * @property int $imagetypeid
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property int $adminid
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage insuranceCardImage()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage profilePhoto()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereAdminid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereImageFile($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereImageid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereImagetypeid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereUserid($value)
 */
	class ProfileImage extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam
 *
 * @property int $ex_page2id
 * @property int $formid
 * @property int $patientid
 * @property string $mallampati
 * @property string $tonsils
 * @property string $tonsils_grade
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $additional_notes
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereAdditionalNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereExPage2id($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereMallampati($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereTonsils($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereTonsilsGrade($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam whereUserid($value)
 */
	class TonsilsClinicalExam extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\ClaimElectronic
 *
 * @property int $id
 * @property int $claimid
 * @property string $response
 * @property string $adddate
 * @property string $ip_address
 * @property string $reference_id
 * @property string $percase_date
 * @property string $percase_name
 * @property float $percase_amount
 * @property bool $percase_status
 * @property int $percase_invoice
 * @property bool $percase_free
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic whereClaimid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic wherePercaseAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic wherePercaseDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic wherePercaseFree($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic wherePercaseInvoice($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic wherePercaseName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic wherePercaseStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic whereReferenceId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\ClaimElectronic whereResponse($value)
 */
	class ClaimElectronic extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Plan
 *
 * @property int $id
 * @property string $name
 * @property float $monthly_fee
 * @property int $trial_period
 * @property float $fax_fee
 * @property int $free_fax
 * @property bool $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property float $eligibility_fee
 * @property int $free_eligibility
 * @property float $enrollment_fee
 * @property int $free_enrollment
 * @property float $claim_fee
 * @property int $free_claim
 * @property float $vob_fee
 * @property int $free_vob
 * @property bool $office_type
 * @property float $efile_fee
 * @property int $free_efile
 * @property int $duration
 * @property float $producer_fee
 * @property float $user_fee
 * @property float $patient_fee
 * @property bool $e0486_bill
 * @property float $e0486_fee
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereClaimFee($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereDuration($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereE0486Bill($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereE0486Fee($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereEfileFee($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereEligibilityFee($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereEnrollmentFee($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereFaxFee($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereFreeClaim($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereFreeEfile($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereFreeEligibility($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereFreeEnrollment($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereFreeFax($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereFreeVob($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereMonthlyFee($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereOfficeType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan wherePatientFee($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereProducerFee($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereTrialPeriod($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereUserFee($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Plan whereVobFee($value)
 */
	class Plan extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\PatientSummary
 *
 * @property int $pid
 * @property int $fspage1_complete
 * @property string $next_visit
 * @property string $last_visit
 * @property string $last_treatment
 * @property int $appliance
 * @property string $delivery_date
 * @property string $vob
 * @property float $ledger
 * @property int $patient_info
 * @property string $tracker_notes
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientSummary whereAppliance($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientSummary whereDeliveryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientSummary whereFspage1Complete($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientSummary whereLastTreatment($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientSummary whereLastVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientSummary whereLedger($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientSummary whereNextVisit($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientSummary wherePatientInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientSummary wherePid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientSummary whereTrackerNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PatientSummary whereVob($value)
 */
	class PatientSummary extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Qualifier
 *
 * @property int $qualifierid
 * @property string $qualifier
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Qualifier active()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Qualifier whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Qualifier whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Qualifier whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Qualifier whereQualifier($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Qualifier whereQualifierid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Qualifier whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Qualifier whereStatus($value)
 */
	class Qualifier extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Login
 *
 * @property int $loginid
 * @property int $docid
 * @property int $userid
 * @property string $login_date
 * @property string $logout_date
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Login whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Login whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Login whereLoginDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Login whereLoginid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Login whereLogoutDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Login whereUserid($value)
 */
	class Login extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\LedgerStatement
 *
 * @property int $id
 * @property int $producerid
 * @property string $filename
 * @property string $service_date
 * @property string $entry_date
 * @property int $patientid
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerStatement whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerStatement whereEntryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerStatement whereFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerStatement whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerStatement whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerStatement wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerStatement whereProducerid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerStatement whereServiceDate($value)
 */
	class LedgerStatement extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Complaint
 *
 * @property int $complaintid
 * @property string $complaint
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Complaint whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Complaint whereComplaint($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Complaint whereComplaintid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Complaint whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Complaint whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Complaint whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Complaint whereStatus($value)
 */
	class Complaint extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\SleepStudy
 *
 * @property int $id
 * @property string $testnumber
 * @property string $docid
 * @property string $patientid
 * @property string $needed
 * @property string $scheddate
 * @property string $sleeplabwheresched
 * @property string $completed
 * @property string $interpolation
 * @property string $labtype
 * @property string $copyreqdate
 * @property string $sleeplab
 * @property string $scanext
 * @property string $date
 * @property string $filename
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereCompleted($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereCopyreqdate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereInterpolation($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereLabtype($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereNeeded($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereScanext($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereScheddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereSleeplab($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereSleeplabwheresched($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereTestnumber($value)
 */
	class SleepStudy extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\SummSleeplab
 *
 * @property int $id
 * @property string $date
 * @property string $sleeptesttype
 * @property string $place
 * @property string $apnea
 * @property string $hypopnea
 * @property string $ahi
 * @property string $ahisupine
 * @property string $rdi
 * @property string $rdisupine
 * @property string $o2nadir
 * @property string $t9002
 * @property string $sleepefficiency
 * @property string $cpaplevel
 * @property string $dentaldevice
 * @property string $devicesetting
 * @property string $diagnosis
 * @property string $notes
 * @property string $patiendid
 * @property string $filename
 * @property string $testnumber
 * @property string $needed
 * @property string $scheddate
 * @property string $completed
 * @property string $interpolation
 * @property string $copyreqdate
 * @property string $sleeplab
 * @property string $diagnosising_doc
 * @property string $diagnosising_npi
 * @property int $image_id
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereAhi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereAhisupine($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereApnea($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereCompleted($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereCopyreqdate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereCpaplevel($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereDentaldevice($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereDevicesetting($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereDiagnosis($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereDiagnosisingDoc($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereDiagnosisingNpi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereHypopnea($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereImageId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereInterpolation($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereNeeded($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereO2nadir($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab wherePatiendid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab wherePlace($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereRdi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereRdisupine($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereScheddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereSleepefficiency($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereSleeplab($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereSleeptesttype($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereT9002($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereTestnumber($value)
 */
	class SummSleeplab extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Patient
 *
 * @property int $patientid
 * @property string $lastname
 * @property string $firstname
 * @property string $middlename
 * @property string $salutation
 * @property string $member_no
 * @property string $group_no
 * @property string $plan_no
 * @property string $dob
 * @property string $add1
 * @property string $add2
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $gender
 * @property string $marital_status
 * @property string $ssn
 * @property string $internal_patient
 * @property string $home_phone
 * @property string $work_phone
 * @property string $cell_phone
 * @property string $email
 * @property string $patient_notes
 * @property string $alert_text
 * @property int $display_alert
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $p_d_party
 * @property string $p_d_relation
 * @property string $p_d_other
 * @property string $p_d_employer
 * @property string $p_d_ins_co
 * @property string $p_d_ins_id
 * @property string $s_d_party
 * @property string $s_d_relation
 * @property string $s_d_other
 * @property string $s_d_employer
 * @property string $s_d_ins_co
 * @property string $s_d_ins_id
 * @property string $p_m_partyfname
 * @property string $p_m_partymname
 * @property string $p_m_partylname
 * @property string $p_m_relation
 * @property string $p_m_other
 * @property string $p_m_employer
 * @property string $p_m_ins_co
 * @property string $p_m_ins_id
 * @property string $s_m_partyfname
 * @property string $s_m_partymname
 * @property string $s_m_partylname
 * @property string $s_m_relation
 * @property string $s_m_other
 * @property string $s_m_employer
 * @property string $s_m_ins_co
 * @property string $s_m_ins_id
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
 * @property string $employer
 * @property string $emp_add1
 * @property string $emp_add2
 * @property string $emp_city
 * @property string $emp_state
 * @property string $emp_zip
 * @property string $emp_phone
 * @property string $emp_fax
 * @property string $plan_name
 * @property string $group_number
 * @property string $ins_type
 * @property string $accept_assignment
 * @property string $print_signature
 * @property string $medical_insurance
 * @property string $mark_yes
 * @property string $inactive
 * @property string $partner_name
 * @property string $emergency_name
 * @property string $emergency_number
 * @property string $referred_source
 * @property string $referred_by
 * @property bool $premedcheck
 * @property string $premed
 * @property string $docsleep
 * @property string $docpcp
 * @property string $docdentist
 * @property string $docent
 * @property string $docmdother
 * @property string $preferredcontact
 * @property string $copyreqdate
 * @property string $best_time
 * @property string $best_number
 * @property string $emergency_relationship
 * @property string $has_s_m_ins
 * @property string $referred_notes
 * @property string $login
 * @property string $password
 * @property string $salt
 * @property string $recover_hash
 * @property \Carbon\Carbon $recover_time
 * @property bool $registered
 * @property string $access_code
 * @property int $parent_patientid
 * @property string $has_p_m_ins
 * @property int $registration_status
 * @property \Carbon\Carbon $text_date
 * @property int $text_num
 * @property int $use_patient_portal
 * @property \Carbon\Carbon $registration_senton
 * @property string $preferred_name
 * @property string $feet
 * @property string $inches
 * @property string $weight
 * @property string $bmi
 * @property bool $symptoms_status
 * @property bool $sleep_status
 * @property bool $treatments_status
 * @property bool $history_status
 * @property \Carbon\Carbon $access_code_date
 * @property bool $email_bounce
 * @property string $docmdother2
 * @property string $docmdother3
 * @property int $last_reg_sect
 * @property int $access_type
 * @property string $p_m_eligible_id
 * @property string $p_m_eligible_payer_id
 * @property string $p_m_eligible_payer_name
 * @property string $p_m_gender
 * @property string $s_m_gender
 * @property bool $p_m_same_address
 * @property string $p_m_address
 * @property string $p_m_state
 * @property string $p_m_city
 * @property string $p_m_zip
 * @property bool $s_m_same_address
 * @property string $s_m_address
 * @property string $s_m_city
 * @property string $s_m_state
 * @property string $s_m_zip
 * @property \Carbon\Carbon $new_fee_date
 * @property float $new_fee_amount
 * @property string $new_fee_desc
 * @property int $new_fee_invoice_id
 * @property string $s_m_eligible_payer_id
 * @property string $s_m_eligible_payer_name
 * @property-read \DentalSleepSolutions\Eloquent\Dental\AirwayEvaluation $airwayEvaluation
 * @property-read \DentalSleepSolutions\Eloquent\Dental\DentalClinicalExam $dentalClinicalExam
 * @property-read \DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam $tmjClinicalExam
 * @property-read \DentalSleepSolutions\Eloquent\Dental\TongueClinicalExam $tongueClinicalExam
 * @property-read \DentalSleepSolutions\Eloquent\Dental\TonsilsClinicalExam $tonsilsClinicalExam
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient active()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient all()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient inactive()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereAcceptAssignment($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereAccessCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereAccessCodeDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereAccessType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereAdd1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereAdd2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereAlertText($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereBestNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereBestTime($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereBmi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereCellPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereCopyreqdate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDisplayAlert($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDob($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDocdentist($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDocent($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDocmdother($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDocmdother2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDocmdother3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDocpcp($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereDocsleep($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmailBounce($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmergencyName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmergencyNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmergencyRelationship($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmpAdd1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmpAdd2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmpCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmpFax($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmpPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmpState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmpZip($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereEmployer($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereFeet($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereGroupNo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereGroupNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereHasPMIns($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereHasSMIns($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereHistoryStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereHomePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereInactive($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereInches($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereIns2Dob($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereInsDob($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereInsType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereInternalPatient($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereLastRegSect($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereLogin($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereMaritalStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereMarkYes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereMedicalInsurance($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereMemberNo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereMiddlename($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereNewFeeAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereNewFeeDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereNewFeeDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereNewFeeInvoiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePDEmployer($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePDInsCo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePDInsId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePDOther($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePDParty($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePDRelation($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMDssFile($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMEligibleId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMEligiblePayerId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMEligiblePayerName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMEmployer($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMGender($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMInsAss($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMInsCo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMInsGrp($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMInsId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMInsPlan($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMInsType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMOther($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMPartyfname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMPartylname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMPartymname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMRelation($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMSameAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePMZip($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereParentPatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePartnerName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePatientNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePlanName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePlanNo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePreferredName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePreferredcontact($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePremed($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePremedcheck($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient wherePrintSignature($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereRecoverHash($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereRecoverTime($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereReferredBy($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereReferredNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereReferredSource($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereRegistered($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereRegistrationSenton($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereRegistrationStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSDEmployer($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSDInsCo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSDInsId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSDOther($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSDParty($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSDRelation($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMDssFile($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMEligiblePayerId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMEligiblePayerName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMEmployer($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMGender($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMInsAss($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMInsCo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMInsGrp($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMInsId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMInsPlan($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMInsType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMOther($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMPartyfname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMPartylname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMPartymname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMRelation($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMSameAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSMZip($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSalt($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSalutation($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSleepStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSsn($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereSymptomsStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereTextDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereTextNum($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereTreatmentsStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereUsePatientPortal($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereWorkPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Patient whereZip($value)
 */
	class Patient extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\FaxInvoice
 *
 * @property int $id
 * @property int $invoice_id
 * @property string $description
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 * @property float $amount
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\FaxInvoice whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\FaxInvoice whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\FaxInvoice whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\FaxInvoice whereEndDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\FaxInvoice whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\FaxInvoice whereInvoiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\FaxInvoice whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\FaxInvoice whereStartDate($value)
 */
	class FaxInvoice extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Document
 *
 * @property int $documentid
 * @property int $categoryid
 * @property string $name
 * @property string $filename
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property-read \DentalSleepSolutions\Eloquent\Dental\DocumentCategory $category
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Document whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Document whereCategoryid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Document whereDocumentid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Document whereFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Document whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Document whereName($value)
 */
	class Document extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\User
 *
 * @property int $userid
 * @property int $user_access
 * @property int $docid
 * @property string $username
 * @property string $npi
 * @property string $password
 * @property string $name
 * @property string $email
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $phone
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $medicare_npi
 * @property string $tax_id_or_ssn
 * @property int $producer
 * @property string $practice
 * @property string $email_header
 * @property string $email_footer
 * @property string $fax_header
 * @property string $fax_footer
 * @property string $salt
 * @property string $recover_hash
 * @property \Carbon\Carbon $recover_time
 * @property bool $ssn
 * @property bool $ein
 * @property bool $use_patient_portal
 * @property string $mailing_practice
 * @property string $mailing_name
 * @property string $mailing_address
 * @property string $mailing_city
 * @property string $mailing_state
 * @property string $mailing_zip
 * @property string $mailing_phone
 * @property \Carbon\Carbon $last_accessed_date
 * @property bool $use_digital_fax
 * @property string $fax
 * @property bool $use_letters
 * @property bool $sign_notes
 * @property bool $use_eligible_api
 * @property string $access_code
 * @property \Carbon\Carbon $text_date
 * @property int $text_num
 * @property \Carbon\Carbon $access_code_date
 * @property \Carbon\Carbon $registration_email_date
 * @property bool $producer_files
 * @property string $medicare_ptan
 * @property bool $use_course
 * @property bool $use_course_staff
 * @property bool $manage_staff
 * @property string $cc_id
 * @property bool $user_type
 * @property int $letter_margin_header
 * @property int $letter_margin_footer
 * @property int $letter_margin_top
 * @property int $letter_margin_bottom
 * @property int $letter_margin_left
 * @property int $letter_margin_right
 * @property int $claim_margin_top
 * @property int $claim_margin_left
 * @property string $logo
 * @property bool $homepage
 * @property bool $use_letter_header
 * @property int $access_code_id
 * @property string $first_name
 * @property string $last_name
 * @property bool $indent_address
 * @property \Carbon\Carbon $registration_date
 * @property bool $header_space
 * @property int $billing_company_id
 * @property int $edx_id
 * @property int $help_id
 * @property bool $tracker_letters
 * @property bool $intro_letters
 * @property int $plan_id
 * @property string $suspended_reason
 * @property \Carbon\Carbon $suspended_date
 * @property \Carbon\Carbon $updated_at
 * @property string $signature_file
 * @property string $signature_json
 * @property bool $use_service_npi
 * @property string $service_name
 * @property string $service_address
 * @property string $service_city
 * @property string $service_state
 * @property string $service_zip
 * @property string $service_phone
 * @property string $service_fax
 * @property string $service_npi
 * @property string $service_medicare_npi
 * @property string $service_medicare_ptan
 * @property string $service_tax_id_or_ssn
 * @property bool $service_ssn
 * @property bool $service_ein
 * @property bool $eligible_test
 * @property int $billing_plan_id
 * @property bool $post_ledger_adjustments
 * @property bool $edit_ledger_entries
 * @property bool $use_payment_reports
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereAccessCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereAccessCodeDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereAccessCodeId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereBillingCompanyId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereBillingPlanId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereCcId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereClaimMarginLeft($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereClaimMarginTop($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereEditLedgerEntries($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereEdxId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereEin($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereEligibleTest($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereEmailFooter($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereEmailHeader($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereFax($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereFaxFooter($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereFaxHeader($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereHeaderSpace($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereHelpId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereHomepage($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereIndentAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereIntroLetters($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLastAccessedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLetterMarginBottom($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLetterMarginFooter($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLetterMarginHeader($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLetterMarginLeft($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLetterMarginRight($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLetterMarginTop($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereLogo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMailingAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMailingCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMailingName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMailingPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMailingPractice($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMailingState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMailingZip($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereManageStaff($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMedicareNpi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereMedicarePtan($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereNpi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User wherePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User wherePlanId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User wherePostLedgerAdjustments($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User wherePractice($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereProducer($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereProducerFiles($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereRecoverHash($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereRecoverTime($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereRegistrationDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereRegistrationEmailDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereSalt($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceEin($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceFax($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceMedicareNpi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceMedicarePtan($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceNpi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServicePhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceSsn($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceTaxIdOrSsn($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereServiceZip($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereSignNotes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereSignatureFile($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereSignatureJson($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereSsn($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereSuspendedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereSuspendedReason($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereTaxIdOrSsn($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereTextDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereTextNum($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereTrackerLetters($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUseCourse($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUseCourseStaff($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUseDigitalFax($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUseEligibleApi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUseLetterHeader($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUseLetters($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUsePatientPortal($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUsePaymentReports($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUseServiceNpi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUserAccess($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUserType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\User whereZip($value)
 */
	class User extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\PlaceService
 *
 * @property int $place_serviceid
 * @property string $place_service
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PlaceService whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PlaceService whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PlaceService whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PlaceService wherePlaceService($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PlaceService wherePlaceServiceid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PlaceService whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\PlaceService whereStatus($value)
 */
	class PlaceService extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Maxilla
 *
 * @property int $maxillaid
 * @property string $maxilla
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Maxilla whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Maxilla whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Maxilla whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Maxilla whereMaxilla($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Maxilla whereMaxillaid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Maxilla whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Maxilla whereStatus($value)
 */
	class Maxilla extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\LedgerPayment
 *
 * @property int $id
 * @property int $payer
 * @property float $amount
 * @property int $payment_type
 * @property \Carbon\Carbon $payment_date
 * @property \Carbon\Carbon $entry_date
 * @property int $ledgerid
 * @property float $allowed
 * @property float $ins_paid
 * @property float $deductible
 * @property float $copay
 * @property float $coins
 * @property float $overpaid
 * @property \Carbon\Carbon $followup
 * @property string $note
 * @property float $amount_allowed
 * @property bool $is_secondary
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereAllowed($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereAmountAllowed($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereCoins($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereCopay($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereDeductible($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereEntryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereFollowup($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereInsPaid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereIsSecondary($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereLedgerid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereOverpaid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment wherePayer($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment wherePaymentDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment wherePaymentType($value)
 */
	class LedgerPayment extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\HealthHistory
 *
 * @property int $q_page3id
 * @property int $formid
 * @property int $patientid
 * @property string $allergens
 * @property string $other_allergens
 * @property string $medications
 * @property string $other_medications
 * @property string $history
 * @property string $other_history
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $dental_health
 * @property string $removable
 * @property string $year_completed
 * @property string $tmj
 * @property string $gum_problems
 * @property string $dental_pain
 * @property string $dental_pain_describe
 * @property string $completed_future
 * @property string $clinch_grind
 * @property string $wisdom_extraction
 * @property string $injurytohead
 * @property string $injurytoneck
 * @property string $injurytoface
 * @property string $injurytoteeth
 * @property string $injurytomouth
 * @property string $drymouth
 * @property string $jawjointsurgery
 * @property string $no_allergens
 * @property string $no_medications
 * @property string $no_history
 * @property string $orthodontics
 * @property string $wisdom_extraction_text
 * @property string $removable_text
 * @property string $dentures
 * @property string $dentures_text
 * @property string $tmj_cp
 * @property string $tmj_cp_text
 * @property string $tmj_pain
 * @property string $tmj_pain_text
 * @property string $tmj_surgery
 * @property string $tmj_surgery_text
 * @property string $injury
 * @property string $injury_text
 * @property string $gum_prob
 * @property string $gum_prob_text
 * @property string $gum_surgery
 * @property string $gum_surgery_text
 * @property string $clinch_grind_text
 * @property string $future_dental_det
 * @property string $drymouth_text
 * @property string $family_hd
 * @property string $family_bp
 * @property string $family_dia
 * @property string $family_sd
 * @property string $alcohol
 * @property string $sedative
 * @property string $caffeine
 * @property string $smoke
 * @property string $smoke_packs
 * @property string $tobacco
 * @property string $additional_paragraph
 * @property bool $allergenscheck
 * @property bool $medicationscheck
 * @property bool $historycheck
 * @property int $parent_patientid
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereAdditionalParagraph($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereAlcohol($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereAllergens($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereAllergenscheck($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereCaffeine($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereClinchGrind($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereClinchGrindText($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereCompletedFuture($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereDentalHealth($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereDentalPain($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereDentalPainDescribe($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereDentures($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereDenturesText($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereDrymouth($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereDrymouthText($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereFamilyBp($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereFamilyDia($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereFamilyHd($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereFamilySd($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereFutureDentalDet($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereGumProb($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereGumProbText($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereGumProblems($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereGumSurgery($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereGumSurgeryText($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereHistory($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereHistorycheck($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereInjury($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereInjuryText($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereInjurytoface($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereInjurytohead($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereInjurytomouth($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereInjurytoneck($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereInjurytoteeth($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereJawjointsurgery($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereMedications($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereMedicationscheck($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereNoAllergens($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereNoHistory($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereNoMedications($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereOrthodontics($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereOtherAllergens($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereOtherHistory($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereOtherMedications($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereParentPatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereQPage3id($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereRemovable($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereRemovableText($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereSedative($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereSmoke($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereSmokePacks($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereTmj($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereTmjCp($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereTmjCpText($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereTmjPain($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereTmjPainText($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereTmjSurgery($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereTmjSurgeryText($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereTobacco($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereWisdomExtraction($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereWisdomExtractionText($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\HealthHistory whereYearCompleted($value)
 */
	class HealthHistory extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\SocialHistory
 *
 * @property int $q_page4id
 * @property int $formid
 * @property int $patientid
 * @property string $family_had
 * @property string $family_diagnosed
 * @property string $additional_paragraph
 * @property string $alcohol
 * @property string $sedative
 * @property string $caffeine
 * @property string $smoke
 * @property string $smoke_packs
 * @property string $tobacco
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property int $parent_patientid
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory whereAdditionalParagraph($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory whereAlcohol($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory whereCaffeine($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory whereFamilyDiagnosed($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory whereFamilyHad($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory whereParentPatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory whereQPage4id($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory whereSedative($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory whereSmoke($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory whereSmokePacks($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory whereTobacco($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SocialHistory whereUserid($value)
 */
	class SocialHistory extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\MedicalHistory
 *
 * @property int $historyid
 * @property string $history
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\MedicalHistory whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\MedicalHistory whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\MedicalHistory whereHistory($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\MedicalHistory whereHistoryid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\MedicalHistory whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\MedicalHistory whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\MedicalHistory whereStatus($value)
 */
	class MedicalHistory extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam
 *
 * @property int $ex_page5id
 * @property int $formid
 * @property int $patientid
 * @property string $palpationid
 * @property string $palpationRid
 * @property string $additional_paragraph_pal
 * @property string $joint_exam
 * @property string $jointid
 * @property string $i_opening_from
 * @property string $i_opening_to
 * @property string $i_opening_equal
 * @property string $protrusion_from
 * @property string $protrusion_to
 * @property string $protrusion_equal
 * @property string $l_lateral_from
 * @property string $l_lateral_to
 * @property string $l_lateral_equal
 * @property string $r_lateral_from
 * @property string $r_lateral_to
 * @property string $r_lateral_equal
 * @property string $deviation_from
 * @property string $deviation_to
 * @property string $deviation_equal
 * @property string $deflection_from
 * @property string $deflection_to
 * @property string $deflection_equal
 * @property string $range_normal
 * @property string $normal
 * @property string $other_range_motion
 * @property string $additional_paragraph_rm
 * @property string $screening_aware
 * @property string $screening_normal
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $deviation_r_l
 * @property string $deflection_r_l
 * @property int $dentaldevice
 * @property string $dentaldevice_date
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereAdditionalParagraphPal($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereAdditionalParagraphRm($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDeflectionEqual($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDeflectionFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDeflectionRL($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDeflectionTo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDentaldevice($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDentaldeviceDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDeviationEqual($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDeviationFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDeviationRL($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDeviationTo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereExPage5id($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereIOpeningEqual($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereIOpeningFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereIOpeningTo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereJointExam($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereJointid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereLLateralEqual($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereLLateralFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereLLateralTo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereNormal($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereOtherRangeMotion($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam wherePalpationRid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam wherePalpationid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereProtrusionEqual($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereProtrusionFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereProtrusionTo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereRLateralEqual($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereRLateralFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereRLateralTo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereRangeNormal($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereScreeningAware($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereScreeningNormal($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\TmjClinicalExam whereUserid($value)
 */
	class TmjClinicalExam extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Ledger
 *
 * @property int $ledgerid
 * @property int $formid
 * @property int $patientid
 * @property \Carbon\Carbon $service_date
 * @property \Carbon\Carbon $entry_date
 * @property string $description
 * @property string $producer
 * @property float $amount
 * @property string $transaction_type
 * @property float $paid_amount
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property string $adddate
 * @property string $ip_address
 * @property string $transaction_code
 * @property string $placeofservice
 * @property string $emg
 * @property string $diagnosispointer
 * @property string $daysorunits
 * @property string $epsdt
 * @property string $idqual
 * @property string $modcode
 * @property int $producerid
 * @property int $primary_claim_id
 * @property string $primary_paper_claim_id
 * @property string $modcode2
 * @property string $modcode3
 * @property string $modcode4
 * @property \Carbon\Carbon $percase_date
 * @property string $percase_name
 * @property float $percase_amount
 * @property bool $percase_status
 * @property int $percase_invoice
 * @property bool $percase_free
 * @property int $secondary_claim_id
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereDaysorunits($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereDiagnosispointer($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereEmg($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereEntryDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereEpsdt($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereIdqual($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereLedgerid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereModcode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereModcode2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereModcode3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereModcode4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger wherePaidAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger wherePercaseAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger wherePercaseDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger wherePercaseFree($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger wherePercaseInvoice($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger wherePercaseName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger wherePercaseStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger wherePlaceofservice($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger wherePrimaryClaimId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger wherePrimaryPaperClaimId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereProducer($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereProducerid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereSecondaryClaimId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereServiceDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereTransactionCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereTransactionType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Ledger whereUserid($value)
 */
	class Ledger extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\InsuranceHistory
 *
 * @property int $insuranceid
 * @property int $formid
 * @property int $patientid
 * @property string $pica1
 * @property string $pica2
 * @property string $pica3
 * @property string $insurance_type
 * @property string $insured_id_number
 * @property string $patient_firstname
 * @property string $patient_lastname
 * @property string $patient_middle
 * @property string $patient_dob
 * @property string $patient_sex
 * @property string $insured_firstname
 * @property string $insured_lastname
 * @property string $insured_middle
 * @property string $patient_address
 * @property string $patient_relation_insured
 * @property string $insured_address
 * @property string $patient_city
 * @property string $patient_state
 * @property string $patient_status
 * @property string $insured_city
 * @property string $insured_state
 * @property string $patient_zip
 * @property string $patient_phone_code
 * @property string $patient_phone
 * @property string $insured_zip
 * @property string $insured_phone_code
 * @property string $insured_phone
 * @property string $other_insured_firstname
 * @property string $other_insured_lastname
 * @property string $other_insured_middle
 * @property string $employment
 * @property string $auto_accident
 * @property string $auto_accident_place
 * @property string $other_accident
 * @property string $insured_policy_group_feca
 * @property string $other_insured_policy_group_feca
 * @property string $insured_dob
 * @property string $insured_sex
 * @property string $other_insured_dob
 * @property string $other_insured_sex
 * @property string $insured_employer_school_name
 * @property string $other_insured_employer_school_name
 * @property string $insured_insurance_plan
 * @property string $other_insured_insurance_plan
 * @property string $reserved_local_use
 * @property string $another_plan
 * @property string $patient_signature
 * @property string $patient_signed_date
 * @property string $insured_signature
 * @property string $date_current
 * @property string $date_same_illness
 * @property string $unable_date_from
 * @property string $unable_date_to
 * @property string $referring_provider
 * @property string $field_17a_dd
 * @property string $field_17a
 * @property string $field_17b
 * @property string $hospitalization_date_from
 * @property string $hospitalization_date_to
 * @property string $reserved_local_use1
 * @property string $outside_lab
 * @property string $s_charges
 * @property string $diagnosis_1
 * @property string $diagnosis_2
 * @property string $diagnosis_3
 * @property string $diagnosis_4
 * @property string $medicaid_resubmission_code
 * @property string $original_ref_no
 * @property string $prior_authorization_number
 * @property string $service_date1_from
 * @property string $service_date1_to
 * @property string $place_of_service1
 * @property string $emg1
 * @property string $cpt_hcpcs1
 * @property string $modifier1_1
 * @property string $modifier1_2
 * @property string $modifier1_3
 * @property string $modifier1_4
 * @property string $diagnosis_pointer1
 * @property string $s_charges1_1
 * @property string $s_charges1_2
 * @property string $days_or_units1
 * @property string $epsdt_family_plan1
 * @property string $id_qua1
 * @property string $rendering_provider_id1
 * @property string $service_date2_from
 * @property string $service_date2_to
 * @property string $place_of_service2
 * @property string $emg2
 * @property string $cpt_hcpcs2
 * @property string $modifier2_1
 * @property string $modifier2_2
 * @property string $modifier2_3
 * @property string $modifier2_4
 * @property string $diagnosis_pointer2
 * @property string $s_charges2_1
 * @property string $s_charges2_2
 * @property string $days_or_units2
 * @property string $epsdt_family_plan2
 * @property string $id_qua2
 * @property string $rendering_provider_id2
 * @property string $service_date3_from
 * @property string $service_date3_to
 * @property string $place_of_service3
 * @property string $emg3
 * @property string $cpt_hcpcs3
 * @property string $modifier3_1
 * @property string $modifier3_2
 * @property string $modifier3_3
 * @property string $modifier3_4
 * @property string $diagnosis_pointer3
 * @property string $s_charges3_1
 * @property string $s_charges3_2
 * @property string $days_or_units3
 * @property string $epsdt_family_plan3
 * @property string $id_qua3
 * @property string $rendering_provider_id3
 * @property string $service_date4_from
 * @property string $service_date4_to
 * @property string $place_of_service4
 * @property string $emg4
 * @property string $cpt_hcpcs4
 * @property string $modifier4_1
 * @property string $modifier4_2
 * @property string $modifier4_3
 * @property string $modifier4_4
 * @property string $diagnosis_pointer4
 * @property string $s_charges4_1
 * @property string $s_charges4_2
 * @property string $days_or_units4
 * @property string $epsdt_family_plan4
 * @property string $id_qua4
 * @property string $rendering_provider_id4
 * @property string $service_date5_from
 * @property string $service_date5_to
 * @property string $place_of_service5
 * @property string $emg5
 * @property string $cpt_hcpcs5
 * @property string $modifier5_1
 * @property string $modifier5_2
 * @property string $modifier5_3
 * @property string $modifier5_4
 * @property string $diagnosis_pointer5
 * @property string $s_charges5_1
 * @property string $s_charges5_2
 * @property string $days_or_units5
 * @property string $epsdt_family_plan5
 * @property string $id_qua5
 * @property string $rendering_provider_id5
 * @property string $service_date6_from
 * @property string $service_date6_to
 * @property string $place_of_service6
 * @property string $emg6
 * @property string $cpt_hcpcs6
 * @property string $modifier6_1
 * @property string $modifier6_2
 * @property string $modifier6_3
 * @property string $modifier6_4
 * @property string $diagnosis_pointer6
 * @property string $s_charges6_1
 * @property string $s_charges6_2
 * @property string $days_or_units6
 * @property string $epsdt_family_plan6
 * @property string $id_qua6
 * @property string $rendering_provider_id6
 * @property string $federal_tax_id_number
 * @property string $ssn
 * @property string $ein
 * @property string $patient_account_no
 * @property string $accept_assignment
 * @property string $total_charge
 * @property string $amount_paid
 * @property string $balance_due
 * @property string $signature_physician
 * @property string $physician_signed_date
 * @property string $service_facility_info_name
 * @property string $service_facility_info_address
 * @property string $service_facility_info_city
 * @property string $service_info_a
 * @property string $service_info_dd
 * @property string $service_info_b_other
 * @property string $billing_provider_phone_code
 * @property string $billing_provider_phone
 * @property string $billing_provider_name
 * @property string $billing_provider_address
 * @property string $billing_provider_city
 * @property string $billing_provider_a
 * @property string $billing_provider_dd
 * @property string $billing_provider_b_other
 * @property int $userid
 * @property int $docid
 * @property int $status
 * @property bool $card
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property string $dispute_reason
 * @property string $sec_dispute_reason
 * @property string $reject_reason
 * @property string $primary_fdf
 * @property string $secondary_fdf
 * @property int $producer
 * @property \Carbon\Carbon $mailed_date
 * @property string $eligible_response
 * @property string $p_m_eligible_payer_id
 * @property string $p_m_eligible_payer_name
 * @property \Carbon\Carbon $sec_mailed_date
 * @property bool $other_insurance_type
 * @property string $patient_relation_other_insured
 * @property int $p_m_billing_id
 * @property bool $p_m_dss_file
 * @property int $s_m_billing_id
 * @property bool $s_m_dss_file
 * @property string $other_insured_address
 * @property string $other_insured_city
 * @property string $other_insured_state
 * @property string $other_insured_zip
 * @property string $eligible_token
 * @property \Carbon\Carbon $percase_date
 * @property string $percase_name
 * @property float $percase_amount
 * @property bool $percase_status
 * @property int $percase_invoice
 * @property int $primary_claim_id
 * @property bool $fo_paid_viewed
 * @property bool $bo_paid_viewed
 * @property bool $closed_by_office_type
 * @property string $s_m_eligible_payer_id
 * @property string $s_m_eligible_payer_name
 * @property string $other_insured_id_number
 * @property bool $primary_claim_version
 * @property bool $secondary_claim_version
 * @property string $nucc_8a
 * @property string $nucc_8b
 * @property string $nucc_9a
 * @property string $nucc_9b
 * @property string $nucc_9c
 * @property string $nucc_10d
 * @property string $nucc_30
 * @property string $claim_codes
 * @property string $other_claim_id
 * @property bool $icd_ind
 * @property string $name_referring_provider_qualifier
 * @property string $diagnosis_a
 * @property string $diagnosis_b
 * @property string $diagnosis_c
 * @property string $diagnosis_d
 * @property string $diagnosis_e
 * @property string $diagnosis_f
 * @property string $diagnosis_g
 * @property string $diagnosis_h
 * @property string $diagnosis_i
 * @property string $diagnosis_j
 * @property string $diagnosis_k
 * @property string $diagnosis_l
 * @property string $current_qual
 * @property string $same_illness_qual
 * @property string $resubmission_code
 * @property bool $resubmission_code_fill
 * @property int $updated_by_user
 * @property int $updated_by_admin
 * @property \Carbon\Carbon $updated_at
 * @property int $id
 * @property string $responsibility_sequence
 * @property string $rendering_provider_entity_1
 * @property string $rendering_provider_first_name_1
 * @property string $rendering_provider_last_name_1
 * @property string $rendering_provider_org_1
 * @property string $rendering_provider_npi_1
 * @property string $rendering_provider_entity_2
 * @property string $rendering_provider_first_name_2
 * @property string $rendering_provider_last_name_2
 * @property string $rendering_provider_org_2
 * @property string $rendering_provider_npi_2
 * @property string $rendering_provider_entity_3
 * @property string $rendering_provider_first_name_3
 * @property string $rendering_provider_last_name_3
 * @property string $rendering_provider_org_3
 * @property string $rendering_provider_npi_3
 * @property string $rendering_provider_entity_4
 * @property string $rendering_provider_first_name_4
 * @property string $rendering_provider_last_name_4
 * @property string $rendering_provider_org_4
 * @property string $rendering_provider_npi_4
 * @property string $rendering_provider_entity_5
 * @property string $rendering_provider_first_name_5
 * @property string $rendering_provider_last_name_5
 * @property string $rendering_provider_org_5
 * @property string $rendering_provider_npi_5
 * @property string $rendering_provider_entity_6
 * @property string $rendering_provider_first_name_6
 * @property string $rendering_provider_last_name_6
 * @property string $rendering_provider_org_6
 * @property string $rendering_provider_npi_6
 * @property string $payer_id
 * @property string $payer_name
 * @property string $payer_address
 * @property string $payer_city
 * @property string $payer_state
 * @property string $payer_zip
 * @property string $billing_provider_taxonomy_code
 * @property string $other_insured_insurance_type
 * @property string $claim_info_code
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereAcceptAssignment($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereAmountPaid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereAnotherPlan($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereAutoAccident($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereAutoAccidentPlace($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBalanceDue($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderA($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderBOther($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderDd($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderPhoneCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBillingProviderTaxonomyCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereBoPaidViewed($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereCard($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereClaimCodes($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereClaimInfoCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereClosedByOfficeType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereCptHcpcs1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereCptHcpcs2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereCptHcpcs3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereCptHcpcs4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereCptHcpcs5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereCptHcpcs6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereCurrentQual($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDateCurrent($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDateSameIllness($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDaysOrUnits1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDaysOrUnits2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDaysOrUnits3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDaysOrUnits4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDaysOrUnits5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDaysOrUnits6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosis1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosis2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosis3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosis4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisA($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisB($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisC($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisD($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisE($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisF($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisG($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisH($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisI($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisJ($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisK($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisL($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisPointer1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisPointer2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisPointer3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisPointer4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisPointer5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDiagnosisPointer6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDisputeReason($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereDocid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEin($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEligibleResponse($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEligibleToken($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEmg1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEmg2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEmg3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEmg4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEmg5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEmg6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEmployment($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEpsdtFamilyPlan1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEpsdtFamilyPlan2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEpsdtFamilyPlan3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEpsdtFamilyPlan4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEpsdtFamilyPlan5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereEpsdtFamilyPlan6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereFederalTaxIdNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereField17a($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereField17aDd($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereField17b($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereFoPaidViewed($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereFormid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereHospitalizationDateFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereHospitalizationDateTo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereIcdInd($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereIdQua1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereIdQua2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereIdQua3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereIdQua4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereIdQua5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereIdQua6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuranceType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuranceid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredDob($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredEmployerSchoolName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredIdNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredInsurancePlan($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredMiddle($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredPhoneCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredPolicyGroupFeca($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredSex($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredSignature($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereInsuredZip($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereMailedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereMedicaidResubmissionCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier11($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier12($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier13($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier14($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier21($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier22($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier23($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier24($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier31($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier32($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier33($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier34($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier41($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier42($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier43($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier44($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier51($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier52($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier53($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier54($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier61($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier62($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier63($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereModifier64($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereNameReferringProviderQualifier($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereNucc10d($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereNucc30($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereNucc8a($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereNucc8b($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereNucc9a($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereNucc9b($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereNucc9c($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOriginalRefNo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherAccident($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherClaimId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuranceType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredDob($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredEmployerSchoolName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredIdNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredInsurancePlan($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredInsuranceType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredMiddle($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredPolicyGroupFeca($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredSex($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOtherInsuredZip($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereOutsideLab($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePMBillingId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePMDssFile($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePMEligiblePayerId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePMEligiblePayerName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientAccountNo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientDob($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientLastname($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientMiddle($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientPhone($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientPhoneCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientRelationInsured($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientRelationOtherInsured($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientSex($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientSignature($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientSignedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientZip($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePatientid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePayerAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePayerCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePayerId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePayerName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePayerState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePayerZip($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePercaseAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePercaseDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePercaseInvoice($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePercaseName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePercaseStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePhysicianSignedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePica1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePica2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePica3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePlaceOfService1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePlaceOfService2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePlaceOfService3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePlaceOfService4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePlaceOfService5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePlaceOfService6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePrimaryClaimId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePrimaryClaimVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePrimaryFdf($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory wherePriorAuthorizationNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereProducer($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereReferringProvider($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRejectReason($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderEntity1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderEntity2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderEntity3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderEntity4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderEntity5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderEntity6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderFirstName1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderFirstName2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderFirstName3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderFirstName4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderFirstName5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderFirstName6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderId1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderId2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderId3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderId4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderId5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderId6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderLastName1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderLastName2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderLastName3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderLastName4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderLastName5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderLastName6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderNpi1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderNpi2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderNpi3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderNpi4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderNpi5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderNpi6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderOrg1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderOrg2($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderOrg3($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderOrg4($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderOrg5($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereRenderingProviderOrg6($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereReservedLocalUse($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereReservedLocalUse1($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereResponsibilitySequence($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereResubmissionCode($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereResubmissionCodeFill($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges11($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges12($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges21($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges22($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges31($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges32($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges41($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges42($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges51($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges52($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges61($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSCharges62($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSMBillingId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSMDssFile($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSMEligiblePayerId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSMEligiblePayerName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSameIllnessQual($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSecDisputeReason($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSecMailedDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSecondaryClaimVersion($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSecondaryFdf($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate1From($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate1To($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate2From($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate2To($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate3From($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate3To($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate4From($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate4To($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate5From($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate5To($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate6From($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceDate6To($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceFacilityInfoAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceFacilityInfoCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceFacilityInfoName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceInfoA($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceInfoBOther($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereServiceInfoDd($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSignaturePhysician($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereSsn($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereTotalCharge($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereUnableDateFrom($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereUnableDateTo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereUpdatedByAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereUpdatedByUser($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\InsuranceHistory whereUserid($value)
 */
	class InsuranceHistory extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\SoftPalate
 *
 * @property int $soft_palateid
 * @property string $soft_palate
 * @property string $description
 * @property int $sortby
 * @property int $status
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SoftPalate whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SoftPalate whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SoftPalate whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SoftPalate whereSoftPalate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SoftPalate whereSoftPalateid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SoftPalate whereSortby($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\SoftPalate whereStatus($value)
 */
	class SoftPalate extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Dental{
/**
 * DentalSleepSolutions\Eloquent\Dental\Refund
 *
 * @property int $id
 * @property float $amount
 * @property int $userid
 * @property int $adminid
 * @property \Carbon\Carbon $refund_date
 * @property int $charge_id
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Refund whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Refund whereAdminid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Refund whereAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Refund whereChargeId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Refund whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Refund whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Refund whereRefundDate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Dental\Refund whereUserid($value)
 */
	class Refund extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent{
/**
 * DentalSleepSolutions\Eloquent\AdminCompany
 *
 * @property int $id
 * @property int $adminid
 * @property int $companyid
 * @property \Carbon\Carbon $adddate
 * @property string $ip_address
 * @property-read \DentalSleepSolutions\Eloquent\Admin $admin
 * @property-read \DentalSleepSolutions\Eloquent\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection|\DentalSleepSolutions\Eloquent\Dental\UserCompany[] $users
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\AdminCompany whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\AdminCompany whereAdminid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\AdminCompany whereCompanyid($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\AdminCompany whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\AdminCompany whereIpAddress($value)
 */
	class AdminCompany extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Enrollments{
/**
 * DentalSleepSolutions\Eloquent\Enrollments\TransactionType
 *
 * @property int $id
 * @property string $transaction_type
 * @property string $description
 * @property string $adddate
 * @property string $ip_address
 * @property bool $status
 * @property string $endpoint_type
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\TransactionType whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\TransactionType whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\TransactionType whereEndpointType($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\TransactionType whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\TransactionType whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\TransactionType whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\TransactionType whereTransactionType($value)
 */
	class TransactionType extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Enrollments{
/**
 * DentalSleepSolutions\Eloquent\Enrollments\Enrollment
 *
 * @property int $id
 * @property int $user_id
 * @property string $payer_id
 * @property int $reference_id
 * @property string $response
 * @property bool $status
 * @property string $adddate
 * @property string $ip_address
 * @property string $payer_name
 * @property int $transaction_type_id
 * @property int $enrollment_invoice_id
 * @property string $npi
 * @property string $facility_name
 * @property string $provider_name
 * @property string $tax_id
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zip
 * @property string $first_name
 * @property string $last_name
 * @property string $contact_number
 * @property string $email
 * @property string $download_url
 * @property string $signed_download_url
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereAdddate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereContactNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereDownloadUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereEnrollmentInvoiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereFacilityName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereIpAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereNpi($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment wherePayerId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment wherePayerName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereProviderName($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereReferenceId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereResponse($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereSignedDownloadUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereTaxId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereTransactionTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\Enrollments\Enrollment whereZip($value)
 */
	class Enrollment extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent\Enrollments{
/**
 * DentalSleepSolutions\Eloquent\Enrollments\PayersList
 *
 */
	class PayersList extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent{
/**
 * DentalSleepSolutions\Eloquent\MemoAdmin
 *
 * @property int $memo_id
 * @property string $memo
 * @property string $last_update
 * @property string $off_date
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\MemoAdmin current()
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\MemoAdmin whereLastUpdate($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\MemoAdmin whereMemo($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\MemoAdmin whereMemoId($value)
 * @method static \Illuminate\Database\Query\Builder|\DentalSleepSolutions\Eloquent\MemoAdmin whereOffDate($value)
 */
	class MemoAdmin extends \Eloquent {}
}

namespace DentalSleepSolutions\Eloquent{
/**
 * Model representing combined dental_users & admin tables data
 * using v_users db view. The view isn't writable thus model
 * is made read-only by disabling saving via model events.
 *
 * @see self::boot
 */
	class User extends \Eloquent {}
}

