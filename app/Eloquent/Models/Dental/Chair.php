<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

/**
 * @SWG\Definition(
 *     definition="Chair",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="rank", type="integer"),
 *     @SWG\Property(property="docid", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Chair
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $rank
 * @property int|null $docid
 * @mixin \Eloquent
 */
class Chair extends AbstractModel
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['name', 'rank', 'docid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_resources';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
