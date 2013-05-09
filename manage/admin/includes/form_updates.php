<?php


function update_financial_agreement_medicare_form($id){

$logo = get_logo($id);

$s = "SELECT amount from dental_transaction_code WHERE transaction_code='E0486' AND docid='".mysql_real_escape_string($id)."'";
$q = mysql_query($s);
$r = mysql_fetch_assoc($q);

$html = '
<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=Generator content="Microsoft Word 14 (filtered)">
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
@font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";}
span.HeaderChar
	{mso-style-name:"Header Char";}
span.FooterChar
	{mso-style-name:"Footer Char";}
.MsoChpDefault
	{font-size:10.0pt;}
.MsoPapDefault
	{text-autospace:ideograph-other;}
 /* Page Definitions */
 @page WordSection1
	{size:8.5in 11.0in;
	margin:.4in .6in .3in .6in;}
div.WordSection1
	{page:WordSection1;}
-->
</style>

</head>

<body lang=EN-US>

<div class=WordSection1>
<table><tr><td width="30%">'.$logo.'</td>
<td width="70%">
<h2 class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-size:24.0pt;font-family:"Arial","sans-serif"\'>DENTAL SLEEP THERAPY</span></b></h2>

<h2 class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-size:24.0pt;font-family:"Arial","sans-serif"\'>MEDICARE FINANCIAL
AGREEMENT</span></b></h2>
</td></tr></table>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>This office
charges a customary fee for Dental Sleep Therapy (DST) of $'.$r['amount'].'.  We are a non-participating
Medicare provider and it is possible that our office is out of network for your
secondary insurance.  Due to our provider status all insurance reimbursements
(Medicare and secondary) will be sent directly to you.   </span></p>


<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>It is our
normal policy to collect the full cost of DST by the delivery of your
appliance.  Due to your financial hardship we have agreed to accept $_________
as an initial payment and that your maximum out of pocket expense will not
exceed this initial payment.  Due to the fact that your secondary insurance payments
go directly to you we request that you forward us your Explanation of Benefits
(EOB) from your secondary insurance once your check(s) are received.  Any
amounts paid to you above your initial payment of $_________ will be required
to be paid to this office.  In the event that you do not forward your secondary
insurance EOB to us you will be billed for the balance of the of the DST
customary fee.</span></p>


<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>By signing
this agreement you agree to pay for services rendered at our office and
understand that you are individually responsible for payment of all fees that
were previously discussed.</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>&nbsp;</span></p>


<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>___________________________________________
          ________________________</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>Signature                                                                                          Date</span></p>


<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>___________________________________________
          ________________________</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>Witness                                                                                              Date    </span></p>

<p class=MsoNormal><span style=\'font-size:8.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p style="width:100%; text-align:right;">
<span style=\'font-size:6.0pt;font-family:"Arial","sans-serif"\'><small>© 2013 Dental Sleep
Solutions</small></span></p>

</div>

</body>

</html>
';

        $title = "Financial Agreement Medicare";
        $filename = "financial_agreement_medicare_".$id.".pdf";

        create_form_pdf($html, $filename, $title);

}

function update_home_care_instructions_form($id){


$logo = get_logo($id);

$s = "SELECT * from dental_users WHERE userid='".mysql_real_escape_string($id)."'";
$q = mysql_query($s);
$r = mysql_fetch_assoc($q);

$html = '
<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=Generator content="Microsoft Word 14 (filtered)">
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
@font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";}
span.HeaderChar
	{mso-style-name:"Header Char";}
span.FooterChar
	{mso-style-name:"Footer Char";}
.MsoChpDefault
	{font-size:10.0pt;}
.MsoPapDefault
	{text-autospace:ideograph-other;}
 /* Page Definitions */
 @page WordSection1
	{size:8.5in 11.0in;
	margin:.4in .6in .3in .6in;}
div.WordSection1
	{page:WordSection1;}
 /* List Definitions */
 ol
	{margin-bottom:0in;}
ul
	{margin-bottom:0in;}
-->
</style>

</head>

<body lang=EN-US>


<div class=WordSection1>
<table><tr><td width="30%">'.$logo.'</td>
<td width="70%">

<h2 class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-size:24.0pt;font-family:"Arial","sans-serif"\'>DENTAL SLEEP THERAPY
(DST)</span></b></h2>

<h2 class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-size:24.0pt;font-family:"Arial","sans-serif"\'>HOME CARE
INSTRUCTIONS</span></b></h2>
</td></tr></table>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>As with
anything that produces predictable results, it is important to follow the
instructions for wearing your device as stated below. </span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>During dental
device therapy, you may become aware of changes either in your bite or in the
muscles of the face, head, or neck. Be aware of these changes and write them
down as they occur and report them (good or bad). These reports help us to identify
any problems with the device and document the progress you are making. </span></p>

<p class=MsoNormal style=\'margin-left:.5in\'><b><span style=\'font-family:"Arial","sans-serif"\'>Maintenance
of your Dental Device:</span></b></p>

<p class=MsoNormal style=\'margin-left:.75in;text-indent:-.25in\'><span
style=\'font-family:"Arial","sans-serif"\'>1.<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;
</span></span><span style=\'font-family:"Arial","sans-serif"\'>The device should
be brushed with a toothbrush and rinsed with water when removed. Dry the device
completely before storing in the container. </span></p>

<p class=MsoNormal style=\'margin-left:.75in;text-indent:-.25in\'><span
style=\'font-family:"Arial","sans-serif"\'>2.<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;
</span></span><span style=\'font-family:"Arial","sans-serif"\'>Every 4-6 weeks,
disinfect the device in a mix of equal parts of water and hydrogen peroxide for
30-60 minutes. Alternately, you may purchase an over-the-counter “denture” or
“retainer” cleaner (such as Efferdent, Retainer Brite, or Ortho Fresh) and follow
the directions on the package. The device should not be soaked in any other
solutions, as it may warp.</span></p>

<p class=MsoNormal style=\'margin-left:.75in;text-indent:-.25in\'><span
style=\'font-family:"Arial","sans-serif"\'>3.<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;
</span></span><span style=\'font-family:"Arial","sans-serif"\'>A high heat source
or the sun may cause damage to your device. KEEP your device away from HEAT.</span></p>

<p class=MsoNormal style=\'margin-left:.75in;text-indent:-.25in\'>4.<span
style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </span><span
style=\'font-family:"Arial","sans-serif"\'>A case is being provided to you for
storage of the device. When not using the device it should remain in the
storage container to avoid loss or being damaged by a pet<b>. </b></span></p>

<p class=MsoNormal style=\'margin-left:.75in;text-indent:-.25in\'><span
style=\'font-family:"Arial","sans-serif"\'>5.<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;&nbsp;&nbsp;
</span></span><span style=\'font-family:"Arial","sans-serif"\'>You should always
floss and brush your teeth before inserting the device. </span></p>

<p class=MsoNormal><b><i><span style=\'font-family:"Arial","sans-serif"\'>If you
have any questions regarding your treatment please contact our office at <span
style=\'background:yellow\'>'.format_phone($r['mailing_phone']).'</span>.</span></i></b></p>

<p class=MsoNormal align=right style=\'text-align:right\'><span style=\'font-size:
8.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal align=right style=\'text-align:right\'><span style=\'font-size:
8.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal align=right style=\'text-align:right\'><span style=\'font-size:
8.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p style="width:100%; text-align:right;">
<span style=\'font-size:6.0pt;font-family:"Arial","sans-serif"\'><small>© 2013 Dental Sleep
Solutions</small></span></p>
</div>

</body>

</html>

';

        $title = "Home Care Instructions";
        $filename = "home_care_instructions_".$id.".pdf";

        create_form_pdf($html, $filename, $title);

}

function update_non_dentist_of_record_release_form($id){


$logo = get_logo($id);

$s = "SELECT * from dental_users WHERE userid='".mysql_real_escape_string($id)."'";
$q = mysql_query($s);
$r = mysql_fetch_assoc($q);

$html = '
<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=Generator content="Microsoft Word 14 (filtered)">
<title>Medical and Dental History</title>
<style>
<!--
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:10.0pt;
	font-family:"Times New Roman","serif";}
