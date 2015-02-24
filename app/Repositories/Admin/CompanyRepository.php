<?php namespace Ds3\Admin\Repositories;

use Ds3\Admin\Contracts\CompanyInterface;
use Ds3\Eloquent\Company;
use Ds3\Eloquent\Plan;
use Ds3\Http\Requests\Request;
use Ds3\Libraries\Constants;
use Illuminate\Support\Facades\DB;

class CompanyRepository implements CompanyInterface {

    private $company;

    public function __construct( Company $company )
    {
        $this->company = $company;
    }

    public function all()
    {
        $result = DB::select('select c.*, count(a.adminid) as numberOfAdmins, count(b.adminid) as numberOfUsers, p.name as plan_name
                              from companies c LEFT JOIN admin_company ac ON ac.companyid = c.id
                              LEFT JOIN admin a ON a.adminid=ac.adminid
                              AND (a.admin_access="'.Constants::DSS_ADMIN_ACCESS_ADMIN.'"
                              OR a.admin_access="'.Constants::DSS_ADMIN_ACCESS_BILLING_ADMIN.'"
                              OR a.admin_access="'.Constants::DSS_ADMIN_ACCESS_HST_ADMIN.'")
                              LEFT JOIN admin b ON b.adminid=ac.adminid
                              AND (b.admin_access="'.Constants::DSS_ADMIN_ACCESS_BASIC.'"
                              OR b.admin_access="'.Constants::DSS_ADMIN_ACCESS_BILLING_BASIC.'"
                              OR b.admin_access="'.Constants::DSS_ADMIN_ACCESS_HST_BASIC.'")
                              LEFT JOIN dental_plans p ON p.id = c.plan_id group by c.id order by name ASC');

            return Company::hydrate($result,new Company);

    }
    public function save($fields)
    {
        if($this->company->create($fields))
        {
            return true;
        }else
        {
            return false;
        }
    }
    public function plans()
    {
        return Plan::where('office_type',2);
    }

    public function update($id,$fields)
    {
        if($this->company->find($id)->update($fields))
        {
            return true;
        }else
        {
            return false;
        }
    }

    public function find($id)
    {
        return $this->company->find($id);
    }

    public function delete($id)
    {
        if( $this->company->find($id)->delete() )
        {
            return true;
        }else
        {
            return false;
        }
    }
}