<?php
namespace Ds3\Libraries\Legacy;

ob_start();
require_once __DIR__ . '/includes/top.htm';
$header = ob_get_clean();

if (!empty($_POST['contacts'])) {
    $counters = getReferralCountersForContacts($_POST['contacts']);
    echo json_encode($counters);
    trigger_error('Die called', E_USER_ERROR);
}

$db = new Db();

if (!empty($_REQUEST["delid"])) {
    $del_sql = "delete from dental_referredby where referredbyid='".$_REQUEST["delid"]."'";
    $db->query($del_sql);

    $msg= "Deleted Successfully";
    ?>
    <script type="text/javascript">
        window.location="<?php echo $_SERVER['PHP_SELF']?>?msg=<?php echo $msg?>";
    </script>
    <?php
    trigger_error("Die called", E_USER_ERROR);
}

$docId = intval($_SESSION['docid']);
$referralTypePhysician = DSS_REFERRED_PHYSICIAN;
$referralTypePatient = DSS_REFERRED_PATIENT;
$contactsPerPage = 10;

$sql = "SELECT
            dc.contactid,
            dc.salutation,
            dc.firstname,
            dc.middlename,
            dc.lastname,
            p.referred_source,
            dc.referredby_notes,
            COUNT(p.patientid) AS num_ref,
            GROUP_CONCAT(CONCAT(p.firstname, ' ', p.lastname)) AS patients_list,
            '$referralTypePhysician' AS referral_type,
            ct.contacttype
        FROM dental_contact dc
            INNER JOIN dental_contacttype ct ON ct.contacttypeid = dc.contacttypeid
            INNER JOIN dental_patients p ON dc.contactid = p.referred_by
        WHERE dc.docid = '$docId'
            AND p.referred_source = '$referralTypePhysician'
        GROUP BY dc.contactid
    UNION
        SELECT
            dp.patientid,
            dp.salutation,
            dp.firstname,
            dp.middlename,
            dp.lastname,
            p.referred_source,
            '',
            COUNT(p.patientid),
            GROUP_CONCAT(CONCAT(p.firstname, ' ', p.lastname)) AS patients_list,
            '$referralTypePatient',
            'Patient'
        FROM dental_patients dp
            INNER JOIN dental_patients p ON dp.patientid = p.referred_by
        WHERE p.docid = '$docId'
            AND p.referred_source = '$referralTypePatient'
        GROUP BY dp.patientid
        ";

if (!empty($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'type':
            $sql .= " ORDER BY referral_type " . $_GET['sortdir'];
            break;
        case 'total':
            $sql .= " ORDER BY num_ref " . $_GET['sortdir'];
            break;
        case 'thirty':
        case 'sixty':
        case 'ninty':
        case 'nintyplus':
            break;
        default:
            $sql .= " ORDER BY lastname " . $_GET['sortdir'] . ", firstname " . $_GET['sortdir'];
            break;
    }
}

$my = $db->getResults($sql);
$num_referredby = count($my);

// get the counters
for ($index = 0; $index < count($my) && $index < $contactsPerPage; $index++) {
    $counters = getReferralCountersForContact($my[$index]['contactid'], $my[$index]['referral_type']);
    $my[$index] += $counters;
}

if (!empty($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'thirty':
            $sort_column = 'num_ref30';
            break;
        case 'sixty':
            $sort_column = 'num_ref60';
            break;
        case 'ninty':
            $sort_column = 'num_ref90';
            break;
        case 'nintyplus':
            $sort_column = 'num_ref90plus';
            break;
    }

    if(isset($sort_column)) {
        usort($my, function ($first, $second) use ($sort_column) {
            $sort_direction_desc = !empty($_GET['sortdir']) && $_GET['sortdir'] == 'DESC' ? true : false;
            if( $first[$sort_column] == $second[$sort_column] ) {
                return 0;
            }
            if($sort_direction_desc) {
                return ($first < $second) ? -1 : 1;
            }
            return ($first > $second) ? -1 : 1;
        });
    }
}

echo $header;