h1
	{margin-top:0in;
	margin-right:-.5in;
	margin-bottom:0in;
	margin-left:-.5in;
	margin-bottom:.0001pt;
	page-break-after:avoid;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
h2
	{margin-top:0in;
	margin-right:-.5in;
	margin-bottom:0in;
	margin-left:-.5in;
	margin-bottom:.0001pt;
	page-break-after:avoid;
	text-autospace:ideograph-other;
	font-size:10.0pt;
	font-family:"Times New Roman","serif";}
h3
	{margin-top:0in;
	margin-right:-.5in;
	margin-bottom:0in;
	margin-left:-13.5pt;
	margin-bottom:.0001pt;
	text-indent:-22.5pt;
	page-break-after:avoid;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:10.0pt;
	font-family:"Times New Roman","serif";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:10.0pt;
	font-family:"Times New Roman","serif";}
p.MsoTitle, li.MsoTitle, div.MsoTitle
	{margin-top:0in;
	margin-right:-.5in;
	margin-bottom:0in;
	margin-left:-.5in;
	margin-bottom:.0001pt;
	text-align:center;
	text-autospace:ideograph-other;
	font-size:16.0pt;
	font-family:"Times New Roman","serif";
	font-weight:bold;}
p.MsoBodyText, li.MsoBodyText, div.MsoBodyText
	{margin:0in;
	margin-bottom:.0001pt;
	punctuation-wrap:simple;
	text-autospace:none;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoBlockText, li.MsoBlockText, div.MsoBlockText
	{margin-top:0in;
	margin-right:-.25in;
	margin-bottom:0in;
	margin-left:-9.0pt;
	margin-bottom:.0001pt;
	line-height:150%;
	text-autospace:ideograph-other;
	font-size:10.0pt;
	font-family:"Times New Roman","serif";}
a:link, span.MsoHyperlink
	{color:blue;
	text-decoration:underline;}
a:visited, span.MsoHyperlinkFollowed
	{color:purple;
	text-decoration:underline;}
span.FooterChar
	{mso-style-name:"Footer Char";}
.MsoChpDefault
	{font-size:10.0pt;}
.MsoPapDefault
	{text-autospace:ideograph-other;}
 /* Page Definitions */
 @page WordSection1
	{size:8.5in 11.0in;
	margin:.4in .6in .4in .6in;}
div.WordSection1
	{page:WordSection1;}
-->
</style>

</head>

<body lang=EN-US link=blue vlink=purple>


<div class=WordSection1>
<table><tr><td width="30%">'.$logo.'</td>
<td width="70%">

<h2 class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-size:24.0pt;font-family:"Arial","sans-serif"\'>NON DENTIST-OF-RECORD</span></b></h2>

<h2 class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-size:24.0pt;font-family:"Arial","sans-serif"\'>RELEASE FORM</span></b></h2>
</td></tr></table>
<p class=MsoNormal align=center style=\'text-align:center\'><b>
'.$r['mailing_practice'].'
</b></p>

<p class=MsoNormal style=\'line-height:150%\'><span style=\'font-size:11.0pt;
line-height:150%;font-family:"Arial","sans-serif"\'>I am seeking treatment with
a sleep orthotic appliance only.  I understand that I am not a dental
patient-of-record with <b>'.$r['mailing_name'].'</b>.
</span></p>

<p class=MsoNormal style=\'line-height:150%\'><span style=\'font-size:11.0pt;
line-height:150%;font-family:"Arial","sans-serif"\'>The importance of regular
dental care has been explained to me and I understand that <b>'.$r['mailing_name'].'</b> will not be responsible
for providing my preventative or emergency dental needs. At this time, I choose
to have my routine and necessary dental care completed in another office.  </span></p>


<p class=MsoNormal><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>_______________________________________________  
           </span></p>

<p class=MsoNormal><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>Patient
Name (Please Print)                                                               </span></p>

<p class=MsoNormal><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>_______________________________________________              ___________________________</span></p>

<p class=MsoNormal><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>Patient
Signature                                                                                Date    </span></p>

<p class=MsoNormal><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-size:8.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-size:8.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-size:8.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-size:8.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-size:8.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-size:8.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p style="width:100%; text-align:right;">
<span style=\'font-size:6.0pt;font-family:"Arial","sans-serif"\'><small>© 2013 Dental Sleep
Solutions</small></span></p>
</div>

</body>

</html>

';

        $title = "Non-dentist of Record Release";
        $filename = "non_dentist_of_record_release_".$id.".pdf";

        create_form_pdf($html, $filename, $title);

}

function update_sleep_recorder_release_form($id){

$logo = get_logo($id);

$s = "SELECT * from dental_users WHERE userid='".mysql_real_escape_string($id)."'";
$q = mysql_query($s);
$r = mysql_fetch_assoc($q);

$html = '
<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=Generator content="Microsoft Word 14 (filtered)">
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";}
span.HeaderChar
	{mso-style-name:"Header Char";}
span.FooterChar
	{mso-style-name:"Footer Char";}
.MsoChpDefault
	{font-size:10.0pt;}
.MsoPapDefault
	{text-autospace:ideograph-other;}
 /* Page Definitions */
 @page WordSection1
	{size:8.5in 11.0in;
	margin:.4in .6in .4in .6in;}
div.WordSection1
	{page:WordSection1;}
-->
</style>

</head>

<body lang=EN-US>



<div class=WordSection1>
<table><tr><td width="30%">'.$logo.'</td>
<td width="70%">

<h2 class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-size:24.0pt;font-family:"Arial","sans-serif"\'>SLEEP RECORDER
RELEASE FORM</span></b></h2>
</td></tr></table>
<p class=MsoNormal style=\'line-height:150%\'><span style=\'font-size:11.0pt;
line-height:150%;font-family:"Arial","sans-serif"\'>I,
____________________________, have been advised by '.$r['mailing_name'].'<i><span style=\'color:red\'> </span></i>to take
home a sleep recorder that will determine my treatment progress after using my
dental device. I understand that I am assuming responsibility for the safe
return of the sleep recorder, valued at $_________.  I agree to give '.$r['mailing_name'].'<i><span style=\'color:red\'> </span></i>a
credit card number to be charged <b><i>only if the sleep recorder is not
returned or is returned damaged due to neglect or physical abuse.  </i></b>I
agree to return the sleep recorder on the date noted below.  I understand that
Dental Sleep Solutions’ normal business hours may change, and I will call the
office prior to returning the unit to arrange a delivery time. </span></p>


<p class=MsoNormal style=\'margin-left:.5in;line-height:200%\'><span
style=\'font-size:11.0pt;line-height:200%;font-family:"Arial","sans-serif"\'>Patient
Name: ________________________________________________________ </span></p>

<p class=MsoNormal style=\'margin-left:.5in;line-height:200%\'><span
style=\'font-size:11.0pt;line-height:200%;font-family:"Arial","sans-serif"\'>Patient
Signature: ______________________________________Date:__________</span></p>

<p class=MsoNormal style=\'margin-left:.5in;line-height:200%\'><span
style=\'font-size:11.0pt;line-height:200%;font-family:"Arial","sans-serif"\'>Witness
Name:  ______________________________________________________</span></p>

<p class=MsoNormal style=\'margin-left:.5in;line-height:200%\'><span
style=\'font-size:11.0pt;line-height:200%;font-family:"Arial","sans-serif"\'>Witness
Signature: _____________________________________Date:__________</span></p>

<p class=MsoNormal style=\'margin-left:.5in;line-height:200%\'><span
style=\'font-size:11.0pt;line-height:200%;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal style=\'margin-left:.5in;line-height:200%\'><span
style=\'font-size:11.0pt;line-height:200%;font-family:"Arial","sans-serif"\'>CREDIT
CARD TYPE: _________________________________________________</span></p>

<p class=MsoNormal style=\'margin-left:.5in;line-height:200%\'><span
style=\'font-size:11.0pt;line-height:200%;font-family:"Arial","sans-serif"\'>CREDIT
CARD NUMBER: _______________________________________________</span></p>

<p class=MsoNormal style=\'margin-left:.5in;line-height:200%\'><span
style=\'font-size:11.0pt;line-height:200%;font-family:"Arial","sans-serif"\'>EXP
DATE: ___________________SECURITY CODE: ________________________</span></p>

<p class=MsoNormal style=\'margin-left:.5in;line-height:150%\'><span
style=\'font-size:11.0pt;line-height:150%;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal style=\'margin-left:.5in;line-height:150%\'><span
style=\'font-size:11.0pt;line-height:150%;font-family:"Arial","sans-serif"\'>Expected
Return Date: ______________________________</span></p>


<p class=MsoNormal style=\'margin-left:.5in\'><span style=\'font-size:11.0pt;
font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-size:8.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p style="width:100%; text-align:right;">
<span style=\'font-size:6.0pt;font-family:"Arial","sans-serif"\'><small>© 2013 Dental Sleep
Solutions</small></span></p>

</div>

</body>

</html>

';

        $title = "Sleep Recorder Release";
        $filename = "sleep_recorder_release_".$id.".pdf";

        create_form_pdf($html, $filename, $title);

}


function update_custom_release_form($id){

$s = "SELECT * from dental_users WHERE userid='".mysql_real_escape_string($id)."'";
$q = mysql_query($s);
$r = mysql_fetch_assoc($q);

$logo = get_logo($id);


$html = '
<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=windows-1252">
<meta name=Generator content="Microsoft Word 14 (filtered)">
<style>
<!--
 /* Font Definitions */
 @font-face
        {font-family:Wingdings;
        panose-1:5 0 0 0 0 0 0 0 0 0;}
@font-face
        {font-family:Wingdings;
        panose-1:5 0 0 0 0 0 0 0 0 0;}
@font-face
        {font-family:Calibri;
        panose-1:2 15 5 2 2 2 4 3 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
        {margin-top:0in;
        margin-right:0in;
        margin-bottom:10.0pt;
        margin-left:0in;
        line-height:115%;
        font-size:11.0pt;
        font-family:"Calibri","sans-serif";}
.MsoChpDefault
        {font-family:"Calibri","sans-serif";}
.MsoPapDefault
        {margin-bottom:10.0pt;
        line-height:115%;}
@page WordSection1
        {size:8.5in 11.0in;
        margin:.5in .5in .5in .5in;
        border:solid windowtext 1.0pt;
        padding:24.0pt 24.0pt 24.0pt 24.0pt;}
div.WordSection1
        {page:WordSection1;}
 /* List Definitions */
 ol
        {margin-bottom:0in;}
ul
        {margin-bottom:0in;}
-->
</style>

</head>

<body lang=EN-US>

<div class=WordSection1>
<table><tr><td width="30%">'.$logo.'</td>
<td width="70%">

<h2 class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-size:24.0pt;font-family:"Arial","sans-serif"\'>PATIENT MEDICAL RECORD RELEASE FORM</span></b></h2>
</td></tr></table>

<p class=MsoNormal style="margin-top:4.0pt;line-height:normal"><span
style="font-size:12.0pt">This office coordinates
treatment with your healthcare providers to help ensure maximum benefit to
you.  Please sign the record release form below so we can retrieve medical
records related to sleep disordered breathing.</span></p>

<p class=MsoNormal style="line-height:normal"><b><span style="font-size:12.0pt">To</span></b><span
style="font-size:12.0pt">: __________________________________________________________________</span></p>

<p class=MsoNormal style="line-height:normal"><b><span style="font-size:12.0pt">From</span></b><span
style="font-size:12.0pt">: '.$r['mailing_name'].'</span></p>

<p class=MsoNormal style="line-height:normal"><span style="font-size:12.0pt">We
would like to request a copy of the following if applicable:</span></p>

<p class=MsoNormal style="line-height:normal"><span
style="font-size:12.0pt;font-family:Symbol">·<span style="font:7.0pt \"Times New Roman\"">
</span></span><span style="font-size:11.0pt">All baseline PSG\'s, oximetry
studies, and the patient\'s most recent CPAP titration study</span></p>

<p class=MsoNormal style="line-height:
normal"><span style="font-size:12.0pt;font-family:Symbol">·<span
style="font:7.0pt \"Times New Roman\"">
</span></span><span
style="font-size:11.0pt">Any pertinent notes about patient\'s past medical
history </span></p>

<p class=MsoNormal style="line-height:normal"><span style="font-size:12.0pt">Patient
Name: _________________________________________________________</span></p>

<p class=MsoNormal style="line-height:normal"><span style="font-size:12.0pt">Patient
DOB: ___________________________________________________________</span></p>

<p class=MsoNormal style="line-height:normal"><span style="font-size:12.0pt">We
wish to obtain them in this way:</span></p>

<p class=MsoNormal style="line-height:normal"><span style="font-size:12.0pt">&#9633; PICK UP FROM OFFICE</span></p>

<p class=MsoNormal style="line-height:normal"><span
style="font-size:12.0pt">&#9633; PLEASE MAIL TO US AT THE ADDRESS LISTED BELOW</span></p>

<p class=MsoNormal style="line-height:normal"><span style="font-size:12.0pt">&#9633; PLEASE FAX TO THE PHONE NUMBER LISTED BELOW</span></p>

<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal"><span style="font-size:12.0pt">ADDRESS:</span></p>
<table class=MsoTableGrid border=0 cellspacing=0 cellpadding=0
 style="border-collapse:collapse;border:none; margin-bottom:0; margin-top:0;">
 <tr style="">
  <td width=515 valign=top style="width:339.25pt;padding:0in 5.4pt 0in 5.4pt;"><span style="font-size:12.0pt">'.$r['mailing_address'].'<br />
'.$r['mailing_city'].' '.$r['mailing_state'].' '.$r['mailing_zip'].'</span></td>
 </tr>
</table>
<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;margin-top:0;line-height:
normal"></p>

<p class=MsoNormal style="line-height:normal"><b><span style="font-size:12.0pt">FAX</span></b><span
style="font-size:12.0pt">: <b>'.$r['fax'].'</b></span></p>

<p class=MsoNormal style="line-height:normal"><i><span style="font-size:12.0pt">I
request and authorize the above named doctor or health care provider, or individual
named in this request to obtain my medical records. A copy of this
authorization or my signature thereon may be used with the same effectiveness
as an original.</span></i></p>

<p class=MsoNormal style="line-height:normal"><b><span style="font-size:12.0pt">Patient
Signature</span></b><span style="font-size:12.0pt">: ________________________________
<b>Date</b>: ___________</span></p>

<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal"><span style="font-size:12.0pt">Additional Comments:</span></p>

<p class=MsoNormal style="line-height:normal"><span style="font-size:12.0pt">____________________________________________________________________________________
____________________________________________________________________________________
____________________________________________________________________________________
</span></p>

<p class=MsoNormal style="line-height:normal"><span style="font-size:12.0pt">Thank
you in advance.</span></p></div></body></html>';



        $title = "DSS Record Release";
        $filename = "user_record_release_".$id.".pdf";

	create_form_pdf($html, $filename, $title);

}



function update_affidavit_for_cpap_intolerance_form($id){

$logo = get_logo($id);


$html = '
<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=Generator content="Microsoft Word 14 (filtered)">
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoDocumentMap, li.MsoDocumentMap, div.MsoDocumentMap
	{margin:0in;
	margin-bottom:.0001pt;
	background:navy;
	text-autospace:ideograph-other;
	font-size:10.0pt;
	font-family:"Tahoma","sans-serif";}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";}
span.HeaderChar
	{mso-style-name:"Header Char";}
span.FooterChar
	{mso-style-name:"Footer Char";}
.MsoChpDefault
	{font-size:10.0pt;}
.MsoPapDefault
	{text-autospace:ideograph-other;}
 /* Page Definitions */
 @page WordSection1
	{size:8.5in 11.0in;
	margin:.4in .6in .3in .6in;}
div.WordSection1
	{page:WordSection1;}
-->
</style>

</head>

<body lang=EN-US>

<div class=WordSection1>
<table><tr><td width="30%">'.$logo.'</td>
<td width="70%">
<h2 class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-size:24.0pt;font-family:"Arial","sans-serif"\'>AFFIDAVIT FOR
INTOLERANCE TO CPAP</span></b></h2>
</td></tr></table>
<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>I have
attempted to use the nasal CPAP to manage my sleep related breathing disorder
(apnea) and find it intolerable to use on a regular basis for the following
reasons:</span></p>


<p class=MsoNormal style=\'margin-left:.5in\'><span style=\'font-family:"Arial","sans-serif"\'>___Mask
leaks</span></p>


<p class=MsoNormal style=\'margin-left:.5in\'><span style=\'font-family:"Arial","sans-serif"\'>___An
inability to get the mask to fit properly</span></p>


<p class=MsoNormal style=\'margin-left:.5in\'><span style=\'font-family:"Arial","sans-serif"\'>___Discomfort
or interrupted sleep caused by the presence of the device</span></p>


<p class=MsoNormal style=\'margin-left:.5in\'><span style=\'font-family:"Arial","sans-serif"\'>___Noise
from the device disturbing sleep or bed partner’s sleep</span></p>


<p class=MsoNormal style=\'margin-left:.5in\'><span style=\'font-family:"Arial","sans-serif"\'>___CPAP
restricted movements during sleep</span></p>


<p class=MsoNormal style=\'margin-left:.5in\'><span style=\'font-family:"Arial","sans-serif"\'>___CPAP
does not seem to be effective</span></p>


<p class=MsoNormal style=\'margin-left:.5in\'><span style=\'font-family:"Arial","sans-serif"\'>___Pressure
on the upper lip causes tooth related problems</span></p>


<p class=MsoNormal style=\'margin-left:.5in\'><span style=\'font-family:"Arial","sans-serif"\'>___Latex
allergy</span></p>


<p class=MsoNormal style=\'margin-left:.5in\'><span style=\'font-family:"Arial","sans-serif"\'>___Claustrophobic
associations</span></p>


<p class=MsoNormal style=\'margin-left:.5in\'><span style=\'font-family:"Arial","sans-serif"\'>___An
unconscious need to remove the CPAP apparatus at night</span></p>


<p class=MsoNormal style=\'margin-left:.5in\'><span style=\'font-family:"Arial","sans-serif"\'>Other___________________________________________________</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>Because of my
intolerance/inability to use the CPAP, I wish to have an alternative method of
treatment. That form of therapy is oral appliance therapy (OAT).</span></p>


<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>Print Name:
________________________________________________</span></p>


<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>Signature:
____________________________________________ Date: ____________________</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>&nbsp;</span></p>


<p style="width:100%; text-align:right;">
<span style=\'font-size:6.0pt;font-family:"Arial","sans-serif"\'><small>© 2013 Dental Sleep
Solutions</small></span></p>

</div>

</body>

</html>

';

        $title = "Affidavit for CPAP Intolerance";
        $filename = "affidavit_for_cpap_intolerance_".$id.".pdf";

        create_form_pdf($html, $filename, $title);

}


function update_device_titration_ema_form($id){

$logo = get_logo($id);
        
$html = '
<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=Generator content="Microsoft Word 14 (filtered)">
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
@font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:0in;
	line-height:115%;
	text-autospace:ideograph-other;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:0in;
	line-height:115%;
	text-autospace:ideograph-other;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:0in;
	line-height:115%;
	text-autospace:ideograph-other;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{mso-style-link:"Balloon Text Char";
	margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";}
span.HeaderChar
	{mso-style-name:"Header Char";}
span.FooterChar
	{mso-style-name:"Footer Char";}
span.BalloonTextChar
	{mso-style-name:"Balloon Text Char";
	mso-style-link:"Balloon Text";
	font-family:"Tahoma","sans-serif";}
.MsoChpDefault
	{font-size:10.0pt;
	font-family:"Calibri","sans-serif";}
.MsoPapDefault
	{text-autospace:ideograph-other;}
 /* Page Definitions */
 @page WordSection1
	{size:8.5in 11.0in;
	margin:.4in .6in .2in .6in;}
div.WordSection1
	{page:WordSection1;}
-->
</style>

</head>

<body lang=EN-US>


<div class=WordSection1>
<table><tr><td width="30%">'.$logo.'</td>
<td width="70%">
<h2 class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-size:24.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>DEVICE
TITRATION FORM (EMA)</span></b></h2>
</td></tr></table>
<p class=MsoNormal align=center style=\'margin-bottom:0in;margin-bottom:.0001pt;
text-align:center\'><b><span style=\'font-size:12.0pt;line-height:115%;
font-family:"Arial","sans-serif"\'>Mandibular Advancement Device (MAD) Record</span></b></p>

<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt\'><span
style=\'font-size:12.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>Patient
Name: _______________________________________________________</span></p>

<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt\'><span
style=\'font-size:12.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>Type
of device: ______________________________________________________</span></p>

<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt\'><span
style=\'font-size:12.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>Max
Translation: ____________________ Starting Translation_________________</span></p>

<table class="MsoNormalTable" border="1" cellspacing="0" cellpadding="0" width="615"> 
 <tr>
  <td width="145" valign=bottom style=\'border:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt\'>
  <p class=MsoNormal align=center style=\'margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center\'><b><span style=\'text-align:center;font-size:12.0pt;line-height:115%;
  font-family:"Arial","sans-serif"\'>DATE </span></b></p>
  </td>
  <td width="168" colspan="2" valign=bottom style=\'border:solid black 1.0pt;
  border-left:none;padding:0in 5.4pt 0in 5.4pt\'>
  <p class=MsoNormal align=center style=\'margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center\'><b><span style=\'font-size:12.0pt;line-height:115%;
  font-family:"Arial","sans-serif"\'>BAND</span></b></p>
  <p class=MsoNormal align=center style=\'margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center\'><b><span style=\'font-size:12.0pt;line-height:115%;
  font-family:"Arial","sans-serif"\'>Proposed                  Actual</span></b></p>
  </td>
  <td width="302" valign=bottom style=\'width:301.5pt;border:solid black 1.0pt;
  border-left:none;padding:0in 5.4pt 0in 5.4pt\'>
  <p class=MsoNormal align=center style=\'margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center\'><b><span style=\'font-size:12.0pt;line-height:115%;
  font-family:"Arial","sans-serif"\'>COMMENTS</span></b></p>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
<tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
</table>

<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt\'><span
style=\'font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal\'><b><span style=\'font-size:12.0pt;font-family:"Arial","sans-serif"\'>Patient
Instructions:</span></b></p>

<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal\'><span style=\'font-size:12.0pt;font-family:"Arial","sans-serif"\'>Advance
device as directed, changing bands as outlined above, until snoring and other
signs of obstructive sleep apnea are diminished.  If muscle, TMJ, or tooth
discomfort occurs, reverse the last adjustment and wait until you have three
days with no pain before continuing advancement.  If you experience any
prolonged discomfort or have any questions about how to advance your device
please contact our office immediately. </span></p>

<p class=MsoNormal align=center style=\'margin-bottom:0in;margin-bottom:.0001pt;
text-align:center;line-height:normal\'><b><span style=\'font-size:12.0pt;
font-family:"Arial","sans-serif"\'>Do Not Exceed the adjustment schedule!!!</span></b></p>

<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt\'><span
style=\'font-size:8.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>For
Office use only</span></p>

<p class=MsoNormal align=right style=\'margin-bottom:0in;margin-bottom:.0001pt;
text-align:right\'>
<table><tr><td>
<span style=\'font-size:8.0pt;line-height:115%;font-family:
"Arial","sans-serif"\'>
<img width=243 height=176 id="Picture 1"
src="/manage/images/device_titration_files/image001.jpg" alt=ema1></span><span
style=\'font-family:"Times New Roman","serif";color:black;background:black\'> </span>
</td><td>
<span
style=\'font-size:8.0pt;line-height:115%;font-family:"Arial","sans-serif"\'><img
width=223 height=182 id="Picture 2"
src="/manage/images/device_titration_files/image002.jpg" alt=ema2></span>
</td></tr></table>
</p>
<p style="width:100%; text-align:right;">
<span style=\'font-size:6.0pt;font-family:"Arial","sans-serif"\'><small>© 2013 Dental Sleep
Solutions</small></span></p>

</body>
</html>

';

        $title = "Device Titration (EMA)";
        $filename = "device_titration_ema_".$id.".pdf";

        create_form_pdf($html, $filename, $title);

}



function update_device_titration_form($id){


$logo = get_logo($id);

        
$html = '
<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=Generator content="Microsoft Word 14 (filtered)">
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:0in;
	line-height:115%;
	text-autospace:ideograph-other;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:0in;
	line-height:115%;
	text-autospace:ideograph-other;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:10.0pt;
	margin-left:0in;
	line-height:115%;
	text-autospace:ideograph-other;
	font-size:11.0pt;
	font-family:"Calibri","sans-serif";}
span.HeaderChar
	{mso-style-name:"Header Char";}
span.FooterChar
	{mso-style-name:"Footer Char";}
.MsoChpDefault
	{font-size:10.0pt;
	font-family:"Calibri","sans-serif";}
.MsoPapDefault
	{text-autospace:ideograph-other;}
 /* Page Definitions */
 @page WordSection1
	{size:8.5in 11.0in;
	margin:.4in .6in .4in .6in;}
div.WordSection1
	{page:WordSection1;}
-->
</style>

</head>

<body lang=EN-US>

<div class=WordSection1>
<table><tr><td width="30%">'.$logo.'</td>
<td width="70%">
<h2 class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-size:24.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>DEVICE
TITRATION FORM</span></b></h2>
</td></tr></table>
<p class=MsoNormal align=center style=\'margin-bottom:0in;margin-bottom:.0001pt;
text-align:center\'><b><span style=\'font-size:12.0pt;line-height:115%;
font-family:"Arial","sans-serif"\'>Mandibular Advancement Device (MAD) Record</span></b></p>

<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt\'><span
style=\'font-size:12.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>Patient
Name: _______________________________________________________</span></p>

<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt\'><span
style=\'font-size:12.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>Type
of device: ______________________________________________________</span></p>

<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt\'><span
style=\'font-size:12.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>Max
Translation: ____________________ Starting Translation_________________</span></p>

<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt\'><span
style=\'font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<table class="MsoNormalTable" border="1" cellspacing="0" cellpadding="0" width="615"> 
 <tr>
  <td width="145" valign=bottom style=\'border:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt\'>
  <p class=MsoNormal align=center style=\'margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center\'><b><span style=\'text-align:center;font-size:12.0pt;line-height:115%;
  font-family:"Arial","sans-serif"\'>DATE </span></b></p>
  </td>
  <td width="168" colspan="2" valign=bottom style=\'border:solid black 1.0pt;
  border-left:none;padding:0in 5.4pt 0in 5.4pt\'>
  <p class=MsoNormal align=center style=\'margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center\'><b><span style=\'font-size:12.0pt;line-height:115%;
  font-family:"Arial","sans-serif"\'>BAND</span></b></p>
  <p class=MsoNormal align=center style=\'margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center\'><b><span style=\'font-size:12.0pt;line-height:115%;
  font-family:"Arial","sans-serif"\'>Proposed                  Actual</span></b></p>
  </td>
  <td width="302" valign=bottom style=\'width:301.5pt;border:solid black 1.0pt;
  border-left:none;padding:0in 5.4pt 0in 5.4pt\'>
  <p class=MsoNormal align=center style=\'margin-bottom:0in;margin-bottom:.0001pt;
  text-align:center\'><b><span style=\'font-size:12.0pt;line-height:115%;
  font-family:"Arial","sans-serif"\'>COMMENTS</span></b></p>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
 <tr style=\'height:.2in\'>
  <td width="145" valign=top style=\'width:108.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="84" valign=top style=\'width:63.0pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt;
  height:.2in\'>
  </td>
  <td width="302" valign=top style=\'width:301.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt;height:.2in\'>
  </td>
 </tr>
</table>


<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal\'><b><span style=\'font-size:12.0pt;font-family:"Arial","sans-serif"\'>Patient
Instructions:</span></b></p>

<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt;line-height:
normal\'><span style=\'font-size:12.0pt;font-family:"Arial","sans-serif"\'>Advance
device as directed, ________ turn(s) every _____ days until snoring and other
signs of obstructive sleep apnea are diminished.  If muscle, TMJ, or tooth
discomfort occurs reverse the last adjustment and wait until you have three
days with no pain before continuing advancement.  If you experience any
prolonged discomfort or have any questions about how to advance your device
please contact our office immediately. </span></p>

<p class=MsoNormal align=center style=\'margin-bottom:0in;margin-bottom:.0001pt;
text-align:center\'><b><span style=\'font-size:12.0pt;line-height:115%;
font-family:"Arial","sans-serif"\'>Do Not Exceed _____________ Turns Per
Adjustment!!!</span></b></p>


<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt\'><span
style=\'font-size:10.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>For
Office Use Only </span></p>

<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt\'><span
style=\'font-size:10.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>TAP:
4 half turns = 1mm</span></p>

<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt\'><span
style=\'font-size:10.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>Dorsal
/ SomnoDent: 10 turns=1m</span></p>

<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt\'><span
style=\'font-size:10.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>SUAD:
Shims as marked (red = .5mm; black = 1mm)</span></p>

<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt\'><span
style=\'font-size:10.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>EMA:
# on band / color of band</span></p>

<p class=MsoNormal style=\'margin-bottom:0in;margin-bottom:.0001pt\'><span
style=\'font-size:10.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p style="width:100%; text-align:right;">
<span style=\'font-size:6.0pt;font-family:"Arial","sans-serif"\'><small>© 2013 Dental Sleep
Solutions</small></span></p></div>

</body>

</html>

';

        $title = "Device Titration";
        $filename = "device_titration_".$id.".pdf";

        create_form_pdf($html, $filename, $title);

}



function update_ess_tss_form($id){

$logo = get_logo($id);

        
$html = '
<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=Generator content="Microsoft Word 14 (filtered)">
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
@font-face
	{font-family:"Franklin Gothic Medium";
	panose-1:2 11 6 3 2 1 2 2 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Calibri","sans-serif";}
h1
	{margin-top:24.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	page-break-after:avoid;
	text-autospace:ideograph-other;
	font-size:14.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#365F91;}
h2
	{margin-top:10.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	page-break-after:avoid;
	text-autospace:ideograph-other;
	font-size:13.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#4F81BD;}
h3
	{margin-top:10.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	page-break-after:avoid;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#4F81BD;}
h4
	{margin-top:10.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	page-break-after:avoid;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#4F81BD;
	font-style:italic;}
h5
	{margin-top:10.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	page-break-after:avoid;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#243F60;
	font-weight:normal;}
h6
	{margin-top:10.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	page-break-after:avoid;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#243F60;
	font-weight:normal;
	font-style:italic;}
p.MsoHeading7, li.MsoHeading7, div.MsoHeading7
	{margin-top:10.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	page-break-after:avoid;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#404040;
	font-style:italic;}
p.MsoHeading8, li.MsoHeading8, div.MsoHeading8
	{margin-top:10.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	page-break-after:avoid;
	text-autospace:ideograph-other;
	font-size:10.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#4F81BD;}
p.MsoHeading9, li.MsoHeading9, div.MsoHeading9
	{margin-top:10.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	page-break-after:avoid;
	text-autospace:ideograph-other;
	font-size:10.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#404040;
	font-style:italic;}
p.MsoCaption, li.MsoCaption, div.MsoCaption
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:9.0pt;
	font-family:"Calibri","sans-serif";
	color:#4F81BD;
	font-weight:bold;}
p.MsoTitle, li.MsoTitle, div.MsoTitle
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:15.0pt;
	margin-left:0in;
	text-autospace:ideograph-other;
	border:none;
	padding:0in;
	font-size:26.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#17365D;
	letter-spacing:.25pt;}
p.MsoBodyText, li.MsoBodyText, div.MsoBodyText
	{margin:0in;
	margin-bottom:.0001pt;
	punctuation-wrap:simple;
	text-autospace:none;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoSubtitle, li.MsoSubtitle, div.MsoSubtitle
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#4F81BD;
	letter-spacing:.75pt;
	font-style:italic;}
p.MsoNoSpacing, li.MsoNoSpacing, div.MsoNoSpacing
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraph, li.MsoListParagraph, div.MsoListParagraph
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoQuote, li.MsoQuote, div.MsoQuote
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Calibri","sans-serif";
	color:black;
	font-style:italic;}
p.MsoIntenseQuote, li.MsoIntenseQuote, div.MsoIntenseQuote
	{margin-top:10.0pt;
	margin-right:.65in;
	margin-bottom:14.0pt;
	margin-left:.65in;
	text-autospace:ideograph-other;
	border:none;
	padding:0in;
	font-size:12.0pt;
	font-family:"Calibri","sans-serif";
	color:#4F81BD;
	font-weight:bold;
	font-style:italic;}
span.MsoSubtleEmphasis
	{color:gray;
	font-style:italic;}
span.MsoIntenseEmphasis
	{color:#4F81BD;
	font-weight:bold;
	font-style:italic;}
span.MsoSubtleReference
	{font-variant:small-caps;
	color:#C0504D;
	text-decoration:underline;}
span.MsoIntenseReference
	{font-variant:small-caps;
	color:#C0504D;
	letter-spacing:.25pt;
	font-weight:bold;
	text-decoration:underline;}
span.MsoBookTitle
	{font-variant:small-caps;
	letter-spacing:.25pt;
	font-weight:bold;}
p.MsoTocHeading, li.MsoTocHeading, div.MsoTocHeading
	{margin-top:24.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	page-break-after:avoid;
	text-autospace:ideograph-other;
	font-size:14.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#365F91;
	font-weight:bold;}
span.Heading1Char
	{mso-style-name:"Heading 1 Char";
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#365F91;
	font-weight:bold;}
span.Heading2Char
	{mso-style-name:"Heading 2 Char";
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#4F81BD;
	font-weight:bold;}
span.Heading3Char
	{mso-style-name:"Heading 3 Char";
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#4F81BD;
	font-weight:bold;}
span.Heading4Char
	{mso-style-name:"Heading 4 Char";
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#4F81BD;
	font-weight:bold;
	font-style:italic;}
span.Heading5Char
	{mso-style-name:"Heading 5 Char";
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#243F60;}
span.Heading6Char
	{mso-style-name:"Heading 6 Char";
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#243F60;
	font-style:italic;}
span.Heading7Char
	{mso-style-name:"Heading 7 Char";
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#404040;
	font-style:italic;}
span.Heading8Char
	{mso-style-name:"Heading 8 Char";
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#4F81BD;}
span.Heading9Char
	{mso-style-name:"Heading 9 Char";
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#404040;
	font-style:italic;}
span.TitleChar
	{mso-style-name:"Title Char";
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#17365D;
	letter-spacing:.25pt;}
span.SubtitleChar
	{mso-style-name:"Subtitle Char";
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#4F81BD;
	letter-spacing:.75pt;
	font-style:italic;}
span.QuoteChar
	{mso-style-name:"Quote Char";
	color:black;
	font-style:italic;}
span.IntenseQuoteChar
	{mso-style-name:"Intense Quote Char";
	color:#4F81BD;
	font-weight:bold;
	font-style:italic;}
span.BodyTextChar
	{mso-style-name:"Body Text Char";
	font-family:"Times New Roman","serif";}
.MsoChpDefault
	{font-size:10.0pt;
	font-family:"Calibri","sans-serif";}
.MsoPapDefault
	{text-autospace:ideograph-other;}
 /* Page Definitions */
 @page WordSection1
	{size:8.5in 11.0in;
	margin:.4in .6in .3in .6in;}
div.WordSection1
	{page:WordSection1;}
-->
</style>

</head>

<body lang=EN-US>

<div class=WordSection1>
<table><tr><td width="30%">'.$logo.'</td>
<td width="70%">
<h2 class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-size:24.0pt;font-family:"Arial","sans-serif"\'>SLEEP SCREENING
QUESTIONNAIRE</span></b></h2>
</td></tr></table>

<h2 class=MsoTitle align=center style=\'margin-bottom:0in;margin-bottom:.0001pt;
text-align:center;border:none;padding:0in\'><span style=\'font-size:14.0pt;
color:windowtext\'>EPWORTH SLEEPINESS SCALE</span></h2>

<p class=MsoNormal style=\'text-align:justify;border:none;padding:0in\'><span
style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>In contrast to just
feeling tired, how likely are you to doze off or fall asleep in the following
situations? </span></p>

<p class=MsoNormal style=\'text-align:justify;border:none;padding:0in\'><span
style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>Use the following
scale to choose the most appropriate number for each situation:</span></p>

<p class=MsoNormal style=\'border:none;padding:0in\'><b><span style=\'font-size:
11.0pt;font-family:"Arial","sans-serif"\'>  0 = Would
never doze                 1 = Slight chance of dozing  </span></b></p>

<p class=MsoNormal style=\'border:none;padding:0in\'><b><span style=\'font-size:
11.0pt;font-family:"Arial","sans-serif"\'>  2 = Moderate
chance of dozing   3 = High chance of dozing</span>                                                                                                                                               </b>

<p class=MsoNormal style=\'border:none;padding:0in\'><b><u><span
style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>SITUATION</span></u></b>
</p>

<p class=MsoNormal style=\'line-height:100%;border:none;padding:0in\'><span
style=\'font-size:11.0pt;line-height:100%;font-family:"Arial","sans-serif"\'>Sitting
and reading                                                                                          _________</span><br />

<span
style=\'font-size:11.0pt;line-height:100%;font-family:"Arial","sans-serif"\'>Watching
television                                                                                         _________</span><br />

<span
style=\'font-size:11.0pt;line-height:120%;font-family:"Arial","sans-serif"\'>Sitting
inactive in a public place (i.e. theater)                                                 _________</span><br />

<span
style=\'font-size:11.0pt;line-height:120%;font-family:"Arial","sans-serif"\'>As a
car passenger for an hour without a break                                             _________</span><br />

<span
style=\'font-size:11.0pt;line-height:120%;font-family:"Arial","sans-serif"\'>Lying
down to rest in the afternoon                                                                _________</span><br />

<span
style=\'font-size:11.0pt;line-height:150%;font-family:"Arial","sans-serif"\'>Sitting
and talking to someone                                                           
            _________</span><br />

<span
style=\'font-size:11.0pt;line-height:150%;font-family:"Arial","sans-serif"\'>Sitting
quietly after lunch without alcohol                                                       _________</span><br />

<span
style=\'font-size:11.0pt;line-height:150%;font-family:"Arial","sans-serif"\'>In a
car, while stopping for a few minutes in traffic                                        _________
</span><br />
<br />

<span style=\'font-size:11.0pt;
font-family:"Arial","sans-serif"\'>                                                <b>TOTAL
SCORE</b>                                             _________</span></p>

<p class=MsoNormal style=\'border:none;padding:0in\'><span style=\'font-size:11.0pt;
font-family:"Arial","sans-serif"\'>A score of 8 or greater indicates the possibility
of sleep disordered breathing.</span></p>


<h2 align=center style=\'text-align:center;border:none;padding:0in\'><span
style=\'font-size:14.0pt;color:windowtext;font-weight:normal\'>THORNTON SNORING
SCALE</span></h2>

<p class=MsoBodyText style=\'border:none;padding:0in\'><span style=\'font-size:
11.0pt;font-family:"Arial","sans-serif"\'>Snoring has a significant effect on
the quality of life for many people.  Snoring can affect the person snoring and
those around him/her, both physically and emotionally.  Use the following scale
to choose the most appropriate number for each situation. (Go to the 4th
statement if you have no bed partner.)</span></p>

<p class=MsoNormal style=\'border:none;padding:0in\'><b><span style=\'font-size:
11.0pt;font-family:"Arial","sans-serif"\'>0 = Never                                               1
= Infrequently (1 night per week)       </span></b></p>

<p class=MsoNormal style=\'border:none;padding:0in; width:100%\'><b><span style=\'font-size:
11.0pt;font-family:"Arial","sans-serif"\'>2 = Frequently (2-3 nights
per week)   3 = Most of the time (4 or more nights per week)</span></b>
</p>

<p class=MsoNormal style=\'line-height:115%;border:none;padding:0in\'><span
style=\'font-size:11.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>My
snoring affects my relationship with my partner                                      _________      </span><br />

<span
style=\'font-size:11.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>My
snoring causes my partner to be irritable or tired                                     _________</span><br />

<span
style=\'font-size:11.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>My
snoring requires us to sleep in separate rooms                                        _________</span><br />

<span
style=\'font-size:11.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>My
snoring is loud                                                                                           _________</span><br />

<span
style=\'font-size:11.0pt;line-height:115%;font-family:"Arial","sans-serif"\'>My
snoring affects people when I am sleeping</span><br />

<span style=\'font-size:11.0pt;
font-family:"Arial","sans-serif"\'>      away from home (i.e. hotel, camping,
etc.)                                             _________</span><br />
<br />

<span style=\'font-size:11.0pt;
font-family:"Arial","sans-serif"\'>                                                    
<b> TOTAL SCORE</b>                                       _________</span></p>

<p class=MsoNormal style=\'border:none;padding:0in\'><span style=\'font-size:11.0pt;
font-family:"Arial","sans-serif"\'>A score of 5 or greater indicates your
snoring may be significantly affecting your quality of life. </span></p>

<p class=MsoNormal><b><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>PATIENT
NAME </span></b><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>__________________________________________________
<b>DATE:</b> _____________</span></p>

<p style="width:100%; text-align:right;">
<span style=\'font-size:6.0pt;font-family:"Arial","sans-serif"\'><small>© 2013 Dental Sleep
Solutions</small></span></p></div></body>

</html>

';

        $title = "ESS TSS Form";
        $filename = "ess_tss_form_".$id.".pdf";

        create_form_pdf($html, $filename, $title);

}



function update_financial_agreement_form($id){

$logo = get_logo($id);

        
$html = '
<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=Generator content="Microsoft Word 14 (filtered)">
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
@font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";}
span.HeaderChar
	{mso-style-name:"Header Char";}
span.FooterChar
	{mso-style-name:"Footer Char";}
.MsoChpDefault
	{font-size:10.0pt;}
.MsoPapDefault
	{text-autospace:ideograph-other;}
 /* Page Definitions */
 @page WordSection1
	{size:8.5in 11.0in;
	margin:.4in .6in .3in .6in;}
div.WordSection1
	{page:WordSection1;}
-->
</style>

</head>

<body lang=EN-US>


<div class=WordSection1>

<table><tr><td width="30%">'.$logo.'</td>
<td width="70%">
<h2 class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-size:24.0pt;font-family:"Arial","sans-serif"\'>DENTAL SLEEP THERAPY</span></b></h2>

<h2 class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-size:24.0pt;font-family:"Arial","sans-serif"\'>FINANCIAL AGREEMENT</span></b></h2>
</td></tr></table>
<p class=MsoNormal><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>As a courtesy
to you, this office<i><span style=\'color:red\'> </span></i>has verified your
third party insurance benefits.  Understand that our verification of benefits
does not guarantee your third party payment.  If for any reason your third
party carrier(s) should fail to pay for your services, you will be billed for
any shortcomings.  Fees for dental sleep therapy vary per case but can cost up
to $___________.  </span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>Your estimated
copayment for your dental device is $________________ and will not exceed
$__________ as your total out of pocket expense.  </span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>I
___________________________________ am the responsible party for treatment and
have read and agree to the above financial statement.</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>By signing
this agreement you agree to pay for services rendered at our office and
understand that you are individually responsible for payment of all fees.</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>___________________________________________
          ________________________</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>Signature                                                                                          Date</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>___________________________________________
          ________________________</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>Witness                                                                                              Date    </span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-size:8.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p style="width:100%; text-align:right;">
<span style=\'font-size:6.0pt;font-family:"Arial","sans-serif"\'><small>© 2013 Dental Sleep
Solutions</small></span></p>
</div>

</body>

</html>

';

        $title = "Financial Agreement";
        $filename = "financial_agreement_".$id.".pdf";

        create_form_pdf($html, $filename, $title);

}



function update_informed_consent_form($id){

$logo = get_logo($id);
        
$html = '
<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=Generator content="Microsoft Word 14 (filtered)">
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:10.0pt;
	font-family:"Times New Roman","serif";}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:10.0pt;
	font-family:"Times New Roman","serif";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:10.0pt;
	font-family:"Times New Roman","serif";}
p.MsoBodyText, li.MsoBodyText, div.MsoBodyText
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:11.0pt;
	font-family:"Times New Roman","serif";}
p.MsoBodyText2, li.MsoBodyText2, div.MsoBodyText2
	{margin:0in;
	margin-bottom:.0001pt;
	text-align:justify;
	text-autospace:ideograph-other;
	font-size:11.0pt;
	font-family:"Times New Roman","serif";}
p.MsoBodyText3, li.MsoBodyText3, div.MsoBodyText3
	{margin:0in;
	margin-bottom:.0001pt;
	text-align:justify;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Arial","sans-serif";}
p.MsoDocumentMap, li.MsoDocumentMap, div.MsoDocumentMap
	{margin:0in;
	margin-bottom:.0001pt;
	background:navy;
	text-autospace:ideograph-other;
	font-size:10.0pt;
	font-family:"Tahoma","sans-serif";}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";}
span.HeaderChar
	{mso-style-name:"Header Char";}
span.FooterChar
	{mso-style-name:"Footer Char";}
.MsoChpDefault
	{font-size:10.0pt;}
.MsoPapDefault
	{text-autospace:ideograph-other;}
 /* Page Definitions */
 @page WordSection1
	{size:8.5in 11.0in;
	margin:.4in .6in .1in .6in;}
div.WordSection1
	{page:WordSection1;}
-->
</style>

</head>

<body lang=EN-US>

<div class=WordSection1>
<table><tr><td width="30%">'.$logo.'</td>
<td width="70%">
<h2 class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-size:24.0pt;font-family:"Arial","sans-serif"\'>INFORMED CONSENT</span></b></h2>

<h2 class=MsoNormal><b><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>Informed
Consent for Dental Sleep Therapy Use for the Treatment of Sleep Disordered
Breathing</span></b></h2>
</td></tr></table>
<p class=MsoBodyText2 align=left style=\'text-align:left\'><span
style=\'font-family:"Arial","sans-serif"\'>You have been diagnosed by your
physician as requiring treatment for sleep disordered breathing (snoring and/or
obstructive sleep apnea). This condition may pose serious health risks since it
disrupts normal sleep patterns, can reduce normal blood oxygen levels, and may
result in excessive daytime sleepiness, irregular heartbeat, high blood
pressure, heart attack, or stroke.</span></p>

<p class=MsoNormal><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>Dental
sleep therapy for snoring/obstructive sleep apnea assists breathing by keeping
the tongue and jaw in a forward position during sleep.  Dental sleep therapy
has effectively treated many patients.  However, there are no guarantees that
it will be effective for you, since everyone is different and there are many
factors that influence the upper airway during sleep. It<i> </i>is important to
recognize that even when the therapy is effective, there may be a period of
time before the device functions maximally.  During this time you may still
experience the symptoms related to your sleep disordered breathing.  If you are
medically diagnosed as having sleep apnea, a follow-up sleep study to
objectively assure effective treatment is to be obtained from your physician
after the dental device is optimally advanced.</span></p>

<p class=MsoNormal><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>Published
studies show that short term side effects of dental device use may include
excessive salivation, difficulty swallowing with the device in place, sore
jaws, sore teeth, jaw joint pain, dry mouth, gum pain, loosening of the teeth,
and bite changes.  There are also occasional reports of the dislodgment of
ill-fitting dental restorations and possible breakage of the device causing
dangers in aspiration or ingesting.  Most of these side effects are minor<i> </i>and<i>
</i>resolve quickly on their own or with minor adjustment of the device. Long
term complications may include bite changes that may be permanent that result
from tooth movement and/or jaw joint repositioning.  These complications may or
may not be fully reversible once dental sleep therapy is discontinued. If not
reversible, additional dental intervention may be suggested in certain cases
for which you will be financially responsible.  As the severity of the disease
may increase over time, additional advancements and/or new devices may be
required in the future.</span></p>

<p class=MsoBodyText><span style=\'font-family:"Arial","sans-serif"\'>Follow-up
visits with the provider of your dental devices are mandatory to ensure proper
fit and to allow an examination of your mouth to assure a healthy condition. 
If unusual symptoms or discomfort occur outside the scope of this consent, or
if pain medication is required to control discomfort, it is recommended that
you cease using the device until you are evaluated further.</span></p>

<p class=MsoNormal><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>Other
accepted treatments for sleep disordered breathing include behavioral
modifications, positive airway pressure, and various surgeries.  It is your
decision to have chosen dental sleep therapy to treat your sleep disordered
breathing, and you are aware that it may not be completely effective for you. 
It is your responsibility to report the occurrence of side effects and<i> </i>to
address any questions to this provider\'s office.  Failure to treat sleep
disordered breathing may increase the likelihood of significant medical complications.</span></p>

<p class=MsoBodyText3 align=left style=\'text-align:left\'><span
style=\'font-size:11.0pt\'>I have received, read and understand the conditions
and information in this consent form.  I have had the opportunity to discuss
the foregoing conditions and the information concerning the dental devices. 
Furthermore, I give my permission for my diagnostic and treatment records to be
used for the purposes of research, education, or publication in professional
journals.  I also accept financial responsibility for this therapy.  With all
of the foregoing in mind, I authorize treatment and confirm that I have
received a copy of this consent form.</span></p>

<p class=MsoNormal><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>Print
Name: ______________________________________________________</span></p>


<p class=MsoNormal><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>Signature:
_______________________________________________________ Date: _____________    </span></p>


<p style="width:100%; text-align:right;">
<span style=\'font-size:6.0pt;font-family:"Arial","sans-serif"\'><small>© 2013 Dental Sleep
Solutions</small></span></p></div>
</body>
</html>';

        $title = "Informed Consent";
        $filename = "informed_consent_".$id.".pdf";

        create_form_pdf($html, $filename, $title);

}



function update_lomn_rx_form($id){

$logo = get_logo($id);

        
$html = '
<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=Generator content="Microsoft Word 14 (filtered)">
<title>Premier Sleep Disorders Centers</title>
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0in;
	margin-bottom:.0001pt;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{mso-style-link:"Header Char";
	margin:0in;
	margin-bottom:.0001pt;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{mso-style-link:"Footer Char";
	margin:0in;
	margin-bottom:.0001pt;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoDocumentMap, li.MsoDocumentMap, div.MsoDocumentMap
	{margin:0in;
	margin-bottom:.0001pt;
	background:navy;
	font-size:10.0pt;
	font-family:"Tahoma","sans-serif";}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{margin:0in;
	margin-bottom:.0001pt;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";}
span.HeaderChar
	{mso-style-name:"Header Char";
	mso-style-link:Header;}
span.FooterChar
	{mso-style-name:"Footer Char";
	mso-style-link:Footer;}
.MsoChpDefault
	{font-size:10.0pt;}
 /* Page Definitions */
 @page WordSection1
	{size:8.5in 11.0in;
	margin:.4in .6in .4in .6in;}
div.WordSection1
	{page:WordSection1;}
-->
</style>

</head>

<body lang=EN-US>

<div class=WordSection1>
<table><tr><td width="30%">'.$logo.'</td>
<td width="70%">
<h2 class=MsoNormal><b><span style=\'font-size:24.0pt;font-family:"Arial","sans-serif"\'>LETTER
OF MEDICAL NECESSITY (LOMN) AND Rx</span></b></h2>
</td></tr></table>
<p class=MsoNormal><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal style=\'text-align:justify;line-height:200%\'><span
style=\'font-size:11.0pt;line-height:200%;font-family:"Arial","sans-serif"\'>            </span><span
style=\'line-height:200%;font-family:"Arial","sans-serif"\'>Patient Name: _______________________________________________________</span></p>

<p class=MsoNormal style=\'text-align:justify;line-height:200%\'><span
style=\'line-height:200%;font-family:"Arial","sans-serif"\'>            Date of
Birth: ________________________________________________________</span></p>

<p class=MsoNormal style=\'text-align:justify;line-height:200%\'><span
style=\'line-height:200%;font-family:"Arial","sans-serif"\'>            ID
Number: __________________________________________________________</span></p>

<p class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-family:"Arial","sans-serif"\'>Re: Obstructive Sleep Apnea and
Mandibular Advancement Device </span></b></p>

<p class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-family:"Arial","sans-serif"\'>Rx and Statement of Medical Necessity</span></b></p>

<p class=MsoNormal style=\'margin-left:1.0in;text-indent:.5in\'><span
style=\'font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal style=\'line-height:115%\'><span style=\'line-height:115%;
font-family:"Arial","sans-serif"\'>I am prescribing a Mandibular Advancement
Device (<b>E0486</b>) for the above named patient who has been diagnosed with
Obstructive Sleep Apnea (<b>327.23</b>).   I concur that the recommended
therapy is medically necessary and I now prescribe treatment utilizing an FDA
approved Mandibular Advancement Device.  I strongly urge you to cover the costs
of this therapy. Failure to do so would place the patient’s health in jeopardy.</span></p>

<p class=MsoNormal><span style=\'font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal style=\'line-height:115%\'><span style=\'line-height:115%;
font-family:"Arial","sans-serif"\'>Physician Name: ________________________________________________________________<span
style=\'color:#0070C0\'>  </span></span></p>

<p class=MsoNormal style=\'line-height:115%\'><span style=\'line-height:115%;
font-family:"Arial","sans-serif";color:#0070C0\'>                           </span></p>

<p class=MsoNormal style=\'line-height:115%\'><span style=\'line-height:115%;
font-family:"Arial","sans-serif"\'>Physician\'s Signature:  ____________________________________________________________
</span></p>

<p class=MsoNormal style=\'line-height:115%\'><span style=\'line-height:115%;
font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal style=\'line-height:115%\'><span style=\'line-height:115%;
font-family:"Arial","sans-serif"\'>Date: _________________________________________________________________________</span></p>

<p class=MsoNormal style=\'line-height:115%\'><span style=\'line-height:115%;
font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal style=\'line-height:115%\'><span style=\'line-height:115%;
font-family:"Arial","sans-serif"\'>Physician Address: <b>            </b>______________________________________________________________</span></p>

<p class=MsoNormal style=\'line-height:115%\'><span style=\'line-height:115%;
font-family:"Arial","sans-serif"\'>                                    </span></p>

<p class=MsoNormal style=\'line-height:115%\'><span style=\'line-height:115%;
font-family:"Arial","sans-serif"\'>                                    ______________________________________________________________</span></p>

</div>

</body>

</html>

';

        $title = "LOMN Rx";
        $filename = "lomn_rx_".$id.".pdf";

        create_form_pdf($html, $filename, $title);

}



function update_medical_hx_update_form($id){

$logo = get_logo($id);
        
$html = '
<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=Generator content="Microsoft Word 14 (filtered)">
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";}
span.HeaderChar
	{mso-style-name:"Header Char";}
span.FooterChar
	{mso-style-name:"Footer Char";}
.MsoChpDefault
	{font-size:10.0pt;}
.MsoPapDefault
	{text-autospace:ideograph-other;}
 /* Page Definitions */
 @page WordSection1
	{size:8.5in 11.0in;
	margin:.4in .6in .4in .6in;}
div.WordSection1
	{page:WordSection1;}
-->
</style>

</head>

<body lang=EN-US>

<div class=WordSection1>
<table><tr><td width="30%">'.$logo.'</td>
<td width="70%">
<h2 class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-size:24.0pt;font-family:"Arial","sans-serif"\'>MEDICAL HISTORY
UPDATE FORM</span></b></h2>
</td></tr></table>
<p class=MsoNormal><b><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></b></p>

<p class=MsoNormal style=\'line-height:150%\'><span style=\'font-size:11.0pt;
line-height:150%;font-family:"Arial","sans-serif"\'>We work hard to keep your
medical contacts informed of your treatment progress and status.  Please take
time to inform us about any changes in your medical history and/or medications
since your last visit.</span></p>

<p class=MsoNormal style=\'line-height:150%\'><b><span style=\'font-size:11.0pt;
line-height:150%;font-family:"Arial","sans-serif"\'>Please list any NEW medical
diagnoses below:</span></b></p>

<p class=MsoNormal style=\'line-height:150%\'><span style=\'font-size:11.0pt;
line-height:150%;font-family:"Arial","sans-serif"\'>________________________________________________________________</span></p>

<p class=MsoNormal style=\'line-height:150%\'><span style=\'font-size:11.0pt;
line-height:150%;font-family:"Arial","sans-serif"\'>________________________________________________________________</span></p>

<p class=MsoNormal style=\'line-height:150%\'><span style=\'font-size:11.0pt;
line-height:150%;font-family:"Arial","sans-serif"\'>________________________________________________________________</span></p>

<p class=MsoNormal style=\'line-height:150%\'><b><span style=\'font-size:11.0pt;
line-height:150%;font-family:"Arial","sans-serif"\'>Please list any NEW or
CHANGES in your medications below:</span></b></p>

<p class=MsoNormal style=\'line-height:150%\'><span style=\'font-size:11.0pt;
line-height:150%;font-family:"Arial","sans-serif"\'>________________________________________________________________</span></p>

<p class=MsoNormal style=\'line-height:150%\'><span style=\'font-size:11.0pt;
line-height:150%;font-family:"Arial","sans-serif"\'>________________________________________________________________</span></p>

<p class=MsoNormal style=\'line-height:150%\'><span style=\'font-size:11.0pt;
line-height:150%;font-family:"Arial","sans-serif"\'>________________________________________________________________</span></p>

<p class=MsoNormal style=\'line-height:150%\'><span style=\'font-size:11.0pt;
line-height:150%;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal style=\'margin-left:.5in;text-align:justify;line-height:200%\'><span
style=\'font-size:11.0pt;line-height:200%;font-family:"Arial","sans-serif"\'>Patient
Name: ________________________________________________________</span></p>

<p class=MsoNormal style=\'margin-left:.5in;text-align:justify;line-height:200%\'><span
style=\'font-size:11.0pt;line-height:200%;font-family:"Arial","sans-serif"\'>Patient
Signature: ______________________________________Date:__________</span></p>

<p class=MsoNormal style=\'margin-left:.5in\'><span style=\'font-size:11.0pt;
font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal align=right style=\'margin-left:.5in;text-align:right\'><span
style=\'font-size:8.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p style="width:100%; text-align:right;">
<span style=\'font-size:6.0pt;font-family:"Arial","sans-serif"\'><small>© 2013 Dental Sleep
Solutions</small></span></p></div>

</body>

</html>

';

        $title = "Medical Hx Update";
        $filename = "medical_hx_update_".$id.".pdf";

        create_form_pdf($html, $filename, $title);

}



function update_the_dss_experience_form($id){

$logo = get_logo($id);
        
$html = '
<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=Generator content="Microsoft Word 14 (filtered)">
<title>The Dental Sleep Solutions Experience</title>
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;}
@font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;}
@font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{margin:0in;
	margin-bottom:.0001pt;
	text-autospace:ideograph-other;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";}
span.HeaderChar
	{mso-style-name:"Header Char";}
span.FooterChar
	{mso-style-name:"Footer Char";}
.MsoChpDefault
	{font-size:10.0pt;}
.MsoPapDefault
	{text-autospace:ideograph-other;}
 /* Page Definitions */
 @page WordSection1
	{size:8.5in 11.0in;
	margin:.4in .6in .4in .6in;}
div.WordSection1
	{page:WordSection1;}
 /* List Definitions */
 ol
	{margin-bottom:0in;}
ul
	{margin-bottom:0in;}
-->
</style>

</head>

<body lang=EN-US>

<div class=WordSection1>
<table><tr><td width="30%">'.$logo.'</td>
<td width="70%">
<h2 class=MsoNormal align=center style=\'text-align:center\'><b><span
style=\'font-size:24.0pt;font-family:"Arial","sans-serif"\'>THE DENTAL SLEEP
SOLUTIONS<sup>®</sup> EXPERIENCE</span></b></h2>
</td></tr></table>
<p class=MsoNormal><span style=\'font-size:11.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

<p class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Successful
treatment of snoring and Obstructive Sleep Apnea (OSA) with dental sleep
therapy relies on seeking treatment from a properly trained dentist, careful
patient screening, and following successful treatment protocols.  You have
already successfully accomplished the first of these goals by selecting a
Dental Sleep Solutions<sup>®</sup> dentist who adheres to these standards.</span></p>

<p class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Although
individual treatments may vary, below is an overview of what you can expect to
happen to ensure proper treatment of your snoring or OSA:</span></p>

<p class=MsoNormal><b><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>1<sup>st</sup>
Appointment - Free Consultation (approximately 45 minutes)</span></b></p>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Prior
      to your arrival, your Dental Sleep Solutions<sup>®</sup> team will review
      all of your previously obtained documentation to understand your reasons
      for seeking treatment.  They will review your questionnaires as well as
      your previous sleep test(s) if applicable. This information is vital to
      help your Dental Sleep Solutions<sup>®</sup> dentist understand your
      needs and to better help with all of your symptoms and concerns.</span></li>
 </ul>
</ul>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>During
      your initial appointment, you will meet your Dental Sleep Solutions<sup>®</sup>
      dentist and their team.  They will listen to your concerns and learn the
      reasons you are seeking advice.  Through their extensive knowledge, they
      will help ensure that you have a complete comprehension of snoring and
      OSA including the causes, diagnosis, and medical ramifications for this
      serious disorder.  They will also review the risks, benefits and
      alternatives of the various treatments available for snoring and OSA.  </span></li>
 </ul>
</ul>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Once
      you have a thorough knowledge of snoring and OSA, and your DSS team has
      answered all of your concerns, then a limited oral exam may take place. 
      The purpose of the examination is to assess the anatomy of the upper
      airway, the condition and stability of the teeth and TMJ, and to evaluate
      the range of motion of the jaw to determine if you are a good candidate
      for dental sleep therapy.  Your Dental Sleep Solutions<sup>®</sup>
      dentist will be able to determine which type of dental sleep device will
      work best for your particular situation and also inform you of the likely
      outcomes of treatment.</span></li>
 </ul>
</ul>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>If
      you have not previously had a sleep study, then your Dental Sleep
      Solutions<sup>®</sup> team will discuss the various options for having a
      sleep study.</span></li>
 </ul>
</ul>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>If
      it is determined that you are a good candidate for dental sleep therapy,
      your Dental Sleep Solutions<sup>®</sup> team will discuss insurance,
      financial arrangements, and make an appointment to begin treatment.</span></li>
 </ul>
</ul>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Regardless
      of whether or not treatment is scheduled, correspondence will be sent to
      your physicians discussing the findings of your Dental Sleep Solutions<sup>®</sup>
      team.</span></li>
 </ul>
</ul>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>This
      appointment will be at no cost to you, although we may bill your medical
      insurance and accept their payments with your permission.</span></li>
 </ul>
</ul>

<p class=MsoNormal><b><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>2<sup>nd</sup>
Appointment – Begin Treatment (approximately 1 to 1.5 hrs)</span></b></p>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Your
      Dental Sleep Solutions<sup>®</sup> dentist will work closely with your
      regular dentist.  However, your Dental Sleep Solutions<sup>®</sup>
      dentist’s goal is not the same as your regular dentist.  He will evaluate
      your teeth to ensure they are stable enough to secure a dental sleep
      device but he will not be doing an exam for preventative dental care. 
      You should see your regular dentist for routine dental services.  If your
      regular dentist has current x-rays then the Dental Sleep Solutions<sup>®</sup>
      staff will obtain a copy prior to your visit.  Our staff will also obtain
      any insurance preauthorizations and medical documentations needed prior
      to your appointment. </span></li>
 </ul>
</ul>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Your
      appointment will consist of an examination of your oral dentition
      (teeth), soft tissues, airway, occlusion (bite), TMJ and range of motion
      of your jaw.  Any needed x-rays will be taken and digital photographs of
      your teeth and oral cavity will be completed.  Impressions (molds) and a
      bite registration will be made from which your custom-made dental sleep
      device will be constructed.</span></li>
 </ul>
</ul>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Your
      Dental Sleep Solutions<sup>®</sup> dentist will help select the most
      appropriate custom-made dental sleep device for your particular situation,
      and he will review the risks, benefits and alternatives of treatment.</span></li>
 </ul>
</ul>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>An
      appointment will be made in 3 to 4 weeks for delivery of your dental
      sleep device.</span></li>
 </ul>
</ul>

<p class=MsoNormal><b><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>3<sup>rd</sup>
Appointment – Delivery of device (approximately 45 minutes)</span></b></p>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Your
      custom dental sleep device will be put in place and assessed as to fit,
      comfort and stability.  Some adjustment by your Dental Sleep Solutions<sup>®</sup>
      dentist is common.  Once adequately fitted, you will be given
      instructions on the wearing and care of the device, as well what to
      expect during the first few weeks of wear.</span></li>
 </ul>
</ul>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Your
      initial symptoms will be reviewed and you will be asked to monitor these
      items during the next few weeks.</span></li>
 </ul>
</ul>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Your
      next appointment is usually scheduled for 1 to 4 weeks after you receive
      the dental sleep device.  Of course any concerns prior to this
      appointment are happily addressed by phone or by seeing your Dental Sleep
      Solutions<sup>®</sup> dentist sooner.</span></li>
 </ul>
</ul>

<p class=MsoNormal><b><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>4<sup>th</sup>
Appointment – 1<sup>st</sup> Device evaluation (30 to 45 minutes) </span></b></p>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>The
      first time that you are seen after you have begun dental sleep therapy,
      your Dental Sleep Solutions<sup>®</sup> team will first want to insure
      that the appliance is being worn comfortably every night.  Any areas of
      concern will be addressed and questions that you have will be answered. 
      Your symptoms will be discussed and documentation of improvement will be
      made.  </span></li>
 </ul>
</ul>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>No
      further advancement of the dental sleep device will be made unless you
      are able to sleep through the night with your device and you are not
      experiencing pain directly related to wearing your device. Due to
      inflammation caused from snoring and OSA, the effectiveness of the dental
      sleep device actually improves over the first month of wearing. </span></li>
 </ul>
</ul>

<p class=MsoNormal><b><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>5<sup>th</sup>
Appointment – 2<sup>nd</sup> Device evaluation (30 to 45 minutes)</span></b></p>

<p class=MsoNormal style=\'margin-left:1.0in;text-indent:-.25in\'><span
style=\'font-family:Wingdings\'>§<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;
</span></span><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>At
this point you should comfortably be wearing your dental sleep device every
night.  You should show improvement in your subjective symptoms.  If some
symptoms remain, then your Dental Sleep Solutions<sup>®</sup> dental team will
develop a plan to adjust your device for maximum effectiveness.  All of the
custom-made dental sleep devices that our dentists utilize are adjustable to
obtain the ideal airway opening.  These dental sleep devices are slowly
adjusted to minimize any discomfort or side effects.  This process sometimes is
not necessary at all, or it can take a few weeks to a few months to
accomplish.  The goal of your Dental Sleep Solutions<sup>®</sup> dentist is to
help you obtain the ideal position that maximizes the airway opening and
diminishes your symptoms while minimizing any unwanted side effects.  </span></p>

<p class=MsoNormal><b><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Additional
Appointments – Device evaluation (10 to 45 minutes)</span></b></p>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Our
      goal is to correct your subjective symptoms and to also document
      objective success of treating your OSA.  We initially adjust your device
      based on subjective symptoms.  It may require no adjustments after the
      initial placement or it make take many adjustments.  Your Dental Sleep
      Solutions<sup>®</sup> team is trained and dedicated to obtain the best
      position for your dental sleep device.  Once your Dental Sleep Solutions<sup>®</sup>
      team feels your dental sleep device is adjusted adequately for relief of
      your symptoms, then you will be given a portable home sleep test (HST) to
      objectively evaluate the effectiveness of your device at the current
      setting.  Depending on the results of the initial test, you may need to
      repeat the portable home sleep test multiple times as your device is
      tweaked.</span></li>
 </ul>
</ul>


<p class=MsoNormal style=\'page-break-before:always\'><b><span style=\'font-size:
10.0pt;font-family:"Arial","sans-serif"\'> Home Sleep Test (overnight)</span></b></p>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Once
      your dental sleep device has been adequately adjusted to control your
      symptoms it will be time to ensure that it your OSA is adequately being
      controlled.  Although symptom relief is a good sign, it does not
      necessarily ensure that your OSA is at an acceptable level.  You will be
      given a state-of-the-art home sleep recorder.  This is the same device
      physicians use in portable sleep studies and gives very valuable
      information as to the objective effectiveness of your dental sleep
      device.  You will be given instructions on how to wear the recorder, and
      you will be asked to sleep one night with the recorder while wearing your
      dental sleep device.  The next day, after you deliver the recorder back
      to your Dental Sleep Solutions<sup>®</sup> dentist, the data will be
      uploaded into their computer where it will be evaluated.  Your Dental
      Sleep Solutions<sup>®</sup> dentist has been trained to read the results
      of this test and they will inform you of their educated findings. 
      Depending on the results, you may be required to adjust your dental sleep
      device further.  Your Dental Sleep Solutions<sup>®</sup> dentist will
      discuss the results of your HST and advise you as to further adjustment
      or testing as necessary.</span></li>
 </ul>
</ul>

<p class=MsoNormal><b><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Dental
Sleep Device Titration Completed</span></b></p>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Once
      your dental sleep device has been optimally titrated, you will be
      scheduled for a yearly follow up.  Please know that your Dental Sleep
      Solutions<sup>®</sup> dentist will be happy to see you at any time prior
      to your yearly evaluation if you experience any problems or have any
      concerns.</span></li>
 </ul>
</ul>

<ul style=\'margin-top:0in\' type=disc>
 <ul style=\'margin-top:0in\' type=square>
  <li class=MsoNormal><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Your
      Dental Sleep Solutions<sup>®</sup> team will send correspondence to all
      of your physicians and your regular dentist regarding the results of your
      HST.  Your primary care physician or sleep doctor may request a formal
      sleep study to confirm the results of our HST.  If this is the case, your
      DSS dentist will help you coordinate this test.<b><span style=\'color:
      red\'>  </span></b></span></li>
 </ul>
</ul>

<p class=MsoNormal><b><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Yearly
Evaluation</span></b></p>

<p class=MsoNormal style=\'margin-left:1.0in;text-indent:-.25in\'><span
style=\'font-size:10.0pt;font-family:Wingdings\'>§<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;
</span></span><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>The
treatment of Snoring and Obstructive Sleep Apnea is a dynamic process that can
change as time passes.  It is important that you see your Dental Sleep
Solutions dentist annually to evaluate the effectiveness of your dental sleep
device and to check for any side effects present.</span></p>

<p class=MsoNormal style=\'margin-left:1.0in;text-indent:-.25in\'><span
style=\'font-family:Wingdings\'>§<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;
</span></span><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>During
this visit your Dental Sleep Solutions<sup>®</sup> dentist will evaluate the
effectiveness of the dental sleep device through discussion of any subjective
changes.    They will do an oral exam and TMJ exam, and will address any
concerns or questions that you have with the device.  They will take digital photographs
of your teeth to document their position and any changes present.  Depending on
their findings they may, on occasion, recommend an updated home sleep study.</span></p>

<p class=MsoNormal style=\'margin-left:1.0in;text-indent:-.25in\'><span
style=\'font-family:Wingdings\'>§<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;
</span></span><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Correspondence
will be sent by your Dental Sleep Solutions<sup>®</sup> team to your physicians
and dentist with the results of this visit.</span></p>

<p class=MsoNormal><b><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Thirty
Month Evaluation</span></b></p>

<p class=MsoNormal style=\'margin-left:1.0in;text-indent:-.25in\'><span
style=\'font-family:Wingdings\'>§<span style=\'font:7.0pt "Times New Roman"\'>&nbsp;
</span></span><span style=\'font-size:10.0pt;font-family:"Arial","sans-serif"\'>Since
most dental devices have a life expectancy of two to three years, we recommend
an evaluation at the 30 month mark.&nbsp; This will allow us to evaluate the
integrity of your device and, if it is cracked or worn, we may recommend
replacement.</span><span style=\'font-size:8.0pt;font-family:"Arial","sans-serif"\'>
</span></p>

<p class=MsoNormal><span style=\'font-size:8.0pt;font-family:"Arial","sans-serif"\'>&nbsp;</span></p>

</div>

</body>

</html>

';

        $title = "The DSS Experience";
        $filename = "the_dss_experience_".$id.".pdf";

        create_form_pdf($html, $filename, $title);

}


function create_form_pdf($html, $filename, $title){

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Dental Sleep Solutions');
        $pdf->SetTitle($title);
        $pdf->SetSubject($title);
        $pdf->SetKeywords('DSS Correspondance');

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        //set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        //set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 0);

        //set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        //set some language-dependent strings
        //$pdf->setLanguageArray($l);

        // set font
        $pdf->SetFont('dejavusans', '', 10);

        // add a page
        $pdf->AddPage();

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');
        //Close and output PDF document

        $pdf->Output($_SERVER['DOCUMENT_ROOT'] . '/manage/q_file/' . $filename, 'F');

}


function form_update_all($docid){
 
      update_custom_release_form($docid);
      update_financial_agreement_medicare_form($docid);
      update_home_care_instructions_form($docid);
      update_non_dentist_of_record_release_form($docid);
      update_sleep_recorder_release_form($docid);
      update_affidavit_for_cpap_intolerance_form($docid);
      update_device_titration_ema_form($docid);
      update_device_titration_form($docid);
      update_ess_tss_form($docid);
      update_financial_agreement_form($docid);
      update_informed_consent_form($docid);
      update_lomn_rx_form($docid);
      update_medical_hx_update_form($docid);
      update_the_dss_experience_form($docid);

}


function get_logo($id){

  $l_sql = "SELECT logo, user_type FROM dental_users where userid=".mysql_real_escape_string($id);
  $l_q = mysql_query($l_sql);
  $l_r = mysql_fetch_assoc($l_q);
  if($l_r['user_type'] == DSS_USER_TYPE_SOFTWARE){
    if($l_r['logo']!=''){
      $logo = '<img src="/manage/q_file/'.$l_r['logo'].'" />';
    }else{
      $logo = "";
    }
  }else{
    $logo = '<img src="/manage/images/logo.gif" />';
  } 
  return $logo;
}
