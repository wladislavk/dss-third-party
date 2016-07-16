<?php namespace Ds3\Libraries\Legacy; ?><?php 
include "includes/top.htm";
include_once "../includes/constants.inc";
?>
<!--link rel="stylesheet" href="css/support.css" type="text/css" /-->
<div class="page-header">
	Manage Memos 
</div>

<input type="hidden" id="dom-api-token" value="<?= adminApiToken() ?>">

<div id="memoManager">

    <button type="button" class="btn btn-success pull-right" v-on="click: newMemo();">
        Add Memo
        <span class="glyphicon glyphicon-plus"></span>
    </button>

    <br /><br />

    <div id="memos">

        <table class="sort_table table table-bordered table-hover" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
            <thead>
            <tr class="tr_bg_h">
                <th valign="top" class="col_head header1" width="25%">
                    Memo
                </th>
                <th valign="top" class="col_head header1" width="10%">
                    Last Updated
                </th>
                <th valign="top" class="col_head header1" width="10%">
                    Display Start
                </th>
                <th valign="top" class="col_head header1" width="15%">
                    Action

                </th></tr>
            </thead>
            <tbody>
            <tr v-repeat="m: memos">
                <td valign="top">
                    {{ m.memo }}
                </td>
                <td valign="top">
                    {{ m.last_update }}
                </td>
                <td valign="top">
                    {{ m.off_date }}
                </td>
                <td valign="top">
                    <a data-toggle="modal" title="" class="btn btn-primary btn-sm" data-original-title="Edit Memo" v-on="click: editMemo(m)">
                        Edit
                        <span class="glyphicon glyphicon-pencil"></span></a>
                    <button class="btn btn-danger btn-sm"  v-on="click: deleteMemo(m)">Delete</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>


	<div id="responsive" class="modal fade" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<form name="memoForm" id="memoForm" style="width:99%;" class="form-horizontal" _lpchecked="1">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
						<h4 class="modal-title">Memo Editor</h4>
					</div>
					<div class="modal-body">
						<div class="scroller" style="height:275px" data-always-visible="1" data-rail-visible1="1">
							<div class="row">
								<div class="col-md-12">
									<div class="alert" v-if="errors">
										<a class="close" data-dismiss="alert">×</a>
										<ul>
											<li v-repeat="e:errors">
												{{ e }}
											</li>
										</ul>
									</div>
                                    <label for="offdate" class="col-md-3 control-label">Display Start</label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control" id="offdate" name="offdate" value="{{ fields.off_date }}" v-model="fields.off_date"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
								</div>
							</div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="memobox" class="col-md-3 control-label">Message</label>
                                    <div class="input-group col-md-9">
                                        <textarea name="memobox" id="memobox" class="form-control" placeholder="Memo" v-model="fields.memoText" rows="8"></textarea>
                                    </div>
                                </div>
                            </div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" data-dismiss="modal" class="btn default">Close</button>
						<button class="btn green" v-on="click: saveMemo">Save changes</button>
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
<script src="/assets/vendor/jquery.serialize-json-2.7.2.js" type="text/javascript"></script>
<script src="/manage/admin/admin/template/assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="/assets/vendor/moment.js" type="text/javascript"></script>
<script src="/assets/vendor/vue/vue.js" type="text/javascript"></script>
<script src="/assets/vendor/vue/vue-resource.min.js" type="text/javascript"></script>
<script src="/assets/app/memos.js?v=20160715" type="text/javascript"></script>
<?php

include "includes/bottom.htm";
