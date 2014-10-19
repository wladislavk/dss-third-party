<?php
  include_once('admin/includes/main_include.php');
  include_once('includes/constants.inc');
  include_once('includes/preauth_functions.php');
  include("includes/sescheck.php");

  $flowquery = "SELECT * FROM dental_flow_pg1 WHERE pid='".$_GET['pid']."' LIMIT 1;";
  
  $flowresult = $db->getResults($flowquery);
  if(count($flowresult) <= 0){
    $message = "There is no started flowsheet for the current patient.";
  } else {
    $flow = $flowresult[0];
    $copyreqdate = $flow['copyreqdate'];
    $referred_by = $flow['referred_by'];
    $referreddate = $flow['referreddate'];
    $thxletter = $flow['thxletter'];
    $queststartdate = $flow['queststartdate'];
    $questcompdate = $flow['questcompdate'];
    $insinforec = $flow['insinforec'];
    $rxreq = $flow['rxreq'];
    $rxrec = $flow['rxrec'];
    $lomnreq = $flow['lomnreq'];
    $lomnrec = $flow['lomnrec'];
    $contact_location = $flow['contact_location'];
    $questsendmeth = $flow['questsendmeth'];
    $questsender = $flow['questsender'];
    $refneed = $flow['refneed'];
    $refneeddate1 = $flow['refneeddate1'];
    $refneeddate2 = $flow['refneeddate2'];
    $preauth = $flow['preauth'];
    $preauth1 = $flow['preauth1'];
    $preauth2 = $flow['preauth2'];
    $insverbendate1 = $flow['insverbendate1'];
    $insverbendate2 = $flow['insverbendate2'];
  }

  $producer_options = '';
  $p_sql = "SELECT * FROM dental_users WHERE userid=".$_SESSION['docid']." OR (docid=".$_SESSION['docid']." AND producer=1)";
  
  $p_query = $db->getResults($p_sql);
  if ($p_query) foreach ($p_query as $p){
    $producer_options .= '<option value="'.$p['userid'].'" '.(($p['userid']==$_SESSION['userid'])?'selected="selected"':'').'>'.$p['first_name'].' '.$p['last_name'].'</option>';
  }
  $producer_options .= "";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="css/admin.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>

    <script type="text/javascript" src="js/add_ledger_entry.js"></script>

    <?php
        $pla_sql = "SELECT post_ledger_adjustments FROM dental_users where userid='".$_SESSION['userid']."'";
        
        $pla = $db->getRow($pla_sql);
        $getTransCodesValue = 0;
        if($pla['post_ledger_adjustments'] != '1' && $_SESSION['docid']!=$_SESSION['userid']){
          $getTransCodesValue = 1;
        }

        $errors = claim_errors($_GET['pid']);
        $appendElementValue = 0;
        if(count($errors)>0){
          $e_text = 'Unable to file claim: ';
          $e_text .= implode($errors, ', ');
          $appendElementValue = 1;
        }
    ?>

    <script type="text/javascript">
      var getTransCodesValue = <?php echo $getTransCodesValue; ?>;
      var appendElementValue = <?php echo $appendElementValue; ?>;
      var appendElementEText = "<?php echo $e_text; ?>";
      var appendElementProducerOptions = '<?php echo $producer_options; ?>';
      var DSS_TRXN_PENDING = <?php echo DSS_TRXN_PENDING; ?>
    </script>
  </head>

  <body onload="hideRemove();appendElement();">
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <script language="JavaScript" src="calendar1.js"></script>
    <script language="JavaScript" src="calendar2.js"></script>

    <form id="ledgerentryform" name="ledgerentryform" action="insert_ledger_entries.php" method="POST" onsubmit="return validate()">
      <div style="width:200px; margin:0 auto; text-align:center;">
        <input type="hidden" value="0" id="currval" />
      </div>
      <div id="form_div" >
        <div style="background:#FFFFFF none repeat scroll 0 0;height:16px;margin-left:9px;margin-top:20px;width:98%; font-weight:bold;">
          <span style="margin: 0pt 10px 0pt 0pt; float: left; width:83px;">Service Date</span>
          <span style="width:80px;margin: 0pt 10px 0pt 0pt; float: left;" >Entry Date</span>
          <span style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;">Producer</span>
          <span style="width:120px;margin: 0pt 10px 0pt 0pt; float: left;">Procedure Code</span>
          <div style="margin: 0pt 10px 0pt 0pt; float: left; width: 127px;">Transaction Code</div>
          <div style="float:left;font-weight:bold;">Amount</div>
        </div>
        <div id="FormFields" style="margin: 20px 10px;"></div>
        <input type="hidden" name="patientid" value="<?php echo $_GET['pid']; ?>">
        <input type="hidden" name="userid" value="<?php echo $_SESSION['userid']; ?>">
        <input type="hidden" name="docid" value="<?php echo $_SESSION['docid']; ?>">
        <input type="hidden" name="ipaddress" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
        <input type="hidden" name="entrycount" value="javascript::readCookie();">
        <div style="width:200px;float:left;margin-left:10px;text-align:left;">
          <input type="button" onclick="appendElement();$('.remove').css('visibility','visible');" id="linecountbtn"  value="+ Add Line Item">
        </div>
        <div style="width:200px;margin-right:10px;float:right;text-align:right;" id="submitButton">
          <input type="submit" value="Submit Transactions" />
        </div>
      </div>
    </form>

    <?php include("includes/calendarinc.php"); ?>

  </body>
</html> 
