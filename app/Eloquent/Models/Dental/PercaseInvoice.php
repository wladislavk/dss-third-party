<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="PercaseInvoice",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="adminid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="adddate", type="string"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="monthly_fee_date", type="string"),
 *     @SWG\Property(property="monthly_fee_amount", type="float"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="due_date", type="string"),
 *     @SWG\Property(property="companyid", type="integer"),
 *     @SWG\Property(property="user_fee_date", type="string"),
 *     @SWG\Property(property="user_fee_amount", type="float"),
 *     @SWG\Property(property="producer_fee_date", type="string"),
 *     @SWG\Property(property="producer_fee_amount", type="float"),
 *     @SWG\Property(property="user_fee_desc", type="string"),
 *     @SWG\Property(property="producer_fee_desc", type="string"),
 *     @SWG\Property(property="invoice_type", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\PercaseInvoice
 *
 * @property int $id
 * @property int|null $adminid
 * @property int|null $docid
 * @property string|null $adddate
 * @property string|null $ip_address
 * @property string|null $monthly_fee_date
 * @property float|null $monthly_fee_amount
 * @property int|null $status
 * @property string|null $due_date
 * @property int|null $companyid
 * @property string|null $user_fee_date
 * @property float|null $user_fee_amount
 * @property string|null $producer_fee_date
 * @property float|null $producer_fee_amount
 * @property string|null $user_fee_desc
 * @property string|null $producer_fee_desc
 * @property int|null $invoice_type
 * @mixin \Eloquent
 */
class PercaseInvoice extends AbstractModel
{
    use WithoutUpdatedTimestamp;

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
    protected $table = 'dental_percase_invoice';

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
    protected $dates = ['monthly_fee_date', 'due_date', 'user_fee_date', 'producer_fee_date'];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
