<?php namespace Ds3\Libraries\Legacy; ?><?php
include "includes/top.htm";
include_once 'includes/constants.inc';
include "includes/similar.php";
?>

<link rel="stylesheet" href="css/pending.css" type="text/css" media="screen" />

<?php
//SQL to search for possible duplicates

$docId = intval($_SESSION['docid']);
$leftJoinDuplicates = "LEFT JOIN (
        SELECT COUNT(contactid) AS total, company
        FROM dental_contact
        WHERE docid = '$docId'
            AND status = 1
            AND IFNULL(company, '') != ''
        GROUP BY company
    ) by_company
    ON by_company.company = c.company
    LEFT JOIN (
        SELECT COUNT(contactid) AS total, firstname, lastname
        FROM dental_contact
        WHERE docid = '$docId'
            AND status = 1
            AND (
                IFNULL(firstname, '') != ''
                OR IFNULL(lastname, '') != ''
            )
        GROUP BY firstname, lastname
    ) by_name
    ON by_name.firstname = c.firstname
        AND by_name.lastname = c.lastname
    LEFT JOIN (
        SELECT COUNT(contactid) AS total, add1, city, state, zip
        FROM dental_contact
        WHERE docid = '$docId'
            AND status = 1
            AND (
                IFNULL(add1, '') != ''
                OR IFNULL(city, '') != ''
                OR IFNULL(state, '') != ''
                OR IFNULL(zip, '') != ''
            )
        GROUP BY add1, city, state, zip
    ) by_address
    ON by_address.add1 = c.add1
        AND by_address.city = c.city
        AND by_address.state = c.state
        AND by_address.zip = c.zip
    ";
$sumTotalsConditional = 'IFNULL(by_company.total, 0) + IFNULL(by_name.total, 0) + IFNULL(by_address.total, 0)';

if(isset($_REQUEST['deleteid'])){
    $dsql = "DELETE FROM dental_contact WHERE docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."' AND contactid='".mysqli_real_escape_string($con, $_REQUEST['deleteid'])."'";
    $db->query($dsql);
?>
<script type="text/javascript">
    window.location = "pending_contacts.php";
</script>
<?php
}elseif(isset($_REQUEST['createid'])){
    $sql = "UPDATE dental_contact SET status= CASE status WHEN 4 THEN 2 ELSE 1 END WHERE docid='".mysqli_real_escape_string($con, $_SESSION['docid'])."' AND contactid='".mysqli_real_escape_string($con, $_REQUEST['createid'])."'";
    $db->query($sql);
?>
<script type="text/javascript">
    window.location = "pending_contacts.php";
</script>
<?php
}elseif(isset($_REQUEST['createtype'])){
	//createtype for duplicates or not
	if($_REQUEST['createtype']=='yes'){
        $sql3 = "SELECT c.contactid
            FROM dental_contact c
                $leftJoinDuplicates
            WHERE c.docid = '$docId'
                AND c.status = '3'
                AND $sumTotalsConditional > 0";
        $sql4 = "SELECT c.contactid
            FROM dental_contact c
                $leftJoinDuplicates
            WHERE c.docid = '$docId'
                AND c.status = '4'
                AND $sumTotalsConditional > 0";
	}elseif($_REQUEST['createtype']=='no'){
        $sql3 = "SELECT c.contactid
            FROM dental_contact c
                $leftJoinDuplicates
            WHERE c.docid = '$docId'
                AND c.status = '3'
                AND $sumTotalsConditional = 0";
        $sql4 = "SELECT c.contactid
            FROM dental_contact c
                $leftJoinDuplicates
            WHERE c.docid = '$docId'
                AND c.status = '4'
                AND $sumTotalsConditional = 0";
	}
    $q3 = $db->getResults($sql3);
    $ids3 = array();
    foreach ($q3 as $r3) {
		array_push($ids3, $r3['contactid']);
	}
    $q4 = $db->getResults($sql4);
    $ids4 = array();
    foreach ($q4 as $r4) {
        array_push($ids4, $r4['contactid']);
    }
    if (count($ids3)) {
	    $s = "UPDATE dental_contact SET status=1 WHERE contactid IN('".implode($ids3, "','")."')";
	    $db->query($s);
    }
    if (count($ids4)) {
        $s = "UPDATE dental_contact SET status=2 WHERE contactid IN('".implode($ids4, "','")."')";
        $db->query($s);
    }
?>
<script type="text/javascript">
    window.location = "pending_contacts.php";
</script>
<?php
}elseif(isset($_REQUEST['deletetype'])){
    if($_REQUEST['deletetype']=='yes'){
        $sql = "SELECT c.contactid
                FROM dental_contact c
                    $leftJoinDuplicates
                WHERE c.docid = '$docId'
                    AND c.status IN (3, 4)
                    AND $sumTotalsConditional > 0";
    }elseif($_REQUEST['deletetype']=='no'){
        $sql = "SELECT c.contactid
                FROM dental_contact c
                    $leftJoinDuplicates
                WHERE c.docid = '$docId'
                    AND c.status IN (3, 4)
                    AND $sumTotalsConditional = 0";
    }
    $q = $db->getResults($sql);
    $ids = array();
    foreach ($q as $r) {
        array_push($ids, $r['contactid']);
    }
    $s = "DELETE FROM dental_contact WHERE contactid IN(".implode($ids, ',').")";
    $db->query($s);
?>
<script type="text/javascript">
    window.location = "pending_contacts.php";
</script>
<?php
}
$sql = "SELECT c.*
    FROM dental_contact c
        $leftJoinDuplicates
    WHERE c.docid = '$docId'
        AND c.status IN (3, 4)
        AND $sumTotalsConditional > 0
    ORDER BY c.lastname ASC";
