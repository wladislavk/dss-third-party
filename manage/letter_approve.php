<?php
require_once 'admin/includes/main_include.php';
require_once 'includes/general_functions.php';
require_once 'admin/includes/invoice_functions.php';
?>

<script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>

<?php

$s = "SELECT pdf_path, send_method, md_list, md_referral_list from dental_letters where letterid='".mysql_real_escape_string($_GET['id'])."'";
$q = mysql_query($s);
$r = mysql_fetch_assoc($q);
$file = './letterpdfs/'.$r['pdf_path'];
$jpg = substr( $file, 0, -4 ) . '';
//echo $file;
?><br /><?php
//echo $jpg;
exec('gs -dSAFER -dBATCH -dNOPAUSE -sDEVICE=jpeg -dTextAlphaBits=4 -dGraphicsAlphaBits=4 -r300 -sOutputFile='.$jpg.'-%01d.jpg '. $file)
?>

<div style="float:left;"><a href="#" onclick="send_letter('<?=$_GET['id']; ?>')">Looks Good! SEND!</a> | <a href="#" onclick="parent.disablePopupClean();">Cancel/Revise</a></div>
<?php
  $fsql = "SELECT fax, preferredcontact from dental_contact WHERE contactid='".mysql_real_escape_string($r['md_list'])."' OR 
contactid='".mysql_real_escape_string($r['md_referral_list'])."'";
  $fq = mysql_query($fsql);
  $f = mysql_fetch_assoc($fq); 
?>
<?php if($r['send_method']=='fax' || ($r['send_method']=='' && $f['preferredcontact']=='fax')){ ?>
<div style="float:right;margin-right:20px;">Digital Fax - <?= format_phone($f['fax']); ?></div>
<?php } ?>
<?php for($i=1; $i<5; $i++){ 
if(file_exists($jpg."-". $i.".jpg")){
?>
<img src="<?= $jpg; ?>-<?= $i; ?>.jpg" style="border:solid 2px #333;" width="600" />
<?php
}
}
?>


<script type="text/javascript">
  function reload_parent(){
    parent.disablePopup();
    //parent.window.location = parent.window.location;

  }



  function send_letter(id){
                                  $.ajax({
                                        url: "includes/letter_send.php",
                                        type: "post",
                                        data: {id: id},
                                        success: function(data){
<?php
if(isset($_REQUEST['parent'])){
if($_REQUEST['goto']!=''){
                                if($_REQUEST['goto']=='flowsheet'){
                                        $page = 'manage_flowsheet3.php?pid='.$_GET['pid'].'&addtopat=1';
                                }elseif($_REQUEST['goto']=='letter'){
                                        $page = 'dss_summ.php?sect=letters&pid='.$_GET['pid'].'&addtopat=1';
                                }elseif($_REQUEST['goto']=='new_letter'){
                                        $page = 'new_letter.php?pid='.$_GET['pid'];
                                }elseif($_REQUEST['goto']=='faxes'){
                                        $page = 'manage_faxes.php';
                                }
?>
                                parent.window.location = '<?= $page ?>';
                        <?php }else{
?>
                parent.window.location = '<?php print ($_GET['backoffice'] == "1") ? "/manage/admin/manage_letters.php?status=pending" : "/manage/letters.php?status=pending"; ?>';
<?php
}
}else{
?>
                                parent.window.location = parent.window.location;
<?php
}
 ?>
                                                
                                        },
                                        failure: function(data){
                                                //alert('fail');
                                        }
                                  });


  }

</script>
