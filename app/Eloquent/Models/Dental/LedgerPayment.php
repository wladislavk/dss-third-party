<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

/**
 * @SWG\Definition(
 *     definition="LedgerPayment",
 *     type="object",
 *     required={"id", "is_secondary"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="payer", type="integer"),
 *     @SWG\Property(property="amount", type="float"),
 *     @SWG\Property(property="payment_type", type="integer"),
 *     @SWG\Property(property="payment_date", type="string", format="dateTime"),
 *     @SWG\Property(property="entry_date", type="string", format="dateTime"),
 *     @SWG\Property(property="ledgerid", type="integer"),
 *     @SWG\Property(property="allowed", type="float"),
 *     @SWG\Property(property="ins_paid", type="float"),
 *     @SWG\Property(property="deductible", type="float"),
 *     @SWG\Property(property="copay", type="float"),
 *     @SWG\Property(property="coins", type="float"),
 *     @SWG\Property(property="overpaid", type="float"),
 *     @SWG\Property(property="followup", type="string", format="dateTime"),
 *     @SWG\Property(property="note", type="string"),
 *     @SWG\Property(property="amount_allowed", type="float"),
 *     @SWG\Property(property="is_secondary", type="integer")
 * )
 *
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
 * @mixin \Eloquent
 */
class LedgerPayment extends AbstractModel
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
