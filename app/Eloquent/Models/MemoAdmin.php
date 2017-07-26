<?php

namespace DentalSleepSolutions\Eloquent\Models;
use Illuminate\Database\Query\Builder;

/**
 * @SWG\Definition(
 *     definition="MemoAdmin",
 *     type="object",
 *     required={"memo_id", "memo", "last_update", "off_date"},
 *     @SWG\Property(property="memo_id", type="integer"),
 *     @SWG\Property(property="memo", type="string"),
 *     @SWG\Property(property="last_update", type="string"),
 *     @SWG\Property(property="off_date", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\MemoAdmin
 *
 * @property int $memo_id
 * @property string $memo
 * @property string $last_update
 * @property string $off_date
 * @mixin \Eloquent
 */
class MemoAdmin extends AbstractModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'memo_admin';

    /**
     * Primary key for the table
     *
     * @var string
     */
    protected $primaryKey = 'memo_id';

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['memo', 'last_update', 'off_date'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
