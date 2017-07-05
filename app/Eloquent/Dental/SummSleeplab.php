<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;

/**
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
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereAhi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereAhisupine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereApnea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereCompleted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereCopyreqdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereCpaplevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereDentaldevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereDevicesetting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereDiagnosis($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereDiagnosisingDoc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereDiagnosisingNpi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereHypopnea($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereImageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereInterpolation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereNeeded($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereO2nadir($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab wherePatiendid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereRdi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereRdisupine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereScheddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereSleepefficiency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereSleeplab($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereSleeptesttype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereT9002($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\SummSleeplab whereTestnumber($value)
 * @mixin \Eloquent
 */
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
 *     @SWG\Property(property="diagnosising", type="string"),
 *     @SWG\Property(property="diagnosising", type="string"),
 *     @SWG\Property(property="image", type="integer")
 * )
 */
/**
 * @SWG\Definition(
 *     definition="SummSleeplab",
 *     type="object",
 * 
 * )
 */
class SummSleeplab extends AbstractModel
{
    protected $table = 'dental_summ_sleeplab';

    /**
     * @param int $patientId
     * @return SummSleeplab|null
     */
    public function getPatientDiagnosis($patientId)
    {
        /** @var SummSleeplab|null $diagnosis */
        $diagnosis = $this->select('diagnosis')
            ->where(function($query) {
                $query->whereNotNull('diagnosis')
                    ->where('diagnosis', '!=', '');
            })->whereNotNull('filename')
            ->where('patiendid', $patientId)
            ->orderBy('id', 'desc')
            ->first();
        return $diagnosis;
    }
}
