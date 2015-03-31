<?php namespace Ds3\Http\Controllers\Admin;

use Ds3\Http\Requests;
use Ds3\Admin\Contracts\CompanyInterface;
use Ds3\Http\Controllers\Controller;
use Ds3\Http\Requests\CompanyRequest;
use Ds3\Libraries\Constants;

class CompanyController extends Controller
{
    private $company;

    public function __construct(CompanyInterface $company)
    {
        $this->company = $company;
    }

    public function index()
    {
        return view("admin.companies.index")
            ->with('companies', $this->company->all());
    }

    public function create()
    {
        return view('admin.companies.new')
            ->with('company_type', Constants::$dss_company_type_labels)
            ->with('plans', [''=>'None'] + $this->company->plans()->lists('name', 'id'));
    }

    public function store(CompanyRequest $request)
    {
        if ($this->company->save(array_merge($request->all(), ['ip_address'=>$request->ip()]))) {
            return redirect("manage/admin/companies")->with('success', 'Company created successfully');
        } else {
            return redirect()->back()->with('errors', 'Company couldn\'t created');
        }
    }

    public function edit($id)
    {
        return view('admin.companies.edit')
            ->with('company', $this->company->find($id))
            ->with('company_type', Constants::$dss_company_type_labels)
            ->with('plans', [''=>'None'] + $this->company->plans()->lists('name', 'id'));
    }

    public function update($id,CompanyRequest $request)
    {
        if ($this->company->update($id,array_merge($request->all(), ['ip_address' => $request->ip()]))) {
            return redirect("manage/admin/companies")->with('success', 'Company updated successfully');
        } else {
            return redirect()->back()->with('errors', 'Company couldn\'t updated');
        }
    }

    public function destroy($id)
    {
        if ($this->company->delete($id)) {
            return redirect()->back()->with('success', 'Company deleted successfully');
        } else {
            return redirect()->back()->with('errors', 'Company couldn\'t deleted');
        }
    }
}
