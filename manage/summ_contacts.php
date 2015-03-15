<?php namespace Ds3\Legacy; ?>
<?php

$thesql = "select * from dental_patients where patientid='".mysqli_real_escape_string($con,(!empty($_REQUEST["pid"]) ? $_REQUEST["pid"] : ''))."'";
$themyarray = $db->getRow($thesql);

$docsleep = st($themyarray["docsleep"]);
if ($docsleep) {
    $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
              LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
              WHERE contactid=".$docsleep;
    $d = $db->getRow($dsql);

    if (!empty($d)) {
        $docsleep_id = $d['contactid'];
        $docsleep_name = $d['firstname']." ".$d['lastname'];
        $docsleep_phone = $d['phone1'];
        $docsleep_fax = $d['fax'];
    } else {
        $docsleep_id = '';
        $docsleep_name = '';
        $docsleep_phone = '';
        $docsleep_fax = '';
    }
}

$docpcp = st($themyarray["docpcp"]);
if ($docpcp) {
    $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
              LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
              WHERE contactid=".$docpcp;
    $d = $db->getRow($dsql);

    if (!empty($d)) { 
        $docpcp_id = $d['contactid'];
        $docpcp_name = $d['firstname']." ".$d['lastname'];
        $docpcp_phone = $d['phone1'];
        $docpcp_fax = $d['fax'];
    } else {
        $docpcp_id = '';
        $docpcp_name = '';
        $docpcp_phone = '';
        $docpcp_fax = '';
    }
}

$docdentist = st($themyarray["docdentist"]);
if ($docdentist) {
    $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
              LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
              WHERE contactid=".$docdentist;
    $d = $db->getRow($dsql);

    if (!empty($d)) { 
        $docdentist_id = $d['contactid'];
        $docdentist_name = $d['firstname']." ".$d['lastname'];
        $docdentist_phone = $d['phone1'];
        $docdentist_fax = $d['fax'];
    } else {
        $docdentist_id = '';
        $docdentist_name = '';
        $docdentist_phone = '';
        $docdentist_fax = '';
    }
}

$docent = st($themyarray["docent"]);
if ($docent) {
    $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
              LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
              WHERE contactid=".$docent;
    $d = $db->getRow($dsql);

    if (!empty($d)) { 
        $docent_id = $d['contactid'];
        $docent_name = $d['firstname']." ".$d['lastname'];
        $docent_phone = $d['phone1'];
        $docent_fax = $d['fax'];
    } else {
        $docent_id = '';
        $docent_name = '';
        $docent_phone = '';
        $docent_fax = '';
    }
}

$docmdother = st($themyarray["docmdother"]);
if ($docmdother) {
    $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
              LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
              WHERE contactid=".$docmdother;
    $d = $db->getRow($dsql);

    if (!empty($d)) { 
        $docmdother_id = $d['contactid'];
        $docmdother_name = $d['firstname']." ".$d['lastname'];
        $docmdother_phone = $d['phone1'];
        $docmdother_fax = $d['fax'];
    } else {
        $docmdother_id = '';
        $docmdother_name = '';
        $docmdother_phone = '';
        $docmdother_fax = '';
    }
}

$docmdother2 = st($themyarray["docmdother2"]);
if ($docmdother2) {
    $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
              LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
              WHERE contactid=".$docmdother2;
    $d = $db->getRow($dsql);

    if (!empty($d)) { 
        $docmdother2_id = $d['contactid'];
        $docmdother2_name = $d['firstname']." ".$d['lastname'];
        $docmdother2_phone = $d['phone1'];
        $docmdother2_fax = $d['fax'];
    } else {
        $docmdother2_id = '';
        $docmdother2_name = '';
        $docmdother2_phone = '';
        $docmdother2_fax = '';
    }
}

