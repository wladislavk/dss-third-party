<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\SleepStudy as Resource;
use DentalSleepSolutions\Contracts\Repositories\SleepStudies as Repository;

/**
 * @SWG\Definition(
 *     definition="SleepStudy",
 *     type="object",
 *     required={"id", "testnumber", "docid", "patientid", "needed", "scheddate", "sleeplabwheresched", "completed", "interpolation", "labtype", "copyreqdate", "sleeplab", "scanext", "date"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="testnumber", type="string"),
 *     @SWG\Property(property="docid", type="string"),
 *     @SWG\Property(property="patientid", type="string"),
 *     @SWG\Property(property="needed", type="string"),
 *     @SWG\Property(property="scheddate", type="string"),
 *     @SWG\Property(property="sleeplabwheresched", type="string"),
 *     @SWG\Property(property="completed", type="string"),
 *     @SWG\Property(property="interpolation", type="string"),
 *     @SWG\Property(property="labtype", type="string"),
 *     @SWG\Property(property="copyreqdate", type="string"),
 *     @SWG\Property(property="sleeplab", type="string"),
 *     @SWG\Property(property="scanext", type="string"),
 *     @SWG\Property(property="date", type="string"),
 *     @SWG\Property(property="filename", type="string")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\SleepStudy
 *
 * @property int $id
 * @property string $testnumber
 * @property string $docid
 * @property string $patientid
 * @property string $needed
 * @property string $scheddate
 * @property string $sleeplabwheresched
 * @property string $completed
 * @property string $interpolation
 * @property string $labtype
 * @property string $copyreqdate
 * @property string $sleeplab
 * @property string $scanext
 * @property string $date
 * @property string|null $filename
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereCopyreqdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereInterpolation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereLabtype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereNeeded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereScanext($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereScheddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereSleeplab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereSleeplabwheresched($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SleepStudy whereTestnumber($value)
 * @mixin \Eloquent
 */
class SleepStudy extends AbstractModel implements Resource, Repository
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
    protected $table = 'dental_sleepstudy';

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
