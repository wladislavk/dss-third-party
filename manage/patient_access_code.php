<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/admin/includes/main_include.php';
require_once __DIR__ . '/includes/sescheck.php';
require_once __DIR__ . '/admin/includes/password.php';
require_once __DIR__ . '/includes/constants.inc';

$patientId = intval($_GET['pid']);

$patientQuery = "SELECT access_code, access_code_date
    FROM dental_patients
    WHERE patientid = '$patientId'";
$patientData = $db->getRow($patientQuery);

$isResetAccessCode = empty($patientData['access_code']) || (isset($_GET['reset']) && !isset($_POST['email_but']));

if ($isResetAccessCode) {
    $accessCode = rand(100000, 999999);
    $db->query("UPDATE dental_patients
        SET access_code = '$accessCode', access_code_date = NOW()
        WHERE patientid = '$patientId'");

    $patientData = $db->getRow($patientQuery);
}

if (isset($_POST['email_but'])) {
    $mailerData = retrieveMailerData($_POST['pid']);

    $pat = $mailerData['patientData'];
    $location_info = $mailerData['mailingData'];
    $mailerData = $location_info + $pat;
    $filename = "user_pin_{$pat['patientid']}.pdf";

    // Set active_status = 2
    sendRegEmail($pat['patientid'], $pat['email'], '', $pat['email'], 2);

    $template = getTemplate('patient/pin-instructions');
    $html = parseTemplate($template, $mailerData);

    create_pdf('User Temporary PIN', $filename, $html, null, '', '', '', $_SESSION['docid']);

    ?>
    <br /><br />
    <h3>Temporary PIN document created and email sent to patient.</h3>
    <script type="text/javascript">
        window.location = 'letterpdfs/<?php echo  $filename; ?>';
    </script>
    <?php

    trigger_error("Die called", E_USER_ERROR);
}

$accessCode = $patientData['access_code'];
$startDate = date('m/d/Y', strtotime($patientData['access_code_date']));
$expirationDate = date('m/d/Y', strtotime(date('Y-m-d', strtotime($patientData['access_code_date'])). '+5 days'));

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link href="css/admin.css?v=20160404" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="/manage/admin/js/tracekit.js"></script>
        <script type="text/javascript" src="/manage/admin/js/tracekit.handler.js"></script>
        <script type="text/javascript" src="/manage/admin/script/jquery-1.6.2.min.js"></script>
        <script type="text/javascript" src="/manage/admin/script/jquery-ui-1.8.22.custom.min.js"></script>
        <script type="text/javascript" src="/manage/includes/modal.js"></script>
        <script type="text/javascript" src="script/validation.js"></script>
        <?php if ($isResetAccessCode) { ?>
            <script>
                var patientId = <?= json_encode($patientId) ?>;

                try {
                    parent.$('#access-code').text(<?= json_encode($accessCode) ?>);
                } catch (e) {
                    /**
                     * @see DSS-513
                     *
                     * It is not possible to reload the page immediately, otherwise the "mail patient" option
                     * won't be shown to the user
                     */
                    // parent.location.search = ['?ed=', patientId, '&addtopat=1&pid=', patientId, '&sendPin=1'].join('');
                }
            </script>
        <?php } ?>
        <link rel="stylesheet" href="/manage/admin/css/jquery-ui-1.8.22.custom.css" />
        <link rel="stylesheet" href="css/modal.css" />
    </head>
    <body style="background:#fff;">
        <br />
        <h3>Online Patient Registration Without Text Messaging:</h3>
        <?php if ($isResetAccessCode) { ?>
            <p>
                Is this patient unable or unwilling to receive text messages?
                If so you can generate a temporary PIN that will allow the user to register without receiving a text message activation code.
            </p>
            <p>Temporary PIN: <?= $accessCode ?></p>
            <form method="post">
                <input type="hidden" name="pid" value="<?= $patientId ?>" />
                <input type="hidden" name="access_code" value="<?= $accessCode ?>" />
                <input type="submit" name="email_but" value="Email Patient and Print PIN" />
            </form>
        <?php } else { ?>
            A temporary PIN was created for this patient on <?= $startDate ?> and is valid until <?= $expirationDate ?>.
            The temporary PIN is: <?= $accessCode ?>.
            <br /><br />
            <a href="?pid=<?= $patientId ?>&reset=1">Generate New PIN</a>
        <?php } ?>
    </body>
</html>
