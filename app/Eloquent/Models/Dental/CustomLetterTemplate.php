<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="CustomLetterTemplate",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="body", type="string"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="status", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $body
 * @property int|null $docid
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $status
 * @mixin \Eloquent
 */
class CustomLetterTemplate extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'body',
        'docid',
        'adddate',
        'ip_address',
        'status',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_letter_templates_custom';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    const CREATED_AT = 'adddate';
}
