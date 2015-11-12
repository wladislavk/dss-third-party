<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/questionnaire_sections.php';

	if (!empty($_SESSION['pid'])) {
		$pid = $_SESSION['pid'];
	} else {
		$pid = '';
	}

$comp = questionnaireCompletedSections($pid);

$q1 = $comp['symptoms'];
$qs = $comp['epworth'];
$q2 = $comp['treatments'];
$q3 = $comp['history'];
$qp = $comp['registered'];

	$tot_sect = 5;
	$comp_sect = $qp + $q1 + $qs + $q2 + $q3;
	$comp_perc = round(($comp_sect / $tot_sect) * 100);

	$questionnaire_completed = ($q1 == 1 && $qs == 1 && $q2 == 1 && $q3 == 1);
?>
