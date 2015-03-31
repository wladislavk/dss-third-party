<?php namespace Ds3\Ds3Auth;

use Ds3\Eloquent\Admin;
use Ds3\Eloquent\Auth\User;
use Ds3\Libraries\Password;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Request;
use Session;
use Ds3\Ds3Auth\Ds3AuthInterface;

class Ds3Auth implements Ds3AuthInterface
{
    private $user;

    public function getByUsername($username, $model)
    {
        return $model::where('username', $username)->first();
    }

    public function recoverAndSetHash($id, $email, $model, $columnName)
    {
        $hash = hash('sha256', $id.$email.rand());
        $updated = $model->where("$columnName", $id)
                         ->update(['recover_hash'=>$hash, 'recover_time'=>Carbon::now()]);

        if ($updated) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function getUserSalt($username, $model)
    {
        return $model->where('username', $username)->where('status', 1)->select('salt')->first();
    }

    public function generatePassword($password, $salt)
    {
        return Password::genPassword($password, $salt);
    }

    public function attempt($username, $password)
    {
        if ($this->isAdmin()) {
            Config::set('auth.model', 'Admin');
            $this->user = $this->getByUsername($username, new Admin);
            if (!$this->user) {
                throw new Exception('User Not Found');
            } elseif($this->user->status == 3) {
                throw new Exception('User is Banned');
            } else {
                self::recoverAndSetHash($this->user->adminid, $this->user->email, new Admin, 'adminid');

                $generatedPassword = $this->generatePassword($password, $this->getUserSalt($username, new Admin));
                $user = Admin::where('admin.username', $username)
                    ->where('admin.password', $generatedPassword)
                    ->leftJoin('admin_company', 'admin_company.adminid', '=', 'admin.adminid')
                    ->select('admin_company.companyid', 'admin.adminid', 'admin.admin_access')
                    ->first();

                if (empty($user)) {
                    throw new Exception('Wrong password');
                }

                if ($user) {
                    Auth::login($user);
                    Session::put('admin_user_id', $user->adminid);
                    Session::put('admin_access', "$user->admin_access");
                    Session::put('admin_company_id', "$user->companyid");

                    return $user;
                }
            }
        }

        if ($this->isUser()) {
            $this->user = $this->getByUsername($username, new Admin);
            if (!$this->user) {
                throw new Exception('User Not Found');
            } else {
                self::recoverAndSetHash($this->user->userid, $this->user->email, new User, 'userid');
                $generatedPassword = $this->generatePassword($password, $this->getUserSalt($username, new User));
                $user = User::where('username', $username)
                    ->where('password', $generatedPassword)
                    ->whereIn('status', [1, 3])
                    ->select("dental_users.userid", "dental_users.username", "dental_users.name", "dental_users.first_name", "dental_users.last_name",
                        "dental_users.user_access", "dental_users.status",
                        \DB::raw("CASE docid WHEN 0 THEN dental_users.userid ELSE docid END as docid"))
                    ->raw(\DB::raw("LEFT JOIN dental_user_company uc ON uc.userid=(CASE docid WHEN 0 THEN dental_users.userid ELSE docid END)"))
                    ->first();
                if (empty($user)) {
                    throw new Exception('Wrong password');
                }

                if ($user) {
                    return $user;
                }
            }

            if ($this->user) {
                Auth::login($user);
                return $user;
            } else {
                return 'false';
            }
        }
    }

    public function isAdmin()
    {
        if (Request::is('manage/admin/login')) {
            return true;
        } else {
            return false;
        }
    }

    public function isUser()
    {
        dd(Request::is('manage/login'));
        if (Request::is('manage/login')) {
            return true;
        } else {
            return false;
        }
    }
}
