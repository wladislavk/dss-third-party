<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;

/**
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
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereAmountAdjust($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereDaysUnits($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereDefaultCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereModifierCode1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereModifierCode2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereSortby($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereTransactionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereTransactionCodeid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\TransactionCode whereType($value)
 * @mixin \Eloquent
 */
/**
 * @SWG\Definition(
 *     definition="TransactionCode",
 *     type="object",
 *     required={"transaction", "type", "ip", "days"},
 *     @SWG\Property(property="transaction", type="integer"),
 *     @SWG\Property(property="transaction", type="string"),
 *     @SWG\Property(property="description", type="string"),
 *     @SWG\Property(property="type", type="string"),
 *     @SWG\Property(property="sortby", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="default", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="amount", type="float"),
 *     @SWG\Property(property="place", type="integer"),
 *     @SWG\Property(property="modifier", type="string"),
 *     @SWG\Property(property="modifier", type="string"),
 *     @SWG\Property(property="days", type="string"),
 *     @SWG\Property(property="amount", type="integer")
 * )
 */
/**
 * @SWG\Definition(
 *     definition="TransactionCode",
 *     type="object",
 * 
 * )
 */
class TransactionCode extends AbstractModel
{
    protected $table = 'dental_transaction_code';
    protected $primaryKey = 'transaction_codeid';
}
