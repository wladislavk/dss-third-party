<?php namespace Ds3\Http\Controllers\Admin;

use Ds3\Admin\Contracts\AdminInterface;
use Ds3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller {

    private $auth;
    private $admin;
    public function __construct(Auth $auth,AdminInterface $admin)
    {
        $this->auth = $auth;
        $this->admin = $admin;
    }
    public function index()
    {
        return view('admin.auth.index');
    }

    public function login()
    {
        $fields = [
            'username' => Input::get('username'),
            'password' => Input::get('password')
        ];
        $rules = ['username'=>'required','password'=>'required'];
        $validator = Validator::make($fields,$rules);
        if($validator->fails())
        {
            return Redirect::to('manage/admin/login');
        }else
        {
            $user = $this->admin->getByUsername($fields['username']);
            if($user)
            {
                $setAndRecoverd = $this->admin->recoverAndSetHash($user->adminid,$user->email);
                if($setAndRecoverd)
                {
                    $auth = $this->admin->attemptAuth($user->username,$fields['password']);
                    if($auth['status'] == 'true')
                    {
                        Session::put('adminuserid',$auth['adminid']);
                        Session::put('admin_access',$auth['admin_access']);
                        Session::put('admincompanyid',$auth['companyid']);

                        return Redirect::to('manage/admin/dashboard')
                                       ->with('message','Welcome Admin');
                    }else
                    {
                        return Redirect::to('manage/admin/login')
                                       ->with('message','Your Password of wrong');
                    }
                }
            }else
            {
                return Redirect::to('manage/admin/login')
                                ->with('message','User Not Found');
            }
        }

    }
} 