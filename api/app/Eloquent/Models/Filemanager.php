<?php

namespace DentalSleepSolutions\Eloquent\Models;

use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="Filemanager",
 *     type="object",
 *     required={"id", "docid", "name", "type", "size", "ext", "content", "date"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="type", type="string"),
 *     @SWG\Property(property="size", type="integer"),
 *     @SWG\Property(property="ext", type="string"),
 *     @SWG\Property(property="content", type="string"),
 *     @SWG\Property(property="date", type="string", format="dateTime")
 * )
 *
 * DentalSleepSolutions\Eloquent\Models\Filemanager
 *
 * @property int $id
 * @property int $docid
 * @property string $name
 * @property string $type
 * @property int $size
 * @property string $ext
 * @property string $content
 * @property \Carbon\Carbon $date
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Filemanager whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Filemanager whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Filemanager whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Filemanager whereExt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Filemanager whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Filemanager whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Filemanager whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\Filemanager whereType($value)
 */
class Filemanager extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['content'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'filemanager';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    const CREATED_AT = 'date';

    public function getPlural()
    {
        return 'Filemanager';
    }
}
