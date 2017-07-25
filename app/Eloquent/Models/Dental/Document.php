<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="Document",
 *     type="object",
 *     required={"documentid", "categoryid"},
 *     @SWG\Property(property="documentid", type="integer"),
 *     @SWG\Property(property="categoryid", type="integer"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="filename", type="string"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
 *     @SWG\Property(property="category", ref="#/definitions/DocumentCategory")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\Document
 *
 * @property int $documentid
 * @property int $categoryid
 * @property string|null $name
 * @property string|null $filename
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property-read \DentalSleepSolutions\Eloquent\Models\Dental\DocumentCategory $category
 * @mixin \Eloquent
 */
class Document extends AbstractModel
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'categoryid', 'name', 'filename',
        'adddate', 'ip_address'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_document';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'documentid';

    const CREATED_AT = 'adddate';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne(DocumentCategory::class, 'categoryid', 'id');
    }
}
