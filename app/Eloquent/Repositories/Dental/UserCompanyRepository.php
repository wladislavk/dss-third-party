<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Dental;

use DentalSleepSolutions\Eloquent\Models\Dental\UserCompany;
use Prettus\Repository\Eloquent\BaseRepository;

class UserCompanyRepository extends BaseRepository
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
