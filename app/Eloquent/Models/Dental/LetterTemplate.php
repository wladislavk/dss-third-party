<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\LetterTemplate as Resource;
use DentalSleepSolutions\Contracts\Repositories\LetterTemplates as Repository;

class LetterTemplate extends AbstractModel implements Resource, Repository
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = [
        'name', 'template', 'body',
        'default_letter','companyid', 'triggerid'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_letter_templates';

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
