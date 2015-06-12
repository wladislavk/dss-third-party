<?php namespace Ds3\Libraries\Legacy; ?><?php
    include_once 'admin/includes/main_include.php';
    include_once 'includes/general_functions.php';
    include_once 'admin/includes/invoice_functions.php';
?>

    <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>

<?php
    $s = "SELECT pdf_path, send_method, md_list, md_referral_list from dental_letters where letterid='".mysqli_real_escape_string($con,(!empty($_GET['id']) ? $_GET['id'] : ''))."'";
    
    $r = $db->getRow($s);
    $file = './letterpdfs/'.$r['pdf_path'];
    $jpg = substr( $file, 0, -4 ) . '';
?>
    <br />

<?php
    exec('gs -dSAFER -dBATCH -dNOPAUSE -sDEVICE=jpeg -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -r300 -sOutputFile='.$jpg.'-%01d.jpg '. $file)
?>
<?php
    $reload = false;
    if(isset($_REQUEST['parent'])){
        if($_REQUEST['goto']!=''){
            if($_REQUEST['goto']=='flowsheet'){
                $page = 'manage_flowsheet3.php?pid='.(!empty($_GET['pid']) ? $_GET['pid'] : '').'&addtopat=1';
            }elseif($_REQUEST['goto']=='letter'){
                $page = 'dss_summ.php?sect=letters&pid='.(!empty($_GET['pid']) ? $_GET['pid'] : '').'&addtopat=1';
            }elseif($_REQUEST['goto']=='new_letter'){
                $page = 'new_letter.php?pid='.(!empty($_GET['pid']) ? $_GET['pid'] : '');
            }elseif($_REQUEST['goto']=='faxes'){
                $page = 'manage_faxes.php';
            }
        } else {
            $page = ($_GET['backoffice'] == "1") ? "/manage/admin/manage_letters.php?status=pending" : "/manage/letters.php?status=pending";
        }
    } else {
        $reload = true;
    }
?>

    <div style="float:left;">
        <a href="#" onclick="send_letter('<?php echo (!empty($_GET['id']) ? $_GET['id'] : 'null'); ?>', <?php echo ($reload ? 'true' : 'false'); ?>, '<?php echo (isset($page) ? $page : 'null'); ?>')">Looks Good! SEND!</a> | <a href="#" onclick="parent.disablePopupClean();">Cancel/Revise</a>
    </div>
    <?php
        $fsql = "SELECT fax, preferredcontact from dental_contact WHERE contactid='".mysqli_real_escape_string($con,$r['md_list'])."' OR 
        contactid='".mysqli_real_escape_string($con,$r['md_referral_list'])."'";
        
        $f = $db->getRow($fsql); 
    ?>
    <?php if($r['send_method']=='fax' || ($r['send_method']=='' && $f['preferredcontact']=='fax')){ ?>
        <div style="float:right;margin-right:20px;">Digital Fax - <?php echo  format_phone($f['fax']); ?></div>
    <?php } ?>

    <?php for($i = 1; $i < 5; $i++){ 
            if(file_exists($jpg."-". $i.".jpg")){
    ?>
                <img src="<?php echo  $jpg; ?>-<?php echo  $i; ?>.jpg" style="border:solid 2px #333;" width="600" />
    <?php
            }
        }
    ?>
    <div style="float:left;">
        <a href="#" onclick="send_letter('<?php echo (!empty($_GET['id']) ? $_GET['id'] : 'null'); ?>', <?php echo ($reload ? 'true' : 'false'); ?>, '<?php echo (isset($page) ? $page : 'null'); ?>')">Looks Good! SEND!</a> | <a href="#" onclick="parent.disablePopupClean();">Cancel/Revise</a>
    </div>
    <script type="text/javascript" src="/manage/js/letter_approve.js"></script>
