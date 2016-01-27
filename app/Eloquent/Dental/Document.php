<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Document as Resource;
use DentalSleepSolutions\Contracts\Repositories\Documents as Repository;

class Document extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'categoryid', 'name', 'filename'
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
}
