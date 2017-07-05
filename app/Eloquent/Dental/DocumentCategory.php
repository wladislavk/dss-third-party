<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\DocumentCategory as Resource;
use DentalSleepSolutions\Contracts\Repositories\DocumentCategories as Repository;

/**
 * @SWG\Definition(
 *     definition="DocumentCategory",
 *     type="object",
 *     required={"categoryid"},
 *     @SWG\Property(property="categoryid", type="integer"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\DocumentCategory
 *
 * @property int $categoryid
 * @property string|null $name
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DocumentCategory active()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DocumentCategory whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DocumentCategory whereCategoryid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DocumentCategory whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DocumentCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\DocumentCategory whereStatus($value)
 * @mixin \Eloquent
 */
class DocumentCategory extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status', 'adddate', 'ip_address'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_document_category';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'categoryid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function getActiveDocumentCategories()
    {
        return self::active()
            ->orderBy('name')
            ->get();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
