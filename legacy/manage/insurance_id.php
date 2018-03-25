<?php namespace Ds3\Libraries\Legacy; ?><?php
    include_once('admin/includes/main_include.php');
    include("includes/sescheck.php");

    $docid = $_SESSION['docid'];
    $patientid = (!empty($_GET['pid']) ? $_GET['pid'] : '');
    //define a maxim size for the uploaded images in Kb
    define ("MAX_SIZE","5096"); 

    //This function reads the extension of the file. It is used to determine if the file  is an image by checking the extension.
    function getExtension($str)
    {
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }

    //This variable is used as a flag. The value is initialized with 0 (meaning no error  found)  
    //and it will be changed to 1 if an errro occures.  
    //If the error occures the file will not be uploaded.
    $errors = 0;
    //checks if the form has been submitted
    if(isset($_POST['Submit'])) {
    	//reads the name of the file the user submitted for uploading
    	$image = $_FILES['image']['name'];
    	//if it is not empty
    	if ($image) {
            //get the original name of the file from the clients machine
    		$filename = stripslashes($_FILES['image']['name']);
    	    //get the extension of the file in a lower case format
    		$extension = getExtension($filename);
    		$extension = strtolower($extension);
    	    //if it is not a known extension, we will suppose it is an error and will not  upload the file,  
            //otherwise we will do more tests
            if ($extension != "jpg") {
    		    //print error message
     			echo '<h1>Unknown extension! Must be ".jpg" file</h1>';
     			$errors=1;
 		    } else {
                //get the size of the image in bytes
                //$_FILES['image']['tmp_name'] is the temporary filename of the file
                //in which the uploaded file was stored on the server
                $size = filesize($_FILES['image']['tmp_name']);
                //compare the size with the maxim size we defined and print error if bigger
                if ($size > MAX_SIZE*1024) {
                	echo '<h1>You have exceeded the size limit!</h1>';
                	$errors=1;
                }
                //we will give an unique name, for example the time in unix time format
                $image_name = $docid."-".$patientid.".".$extension;
                //the new name will be containing the full path where will be stored (images folder)
                $newname = "insurance_cards/".$image_name;
                //we verify if the image has been uploaded, and print error instead
                $copied = copy($_FILES['image']['tmp_name'], $newname);
                if (!$copied) {
                	echo '<h1>Copy unsuccessfull!</h1>';
                	$errors=1;
                }
            }
        }
    }

    //If no errors registred, print the success message
    if(isset($_POST['Submit']) && !$errors) {
        $qry = "SELECT * FROM dental_insurance WHERE patientid={$patientid}";

        $numrows = $db->getNumberRows($qry);
        if($numrows < 1){
            echo "Initial claim form must be created first.";
        }else{
         	$qry = "UPDATE dental_insurance SET card=1 WHERE patientid={$patientid}";
         	
            $query = $db->query($qry);
         	if(!$query){
                echo "Insert failed, please try again.";
            }else{
                echo "<h1>Card created successfully!</h1>";
            }
        }
    }

    $sql = "select card from dental_insurance where docid='".$_SESSION['docid']."' and patientid='".s_for((!empty($_GET['pid']) ? $_GET['pid'] : ''))."' order by adddate";
    
    $my = $db->getResults($sql);
    if ($my) foreach ($my as $myinsid){
        if($myinsid['card'] == 1){
            function imageResize($width, $height, $target)
            {
                if ($width > $height) {
                    $percentage = ($target / $width);
                } else {
                    $percentage = ($target / $height);
                }

                $width = round($width * $percentage);
                $height = round($height * $percentage);

                return "width=\"$width\" height=\"$height\"";
            }
            $idsize = getimagesize("insurance_cards/".$docid."-".$patientid.".jpg");
?>
            <center><img src="<?php echo "insurance_cards/".$docid."-".$patientid.".jpg" ?>" width="80%"></center>
<?php
        }else{
?>
            <!--next comes the form, you must set the enctype to "multipart/frm-data" and use an input type "file" -->
            <form name="newad" method="post" enctype="multipart/form-data"  action="">
                <table>
                	<tr>
                        <td>
                            <input type="file" name="image">
                        </td>
                    </tr>
                	<tr>
                        <td>
                            <input name="Submit" type="submit" value="Upload image">
                        </td>
                    </tr>
                </table>	
            </form>
<?php
        }
    }
?>
