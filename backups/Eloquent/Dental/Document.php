<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Document as Resource;
use DentalSleepSolutions\Contracts\Repositories\Documents as Repository;

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
 * @property-read \DentalSleepSolutions\Eloquent\Dental\DocumentCategory $category
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Document whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Document whereCategoryid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Document whereDocumentid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Document whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Document whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Document whereName($value)
 * @mixin \Eloquent
 */
class Document extends AbstractModel implements Resource, Repository
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

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    /**
     * RELATIONS
     */
    public function category()
    {
        return $this->hasOne(DocumentCategory::class, 'categoryid', 'id');
    }
}
