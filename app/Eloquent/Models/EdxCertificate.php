<?php

namespace DentalSleepSolutions\Eloquent\Models;

use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="EdxCertificate",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="url", type="string"),
 *     @SWG\Property(property="edx_id", type="integer"),
 *     @SWG\Property(property="course_name", type="string"),
 *     @SWG\Property(property="course_section", type="string"),
 *     @SWG\Property(property="course_subsection", type="string"),
 *     @SWG\Property(property="number_ce", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Models\EdxCertificate
 *
 * @property int $id
 * @property string|null $url
 * @property int|null $edx_id
 * @property string|null $course_name
 * @property string|null $course_section
 * @property string|null $course_subsection
 * @property int|null $number_ce
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\EdxCertificate whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\EdxCertificate whereCourseName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\EdxCertificate whereCourseSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\EdxCertificate whereCourseSubsection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\EdxCertificate whereEdxId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\EdxCertificate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\EdxCertificate whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\EdxCertificate whereNumberCe($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\EdxCertificate whereUrl($value)
 */
class EdxCertificate extends AbstractModel
{
    use WithoutUpdatedTimestamp;

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
    protected $table = 'edx_certificates';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    const CREATED_AT = 'adddate';
}
