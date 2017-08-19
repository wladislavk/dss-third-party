<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/includes/constants.inc';
require_once __DIR__ . '/includes/formatters.php';
require_once __DIR__ . '/includes/checkemail.php';
require_once __DIR__ . '/includes/general_functions.php';

require_once __DIR__ . '/admin/includes/CsvProcessor.php';
require_once __DIR__ . '/admin/includes/CsvContactProcessorAdapter.php';

if (isset($_POST['submitbut'])) {
    if ($_FILES['csv']['error'] !== 0) { ?>
        <script type="text/javascript">
            window.location = "?msg=<?= urlencode('The file cpuld not be uploaded.') ?>";
        </script>
        <?php

        trigger_error('Die called', E_USER_ERROR);
    }

    $ext = strtolower(preg_replace('/^.*[.]([^.]+)$/', '$1', ($_FILES['csv']['name'])));
    $tmpName = $_FILES['csv']['tmp_name'];

    // check the file is a csv
    if ($ext !== 'csv') { ?>
        <script type="text/javascript">
            window.location = "?msg=<?= urlencode('The file does not have a .csv extension.') ?>";
        </script>
        <?php

        trigger_error('Die called', E_USER_ERROR);
    }

    $db = new Db();
    $patientProcessor = new CsvContactProcessorAdapter($db);
    $csvProcessor = new CsvProcessor();

    $report = $csvProcessor->saveCsvContents(
        $tmpName, $patientProcessor, (int)$_SESSION['docid'], $_SERVER['REMOTE_ADDR'], true
    );

    ?>
    <script type="text/javascript">
        window.location = "pending_contacts.php?msg=<?= urlencode(json_encode($report)) ?>";
    </script>
    <?php

    trigger_error('Die called', E_USER_ERROR);
}

?>
<div style="width:90%; margin-left:5%;">
    <?php if (!empty($_GET['msg'])) { ?>
        <p><strong><?= e($_GET['msg']) ?></strong></p>
    <?php } ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
        <input type="file" name="csv" />
        <br /><br />
        <input type="submit" name="submitbut" value="Upload" />
    </form>
</div>
<br /><br />
<?php

require_once __DIR__ . '/includes/bottom.htm';
