<? 
include "includes/top.htm";
require_once('../includes/constants.inc');
require_once "includes/general.htm";

?>

<?php
  $reports_sql = "SELECT * FROM dental_payment_reports WHERE claimid = '".mysql_real_escape_string($_GET['insid']). "' ORDER BY adddate DESC";
  $reports_query = mysql_query($reports_sql);  
  if (mysql_num_rows($reports_query) == 0){
    echo ("No records");
  } else {
    ?>
    <table>
    <tr>
      <th>
      Date
      </th>
      <th>
      Response
      </th>
    </tr>
    <?php
    while($reports_result = mysql_fetch_assoc($reports_query)){
      ?>
      <tr>
        <td>
          <?php echo $reports_result['adddate']; ?>
        </td>
        <td>
          <?php echo $reports_result['response']; ?>
        </td>
      </tr>
    <?php
    }
    ?>
    <table>
    <?php
  }
?>

<? include "includes/bottom.htm";?>
