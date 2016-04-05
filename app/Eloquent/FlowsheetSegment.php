<?php

namespace DentalSleepSolutions\Eloquent;

use Illuminate\Database\Eloquent\Model;
use DentalSleepSolutions\Contracts\Resources\FlowsheetSegment as Resource;
use DentalSleepSolutions\Contracts\Repositories\FlowsheetSegments as Repository;

class FlowsheetSegment extends Model implements Resource, Repository
{
    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'flowsheet_segments';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
