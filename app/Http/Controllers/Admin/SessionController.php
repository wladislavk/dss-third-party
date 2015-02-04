<?php namespace Ds3\Http\Controllers\Admin;

use Ds3\Admin\Contracts\AdminInterface;
use Ds3\Ds3Auth\Ds3AuthInterface;
use Ds3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class SessionController extends Controller {

    private $auth;
    private $admin;
    public function __construct(Ds3AuthInterface $auth,AdminInterface $admin)
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
                 $user = $this->auth->attempt($fields['username'],$fields['password'],'Admin');

            }catch (Exception $e){
                    dd($e->getMessage());
            }
            if(!empty($user))
            {
                Session::put('admin_user_id',$user->adminid);
                Session::put('admin_access',"$user->admin_access");
                Session::put('admin_company_id',"$user->companyid");

                return redirect('manage/admin/dashboard');

            }elseif($user->status == 3)
            {
                return redirect('manage/admin/login')
                                ->with('errors','User is banned');
            }else
            {
                return redirect('manage/admin/login')->with('errors','Wrong Password');
            }
        }

    }
    public function logout()
    {
        Session:flush();
        return Redirect::to('manage/admin/login');
    }
} 

