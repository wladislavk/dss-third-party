<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Document as Resource;
use DentalSleepSolutions\Contracts\Repositories\Documents as Repository;

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
