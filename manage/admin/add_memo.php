<?php 
session_start();
require_once 'includes/main_include.php';
include_once 'includes/sescheck.php';
include_once '../includes/general_functions.php';
include_once 'includes/general.htm';
//include "includes/top.htm";
?>

<?php require_once dirname(__FILE__) . '/includes/popup_top.htm'; ?>

<script type="text/javascript" src="/manage/js/preferred_contact.js"></script>
<?php
if($_POST["memosub"] == 1)
{
      $memobox = $_POST['memobox'];
      $offdate = isset($_REQUEST["offdate"]) ? date('Y-m-d', strtotime($_REQUEST["offdate"])) : "";
   if(isset($_POST['ed'])){
          $memo_update_query = "UPDATE memo_admin SET memo='".mysql_real_escape_string($memobox)."', last_update=CURDATE(), off_date='".mysql_real_escape_string($offdate)."' WHERE memo_id='".mysql_real_escape_string($_POST['ed'])."'";
          mysql_query($memo_update_query);
      }else{
          $memo_update_query = "INSERT INTO memo_admin (memo,last_update,off_date) VALUES('".mysql_real_escape_string($memobox)."',CURDATE(),'".mysql_real_escape_string($offdate)."')";
          mysql_query($memo_update_query) or die($memo_update_query.mysql_error());
      }


		?>
		<script type="text/javascript">
			//alert("<?=$msg;?>");
			alert('Thank you for your submission!');
			parent.window.location='manage_memos.php?msg=<?=$msg;?>';
		</script>
		<?
		
		die();
	
}

?>
    <?php if(isset($_GET['ed'])){
	  $sql = "SELECT * FROM memo_admin WHERE memo_id='".mysql_real_escape_string($_GET['ed'])."'";
	  $q = mysql_query($sql);
	  $r = mysql_fetch_assoc($q);
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
            <strong><?= $_GET['msg'] ?></strong>
        </div>
        <?php } ?>
        
        <?php if ($msg != '') { ?>
        <div class="alert alert-success text-center">
            <?= $msg ?>
        </div>
        <?php } ?>
        
        <div class="page-header">
            <h1>
                Add Memo
            </h1>
        </div>
        <form name="contactfrm" action="<?=$_SERVER['PHP_SELF'];?>" method="post" style="width:99%;" class="form-horizontal">
            <div class="form-group date">
                <label for="docid" class="col-md-3 control-label">End Date</label>
                <div class="col-md-9">
  <input class="form-control text-center" type="text" name="offdate" value="<?= $end_date; ?>">
  <span class="input-group-addon">
    <i class="glyphicon glyphicon-calendar"></i>
  </span>

                </div>
            </div>
            <div class="form-group">
                <label for="body" class="col-md-3 control-label">Message</label>
                <div class="col-md-9">
                    <textarea name="memobox" id="memobox" class="form-control" placeholder="Memo"><?= $memo ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                    <input type="hidden" name="memosub" value="1">
		    <?php if(isset($_GET['ed']) && $_GET['ed']!=''){ ?>
			<input type="hidden" name="ed" value="<?= $_GET['ed']; ?>" />
		    <?php } ?>
                    <input type="submit" value="Add Memo" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
</body>
</html>
