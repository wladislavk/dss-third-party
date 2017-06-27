<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\PaymentReport as Resource;
use DentalSleepSolutions\Contracts\Repositories\PaymentReports as Repository;
use DB;

/**
 * DentalSleepSolutions\Eloquent\Dental\PaymentReport
 *
 * @property int $payment_id
 * @property int|null $claimid
 * @property string|null $reference_id
 * @property string|null $response
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $viewed
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PaymentReport whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PaymentReport whereClaimid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PaymentReport whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PaymentReport wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PaymentReport whereReferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PaymentReport whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\PaymentReport whereViewed($value)
 * @mixin \Eloquent
 */
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
