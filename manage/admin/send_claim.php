<?php namespace Ds3\Libraries\Legacy; ?><?php 
include 'includes/top.htm';?>

<?php
if(isset($_POST['submit'])){

  $p_sql = "SELECT patientid FROM dental_insurance where insuranceid='".mysql_real_escape_string($_REQUEST['insid'])."'";
  $p_q = mysql_query($p_sql);
  
  if(mysql_num_rows($p_q)>0){
    $p = mysql_fetch_assoc($p_q);

    $_GET['insid'] = $_POST['insid'];
    $_GET['pid'] = $p['patientid'];
    $_GET['memid'] = $_POST['memid'];
    $_GET['test'] = $_POST['test'];
    $_GET['payerid'] = $_POST['p_m_ins_payer_id'];
    include '../insurance_electronic_file.php';

      $p_sql = "SELECT response FROM dental_claim_electronic where claimid='".mysql_real_escape_string($_REQUEST['insid'])."' ORDER BY id DESC";
      $p_q = mysql_query($p_sql);
      $p_r = mysql_fetch_assoc($p_q);
      echo $p_r['response'];

  }else{
    ?>CLAIM NOT FOUND!<?php
  }

}
?>

<form method="post">
Ins. id <input type="text" name="insid" />
<br />
Member ID <input type="text" name="memid" />
<br />
Payer ID
<?php
                $p_m_ins_payer_id = st($pat_myarray["p_m_eligible_id"]);
                if($p_m_ins_payer_id){
                  $dsql = "SELECT name, payer_id FROM dental_ins_payer
                        WHERE id=".mysql_real_escape_string($p_m_ins_payer_id);
                  $dq = mysql_query($dsql);
                  $d = mysql_fetch_assoc($dq);
                  $p_m_ins_payer_name = $d['payer_id']." - ".$d['name'];
                }else{
                  $p_m_ins_payer_name = "";
                }
?>
  <script type="text/javascript" src="/manage/script/autocomplete.js"></script>
  <link rel="stylesheet" href="/manage/css/search-hints.css" />

                                        <input type="text" id="ins_payer_name" onclick="updateval(this)" autocomplete="off" name="ins_payer_name" value="<?= ($p_m_ins_payer_name!='')?$p_m_ins_payer_name:'Type insurance payer name'; ?>" style="width:300px;" />
<br />
        <div id="ins_payer_hints" class="search_hints" style="margin-top:20px; display:none;">
                <ul id="ins_payer_list" class="search_list">
                        <li class="template" style="display:none"></li>
                </ul>
        </div>
<script type="text/javascript">
$(document).ready(function(){
  setup_autocomplete('ins_payer_name', 'ins_payer_hints', 'p_m_ins_payer_id', '', '../list_ins_payers.php');
});
</script>
<input type="hidden" name="p_m_ins_payer_id" id="p_m_ins_payer_id" value="<?=$p_m_ins_payer_id;?>" />

<br />

<input type="checkbox" name="test" value="1" /> Test
<br />
<input type="submit" name="submit" value="Send Electronic Claim" class="btn btn-primary">
</form>




<?php include 'eligible_history.php'; ?>




<? include 'includes/bottom.htm';?>
