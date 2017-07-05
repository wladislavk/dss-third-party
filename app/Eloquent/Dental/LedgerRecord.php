<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\LedgerRecord as Resource;
use DentalSleepSolutions\Contracts\Repositories\LedgerRecords as Repository;

/**
 * @SWG\Definition(
 *     definition="LedgerRecord",
 *     type="object",
 *     required={"ledgerid"},
 *     @SWG\Property(property="ledgerid", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="service", type="string"),
 *     @SWG\Property(property="entry", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="producer", type="string"),
 *     @SWG\Property(property="amount", type="float"),
 *     @SWG\Property(property="transaction", type="string"),
 *     @SWG\Property(property="paid", type="float"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="transaction", type="string")
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
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereEntryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereFormid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereLedgerid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereProducer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereServiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereTransactionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereTransactionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerRecord whereUserid($value)
 * @mixin \Eloquent
 */
/**
 * @SWG\Definition(
 *     definition="LedgerRecord",
 *     type="object",
 *     required={"ledgerid"},
 *     @SWG\Property(property="ledgerid", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="service", type="string"),
 *     @SWG\Property(property="entry", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="producer", type="string"),
 *     @SWG\Property(property="amount", type="float"),
 *     @SWG\Property(property="transaction", type="string"),
 *     @SWG\Property(property="paid", type="float"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="transaction", type="string")
 * )
 */
class LedgerRecord extends AbstractModel implements Resource, Repository
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
