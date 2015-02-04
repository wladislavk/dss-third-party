<?php namespace Ds3\Ds3Auth;

use Ds3\Eloquent\Admin;
use Ds3\Eloquent\Auth\User;
use Ds3\Libraries\Password;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Exception;
class Ds3Auth implements Ds3AuthInterface
{
	private $user;

	 function getByUsername($username,$model)
    {
         return $model::where('username',$username)->first();
    
            
    }
    public function recoverAndSetHash($id,$email,$model,$columnName)
    {  
        $hash = hash('sha256', $id.$email.rand());
        $updated = $model->where("$columnName",$id)
                         ->update(['recover_hash'=>$hash,'recover_time'=>Carbon::now()]);

        if($updated)
        {
            return 'true';
        }else
        {
            return 'false';
        }
    }

   	public function getUserSalt($username,$model)
	{
		return  $model->where('username',$username)->where('status',1)->select('salt')->first();
	}
	 public function generatePassword($password,$salt)
	{
		return Password::genPassword($password,$salt);
	}
	 public function attempt($username,$password,$model)
    {
        if($model == 'User')
        {
            $this->user = $this->getByUsername($username,new User);
        }elseif($model == 'Admin')
        {
            $this->user = $this->getByUsername($username,new Admin);
        }

    	if($this->user == null)
    	{
    		return 'User not found';
    	}

    	if($model == 'Admin')
        {
            self::recoverAndSetHash($this->user->adminid,$this->user->email,new Admin,'adminid');

            $generatedPassword = $this->generatePassword($password,$this->getUserSalt($username,new Admin));
            $user = Admin::where('admin.username',$username)
                  		 ->where('admin.password',$generatedPassword)
                  		 ->leftJoin('admin_company','admin_company.adminid','=','admin.adminid')
                  		 ->select('admin_company.companyid','admin.adminid','admin.admin_access')
                  		 ->first();

            if(empty($user))
            {
                return "Wrong Password";
//                return new Exception("Wrong Password");
            }else
            {
                return $user;
            }

    	}
        if($model == 'User')
        {
            self::recoverAndSetHash($this->user->userid,$this->user->email,new User,'userid');
            $generatedPassword = $this->generatePassword($password,$this->getUserSalt($username,new User));
            $user = User::where('username',$username)
                          ->where('password',$generatedPassword)
                          ->whereIn('status',[1, 3])
                          ->select("dental_users.userid",
                                    "dental_users.username",
                                    "dental_users.name",
                                    "dental_users.first_name",
                                    "dental_users.last_name",
                                    "dental_users.user_access",
                                    "dental_users.status",
                                    \DB::raw("CASE docid WHEN 0 THEN dental_users.userid ELSE docid END as docid"))
                          ->raw(\DB::raw("LEFT JOIN dental_user_company uc ON uc.userid=(CASE docid WHEN 0 THEN dental_users.userid ELSE docid END)"))
                          ->first();
            if($user)
            {
                if( $user->status == 3)
                {
                    return $user;
                }
            }else
            {
                return "Wrong password";
            }
        }
    	
        if($this->user)
        {
            Auth::login($user);
            return $user;
        }else
        {
            return 'false';
        }
    }
}
