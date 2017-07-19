<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Traits\WithoutUpdatedTimestamp;
use DentalSleepSolutions\Contracts\Resources\ProfileImage as Resource;
use DentalSleepSolutions\Contracts\Repositories\ProfileImages as Repository;

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
