<?php namespace Ds3\Http\Controllers\Admin;

use Ds3\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Ds3\Admin\Contracts\UserInterface;
use Ds3\Http\Requests\AddUserRequest;
use Ds3\Libraries\Constants;

class UserController extends Controller
{
    private $user;

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return view('admin.user.index')
            ->with('users',$this->user->getAllUsers());
    }

    public function getNewUser()
    {
        return view('admin.user.new')
            ->with('billingPlans', $this->user->getUserPlansWithStatus(3))  // get plan where office_type = 3
            ->with('softwarePlans', $this->user->getUserPlansWithStatus(1)) // get plan where office_type = 1
            ->with('accessCode', $this->user->getAccessCode())
            ->with('billingCompanyType', $this->user->getCompanies(Constants::DSS_COMPANY_TYPE_BILLING))
            ->with('userType', $this->user->getUserType())
            ->with('adminCompanies', $this->user->getCompanies(Constants::DSS_COMPANY_TYPE_SOFTWARE));
    }

    public function postNewUser(AddUserRequest $request)
    {
        return response('Friend added!');
    }

    public function show($id)
    {
        return view('admin.user.edit')
            ->with('user', $this->user->findUser($id));
    }

    public function update($id)
    {
        if ($this->user->updateUser($id)) {
            return Redirect::to("manage/admin/users")->with('message', 'User updated successfully');
        } else {
            return Redirect::to("manage/admin/users")->with('message', 'User could not be updated');
        }
    }

    public function suspend($id)
    {
        if ($this->user->suspendUser($id)) {
            return Redirect::to('manage/admin/users')->with('message', 'User suspended successfully');
        } else {
            return Redirect::back('manage/admin/users')->with('message', 'User could not be suspended');
        }
    }

    public function unSuspend($id)
    {
        if ($this->user->unSuspendUser($id)) {
            return Redirect::to('manage/admin/users')->with('message', 'User un-suspended successfully');
        } else {
            return Redirect::back('manage/admin/users');
        }
    }

    public function delete($id)
    {
        if ($this->user->deleteUser($id)) {
            return Redirect::to('manage/admin/users')->with('message', 'User deleted successfully');
        } else {
            return Redirect::to('manage/admin/users')->with('message', 'User could not be deleted successfully');
        }
    }
}
