<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Eloquent\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Note as Resource;
use DentalSleepSolutions\Contracts\Repositories\Notes as Repository;

class Note extends Model implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['notesid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_notes';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'notesid';

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['signed_on'];

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';
}
