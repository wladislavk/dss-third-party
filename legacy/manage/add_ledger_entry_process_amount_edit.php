<?php
namespace Ds3\Libraries\Legacy;

include_once 'admin/includes/main_include.php';
include "includes/sescheck.php";

echo '<input readonly="readonly" name="amount" type="text" class="tbox" value="'.(!empty($row['amount']) ? $row['amount'] : '').'"  maxlength="255"/>';
