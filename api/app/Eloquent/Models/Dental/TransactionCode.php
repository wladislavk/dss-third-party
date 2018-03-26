<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="TransactionCode",
 *     type="object",
 *     required={"transaction_codeid", "type", "ip_address", "days_units"},
 *     @SWG\Property(property="transaction_codeid", type="integer"),
 *     @SWG\Property(property="transaction_code", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="type", type="string"),
 *     @SWG\Property(property="sortby", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="default_code", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="amount", type="float"),
 *     @SWG\Property(property="place", type="integer"),
 *     @SWG\Property(property="modifier_code_1", type="string"),
 *     @SWG\Property(property="modifier_code_2", type="string"),
 *     @SWG\Property(property="days_units", type="string"),
 *     @SWG\Property(property="amount_adjust", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\TransactionCode
 *
 * @property int $transaction_codeid
 * @property string|null $transaction_code
 * @property string|null $description
 * @property string $type
 * @property int|null $sortby
 * @property int|null $status
 * @property string|null $adddate
 * @property string $ip_address
 * @property int|null $default_code
 * @property int|null $docid
 * @property float|null $amount
 * @property int|null $place
 * @property string|null $modifier_code_1
 * @property string|null $modifier_code_2
 * @property string $days_units
 * @property int|null $amount_adjust
 * @mixin \Eloquent
 */
class TransactionCode extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['transaction_codeid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_transaction_code';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'transaction_codeid';

    const CREATED_AT = 'adddate';
}
