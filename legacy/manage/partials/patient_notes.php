<?php
namespace Ds3\Libraries\Legacy;

if (isset($my)) { ?>
    <style>
        #sect_notes dd {
            word-break: break-all;
        }
    </style>
    <table width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center" class="table table-bordered table-hover">
        <?php
        if (count($my) == 0) { ?>
            <tr class="tr_bg">
                <th valign="top" class="col_head" colspan="10" align="center">No Records</th>
            </tr>
            <?php
        } else {
            $db = new Db();

            $signNotesSql = "SELECT sign_notes FROM dental_users where userid = '" . $db->escape($_SESSION['userid']) . "'";
            $signNotesResult = $db->getRow($signNotesSql);

            $userSign = $signNotesResult['sign_notes'];
            $userIds = [];
            foreach ($my as $dentalNote) {
                $userIds[] = $dentalNote['userid'];
            }
            $users = [];
            if (count($userIds)) {
                $userIdsString = $db->escapeList($userIds);
                $userSql = "SELECT * FROM dental_users WHERE userid IN ($userIdsString);";
                $users = $db->getResults($userSql);
            }
            foreach ($my as $dentalNote) {
                if ($dentalNote["signed_id"] != '') {
                    $bg_color = "";
                    $status = "Signed";
                } elseif ($dentalNote["status"] == 2) {
                    $bg_color = "#FFFF99";
                    $status = 'Draft';
                } else {
                    $bg_color = "#FF9999";
                    $status = "Unsigned";
                }
                $theUser = [];
                foreach ($users as $user) {
                    if ($user['userid'] == $dentalNote['userid']) {
                        $theUser = $user;
                    }
                }
                $tr_class = "tr_active";

                try {
                    $soapNote = json_decode($dentalNote['notes'], true);
                } catch (\Exception $e) {
                    $soapNote = null;
                }
                ?>
                <tr id="note_<?= $dentalNote['notesid']; ?>" class="<?= $tr_class; ?>" <?php if ($bg_color != '') { ?> style="background-color:<?php echo $bg_color?>" <?php } ?>>
                    <td valign="top" style="border:solid 1px #000;">
                        <table width="100%" cellpadding="2" cellspacing="1" border="0">
                            <tr>
                                <td valign="top" width="35%">
                                    Procedure Date:
                                    <span style="font-weight:normal;">
                                        <?= ($dentalNote["procedure_date"] != '') ? date('M d, Y', strtotime(st($dentalNote["procedure_date"]))) : ''; ?>
                                    </span>
                                    <br />
                                    Entry Date:
                                    <span style="font-weight:normal;">
                                        <?php
                                        $entry = ($dentalNote["parent_adddate"] != '') ? $dentalNote["parent_adddate"] : $dentalNote["adddate"];
                                        ?>
                                        <?= date('M d, Y H:i', strtotime(st($entry))); ?>
                                    </span>
                                </td>
                                <td valign="top" width="35%">
                                    Added By:
                                    <span style="font-weight:normal;"><?= st($theUser['first_name']) ?> <?= st($theUser["last_name"]) ?></span>
                                </td>
                                <td valign="top" width="30%">
                                    <span id="note_edit_<?= $dentalNote['notesid']; ?>">
                                        <?php
                                        if ($status == 'Unsigned' || $status == 'Draft') { ?>
                                            Status:
                                            <span style="font-size:14px;"><?= $status; ?></span>
                                            <?php
                                            if (!empty($office_type) && $office_type == DSS_OFFICE_TYPE_FRONT) { ?>
                                                <a href="#" onclick="loadPopup('add_notes.php?pid=<?= $_GET['pid']; ?>&ed=<?= $dentalNote['notesid']; ?>');return false;">Edit</a>
                                                <?php
                                                if ($dentalNote["docid"] == $_SESSION['userid'] || $userSign == 1) { ?>
                                                    /
                                                    <a href="dss_summ.php?pid=<?= $_GET['pid']; ?>&sid=<?= $dentalNote['notesid']; ?>&addtopat=1" onclick="return confirm('This progress note will become a legally valid part of the patient\'s chart; no further changes can be made after saving. Proceed?');">Sign</a>
                                                    <input type="checkbox" class="sign_chbx" name="sign[]" value="<?= $dentalNote['notesid']; ?>" />
                                                <?php
                                                }
                                            }
                                        } else { ?>
                                            Signed By: <?= $dentalNote["signed_name"]; ?>
                                            <br />
                                            Signed On: <?= date('m/d/Y H:i a', strtotime($dentalNote["signed_on"])); ?>
                                        <?php
                                        } ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td valign="top" colspan="3">
                                    <hr size="1" />
                                    <span style="font-weight:normal;">
                                                    <?php if ($soapNote) { ?>
                                                        <dl>
                                                            <dt><strong>Subjective</strong></dt>
                                                            <dd><?= nl2br(e($soapNote['subjective'])) ?></dd>
                                                            <dt><strong>Objective</strong></dt>
                                                            <dd><?= nl2br(e($soapNote['objective'])) ?></dd>
                                                            <dt><strong>Assessment</strong></dt>
                                                            <dd><?= nl2br(e($soapNote['assessment'])) ?></dd>
                                                            <dt><strong>Plan</strong></dt>
                                                            <dd><?= nl2br(e($soapNote['plan'])) ?></dd>
                                                        </dl>
                                                    <?php } else { ?>
                                                        <?= nl2br(st($dentalNote["notes"]));?>
                                                    <?php } ?>
                                                </span>
                                        </td>
                                </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="line-height:2px;">&nbsp;</td>
                </tr>
                <?php
            }
        } ?>
    </table>
    <?php
} ?>
