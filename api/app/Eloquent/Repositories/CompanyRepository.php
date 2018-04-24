<?php

namespace DentalSleepSolutions\Eloquent\Repositories;

use DentalSleepSolutions\Eloquent\Models\Company;
use Illuminate\Database\Query\JoinClause;

class CompanyRepository extends AbstractRepository
{
    public function model()
    {
        return Company::class;
    }

    /**
     * @param int $userId
     * @return Company|null
     */
    public function getCompanyByUser(int $userId): ?Company
    {
        /** @var Company|null $result */
        $result = $this->model
            ->from(\DB::raw('companies c'))
            ->select(\DB::raw('c.*'))
            ->join(\DB::raw('dental_user_company uc'), 'uc.companyid', '=', 'c.id')
            ->where('uc.userid', $userId)
            ->first()
        ;
        return $result;
    }

    /**
     * @param int $docId
     * @return array|\Illuminate\Database\Eloquent\Collection
     */
    public function getHomeSleepTestCompanies($docId)
    {
        return $this->model
            ->select('h.*', \DB::raw('uhc.id as uhc_id'))
            ->from(\DB::raw('companies h'))
            ->join(\DB::raw('dental_user_hst_company uhc'), function (JoinClause $query) use ($docId) {
                $query
                    ->on('uhc.companyid', '=', 'h.id')
                    ->where('uhc.userid', '=', $docId)
                ;
            })
            ->where('h.company_type', Company::DSS_COMPANY_TYPE_HST)
            ->orderBy('name')
            ->get()
        ;
    }

    /**
     * @param int $docId
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getBillingExclusiveCompany($docId)
    {
        return $this->model
            ->select('c.name', 'c.exclusive')
            ->from(\DB::raw('companies c'))
            ->join(\DB::raw('dental_users u'), 'c.id', '=', 'u.billing_company_id')
            ->where('u.userid', $docId)
            ->first()
        ;
    }
}
