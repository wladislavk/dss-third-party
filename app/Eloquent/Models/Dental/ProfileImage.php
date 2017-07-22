<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;

/**
 * @SWG\Definition(
 *     definition="ProfileImage",
 *     type="object",
 *     required={"imageid"},
 *     @SWG\Property(property="imageid", type="integer"),
 *     @SWG\Property(property="formid", type="integer"),
 *     @SWG\Property(property="patientid", type="integer"),
 *     @SWG\Property(property="title", type="string"),
 *     @SWG\Property(property="image_file", type="string"),
 *     @SWG\Property(property="imagetypeid", type="integer"),
 *     @SWG\Property(property="userid", type="integer"),
 *     @SWG\Property(property="docid", type="integer"),
 *     @SWG\Property(property="status", type="integer"),
 *     @SWG\Property(property="adddate", type="string", format="dateTime"),
 *     @SWG\Property(property="ip_address", type="string"),
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
 * @mixin \Eloquent
 */
class ProfileImage extends AbstractModel
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

    const CREATED_AT = 'adddate';

    const PROFILE_PHOTO_ID = 4;
    const INSURANCE_CARD_IMAGE_ID = 10;
}
