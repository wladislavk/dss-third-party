<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Contracts\Resources\Resource;

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
 * @mixin \Eloquent
 */
class SleepStudy extends AbstractModel implements Resource
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
