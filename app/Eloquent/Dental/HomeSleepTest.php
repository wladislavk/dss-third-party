<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\HomeSleepTest as Resource;
use DentalSleepSolutions\Contracts\Repositories\HomeSleepTests as Repository;
use DB;

/**
 * @SWG\Definition(
 *     definition="HomeSleepTest",
 *     type="object",
 *     required={"id", "provider", "canceled", "hst"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="doc", type="integer"),
 *     @SWG\Property(property="user", type="integer"),
 *     @SWG\Property(property="company", type="integer"),
 *     @SWG\Property(property="patient", type="integer"),
 *     @SWG\Property(property="screener", type="integer"),
 *     @SWG\Property(property="ins", type="integer"),
 *     @SWG\Property(property="ins", type="string"),
 *     @SWG\Property(property="patient", type="string"),
 *     @SWG\Property(property="patient", type="string"),
 *     @SWG\Property(property="patient", type="string"),
 *     @SWG\Property(property="patient", type="string"),
 *     @SWG\Property(property="patient", type="string"),
 *     @SWG\Property(property="patient", type="string"),
 *     @SWG\Property(property="patient", type="string"),
 *     @SWG\Property(property="patient", type="string"),
 *     @SWG\Property(property="patient", type="string"),
 *     @SWG\Property(property="patient", type="string", format="dateTime"),
 *     @SWG\Property(property="patient", type="string"),
 *     @SWG\Property(property="patient", type="string"),
 *     @SWG\Property(property="patient", type="string"),
 *     @SWG\Property(property="diagnosis", type="integer"),
 *     @SWG\Property(property="hst", type="integer"),
 *     @SWG\Property(property="provider", type="string"),
 *     @SWG\Property(property="provider", type="string"),
 *     @SWG\Property(property="provider", type="string"),
 *     @SWG\Property(property="provider", type="string"),
 *     @SWG\Property(property="provider", type="string"),
 *     @SWG\Property(property="provider", type="string"),
 *     @SWG\Property(property="provider", type="string"),
 *     @SWG\Property(property="provider", type="string"),
 *     @SWG\Property(property="provider", type="string", format="dateTime"),
 *     @SWG\Property(property="snore", type="integer"),
 *     @SWG\Property(property="snore", type="integer"),
 *     @SWG\Property(property="snore", type="integer"),
 *     @SWG\Property(property="snore", type="integer"),
 *     @SWG\Property(property="snore", type="integer"),
 *     @SWG\Property(property="viewed", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="office", type="string"),
 *     @SWG\Property(property="sleep", type="integer"),
 *     @SWG\Property(property="authorized", type="integer"),
 *     @SWG\Property(property="authorizeddate", type="string", format="dateTime"),
 *     @SWG\Property(property="updatedate", type="string", format="dateTime"),
 *     @SWG\Property(property="rejected", type="string"),
 *     @SWG\Property(property="rejecteddate", type="string", format="dateTime"),
 *     @SWG\Property(property="canceled", type="integer"),
 *     @SWG\Property(property="canceled", type="string", format="dateTime"),
 *     @SWG\Property(property="hst", type="integer"),
 *     @SWG\Property(property="hst", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\HomeSleepTest
 *
 * @property int $id
 * @property int|null $doc_id
 * @property int|null $user_id
 * @property int|null $company_id
 * @property int|null $patient_id
 * @property int|null $screener_id
 * @property int|null $ins_co_id
 * @property string|null $ins_phone
 * @property string|null $patient_ins_group_id
 * @property string|null $patient_ins_id
 * @property string|null $patient_firstname
 * @property string|null $patient_lastname
 * @property string|null $patient_add1
 * @property string|null $patient_add2
 * @property string|null $patient_city
 * @property string|null $patient_state
 * @property string|null $patient_zip
 * @property \Carbon\Carbon|null $patient_dob
 * @property string|null $patient_cell_phone
 * @property string|null $patient_home_phone
 * @property string|null $patient_email
 * @property int|null $diagnosis_id
 * @property int|null $hst_type
 * @property string|null $provider_firstname
 * @property string|null $provider_lastname
 * @property string $provider_phone
 * @property string|null $provider_address
 * @property string|null $provider_city
 * @property string|null $provider_state
 * @property string|null $provider_zip
 * @property string|null $provider_signature
 * @property \Carbon\Carbon|null $provider_date
 * @property int|null $snore_1
 * @property int|null $snore_2
 * @property int|null $snore_3
 * @property int|null $snore_4
 * @property int|null $snore_5
 * @property int|null $viewed
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property string|null $office_notes
 * @property int|null $sleep_study_id
 * @property int|null $authorized_id
 * @property \Carbon\Carbon|null $authorizeddate
 * @property \Carbon\Carbon|null $updatedate
 * @property string|null $rejected_reason
 * @property \Carbon\Carbon|null $rejecteddate
 * @property int $canceled_id
 * @property \Carbon\Carbon|null $canceled_date
 * @property int|null $hst_nights
 * @property string $hst_positions
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest base($docId = 0)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest completed()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest orPending()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest orRejected()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest orScheduled()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest rejected()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest requested()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereAuthorizedId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereAuthorizeddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereCanceledDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereCanceledId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereDiagnosisId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereDocId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereHstNights($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereHstPositions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereHstType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereInsCoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereInsPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereOfficeNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientAdd1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientAdd2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientCellPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientHomePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientInsGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientInsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest wherePatientZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereProviderZip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereRejectedReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereRejecteddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereScreenerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereSleepStudyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereSnore1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereSnore2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereSnore3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereSnore4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereSnore5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereUpdatedate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\HomeSleepTest whereViewed($value)
 * @mixin \Eloquent
 */
