<?php
namespace Ds3\Libraries\Legacy;

require_once __DIR__ . '/admin/includes/main_include.php';

$filename = 'some-filename.pdf';
$html = <<<HTML
<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=Generator content="Microsoft Word 14 (filtered)">
<title>Medicare Proof of Delivery</title>
</head>

<body lang=EN-US link=blue vlink=purple>

<div>

<p><b><span
style='font-size:24.0pt;font-family:"Arial","sans-serif"'>Proof of Delivery
(POD) for </span></b></p>

<p><b><span
style='font-size:24.0pt;font-family:"Arial","sans-serif"'>Custom Oral Appliance</span></b></p>

<p><span
style='font-size:20.0pt;font-family:"Arial","sans-serif"'>(Receipt of DME
Goods)</span></p>

<p><b>&nbsp;</b></p>

<p><b><span
style='font-size:11.0pt;font-family:"Arial","sans-serif"'>&nbsp;</span></b></p>

<p><b><span>{{loc_r.name}}</span></b></p>

<p><b><span>{{loc_r.address}}</span></b></p>

<p><b><span>{{loc_r.city}}, {{loc_r.state}}, {{loc_r.zip}}</span></b></p>

<p><b><span>{{loc_r.phone}}</span></b></p>

<p>&nbsp;</p>

<p><span>&nbsp;</span></p>

<p><span>I certify that I have
received the item(s) marked below in good condition.  This equipment is
medically necessary and not substandard.  This device was fitted and sized and
the device fits well.  I have received verbal and written instructions for use
of the equipment, the warranty, complaint resolution information and the
Durable Medical Equipment Supplier Guidelines. </span></p>

<p><span>&nbsp;</span></p>

<p><span>&nbsp;</span></p>

<p><span>____ Custom Fabricated Oral
Appliance for Obstructive Sleep Apnea (E0486) – Qty 1</span></p>

<p><span
style='font-size:11.0pt;line-height:150%;font-family:"Arial","sans-serif"'>Brand
Name (Manufacturer): _______________________________________</span></p>

<p><span>&nbsp;</span></p>

<p><span>____ Other Item: __________________</span></p>

<p>&nbsp;</p>

<p><span>&nbsp;</span></p>

<p><span>_______________________________________________&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span></p>

<p><span>Patient
Name (Please
Print)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></p>

<p><span>&nbsp;</span></p>

<p><span>_______________________________________________&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
___________________________</span></p>

<p><span>Patient
Signature&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Date&nbsp;&nbsp;&nbsp; </span></p>

<p><span>&nbsp;</span></p>

<p><span>© 2013 Dental Sleep Solutions</span></p>

</div>

</body>

</html>
HTML;

// create_pdf($title, $filename, $html, $fax = null, $header, $footer, $cover = '', $docid = null, $letterid = null)
create_pdf('Some Title', $filename, $html, null, '', '', '', null, null);

?>
<script type="text/javascript">
    window.location = 'letterpdfs/<?= rawurlencode($filename) ?>';
</script>
