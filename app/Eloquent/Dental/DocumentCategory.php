<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\DocumentCategory as Resource;
use DentalSleepSolutions\Contracts\Repositories\DocumentCategories as Repository;

class DocumentCategory extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'name', 'status'
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
}
