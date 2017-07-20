<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="DocumentCategory",
 *     type="object",
 *     required={"categoryid"},
 *     @SWG\Property(property="categoryid", type="integer"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\DocumentCategory
 *
 * @property int $categoryid
 * @property string|null $name
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @mixin \Eloquent
 */
class DocumentCategory extends AbstractModel
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
