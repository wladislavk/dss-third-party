<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/claim_functions.php';
require_once __DIR__ . '/access.php';

function claimStatusSwitcher ($targetClaimId, $displayCurrentStatus=true) {
    require __DIR__ . '/../../includes/constants.inc';

    $db = new Db();

    if (!isset($_SESSION['admin_access']) || !is_super($_SESSION['admin_access'])) {
        return;
    }

    $targetClaimId = intval($targetClaimId);
    $currentStatus = $db->getColumn("SELECT status
        FROM dental_insurance
        WHERE insuranceid = '$targetClaimId'", 'status');
    $currentStatusName = ClaimFormData::statusName($currentStatus);

    $selectorId = rand();

    ?>
    <div id="status-switch-<?= $selectorId ?>" class="right text-center" style="padding:1em;"
        title="Super Admin: change the status of the claim. Set 'pending' to allow re-filing the claim">
        <?php if ($displayCurrentStatus) { ?>
            <strong>Current claim status is "<?= e(ucwords($currentStatusName)) ?>"</strong>
        <?php } ?>
        <select>
            <option value="-1" selected>Switch claim status:</option>
            <?php foreach ($dss_claim_status_labels as $value=>$label) {
                if (preg_match('/secondary/i', $label)) {
                    continue;
                }

                ?>
                <option value="<?= $value ?>"><?= e($label) ?></option>
            <?php } ?>
        </select>
    </div>
    <script>
        if (typeof window.jQuery !== 'undefined') {
            jQuery(function($){
                var $div = $('#status-switch-<?= $selectorId ?>'),
                    $select = $div.find('select'),
                    claimId = <?= $targetClaimId ?>,
                    claimStatus, statusName, confirmAction;

                if (!claimId) {
                    return;
                }

                $select.change(function(){
                    claimStatus = $select.val();
                    statusName = $select.find('option[value="' + claimStatus + '"]').text();

                    if (claimStatus == -1) {
                        return;
                    }

                    confirmAction = confirm(
                        'This action will change the status of the claim id ' + claimId +
                        ' to "' + statusName + '"\n\nAre you sure you want to continue?'
                    );

                    if (!confirmAction) {
                        return false;
                    }

                    $select.prop('disabled', true);

                    $.ajax({
                        type: 'get',
                        url: '/manage/admin/manage_claims.php',
                        data: { insid: claimId, upstatus: claimStatus },
                        complete: function () {
                            $select.prop('disabled', false);
                            alert('Action complete, please refresh the page to see the changes.');
                        }
                    });
                });

                $div.show();
            });
        }
    </script>
    <?php
}