class HomeSleepTest extends AbstractModel implements Resource, Repository
{
    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_hst';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'patient_dob', 'provider_date', 'authorizeddate',
        'rejecteddate', 'canceled_date'
    ];

    private $preAuthorizationStatuses = [
        'DSS_HST_CANCELED'  => -1,
        'DSS_HST_REQUESTED' => 0,
        'DSS_HST_PENDING'   => 1,
        'DSS_HST_SCHEDULED' => 2,
        'DSS_HST_COMPLETE'  => 3,
        'DSS_HST_REJECTED'  => 4,
        'DSS_HST_CONTACTED' => 5
    ];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'updatedate';

    public function scopeRequested($query)
    {
        return $query->where('status', $this->preAuthorizationStatuses['DSS_HST_REQUESTED']);
    }

    public function scopeOrPending($query)
    {
        return $query->orWhere('status', $this->preAuthorizationStatuses['DSS_HST_PENDING']);
    }

    public function scopeOrScheduled($query)
    {
        return $query->orWhere('status', $this->preAuthorizationStatuses['DSS_HST_SCHEDULED']);
    }

    public function scopeOrRejected($query)
    {
        return $query->orWhere(function($query) {
            $query->where('status', $this->preAuthorizationStatuses['DSS_HST_REJECTED'])
                ->where(function($query) {
                    $query->whereNull('viewed')
                        ->orWhere('viewed', 0);
                });
        });
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', $this->preAuthorizationStatuses['DSS_HST_COMPLETE']);
    }

    public function scopeRejected($query)
    {
        return $query->where('status', $this->preAuthorizationStatuses['DSS_HST_REJECTED']);
    }

    public function scopeBase($query, $docId = 0)
    {
        return $query->select(DB::raw('COUNT(id) AS total'))
            ->where('doc_id', $docId)
            ->whereRaw('COALESCE(viewed, 0) != 1');
    }

    public function getUncompleted($patientId = 0)
    {
        return $this->where(function($query) {
                $query->requested()->orPending()->orScheduled()->orRejected();
            })
            ->where('patient_id', $patientId)
            ->get();
    }

    public function getCompleted($docId = 0)
    {
        return $this->base($docId)
            ->completed()
            ->first();
    }

    public function getRequested($docId = 0)
    {
        return $this->base($docId)
            ->requested()
            ->first();
    }

    public function getRejected($docId = 0)
    {
        return $this->base($docId)
            ->rejected()
            ->first();
    }
}