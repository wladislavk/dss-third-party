<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ProfileImage;
use Prettus\Repository\Eloquent\BaseRepository;

class ProfileImageRepository extends BaseRepository
{
    public function model()
    {
        return ProfileImage::class;
    }

    /**
     * @param int $patientId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getProfilePhoto($patientId)
    {
        return $this->model->profilePhoto()
            ->where('patientid', $patientId)
            ->orderBy('adddate', 'desc')
            ->first();
    }

    /**
     * @param int $patientId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getInsuranceCardImage($patientId)
    {
        return $this->model->insuranceCardImage()
            ->where('patientid', $patientId)
            ->orderBy('adddate', 'desc')
            ->first();
    }
}
