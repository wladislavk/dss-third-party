<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/../includes/constants.inc';
?>
<input type="hidden" id="dom-api-token" value="<?= adminApiToken() ?>">

<?php
require_once __DIR__ . '/manage-api-permission-resource-groups.php';
require_once __DIR__ . '/manage-api-permission-resources.php';
?>

<div style="display: none;">
    <div class="page-header">
        Manage API Permissions
    </div>
    <p>
        Users listed here will be granted access to the corresponding Resource Group.
    </p>
    <div id="api-permissions">
        <button type="button" class="btn btn-success pull-right" v-on:click.prevent="newModelCallback()">
            Add Permission
            <span class="glyphicon glyphicon-plus"></span>
        </button>
        <br /><br />
        <div>
            <table class="sort_table table table-bordered table-hover" width="98%" cellpadding="5" cellspacing="1"
                   bgcolor="#fff" align="center">
                <thead>
                <tr class="tr_bg_h">
                    <th valign="top" class="col_head header1" width="10%">
                        Group
                    </th>
                    <th valign="top" class="col_head header1" width="10%">
                        Office
                    </th>
                    <th valign="top" class="col_head header1" width="15%">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="model in models | orderBy 'id'">
                    <td valign="top" class="col_head header1">
                        {{ indexedGroups[model.group_id] ? indexedGroups[model.group_id].name : '' }}
                    </td>
                    <td valign="top" class="col_head header1">
                        {{ indexedUsers[model.doc_id] ? indexedUsers[model.doc_id].last_name : '' }},
                        {{ indexedUsers[model.doc_id] ? indexedUsers[model.doc_id].first_name : '' }}
                    </td>
                    <td valign="top">
                        <a data-toggle="modal" title="" class="btn btn-primary btn-sm" data-original-title="Edit Group" v-on:click.prevent="editModelCallback(model)">
                            Edit
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
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
                            <h4 class="modal-title">Permission Editor</h4>
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
                                        <label for="model-doc-id" class="col-md-3 control-label">User</label>
                                        <div class="col-md-9">
                                            <select class="form-control" id="model-doc-id" name="doc_id"
                                                    v-model="model.doc_id">
                                                <option v-bind:value="user.userid"
                                                    v-for="user in filteredUsers">
                                                    {{ user.last_name }}, {{ user.first_name }}
                                                </option>
                                            </select>
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
</div>
<br /><br />

<script>
    var apiRoot = <?= json_encode(config('app.apiUrl')) ?>;
</script>
<script src="/assets/vendor/moment.js" type="text/javascript"></script>
<script src="/assets/vendor/dot-object-1.5.3.min.js" type="text/javascript"></script>
<script src="/assets/app/utils/modal.js" type="text/javascript"></script>
<script src="/assets/app/utils/utils.js" type="text/javascript"></script>
<script src="/assets/app/utils/events.js" type="text/javascript"></script>
<script src="/assets/vendor/vue/vue-1.0.26.min.js"></script>
<script src="/assets/vendor/vue/vue-resource-0.9.3.min.js"></script>
<script src="/assets/app/mixins/api-permissions-form.js?v=20180502" type="text/javascript"></script>
<script src="/assets/app/api-permission-resource-groups.js?v=20180502" type="text/javascript"></script>
<script src="/assets/app/api-permission-resources.js?v=20180502" type="text/javascript"></script>
<script src="/assets/app/api-permissions.js?v=20180502" type="text/javascript"></script>
<?php include "includes/bottom.htm";?>
