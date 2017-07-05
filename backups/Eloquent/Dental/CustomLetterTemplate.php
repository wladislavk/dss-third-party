<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\CustomLetterTemplate as Resource;
use DentalSleepSolutions\Contracts\Repositories\CustomLetterTemplates as Repository;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\CustomLetterTemplate whereStatus($value)
 * @mixin \Eloquent
 */
class CustomLetterTemplate extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'name', 'body', 'docid', 'adddate', 'ip_address', 'status'
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

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
