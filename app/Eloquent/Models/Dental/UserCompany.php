<?php

namespace DentalSleepSolutions\Eloquent\Models\Dental;

use DentalSleepSolutions\Eloquent\Models\AbstractModel;
use DentalSleepSolutions\Eloquent\Models\Company;

class UserCompany extends AbstractModel
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['userid', 'companyid', 'adddate', 'ip_address'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dental_user_company';

    /**
     * @var bool
     */
    public $timestamps = false;

    public function company()
    {
        $this->belongsTo(Company::class, 'companyid');
    }

    /**
     * return api key from user
     *
     * @param $id
     * @return mixed
     */
    public static function getApiKey($id)
    {
        $return = self::select(['eligible_api_key'])
            ->leftJoin('companies', 'companyid', '=', 'companies.id')
            ->where('userid', $id)
            ->first();
        if ($return && $return->eligible_api_key != '') {
            return $return->eligible_api_key;
        }
        return false;
    }

}
