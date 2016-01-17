<?php namespace Ds3\Libraries\Legacy; ?><?php
include "includes/top.htm";
require_once('includes/constants.inc');

?>

<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen"/>
<link href="css/add_enrollment.css" rel="stylesheet" type="text/css"/>
<script src="admin/popup/popup.js" type="text/javascript"></script>

<script language="javascript" type="text/javascript" src="../script/validation.js"></script>
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>-->
<script type="text/javascript" src="/manage/3rdParty/input_mask/jquery.maskedinput-1.3.min.js"></script>
<script type="text/javascript" src="/manage/js/masks.js"></script>
<script type="text/javascript" src="/manage/script/autocomplete.js"></script>
<script type="text/javascript" src="/manage/script/autocomplete_local.js?v=<?= time() ?>"></script>
<link rel="stylesheet" href="/manage/css/form.css" type="text/css" />

<span class="admin_head">
	Manage Enrollment
</span>
<br/>
<br/>
&nbsp;

<div id="enrollmentManager">
<div id="enrollmentManager">

    <div id="enrollments">

        <input type="hidden" id="dom-api-token" value="<?= apiToken() ?>">

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
            <button style="margin-right:10px; float:right; display: none;" onclick="loadPopup('add_enrollment.php')" class="addButton1">
                Old Add New Enrollment
            </button>
            <a href="#enrollmentForm" class="addButton" id="load-add-enrollment" style="margin-right:10px; float:right;">Add New Enrollment</a>
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
                        <a href="#response_{{e.id}}"  v-on="click: showHideResponse('response_' + e.id);"  style="display:block;">View</a> 
                        <span style="display: none;">
                        <div id="response_{{e.id}}" style='padding:10px; background:#fff;'> 
                            {{ e.response }} 
                        </div> </span>
                    </td>
                    <td valign="top">
                        <a href="https://gds.eligibleapi.com/v1.5/payers/{{ e.payer_id }}/enrollment_form?api_key={{ apikey }}&transaction_type={{ e.transaction_type.split('-')[0] }}"
  target="_blank">PDF</a>
                        <span v-if="e.download_url"><a class="btn btn-success" href="{{ e.download_url }}">Sign 
                                Form</a> 
                            <br/> 
                            <a href="upload_enrollment.php?id={{ e.reference_id }}" class="iframe cboxElement btn btn-success" >Upload</a> </span>
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

    <script type="text/javascript" src="js/add_enrollment.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var api_key = <?php echo "'".DSS_DEFAULT_ELIGIBLE_API_KEY."'" ?>;
            setup_autocomplete_local('ins_payer_name', 'ins_payer_hints', 'payer_id', '', 'https://gds.eligibleapi.com/v1.5/payers.json?endpoint=coverage&enrollment_required=true&api_key=' + api_key, 'ins_payer', null, null, false, '', '', 'coverage');
        });
    </script>

    <?php
    $sql = "SELECT * FROM dental_users WHERE (docid='" . $_SESSION['docid'] . "' OR userid='" . $_SESSION['docid'] . "') AND npi !='' AND (producer=1 OR docid=0) ORDER BY docid ASC";

    $q = $db->getResults($sql);

    $payer_id = (!empty($_POST['payer_id']) ? $_POST['payer_id'] : '');

    $payer_id = substr($payer_id, 0, strpos($payer_id, '-'));
    $payer_name = substr($payer_id, strpos($payer_id, '-') + 1);
    $t_sql = "SELECT * FROM dental_enrollment_transaction_type WHERE id='" . mysqli_real_escape_string($con, (!empty($_POST['transaction_type']) ? $_POST['transaction_type'] : '')) . "' AND status=1";

    $t_r = $db->getRow($t_sql);
    ?>

    <div style='display:none'>

        <div id="enrollmentForm" style="padding:15px; background:url(../images/tall.jpg) #BFCFDC; z-index: 1000;">

            <form name="enrollForm">
                <?php
                $t_sql = "SELECT * FROM dental_enrollment_transaction_type WHERE status=1 ORDER BY transaction_type ASC";

                $t_q = $db->getResults($t_sql);

                $s = "SELECT eligible_test FROM dental_users where userid='" . $_SESSION['docid'] . "'";
                $r = $db->getRow($s);
                if ($r['eligible_test'] == "1") {
                    ?>
                    <div>
                        <label class="form-label">Test?</label> <input type="checkbox" value="1" name="test"/>
                    </div>
                <?php } ?>

                <table style="width: 80%;">
                    <tr>
                        <td class="form-label">Enroll Type</td>
                        <td>
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['docid'];?>">
                            <input type="hidden" name="selected_transaction_type" id="selected_transaction_type">
                            <select id="transaction_type" name="transaction_type" v-model="fields.transaction_type"
                                    v-on="change: setEnrollmentType();">
                                <?php if ($t_q) foreach ($t_q as $t) { ?>
                                    <option
                                        value="<?php echo $t['id']; ?>"><?php echo $t['transaction_type']; ?><?php echo $t['description']; ?></option>
                                <?php } ?>
                            </select></td>
                    </tr>
                    <tr>
                        <td class="form-label"><span id="payer_id_required" style="display: none">*</span> Insurance Co</td>
                        <td><input type="hidden" name="payer_id" id="payer_id">
                            <input type="text" id="ins_payer_name" onclick="updateval(this)" autocomplete="off"
                                   name="ins_payer_name" value="Type insurance payer name" style="width:300px;" />
                            <br/>
                            <div id="ins_payer_hints" class="search_hints" style="margin-top:20px; display:none;">
                                <ul id="ins_payer_list" class="search_list">
                                    <li class="template" style="display:none"></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <span id="npi_required" style="display: none">*</span> NPI to Enroll
                        </td>
                        <td>
                            <select id="provider_select" name="provider_select" v-on="change: providerOnChangeHandler(this);">
                                <?php if ($q) foreach ($q as $r) { ?>
                                    <?php
                                    $us_sql = "SELECT * FROM dental_user_signatures where user_id='" . mysqli_real_escape_string($con, $_SESSION['docid']) . "'";

                                    $signature = $db->getNumberRows($us_sql);
                                    $api_key = DSS_DEFAULT_ELIGIBLE_API_KEY;
                                    $api_key_sql = "SELECT eligible_api_key FROM dental_user_company LEFT JOIN companies ON dental_user_company.companyid = companies.id WHERE dental_user_company.userid = '" . mysqli_real_escape_string($con, $_SESSION['docid']) . "'";
                                    $api_key_query = mysqli_query($con, $api_key_sql);
                                    $api_key_result = mysqli_fetch_assoc($api_key_query);
                                    if ($api_key_result && !empty($api_key_result['eligible_api_key'])) {
                                        if (trim($api_key_result['eligible_api_key']) != "") {
                                            $api_key = $api_key_result['eligible_api_key'];
                                        }
                                    }
                                    ?>
                                    <?php if ($r['docid'] == 0) {
                                        $snpi = $r['service_npi'];
                                        $sjson = '{"facility_name":"' . $r['practice'] . '","provider_name":"' . $r['first_name'] . ' ' . $r['last_name'] . '", "tax_id":"' . $r['tax_id_or_ssn'] . '", "address":"' . $r['address'] . '","city":"' . $r['city'] . '","state":"' . $r['state'] . '","zip":"' . $r['zip'] . '","medicare_ptan":"' . $r['medicare_ptan'] . '","npi":"' . $r['npi'] . '","first_name":"' . $r['first_name'] . '","last_name":"' . $r['last_name'] . '","contact_number":"' . $r['phone'] . '","email":"' . $r['email'] . '","signature":"' . $signature . '"}';
                                    }
                                    $json = '{"facility_name":"' . $r['practice'] . '","provider_name":"' . $r['first_name'] . ' ' . $r['last_name'] . '", "tax_id":"' . $r['tax_id_or_ssn'] . '", "address":"' . $r['address'] . '","city":"' . $r['city'] . '","state":"' . $r['state'] . '","zip":"' . $r['zip'] . '","medicare_ptan":"' . $r['medicare_ptan'] . '","npi":"' . $r['npi'] . '","first_name":"' . $r['first_name'] . '","last_name":"' . $r['last_name'] . '","contact_number":"' . $r['phone'] . '","email":"' . $r['email'] . '","signature":"' . $signature . '"}';
                                    ?>
                                    <option value='<?php echo $json; ?>'><?php echo $r['npi']; ?>
                                        - <?php echo $r['first_name'] . " " . $r['last_name']; ?></option>
                                <?php } ?>
                                <?php if ($snpi != '') { ?>
                                    <option value='<?php echo $sjson; ?>'><?php echo $snpi; ?> - Service Facility</option>
                                <?php } ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <span id="facility_name_required" style="display: none">*</span> Facility Name
                        </td>
                        <td>
                            <input type="text" id="facility_name" name="facility_name" value="<?php echo $r['practice']; ?>"
                                   readonly="readonly"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <span id="provider_name_required" style="display: none">*</span> Provider Name
                        </td>
                        <td>
                            <input type="text" id="provider_name" name="provider_name"
                                   value="<?php echo $r['first_name'] . ' ' . $r['last_name']; ?>" readonly="readonly"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <span id="tax_id_required" style="display: none">*</span> Tax ID
                        </td>
                        <td>
                            <input type="text" id="tax_id" name="tax_id" value="<?php echo $r['tax_id_or_ssn']; ?>"
                                   readonly="readonly"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <span id="address_required" style="display: none">*</span> Address
                        </td>
                        <td>
                            <input type="text" id="address" name="address" value="<?php echo $r['address']; ?>"
                                   readonly="readonly"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <span id="city_required" style="display: none">*</span> City
                        </td>
                        <td>
                            <input type="text" id="city" name="city" value="<?php echo $r['city']; ?>" readonly="readonly"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <span id="state_required" style="display: none">*</span> State
                        </td>
                        <td>
                            <input type="text" id="state" name="state" value="<?php echo $r['state']; ?>"
                                   readonly="readonly"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <span id="zip_required" style="display: none">*</span> Zip
                        </td>
                        <td>
                            <input type="text" id="zip" name="zip" value="<?php echo $r['zip']; ?>" readonly="readonly"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <span id="npi_required" style="display: none">*</span> NPI
                        </td>
                        <td>
                            <input type="text" id="npi" name="npi" value="<?php echo $r['npi']; ?>" readonly="readonly"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <span id="ptan_required" style="display: none">*</span> PTAN (Medicare)
                        </td>
                        <td>
                            <input type="text" id="ptan" name="ptan" value="<?= $r['medicare_ptan']; ?>"
                                   readonly="readonly"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <span id="first_name_required" style="display: none">*</span> First Name
                        </td>
                        <td>
                            <input type="text" id="first_name" name="first_name" value="<?php echo $r['first_name']; ?>"
                                   readonly="readonly"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <span id="last_name_required" style="display: none">*</span> Last Name
                        </td>
                        <td>
                            <input type="text" id="last_name" name="last_name" value="<?php echo $r['last_name']; ?>"
                                   readonly="readonly"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <span id="contact_number_required" style="display: none">*</span> Contact Number
                        </td>
                        <td>
                            <input type="text" id="contact_number" name="contact_number" value="<?php echo $r['phone']; ?>"
                                   readonly="readonly"/>
                        </td>
                    </tr>
                    <tr>
                        <td class="form-label">
                            <span id="email_required" style="display: none">*</span> Email
                        </td>
                        <td>
                            <input type="text" id="email" name="email" value="<?php echo $r['email']; ?>"
                                   readonly="readonly"/>
                        </td>
                    </tr>
                    <tr>
                        <td>

                        </td>
                        <td>
                            <button name="enroll_but" class="button" v-on="click: createEnrollment">Enroll
                            </button>
                        </td>
                    </tr>
                </table>

            </form>

        </div>

    </div>

</div>


<script>
    var apiRoot = <?= json_encode(config('app.apiUrl')) ?>;
</script>
<script src="/assets/app/enrollments.js" type="text/javascript"></script>

<?php include "includes/bottom.htm"; ?>

