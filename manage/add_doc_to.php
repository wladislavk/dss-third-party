<?php namespace Ds3\Libraries\Legacy; ?><?php
session_start();
require_once('admin/includes/main_include.php');
include("includes/sescheck.php"); 
?>

<?php
if(isset($_GET['ed'])){
 $patid = $_GET['ed'];
}else{
 $patid = $_POST['patid'];
}
 $pcont_qry = "SELECT * FROM dental_pcont WHERE patient_id=".$patid;
 $pcont_array = mysql_query($pcont_qry);

?>

<table>


<tr>
<td class="frmhead" style="padding:20px;">
<p><strong>Attach New Contact</strong></p>
<?php
if(isset($_POST['patid'])){
$insert_new_contactto = "INSERT INTO dental_pcont(contact_id,patient_id) VALUES(".$_POST['contacts'].",".$_POST['patid'].");";
$insert_new_contacttores = mysql_query($insert_new_contactto);

if($insert_new_contacttores){
echo "Successfully added contact!";
}
}
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<select name="contacts">
    <?php
    $newcont_qry = "SELECT * FROM dental_contact LEFT JOIN dental_contacttype ON dental_contact.contacttypeid = dental_contacttype.contacttypeid WHERE docid=".$_SESSION['docid']." UNION SELECT * FROM dental_contact RIGHT JOIN dental_contacttype ON dental_contact.contacttypeid = dental_contacttype.contacttypeid WHERE docid=".$_SESSION['docid']; 
    $newcont_array = mysql_query($newcont_qry);
    
    while($newcont_list = mysql_fetch_array($newcont_array)){
    if($newcont_list['contacttype'] == ""){
    $newcont_conttype = "Type Not Set";
    }else{
    $newcont_conttype = $newcont_list['contacttype'];
    }
       
       ?>
        
        <option value="<?php echo $newcont_list['contactid']; ?>">
           <?php echo $newcont_list['firstname']." ".$newcont_list['lastname']. " - ". $newcont_conttype; ?>
        </option>
        
       <?php
       
    }
    ?>
</select>
<input type="hidden" value="<?php echo $patid; ?>" name="patid" onclick="Javascript: parent.window.reload;" />
<input type="submit" value="Add" />
</form> 
</td>
</tr>
 </table>
