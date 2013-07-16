<?php	session_start(); ?>
<html>

<head>

</head>

<body>
<script language="JavaScript" src="calendar1.js"></script>
<script language="JavaScript" src="calendar2.js"></script>
 <?php
include('admin/includes/main_include.php');
$memouserid = $_SESSION['userid'];
 
 
  if(isset($_POST['submit'])){
      $memobox = $_POST['memobox'];
      $show_until = $_POST['show_until'];
      $memo_check_sql = "SELECT * FROM memo WHERE user_id={$memouserid} LIMIT 1";
      $memo_check_qry = mysql_query($memo_check_sql);
      
      while($memo_array = mysql_fetch_array($memo_check_qry)){
      $total_rows = mysql_num_rows($memo_check_qry);
      if($memo_array != NULL || $memo_array != ''){
      
      if($total_rows >= 1){
          $memo_update_query = "UPDATE memo SET memo='{$memobox}',show_until='{$show_until}' WHERE user_id={$memouserid} LIMIT 1";
          mysql_query($memo_update_query);
          ?>
          <script>
          
          </script>
    <?php }else{
          $memo_update_query = "INSERT INTO memo (user_id,memo,show_until) VALUES({$memouserid},'{$memobox}','{$show_until}') LIMIT 1";
          mysql_query($memo_update_query);
      }
}
}
 }?>
 
 <?php 

$memo_check_sql = "SELECT * FROM memo WHERE user_id={$memouserid} LIMIT 1";
$memo_check_qry = mysql_query($memo_check_sql);
while($memo_array = mysql_fetch_array($memo_check_qry)){
if($memo_array != NULL || $memo_array != ''){
$memo = $memo_array['memo'];
$date = $memo_array['show_until'];
}
}
?>
 <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="width:600px; margin:40px" name="memofrm">
 <textarea name="memobox" cols=60 rows=6>
 <?php echo $memo ?>
 </TEXTAREA>
<br />
<input type="text" onclick="javascript:cal72.popup();" maxlength="255" style="width: 150px;" class="field text addr tbox" name="show_until" id="show_until" value="<?php echo $date; ?>">
							<a href="javascript:cal72.popup();"><img width="16" height="16" border="0" alt="Click Here to Pick up the date" src="img/cal.gif"></a>
							<label for="add1">Show Until</label>
<br />							
<input type="submit" name="submit" value="Update Memo" />


      </form>
 <script language="JavaScript">
	
	   var cal72 = new calendar2(document.forms['memofrm'].elements['show_until']);

    </script>
</body>
 
</html>