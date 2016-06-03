<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resources\HomeSleepTest as Resource;
use DentalSleepSolutions\Contracts\Repositories\HomeSleepTests as Repository;
use DB;

class HomeSleepTest extends Model implements Resource, Repository
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
            ->get();
    }

    public function getRequested($docId = 0)
    {
        return $this->base($docId)
            ->requested()
            ->get();
    }

    public function getRejected($docId = 0)
    {
        return $this->base($docId)
            ->rejected()
            ->get();
    }
}