<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/main_include.php';
require_once __DIR__ . '/includes/sescheck.php';
require_once __DIR__ . '/includes/access.php';
require_once __DIR__ . '/../includes/constants.inc';

if (!is_super($_SESSION['admin_access'])) {
    header('Location: /manage/admin');
    trigger_error('Die called', E_USER_ERROR);
}

if (isset($_POST['admin_access'])) {
    $_SESSION['admin_access'] = intval($_POST['admin_access']);
    $_SESSION['admincompanyid'] = intval($_POST['admincompanyid']);
}

$companies = $db->getResults('SELECT id, name FROM companies');
$accessLevels = $dss_admin_access_labels;

require_once __DIR__ . '/includes/top.htm';

?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/styles/default.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.1.0/highlight.min.js"></script>
<h2>Alter Session</h2>
<p class="lead">Ater session level access and linked company, for this session only.</p>
<p>The change will only affect queries from the site that rely on the session data. If queries rely on the user id, this change might have unexpected results.</p>
<form method="post">
    <select name="admin_access" class="form-control input-sm input-inline">
        <?php foreach ($accessLevels as $level=>$label) { ?>
            <option value="<?= $level ?>" <?= $_SESSION['admin_access'] == $level ? 'selected' : '' ?>>
                <?= e("[$level] $label") ?>
            </option>
        <?php } ?>
    </select>
    <select name="admincompanyid" class="form-control input-sm input-inline">
        <option value="0" <?= $_SESSION['admincompanyid'] == 0 ? 'selected' : '' ?>>None</option>
        <?php foreach ($companies as $company) { ?>
            <option value="<?= $company['id'] ?>" <?= $_SESSION['admincompanyid'] == $company['id'] ? 'selected' : '' ?>>
                <?= e("[{$company['id']}] {$company['name']}") ?>
            </option>
        <?php } ?>
    </select>
    <input type="submit" class="btn btn-default" value="Update session values" />
</form>
<?php

require_once __DIR__ . '/includes/bottom.htm';
