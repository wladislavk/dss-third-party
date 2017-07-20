<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\Resource;

/**
 * @SWG\Definition(
 *     definition="LedgerRecord",
 *     type="object",
 *     required={"ledgerid"},
 *     @SWG\Property(property="ledgerid", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="service_date", type="string"),
 *     @SWG\Property(property="entry_date", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="producer", type="string"),
 *     @SWG\Property(property="amount", type="float"),
 *     @SWG\Property(property="transaction_type", type="string"),
 *     @SWG\Property(property="paid_amount", type="float"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="transaction_code", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\LedgerRecord
 *
 * @property int $ledgerid
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $service_date
 * @property string|null $entry_date
 * @property string|null $description
 * @property string|null $producer
 * @property float|null $amount
 * @property string|null $transaction_type
 * @property float|null $paid_amount
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property string|null $adddate
 * @property string|null $ip_address
 * @property string|null $transaction_code
 * @mixin \Eloquent
 */
class LedgerRecord extends AbstractModel implements Resource
{
    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['ledgerid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_ledger_rec';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ledgerid';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
