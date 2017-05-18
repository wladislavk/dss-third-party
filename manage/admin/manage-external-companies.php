<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/../includes/constants.inc';

?>
<!--link rel="stylesheet" href="css/support.css" type="text/css" /-->
<div class="page-header">
    Manage Dentrix API companies
</div>

<input type="hidden" id="dom-api-token" value="<?= adminApiToken() ?>">

<div id="company-manager">

    <button type="button" class="btn btn-success pull-right" v-on="click: newCompany();">
        Add Company
        <span class="glyphicon glyphicon-plus"></span>
    </button>

    <br /><br />

    <div id="companies">

        <table class="sort_table table table-bordered table-hover" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
            <thead>
            <tr class="tr_bg_h">
                <th valign="top" class="col_head header1" width="15%">
                    Name
                </th>
                <th valign="top" class="col_head header1" width="10%">
                    Status
                </th>
                <th valign="top" class="col_head header1" width="15%">
                    API Key
                </th>
                <th valign="top" class="col_head header1" width="20%">
                    API Key Period
                </th>
                <th valign="top" class="col_head header1" width="10%">
                    Last Updated
                </th>
                <th valign="top" class="col_head header1" width="15%">
                    Action
                </th></tr>
            </thead>
            <tbody>
            <tr v-repeat="company: companies">
                <td valign="top">
                    {{ company.name }}
                </td>
                <td valign="top">
                    {{ company.status == 1 ? 'Active' : '' }}
                    {{ company.status == 2 ? 'Inactive' : '' }}
                    {{ company.status == 3 ? 'Suspended' : '' }}
                    {{ company.status < 1 || company.status > 3 ? 'Not set' : '' }}
                </td>
                <td valign="top">
                    {{ company.api_key }}
                </td>
                <td valign="top">
                    {{ company.valid_from }} &mdash; {{ company.valid_to }}
                </td>
                <td valign="top">
                    {{ company.updated_at }}
                </td>
                <td valign="top">
                    <a data-toggle="modal" title="" class="btn btn-primary btn-sm" data-original-title="Edit Company" v-on="click: editCompany(company, $index)">
                        Edit
                        <span class="glyphicon glyphicon-pencil"></span></a>
                    <button class="btn btn-danger btn-sm"  v-on="click: deleteCompany(company)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>


    <div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="company-form" id="company-form" style="width:99%;" class="form-horizontal" _lpchecked="1">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Company Editor</h4>
                    </div>
                    <div class="modal-body">
                        <div class="scroller" style="height:275px" data-always-visible="1" data-rail-visible1="1">
                            <div class="row">
                                <div class="alert" v-if="errors">
                                    <a class="close" data-dismiss="alert">×</a>
                                    <ul>
                                        <li v-repeat="e:errors">
                                            {{ e }}
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-12">
                                    <label for="company-name" class="col-md-3 control-label">Name</label>
                                    <div class="input-group col-md-9">
                                        <input type="text" class="form-control" id="company-name" name="company.name" v-model="fields.name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="company-short-name" class="col-md-3 control-label">Short name</label>
                                    <div class="input-group col-md-9">
                                        <input type="text" class="form-control" id="company-short-name" name="company.short_name" v-model="fields.short_name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="company-software" class="col-md-3 control-label" title="Name of the software that access the DS3 API">Software</label>
                                    <div class="input-group col-md-9">
                                        <input type="text" class="form-control" id="company-software" name="company.software" v-model="fields.software">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="company-api_key" class="col-md-3 control-label">API key</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="company-api_key" name="company.api_key" v-model="fields.api_key" readonly><span class="input-group-addon" v-on="click: generateApiKey(fields)"><i class="glyphicon glyphicon-refresh"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="company-valid_from" class="col-md-3 control-label">Valid from</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control" id="company-valid_from" name="company.valid_from" v-model="fields.valid_from"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="company-valid_to" class="col-md-3 control-label">Valid to</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control" id="company-valid_to" name="company.valid_to" v-model="fields.valid_to"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="company-url" class="col-md-3 control-label">URL</label>
                                    <div class="input-group col-md-9">
                                        <input type="text" class="form-control" id="company-url" name="company.url" v-model="fields.url">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="company-description" class="col-md-3 control-label">Description</label>
                                    <div class="input-group col-md-9">
                                        <textarea type="text" class="form-control" id="company-description" name="company.description" v-model="fields.description"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="company-status" class="col-md-3 control-label">Status</label>
                                    <div class="input-group col-md-9">
                                        <select name="company-status" id="company-status" class="form-control" v-model="fields.status">
                                            <option value="1">Active</option>
                                            <option value="2">Inactive</option>
                                            <option value="3">Suspended</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-show="fields.status == 3">
                                <div class="col-md-12">
                                    <label for="company-reason" class="col-md-3 control-label">Reason</label>
                                    <div class="input-group col-md-9">
                                        <textarea name="company-reason" id="company-reason" class="form-control" v-model="fields.reason" rows="8"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn default">Close</button>
                        <button class="btn green" v-on="click: saveCompany">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<br /><br />

<script>
    var apiRoot = <?= json_encode(config('app.apiUrl')) ?>;
</script>
<script src="/assets/vendor/moment.js" type="text/javascript"></script>
<script src="/assets/vendor/vue/vue.js" type="text/javascript"></script>
<script src="/assets/vendor/vue/vue-resource.min.js" type="text/javascript"></script>
<script src="/assets/app/external-companies.js?v=20170517<?= time() ?>" type="text/javascript"></script>
<?php include "includes/bottom.htm";?>
