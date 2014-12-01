<?php
include 'includes/top.htm';
include_once 'includes/constants.inc';

if(isset($_REQUEST['del_note'])){
    $s = "UPDATE dental_notes SET status=0 
          WHERE parentid='".mysqli_real_escape_string($con, $_REQUEST['del_note'])."'
          	OR notesid='".mysqli_real_escape_string($con, $_REQUEST['del_note'])."'";
    $db->query($s);
}

if(isset($_REQUEST['sid'])){
    $s = "UPDATE dental_notes SET signed_id='".mysqli_real_escape_string($con, $_SESSION['userid'])."', signed_on=now() 
          WHERE patientid='".mysqli_real_escape_string($con, $_REQUEST['pid'])."'
          	AND notesid='".mysqli_real_escape_string($con, $_REQUEST['sid'])."'
            AND docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";
    $db->query($s);
    if(isset($_REQUEST['return'])){
        if($_REQUEST['return']=='unsigned'){
        ?>
<script type="text/javascript">
window.location = 'manage_unsigned_notes.php';
</script>
        <?php
        }
    }
}
?>
<link rel="stylesheet" href="css/summ.css" />

<!-- PUT TOP SECTION HERE -->
<?php
$notes_sql = "select n.*, u.name signed_name, p.adddate as parent_adddate from
              (
              select * from dental_notes where status!=0 AND docid='".$_SESSION['docid']."' and patientid='".s_for(!empty($_GET['pid']) ? $_GET['pid'] : '')."' order by adddate desc
              ) as n
              LEFT JOIN dental_users u on u.userid=n.signed_id
              LEFT JOIN dental_notes p ON p.notesid = n.parentid
              group by n.parentid
              order by n.procedure_date DESC, n.adddate desc
              ";
$notes_q = $db->getResults($notes_sql);
$num_unsigned_notes = 0;
if ($notes_q) {
    foreach ($notes_q as $notes_r) {
        if($notes_r['signed_id']==''){
            $num_unsigned_notes++;
        }
    }
}

$dental_letters_query = "SELECT letterid FROM dental_letters
                        JOIN dental_patients ON dental_letters.patientid=dental_patients.patientid
                        WHERE dental_letters.status = '0' AND 
                        dental_letters.deleted = '0' AND 
                        dental_patients.docid = '".mysqli_real_escape_string($con, $_SESSION['docid'])."' AND
                        dental_letters.patientid= '".mysqli_real_escape_string($con, (!empty($_REQUEST['pid']) ? $_REQUEST['pid'] : ''))."';";

$pending_letters = $db->getNumberRows($dental_letters_query);
?>

<div id="content">
<ul id="summ_nav">
  <li><a href="#" onclick="show_sect('summ')" id="link_summ">SUMMARY</a></li>
  <li><a href="#" onclick="show_sect('notes')" id="link_notes">PROG NOTES <?= ($num_unsigned_notes>0)?"(".$num_unsigned_notes.")":''; ?></a></li>
  <li><a href="#" onclick="show_sect('treatment')" id="link_treatment">TREATMENT Hx</a></li>
  <li><a href="#" onclick="show_sect('health')" id="link_health">HEALTH Hx</a></li>
  <li><a href="#" onclick="show_sect('letters')" id="link_letters">LETTERS <?= ($pending_letters>0)?"(".$pending_letters.")":''; ?></a></li>
  <li><a href="#" onclick="show_sect('sleep')" id="link_sleep">SLEEP TESTS</a></li>
  <li><a href="#" onclick="show_sect('subj')" id="link_subj">SUBJ TESTS</a></li>
</ul>
    <div id="sections">
        <div id="sect_summ">
            <?php include 'summ_summ.php'; ?>
        </div>
        <div id="sect_notes">
            <?php include 'summ_notes.php'; ?>
        </div>
        <div id="sect_treatment">
            <?php include 'summ_treatment.php'; ?>
        </div>
        <div id="sect_health">
            <?php include 'summ_health.php'; ?>		
        </div>
        <div id="sect_letters">
            <?php include 'summ_letters.php'; ?>
        </div>
        <div id="sect_sleep">
            <?php include 'summ_sleep.php'; ?>
        </div>
        <div id="sect_subj">
            <?php include 'summ_subj.php'; ?>
        </div>
    </div>
    <div class="clear"></div>
    <div>
        <div id="popupContact" style="width:750px;">
            <a id="popupContactClose"><button>X</button></a>
            <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
        </div>
        <div id="backgroundPopup"></div>
        <div id="popupRefer" style="height:550px; width:750px;">
            <a id="popupReferClose"><button>X</button></a>
            <iframe id="aj_ref" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
        </div>
        <div id="backgroundPopupRef"></div>

<?php include 'includes/bottom.htm';?>

<script src="js/dss_summ.js" type="text/javascript"></script>