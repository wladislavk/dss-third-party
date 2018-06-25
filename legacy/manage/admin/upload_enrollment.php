<?php 
session_start();

require_once('includes/main_include.php');
include("includes/sescheck.php");
include_once "includes/general.htm";
include_once "../includes/constants.inc";
include_once "includes/invoice_functions.php";

if (isset($_POST["enrollsub"])) {
    $api_key = DSS_DEFAULT_ELIGIBLE_API_KEY;
    $api_key_sql = "SELECT eligible_api_key FROM dental_user_company LEFT JOIN companies ON dental_user_company.companyid = companies.id WHERE dental_user_company.userid = '".$db->escape( $r['userid'])."'";
    $api_key_query = mysqli_query($con, $api_key_sql);
    $api_key_result = mysqli_fetch_assoc($api_key_query);
    if($api_key_result && !empty($api_key_result['eligible_api_key'])){
        if(trim($api_key_result['eligible_api_key']) != ""){
            $api_key = $api_key_result['eligible_api_key'];
        }
    }
    $data = [];
    $data['test'] = "true";
    $data['api_key'] = $api_key;
    $data['file'] = '@'.$_FILES['file']['tmp_name'];

    $ch = curl_init('https://gds.eligibleapi.com/v1.5/enrollment_npis/'.$_REQUEST['ed'].'/original_signature_pdf');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);
    $json_response = json_decode($result);

    if(isset($json_response->{"error"})){
        $error = $json_response->{"error"};
        ?>
        <script type="text/javascript">
            alert("<?= $error; ?>");
        </script>
        <?php
    }else{
        $ref_id = $_REQUEST['ed'];
        $download_url = $json_response->{"original_signature_pdf"}->{"download_url"};
        $up_sql = "UPDATE dental_eligible_enrollment SET
            status='".DSS_ENROLLMENT_PDF_SENT."',
            signed_download_url = '".$db->escape( $download_url)."'
            WHERE reference_id='".$db->escape( $ref_id)."'";
        mysqli_query($con, $up_sql);
        echo "<p>Your enrollment has been submitted.</p>";
        trigger_error('Die called', E_USER_ERROR);
    }
}
?>
<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>
<script type="text/javascript" src="../3rdParty/input_mask/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="/manage/script/masks.js"></script>
<script type="text/javascript" src="/manage/script/autocomplete.js?v=20160719"></script>
<script type="text/javascript" src="/manage/script/autocomplete_local.js?v=20160719"></script>
<link href="/manage/css/search-hints.css" rel="stylesheet" type="text/css">
<?php if($msg != '') {?>
    <div class="alert alert-danger text-center">
        <?php echo $msg;?>
    </div>
<?php }?>
<form name="planfrm" action="<?=$_SERVER['PHP_SELF'];?>?add=1&docid=<?=$_GET['docid'];?>" method="post" enctype="multipart/form-data">
    <table class="table table-bordered table-hover">
        <tr>
            <td colspan="2" class="cat_head">
               Upload Enrollment
            </td>
        </tr>
        <tr bgcolor="#FFFFFF">
            <td valign="top" class="frmhead" width="30%">
                File
            </td>
            <td valign="top" class="frmdata">
                <input type="file" id="file" name="file" class="form-control" />          
            </td>
        </tr>
        <tr>
            <td colspan="2" align="center">
                <input type="hidden" name="enrollsub" value="1" />
                <input type="hidden" name="ed" value="<?=$_REQUEST["id"]?>" />
                <input type="submit" value="Upload Enrollment" class="btn btn-primary">
            </td>
        </tr>
    </table>
</form>
</body>
</html>
