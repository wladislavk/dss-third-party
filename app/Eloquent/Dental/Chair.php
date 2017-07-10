<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resources\Chair as Resource;
use DentalSleepSolutions\Contracts\Repositories\Chairs as Repository;

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
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Chair whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Chair whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Chair whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Chair whereRank($value)
 * @mixin \Eloquent
 */
class Chair extends AbstractModel implements Resource, Repository
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
