<?php
namespace Ds3\Libraries\Legacy;

include "includes/top.htm";
include_once "includes/constants.inc";

$db = new Db();

if(isset($_GET['vobdel'])){
    $d = "DELETE FROM dental_insurance_preauth WHERE id='".$db->escape($_GET['vobdel'])."'
        AND doc_id = '".$db->escape($_SESSION['docid'])."'";
    $db->query($d);
} ?>

<a href="#" style="float:right;margin-right:20px;" onclick="$('#ins_info').show(500);$(this).hide();return false;" id="ins_info_but" class="button"> View Ins. Info </a>
<div id="ins_info" class="fullwidth" style="display:none;">
    <a href="#" style="float:right;margin-right:20px;" onclick="$('#ins_info').hide(500);$('#ins_info_but').show();return false;" class="button"> Hide Ins. Info </a>
    <a href="add_patient.php?ed=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>&preview=1&addtopat=1&pid=<?php echo  (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>#p_m_ins" style="float:right;margin-right:20px;" class="button"> Edit Insurance </a>
    <?php include 'insurance_info.php'; ?>
</div>
<?php include 'vob_checklist.php'; ?>
<div style="clear:both;"></div>
<script src="js/manage_insurance.js" type="text/javascript"></script>
<?php
include 'includes/bottom.htm';
?>
