<?php

namespace DentalSleepSolutions\Structs;

use DentalSleepSolutions\Exceptions\GeneralException;
use Illuminate\Database\Eloquent\Model;

class ContactData
{
    /** @var array */
    private $patients = [];

    /** @var array */
    private $mds = [];

    /** @var array */
    private $mdReferrals = [];

    /** @var array */
    private $patientReferrals = [];

    public function setPatients(array $patients)
    {
        $this->patients = $this->useToArrayOnModels($patients);
        return $this;
    }

    public function getPatients()
    {
        return $this->patients;
    }

    public function setMds(array $mds)
    {
        $this->mds = $this->useToArrayOnModels($mds);
        return $this;
    }

    public function getMds()
    {
        return $this->mds;
    }

    public function setMdReferrals(array $mdReferrals)
    {
        $this->mdReferrals = $this->useToArrayOnModels($mdReferrals);
        return $this;
    }

    public function getMdReferrals()
    {
        return $this->mdReferrals;
    }

    public function setPatientReferrals(array $patientReferrals)
    {
        $this->patientReferrals = $this->useToArrayOnModels($patientReferrals);
        return $this;
    }

    public function getPatientReferrals()
    {
        return $this->patientReferrals;
    }

    /**
     * @param Model[] $models
     * @return array[]
     * @throws GeneralException
     */
    private function useToArrayOnModels(array $models)
    {
        $result = [];
        foreach ($models as $model) {
            if (!$model instanceof Model) {
                throw new GeneralException('Instance of ' . Model::class . ' expected, got ' . get_class($model));
            }
            $result[] = $model->toArray();
        }
        return $result;
    }
}
