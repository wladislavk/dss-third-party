<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\ContactType;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class ContactTypeRepository extends AbstractRepository
{
    public function model()
    {
        return ContactType::class;
    }

    /**
     * @return mixed
     */
    public function getActiveNonCorporateTypes()
    {
        return $this->model->select('contacttypeid', 'contacttype')
            ->active()
            ->nonCorporate()
            ->orderBy('sortby')
            ->get();
    }

    /**
     * @return mixed
     */
    public function getPhysicianTypes()
    {
        return $this->model->select(\DB::raw('GROUP_CONCAT(contacttypeid) as physician_types'))
            ->physician()
            ->groupBy('physician')
            ->first();
    }

    /**
     * @return mixed
     */
    public function getSorted()
    {
        return $this->model->orderBy('sortby')->get();
    }
}
