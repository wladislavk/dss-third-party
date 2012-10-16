<?php
/* $date should be in format year-month-day
   $past can be set to true if the date is supposed to be in the past
*/
function format_date($date = null, $past = false) {
  if (empty($date) || $date == '0000-00-00') {
    return "N/A";
  }
	$day = (24 * 60 * 60);
  $totaldays = ceil((strtotime($date) - time()) / $day);
  if ($totaldays < 0) {
    $neg = true;
    $totaldays = abs($totaldays);
  }
  $years = floor($totaldays / 365);
  $months = floor(($totaldays % 365) / 31);
  $days = floor(($totaldays % 365) % 31);

	if ($years > 0 && $past) {
    return $years . " yr" . ($months > 0 ? " " . $months . " mo" : "");
  } else if ($months > 0 && $past){
	return $months . " mo" .($days > 1 ? " $days days" : ($days == 0 ? "" : " $days day"));
  } else if ($totaldays > 0 && $past) {
		return $totaldays . ($totaldays > 1 ? " days" : " day");
  } else if ($past) {
    return "Today";
  }

  if ($years > 0 && !$past && $neg) {
    $value = "<span class=\"red\">(".$years." yr" . ($months > 0 ? " $months mo" : "") . ($days > 1 ? " $days days" : ($days == 0 ? "" : " $days day")) . ")</span>";
  } else if ($months > 0 && !$past && $neg) {
    $value = "<span class=\"red\">($months mo" . ($days > 1 ? " $days days" : ($days == 0 ? "" : " $days day")) . ")</span>";
  } else if ($totaldays > 0 && !$past && $neg) {
    $value = "<span class=\"red\">(" . ($totaldays > 1 ? "$totaldays days" : "$totaldays day") . ")</span>";
  } else if ($years > 0 && !$past) {
    $value = "$years yr" . ($months > 0 ? " $months mo" : "") . ($days > 1 ? " $days days" : ($days == 0 ? "" : " $days day"));
  } else if ($months > 0 && !$past) {
    $value = "$months mo" . ($days > 1 ? " $days days" : ($days == 0 ? "" : " $days day"));
	} else if ($totaldays > 0 && !$past) {
    $value = $totaldays . ($totaldays > 1 ? " days" : " day");
  } else if (!$past) {
    $value = "Today";
  }
  if ($totaldays >= 0 && $totaldays <= 7 && !$neg) {
		$value = "<span class=\"green\">$value</span>";
  }
  if (isset($value)) {
		return $value;
  }
}

function format_ledger($balance) {
  if ($balance > 0) {
    return "<span class=\"red\">($$balance)</span>";
  } else{ 
    return "<span class=\"green\">$$balance</span>";
  }
}

?>
