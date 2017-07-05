<?php

namespace DentalSleepSolutions\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * @SWG\Definition(
 *     definition="MemoAdmin",
 *     type="object",
 *     required={"memo", "memo", "last", "off"},
 *     @SWG\Property(property="memo", type="integer"),
 *     @SWG\Property(property="memo", type="string"),
 *     @SWG\Property(property="last", type="string"),
 *     @SWG\Property(property="off", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\MemoAdmin
 *
 * @property int $memo_id
 * @property string $memo
 * @property string $last_update
 * @property string $off_date
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\MemoAdmin current()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\MemoAdmin whereLastUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\MemoAdmin whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\MemoAdmin whereMemoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\MemoAdmin whereOffDate($value)
 * @mixin \Eloquent
 */
class MemoAdmin extends Model
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

    public static function getCurrent()
    {
        return self::current()
            ->get();
    }

    public function scopeCurrent($query)
    {
        return $query->where('off_date', '<=', 'CURDATE()');
    }
}
