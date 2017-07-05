<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutCreatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="LedgerPaymentHistory",
 *     type="object",
 *     required={"paymentid", "id", "is"},
 *     @SWG\Property(property="paymentid", type="integer"),
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
 *     @SWG\Property(property="updated", type="integer"),
 *     @SWG\Property(property="updated", type="integer"),
 *     @SWG\Property(property="updated", type="string", format="dateTime"),
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="is", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory
 *
 * @property int $paymentid
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
 * @property int|null $updated_by_user
 * @property int|null $updated_by_admin
 * @property \Carbon\Carbon|null $updated_at
 * @property int $id
 * @property int $is_secondary
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereAllowed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereAmountAllowed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereCoins($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereCopay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereDeductible($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereEntryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereFollowup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereInsPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereIsSecondary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereLedgerid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereOverpaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory wherePayer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory wherePaymentid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereUpdatedByAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LedgerPaymentHistory whereUpdatedByUser($value)
 * @mixin \Eloquent
 */
/**
 * @SWG\Definition(
 *     definition="LedgerPaymentHistory",
 *     type="object",
 *     required={"paymentid", "id", "is"},
 *     @SWG\Property(property="paymentid", type="integer"),
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
 *     @SWG\Property(property="updated", type="integer"),
 *     @SWG\Property(property="updated", type="integer"),
 *     @SWG\Property(property="updated", type="string", format="dateTime"),
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="is", type="integer")
 * )
 */
/**
 * @SWG\Definition(
 *     definition="LedgerPaymentHistory",
 *     type="object",
 * 
 * )
 */
class LedgerPaymentHistory extends AbstractModel
{
    use WithoutCreatedTimestamp;

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
    protected $table = 'dental_ledger_payment_history';

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
}
