<?php namespace Ds3\Http\Controllers\Admin;

use Ds3\Admin\Contracts\AdminInterface;
use Ds3\Ds3Auth\Ds3AuthInterface;
use Ds3\Http\Controllers\Controller;
use Ds3\Http\Requests\AuthRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Config;
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

    public function login(AuthRequest $request)
    {
        try
            {
                $user = $this->auth->attempt($request->input('username'),$request->input('password'));

            }catch(\Exception $e)
            {
                return redirect()->back()->withErrors($e->getMessage());
            }
            if( ! empty( $user ) )
            {
                return redirect('manage/admin/dashboard');
            }
    }
    public function logout()
    {
        return Redirect::to('manage/admin/login');
    }
} 

