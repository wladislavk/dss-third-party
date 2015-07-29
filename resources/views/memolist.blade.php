<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>Memo API sample</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css"/>
    <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="assets/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css"/>
    <link href="assets/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css"/>
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- END PAGE STYLES -->
    <!-- BEGIN THEME STYLES -->
    <link href="assets/css/components.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/plugins.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/layout.css" rel="stylesheet" type="text/css"/>
    <link href="assets/css/themes/default.css" rel="stylesheet" type="text/css" id="style_color"/>
    <link href="assets/css/custom.css" rel="stylesheet" type="text/css"/>
    <!-- END THEME STYLES -->

</head>
<body class="page-header-fixed">
<!-- BEGIN CONTAINER -->
<div class="page-container memoManager">
    <!-- BEGIN CONTENT -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <div id="memos">
                <a href="#responsive" data-toggle="modal" class="btn btn-success pull-right" v-on="click: addMemo">
                    Add Memo
                    <span class="glyphicon glyphicon-plus"></span>
                </a>
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
            End Date
        </th>
        <th valign="top" class="col_head header1" width="15%">
            Action

        </th></tr>
    </thead>
    <tbody>
    <tr v-repeat="m: memos">
        <td valign="top">
            @{{ m.memo }}
        </td>
        <td valign="top">
            @{{ m.last_update }}
        </td>
        <td valign="top">
            @{{ m.off_date }}
        </td>
        <td valign="top">
            <a href="#responsive" data-toggle="modal" title="" class="btn btn-primary btn-sm" data-original-title="Edit Memo" v-on="click: editMemo(m)">
                Edit
                <span class="glyphicon glyphicon-pencil"></span></a>
        </td>
    </tr>
    </tbody>
</table>
            </div>
</div>
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
                        <div class="scroller" style="height:200px" data-always-visible="1" data-rail-visible1="1">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group date">
                                        <label for="docid" class="col-md-3 control-label">End Date</label>
                                        <div class="input-append date datepicker col-md-9">
                                            <input class="form-control text-center" type="text" name="offdate" value="@{{ fields.off_date }}" v-model="fields.off_date">
                                          <span class="input-group-addon add-on">
                                            <i class="glyphicon glyphicon-calendar"></i>
                                          </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="body" class="col-md-3 control-label">Message</label>
                                        <div class="col-md-9">
                                            <textarea name="memobox" id="memobox" class="form-control" placeholder="Memo" v-model="fields.memoText"></textarea>
                                        </div>
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

<!-- BEGIN CORE PLUGINS -->
<!--[if lt IE 9]>
<script src="assets/plugins/respond.min.js"></script>
<script src="assets/plugins/excanvas.min.js"></script>
<![endif]-->
<script src="assets/plugins/jquery-1.10.2.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="assets/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="assets/plugins/jquery.cokie.min.js" type="text/javascript"></script>
<script src="assets/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script>

<script src="assets/js/moment.js"></script>
<script src="assets/js/vue.js"></script>
<script src="assets/js/vue-resource.min.js"></script>
<script src="assets/js/app.js"></script>



</body>
<!-- END BODY -->
</html>