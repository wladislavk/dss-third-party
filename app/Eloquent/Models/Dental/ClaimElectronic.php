<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="ClaimElectronic",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="claimid", type="integer"),
 *     @SWG\Property(property="response", type="string"),
 *     @SWG\Property(property="adddate", type="string"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="reference_id", type="string"),
 *     @SWG\Property(property="percase_date", type="string"),
 *     @SWG\Property(property="percase_name", type="string"),
 *     @SWG\Property(property="percase_amount", type="float"),
 *     @SWG\Property(property="percase_status", type="integer"),
 *     @SWG\Property(property="percase_invoice", type="integer"),
 *     @SWG\Property(property="percase_free", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\ClaimElectronic
 *
 * @property int $id
 * @property int|null $claimid
 * @property string|null $response
 * @property string|null $adddate
 * @property string|null $ip_address
 * @property string|null $reference_id
 * @property string|null $percase_date
 * @property string|null $percase_name
 * @property float|null $percase_amount
 * @property int|null $percase_status
 * @property int|null $percase_invoice
 * @property int|null $percase_free
 * @mixin \Eloquent
 */
class ClaimElectronic extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'claimid',
        'response',
        'adddate',
        'ip_address',
        'reference_id',
        'percase_date',
        'percase_name',
        'percase_amount',
        'percase_status',
        'percase_invoice',
        'percase_free',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_claim_electronic';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'id';

    const CREATED_AT = 'adddate';

    public function getPlural()
    {
        return 'ClaimsElectronic';
    }
}
