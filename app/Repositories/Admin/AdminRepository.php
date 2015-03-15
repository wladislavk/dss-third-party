<?php namespace Ds3\Admin\Repositories;

use Carbon\Carbon;
use Ds3\Admin\Contracts\AdminInterface;
use Ds3\Eloquent\Admin;
use Ds3\Libraries\Password;
use Illuminate\Support\Facades\Auth;

class AdminRepository implements AdminInterface
{
    public function getByUsername($username)
    {
        return Admin::where('username', $username)->select('adminid', 'username', 'email')->first();
    }

    public function recoverAndSetHash($admin_id, $email)
    {
        $hash = hash('sha256', $admin_id.$email.rand());
        $updated = Admin::where('adminid', $admin_id)
                        ->update(['recover_hash'=>$hash, 'recover_time'=>Carbon::now()]);
        if ($updated) {
            return 'true';
        }
    }

    public function attemptAuth($username, $password)
    {
        $salt =  Admin::where('username', $username)
            ->where('status',1)
            ->select('salt')
            ->first();

        $genPass = Password::genPassword($password, $salt);

        $user = Admin::where('admin.username', $username)
            ->where('admin.password', $genPass)
            ->leftJoin('admin_company', 'admin_company.adminid', '=', 'admin.adminid')
            ->select('admin_company.companyid', 'admin.adminid', 'admin.admin_access')
            ->first();
        if (count($user) == 1) {
            Auth::login($user);
            return ['status' => 'true', 'user' => $user];
        } else {
            return ['status' => 'false'];
        }
    }
}
