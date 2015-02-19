<?php namespace Ds3\Http\Controllers\Admin;

use Ds3\Admin\Contracts\UserInterface;
use Ds3\Http\Requests\AddAccessCodeRequest;
use Ds3\Http\Controllers\Controller;
use Ds3\Admin\Contracts\AccessCodeInterface;

class AccessCodeController extends Controller {

    private $user;
    private $accesscode;


	public function __construct(UserInterface $user ,AccessCodeInterface $accesscode)
    {
        $this->user = $user;
        $this->accesscode = $accesscode;
    }
    public function getIndex()
    {
        return view('admin.accesscode.index')
                ->with('accessCodes',$this->accesscode->getAllAccessCodes()->paginate(20));
    }
    public function getAddAccessCode()
    {
        return view('admin.accesscode.new')
             ->with('plans',$this->user->getAllUserPlans()->lists('name','id'));
    }
    public function postAddAccessCode(AddAccessCodeRequest $request)
    {
        if ($this->accesscode->save($request->all()))
        {
            return redirect('manage/admin/accesscode')->with('success','Access Code Successfully added');
        }else
        {
            return redirect()->back()->with('error','Access Code Couldn\'t added');
        }

    }
    public function getUpdateAccessCode($id)
    {
        return view('admin.accesscode.edit')
             ->with('plans',$this->user->getAllUserPlans()->lists('name','id'))
             ->with('accesscode',$this->accesscode->find($id));
    }
    public function postUpdateAccessCode(AddAccessCodeRequest $request,$id)
    {
        if($this->accesscode->update($request->all(),$id))
        {
            return redirect()->to('manage/admin/accesscode')->with('success','Access Code Successfully updated');
        }else
        {
            return redirect()->back()->with('error','Access Code Couldn\'t updated successfully');
        }
    }
    public function getDeleteAccessCode($id)
    {
        if($this->accesscode->delete($id))
        {
            return redirect()->back()->with('success','Access Code Successfully deleted');
        }else
        {
            return redirect()->back()->with('error','Access Code Couldn\'t deleted successfully');
        }
    }

}
