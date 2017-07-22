<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ProfileImage;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ProfileImageRepository extends AbstractRepository
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
