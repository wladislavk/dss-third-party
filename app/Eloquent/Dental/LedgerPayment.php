<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\LedgerPayment as Resource;
use DentalSleepSolutions\Contracts\Repositories\LedgerPayments as Repository;

/**
 * DentalSleepSolutions\Eloquent\Dental\LedgerPayment
 *
 * @property int $id
 * @property int|null $payer
 * @property float|null $amount
 * @property int|null $payment_type
 * @property \Carbon\Carbon|null $payment_date
 * @property \Carbon\Carbon|null $entry_date
 * @property int|null $ledgerid
 * @property float|null $allowed
 * @property float|null $ins_paid
 * @property float|null $deductible
 * @property float|null $copay
 * @property float|null $coins
 * @property float|null $overpaid
 * @property \Carbon\Carbon|null $followup
 * @property string|null $note
 * @property float|null $amount_allowed
 * @property int $is_secondary
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereAllowed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereAmountAllowed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereCoins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereCopay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereDeductible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereEntryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereFollowup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereInsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereIsSecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereLedgerid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment whereOverpaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment wherePayer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPayment wherePaymentType($value)
 * @mixin \Eloquent
 */
/**
 * @SWG\Definition(
 *     definition="LedgerPayment",
 *     type="object",
 *     required={"id", "is"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="payer", type="integer"),
 *     @SWG\Property(property="amount", type="float"),
 *     @SWG\Property(property="payment", type="integer"),
 *     @SWG\Property(property="payment", type="string", format="dateTime"),
 *     @SWG\Property(property="entry", type="string", format="dateTime"),
 *     @SWG\Property(property="ledgerid", type="integer"),
 *     @SWG\Property(property="allowed", type="float"),
 *     @SWG\Property(property="ins", type="float"),
 *     @SWG\Property(property="deductible", type="float"),
 *     @SWG\Property(property="copay", type="float"),
 *     @SWG\Property(property="coins", type="float"),
 *     @SWG\Property(property="overpaid", type="float"),
 *     @SWG\Property(property="followup", type="string", format="dateTime"),
 *     @SWG\Property(property="note", type="string"),
 *     @SWG\Property(property="amount", type="float"),
 *     @SWG\Property(property="is", type="integer")
 * )
 */
/**
 * @SWG\Definition(
 *     definition="LedgerPayment",
 *     type="object",
 * 
 * )
 */
class LedgerPayment extends AbstractModel implements Resource, Repository
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
    protected $table = 'dental_ledger_payment';

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
    protected $dates = ['payment_date', 'entry_date', 'followup'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
