<?php

require_once './pdfGenerator.php';
require_once './pdfWrapper.php';
require_once './tcpdf_ext.php';
$debug = false;
$error_handler = set_error_handler("PDFErrorHandler");

if (get_magic_quotes_gpc()) {
	$xmlString = stripslashes($_POST['mycoolxmlbody']);
} else {
	$xmlString = $_POST['mycoolxmlbody'];
}

if ($debug == true) {
	error_log($xmlString, 3, 'debug_'.date("Y_m_d__H_i_s").'.xml');
}

$xmlString = urldecode($xmlString);
$xml = new SimpleXMLElement($xmlString, LIBXML_NOCDATA);

$mode = $xml->xpath('//scale/@mode');
$mode = substr(substr(trim($mode[0]->asXML()), 6), 0, -1);
if($mode == 'month' || $mode == 'timeline')
{
}
else
{
list($val) = $xml->xpath('//scale/y');
unset($val[0]);
$xml->scale->addChild('y', '');
$xml->scale->y->addChild('row', '12AM');
$xml->scale->y->addChild('row', '1:00');
$xml->scale->y->addChild('row', '2:00');
$xml->scale->y->addChild('row', '3:00');
$xml->scale->y->addChild('row', '4:00');
$xml->scale->y->addChild('row', '5:00');
$xml->scale->y->addChild('row', '6:00');
$xml->scale->y->addChild('row', '7:00');
$xml->scale->y->addChild('row', '8:00');
$xml->scale->y->addChild('row', '9:00');
$xml->scale->y->addChild('row', '10:00');
$xml->scale->y->addChild('row', '11:00');
$xml->scale->y->addChild('row', '12PM');
$xml->scale->y->addChild('row', '1:00');
$xml->scale->y->addChild('row', '2:00');
$xml->scale->y->addChild('row', '3:00');
$xml->scale->y->addChild('row', '4:00');
$xml->scale->y->addChild('row', '5:00');
$xml->scale->y->addChild('row', '6:00');
$xml->scale->y->addChild('row', '7:00');
$xml->scale->y->addChild('row', '8:00');
$xml->scale->y->addChild('row', '9:00');
$xml->scale->y->addChild('row', '10:00');
$xml->scale->y->addChild('row', '11:00');
}

/*
print_r('<pre>');
print_r($xml);
print_r('</pre>');
*/

$scPDF = new schedulerPDF();
$scPDF->printScheduler($xml);
function PDFErrorHandler ($errno, $errstr, $errfile, $errline) {
	global $xmlString;
	if ($errno < 1024) {
		echo $errstr."<br>";
		error_log($xmlString, 3, 'error_report_'.date("Y_m_d__H_i_s").'.xml');
		trigger_error("Exit called with status 1", E_USER_ERROR);
	}
}

?>
