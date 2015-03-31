<?php namespace Ds3\Eloquent;

use Ds3\Http\Requests\Request;
use Illuminate\Database\Eloquent\Model;
use Ds3\Eloquent\Auth\User;

class Company extends Model
{
    protected $table = 'companies';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name','add1','address_2','city','state','zip','phone',
        'fac','email','eligible_api_key','stripe_secret_key','stripe_publishable_key',
        'sfax_security_context','sfax_app_id','sfax_app_key','sfax_encryption_key',
        'sfax_init_vector','company_type','vob_require_test','plan_id','status','use_support',
        'exclusive','ip_address'
    ];

    public function users($type = null, $company_id = null)
    {
        if ($type == 'DSS_COMPANY_TYPE_HST') {
            return User::join('dental_user_hst_company as uhc', 'uhc.userid', '=', 'dental_users.userid')
                ->where('uhc.companyid', $company_id)
                ->select('users.userid')
                ->count();
        } elseif ($type == 'DSS_COMPANY_TYPE_BILLING') {
            return $this->hasMany(new User, 'billing_company_id');
        } else {
            return UserCompany::where('companyid', $company_id)->count();
        }

    }
}
