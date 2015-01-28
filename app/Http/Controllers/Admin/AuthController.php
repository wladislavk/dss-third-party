<?php namespace Ds3\Http\Controllers\Admin;

use Ds3\Admin\Contracts\AdminInterface;
use Ds3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Ds3\Auth\AuthenticateInterface;
use Ds3\Eloquent\Admin;
use Ds3\Eloquent\Auth\User;

class AuthController extends Controller {

    private $auth;
    private $admin;
    public function __construct(AuthenticateInterface $auth,AdminInterface $admin)
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
            return redirect('manage/admin/login')->withErrors($validator);
        }else
        {
            try {
                 $this->auth->attempt($fields['username'],$fields['password'],'User');
            }catch (Exception $e){
                    dd($e->getMessage());
            }
            $user = 0;
            if($user)
            {

                Session::put('admin_user_id',$user->adminid);
                Session::put('admin_access',$user->admin_access);
                Session::put('admin_company_id',$user->companyid);
                return redirect('manage/admin/dashboard');

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
                                       ->with('message','Your Password is wrong');
                    }
                }
            }else
            {
                return Redirect::to('manage/admin/login')
                                ->with('errors','User Not Found');
            }
        }

    }
    public function logout()
    {
        Session:flush();
        return Redirect::to('manage/admin/login');
    }
} 