$my = $db->getResults($sql);

$message = '';

if (!empty($_GET['msg'])) {
    $message = e($_GET['msg']);
    $json = json_decode($_GET['msg'], true);

    if (is_string($json)) {
        $message = e($json);
    }

    if (is_array($json)) {
        $message = '';

        array_walk_recursive($json, 'e');

        if (!empty($json['errors'])) {
            $message .= '<ul><li>' . join('</li><li>', $json['errors']) . '.</li></ul>';
        }

        if (!empty($json['inserted'])) {
            $message .= "{$json['inserted']} new contacts.";
        }
    }
}

?>

<script src="js/pending.js" type="text/javascript"></script>

<button style="float:right;margin-right:20px;" onclick="return redirect('upload_contacts.php');" class="addButton">
    Upload
</button>
<br />
<span class="admin_head">
	Manage Pending Contacts Possible Duplicates
</span>
<br />
<br />
<a href="<?php echo $_SERVER['PHP_SELF']; ?>?deletetype=yes" style="margin-right:10px;float:right;" onclick="return confirm('Are you sure you want to delete all?');">Delete All</a>
<a href="<?php echo $_SERVER['PHP_SELF']; ?>?createtype=yes" style="margin-right:10px;float:right;">Create All</a>
<br />
<?php if ($message) { ?>
    <div align="center" class="red">
        <?= $message ?>
    </div>
<?php } ?>

