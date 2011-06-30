<?php
session_start();
require_once('admin/includes/config.php');
include("includes/sescheck.php");
include "includes/top.htm"; 
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
<?php
 $pcont_qry = "SELECT * FROM dental_pcont LEFT JOIN dental_contact ON dental_pcont.contact_id = dental_contact.contactid WHERE dental_pcont.patient_id=".$patid." UNION SELECT * FROM dental_pcont RIGHT JOIN dental_contact ON dental_pcont.contact_id = dental_contact.contactid WHERE dental_pcont.patient_id=".$patid;
 $pcont_array = mysql_query($pcont_qry);

?>
<div style="margin:20px 20px 0px 20px;">
<table width="99%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" style="margin-left: 11px;">
<tr>
<td class="cat_head">Add Contact to Patient</td>
</tr>

<?php 
 while($pcont_l = mysql_fetch_array($pcont_array)){
 
?>
<tr>
<td>
<?php

if($pcont_l['contacttypeid'] != '0'){
$type_check = "SELECT contacttype FROM dental_contacttype WHERE contacttypeid=".$pcont_l['contacttypeid'];
$type_query = mysql_query($type_check);
$type_array = mysql_fetch_array($type_query);
$currentcontact_type = $type_array['contacttype'];
}else{
$currentcontact_type = "Type Not Set";
}





echo "<a href=\"add_contact.php?ed=".$pcont_l['contactid']."\">".$pcont_l['firstname']." ".$pcont_l['lastname']." - ". $currentcontact_type ."</a><br />";
?>
</td>
</tr>
<?php 
 }
?>

<tr>
<td class="frmhead">
<br /><strong>Attach New Contact</strong>
<?php
if(isset($_POST['patid'])){
$insert_new_contactto = "INSERT INTO dental_pcont(contact_id,patient_id) VALUES(".$_POST['contacts'].",".$_POST['patid'].");";
$insert_new_contacttores = mysql_query($insert_new_contactto);

if($insert_new_contacttores){
?>
<script>
alert('Successfully Added New Contact to Patient');
<!--
<?php
echo("parent.window.location.href='add_patient.php?ed=".$_GET['ed']."&addtopat=1&pid=".$_GET['ed']."'");
?>
// -->
</script>
<?php
}
}
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?ed=".$_GET['ed']; ?>">
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
<input type="hidden" value="<?php echo $patid; ?>" name="patid" />
<input type="submit" value="Add" /> Or <a href="add_contact.php?activePat=<?php echo $_GET['ed']; ?>">Add New Contact</a>
</form> 
</td>
</tr>
 </table>
 </div>
<?php 
include "includes/bottom.htm"; 
?>
