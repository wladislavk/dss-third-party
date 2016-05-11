<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/includes/main_include.php';
require_once __DIR__ . '/includes/ledger-functions.php';

$isBackOffice = !empty($is_back_office) || empty($is_front_office);

for ($lowerLimit=0; $lowerLimit<=120; $lowerLimit+=30) {
    $upperLimit = $lowerLimit == 120 ? 0 : $lowerLimit + 29;

    ?>
    <span class="lead">
        <?= $lowerLimit . ($upperLimit ? "-$upperLimit" : '+') ?> Days
    </span>
    <?php

    $q = claimAgingBreakdownResults([$lowerLimit, $upperLimit], $isBackOffice, $_GET);
    require __DIR__ . '/../partials/claim_aging_breakdown_table.php';
}
