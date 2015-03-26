<?php
namespace Ds3\Http\Controllers\Admin;

use Ds3\Admin\Contracts\PlanInterface;
use Ds3\Http\Requests\PlanRequest;
use Ds3\Http\Controllers\Controller;

class PlanController extends Controller
{
    private $plan;

    public function __construct(PlanInterface $plan)
    {
        $this->plan = $plan;
    }

    public function getIndex()
    {
        return view('admin.plans.index')
            ->with('plans', $this->plan->all());
    }

    public function getAddNewPlan()
    {
        return view('admin.plans.new');
    }

    public function postAddNewPlan(PlanRequest $request)
    {
        if ($this->plan->save($request->all())) {
            return redirect('manage/admin/plan')->with('success', 'Plan Added Successfully');
        } else {
            return redirect()->back()->with('errors', 'Plan couldn\'t added');
        }
    }

    public function getUpdatePlan($id)
    {
        return view('admin.plans.edit')
            ->with('plan', $this->plan->find($id));
    }

    public function postUpdatePlan($id, PlanRequest $request)
    {
        if ($this->plan->update($id,$request->all())) {
            return redirect("manage/admin/plan")->with('success', 'Plan updated successfully');
        } else {
            return redirect("manage/admin/plan{$id}/edit")->with('errors', 'Plan couldn\'t updated');
        }
    }

    public function getDeletePlan($id)
    {
        if ($this->plan->delete($id)) {
            return redirect("manage/admin/plan")->with('success', 'Plan deleted successfully');
        } else {
            return redirect("manage/admin/plan")->back()->with('error','Plan couldn\'t deleted');
        }
    }
}
