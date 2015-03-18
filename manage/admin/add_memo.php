<?php namespace Ds3\Libraries\Legacy; ?><?php 

include_once 'includes/main_include.php';
include_once 'includes/sescheck.php';
include_once '../includes/general_functions.php';
include_once 'includes/general.htm';
//include "includes/top.htm";
?>

<?php include_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>
<?php
if(!empty($_POST["memosub"]) && $_POST["memosub"] == 1)
{
      $memobox = $_POST['memobox'];
      $offdate = isset($_REQUEST["offdate"]) ? date('Y-m-d', strtotime($_REQUEST["offdate"])) : "";
   if(isset($_POST['ed'])){
          $memo_update_query = "UPDATE memo_admin SET memo='".mysqli_real_escape_string($con,$memobox)."', last_update=CURDATE(), off_date='".mysqli_real_escape_string($con,$offdate)."' WHERE memo_id='".mysqli_real_escape_string($con,$_POST['ed'])."'";
          mysqli_query($con,$memo_update_query);
      }else{
          $memo_update_query = "INSERT INTO memo_admin (memo,last_update,off_date) VALUES('".mysqli_real_escape_string($con,$memobox)."',CURDATE(),'".mysqli_real_escape_string($con,$offdate)."')";
          mysqli_query($con,$memo_update_query);
      }


		?>
		<script type="text/javascript">
			//alert("<?php echo $msg;?>");
			alert('Thank you for your submission!');
			parent.window.location='manage_memos.php?msg=<?php echo $msg;?>';
		</script>
		<?
		
		trigger_error("Die called", E_USER_ERROR);
	
}

?>
    <?php if(isset($_GET['ed'])){
	  $sql = "SELECT * FROM memo_admin WHERE memo_id='".mysqli_real_escape_string($con,$_GET['ed'])."'";
	  $q = mysqli_query($con,$sql);
	  $r = mysqli_fetch_assoc($q);
	  $end_date = date('m/d/Y', strtotime($r['off_date']));
	  $memo = $r['memo'];
	}else{
          $end_date = date('m/d/Y');
          $memo = '';
	}
    ?>

    <div class="col-md-6 col-md-offset-3">
        <?php if (isset($_GET['msg'])) { ?>
        <div class="alert alert-danger text-center">
            <strong><?php echo  $_GET['msg'] ?></strong>
        </div>
        <?php } ?>
        
        <?php if (!empty($msg)) { ?>
        <div class="alert alert-success text-center">
            <?php echo  $msg ?>
        </div>
        <?php } ?>
        
        <div class="page-header">
            <h1>
                Add Memo
            </h1>
        </div>
        <form name="contactfrm" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" style="width:99%;" class="form-horizontal">
            <div class="form-group date">
                <label for="docid" class="col-md-3 control-label">End Date</label>
                <div class="input-append date datepicker col-md-9">
  <input class="form-control text-center" type="text" name="offdate" value="<?php echo  $end_date; ?>">
  <span class="input-group-addon add-on">
    <i class="glyphicon glyphicon-calendar"></i>
  </span>

                </div>
            </div>
            <div class="form-group">
                <label for="body" class="col-md-3 control-label">Message</label>
                <div class="col-md-9">
                    <textarea name="memobox" id="memobox" class="form-control" placeholder="Memo"><?php echo  $memo ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <input type="hidden" name="memosub" value="1">
		    <?php if(isset($_GET['ed']) && $_GET['ed']!=''){ ?>
			<input type="hidden" name="ed" value="<?php echo  $_GET['ed']; ?>" />
		    <?php } ?>
                    <input type="submit" value="Add Memo" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
</body>
</html>
