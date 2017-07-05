<?php

namespace DentalSleepSolutions\Eloquent\Dental;

use DentalSleepSolutions\Eloquent\AbstractModel;
use DentalSleepSolutions\EloquentTraits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\ProfileImage as Resource;
use DentalSleepSolutions\Contracts\Repositories\ProfileImages as Repository;

/**
 * @SWG\Definition(
 *     definition="ProfileImage",
 *     type="object",
 *     required={"imageid"},
 *     @SWG\Property(property="imageid", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="title", type="string"),
 *     @SWG\Property(property="image", type="string"),
 *     @SWG\Property(property="imagetypeid", type="integer"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="adminid", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Dental\ProfileImage
 *
 * @property int $imageid
 * @property int|null $formid
 * @property int|null $patientid
 * @property string|null $title
 * @property string|null $image_file
 * @property int|null $imagetypeid
 * @property int|null $userid
 * @property int|null $docid
 * @property int|null $status
 * @property \Carbon\Carbon|null $adddate
 * @property string|null $ip_address
 * @property int|null $adminid
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage insuranceCardImage()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage profilePhoto()
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereAdddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereAdminid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereDocid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereFormid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereImageFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereImageid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereImagetypeid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage wherePatientid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Dental\ProfileImage whereUserid($value)
 * @mixin \Eloquent
 */
/**
 * @SWG\Definition(
 *     definition="ProfileImage",
 *     type="object",
 *     required={"imageid"},
 *     @SWG\Property(property="imageid", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="title", type="string"),
 *     @SWG\Property(property="image", type="string"),
 *     @SWG\Property(property="imagetypeid", type="integer"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip", type="string"),
 *     @SWG\Property(property="adminid", type="integer")
 * )
 */
class ProfileImage extends AbstractModel implements Resource, Repository
{
    use WithoutUpdatedTimestamp;

    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['imageid'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dental_q_image';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'imageid';

    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'adddate';

    public function scopeProfilePhoto($query)
    {
        return $query->where('imagetypeid', 4);
    }

    public function scopeInsuranceCardImage($query)
    {
        return $query->where('imagetypeid', 10);
    }

    public function getProfilePhoto($patientId = 0)
    {
        return $this->profilePhoto()
            ->where('patientid', $patientId)
            ->orderBy('adddate', 'desc')
            ->first();
    }

    public function getInsuranceCardImage($patientId = 0)
    {
        return $this->insuranceCardImage()
            ->where('patientid', $patientId)
            ->orderBy('adddate', 'desc')
            ->first();
    }
}