<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
	<tr class="tr_bg_h">
		<td valign="top" class="col_head" width="15%">
			Contact Name
		</td>
		<td valign="top" class="col_head" width="15%">
			Company
		</td>
		<td valign="top" class="col_head" width="40%">
			Address
		</td>
        <td valign="top" class="col_head" width="15%">
            Phone
        </td>
        <td valign="top" class="col_head" width="45%">
            Similar Contacts
        </td>
		<td valign="top" class="col_head" width="15%">
			Action
		</td>
	</tr>
	<?php if(count($my) == 0){ ?>
	<tr class="tr_bg">
		<td valign="top" class="col_head" colspan="6" align="center">
			No Records
		</td>
	</tr>
	<?php
	}
	else
	{
        foreach ($my as $myarray) {
			$sim = similarContacts($myarray['contactid']);?>
    <tr class="<?php echo $tr_class;?> <?php echo ($myarray['viewed'])?'':'unviewed'; ?>">
        <td valign="top">
            <?php echo st($myarray["firstname"]);?>&nbsp;
            <?php echo st($myarray["lastname"]);?>
        </td>
        <td valign="top">
            <?php echo st($myarray["company"]);?>
        </td>
        <td valign="top">
            <?php echo st($myarray["add1"]); ?>
            <?php echo st($myarray["add2"]); ?>
            <?php echo st($myarray["city"]); ?>,
            <?php echo st($myarray["state"]); ?>
            <?php echo st($myarray["zip"]); ?>
        </td>
        <td valign="top">
            <?php echo format_phone($myarray["phone1"]); ?>
        </td>
        <td valign="top">
            <a href="#" onclick="$('.sim_<?php echo $myarray['contactid']; ?>').toggle();return false;"><?php echo count($sim); ?></a>
        </td>
        <td valign="top">
            <a href="pending_contacts.php?createid=<?php echo $myarray["contactid"]; ?>" class="editlink" title="EDIT">
                Create
            </a>
            <a href="pending_contacts.php?deleteid=<?php echo $myarray["contactid"]; ?>" onclick="return confirm('Are you sure you want to delete <?php echo $myarray['firstname']." ".$myarray['lastname']; ?>?')" class="editlink" title="EDIT">
                Delete
            </a>
            <a href="#" onclick="loadPopup('view_contact.php?ed=<?php echo $myarray["contactid"]; ?>');return false;" class="editlink" title="EDIT">
                View
            </a>
        </td>
    </tr>
    		<?php
    		if(count($sim) > 0){
    		    foreach($sim as $s){ ?>
    <tr class="similar sim_<?php echo $myarray['contactid']; ?>">
        <td valign="top">
            <?php echo st($s["name"]);?>
        </td>
        <td valign="top">
            <?php echo st($s["company"]);?>
        </td>
        <td valign="top">
            <?php echo st($s["address"]); ?>
        </td>
        <td valign="top">
            <?php echo format_phone($s["phone1"]); ?>
        </td>
        <td>
        </td>
        <td valign="top">
            <a href="#" onclick="loadPopup('view_contact.php?ed=<?php echo $s["id"]; ?>');return false;" class="editlink" title="EDIT">
                View
            </a>
        </td>
    </tr>
			<?php
    		    }
    		}
        }
	}?>
</table>

<?php
$sql = "SELECT c.*
    FROM dental_contact c
        $leftJoinDuplicates
    WHERE c.docid = '$docId'
        AND c.status IN (3, 4)
        AND $sumTotalsConditional = 0
    ORDER BY c.lastname ASC";
$my = $db->getResults($sql);
?>
<span class="admin_head">
        Manage Pending Contacts No Duplicates
</span>
<br />
<br />
<a href="<?php echo $_SERVER['PHP_SELF']; ?>?deletetype=no" style="margin-right:10px;float:right;" onclick="return confirm('Are you sure you want to delete all?');">Delete All</a>
<a href="<?php echo $_SERVER['PHP_SELF']; ?>?createtype=no" style="margin-right:10px;float:right;">Create All</a>


