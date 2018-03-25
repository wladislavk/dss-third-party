@extends('layouts.admin.master')

@section('content')

    <div class="page-header">
        Manage Companies
    </div>

    <div align="right">
        <a class="btn btn-success" href="/manage/admin/companies/create">
            Add New Company
            <span class="glyphicon glyphicon-plus"></span>
        </a>
        &nbsp;&nbsp;
    </div>
    <br/>
    @if($companies)
    <table class="table table-bordered table-hover">
            <tbody><tr class="tr_bg_h">
            <td valign="top" class="col_head" width="40%">Name</td>
            <td valign="top" class="col_head">Number of Admins</td>
            <td valign="top" class="col_head">Number of Users</td>
            <td valign="top" class="col_head">Number of Clients</td>
            <td valign="top" class="col_head">Billing Plan</td>
            <td valign="top" class="col_head">Type</td>
            <td valign="top" class="col_head">Logo</td>
            <td valign="top" class="col_head" width="10%">Action</td>
        </tr>
        @foreach($companies as $company)
        <tr>
            <td valign="top">{{ $company->name }}</td>
                    <td valign="top">
                        <a href="manage_backoffice.php?cid=3">{{ $company->numberOfAdmins }}</a>
                    </td>
                    <td valign="top"><a href="manage_backoffice.php?cid=3">{{ $company->numberOfUsers }}</a></td>
                    <td valign="top">
                        <a href="software_company_users.php?id=3">
                            @if(\Ds3\Libraries\Constants::DSS_COMPANY_TYPE_BILLING == $company->company_type)

                                {{ $company->users('DSS_COMPANY_TYPE_BILLING')->count() }}

                            @elseif(\Ds3\Libraries\Constants::DSS_COMPANY_TYPE_HST == $company->company_type)

                                {{ $company->users('DSS_COMPANY_TYPE_HST',$company->id) }}

                            @else
                                {{ count($company->users()) }}
                            @endif
                        </a>
                    </td>
                    <td valign="top">{{ $company->name }}</td>
                    <td valign="top">{{ \Ds3\Libraries\Constants::$dss_company_type_labels[$company->company_type] }}</td>
                    <td valign="top"><a href="" title="" class="btn btn-primary btn-sm" data-original-title="Edit">Edit
                        <span class="glyphicon glyphicon-pencil"></span></a>
                    </td>
                    <td valign="top">
                        <a href="/manage/admin/companies/{{$company->id}}/edit" title="" class="btn btn-primary btn-sm" data-original-title="Edit">
                            Edit
                        <span class="glyphicon glyphicon-pencil"></span></a>
                        <a href="invoice_bo_additional.php?show=1&amp;coid=3" title="" class="btn btn-primary btn-sm" data-original-title="Edit">
                            Invoice
                            <span class="glyphicon glyphicon-pencil"></span></a>

                        {!! Form::open(['url'=>'manage/admin/companies/'.$company->id,'method'=>'delete']) !!}
                            <button class="btn btn-danger" onclick="javascript:return confirm('Are you absolutely sure you want to delete?')">
                                Delete
                                <span class="glyphicon glyphicon-remove-sign"></span>
                            </button>


                        {!! Form::close() !!}
                    </td>
        </tr>
        @endforeach
        </tbody>
        </table>
    @else
        {{ "No Record" }}
    @endif

@stop

@stop