?>
<link rel="stylesheet" href="admin/popup/popup.css" type="text/css" media="screen" />
<link rel="stylesheet" href="css/manage.css" type="text/css" media="screen" />
<script src="admin/popup/popup.js" type="text/javascript"></script>
<script>
    $(document).ready(function(){
        var contacts = [],
            targets = {},
            count = <?= $contactsPerPage ?>,
            page = 1,
            total = 0;

        $('tr[data-contact-id]').each(function(){
            var $this = $(this),
                id = $this.attr('data-contact-id');

            contacts.push({
                id: id,
                type: $this.attr('data-contact-type')
            });

            targets[id] = $this;
        });

        total = Math.ceil(contacts.length/count);

        function requestContactCounters () {
            if (page >= total) {
                return;
            }

            $.ajax({
                url: '/manage/manage_referredby.php',
                type: 'post',
                data: { contacts: contacts.slice(page*count, (page + 1)*count) },
                dataType: 'json',
                complete: function () {
                    page++;
                    setTimeout(requestContactCounters, 100);
                },
                success: function (json) {
                    for (var id in json) {
                        var $target = targets.hasOwnProperty(id) ? targets[id] : false;

                        if (!$target) {
                            continue;
                        }

                        for (var counter in json[id]) {
                            $target.find('span[class*="' + counter + '"]').text(json[id][counter]);
                        }
                    }
                }
            });
        }

        requestContactCounters();
    });
</script>
<span class="admin_head">
    Manage Referred By
</span>
<br />
<br />
&nbsp;

<div align="right">
    <button onclick="loadPopup('add_referredby.php');" class="addButton">
        Add New Referred By
    </button>
    &nbsp;&nbsp;
    <a href="manage_referredby_print.php" class="button">Print List</a>
    &nbsp;&nbsp;
</div>

<br />
<div align="center" class="red">
    <b><?php echo (!empty($_GET['msg']) ? $_GET['msg'] : '');?></b>
</div>

<div id="pager" class="pager">
    <form>
        <img src="images/first.png" class="first">
        <img src="images/prev.png" class="prev">
        <input class="pagedisplay" style="width:75px;" type="text">
        <img src="images/next.png" class="next">
        <img src="images/last.png" class="last">
    </form>
</div>

