<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';

$db = new Db();
$companyId = (int)$_GET['id'];
$companyType = $db->escape(DSS_COMPANY_TYPE_BILLING);

$companyDetails = $db->getRow("SELECT name
    FROM companies
    WHERE id = '$companyId'
        AND company_type = '$companyType'
    ");
$companyExists = false;
$companyName = '<Invalid Billing Company>';
$listUpdated = false;

if (isset($companyDetails['name'])) {
    $companyExists = true;
    $companyName = $companyDetails['name'];
}

if (isset($_POST['user_sub']) && $companyExists) {
    $listUpdated = true;
    $users = $_POST['user'];
    $exclusives = $_POST['exclusive'];
    $exclusives = array_intersect($exclusives, $users);

    $db->query("UPDATE dental_users
        SET billing_company_id = NULL
        WHERE billing_company_id = '$companyId'
    ");

    if (count($users)) {
        $userIds = $db->escapeList($users);

        $db->query("UPDATE dental_users
            SET billing_company_id = '$companyId'
            WHERE userid IN ($userIds)
        ");

        $db->query("UPDATE dental_user_billing_exclusive
            SET exclusive = 0
            WHERE user_id IN ($userIds)
        ");
    }

    if (count($exclusives)) {
        $exclusiveIds = $db->escapeList($exclusives);

        $db->query("INSERT INTO dental_user_billing_exclusive (user_id, exclusive)
            SELECT userid, 1
            FROM dental_users user
            WHERE user.userid IN ($exclusiveIds)
            ON DUPLICATE KEY UPDATE user_id = user.userid, exclusive = 1
        ");
    }
}

$sql = "SELECT
        user.userid,
        user.username,
        user.first_name,
        user.last_name,
        user.billing_company_id,
        company.name AS billing_company,
        billing_exclusive.exclusive AS exclusive,
        user.billing_company_id = '$companyId' AS company_client,
        user.billing_company_id != '$companyId' && user.billing_company_id != 0 AS other_client
    FROM dental_users user
		LEFT JOIN companies company ON company.id = user.billing_company_id
            AND company.company_type = '$companyType'
		LEFT JOIN dental_user_billing_exclusive billing_exclusive ON billing_exclusive.user_id = user.userid
	WHERE user.docid = 0
	ORDER BY user.billing_company_id = '$companyId' DESC,
	    user.billing_company_id = 0 ASC,
	    user.last_name ASC,
	    user.first_name ASC,
	    user.username ASC
	";

$users = $db->getResults($sql);

?>
<div class="page-header">
    <?= e($companyName) ?> Company Users
</div>
<?php if ($listUpdated) { ?>
    <div class="text-center">
        <div class="well inline-block">User list updated</div>
    </div>
<?php } ?>
<form method="post">
    <table class="table table-bordered table-striped">
        <colgroup>
            <col width="8%" />
            <col width="8%" />
            <col width="54%" />
            <col width="30%" />
        </colgroup>
        <tr>
            <th>
                Client
            </th>
            <th>
                Exclusive
            </th>
            <th>
                User
            </th>
            <th>
                Username
            </th>
        </tr>
        <?php foreach ($users as $user) {
            $isClient = $user['company_client'];
            $isOtherClient = $user['other_client'];
            ?>
            <tr class="<?= $isClient ? 'text-success' : '' ?> <?= $isOtherClient ? 'text-muted' : '' ?>">
                <td>
                    <input type="checkbox" name="user[]" value="<?= $user['userid'] ?>"
                        <?= $isClient ? 'checked' : '' ?>
                        <?= !$companyExists || $isOtherClient ? 'disabled' : '' ?>
                        <?= $isOtherClient ? 'title="User is associated to a different company"' : '' ?>
                    />
                </td>
                <td>
                    <?php if ($isClient || !$isOtherClient) { ?>
                        <input type="checkbox" name="exclusive[]" value="<?= $user['userid'] ?>"
                            <?= $user['exclusive'] ? 'checked' : '' ?>
                            <?= !$companyExists || !$isClient ? 'disabled' : '' ?>
                        />
                    <?php } ?>
                </td>
                <td>
                    <?= e("{$user['last_name']}, {$user['first_name']}") ?>
                </td>
                <td>
                    <?= e($user['username']) ?>
                </td>
            </tr>
        <?php } ?>
    </table>
    <input type="submit" name="user_sub" value="Update" class="btn btn-primary">
</form>
<script>
    jQuery(function($) {
        var $client = $(':checkbox[name^=user]');

        $client.on('change', function () {
            var $this = $(this),
                isChecked = $this.is(':checked'),
                $exclusive = $this
                    .closest('tr')
                    .find(':checkbox[name^=exclusive]')
            ;

            $exclusive.prop('disabled', !isChecked)
                .closest('.checker')
                .toggleClass('disabled', !isChecked)
            ;
        })
    });
</script>
<?php

require_once __DIR__ . '/includes/bottom.htm';
