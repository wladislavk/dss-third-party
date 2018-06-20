<?php
namespace Ds3\Libraries\Legacy;

$db = new Db();

$thesql = "select * from dental_patients where patientid='".$db->escape( (!empty($_REQUEST["pid"]) ? $_REQUEST["pid"] : ''))."'";
$themyarray = $db->getRow($thesql);

$docsleep = intval($themyarray["docsleep"]);
if ($docsleep) {
    $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax 
        FROM dental_contact dc
        LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
        WHERE contactid=".$docsleep;
    $d = $db->getRow($dsql);

    $docsleep_id = '';
    $docsleep_name = '';
    $docsleep_phone = '';
    $docsleep_fax = '';
    if (!empty($d)) {
        $docsleep_id = $d['contactid'];
        $docsleep_name = $d['firstname']." ".$d['lastname'];
        $docsleep_phone = $d['phone1'];
        $docsleep_fax = $d['fax'];
    }
}

$docpcp = intval($themyarray["docpcp"]);
if ($docpcp) {
    $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax 
        FROM dental_contact dc
        LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
        WHERE contactid=".$docpcp;
    $d = $db->getRow($dsql);

    $docpcp_id = '';
    $docpcp_name = '';
    $docpcp_phone = '';
    $docpcp_fax = '';
    if (!empty($d)) {
        $docpcp_id = $d['contactid'];
        $docpcp_name = $d['firstname']." ".$d['lastname'];
        $docpcp_phone = $d['phone1'];
        $docpcp_fax = $d['fax'];
    }
}

$docdentist = intval($themyarray["docdentist"]);
if ($docdentist) {
    $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax 
        FROM dental_contact dc
        LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
        WHERE contactid=".$docdentist;
    $d = $db->getRow($dsql);

    $docdentist_id = '';
    $docdentist_name = '';
    $docdentist_phone = '';
    $docdentist_fax = '';
    if (!empty($d)) {
        $docdentist_id = $d['contactid'];
        $docdentist_name = $d['firstname']." ".$d['lastname'];
        $docdentist_phone = $d['phone1'];
        $docdentist_fax = $d['fax'];
    }
}

$docent = intval($themyarray["docent"]);
if ($docent) {
    $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
              LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
              WHERE contactid=".$docent;
    $d = $db->getRow($dsql);

    $docent_id = '';
    $docent_name = '';
    $docent_phone = '';
    $docent_fax = '';
    if (!empty($d)) {
        $docent_id = $d['contactid'];
        $docent_name = $d['firstname']." ".$d['lastname'];
        $docent_phone = $d['phone1'];
        $docent_fax = $d['fax'];
    }
}

$docmdother = intval($themyarray["docmdother"]);
if ($docmdother) {
    $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
              LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
              WHERE contactid=".$docmdother;
    $d = $db->getRow($dsql);

    $docmdother_id = '';
    $docmdother_name = '';
    $docmdother_phone = '';
    $docmdother_fax = '';
    if (!empty($d)) {
        $docmdother_id = $d['contactid'];
        $docmdother_name = $d['firstname']." ".$d['lastname'];
        $docmdother_phone = $d['phone1'];
        $docmdother_fax = $d['fax'];
    }
}

$docmdother2 = intval($themyarray["docmdother2"]);
if ($docmdother2) {
    $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
              LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
              WHERE contactid=".$docmdother2;
    $d = $db->getRow($dsql);

    $docmdother2_id = '';
    $docmdother2_name = '';
    $docmdother2_phone = '';
    $docmdother2_fax = '';
    if (!empty($d)) {
        $docmdother2_id = $d['contactid'];
        $docmdother2_name = $d['firstname']." ".$d['lastname'];
        $docmdother2_phone = $d['phone1'];
        $docmdother2_fax = $d['fax'];
    }
}