$docmdother3 = st($themyarray["docmdother3"]);
if ($docmdother3) {
    $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
              LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
              WHERE contactid=".$docmdother3;
    $d = $db->getRow($dsql);

    if (!empty($d)) { 
        $docmdother3_id = $d['contactid'];
        $docmdother3_name = $d['firstname']." ".$d['lastname'];
        $docmdother3_phone = $d['phone1'];
        $docmdother3_fax = $d['fax'];
    } else {
        $docmdother3_id = '';
        $docmdother3_name = '';
        $docmdother3_phone = '';
        $docmdother3_fax = '';
    }
}
?>
<table width="100%" class="table table-striped">
    <tr>
        <th>Type</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Fax</th>
        <th></th>
    </tr>
    <tr>
        <td>Primary Care</td>
        <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?php echo (!empty($docpcp_id) ? $docpcp_id : ''); ?>'); return false;"><?php echo (!empty($docpcp_name) ? $docpcp_name : ''); ?></a></td>
        <td><?php echo (!empty($docpcp_phone) ? format_phone($docpcp_phone) : ''); ?></td>
        <td><?php echo (!empty($docpcp_fax) ? format_phone($docpcp_fax) : ''); ?></td>
        <td><a href="new_letter.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid']: ''); ?>">Write Letter</a></td>
    </tr>
    <tr>
        <td>Sleep Doctor</td>
        <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?php echo (!empty($docsleep_id) ? $docsleep_id : ''); ?>'); return false;"><?php echo (!empty($docsleep_name) ? $docsleep_name : ''); ?></a></td>
        <td><?php echo (!empty($docsleep_phone) ? format_phone($docsleep_phone) : ''); ?></td>
        <td><?php echo (!empty($docsleep_fax) ? format_phone($docsleep_fax) : ''); ?></td>
        <td><a href="new_letter.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">Write Letter</a></td>
    </tr>
    <tr>
        <td>Dentist</td>
        <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?php echo (!empty($docdentist_id) ? $docdentist_id : ''); ?>'); return false;"><?php echo (!empty($docdentist_name) ? $docdentist_name : ''); ?></a></td>
        <td><?php echo (!empty($docdentist_phone) ? format_phone($docdentist_phone) : ''); ?></td>
        <td><?php echo (!empty($docdentist_fax) ? format_phone($docdentist_fax) : ''); ?></td>
        <td><a href="new_letter.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">Write Letter</a></td>
    </tr>
    <tr>
        <td>ENT</td>
        <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?php echo (!empty($docent_id) ? $docent_id : ''); ?>'); return false;"><?php echo (!empty($docent_name) ? $docent_name : ''); ?></a></td>
        <td><?php echo (!empty($docent_phone) ? format_phone($docent_phone) : ''); ?></td>
        <td><?php echo (!empty($docent_fax) ? format_phone($docent_fax) : ''); ?></td>
        <td><a href="new_letter.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">Write Letter</a></td>
    </tr>
    <tr>
        <td>MD Other</td>
        <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?php echo (!empty($docmdother_id) ? $docmdother_id : ''); ?>'); return false;"><?php echo (!empty($docmdother_name) ? $docmdother_name : ''); ?></a></td>
        <td><?php echo (!empty($docmdother_phone) ? format_phone($docmdother_phone) : ''); ?></td>
        <td><?php echo (!empty($docmdother_fax) ? format_phone($docmdother_fax) : ''); ?></td>
        <td><a href="new_letter.php?pid=<?php echo (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">Write Letter</a></td>
    </tr>
<?php 
if($docmdother2!=''){ ?>
    <tr>
        <td>MD Other 2</td>
        <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?php echo $docmdother2_id; ?>'); return false;"><?php echo $docmdother2_name; ?></a></td>
        <td><?php echo format_phone($docmdother2_phone); ?></td>
        <td><?php echo format_phone($docmdother2_fax); ?></td>
        <td><a href="new_letter.php?pid=<?php echo $_GET['pid']; ?>">Write Letter</a></td>
    </tr>
<?php
}
if($docmdother3!=''){ ?>
    <tr>
        <td>MD Other 3</td>
        <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?php echo $docmdother3_id; ?>'); return false;"><?php echo $docmdother3_name; ?></a></td>
        <td><?php echo format_phone($docmdother3_phone); ?></td>
        <td><?php echo format_phone($docmdother3_fax); ?></td>
        <td><a href="new_letter.php?pid=<?php echo $_GET['pid']; ?>">Write Letter</a></td>
    </tr>
<?php 
} ?>
</table>








