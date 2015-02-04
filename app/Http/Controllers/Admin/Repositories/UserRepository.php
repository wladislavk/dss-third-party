<?php namespace Ds3\Admin\Repositories;

use Carbon\Carbon;
use Ds3\Eloquent\AccessCode;
use Ds3\Eloquent\AdminCompany;
use Ds3\Eloquent\Auth\User;
use Ds3\Admin\Contracts\UserInterface;
use Ds3\Eloquent\Company;
use Ds3\Eloquent\Plan;
use Ds3\Libraries\Constants;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class UserRepository  implements UserInterface {

    private $user;
    private $company;
   public function __construct(User $user,Company $company)
   {
        $this->user = $user;
       $this->company = $company;
   }
    public function getAllUsers()
    {
        $query = null;
        $access = Session::get('admin_access');
        $cid = Input::get('cid');

//        if -> is_super_user
        if( $this->user->is_super( $access ) )
        {
            $query = $this->user->leftJoin('dental_user_company as duc','duc.userid','=','dental_users.userid')
                ->leftJoin('companies as c','c.id','=','duc.companyid')
                ->leftJoin('dental_plans as dp','dp.id','=','dental_users.plan_id')
                ->where('dental_users.user_access','=', '2')
                ->select('dental_users.*', 'c.name as company_name','dp.name as plan_name');

            $query = $query;
            if($cid)
            {
                $query = $query->where('c.id',$cid);
            }
        // if -> is_admin
        }elseif( $this->user->is_admin( $access ) )
        {
            $query = $this->user->join('dental_user_company as duc','duc.userid','=','dental_users.userid')
                ->join('companies as c','c.id','=','duc.companyid')
                ->leftJoin('dental_plans as dp','dp.id','=','dental_users.plan_id')
                ->where('dental_users.user_access','=', '2')
                ->where('duc.companyid','=',Session::get('admin_company_id'))
                ->orderBy('dental_users.last_name')
                ->orderBy('dental_users.first_name');
            $query = $query;

//      if -> is_billing
        }elseif( $this->user->is_billing( $access ) )
        {

            $adminCompany = AdminCompany::join('admin as a','a.adminid','=','admin_company.adminid')
                                        ->where('a.adminid',Session::get('admin_user_id'))
                                        ->select('admin_company.companyid')
                                        ->first();
            $query = $this->user->join('dental_user_company as duc','duc.userid','=','dental_users.userid')
                       ->join('companies as c','c.id','=','duc.companyid')
                       ->leftJoin('dental_plans as dp','dp.id','=','dental_users.plan_id')
                       ->where('dental_users.user_access','2')
                       ->where('dental_users.billing_company_id',$adminCompany->companyid)
                       ->orderBy('dental_users.last_name')
                       ->orderBy('dental_users.first_name');
        }

        return $query->get();
    }
    public function getUserWithStatus($status){}

    public function getUserByName($username)
    {
        return 'foo';
    }
    public function suspendUser($userId)
    {
        $user = $this->user->find($userId);
        $user->suspended_date = Carbon::now();
        if($user->save())
        {
            return 'true';
        }else
        {
            return 'false';
        }
    }
    public function findUser($userId)
    {
        return User::find($userId);
    }
    public function updateUser($userId)
    {
        $user = User::find($userId);
        $user->first_name = Input::get('first_name');
        $user->last_name = Input::get('last_name');
        $user->email = Input::get('email');

        if($user->save())
        {
            return 'true';
        }else
        {
            return 'false';
        }
    }
    public function unSuspendUser($userId)
    {
        $user = User::find($userId);
        $user->suspended_date = null;

        if($user->save())
        {
            return 'true';
        }else
        {
            return 'false';
        }
    }

    public function deleteUser($userId)
    {
        $user = User::find($userId);

        if($user->delete())
        {
            return 'true';
        }else
        {
            return 'false';
        }
    }
    public function getCompanies($companyType)
    {
            return $this->company->where('company_type',$companyType)->orderBy('name','ASC')->lists('name','id','None','null');
    }
    public function getUserType()
    {
        return Constants::$UserTypeLabel;
    }
    public function getAccessCode()
    {
        return AccessCode::orderBy('access_code','ASC')->lists('access_code','id');
    }
    public function getPlans($planType)
    {
        return Plan::where('office_type',$planType)->orderBy('name','ASC')->lists('name','id');
    }

} 