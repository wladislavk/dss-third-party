<?php namespace Ds3\Libraries\Legacy; ?><?php
    include "includes/top.htm";
    require_once('includes/constants.inc');

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen"/>
<script src="admin/popup/popup.js" type="text/javascript"></script>

<span class="admin_head">
	Manage Enrollment
</span>
<br/>
<br/>
&nbsp;

<div id="enrollmentManager">

    <div id="enrollments">

        <div id="dom-docid" style="display: none;">
            <?php
                $output = $_SESSION['docid'];
                echo htmlspecialchars($output);
            ?>
        </div>

        <div id="dom-default-api-key" style="display: none;">
            <?php
                $output = DSS_DEFAULT_ELIGIBLE_API_KEY;
                echo htmlspecialchars($output);
            ?>
        </div>

        <div style="margin-left:10px;margin-right:10px;">
            <button style="margin-right:10px; float:right;" onclick="loadPopup('add_enrollment.php')" class="addButton">
                Add New Enrollment
            </button>
            &nbsp;&nbsp;
        </div>
        <br/>

        <div align="center" class="red">
            <b><?php echo(!empty($_GET['msg']) ? $_GET['msg'] : ''); ?></b>
        </div>

        <form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <table class="sort_table" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center">
                <thead>
                <tr class="tr_bg_h">
                    <th class="col_head">Provider</th>
                    <th class="col_head">NPI</th>
                    <th class="col_head">Payer ID</th>
                    <th class="col_head">Service Type</th>
                    <th class="col_head">Payer Name</th>
                    <th class="col_head">Status</th>
                    <th class="col_head">Response</th>
                    <th class="col_head">Get Form</th>
                </thead>
                <tbody>
                <tr v-repeat="e: enrollments">
                    <td valign="top">
                        {{ e.provider_name }}
                    </td>
                    <td valign="top">
                        {{ e.npi }}
                    </td>
                    <td valign="top">
                        {{ e.payer_id }}
                    </td>
                    <td valign="top">
                        {{ e.transaction_type }}
                    </td>
                    <td valign="top">
                        {{ e.payer_name }}
                    </td>
                    <td valign="top">
                        {{ enrollmentStatusLabel(e.status); }}
                    </td>
                    <td valign="top">
                        <a href="#"   onclick="$('#response_{{e.id}}').toggle();return false;"   style="display:block;">View</a> 
                        <span id="response_{{e.id}}"
                              style="display:none;"> 
                            {{ e.response }}  
                        </span> 
                    </td>
                    <td valign="top">
                        <a href="https://gds.eligibleapi.com/v1.5/payers/{{ e.payer_id }}/enrollment_form?api_key={{ apikey }}&transaction_type=837P"
                             target="_blank">PDF</a>
                        <span v-if="e.download_url"><a class="btn btn-success" href="{{ e.download_url }}">Sign 
                                Form</a> 
                            <br/> 
                            <a class="btn btn-success" href="#"  
                               onclick="Javascript: loadPopup('upload_enrollment.php?id={{ e.reference_id }}');">Upload</a> </span>
                        <span v-if="e.signed_download_url">
                            <br/> 
                            <a class="btn btn-success" href="{{ e.signed_download_url }}">View  Signed Form</a>
                        </span>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>

    </div>

</div>

<div class="fullwidth">
    <?php //include 'eligible_enrollment/index.php'; ?>
</div>

<br/><br/>

<script src="/assets/vendor/moment.js" type="text/javascript"></script>
<script src="/assets/vendor/vue/vue.js" type="text/javascript"></script>
<script src="/assets/vendor/vue/vue-resource.min.js" type="text/javascript"></script>
<script src="/assets/app/enrollments.js" type="text/javascript"></script>

<?php include "includes/bottom.htm"; ?>