<form name="sortfrm" action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
    <table id="sort_table" width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" >
        <thead>
        <tr class="tr_bg_h">
            <th valign="top" class="col_head" width="20%">
              Name
            </th>
            <th valign="top" class="col_head" width="20%">
                Physician Type
            </th>
            <th valign="top" class="col_head" width="20%">
                Total Referrals
            </th>
                    <th valign="top" class="col_head">
                            30 Days
                    </th>
                    <th valign="top" class="col_head">
                            60 Days
                    </th>
                    <th valign="top" class="col_head">
                            90 Days
                    </th>
                    <th valign="top" class="col_head">
                            90+ Days
                    </th>

                    <th valign="top" class="col_head">
                            Notes
                    </th>
            <th valign="top" class="col_head">
                Expand
            </th>
        </tr>
        </thead>
        <tbody>
        <?php if($num_referredby == 0) { ?>
            <tr class="tr_bg">
                <td valign="top" class="col_head" colspan="10" align="center">
                    No Records
                </td>
            </tr>
        <?php
        } else {
            foreach ($my as $myarray) {
                $name = st($myarray['salutation'])." ".st($myarray['firstname'])." ".st($myarray['middlename'])." ".st($myarray['lastname']);
            ?>
            <tr data-contact-id="<?= $myarray['contactid'] ?>" data-contact-type="<?= e($myarray['referral_type']) ?>">
                <td valign="top" width="20%">
                    <?php if($myarray['referred_source']==DSS_REFERRED_PHYSICIAN){
                        ?><a href="#" onclick="loadPopup('view_contact.php?ed=<?php echo  $myarray['contactid'];?>');return false;"><?php echo $name;?></a><?php
                    }else{
                        echo $name;
                    } ?>
                </td>
                <td valign="top" width="30%">
                    <?php echo st($myarray['contacttype']);?>
                </td>
                <td valign="top" width="10%">
                    <a href="referredby_patient.php?rid=<?php echo $myarray["contactid"];?>&rsource=<?php echo $myarray["referral_type"];?>" class="editlink">
                        <?php echo $myarray['num_ref'];?>
                    </a>
                </td>
                <td valign="top" width="10%">
                    <a href="referredby_patient.php?rid=<?php echo $myarray["contactid"];?>&rsource=<?php echo $myarray["referral_type"];?>" class="editlink">
                        <span class="num_ref30"><?php echo $myarray['num_ref30'];?></span>
                    </a>
                </td>
                <td valign="top" width="10%">
                    <a href="referredby_patient.php?rid=<?php echo $myarray["contactid"];?>&rsource=<?php echo $myarray["referral_type"];?>" class="editlink">
                        <span class="num_ref60"><?php echo $myarray['num_ref60'];?></span>
                    </a>
                </td>
                <td valign="top" width="10%">
                    <a href="referredby_patient.php?rid=<?php echo $myarray["contactid"];?>&rsource=<?php echo $myarray["referral_type"];?>" class="editlink">
                        <span class="num_ref90"><?php echo $myarray['num_ref90'];?></span>
                    </a>
                </td>
                <td valign="top" width="10%">
                    <a href="referredby_patient.php?rid=<?php echo $myarray["contactid"];?>&rsource=<?php echo $myarray["referral_type"];?>" class="editlink">
                        <span class="num_ref90plus"><?php echo $myarray['num_ref90plus'];?></span>
                    </a>
                </td>
                <td valign="top" width="10%">
                    <a href="#" onclick="loadPopup('add_referredby_notes.php?rid=<?php echo $myarray["contactid"];?>')" class="editlink" title="<?php echo ($myarray['referredby_notes'])?$myarray['referredby_notes']:'No Notes'; ?>">
                        View
                    </a>
                </td>
                <td valign="top">
                    <a href="referredby_patient.php?rid=<?php echo $myarray["contactid"];?>&rsource=<?php echo $myarray["referral_type"];?>" class="editlink" title="<?php echo $myarray['patients_list']; ?>">
                    List
                    </a>
                </td>
            </tr>
        <?php }
        }?>
        </tbody>
    </table>
</form>

<div id="popupContact" style="width:750px;">
    <a id="popupContactClose"><button>X</button></a>
    <iframe id="aj_pop" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0"></iframe>
</div>
<div id="backgroundPopup"></div>

<br /><br />
<?php

require_once __DIR__ . '/includes/bottom.htm';

function getReferralCountersForContact($contactId, $contactType)
{
    $db = new Db();

    $contactId = intval($contactId);
    $contactType = $db->escape($contactType);
    $counters = [];

    $ranges = [
        [0, 30],
        [30, 60],
        [60, 90],
        [90, 0],
    ];

    foreach ($ranges as $range) {
        if ($range[1]) {
            $key = "num_ref{$range[1]}";
            $dateConditional = "BETWEEN DATE_SUB(CURDATE(), INTERVAL {$range[1]} DAY) AND " .
                ($range[0] ? "DATE_SUB(CURDATE(), INTERVAL {$range[0]} DAY)" : 'CURDATE()');
        } else {
            $key = "num_ref{$range[0]}plus";
            $dateConditional = "< DATE_SUB(CURDATE(), INTERVAL {$range[0]} DAY)";
        }

        $count = $db->getColumn("SELECT COUNT(p.patientid) AS total
            FROM dental_patients p
                WHERE p.referred_by = '$contactId'
                    AND p.referred_source = '$contactType'
                    AND STR_TO_DATE(p.copyreqdate, '%m/%d/%Y') $dateConditional", 'total', 0);

        $counters[$key] = $count;
    }

    return $counters;
}

function getReferralCountersForContacts(array $contacts)
{
    $counters = [];
    foreach ($contacts as $contact) {
        $counters[$contact['id']] = getReferralCountersForContact($contact['id'], $contact['type']);
    }
    return $counters;
}
