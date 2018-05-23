<div class="page-header">
    Manage API Permission Resources
</div>

<p>
    Resources listed here will inherit authorization requirements from the Resource Group they belong to.
    The slug needs to be unique, it's a hint for legacy code that might not know the API routes.
</p>
<p>
    A resource is an API endpoint, or "section" of the legacy code. Once a resource is listed here, the
    corresponding office or patient will need to have the resource/endpoint/section enabled to be able to
    access it.
</p>

<div id="api-permission-resources">
    <button type="button" class="btn btn-success pull-right" v-on:click.prevent="newModelCallback()">
        Add Resource
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
                    Group ID
                </th>
                <th valign="top" class="col_head header1" width="10%">
                    Group
                </th>
                <th valign="top" class="col_head header1" width="10%">
                    Slug
                </th>
                <th valign="top" class="col_head header1" width="10%">
                    Route
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
                    {{ model.group_id }}
                </td>
                <td valign="top" class="col_head header1">
                    {{ indexedGroups[model.group_id] ? indexedGroups[model.group_id].name : '' }}
                </td>
                <td valign="top" class="col_head header1">
                    <code>{{ model.slug }}</code>
                </td>
                <td valign="top" class="col_head header1">
                    <code>{{ model.route }}</code>
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
                        <h4 class="modal-title">Resource Editor</h4>
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
                                    <label for="model-group" class="col-md-3 control-label">Group</label>
                                    <div class="col-md-9">
                                        <select class="form-control" id="model-group" name="group"
                                                v-model="model.group_id">
                                            <option v-for="group in groups" v-bind:value="group.id">
                                                {{ group.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="model-slug" class="col-md-3 control-label">Slug</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="model-slug" name="slug"
                                               v-model="model.slug">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="model-route" class="col-md-3 control-label">Route</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" id="model-route" name="route"
                                               v-model="model.route">
                                    </div>
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
