<div class="page-header">
    Manage API Permission Resource Groups
</div>

<p>
    Resource Groups set required permissions for Resources.
</p>
<p>
    <strong>Important:</strong>
    Resource Groups will be listed in the Pt. Portal once the required user/patient permissions are set.
    The questionnaire page will match the slug of the group, for example: <code>/reg/some-slug.php</code>.
    If the Resource Group is created but the matching page is not created, the patient will see an error.
</p>
<ul>
    <li>
        <code>Authorize Per User</code>: Resources in group need to grant access per office.
    </li>
    <li>
        <code>Authorize Per Patient</code>: Resources in group need to grant access per patient.
    </li>
</ul>

<div id="api-permission-resource-groups">
    <button type="button" class="btn btn-success pull-right" v-on:click.prevent="newModelCallback()">
        Add Group
        <span class="glyphicon glyphicon-plus"></span>
    </button>

    <br /><br />

    <div>
        <table class="sort_table table table-bordered table-hover" width="98%" cellpadding="5" cellspacing="1"
               bgcolor="#fff" align="center">
            <thead>
                <tr class="tr_bg_h">
                    <th valign="top" class="col_head header1" width="25%">
                        ID
                    </th>
                    <th valign="top" class="col_head header1" width="10%">
                        Slug
                    </th>
                    <th valign="top" class="col_head header1" width="10%">
                        Name
                    </th>
                    <th valign="top" class="col_head header1" width="10%">
                        Authorize Per User
                    </th>
                    <th valign="top" class="col_head header1" width="10%">
                        Authorize Per Patient
                    </th>
                    <th valign="top" class="col_head header1" width="15%">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="model in models | orderBy 'id'">
                    <td valign="top" class="col_head header1">
                        {{ model.id }}
                    </td>
                    <td valign="top" class="col_head header1">
                        <code>{{ model.slug }}</code>
                    </td>
                    <td valign="top" class="col_head header1">
                        {{ model.name }}
                    </td>
                    <td valign="top" class="col_head header1">
                        {{ model.authorize_per_user }}
                    </td>
                    <td valign="top" class="col_head header1">
                        {{ model.authorize_per_patient }}
                    </td>
                    <td valign="top">
                        <a data-toggle="modal" title="" class="btn btn-primary btn-sm"
                           data-original-title="Edit Group" v-on:click.prevent="editModelCallback(model)">
                            Edit
                            <span class="glyphicon glyphicon-pencil"></span></a>
                        <button class="btn btn-danger btn-sm"  v-on:click.prevent="deleteModelCallback(model)">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form name="memoForm" id="memoForm" style="width:99%;" class="form-horizontal" _lpchecked="1">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h4 class="modal-title">Group Editor</h4>
                    </div>
                    <div class="modal-body">
                        <div class="scroller" style="height:275px" data-always-visible="1" data-rail-visible1="1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert" v-if="errors">
                                        <a class="close" data-dismiss="alert">×</a>
                                        <ul>
                                            <li v-for="e in errors">
                                                {{ e }}
                                            </li>
                                        </ul>
                                    </div>
                                    <label for="model-slug" class="col-md-3 control-label">Slug</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="model-slug" name="slug"
                                               v-model="model.slug">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="model-name" class="col-md-3 control-label">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="model-name" name="name"
                                               v-model="model.name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="model-authorize-per-user" class="col-md-4 control-label">
                                        Authorize Per User
                                    </label>

                                    <label for="model-authorize-per-user-yes" class="col-md-4 control-label">
                                        Yes
                                        <input type="radio"
                                               id="model-authorize-per-user-yes" name="authorize_per_user"
                                               v-model="model.authorize_per_user" v-bind:value="1">
                                    </label>

                                    <label for="model-authorize-per-user-no" class="col-md-2 control-label">
                                        No
                                        <input type="radio"
                                               id="model-authorize-per-user-no" name="authorize_per_user"
                                               v-model="model.authorize_per_user" v-bind:value="0">
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="model-authorize-per-patient" class="col-md-4 control-label">
                                        Authorize Per Patient
                                    </label>

                                    <label for="model-authorize-per-patient-yes" class="col-md-4 control-label">
                                        Yes
                                        <input type="radio"
                                               id="model-authorize-per-patient-yes" name="authorize_per_patient"
                                               v-model="model.authorize_per_patient" v-bind:value="1">
                                    </label>

                                    <label for="model-authorize-per-patient-no" class="col-md-2 control-label">
                                        No
                                        <input type="radio" class="form-control"
                                               id="model-authorize-per-patient-no" name="authorize_per_patient"
                                               v-model="model.authorize_per_patient" v-bind:value="0">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn default">Close</button>
                        <button class="btn green" v-on:click.prevent="saveModelCallback()">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<br /><br />
