<?php 
require_once('classes/tc_calendar.php');
include 'includes/top.htm';?>
<?php if(is_billing($_SESSION['admin_access']) || is_hst($_SESSION['admin_access'])){ ?>

<h1>Welcome to the DS3 backoffice system.</h1>
<p>Any unauthorized use of this system is strictly prohibited. By accessing this system you are bound to the user agreement terms as well as all applicable HIPAA-HiTECH regulations. Please take all possible measures to ensure patient data is protected at all times.</p>


<?php }else{ ?>
                <center><B>Welcome</B></center> <p>&nbsp;</p>
		
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Set Global Memo</b>

		
 <?php

 
  if(isset($_POST['submit'])){
      $memobox = $_POST['memobox'];
      $offdate = isset($_REQUEST["date5"]) ? $_REQUEST["date5"] : "";
      
      $memo_check_sql = "SELECT * FROM memo_admin LIMIT 1";
      $memo_check_qry = mysql_query($memo_check_sql);
      
      while($memo_array = mysql_fetch_array($memo_check_qry)){
      $total_rows = mysql_num_rows($memo_check_qry);      
      if($total_rows >= 1){
          $memo_update_query = "UPDATE memo_admin SET memo='{$memobox}', last_update=CURDATE(), off_date='{$offdate}' LIMIT 1";
          mysql_query($memo_update_query);
      }else{
          $memo_update_query = "INSERT INTO memo_admin (memo,last_update,off_date) VALUES('{$memobox}',CURDATE(),'{$offdate}') LIMIT 1";
          mysql_query($memo_update_query);
      }

}
 }
 
 $memo_check_sql = "SELECT * FROM memo_admin LIMIT 1";
$memo_check_qry = mysql_query($memo_check_sql);
while($memo_array = mysql_fetch_array($memo_check_qry)){

$today = date("m-d-Y", mktime(date("m"), date("d"), date("Y")));

       $day = substr($memo_array['off_date'],-2);
       $year = substr($memo_array['off_date'],-10,4);
       $month = substr($memo_array['off_date'],-5,2);
       
       $date_to_compar = date("m-d-Y", mktime(0, 0, 0, $month, $day, $year));

       if($today >= $date_to_compar){     
echo "<b><font style=\"color:#FF0000;\">EXPIRED</font></b>";
}
?>
 
 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="padding-left: 20px;">
 <textarea name="memobox" cols=90 rows=6>
 <?php 

 if($memo_array['memo'] != NULL || $memo_array['memo'] != ''){
echo $memo_array['memo'];
 }
?></TEXTAREA>

<br /><?php if($memo_array['memo'] != NULL || $memo_array['memo'] != ''){ ?>Current Expiration Date: <font style="color:#FF0000;"><?php echo $memo_array['off_date']; ?></font>&nbsp;&nbsp;&nbsp;<?php } ?>
 <?php

}
?>

<div class="input-group date col-md-3" id="datepicker" data-date="$dd" data-date-format="yyyy-dd-mm">
  <span class="input-group-addon">End date:</span>
  <input class="form-control text-center" type="text" name="date5" value="12-02-2012">
  <span class="input-group-addon">
    <i class="glyphicon glyphicon-calendar"></i>
  </span>
</div>
<input type="submit" name="submit" value="Update Memo">
      </form>
<br /><br />
<?php } ?>
<? include 'includes/bottom.htm';?>
