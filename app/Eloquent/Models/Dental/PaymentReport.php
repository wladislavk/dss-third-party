<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Resource;
use DentalSleepSolutions\Contracts\Repositories\Repository;
use DB;

class PaymentReport extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'claimid', 'reference_id', 'response',
        'adddate', 'ip_address', 'viewed'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_payment_reports';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'payment_id';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function getNumber($docId = 0)
    {
        return $this->select(DB::raw('COUNT(payment_id) AS total'))
            ->from(DB::raw('dental_payment_reports AS pr'))
            ->join(DB::raw('dental_insurance AS i'), 'i.insuranceid', '=', 'pr.claimid')
            ->where('i.docid', $docId)
            ->whereRaw('COALESCE(pr.viewed, 0) != 1')
            ->first();
    }
}
