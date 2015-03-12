<?php namespace Ds3\Http\Controllers\Admin;

use Ds3\Admin\Contracts\BackOfficeUserInterface as BackOfficeUser;
use Ds3\Http\Requests;
use Ds3\Http\Controllers\Controller;
use Ds3\Libraries\Constants;
use Ds3\Http\Requests\BackOfficeUserRequest;

class BackOfficeController extends Controller
{
    private $backOfficeUsers;

    public function __construct(BackOfficeUser $backOfficeUser)
    {
        $this->backOfficeUsers = $backOfficeUser;
    }

    public function getIndex()
    {
        return view('admin.backofficeusers.index')
            ->with('backOfficeUsers', $this->backOfficeUsers->all());
    }

    public function getAddBackOfficeUser()
    {
        $companies = $this->backOfficeUsers->companies()->lists('name', 'id');
        $access_labels = Constants::$dss_admin_access_labels;

        return view('admin.backofficeusers.new')
            ->with('access_level', $access_labels ? $access_labels : ['None'])
            ->with('companies', $companies ? $companies : ['None']);
    }

    public function postAddBackOfficeUser(BackOfficeUserRequest $request)
    {
        if ($this->backOfficeUsers->save($request->all())) {
            return redirect('manage/admin/backoffice/users');
        }
    }

    public function getUpdateBackOfficeUser($id)
    {
        $companies     = $this->backOfficeUsers->companies()->lists('name', 'id');
        $user          = $this->backOfficeUsers->userCompany($id);
        $access_labels = Constants::$dss_admin_access_labels;
        if (isset($user)) {
            $companyId = $user->company_id;
        } else {
            $companyId = null;
        }

        return view('admin.backofficeusers.edit')
            ->with('access_level', $access_labels ? $access_labels : ['None'])
            ->with('companies', $companies ? $companies : ['None'])
            ->with('user_company', $companyId)
            ->with('backOfficeUser', $this->backOfficeUsers->find($id));
    }

    public function postUpdateBackOfficeUser(BackOfficeUserRequest $request, $id)
    {
        if ($this->backOfficeUsers->update($id,$request->all())) {
            return redirect('manage/admin/backoffice/users')->with('success', 'User Updated Successfully');
        } else {
            return redirect()->back()->with('errors', 'User couldn\'t updated successfully');
        }
    }

    public function deleteBackOfficeUser($id)
    {
        if ($this->backOfficeUsers->delete($id)) {
            return redirect()->back()->with('success', 'User deleted successfully');
        } else {
            return redirect()->back()->with('success', 'User couldn\'t deleted');
        }
    }
}
