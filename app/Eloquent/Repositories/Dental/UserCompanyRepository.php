<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\UserCompany;
use DentalSleepSolutions\Eloquent\Repositories\AbstractRepository;

class UserCompanyRepository extends AbstractRepository
{
    public function model()
    {
        return UserCompany::class;
    }

    /**
     * @param int $id
     * @return string|bool
     */
    public function getApiKey($id)
    {
        $return = $this->model->select(['eligible_api_key'])
            ->leftJoin('companies', 'companyid', '=', 'companies.id')
            ->where('userid', $id)
            ->first();
        if ($return && $return->eligible_api_key != '') {
            return $return->eligible_api_key;
        }
        return false;
    }
}
