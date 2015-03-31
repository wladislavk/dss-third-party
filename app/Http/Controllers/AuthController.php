<?php namespace Ds3\Http\Controllers;

use Ds3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use Ds3\Http\Requests\AuthFormRequest;
use Ds3\Contracts\UserInterface;
use Ds3\Contracts\LoginInterface;
use Ds3\Contracts\LoginDetailInterface;

class AuthController extends Controller
{
    private $user;
    private $login;
    private $loginDetail;

    public function __construct(UserInterface $user, LoginInterface $login, LoginDetailInterface $loginDetail)
    {
        $this->user = $user;
        $this->login = $login;
        $this->loginDetail = $loginDetail;
    }

    public function index()
    {
        return view('manage.login');
    }

    public function login(AuthFormRequest $request)
    {
        if (!empty(Session::get('loginId'))) {
            $data = array(
                'loginid'     => Session::get('loginId'),
                'userid'      => Session::get('userId'),
                'cur_page'    => $request->route()->uri(),
                'ip_address'  => $request->ip()
            );

            $this->loginDetail->insertData($data);
        }

        $requestUser = $request->all();
        
        $msg = 'Wrong username or password';

        $authResponse = $this->user->attemptAuth($requestUser['username'], $requestUser['password']);

        if ($authResponse['success']) {
            if ($authResponse['user']->status == '3') {
                $msg = 'This account has been suspended.';

                return view('manage.login')->with('msg', $msg)
                                           ->with('username', $requestUser['username']);
            } else {
                if ($authResponse['user']->docid != 0) {
                    $authResponse['user']->user_type = $this->user->getType($authResponse['user']->docid);                     
                } else {
                    $authResponse['user']->docid = $authResponse['user']->userid;
                }

                $data = array(
                    'docid'       => $authResponse['user']->docid,
                    'userid'      => $authResponse['user']->userid,
                    'login_date'  => date("Y-m-d H:i:s"),
                    'ip_address'  => $request->ip()
                );

                $loginId = $this->login->insertData($data);

                Session::put('loginId', $loginId);
                Session::put('companyId', $authResponse['user']->companyid);
                Session::put('docId', $authResponse['user']->docid);
                Session::put('userType', $authResponse['user']->user_type);
                Session::put('userId', $authResponse['user']->userid);
                Session::put('username', $authResponse['user']->username);

                return redirect('/manage/index');
            }
        } else {
            return view('manage.login')->with('msg', $msg)
                                       ->with('username', $requestUser['username']);
        }
    }

    public function logout()
    {
        $loginUp = $this->login->updateData(Session::get('loginId'), array(
            'logout_date' => date('Y-m-d H:i:s')
        ));

        Session::flush();

        return redirect('manage/login');
    }
}
