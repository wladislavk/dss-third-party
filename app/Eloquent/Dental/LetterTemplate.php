<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\LetterTemplate as Resource;
use DentalSleepSolutions\Contracts\Repositories\LetterTemplates as Repository;

/**
 * @SWG\Definition(
 *     definition="LetterTemplate",
 *     type="object",
 *     required={"id", "body", "default"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="template", type="string"),
 *     @SWG\Property(property="body", type="string"),
 *     @SWG\Property(property="default", type="integer"),
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
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LetterTemplate whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LetterTemplate whereCompanyid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LetterTemplate whereDefaultLetter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LetterTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LetterTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LetterTemplate whereTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\LetterTemplate whereTriggerid($value)
 * @mixin \Eloquent
 */
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
