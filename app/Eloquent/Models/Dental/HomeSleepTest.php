<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DB;
use Illuminate\Database\Query\Builder;

/**
 * @SWG\Definition(
 *     definition="HomeSleepTest",
 *     type="object",
 *     required={"id", "provider_phone", "canceled_id", "hst_positions"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="doc_id", type="integer"),
 *     @SWG\Property(property="user_id", type="integer"),
 *     @SWG\Property(property="company_id", type="integer"),
 *     @SWG\Property(property="patient_id", type="integer"),
 *     @SWG\Property(property="screener_id", type="integer"),
 *     @SWG\Property(property="ins_co_id", type="integer"),
 *     @SWG\Property(property="ins_phone", type="string"),
 *     @SWG\Property(property="patient_ins_group_id", type="string"),
 *     @SWG\Property(property="patient_ins_id", type="string"),
 *     @SWG\Property(property="patient_firstname", type="string"),
 *     @SWG\Property(property="patient_lastname", type="string"),
 *     @SWG\Property(property="patient_add1", type="string"),
 *     @SWG\Property(property="patient_add2", type="string"),
 *     @SWG\Property(property="patient_city", type="string"),
 *     @SWG\Property(property="patient_state", type="string"),
 *     @SWG\Property(property="patient_zip", type="string"),
 *     @SWG\Property(property="patient_dob", type="string", format="dateTime"),
 *     @SWG\Property(property="patient_cell_phone", type="string"),
 *     @SWG\Property(property="patient_home_phone", type="string"),
 *     @SWG\Property(property="patient_email", type="string"),
 *     @SWG\Property(property="diagnosis_id", type="integer"),
 *     @SWG\Property(property="hst_type", type="integer"),
 *     @SWG\Property(property="provider_firstname", type="string"),
 *     @SWG\Property(property="provider_lastname", type="string"),
 *     @SWG\Property(property="provider_phone", type="string"),
 *     @SWG\Property(property="provider_address", type="string"),
 *     @SWG\Property(property="provider_city", type="string"),
 *     @SWG\Property(property="provider_state", type="string"),
 *     @SWG\Property(property="provider_zip", type="string"),
 *     @SWG\Property(property="provider_signature", type="string"),
 *     @SWG\Property(property="provider_date", type="string", format="dateTime"),
 *     @SWG\Property(property="snore_1", type="integer"),
 *     @SWG\Property(property="snore_2", type="integer"),
 *     @SWG\Property(property="snore_3", type="integer"),
 *     @SWG\Property(property="snore_4", type="integer"),
 *     @SWG\Property(property="snore_5", type="integer"),
 *     @SWG\Property(property="viewed", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="office_notes", type="string"),
 *     @SWG\Property(property="sleep_study_id", type="integer"),
 *     @SWG\Property(property="authorized_id", type="integer"),
 *     @SWG\Property(property="authorizeddate", type="string", format="dateTime"),
 *     @SWG\Property(property="updatedate", type="string", format="dateTime"),
 *     @SWG\Property(property="rejected_reason", type="string"),
 *     @SWG\Property(property="rejecteddate", type="string", format="dateTime"),
 *     @SWG\Property(property="canceled_id", type="integer"),
 *     @SWG\Property(property="canceled_date", type="string", format="dateTime"),
 *     @SWG\Property(property="hst_nights", type="integer"),
 *     @SWG\Property(property="hst_positions", type="string")
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
 * @mixin \Eloquent
 */
class HomeSleepTest extends AbstractModel
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
        'patient_dob',
        'provider_date',
        'authorizeddate',
        'rejecteddate',
        'canceled_date',
    ];

    private $preAuthorizationStatuses = [
        'DSS_HST_CANCELED'  => -1,
        'DSS_HST_REQUESTED' => 0,
        'DSS_HST_PENDING'   => 1,
        'DSS_HST_SCHEDULED' => 2,
        'DSS_HST_COMPLETE'  => 3,
        'DSS_HST_REJECTED'  => 4,
        'DSS_HST_CONTACTED' => 5,
    ];

    const CREATED_AT = 'adddate';

    const UPDATED_AT = 'updatedate';

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeRequested(Builder $query)
    {
        return $query->where('status', $this->preAuthorizationStatuses['DSS_HST_REQUESTED']);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrPending(Builder$query)
    {
        return $query->orWhere('status', $this->preAuthorizationStatuses['DSS_HST_PENDING']);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrScheduled(Builder $query)
    {
        return $query->orWhere('status', $this->preAuthorizationStatuses['DSS_HST_SCHEDULED']);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeOrRejected(Builder $query)
    {
        return $query->orWhere(function($query) {
            $query->where('status', $this->preAuthorizationStatuses['DSS_HST_REJECTED'])
                ->where(function($query) {
                    $query->whereNull('viewed')
                        ->orWhere('viewed', 0);
                });
        });
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeCompleted(Builder $query)
    {
        return $query->where('status', $this->preAuthorizationStatuses['DSS_HST_COMPLETE']);
    }

    /**
     * @param Builder $query
     * @return Builder
     */
    public function scopeRejected(Builder $query)
    {
        return $query->where('status', $this->preAuthorizationStatuses['DSS_HST_REJECTED']);
    }

    /**
     * @param Builder $query
     * @param int $docId
     * @return Builder
     */
    public function scopeBase(Builder $query, $docId = 0)
    {
        return $query->select(DB::raw('COUNT(id) AS total'))
            ->where('doc_id', $docId)
            ->whereRaw('COALESCE(viewed, 0) != 1');
    }
}
