<?php
namespace Ds3\Libraries\Legacy;

$is_front_office = false;
$is_back_office = true;

$mark_as_viewed = false;
$header_class = 'page-header';
$table_style = 'class="table -table-bordered table-hover"';

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/includes/payment-report.inc';
require_once __DIR__ . '/includes/bottom.htm';