$docmdother3 = intval($themyarray["docmdother3"]);
if ($docmdother3) {
    $dsql = "SELECT dc.contactid, dc.lastname, dc.firstname, dct.contacttype, dc.phone1, dc.fax FROM dental_contact dc
              LEFT JOIN dental_contacttype dct ON dct.contacttypeid = dc.contacttypeid
              WHERE contactid=".$docmdother3;
    $d = $db->getRow($dsql);

    $docmdother3_id = '';
    $docmdother3_name = '';
    $docmdother3_phone = '';
    $docmdother3_fax = '';
    if (!empty($d)) {
        $docmdother3_id = $d['contactid'];
        $docmdother3_name = $d['firstname']." ".$d['lastname'];
        $docmdother3_phone = $d['phone1'];
        $docmdother3_fax = $d['fax'];
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
        <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?= (!empty($docpcp_id) ? $docpcp_id : ''); ?>'); return false;"><?= (!empty($docpcp_name) ? $docpcp_name : ''); ?></a></td>
        <td><?= (!empty($docpcp_phone) ? format_phone($docpcp_phone) : ''); ?></td>
        <td><?= (!empty($docpcp_fax) ? format_phone($docpcp_fax) : ''); ?></td>
        <td><a href="new_letter.php?pid=<?= (!empty($_GET['pid']) ? $_GET['pid']: ''); ?>">Write Letter</a></td>
    </tr>
    <tr>
        <td>Sleep Doctor</td>
        <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?= (!empty($docsleep_id) ? $docsleep_id : ''); ?>'); return false;"><?= (!empty($docsleep_name) ? $docsleep_name : ''); ?></a></td>
        <td><?= (!empty($docsleep_phone) ? format_phone($docsleep_phone) : ''); ?></td>
        <td><?= (!empty($docsleep_fax) ? format_phone($docsleep_fax) : ''); ?></td>
        <td><a href="new_letter.php?pid=<?= (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">Write Letter</a></td>
    </tr>
    <tr>
        <td>Dentist</td>
        <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?= (!empty($docdentist_id) ? $docdentist_id : ''); ?>'); return false;"><?= (!empty($docdentist_name) ? $docdentist_name : ''); ?></a></td>
        <td><?= (!empty($docdentist_phone) ? format_phone($docdentist_phone) : ''); ?></td>
        <td><?= (!empty($docdentist_fax) ? format_phone($docdentist_fax) : ''); ?></td>
        <td><a href="new_letter.php?pid=<?= (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">Write Letter</a></td>
    </tr>
    <tr>
        <td>ENT</td>
        <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?= (!empty($docent_id) ? $docent_id : ''); ?>'); return false;"><?= (!empty($docent_name) ? $docent_name : ''); ?></a></td>
        <td><?= (!empty($docent_phone) ? format_phone($docent_phone) : ''); ?></td>
        <td><?= (!empty($docent_fax) ? format_phone($docent_fax) : ''); ?></td>
        <td><a href="new_letter.php?pid=<?= (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">Write Letter</a></td>
    </tr>
    <tr>
        <td>MD Other</td>
        <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?= (!empty($docmdother_id) ? $docmdother_id : ''); ?>'); return false;"><?= (!empty($docmdother_name) ? $docmdother_name : ''); ?></a></td>
        <td><?= (!empty($docmdother_phone) ? format_phone($docmdother_phone) : ''); ?></td>
        <td><?= (!empty($docmdother_fax) ? format_phone($docmdother_fax) : ''); ?></td>
        <td><a href="new_letter.php?pid=<?= (!empty($_GET['pid']) ? $_GET['pid'] : ''); ?>">Write Letter</a></td>
    </tr>
    <?php
    if ($docmdother2 != '') { ?>
        <tr>
            <td>MD Other 2</td>
            <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?= $docmdother2_id; ?>'); return false;"><?= $docmdother2_name; ?></a></td>
            <td><?= format_phone($docmdother2_phone); ?></td>
            <td><?= format_phone($docmdother2_fax); ?></td>
            <td><a href="new_letter.php?pid=<?= $_GET['pid']; ?>">Write Letter</a></td>
        </tr>
        <?php
    }
    if ($docmdother3 != '') { ?>
        <tr>
            <td>MD Other 3</td>
            <td><a href="#" onclick="loadPopup('view_contact.php?ed=<?= $docmdother3_id; ?>'); return false;"><?= $docmdother3_name; ?></a></td>
            <td><?= format_phone($docmdother3_phone); ?></td>
            <td><?= format_phone($docmdother3_fax); ?></td>
            <td><a href="new_letter.php?pid=<?= $_GET['pid']; ?>">Write Letter</a></td>
        </tr>
        <?php
    } ?>
</table>
