<?php namespace Ds3\Libraries\Legacy; ?><?php include_once 'admin/includes/main_include.php'; ?>

<?php
    if(isset($_POST['sign_but'])){
        $sql = "SELECT manage_staff FROM dental_users WHERE userid='".mysqli_real_escape_string($con,$_SESSION['userid'])."'";
        
        $r = $db->getRow($sql);
        if($_SESSION['docid'] != $_SESSION['userid'] && $r['manage_staff'] != 1) {
?>
            <script type="text/javascript">
                alert('You do not have permission to edit the practice profile.  Only users with sufficient permission may do so.  Please contact your office manager to resolve this issue.');
            </script>
<?php
        } else {
            include_once '3rdParty/thomasjbradley-signature-to-image/signature-to-image.php';

            $json = (!empty($_POST['output']) ? $_POST['output'] : '');
            $s = "INSERT INTO dental_user_signatures SET
                    signature_json='".mysqli_real_escape_string($con,$json)."',
                    user_id='".mysqli_real_escape_string($con,$_SESSION['userid'])."',
                    adddate=now(),
                    ip_address='".mysqli_real_escape_string($con,$_SERVER['REMOTE_ADDR'])."'";
 
            $signature_id = $db->getInsertId($s);

            if (!empty($json)) {
                $img = sigJsonToImage($json);
            }

            $file = "signature_" . $_SESSION['userid'] . "_" . $signature_id . ".png";

            if (!file_exists('../../../shared/q_file/' . $file)) {
                $s = imagepng($img, '../../../shared/q_file/' . $file);
                imagedestroy($img);
            }
        }
    }
?>

    <div style="clear:both;"></div>

    <!--[if lt IE 9]><script src="flashcanvas.js"></script><![endif]-->
    <script src="3rdParty/thomasjbradley-signature-pad/build/jquery.signaturepad.min.js"></script>
    <script src="3rdParty/thomasjbradley-signature-pad/build/json2.min.js"></script>

    <link rel="stylesheet" href="3rdParty/thomasjbradley-signature-pad/build/jquery.signaturepad.css">
    
    <script type="text/javascript" src="/manage/js/signature_test.js"></script>

    <br />
    <div class="fullwidth">
        <?php
            $sign_sql = "SELECT * FROM dental_user_signatures WHERE user_id='".mysqli_real_escape_string($con,$_SESSION['userid'])."' ORDER BY adddate DESC LIMIT 1";

            $sign = $db->getRow($sign_sql);
            if(file_exists('../../../shared/q_file/signature_' . $_SESSION['userid'] . '_' . $sign['id'] . '.png')) {
        ?>
            <img src='display_file.php?f=signature_<?php echo $_SESSION['userid'];?>_<?php echo $sign['id'];?>.png' />
            <a href="#" onclick="$('#update_signature').show();return false;">Update Signature</a>
            <div id="update_signature" style="display:none;">
        <?php } else { ?>
                <div>
        <?php } ?>
                    <form method="post" action="" class="sigPad" style="margin-left:20px">
                        <p class="typeItDesc">Review your signature</p>
                        <p class="drawItDesc">Draw your signature</p>
                        <ul class="sigNav">
                            <li class="clearButton"><a href="#clear">Clear</a></li>
                        </ul>
                        <div class="sig sigWrapper">
                            <div class="typed"></div>
                            <canvas class="pad" width="198" height="55"></canvas>
                            <input type="hidden" name="output" class="output">
                        </div>
                        <button name="sign_but" type="submit">Save Signature</button>
                        <?php if(file_exists('../../../shared/q_file/signature_'.$_SESSION['userid'].'.png')) { ?>
                          <button onclick="$('#update_signature').hide();return false;">Cancel</button>
                        <?php } ?>
                    </form>
                </div>
            </div>
