<?php namespace Ds3\Libraries\Legacy; ?><?php 
  include_once('admin/includes/main_include.php');
  include("includes/sescheck.php");

  if(isset($_POST['upload'])) {
    $uploadNeed = $_POST['uploadNeed'];
    $doctorid = $_SESSION['docid'];
    $counter = 0;
    while( ($counter + 1) <= $uploadNeed) {
      if(isset($_FILES['userfile_'.$counter]['size']) && $_FILES['userfile_'.$counter]['size'] > 0){
        $fileName = $_FILES['userfile_'.$counter]['name'];
        $tmpName  = $_FILES['userfile_'.$counter]['tmp_name'];
        $fileSize = $_FILES['userfile_'.$counter]['size'];
        $fileType = $_FILES['userfile_'.$counter]['type'];
        $ext = pathinfo($_FILES['userfile_'.$counter]['name'], PATHINFO_EXTENSION);
        $fp      = fopen($tmpName, 'r');
        $content = fread($fp, filesize($tmpName));
        $content = addslashes($content);
        fclose($fp);

        if(!get_magic_quotes_gpc()) {
            $fileName = addslashes($fileName);
        }

        $query = "INSERT INTO filemanager (name, docid, size, type, ext, content ) VALUES ('$fileName', '$doctorid', '$fileSize', '$fileType', '$ext', '$content')";

        $db->query($query);
        echo "<br><strong>File $fileName uploaded</strong><br>";
      }
      $counter++;
    }
  } 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <link href="css/admin.css" rel="stylesheet" type="text/css" />
    <script language="javascript" type="text/javascript" src="script/validation.js"></script>
    <link rel="stylesheet" href="css/form.css" type="text/css" />
    <script type="text/javascript" src="script/wufoo.js"></script>
  </head>

  <body style="width:100%; text-align:center;">
    <center>
      <?php if (isset($_POST['submitqty'])){ ?>
        <form method="post" enctype="multipart/form-data">
          <table width="350" border="0" cellpadding="1" cellspacing="1" class="box">
            <tr>
              <td width="246">
                <?php
                  // start of dynamic form
                  $uploadNeed = $_POST['uploadNeed'];
                  for($x=0;$x<$uploadNeed;$x++){
                ?>
                    <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                    <input name="userfile_<?php echo $x; ?>" type="file" id="userfile">
                    <input name="uploadNeed" type="hidden" value="<?php echo $uploadNeed;?>">
                <?php
                  // end of for loop
                  }
                ?>
              </td>
              <td width="80">
                <input name="upload" type="submit" class="box" id="upload" value=" Upload ">
              </td>
            </tr>
          </table>
        </form>
      <?php } else { ?>
        <form name="form1" method="post">
          <p>Enter the amount of files you will be uploading. Max = 9.</p>
          <p>
            <select name="uploadNeed" id="uploadNeed" maxlength="1">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            </select>
          </p>
          <p>
            <input type="submit" name="submitqty" value=" Next ">
          </p>
        </form>
      <?php } ?> 
    </center>
  </body>
</html>
