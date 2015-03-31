<?php namespace Ds3\Admin\Repositories;

use Ds3\Admin\Contracts\BackOfficeUserInterface;
use Ds3\Eloquent\Admin;
use Ds3\Eloquent\AdminCompany;
use Ds3\Eloquent\Auth\User;
use Ds3\Eloquent\Company;
use Ds3\Libraries\Password;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class BackOfficeUserRepository implements BackOfficeUserInterface
{
    private $user;
    private $admin;
    private $company;
    private $adminCompany;

    public function __construct(
        User $user,
        Admin $admin,
        Company $company,
        AdminCompany $adminCompany
    ) {
        $this->user         = $user;
        $this->admin        = $admin;
        $this->company      = $company;
        $this->adminCompany = $adminCompany;
    }

    public function all()
    {
        return $this->admin->leftJoin('admin_company as ac', 'admin.adminid', '=', 'ac.adminid')
            ->leftJoin('companies as c', 'ac.companyid', '=', 'c.id')
//            ->where('c.id', Session::get('admin_company_id'))
            ->orderBy('admin.adminid', 'DESC')
            ->select('admin.*', 'c.id as company_id', 'c.name as company_name')
            ->get();
    }

    public function find($id)
    {
        return $this->admin->find($id);
    }

    public function update($id, $fields)
    {
        $admin = $this->admin->find($id)->update($fields);
        if ($admin) {
            $updated = $this->adminCompany->where('adminid', $id)->update([
                'companyid'   => Request::input('companyid'),
                'ip_address'  => Request::ip()
            ]);
            if ($updated) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function delete($id)
    {
        if ($this->admin->find($id)->delete()) {
            $this->adminCompany->where('adminid', $id)->delete();
        } else {
            return false;
        }
    }

    public function save($fields)
    {
        $fields['password'] = Password::genPassword($fields['password'], Password::createSalt());
        $admin = $this->admin->create($fields);
        if ($admin) {
            $created = $this->adminCompany->create([
                'adminid'    => $admin->adminid,
                'companyid'  => $fields['companyid'],
                'ip_address' => Request::ip()
            ]);
            if ($created) {
                return true;
            }
        } else {
            return false;
        }
    }

    public function companies()
    {
        return $this->company->select('name', 'id')->get();
    }

    public function userCompany($id)
    {
        return $this->admin->where('admin.adminid', $id)
            ->leftJoin('admin_company as ac', 'admin.adminid', '=', 'ac.adminid')
            ->join('companies as c', 'ac.companyid', '=', 'c.id')
            ->select('c.id as company_id')
            ->first();
    }
}
