<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\Sleeplab as Resource;
use DentalSleepSolutions\Contracts\Repositories\Sleeplabs as Repository;

/**
 * DentalSleepSolutions\Eloquent\Dental\Sleeplab
 *
 * @property int $sleeplabid
 * @property int|null $docid
 * @property string|null $salutation
 * @property string|null $lastname
 * @property string|null $firstname
 * @property string|null $middlename
 * @property string|null $company
 * @property string|null $add1
 * @property string|null $add2
 * @property string|null $city
 * @property string|null $state
 * @property string|null $zip
 * @property string|null $phone1
 * @property string|null $phone2
 * @property string|null $fax
 * @property string|null $email
 * @property string|null $greeting
 * @property string|null $sincerely
 * @property string|null $notes
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereAdd1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereAdd2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereFirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereGreeting($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereMiddlename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab wherePhone1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab wherePhone2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereSalutation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereSincerely($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereSleeplabid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\Sleeplab whereZip($value)
 * @mixin \Eloquent
 */
/**
 * @SWG\Definition(
 *     definition="Sleeplab",
 *     type="object",
 *     required={"sleeplabid"},
 *     @SWG\Property(property="sleeplabid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="salutation", type="string"),
 *     @SWG\Property(property="lastname", type="string"),
 *     @SWG\Property(property="firstname", type="string"),
 *     @SWG\Property(property="middlename", type="string"),
 *     @SWG\Property(property="company", type="string"),
 *     @SWG\Property(property="add1", type="string"),
 *     @SWG\Property(property="add2", type="string"),
 *     @SWG\Property(property="city", type="string"),
 *     @SWG\Property(property="state", type="string"),
 *     @SWG\Property(property="zip", type="string"),
 *     @SWG\Property(property="phone1", type="string"),
 *     @SWG\Property(property="phone2", type="string"),
 *     @SWG\Property(property="fax", type="string"),
 *     @SWG\Property(property="email", type="string"),
 *     @SWG\Property(property="greeting", type="string"),
 *     @SWG\Property(property="sincerely", type="string"),
 *     @SWG\Property(property="notes", type="string"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string")
 * )
 */
/**
 * @SWG\Definition(
 *     definition="Sleeplab",
 *     type="object",
 * 
 * )
 */
class Sleeplab extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['sleeplabid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_sleeplab';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'sleeplabid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function getList($docId, $page, $rowsPerPage, $sort, $sortDir = 'asc', $letter = '')
    {
        $query = $this->where('docid', $docId);

        switch ($sort) {
            case 'lab':
                $sortColumn = 'company';
                break;

            case 'name':
                $sortColumn = 'lastname';
                break;

            default:
                $sortColumn = 'company';
                break;
        }

        if (!empty($letter)) {
            $query = $query->where('company', 'like', $letter . '%');
        }

        $totalNumber = $query->count();

        $resultQuery = $query->orderBy($sortColumn, $sortDir)
            ->skip($page * $rowsPerPage)
            ->take($rowsPerPage);

        return [
            'total'  => $totalNumber,
            'result' => $resultQuery->get()
        ];
    }

    public function updateSleeplab($sleeplabId, $data = [])
    {
        return $this->where('sleeplabid', $sleeplabId)
            ->update($data);
    }
}