<table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
    <tr class="tr_bg_h">
        <td valign="top" class="col_head" width="15%">
            Name
        </td>
        <td valign="top" class="col_head" width="15%">
            Company
        </td>
        <td valign="top" class="col_head" width="40%">
            Address
        </td>
        <td valign="top" class="col_head" width="15%">
            Phone
        </td>
        <td valign="top" class="col_head" width="15%">
            Action
        </td>
    </tr>
        <?php if(count($my) == 0){ ?>
    <tr class="tr_bg">
        <td valign="top" class="col_head" colspan="5" align="center">
            No Records
        </td>
    </tr>
        <?php
        }
        else
        {
            foreach ($my as $myarray) {
                $sim = similarContacts($myarray['contactid']);?>
    <tr class="<?php echo $tr_class;?> <?php echo ($myarray['viewed'])?'':'unviewed'; ?>">
        <td valign="top">
            <?php echo st($myarray["firstname"]);?>&nbsp;
            <?php echo st($myarray["lastname"]);?>
        </td>
        <td valign="top">
            <?php echo st($myarray["company"]);?>
        </td>
        <td valign="top">
            <?php echo st($myarray["add1"]); ?>
            <?php echo st($myarray["add2"]); ?>
            <?php echo st($myarray["city"]); ?>,
            <?php echo st($myarray["state"]); ?>
            <?php echo st($myarray["zip"]); ?>
        </td>
        <td valign="top">
            <?php echo format_phone($myarray["phone1"]); ?>
        </td>
        <td valign="top">
            <a href="pending_contacts.php?createid=<?php echo $myarray["contactid"]; ?>" class="editlink" title="EDIT">
                Create
            </a>
            <a href="pending_contacts.php?deleteid=<?php echo $myarray["contactid"]; ?>" onclick="return confirm('Are you sure you want to delete <?php echo $myarray['firstname']." ".$myarray['lastname']; ?>?')" class="editlink" title="EDIT">
                Delete
            </a>
            <a href="#" onclick="loadPopup('view_contact.php?ed=<?php echo $myarray["contactid"]; ?>');return false;" class="editlink" title="EDIT">
                View
            </a>
        </td>
    </tr>
        <?php }
        }?>
</table>
<?php

include "includes/bottom.htm";


function similarContacts ($id) {
    $db = new Db();

    $id = intval($id);
    $docId = intval($_SESSION['docid']);

    $s = "SELECT firstname, lastname, company, add1, city, state, zip
        FROM dental_contact
        WHERE contactid='$id'";
    $r = $db->getRow($s);

    $r = array_map([$db, 'escape'], $r);

    $s2 = "SELECT firstname, lastname, company, add1, city, state, zip, phone1
        FROM dental_contact
        WHERE docid = '$docId'
            AND status IN (1, 2)
            AND contactid != '$id'
            AND (
                (
                    IFNULL(company, '') != ''
                    AND IFNULL(company, '') = '{$r['company']}'
                )
                OR (
                    (
                        IFNULL(firstname, '') != ''
                        OR IFNULL(lastname, '') != ''
                    )
                    AND IFNULL(firstname, '') = '{$r['firstname']}'
                    AND IFNULL(lastname, '') = '{$r['lastname']}'
                )
                OR (
                    (
                        IFNULL(add1, '') != ''
                        OR IFNULL(city, '') != ''
                        OR IFNULL(state, '') != ''
                        OR IFNULL(zip, '') != ''
                    )
                    AND IFNULL(add1, '') = '{$r['add1']}'
                    AND IFNULL(city, '') = '{$r['city']}'
                    AND IFNULL(state, '') = '{$r['state']}'
                    AND IFNULL(zip, '') = '{$r['zip']}'
                )
            )";

    $q2 = $db->getResults($s2);
    $docs = array();
    $c = 0;

    foreach ($q2 as $r2) {
        $docs[$c]['id'] = $r2['contactid'];
        $docs[$c]['name'] = $r2['firstname']. " " .$r2['lastname'];
        $docs[$c]['company'] = $r2['company'];
        $docs[$c]['address'] = $r2['add1']. " " . $r2['add2']. " " . $r2['city']. " " . $r2['state']. " " . $r2['zip'];
        $docs[$c]['phone1'] = $r2['phone1'];
        $c++;
    }

    return $docs;
}
