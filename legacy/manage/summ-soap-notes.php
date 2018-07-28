<?php
namespace Ds3\Libraries\Legacy;

$patientId = (int)$_GET['pid'];
$noteWidth = 20;
$widthUnits = 'em';

?>
<table class="section-banner">
    <tr>
        <td>
            SOAP Notes:
        </td>
    </tr>
</table>
<div id="soap-notes-wrapper">
    <div is="soap-notes-display"
         v-bind:patient-id="<?= $patientId ?>"
         v-bind:user-id="<?= (int)$_SESSION['userid'] ?>"
         v-bind:doc-id="<?= (int)$_SESSION['docid'] ?>"
         v-bind:note-width="<?= $noteWidth ?>"
         v-bind:width-units="<?= $widthUnits ?>"></div>
</div>
<p></p>
<?php include __DIR__ . '/includes/vue-setup.htm'; ?>
<link rel="stylesheet" href="/assets/css/components/soap-notes-display.css?v=20171219" />
<script type="text/javascript" src="/assets/app/components/soap-notes-display.js?v=20180727"></script>
<script type="text/javascript" src="/assets/app/patient/soap-notes.js?v=20180502"></script>
<script type="text/javascript" src="/assets/app/vue-cleanup.js?v=20180502"></script>
