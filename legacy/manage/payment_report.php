<?php
namespace Ds3\Libraries\Legacy;

$is_front_office = true;
$is_back_office = false;

$mark_as_viewed = true;
$header_class = 'admin_head';
$table_style = 'width="98%" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" align="center"';

require_once __DIR__ . '/includes/top.htm';
require_once __DIR__ . '/admin/includes/payment-report.inc';
require_once __DIR__ . '/includes/bottom.htm';
