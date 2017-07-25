<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;

/**
 * @SWG\Definition(
 *     definition="SummSleeplab",
 *     type="object",
 *     required={"id", "date", "sleeptesttype", "place", "apnea", "hypopnea", "ahi", "ahisupine", "rdi", "rdisupine", "o2nadir", "t9002", "sleepefficiency", "cpaplevel", "dentaldevice", "devicesetting", "diagnosis", "notes", "patiendid"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="date", type="string"),
 *     @SWG\Property(property="sleeptesttype", type="string"),
 *     @SWG\Property(property="place", type="string"),
 *     @SWG\Property(property="apnea", type="string"),
 *     @SWG\Property(property="hypopnea", type="string"),
 *     @SWG\Property(property="ahi", type="string"),
 *     @SWG\Property(property="ahisupine", type="string"),
 *     @SWG\Property(property="rdi", type="string"),
 *     @SWG\Property(property="rdisupine", type="string"),
 *     @SWG\Property(property="o2nadir", type="string"),
 *     @SWG\Property(property="t9002", type="string"),
 *     @SWG\Property(property="sleepefficiency", type="string"),
 *     @SWG\Property(property="cpaplevel", type="string"),
 *     @SWG\Property(property="dentaldevice", type="string"),
 *     @SWG\Property(property="devicesetting", type="string"),
 *     @SWG\Property(property="diagnosis", type="string"),
 *     @SWG\Property(property="notes", type="string"),
 *     @SWG\Property(property="patiendid", type="string"),
 *     @SWG\Property(property="filename", type="string"),
 *     @SWG\Property(property="testnumber", type="string"),
 *     @SWG\Property(property="needed", type="string"),
 *     @SWG\Property(property="scheddate", type="string"),
 *     @SWG\Property(property="completed", type="string"),
 *     @SWG\Property(property="interpolation", type="string"),
 *     @SWG\Property(property="copyreqdate", type="string"),
 *     @SWG\Property(property="sleeplab", type="string"),
 *     @SWG\Property(property="diagnosising_doc", type="string"),
 *     @SWG\Property(property="diagnosising_npi", type="string"),
 *     @SWG\Property(property="image_id", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\SummSleeplab
 *
 * @property int $id
 * @property string $date
 * @property string $sleeptesttype
 * @property string $place
 * @property string $apnea
 * @property string $hypopnea
 * @property string $ahi
 * @property string $ahisupine
 * @property string $rdi
 * @property string $rdisupine
 * @property string $o2nadir
 * @property string $t9002
 * @property string $sleepefficiency
 * @property string $cpaplevel
 * @property string $dentaldevice
 * @property string $devicesetting
 * @property string $diagnosis
 * @property string $notes
 * @property string $patiendid
 * @property string|null $filename
 * @property string|null $testnumber
 * @property string|null $needed
 * @property string|null $scheddate
 * @property string|null $completed
 * @property string|null $interpolation
 * @property string|null $copyreqdate
 * @property string|null $sleeplab
 * @property string|null $diagnosising_doc
 * @property string|null $diagnosising_npi
 * @property int|null $image_id
 * @mixin \Eloquent
 */
class SummarySleeplab extends AbstractModel
{
    protected $table = 'dental_summ_sleeplab';

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

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
