<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\Resource;

/**
 * @SWG\Definition(
 *     definition="LetterTemplate",
 *     type="object",
 *     required={"id", "body", "default_letter"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="template", type="string"),
 *     @SWG\Property(property="body", type="string"),
 *     @SWG\Property(property="default_letter", type="integer"),
 *     @SWG\Property(property="companyid", type="integer"),
 *     @SWG\Property(property="triggerid", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\LetterTemplate
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $template
 * @property string $body
 * @property int $default_letter
 * @property int|null $companyid
 * @property int|null $triggerid
 * @mixin \Eloquent
 */
class LetterTemplate extends AbstractModel implements Resource
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
