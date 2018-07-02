<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';

$db = new Db();
$companyId = (int)$_GET['id'];
$companyType = $db->escape(DSS_COMPANY_TYPE_SOFTWARE);

$companyDetails = $db->getRow("SELECT name
    FROM companies
    WHERE id = '$companyId'
    AND company_type = '$companyType'
");
$companyExists = false;
$companyName = '<Invalid Software Company>';
$listUpdated = false;

if (isset($companyDetails['name'])) {
    $companyExists = true;
    $companyName = $companyDetails['name'];
}

if (isset($_POST['user_sub']) && $companyExists) {
    $listUpdated = true;
    $users = $_POST['user'];

    $db->query("DELETE FROM dental_user_company WHERE companyid = '$companyId'");

    if (count($users)) {
        $userIds = $db->escapeList($users);
        $db->query("INSERT INTO dental_user_company (userid, companyid)
            SELECT userid, '$companyId'
            FROM dental_users user
            WHERE user.userid IN ($userIds)
            ON DUPLICATE KEY UPDATE userid = user.userid, companyid = '$companyId'
        ");
    }
}

$sql = "SELECT
        user.userid,
        user.username,
        user.first_name,
        user.last_name,
        company_pivot.companyid = '$companyId' AS company_client
    FROM dental_users user
    LEFT JOIN dental_user_company company_pivot ON company_pivot.userid = user.userid
    LEFT JOIN companies company ON company.id = company_pivot.companyid
    AND company.company_type = '$companyType'
    WHERE user.docid = 0
    ORDER BY company_pivot.companyid = '$companyId' DESC,
        user.last_name ASC,
        user.first_name ASC,
        user.username ASC
";

$users = $db->getResults($sql);
?>
<style>
    .well.inline-block {
        display: inline-block;
        margin-left: auto;
        margin-right: auto;
    }
</style>
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
            <col width="10%" />
            <col width="60%" />
            <col width="30%" />
        </colgroup>
        <tr>
            <th>
                Client
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
            ?>
            <tr class="<?= $isClient ? 'text-success' : '' ?>">
                <td>
                    <input type="checkbox" name="user[]" value="<?= $user['userid'] ?>"
                        <?= $isClient ? 'checked' : '' ?>
                        <?= !$companyExists ? 'disabled' : '' ?>
                    />
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
<?php

require_once __DIR__ . '/includes/bottom.htm';
