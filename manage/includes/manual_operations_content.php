<?php namespace Ds3\Libraries\Legacy; ?><style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;}
@font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;}
@font-face
	{font-family:Cambria;
	panose-1:2 4 5 3 5 4 6 3 2 4;}
@font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
@font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;}
@font-face
	{font-family:"Franklin Gothic Medium";
	panose-1:2 11 6 3 2 1 2 2 2 4;}
@font-face
	{font-family:"Bernard MT Condensed";
	panose-1:2 5 8 6 6 9 5 2 4 4;}
@font-face
	{font-family:"Bodoni MT Black";
	panose-1:2 7 10 3 8 6 6 2 2 3;}
@font-face
	{font-family:"Bodoni MT";
	panose-1:2 7 6 3 8 6 6 2 2 3;}
@font-face
	{font-family:"Franklin Gothic Book";
	panose-1:2 11 5 3 2 1 2 2 2 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:12.0pt;
	font-family:"Calibri","sans-serif";}
h1
	{mso-style-link:"Heading 1 Char";
	margin-top:24.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.25in;
	margin-bottom:.0001pt;
	text-indent:-.25in;
	line-height:120%;
	page-break-after:avoid;
	border:none;
	padding:0in;
	font-size:26.0pt;
	font-family:"Cambria","serif";}
h2
	{mso-style-link:"Heading 2 Char";
	margin-top:10.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	text-align:center;
	line-height:120%;
	page-break-after:avoid;
	font-size:18.0pt;
	font-family:"Cambria","serif";
	text-transform:uppercase;
	text-decoration:underline;}
h3
	{mso-style-link:"Heading 3 Char";
	margin-top:10.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	page-break-after:avoid;
	font-size:16.0pt;
	font-family:"Cambria","serif";
	text-decoration:underline;}
h4
	{mso-style-link:"Heading 4 Char";
	margin-top:10.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	page-break-after:avoid;
	font-size:12.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#4F81BD;
	font-style:italic;}
h5
	{mso-style-link:"Heading 5 Char";
	margin-top:10.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	page-break-after:avoid;
	font-size:12.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#243F60;
	font-weight:normal;}
h6
	{mso-style-link:"Heading 6 Char";
	margin-top:10.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	page-break-after:avoid;
	font-size:12.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#243F60;
	font-weight:normal;
	font-style:italic;}
p.MsoHeading7, li.MsoHeading7, div.MsoHeading7
	{mso-style-link:"Heading 7 Char";
	margin-top:10.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	page-break-after:avoid;
	font-size:12.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#404040;
	font-style:italic;}
p.MsoHeading8, li.MsoHeading8, div.MsoHeading8
	{mso-style-link:"Heading 8 Char";
	margin-top:10.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	page-break-after:avoid;
	font-size:10.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#4F81BD;}
p.MsoHeading9, li.MsoHeading9, div.MsoHeading9
	{mso-style-link:"Heading 9 Char";
	margin-top:10.0pt;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	page-break-after:avoid;
	font-size:10.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#404040;
	font-style:italic;}
p.MsoToc1, li.MsoToc1, div.MsoToc1
	{margin-top:6.0pt;
	margin-right:0in;
	margin-bottom:6.0pt;
	margin-left:0in;
	line-height:120%;
	font-size:12.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	text-transform:uppercase;
	font-weight:bold;}
p.MsoToc2, li.MsoToc2, div.MsoToc2
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:12.0pt;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:12.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	font-variant:small-caps;}
p.MsoToc3, li.MsoToc3, div.MsoToc3
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:24.0pt;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:12.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	font-style:italic;}
p.MsoToc4, li.MsoToc4, div.MsoToc4
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:9.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoToc5, li.MsoToc5, div.MsoToc5
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:48.0pt;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:9.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoToc6, li.MsoToc6, div.MsoToc6
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:60.0pt;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:9.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoToc7, li.MsoToc7, div.MsoToc7
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:1.0in;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:9.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoToc8, li.MsoToc8, div.MsoToc8
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:84.0pt;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:9.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoToc9, li.MsoToc9, div.MsoToc9
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:96.0pt;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:9.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoCommentText, li.MsoCommentText, div.MsoCommentText
	{mso-style-link:"Comment Text Char";
	margin:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:10.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoHeader, li.MsoHeader, div.MsoHeader
	{mso-style-link:"Header Char";
	margin:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:12.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoFooter, li.MsoFooter, div.MsoFooter
	{mso-style-link:"Footer Char";
	margin:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:12.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoCaption, li.MsoCaption, div.MsoCaption
	{margin:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:9.0pt;
	font-family:"Calibri","sans-serif";
	color:#4F81BD;
	font-weight:bold;}
p.MsoTitle, li.MsoTitle, div.MsoTitle
	{mso-style-link:"Title Char";
	margin-top:0in;
	margin-right:0in;
	margin-bottom:15.0pt;
	margin-left:0in;
	line-height:120%;
	border:none;
	padding:0in;
	font-size:26.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#17365D;
	letter-spacing:.25pt;}
p.MsoTitleCxSpFirst, li.MsoTitleCxSpFirst, div.MsoTitleCxSpFirst
	{mso-style-link:"Title Char";
	margin:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	border:none;
	padding:0in;
	font-size:26.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#17365D;
	letter-spacing:.25pt;}
p.MsoTitleCxSpMiddle, li.MsoTitleCxSpMiddle, div.MsoTitleCxSpMiddle
	{mso-style-link:"Title Char";
	margin:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	border:none;
	padding:0in;
	font-size:26.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#17365D;
	letter-spacing:.25pt;}
p.MsoTitleCxSpLast, li.MsoTitleCxSpLast, div.MsoTitleCxSpLast
	{mso-style-link:"Title Char";
	margin-top:0in;
	margin-right:0in;
	margin-bottom:15.0pt;
	margin-left:0in;
	line-height:120%;
	border:none;
	padding:0in;
	font-size:26.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#17365D;
	letter-spacing:.25pt;}
p.MsoBodyText, li.MsoBodyText, div.MsoBodyText
	{mso-style-link:"Body Text Char";
	margin:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	punctuation-wrap:simple;
	text-autospace:none;
	font-size:12.0pt;
	font-family:"Times New Roman","serif";}
p.MsoSubtitle, li.MsoSubtitle, div.MsoSubtitle
	{mso-style-link:"Subtitle Char";
	margin:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:12.0pt;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#4F81BD;
	letter-spacing:.75pt;
	font-style:italic;}
p.MsoBodyText2, li.MsoBodyText2, div.MsoBodyText2
	{mso-style-link:"Body Text 2 Char";
	margin-top:0in;
	margin-right:0in;
	margin-bottom:6.0pt;
	margin-left:0in;
	line-height:200%;
	font-size:12.0pt;
	font-family:"Calibri","sans-serif";}
a:link, span.MsoHyperlink
	{color:blue;
	text-decoration:underline;}
a:visited, span.MsoHyperlinkFollowed
	{color:purple;
	text-decoration:underline;}
p.MsoCommentSubject, li.MsoCommentSubject, div.MsoCommentSubject
	{mso-style-link:"Comment Subject Char";
	margin:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:10.0pt;
	font-family:"Calibri","sans-serif";
	font-weight:bold;}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{mso-style-link:"Balloon Text Char";
	margin:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:8.0pt;
	font-family:"Tahoma","sans-serif";}
p.MsoNoSpacing, li.MsoNoSpacing, div.MsoNoSpacing
	{margin:0in;
	margin-bottom:.0001pt;
	font-size:12.0pt;
	font-family:"Arial","sans-serif";}
p.MsoRMPane, li.MsoRMPane, div.MsoRMPane
	{margin:0in;
	margin-bottom:.0001pt;
	font-size:11.0pt;
	font-family:"Arial","sans-serif";}
p.MsoListParagraph, li.MsoListParagraph, div.MsoListParagraph
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:12.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraphCxSpFirst, li.MsoListParagraphCxSpFirst, div.MsoListParagraphCxSpFirst
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:12.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraphCxSpMiddle, li.MsoListParagraphCxSpMiddle, div.MsoListParagraphCxSpMiddle
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:12.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoListParagraphCxSpLast, li.MsoListParagraphCxSpLast, div.MsoListParagraphCxSpLast
	{margin-top:0in;
	margin-right:0in;
	margin-bottom:0in;
	margin-left:.5in;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:12.0pt;
	font-family:"Calibri","sans-serif";}
p.MsoQuote, li.MsoQuote, div.MsoQuote
	{mso-style-link:"Quote Char";
	margin:0in;
	margin-bottom:.0001pt;
	line-height:120%;
	font-size:12.0pt;
	font-family:"Calibri","sans-serif";
	color:black;
	font-style:italic;}
p.MsoIntenseQuote, li.MsoIntenseQuote, div.MsoIntenseQuote
	{mso-style-link:"Intense Quote Char";
	margin-top:10.0pt;
	margin-right:.65in;
	margin-bottom:14.0pt;
	margin-left:.65in;
	line-height:120%;
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
	margin-left:.25in;
	margin-bottom:.0001pt;
	text-indent:-.25in;
	line-height:120%;
	page-break-after:avoid;
	border:none;
	padding:0in;
	font-size:26.0pt;
	font-family:"Cambria","serif";
	font-weight:bold;}
span.Heading1Char
	{mso-style-name:"Heading 1 Char";
	mso-style-link:"Heading 1";
	font-family:"Cambria","serif";
	font-weight:bold;}
span.Heading2Char
	{mso-style-name:"Heading 2 Char";
	mso-style-link:"Heading 2";
	font-family:"Cambria","serif";
	text-transform:uppercase;
	font-weight:bold;
	text-decoration:underline;}
span.Heading3Char
	{mso-style-name:"Heading 3 Char";
	mso-style-link:"Heading 3";
	font-family:"Cambria","serif";
	font-weight:bold;
	text-decoration:underline;}
span.Heading4Char
	{mso-style-name:"Heading 4 Char";
	mso-style-link:"Heading 4";
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#4F81BD;
	font-weight:bold;
	font-style:italic;}
span.Heading5Char
	{mso-style-name:"Heading 5 Char";
	mso-style-link:"Heading 5";
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#243F60;}
span.Heading6Char
	{mso-style-name:"Heading 6 Char";
	mso-style-link:"Heading 6";
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#243F60;
	font-style:italic;}
span.Heading7Char
	{mso-style-name:"Heading 7 Char";
	mso-style-link:"Heading 7";
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#404040;
	font-style:italic;}
span.Heading8Char
	{mso-style-name:"Heading 8 Char";
	mso-style-link:"Heading 8";
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#4F81BD;}
span.Heading9Char
	{mso-style-name:"Heading 9 Char";
	mso-style-link:"Heading 9";
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#404040;
	font-style:italic;}
span.TitleChar
	{mso-style-name:"Title Char";
	mso-style-link:Title;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#17365D;
	letter-spacing:.25pt;}
span.SubtitleChar
	{mso-style-name:"Subtitle Char";
	mso-style-link:Subtitle;
	font-family:"Franklin Gothic Medium","sans-serif";
	color:#4F81BD;
	letter-spacing:.75pt;
	font-style:italic;}
span.QuoteChar
	{mso-style-name:"Quote Char";
	mso-style-link:Quote;
	color:black;
	font-style:italic;}
span.IntenseQuoteChar
	{mso-style-name:"Intense Quote Char";
	mso-style-link:"Intense Quote";
	color:#4F81BD;
	font-weight:bold;
	font-style:italic;}
span.HeaderChar
	{mso-style-name:"Header Char";
	mso-style-link:Header;}
span.FooterChar
	{mso-style-name:"Footer Char";
	mso-style-link:Footer;}
span.BodyTextChar
	{mso-style-name:"Body Text Char";
	mso-style-link:"Body Text";
	font-family:"Times New Roman","serif";}
span.BodyText2Char
	{mso-style-name:"Body Text 2 Char";
	mso-style-link:"Body Text 2";}
span.BalloonTextChar
	{mso-style-name:"Balloon Text Char";
	mso-style-link:"Balloon Text";
	font-family:"Tahoma","sans-serif";}
span.CommentTextChar
	{mso-style-name:"Comment Text Char";
	mso-style-link:"Comment Text";}
span.CommentSubjectChar
	{mso-style-name:"Comment Subject Char";
	mso-style-link:"Comment Subject";
	font-weight:bold;}
.MsoChpDefault
	{font-size:10.0pt;
	font-family:"Arial","sans-serif";}
 /* Page Definitions */
 @page WordSection1
	{size:8.5in 11.0in;
	margin:.7in .8in .9in .8in;}
div.WordSection1
	{page:WordSection1;}
@page WordSection2
	{size:8.5in 11.0in;
	margin:1.0in 1.2in 1.0in 1.2in;}
div.WordSection2
	{page:WordSection2;}
@page WordSection3
	{size:8.5in 11.0in;
	margin:1.0in 1.75in 1.0in .75in;}
div.WordSection3
	{page:WordSection3;}
 /* List Definitions */
 ol
	{margin-bottom:0in;}
ul
	{margin-bottom:0in;}
-->
</style>

</head>

<body lang=EN-US link=blue vlink=purple>

<div class=WordSection1>

<p class=MsoNormal align=center style='margin-top:12.0pt;text-align:center;
line-height:normal'><b><span style='font-size:28.0pt;font-family:"Franklin Gothic Medium","sans-serif"'>SYSTEMS
&amp; OPERATIONS MANUAL</span></b></p>

<p class=MsoNormal align=center style='text-align:center;line-height:normal'><b><span
style='font-size:22.0pt;font-family:"Franklin Gothic Medium","sans-serif"'>DENTAL
SLEEP SOLUTIONS<sup>&reg; </sup>FRANCHISING LLC</span></b></p>

<p class=MsoNormal align=center style='text-align:center;line-height:normal'><b><span
style='font-size:28.0pt;font-family:"Franklin Gothic Medium","sans-serif";
color:white;background:black'>LICENSE #<?= $_SESSION['docid']; ?></span></b></p>
<?php

$s = "SELECT * from dental_users where userid='".mysqli_real_escape_string($con, $_SESSION['docid'])."'";
$q = mysqli_query($con, $s);
$r = mysqli_fetch_assoc($q);
$docname = $r['name'];
?>


<p class=MsoNormal align=center style='text-align:center;line-height:normal'><b><span
style='font-size:28.0pt;font-family:"Franklin Gothic Medium","sans-serif";
color:white;background:black'>FOR USE BY: <?= $docname; ?></span></b></p>

<p class=MsoNormal align=center style='text-align:center;line-height:normal'><b><span
style='font-size:28.0pt;font-family:"Franklin Gothic Medium","sans-serif";
color:white'>&nbsp;</span></b></p>

<p class=MsoNormal align=center style='text-align:center;line-height:normal'><span
style='font-family:"Franklin Gothic Medium","sans-serif"'><img width=475
height=438 id="Picture 45"
src="includes/manual_operations_assets/image001.png"></span></p>

<p class=MsoNormal align=center style='text-align:center'><span
style='font-size:22.0pt;line-height:120%;font-family:"Franklin Gothic Medium","sans-serif"'>&nbsp;</span></p>

<p class=MsoNormal align=center style='text-align:center'><span
style='font-size:22.0pt;line-height:120%;font-family:"Franklin Gothic Medium","sans-serif"'>FOR
THE USE OF AUTHORIZED</span></p>

<p class=MsoNormal align=center style='text-align:center'><span
style='font-size:22.0pt;line-height:120%;font-family:"Franklin Gothic Medium","sans-serif"'>FRANCHISEES/OPERATORS/MANAGERS
ONLY</span></p>

<p class=MsoNormal align=center style='text-align:center'><span
style='font-size:22.0pt;line-height:120%;font-family:"Franklin Gothic Medium","sans-serif"'>&nbsp;</span></p>

<p class=MsoNormal align=center style='text-align:center;punctuation-wrap:simple;
text-autospace:none;vertical-align:baseline'><b><span style='font-size:22.0pt;
line-height:120%;font-family:"Bernard MT Condensed","serif"'>PROPRIETARY AND CONFIDENTIAL</span></b></p>

<p class=MsoNormal align=center style='text-align:center'><span
style='font-size:22.0pt;line-height:120%;font-family:"Franklin Gothic Medium","sans-serif"'>&nbsp;</span></p>

</div>

<span style='font-size:22.0pt;line-height:120%;font-family:"Franklin Gothic Medium","sans-serif"'><br
clear=all style='page-break-before:always'>
</span>

<div class=WordSection2>

<p class=MsoNormal style='line-height:normal'>&nbsp;</p>

<p class=MsoNormal align=center style='text-align:center;line-height:normal'><a
name="_top"></a><span style='font-size:20.0pt;font-family:"Bodoni MT","serif"'>INFORMATION
DISCLAIMER</span></p>

<p class=MsoNormal style='line-height:normal'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify;line-height:normal'><span
style='font-family:"Franklin Gothic Book","sans-serif"'>Information in this
document CANNOT be considered a substitute for appropriate medical training. 
Practitioners who intend to treat patients in the field of sleep medicine
should only do so AFTER they have received appropriate medical training and
certification.  This document is intended to help practitioners broadly
understand the field of sleep medicine and is NOT ADEQUATE NOR INTENDED AS A
SUBSTITUTE FOR ADEQUATE MEDICAL TRAINING.  Medical information changes
constantly. Therefore, the information in this document should not be
considered current, complete, or exhaustive, nor should you rely on the
contents of this document to recommend a course of treatment for any
individual.  Individual facts and circumstances will determine the treatment
that is most appropriate for any particular patient.  </span></p>

<p class=MsoNormal style='text-align:justify;line-height:normal'><span
style='font-family:"Franklin Gothic Book","sans-serif"'>&nbsp;</span></p>

<p class=MsoNormal align=center style='text-align:center;line-height:normal'><span
style='font-size:20.0pt;font-family:"Bodoni MT","serif"'>COPYRIGHT NOTICE</span></p>

<p class=MsoNormal style='line-height:normal'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify;line-height:normal'><span
style='font-family:"Franklin Gothic Book","sans-serif"'>Information in this
document is proprietary and confidential to Dental Sleep Solutions ("DSS"). 
You are licensed to view this information as part of the services DSS provides
to you and in consideration for your fees within your agreement with DSS.  You
MAY NOT COPY, REPRODUCE, OR SHARE this material.  If you unlawfully copy,
reproduce, or share this material DSS will be harmed, and DSS will prosecute
you to the full extent of the law.</span></p>

<span style='font-size:12.0pt;font-family:"Calibri","sans-serif"'><br
clear=all style='page-break-before:always'>
</span>

<p class=MsoNormal style='line-height:normal'><span style='font-size:26.0pt;
font-family:"Franklin Gothic Medium","sans-serif";color:#17365D;letter-spacing:
.25pt'>&nbsp;</span></p>

<div style='border:none;border-bottom:solid #4F81BD 1.0pt;padding:0in 0in 4.0pt 0in;
margin-left:27.0pt;margin-right:0in'>

<p class=MsoTitle>Table of Contents</p>

</div>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoToc1><a
href="#_Toc351027132">1.<span style='font-size:11.0pt;line-height:120%;
font-family:"Calibri","sans-serif";color:windowtext;text-transform:none;
font-weight:normal;text-decoration:none'>     </span>Introduction<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>2</span></a></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027133">WELCOME TO DENTAL SLEEP SOLUTIONS<sup>&reg;</sup>!<span
style='color:windowtext;display:none;text-decoration:none'> </span><span
style='color:windowtext;display:none;text-decoration:none'>2</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027134">THE DENTAL SLEEP SOLUTIONS<sup>&reg;</sup>
MISSION STATEMENT<span style='color:windowtext;display:none;text-decoration:
none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>3</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027135">PATIENT RELATIONS<span style='color:windowtext;
display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>4</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027136">THE DENTAL SLEEP SOLUTIONS<sup>&reg;</sup>
TRADEMARK<span style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>7</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027137">YOUR STATUS AS A FRANCHISEE<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>9</span></a></span></p>

<p class=MsoToc3><a href="#_Toc351027138">Business Name<span style='color:windowtext;
display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>9</span></a></p>

<p class=MsoToc3><a href="#_Toc351027139">Checks, Stationery and Business Forms<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>10</span></a></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027140">YOUR FUNCTION AS THE OWNER/OPERATOR<span
style='color:windowtext;display:none;text-decoration:none'>.. </span><span
style='color:windowtext;display:none;text-decoration:none'>12</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027141">USE OF THIS FRANCHISE MANUAL<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>13</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027142">TRAINING PROGRAM<span style='color:windowtext;
display:none;text-decoration:none'>.. </span><span
style='color:windowtext;display:none;text-decoration:none'>14</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027143">NEW PRODUCTS OR SERVICES<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>16</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027144">COMMUNICATIONS<span style='color:windowtext;
display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>18</span></a></span></p>

<p class=MsoToc1><a href="#_Toc351027145">2.<span style='font-size:11.0pt;
line-height:120%;font-family:"Calibri","sans-serif";color:windowtext;
text-transform:none;font-weight:normal;text-decoration:none'>     </span>Prior
to Opening Your Franchised Business<span style='color:windowtext;display:none;
text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>21</span></a></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027146">TERRITORY<span style='color:windowtext;
display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>21</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027147">LICENSES &amp; REGULATIONS<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>23</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027148">INTERNET ACCESS<span style='color:windowtext;
display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>25</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027149">INSURANCE<span style='color:windowtext;
display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>26</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027150">PRE-OPENING CHECKLIST<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>28</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027151">ETHICS<span style='color:windowtext;
display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>30</span></a></span></p>

<p class=MsoToc3><a href="#_Toc351027152">Corporate Social Responsibility<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>30</span></a></p>

<p class=MsoToc1><a href="#_Toc351027153">3.<span style='font-size:11.0pt;
line-height:120%;font-family:"Calibri","sans-serif";color:windowtext;
text-transform:none;font-weight:normal;text-decoration:none'>     </span>Your
Employees<span style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>33</span></a></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027154">THE HIDDEN COSTS OF EMPLOYING<span
style='color:windowtext;display:none;text-decoration:none'>.. </span><span
style='color:windowtext;display:none;text-decoration:none'>33</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027155">TRAINING<span style='color:windowtext;
display:none;text-decoration:none'>.. </span><span
style='color:windowtext;display:none;text-decoration:none'>35</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027156">MORALE<span style='color:windowtext;
display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>37</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027157">RECOMMENDED STAFFING LEVELS<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>39</span></a></span></p>

<p class=MsoToc1><a href="#_Toc351027158">4.<span style='font-size:11.0pt;
line-height:120%;font-family:"Calibri","sans-serif";color:windowtext;
text-transform:none;font-weight:normal;text-decoration:none'>     </span>Business
Set-Up &amp; Operations<span style='color:windowtext;display:none;text-decoration:
none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>45</span></a></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027159">AN OVERVIEW OF THE<span style='color:windowtext;
display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>45</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027160">DENTAL SLEEP SOLUTIONS<sup>&reg;</sup> SYSTEM<span
style='color:windowtext;display:none;text-decoration:none'>.. </span><span
style='color:windowtext;display:none;text-decoration:none'>45</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027161">CALL CENTER/LEAD PROCESSING<span
style='color:windowtext;display:none;text-decoration:none'>.. </span><span
style='color:windowtext;display:none;text-decoration:none'>46</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027162">PRACTICE MANAGER SOFTWARE<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>47</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027163">DENTAL SLEEP PROCEDURES MANUAL<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>49</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027164">MATERIALS &amp; EQUIPMENT NEEDED TO OPEN
FOR BUSINESS<span style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>50</span></a></span></p>

<p class=MsoToc3><a href="#_Toc351027165">Recommended Vendors<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>50</span></a></p>

<p class=MsoToc3><a href="#_Toc351027166">Recommended Appliance
Manufacturers/Labs<span style='color:windowtext;display:none;text-decoration:
none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>51</span></a></p>

<p class=MsoToc3><a href="#_Toc351027167">Recommended Home Sleep Testing
Devices<span style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>53</span></a></p>

<p class=MsoToc3><a href="#_Toc351027168">Recommended Printing Services<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>54</span></a></p>

<p class=MsoToc3><a href="#_Toc351027169">Required Signage<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>55</span></a></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027170">DEALING WITH VENDORS<span style='color:
windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>56</span></a></span></p>

<p class=MsoToc3><a href="#_Toc351027171">Establishing &amp; Maintaining Vendor
Relations<span style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>56</span></a></p>

<p class=MsoToc3><a href="#_Toc351027172">Recommended Product Check-In Policies<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>56</span></a></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027173">YOUR RESPONSIBILITIES AS A FRANCHISE OWNER<span
style='color:windowtext;display:none;text-decoration:none'>.. </span><span
style='color:windowtext;display:none;text-decoration:none'>58</span></a></span></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027174">TRADEMARKED MERCHANDISE<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>60</span></a></span></p>

<p class=MsoToc1><a href="#_Toc351027175">5.<span style='font-size:11.0pt;
line-height:120%;font-family:"Calibri","sans-serif";color:windowtext;
text-transform:none;font-weight:normal;text-decoration:none'>     </span>Fees<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>62</span></a></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027176">SYSTEM LICENSE &amp; CASE MANAGEMENT FEES<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>62</span></a></span></p>

<p class=MsoToc3><a href="#_Toc351027177">System License Fee<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>62</span></a></p>

<p class=MsoToc3><a href="#_Toc351027178">Case Management Fee<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>62</span></a></p>

<p class=MsoToc1><a href="#_Toc351027179">6.<span style='font-size:11.0pt;
line-height:120%;font-family:"Calibri","sans-serif";color:windowtext;
text-transform:none;font-weight:normal;text-decoration:none'>     </span>Advertising<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>64</span></a></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027180">ADVERTISING - A GENERAL OVERVIEW<span
style='color:windowtext;display:none;text-decoration:none'>... </span><span
style='color:windowtext;display:none;text-decoration:none'>64</span></a></span></p>

<p class=MsoToc3><a href="#_Toc351027181">Advertising Program<span
style='color:windowtext;display:none;text-decoration:none'>.. </span><span
style='color:windowtext;display:none;text-decoration:none'>64</span></a></p>

<p class=MsoToc3><a href="#_Toc351027182">Purpose of Advertising<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>65</span></a></p>

<p class=MsoToc3><a href="#_Toc351027183">Creating the Ad Budget<span
style='color:windowtext;display:none;text-decoration:none'> </span><span
style='color:windowtext;display:none;text-decoration:none'>66</span></a></p>

<p class=MsoToc3><a href="#_Toc351027184">Selecting the Right Media<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>67</span></a></p>

<p class=MsoToc3><a href="#_Toc351027185">Newspapers<span style='color:windowtext;
display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>67</span></a></p>

<p class=MsoToc3><a href="#_Toc351027186">Radio<span style='color:windowtext;
display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>68</span></a></p>

<p class=MsoToc3><a href="#_Toc351027187">The Yellow Pages<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>68</span></a></p>

<p class=MsoToc3><a href="#_Toc351027188">Independent Local Directories<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>68</span></a></p>

<p class=MsoToc3><a href="#_Toc351027189">Direct Mail<span style='color:windowtext;
display:none;text-decoration:none'> </span><span
style='color:windowtext;display:none;text-decoration:none'>69</span></a></p>

<p class=MsoToc3><a href="#_Toc351027190">The Internet<span style='color:windowtext;
display:none;text-decoration:none'> </span><span
style='color:windowtext;display:none;text-decoration:none'>69</span></a></p>

<p class=MsoToc3><a href="#_Toc351027191">Public Speaking<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>69</span></a></p>

<p class=MsoToc3><a href="#_Toc351027192">The Best Advertisement There Is: You<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>69</span></a></p>

<p class=MsoToc3><a href="#_Toc351027193">Measuring Advertising Effectiveness<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>70</span></a></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027194">APPROVED ADVERTISING MATERIALS &amp;
PROMOTIONAL PROGRAMS<span style='color:windowtext;display:none;text-decoration:
none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>71</span></a></span></p>

<p class=MsoToc3><a href="#_Toc351027195">The Grand Opening<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>71</span></a></p>

<p class=MsoToc3><a href="#_Toc351027196">Ongoing Advertising/Promotion<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>71</span></a></p>

<p class=MsoToc3><a href="#_Toc351027197">Publicity<span style='color:windowtext;
display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>72</span></a></p>

<p class=MsoToc3><a href="#_Toc351027198">Publicity and How Publicity Programs
Work<span style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>72</span></a></p>

<p class=MsoToc3><a href="#_Toc351027199">The Basics<span style='color:windowtext;
display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>73</span></a></p>

<p class=MsoToc1><a href="#_Toc351027200">7.<span style='font-size:11.0pt;
line-height:120%;font-family:"Calibri","sans-serif";color:windowtext;
text-transform:none;font-weight:normal;text-decoration:none'>     </span>Appendix
A<span style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>76</span></a></p>

<p class=MsoToc2><span style='font-variant:normal !important;text-transform:
uppercase'><a href="#_Toc351027201">Dental Sleep SolutionS<sup>&reg;</sup> Forms<span
style='color:windowtext;display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>76</span></a></span></p>

<p class=MsoToc3><a href="#_Toc351027202">List of Forms<span style='color:windowtext;
display:none;text-decoration:none'>. </span><span
style='color:windowtext;display:none;text-decoration:none'>76</span></a></p>

<p class=MsoNormal><i><span style='line-height:120%;text-transform:uppercase'>&nbsp;</span></i></p>

</div>

<i><span style='font-size:12.0pt;line-height:120%;font-family:"Calibri","sans-serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></i>

<div class=WordSection3>

<p class=MsoNormal><img width=287 height=1072
src="includes/manual_operations_assets/image002.png"
align=left hspace=12 vspace=10
alt="Text Box: Operations&#13;&#10;Manual&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;Dental Sleep Solutions&reg;&#13;&#10;"></p>

<p class=MsoNormal><i><span style='line-height:120%;text-transform:uppercase'>&nbsp;</span></i></p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><span style='font-size:48.0pt;line-height:120%;font-family:
"Cambria","serif"'>&nbsp;</span></p>

<p class=MsoNormal><span style='font-size:36.0pt;line-height:120%;font-family:
"Cambria","serif"'>Section I</span></p>

<p class=MsoNormal><b><span style='font-size:28.0pt;line-height:120%;
font-family:"Cambria","serif"'>Introduction</span></b></p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoListParagraphCxSpFirst style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Welcome to Dental Sleep Solutions&reg;!</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Dental Sleep Solutions Mission Statement</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Patient Relations</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>The Dental Sleep Solutions&reg; Trademark</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Your Status as a Franchisee</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Business Name</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Checks, Stationery, and Business Forms</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Your Function as the Owner/Operator</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Use of this Operations Manual</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Training Program</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>New Products or Services</p>

<p class=MsoListParagraphCxSpLast style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Communications</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<span style='font-size:12.0pt;line-height:120%;font-family:"Calibri","sans-serif"'><br
clear=all style='page-break-before:always'>
</span>

<p class=MsoNormal><span style='font-size:26.0pt;line-height:120%;font-family:
"Franklin Gothic Medium","sans-serif";color:#17365D;letter-spacing:.25pt'>&nbsp;</span></p>

<div style='border:none;border-bottom:solid windowtext 3.0pt;padding:0in 0in 1.0pt 0in'>

<h1 style='border:none;padding:0in'><a name="_Toc351027132"></a><a
name="_Toc351024484"></a><a name="_Toc351024366"></a><a name="_Toc259183332">1.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span><strong><span style='font-family:"Cambria","serif"'>Introduction</span></strong></a></h1>

</div>

<h2><a name="_Toc351027133"></a><a name="_Toc351024485"></a><a
name="_Toc351024367"></a><a name="_Toc259183333">WELCOME TO DENTAL SLEEP
SOLUTIONS</a><sup>&reg;</sup>!</h2>

<h2><span style='font-size:9.0pt;line-height:120%'><img width=260 height=260
id="Picture 40"
src="includes/manual_operations_assets/image003.jpg"
alt="DSS Logo"></span></h2>

<p class=MsoNormal>            </p>

<p class=MsoNormal style='text-align:justify'><a name="_Toc259183334">&nbsp;</a></p>

<div>

<table cellspacing=0 cellpadding=0 hspace=0 vspace=0 align=left>
 <tr>
  <td valign=top align=left style='padding-top:0in;padding-right:0in;
  padding-bottom:0in;padding-left:0in'>
  <p class=MsoNormal style='text-align:justify;line-height:43.9pt;page-break-after:
  avoid;vertical-align:baseline'><span style='font-size:58.5pt'>O</span></p>
  </td>
 </tr>
</table>

</div>

<p class=MsoNormal style='text-align:justify'>n behalf of Dental Sleep
Solutions Franchising LLC, (&quot;DSS Franchising LLC&quot;), we welcome you to
the DENTAL SLEEP SOLUTIONS&reg; (&quot;DSS&quot;) family and network of
franchisees.  As you know, owning and managing your own business is a
gratifying experience.  But when that business is a franchise, you have the
added benefit of ongoing support, programs and systems that really make a
difference!</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Our goal is to provide a
comfortable treatment solution for the growing number of patients being
diagnosed with sleep apnea.  That means creating centers that utilize the
latest technology and a professional, consultative approach for treating
patients.  We want all of our franchisees to be committed to providing
individualized services in centers that reflect our commitment to this
burgeoning new field of dentistry.  And of course, we want our patients to be
so satisfied with their results that they recommend us to others.  In this
highly competitive field, we want to stand out -- to be the leader in each of
our markets -- and we're ready to help you achieve that goal!</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>We look forward to a long and
prosperous relationship.  Our success, yours <i>and </i>ours, is dependent on
us working as a team.  Your comments and suggestions are always welcome and we
encourage you to be active in our DENTAL SLEEP SOLUTIONS&reg; network.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Richard Drake                                     Gy
Yatros</p>

<p class=MsoNormal style='text-align:justify'>Manager Member                              Manager
Member</p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2 align=left style='text-align:left'><a name="_Toc351027134"></a><a
name="_Toc351024486"></a><a name="_Toc351024368">THE DENTAL SLEEP SOLUTIONS<sup>&reg;</sup>
</a>MISSION STATEMENT</h2>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><i><span style='font-size:16.0pt;
line-height:120%'>"Dental Sleep Solutions Franchising LLC exists to provide
member dentists with training, systems, and support to maximize patient
acceptance of oral appliance therapy and promote dental excellence."</span></i></p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc259183335"></a><a name="_Toc351027135"></a><a
name="_Toc351024487"></a><a name="_Toc351024369">PATIENT RELATIONS</a></h2>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>It is difficult to find and
establish a single universally accepted definition of what constitutes
excellent service.  Ask ten different people what the concept means to them,
and odds are you'll get ten different answers.  Not only are personal perceptions
different, but applications vary by business as well.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>DENTAL SLEEP SOLUTIONS&reg;'
philosophy of patient relations and quality service is built on the premise
that our <b>patients are our guests.</b>  They have <i>voluntarily chosen</i>
to patronize our business, despite having countless options and alternatives
available to them.  We want and need them to leave our franchise feeling as if
the decision they made was the right one.  More importantly, we want them to recommend
our services to others based on their experience.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>By treating patients as if they
were guests in our own homes, affording them the same courtesy, attention to
detail and care we would offer a relative or friend, we help to establish
ourselves as a place they want to do business with.  Atmosphere is important,
but history has proven time and time again that this quality is nowhere near
enough.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>To accomplish our overall
objective, we need to provide, on a daily basis, and without exception, each
and every patient with the following promises:</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>That they will be greeted in a warm and friendly manner by every
member of the staff that comes into contact with them, each of whom will be
well-groomed and properly dressed.</p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>That we will meet and exceed their expectations by providing only
the highest quality service. </p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>That we will at all times strive to anticipate their needs, and
to provide for those needs before they ask.</p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>That we stand committed to go the extra mile to make sure our
patients have the best possible experience.  </p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>That each and every patient will be assisted quickly,
enthusiastically, and attentively.  We never want anyone to feel that we are
taking their needs or satisfaction for granted.  Maintain eye contact with your
patients. Greet them by name whenever you can.  And most importantly, always
thank them for their patronage.   </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Each and every one of us, from
our franchisees to staff and even our suppliers, sit firmly on the front line
of our collective goal of achieving success.  Ours is a business with fierce
competition, and if we are to rise and stay above that competition, we need to
establish ourselves as the location of choice for all of our patients.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Think of each person who walks through
your door for the first time as a consumer whom you want to convert into a patient. 
To capture their loyalty, everyone involved with DENTAL SLEEP SOLUTIONS&reg; must
become an ambassador, to make each person feel important and welcomed - to let
them know that we appreciate the opportunity to serve them.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><b><i>As professionals, we work
hard every day to avoid and prevent problems, but when they do occur, we must
use them as an opportunity to show how and why we are better than everyone
else.  We must do everything in our power to correct problems, to make everything
right in the eyes of the patient.  When problems arise, we must all remember
that we have no wrong patients.  We only have patients that we have somehow
disappointed, and if we fail to address and correct their disappointment, all
we have accomplished is to make that patient</i></b> <b><i>available to our
competitors.  </i></b></p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>We must strive to consistently
offer our patients:</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;
</span></span><b>First rate service.</b></p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;
</span></span><b>Willing, genuine smiles.</b></p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;
</span></span><b>A clear understanding that we care.</b></p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;
</span></span><b>An atmosphere that allows people to relax and feel accepted.</b></p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;
</span></span><b>And a sparkling clean facility.</b></p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Our message to everyone will be
clear and unmistakable - <b>we are dedicated to being the best!</b></p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>To truly be the best, one of the
things we all need to do is develop our listening skills.  We have to encourage
people to talk to us, to train ourselves to listen to and hear what they have
to say, and to then learn from the information they give us.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Listen to patients if they
express opinions about what they see, or if they voice a request for something
you don't have.  Talk with your staff on a consistent basis, probing for
reactions and ideas that may improve the way we run our business.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>You never know where the next
great idea may come from.  We have developed an innovative, creative and
imaginative service concept, but we cannot ever delude ourselves into thinking
that it cannot still be improved.  Listen to what the people around you - the
people on whom your business is based - have to say, and when possible or
practical, act on their suggestions.  Doing so shows that you care, that you
take their opinions and suggestions seriously.  It will improve your standing
in their eyes, which in turn will help you to establish and grow a successful
business.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<div style='border:none;border-left:double windowtext 1.5pt;padding:0in 0in 0in 4.0pt;
margin-left:.5in;margin-right:0in'>

<p class=MsoNormal style='text-align:justify;border:none;padding:0in'><b><i>And
always remember: a satisfied customer will tell one or two people; a dissatisfied
customer will tell anyone who will listen! </i></b></p>

<p class=MsoNormal style='text-align:justify;border:none;padding:0in'><b><i>&nbsp;</i></b></p>

</div>

<p class=MsoNormal>When you lose a patient, odds are that you'll lose much more
than the one person you allowed to walk out your door dissatisfied.          </p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027136"></a><a name="_Toc351024488"></a><a
name="_Toc351024370">THE DENTAL SLEEP SOLUTIONS<sup>&reg;</sup> TRADEMARK</a> </h2>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>We have granted you the
non-exclusive right to use certain Marks under the Franchise Agreement.  You will
also be able to use future Marks that we develop to identify the goods and
services associated with the DENTAL SLEEP SOLUTIONS&reg; system.  Your right to use
the Marks is derived only from the Franchise Agreement and is limited to your
operating the Franchised Business according to the Franchise Agreement and all
System Standards we prescribe during its term.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>By Marks, we mean trade name,
trademark, service marks, logos, designs or other commercial symbols, URLs,
domain names, website addresses, email addresses, digital cellular addresses,
wireless web addresses and trade dress used to identify your DENTAL SLEEP
SOLUTIONS&reg; Franchised Business.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>The following Marks have been
registered with the United States Patent and Trademark Office (the <b>"USPTO</b>")
as indicated:</p>

<p class=MsoNormal>&nbsp;</p>

<div align=center>

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width=670
 style='width:401.85pt;border-collapse:collapse;border:none'>
 <thead>
  <tr style='height:5.8pt'>
   <td width=222 colspan=2 valign=bottom style='width:133.45pt;border:solid windowtext 1.0pt;
   padding:0in 5.4pt 0in 5.4pt;height:5.8pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>Mark</b></p>
   </td>
   <td width=158 colspan=2 valign=bottom style='width:94.5pt;border:solid windowtext 1.0pt;
   border-left:none;padding:0in 5.4pt 0in 5.4pt;height:5.8pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>Registration 
   No.</b></p>
   </td>
   <td width=142 valign=bottom style='width:85.25pt;border:solid windowtext 1.0pt;
   border-left:none;padding:0in 5.4pt 0in 5.4pt;height:5.8pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>Registration 
   Date</b></p>
   </td>
   <td width=148 valign=bottom style='width:88.65pt;border:solid windowtext 1.0pt;
   border-left:none;padding:0in 5.4pt 0in 5.4pt;height:5.8pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>Place of
   Registration</b></p>
   </td>
  </tr>
  <tr style='height:5.8pt'>
   <td width=219 valign=bottom style='width:131.4pt;border:solid windowtext 1.0pt;
   border-top:none;padding:0in 5.4pt 0in 5.4pt;height:5.8pt'>
   <p class=MsoNormal><b>Dental Sleep Solutions </b></p>
   <p class=MsoNormal><b>(Word Mark)</b></p>
   </td>
   <td width=158 colspan=2 valign=bottom style='width:94.5pt;border-top:none;
   border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
   padding:0in 5.4pt 0in 5.4pt;height:5.8pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>3,691,896</b></p>
   </td>
   <td width=146 colspan=2 valign=bottom style='width:87.3pt;border-top:none;
   border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
   padding:0in 5.4pt 0in 5.4pt;height:5.8pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>October 6, 2009</b></p>
   </td>
   <td width=148 valign=bottom style='width:88.65pt;border-top:none;border-left:
   none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
   padding:0in 5.4pt 0in 5.4pt;height:5.8pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>Principal
   Register</b></p>
   </td>
  </tr>
  <tr style='height:93.1pt'>
   <td width=219 valign=bottom style='width:131.4pt;border:solid windowtext 1.0pt;
   border-top:none;padding:0in 5.4pt 0in 5.4pt;height:93.1pt'>
   <p class=MsoNormal><img width=138 height=128 id="Picture 249"
   src="includes/manual_operations_assets/image004.png"></p>
   <p class=MsoNormal><b>(Composite Mark)</b></p>
   </td>
   <td width=158 colspan=2 valign=bottom style='width:94.5pt;border-top:none;
   border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
   padding:0in 5.4pt 0in 5.4pt;height:93.1pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>3,701,197</b></p>
   </td>
   <td width=146 colspan=2 valign=bottom style='width:87.3pt;border-top:none;
   border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
   padding:0in 5.4pt 0in 5.4pt;height:93.1pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>October 27,
   2009</b></p>
   </td>
   <td width=148 valign=bottom style='width:88.65pt;border-top:none;border-left:
   none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
   padding:0in 5.4pt 0in 5.4pt;height:93.1pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>Principal
   Register</b></p>
   </td>
  </tr>
  <tr style='height:44.5pt'>
   <td width=219 valign=bottom style='width:131.4pt;border:solid windowtext 1.0pt;
   border-top:none;padding:0in 5.4pt 0in 5.4pt;height:44.5pt'>
   <p class=MsoNormal><b>Virtual Sleep Solutions (Standard Character Claim)</b></p>
   </td>
   <td width=158 colspan=2 valign=bottom style='width:94.5pt;border-top:none;
   border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
   padding:0in 5.4pt 0in 5.4pt;height:44.5pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>3,788,445</b></p>
   </td>
   <td width=146 colspan=2 valign=bottom style='width:87.3pt;border-top:none;
   border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
   padding:0in 5.4pt 0in 5.4pt;height:44.5pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>May 11, 2010</b></p>
   </td>
   <td width=148 valign=bottom style='width:88.65pt;border-top:none;border-left:
   none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
   padding:0in 5.4pt 0in 5.4pt;height:44.5pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>Principal
   Register</b></p>
   </td>
  </tr>
  <tr style='height:53.95pt'>
   <td width=219 valign=bottom style='width:131.4pt;border:solid windowtext 1.0pt;
   border-top:none;padding:0in 5.4pt 0in 5.4pt;height:53.95pt'>
   <p class=MsoNormal><img width=114 height=125 id="Picture 250"
   src="includes/manual_operations_assets/image005.jpg"
   alt="ImageAgentProxy?getImage=77398171"></p>
   <p class=MsoNormal><b>Dental Sleep Solutions </b></p>
   <p class=MsoNormal><b>(Composite Mark)</b></p>
   </td>
   <td width=158 colspan=2 valign=bottom style='width:94.5pt;border-top:none;
   border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
   padding:0in 5.4pt 0in 5.4pt;height:53.95pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>3,668,258</b></p>
   </td>
   <td width=146 colspan=2 valign=bottom style='width:87.3pt;border-top:none;
   border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
   padding:0in 5.4pt 0in 5.4pt;height:53.95pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>August 18, 2009</b></p>
   </td>
   <td width=148 valign=bottom style='width:88.65pt;border-top:none;border-left:
   none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;
   padding:0in 5.4pt 0in 5.4pt;height:53.95pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>Principal Register</b></p>
   </td>
  </tr>
 </thead>
 <tr height=0>
  <td width=219 style='border:none'></td>
  <td width=3 style='border:none'></td>
  <td width=154 style='border:none'></td>
  <td width=3 style='border:none'></td>
  <td width=142 style='border:none'></td>
  <td width=148 style='border:none'></td>
 </tr>
</table>

</div>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><a name="_Toc259183336">We will give you artwork for our
logo(s); you must always use this artwork when creating promotional materials
or business cards/stationery.  The consistent look/color/style of our logo
across the franchise creates brand awareness which benefits us all. </a></p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027137"></a><a name="_Toc351024489"></a><a
name="_Toc351024371">YOUR STATUS AS A FRANCHISEE</a></h2>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Upon signing the Franchise
Agreement, you agreed not to represent yourself as an agent, employee, or
partner of Dental Sleep Solutions Franchising LLC, the franchisor.  While you
are enfranchised to use the "DENTAL SLEEP SOLUTIONS&reg;" name and logos in your
daily business operations, your status as an independent business and separate
legal entity must be made clear to the public.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>We  have created the following
policies to direct you in the proper use of the DENTAL SLEEP SOLUTIONS&reg; logo
and name in order to clearly indicate your status as a franchisee, as required
by your Franchise Agreement.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<h3 style='text-align:justify'><a name="_Toc351027138"></a><a
name="_Toc351024490"></a><a name="_Toc351024372"></a><a name="_Toc259183337">Business
Name</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>If you decide to incorporate, you
may not, under any circumstances, use the trademarks of the franchisor as part
of your <b>legal</b> business name.  Additionally, "DENTAL SLEEP SOLUTIONS&reg;"
may only be used when referring to:  (1) the<span style='color:red'> </span>products
or services, (2) the Franchisor, or (3) a DENTAL SLEEP SOLUTIONS&reg; Management
opportunity.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Whether you are a sole
proprietorship, partnership, LLC or corporation, you must operate your business
under the trade name DENTAL SLEEP SOLUTIONS&reg; or if use of an exclusive trade
name is prohibited, under your  license, use as permitted.  In addition, you
may be required by the county, city, or state to register your fictitious name,
also known as a "DBA" (Doing Business As).</p>

<p class=MsoNormal style='text-align:justify'>                             </p>

<p class=MsoNormal style='text-align:justify'>Filing procedures vary in
different parts of the country.  In many states, you need only go to the county
offices and pay a registration fee to the county clerk.  Some states have Town
Clerks that perform the same function, while other states require placing a
fictitious-name ad in a local newspaper.  Generally, the newspaper that prints
the legal notice for your business name will file the necessary papers with the
county for a small fee.  The cost of filing a fictitious-name notice ranges
from $10 to $100.  The easiest way to determine the procedure for your area is
to call your bank and ask if it requires a fictitious-name registry or
certificate in order to open a business account.  If so, inquire where you
should go to obtain one.<br clear=all style='page-break-before:always'>
</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><b>&nbsp;</b></p>

<p class=MsoNormal align=center style='text-align:center'><b>Business Name
Examples</b></p>

<p class=MsoNormal>

<table cellpadding=0 cellspacing=0 align=left>
 <tr>
  <td width=948 height=40></td>
 </tr>
 <tr>
  <td></td>
  <td><img width=3 height=31
  src="includes/manual_operations_assets/image006.png"></td>
 </tr>
</table>

 &nbsp;</p>

<br clear=ALL>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none'>
 <tr>
  <td width=369 style='width:221.4pt;border:solid black 1.0pt;background:black;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:18.0pt;line-height:120%;color:white'>ACCEPTABLE</span></b></p>
  </td>
  <td width=369 style='width:221.4pt;border:solid black 1.0pt;border-left:none;
  background:black;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b><span
  style='font-size:18.0pt;line-height:120%;color:white'>UNACCEPTABLE</span></b></p>
  </td>
 </tr>
 <tr>
  <td width=369 style='width:221.4pt;border:solid black 1.0pt;border-top:none;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b>Sunshine
  Corporation</b></p>
  <p class=MsoNormal align=center style='text-align:center'><b>d/b/a </b><b>DENTAL
  SLEEP SOLUTIONS</b></p>
  </td>
  <td width=369 style='width:221.4pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b>DENTAL SLEEP
  SOLUTIONS, Inc</b>.</p>
  </td>
 </tr>
 <tr>
  <td width=369 style='width:221.4pt;border:solid black 1.0pt;border-top:none;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'>&nbsp;</p>
  </td>
  <td width=369 style='width:221.4pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b>DENTAL SLEEP
  SOLUTIONS Sunshine Corporation</b></p>
  </td>
 </tr>
 <tr>
  <td width=369 style='width:221.4pt;border:solid black 1.0pt;border-top:none;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'>&nbsp;</p>
  </td>
  <td width=369 style='width:221.4pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal align=center style='text-align:center'><b>DENTAL SLEEP
  SOLUTIONS</b></p>
  <p class=MsoNormal align=center style='text-align:center'><b>of Anywhere,
  Inc.</b></p>
  </td>
 </tr>
</table>

<p class=MsoNormal>&nbsp;</p>

<b><u><span style='font-size:16.0pt;line-height:120%;font-family:"Cambria","serif"'><br
clear=all style='page-break-before:always'>
</span></u></b>

<h3 style='text-align:justify'><a name="_Toc351027139"></a><a
name="_Toc351024491"></a><a name="_Toc351024373"></a><a name="_Toc259183338">Checks,
Stationery and Business Forms</a></h3>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Dental Sleep Solutions
Franchising LLC has designed a distinctive logo to use on your checks,
letterhead, forms and business cards to establish immediate recognition of your
status as a DENTAL SLEEP SOLUTIONS&reg; franchise owner; however, your personal
identification must always be included when you use the DENTAL SLEEP SOLUTIONS&reg;
and logo.  For example, your business card may read:</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><span style='position:relative;
z-index:251652608;left:-5px;top:68px;width:716px;height:237px'>

<table cellpadding=0 cellspacing=0 align=left>
 <tr>
  <td width=0 height=0></td>
  <td width=329></td>
  <td width=58></td>
  <td width=329></td>
 </tr>
 <tr>
  <td height=169></td>
  <td align=left valign=top><img width=329 height=169
  src="includes/manual_operations_assets/image007.png"
  alt="Text Box: DENTAL SLEEP SOLUTIONS&#13;&#10;Independently owned and operated by Sunshine Corporation&#13;&#10;"></td>
  <td></td>
  <td align=left valign=top><img width=329 height=169
  src="includes/manual_operations_assets/image008.png"
  alt="Text Box: DENTAL SLEEP SOLUTIONS&#13;&#10;of Anywhere&#13;&#10;John Doe, Franchise Owner&#13;&#10;"></td>
 </tr>
</table>

</span>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<br clear=ALL>

<p class=MsoNormal style='text-align:justify'>All business forms must clearly
indicate that you are an independent owner of a DENTAL SLEEP SOLUTIONS&reg;
franchise.  Remember that all printed materials you develop must be reviewed
and approved by Dental Sleep Solutions Franchising LLC before they are put to
use.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Additionally, there may be
restrictions put forth by your state's licensing agency regarding the use of
business names; be sure that you are aware of, and comply with, all state and
local regulations. </p>

<p class=MsoNormal>&nbsp;</p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027140"></a><a name="_Toc351024492"></a><a
name="_Toc351024374"></a><a name="_Toc259183339">YOUR FUNCTION AS THE
OWNER/OPERATOR</a></h2>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>As the owner/operator of a DENTAL
SLEEP SOLUTIONS&reg; facility, you are responsible for controlling the operation of
your franchised business.  You will be working closely with DENTAL SLEEP
SOLUTIONS&reg; operations personnel, who we have carefully hired and trained to be
an effective extension of your management team.   </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Notwithstanding the assistance we
will provide you, you alone must control the various aspects of your business
if you are going to be successful.  You will have to make numerous decisions
every day.  You will have to control how the money is being spent and how to
develop new business; you will have to supervise your staff as they interact
with your dental sleep medicine patients and ensure patient satisfaction on a
daily basis.  You have bought a credible business system, one that affords you
access to an experienced and knowledgeable team of corporate managers and
franchise representatives, <i>but there is only so much we can do for you
beyond offering advice and counsel. </i></p>

<p class=MsoNormal style='text-align:justify'><i>&nbsp;</i></p>

<p class=MsoNormal style='text-align:justify'><i>You </i>are the key person in
your operation, and your judgment, business ability, and effort will have more
to do with your business's success or failure than anything else.  You will
need to operate your facility within its means; make good hiring decisions; and
make sure your patients are being taken care of at all times.  A clean, safe
office, staffed by friendly, well-trained and knowledgeable people, will set
you apart from your would-be competitors.  Set the example you want to have
followed by your staff.  The old theory of management by means of &quot;do as I
say, not as I do," does not, never has, and never will work.  Believe it.  </p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027141"></a><a name="_Toc351024493"></a><a
name="_Toc351024375"></a><a name="_Toc259183340">USE OF THIS FRANCHISE MANUAL</a></h2>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>This Manual and its related
Sub-Manuals, plus the documents provided through our web-based software, contain
all of the forms, procedures, philosophy and instruction you will need to
operate your DENTAL SLEEP SOLUTIONS&reg; Franchise.  Even if you have had no prior
experience in the field of dental sleep medicine, after completing our training
program and familiarizing yourself with the contents of this Manual, you should
be prepared to handle most any eventuality.  If you have a problem that is not
covered in this Operations Manual, or need further clarification on something,
please call your franchise representative.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>The Manual has been divided into
sections, each of which cover specific topics related to the set up and smooth
operation of your franchised business.  You will find guidelines on the use of
our trademark, details related to your territory and an outline of our
advertising program.  Also included are outlines for every patient appointment
with its related forms and software driven process. You will also find
guidelines for vendor and patient relations.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>While all of this information has
been developed by the company's founders, we must all remain aware that the
operating policies and conditions of any successful business will change in the
future.  For that reason, DENTAL SLEEP SOLUTIONS&reg; reserves the right to make
procedural and policy changes in this Manual, which will become effective immediately
and will be available online immediately following the change.  To the extent
possible, any such changes will be implemented when it is deemed to be mutually
beneficial to both franchisees and DENTAL SLEEP SOLUTIONS&reg;.  In the meantime,
all comments and suggestions from franchisees as to improvements in operations,
sales, or policies and procedures are encouraged.  Only by working together
with mutual respect and trust can we build a lasting and successful
relationship.</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027142"></a><a name="_Toc351024494"></a><a
name="_Toc351024376"></a><a name="_Toc259183341">TRAINING PROGRAM</a></h2>

<p class=MsoNormal style='text-align:justify'><span style='line-height:120%'>&nbsp;</span></p>

<p class=MsoNormal style='text-align:justify'><span style='line-height:120%'>&nbsp;</span></p>

<p class=MsoNormal style='text-align:justify'><span style='line-height:120%'>The
DENTAL SLEEP SOLUTIONS&reg; Credentialing Program may include a combination of webinars,
online video streaming, in the classroom, and on-the-job training, all to be
conducted in Manatee, Florida and/or your office and/or a facility near you.  You
will receive hands-on sales, management, and operations training under actual
working conditions, and we encourage you to also study this Manual to
familiarize yourself with our franchise operations details.</span></p>

<p class=MsoNormal style='text-align:justify'><span style='line-height:120%'>&nbsp;</span></p>

<p class=MsoNormal style='text-align:justify'><span style='line-height:120%'>Total
training time is expected in most cases to be about 3 days, but can be extended
or reduced as needed, at our discretion.  Only when both you and Dental Sleep
Solutions&reg; Franchising LLC are confident that all items have been covered and
fully understood will the initial training program end.  </span></p>

<p class=MsoNormal style='text-align:justify'><span style='line-height:120%'>&nbsp;</span></p>

<p class=MsoNormal style='text-align:justify'><span style='line-height:120%'>Upon
completion of the program, our mutual efforts will be directed to getting your DENTAL
SLEEP SOLUTIONS&reg; office ready for business.  Close communication and
consultation during those next several weeks will help to extend and reinforce
the training you will have received, and help to further prepare you for
actually operating your own business.  We will do everything possible to assure
your success.</span></p>

<p class=MsoNormal style='text-align:justify'><span style='line-height:120%'>&nbsp;</span></p>

<p class=MsoNormal style='text-align:justify'><span style='line-height:120%'>At
all other times, we urge you to call us whenever problems arise.  We want to
hear from you because, remember, this relationship only works if it is a
mutually beneficial one.  By helping you to succeed will we be able to continue
growing as well.</span></p>

<span style='font-size:12.0pt;font-family:"Calibri","sans-serif"'><br
clear=all style='page-break-before:always'>
</span>

<p class=MsoNormal style='line-height:normal'>&nbsp;</p>

<p class=MsoNormal><b><span style='font-size:14.0pt;line-height:120%'>Dental
Sleep Solutions&reg; Credentialing Program Schedule</span></b></p>

<p class=MsoNormal><b><span style='font-size:14.0pt;line-height:120%'>&nbsp;</span></b></p>

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 align=left
 width=756 style='width:6.3in;border-collapse:collapse;border:none;margin-left:
 7.55pt;margin-right:7.55pt'>
 <thead>
  <tr style='height:20.0pt'>
   <td width=263 style='width:157.5pt;border:solid black 1.0pt;background:#CCCCCC;
   padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>Subject</b></p>
   </td>
   <td width=128 style='width:76.5pt;border:solid black 1.0pt;border-left:none;
   background:#CCCCCC;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>Hours of Training</b></p>
   </td>
   <td width=128 style='width:76.5pt;border:solid black 1.0pt;border-left:none;
   background:#CCCCCC;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>Hours of
   On-The-Job Training</b></p>
   </td>
   <td width=239 style='width:143.1pt;border:solid black 1.0pt;border-left:
   none;background:#CCCCCC;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
   <p class=MsoNormal align=center style='text-align:center'><b>Location</b></p>
   </td>
  </tr>
 </thead>
 <tr style='height:20.0pt'>
  <td width=263 style='width:157.5pt;border:solid black 1.0pt;border-top:none;
  background:white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>Introduction to
  Sleep Medicine &amp;</p>
  <p class=MsoNormal align=center style='text-align:center'>Sleep Disordered
  Breathing</p>
  </td>
  <td width=128 style='width:76.5pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>7</p>
  </td>
  <td width=128 style='width:76.5pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>2</p>
  </td>
  <td width=239 style='width:143.1pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>Manatee County,
  Florida or Your Office or Mutually agreed upon location,</p>
  <p class=MsoNormal align=center style='text-align:center'>Or Online</p>
  </td>
 </tr>
 <tr style='height:20.0pt'>
  <td width=263 style='width:157.5pt;border:solid black 1.0pt;border-top:none;
  background:white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>Dental Devices</p>
  </td>
  <td width=128 style='width:76.5pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>3</p>
  </td>
  <td width=128 style='width:76.5pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>2</p>
  </td>
  <td width=239 style='width:143.1pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>Manatee County,
  Florida or Your Office or Mutually agreed upon location,</p>
  <p class=MsoNormal align=center style='text-align:center'>Or Online</p>
  </td>
 </tr>
 <tr style='height:20.0pt'>
  <td width=263 style='width:157.5pt;border:solid black 1.0pt;border-top:none;
  background:white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>Patient Treatment
  Steps</p>
  </td>
  <td width=128 style='width:76.5pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>2</p>
  </td>
  <td width=128 style='width:76.5pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>2</p>
  </td>
  <td width=239 style='width:143.1pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>Manatee County,
  Florida or Your Office or Mutually agreed upon location,</p>
  <p class=MsoNormal align=center style='text-align:center'>Or Online</p>
  </td>
 </tr>
 <tr style='height:20.0pt'>
  <td width=263 style='width:157.5pt;border:solid black 1.0pt;border-top:none;
  background:white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>Polysomnograph (PSG)
  &amp; Home Sleep Testing (HST)</p>
  </td>
  <td width=128 style='width:76.5pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>2</p>
  </td>
  <td width=128 style='width:76.5pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>1</p>
  </td>
  <td width=239 style='width:143.1pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>Manatee County,
  Florida or Your Office or Mutually agreed upon location,</p>
  <p class=MsoNormal align=center style='text-align:center'>Or Online</p>
  </td>
 </tr>
 <tr style='height:20.0pt'>
  <td width=263 style='width:157.5pt;border:solid black 1.0pt;border-top:none;
  background:white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>Insurance &amp;
  Medical Billing</p>
  </td>
  <td width=128 style='width:76.5pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>2</p>
  </td>
  <td width=128 style='width:76.5pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>2</p>
  </td>
  <td width=239 style='width:143.1pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>Manatee County,
  Florida or Your Office or Mutually agreed upon location,</p>
  <p class=MsoNormal align=center style='text-align:center'>Or Online</p>
  </td>
 </tr>
 <tr style='height:20.0pt'>
  <td width=263 style='width:157.5pt;border:solid black 1.0pt;border-top:none;
  background:white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>Marketing</p>
  </td>
  <td width=128 style='width:76.5pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>2</p>
  </td>
  <td width=128 style='width:76.5pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>1</p>
  </td>
  <td width=239 style='width:143.1pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>Manatee County,
  Florida or Your Office or Mutually agreed upon location,</p>
  <p class=MsoNormal align=center style='text-align:center'>Or Online</p>
  </td>
 </tr>
 <tr style='height:20.0pt'>
  <td width=263 style='width:157.5pt;border:solid black 1.0pt;border-top:none;
  background:white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>DSS Franchise &amp;
  Software</p>
  </td>
  <td width=128 style='width:76.5pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>5</p>
  </td>
  <td width=128 style='width:76.5pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>2</p>
  </td>
  <td width=239 style='width:143.1pt;border-top:none;border-left:none;
  border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:
  white;padding:0in 5.4pt 0in 5.4pt;height:20.0pt'>
  <p class=MsoNormal align=center style='text-align:center'>Manatee County,
  Florida or Your Office or Mutually agreed upon location,</p>
  <p class=MsoNormal align=center style='text-align:center'>Or Online</p>
  </td>
 </tr>
</table>

<p class=MsoNormal><a name="_Toc259183342">&nbsp;</a></p>

<span style='font-size:12.0pt;font-family:"Calibri","sans-serif"'><br
clear=all style='page-break-before:always'>
</span>

<p class=MsoNormal style='line-height:normal'>&nbsp;</p>

<h2><a name="_Toc351027143"></a><a name="_Toc351024495"></a><a
name="_Toc351024377">NEW PRODUCTS OR SERVICES</a></h2>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>From time to time, we may offer
our franchisees new and additional products or services, thus helping you to
secure your marketplace by providing your patients with additional, yet
compatible reasons to come to your office.  Similarly, if you find a new
product or service that you feel is compatible with our business and that you
would like to offer to your patients, we invite and encourage you to send this
information to us.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>We will evaluate your suggestion
on the basis of compatibility with our core business, the ease with which it
may be introduced into all units, and for any issues having to do with the
various legal agreements that bind us all together.  We will also evaluate the
suggestion on the basis of product or service cost, availability, market
acceptance, and where appropriate, the supplier or manufacturer's product
liability and overall service.  If it appears that your suggestion is workable
within the framework of the Dental Sleep Solutions Franchising LLC system, we
will approve your request and assist all units in implementing whatever changes
result.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>While we have to reserve the
right to make the final determination on any such new products or services, the
more ideas we all have to work with, the better the chance of finding something
that can benefit everyone.  Listen to what your patients say or ask for; keep
an eye on what your competitors are doing.  After all, none of us really know
for sure where the next great idea is going to come from, and the more sources
we have at our disposal, the better the odds of finding something that can help
us all.  </p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027144"></a><a name="_Toc351024496"></a><a
name="_Toc351024378"></a><a name="_Toc259183343">COMMUNICATIONS</a></h2>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>We may periodically visit you at your
office in order to help you stay on top of new business situations, and to
provide you with continuous support and guidance.  Our visits, whenever
possible, will be scheduled in advance, will generally be informal in nature,
and where practical or possible, agendas for the visit will be sent to you in
advance.  Topics may include such things as the general condition of your
business, new corporate policies and procedures, or simply to assist you with
any problems you may be encountering.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>As a DENTAL SLEEP SOLUTIONS&reg;
franchisee, you are encouraged to communicate your ideas and concerns openly
and freely through any of the company management team members.  Don't view
these visits with apprehension; view them as opportunities.  Hopefully our relationship
will be congenial enough to make them social occasions as well as productive
business discussions.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>We urge you to communicate our
visits to your staff in advance of our arrival.  The appearance of an
unannounced company representative in your office can be somewhat unsettling
for someone who doesn't know what's going on.  We will be there to help you. 
It will be a much healthier environment for all of us if your people know that
ahead of time.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>We would also ask that when we
visit your office, arrangements be made that will allow us to meet without
significant distraction or interruption.  Our meetings may include such topics
as overall appearance of your office, patient relations, management and sales,
or profit maximization, among the many possibilities.  Conducting such
discussions within earshot of employees and patients may be inefficient, less
than confidential, and when all is said and done, unproductive.  Let's work
together to use our time wisely so that we may both maximize the benefit of our
relationship. </p>

<p class=MsoNormal style='text-align:justify'><span style='color:red'>&nbsp;</span></p>

<p class=MsoNormal style='text-align:justify'>DENTAL SLEEP SOLUTIONS&reg; believes your
staff is an integral part of this program and that communication with them is
at all times critical to our continued success and growth.  As such, we support
and are committed to the following philosophy:</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<ol style='margin-top:0in' start=1 type=1>
 <li class=MsoNormal style='text-align:justify'><i>To maintain an environment
     where staff can openly communicate suggestions and ideas, ask questions
     freely, and express their interests and concerns.</i></li>
 <li class=MsoNormal style='text-align:justify'><i>To provide vehicles for
     straightforward communications between staff and management.</i></li>
 <li class=MsoNormal style='text-align:justify'><i>To keep the staff informed,
     as appropriate, of developments within the company that affect them.</i></li>
 <li class=MsoNormal style='text-align:justify'><i>To actively listen to their
     suggestions and concerns and respond appropriately.</i></li>
</ol>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Periodic staff meetings are an
effective means for generating dialogue and establishing camaraderie between
management and staff.  Staff meetings can be used to disseminate information,
to provide general training, to seek input or ideas, and to recognize or reward
individual or group achievements.  Properly planned and structured, they can be
great tools for building the concept of a unified team.  </p>

<span style='font-size:12.0pt;line-height:120%;font-family:"Calibri","sans-serif"'><br
clear=all style='page-break-before:always'>
</span>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><img width=287 height=1100
src="includes/manual_operations_assets/image009.png"
align=left hspace=12 vspace=10
alt="Text Box: Operations&#13;&#10;Manual&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;Dental Sleep Solutions&reg;&#13;&#10;&#13;&#10;"></p>

<p class=MsoNormal><span style='font-size:36.0pt;line-height:120%;font-family:
"Cambria","serif"'>&nbsp;</span></p>

<p class=MsoNormal><span style='font-size:36.0pt;line-height:120%;font-family:
"Cambria","serif"'>&nbsp;</span></p>

<p class=MsoNormal><span style='font-size:36.0pt;line-height:120%;font-family:
"Cambria","serif"'>&nbsp;</span></p>

<p class=MsoNormal><span style='font-size:36.0pt;line-height:120%;font-family:
"Cambria","serif"'>Section II</span></p>

<p class=MsoNormal><b><span style='font-size:28.0pt;line-height:120%;
font-family:"Cambria","serif"'>Prior to Opening Your Franchised Business</span></b></p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoListParagraphCxSpFirst style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Territory</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Licenses &amp; Regulations</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Internet Access</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Insurance</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Pre-Opening Checklist</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Ethics</p>

<p class=MsoListParagraphCxSpLast style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Corporate Social Responsibility</p>

<p class=MsoNormal>&nbsp;</p>

<span style='font-size:12.0pt;line-height:120%;font-family:"Calibri","sans-serif"'><br
clear=all style='page-break-before:always'>
</span>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<div style='border:none;border-bottom:solid windowtext 3.0pt;padding:0in 0in 1.0pt 0in'>

<h1 style='border:none;padding:0in'><a name="_Toc351027145"></a><a
name="_Toc351024497"></a><a name="_Toc351024379"></a><a name="_Toc259183360">2.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span>Prior to Opening Your Franchised Business</a></h1>

</div>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>This section contains information
regarding specific contractual obligations under your Franchise Agreement.  Be
sure to retain appropriate legal or accounting professionals for specific questions
or issues related to this process.</p>

<p class=MsoNormal style='text-align:justify'><span style='color:red'>&nbsp;</span></p>

<h2><a name="_Toc351027146"></a><a name="_Toc351024498"></a><a
name="_Toc351024380">TERRITORY</a></h2>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>You may or may not have not
received an exclusive territory and therefore, you may face competition from
other franchisees, from businesses that we own, or from other channels of
distribution or from other competitive brands that we control. We have granted
you the right to operate the Franchised Business at the location specified in
your Franchise Agreement.  If you choose to relocate the Franchised Business,
you may do so with our permission. </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>We have the right to establish
other businesses using the DENTAL SLEEP SOLUTIONS&reg;' System and the Marks at any
location. You will not have any options, rights of first refusal or similar
rights to acquire additional franchises. </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>We retain the right to develop,
use and license the use of proprietary marks other than those used with the
System for the sale of similar or different products and services, on any terms
and conditions we may deem advisable. We also retain the right to use other
channels of distribution, without granting you any rights or paying you any
compensation from these sales. We reserve the right to make sales via
alternative channels of distribution, including the Internet. Any marketing
through the internet or e commerce must be approved by DSS prior to use.  You
may use alternative channels of distribution to solicit patients, telemarketing
or other direct marketing to make sales. We may solicit and accept patients
from anywhere as permitted by law. You may solicit and accept patients from
anywhere as permitted by law.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>There is no minimum sales quota.
The continuation of the Franchised Business does not depend on the achievement
of any particular sales volume, market penetration, or other contingency.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027147"></a><a name="_Toc351024499"></a><a
name="_Toc351024381">LICENSES &amp; REGULATIONS</a></h2>

<p class=MsoBodyText2 style='line-height:normal'>&nbsp;</p>

<p class=MsoBodyText2 style='text-align:justify;line-height:normal'>You must
secure and maintain in force in your name all required licenses, permits, and
certificates relating to the operation of your DENTAL SLEEP SOLUTIONS&reg;
Franchised Business.  You also agree to open and operate the Franchised
Business in compliance with all applicable laws, ordinances, and regulations.</p>

<p class=MsoNormal style='text-align:justify'><b><span style='line-height:120%;
color:black'>&nbsp;</span></b></p>

<p class=MsoNormal style='text-align:justify'><span style='line-height:120%'>You
must meet and maintain the highest standards of safety applicable to the
operation of your DENTAL SLEEP SOLUTIONS&reg; business and the performance of
patient services, as we reasonably require. You must maintain your DENTAL SLEEP
SOLUTIONS&reg; facility in the highest degree of repair, sanitation, and security as
stated in this Manual. You must meet and maintain the highest health standards
and ratings applicable to operating your business.  Should you receive a
violation or citation which indicates your failure to maintain local health or
safety standards, you must furnish a copy of it to us within 24 hours after
receipt.</span></p>

<p class=MsoNormal style='text-align:justify'><span style='line-height:120%'>&nbsp;</span></p>

<p class=MsoNormal style='text-align:justify'>In addition to licenses and
permits, there are other regulations that may apply to your practice, and you
should become familiar with them prior to offering dental sleep therapy
services under the DENTAL SLEEP SOLUTIONS&reg; name.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>For example, there are federal
and state laws in existence which are designed to encourage competition by
prohibiting practices such as contracts and conspiracies in restraint of
trade.  Others prohibit discrimination in price between different purchasers of
commodities similar in grade and quality that may injure competition, while
another fairly common statute forbids the sale of any article at less than the
seller's cost if the intent is to injure competitors. </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>In most places, it is unlawful to
engage in unfair or deceptive practices.  The term &quot;deceptive
practices&quot; refers to false advertising, misrepresentation, simulation of
competitive products, and falsely denigrating competitors.  Other laws deal
with &quot;bait-and-switch&quot; selling, withholding appropriate refunds on
deposits made by patients, misrepresenting warranties and guarantees, and
quality requirements for certain products.  Even on violations by a
manufacturer or distributor, a business may be considered equally liable if he
knowingly accepts an illegal concession offered by the vendor.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Additionally, any firm conducting
business across state lines, or that advertises in more than one state, is
subject to federal regulations - usually those of the Federal Trade Commission
(FTC) -- as well as other state licensing requirements.  Because of the
complexities of these regulations and the penalties imposed for violations, it
is essential that you consult a lawyer to determine if your practice may be
subject to them.</p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027148"></a><a name="_Toc351024500"></a><a
name="_Toc351024382">INTERNET ACCESS</a></h2>

<p class=MsoNormal><span style='color:#0070C0'>&nbsp;</span></p>

<p class=MsoNormal style='text-align:justify'>The DENTAL SLEEP SOLUTIONS&reg;
franchise has a proprietary, web-based software program that all franchisees
must access via the internet in order to provide dental sleep therapy services
and manage patients appropriately.  Therefore, we require all franchisees to
have high speed internet access throughout their offices, and desktop or laptop
computers with internet access in patient rooms where dental sleep services are
being discussed, reviewed and evaluated.  This capability will allow the
dentist and his/her staff to access and update patient records during exams to
activate specific activities and communications at the DSS Franchising LLC
offices. In addition, it is required that you utilize either the Firefox or
Google Chrome web browsers, in their most current release.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoBodyText style='text-align:justify'><span style='font-family:"Calibri","sans-serif"'>Costs
vary geographically for internet services from $100 to $200 to install and $50
to $150 per month for the subscription fee.  When seeking these services, it is
best to contact several providers and determine which one is most appropriate and
cost effective for your practice.   In most cases the Internet access line can
provide online access by using your dedicated fax line or one of your phone
lines without impacting use of those lines.  This would be a cost savings.</span></p>

<p class=MsoNormal style='text-align:justify'><b>&nbsp;</b></p>

<p class=MsoNormal><b>&nbsp;</b></p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc259183379"></a><a name="_Toc351027149"></a><a
name="_Toc351024501"></a><a name="_Toc351024383">INSURANCE</a></h2>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><a name="_Toc259183380">You must
obtain and maintain insurance for the performance of dental sleep medicine, at
your expense, as required by law or otherwise.  If you fail to purchase the
mandatory insurance, we will terminate your Franchise Agreement.  All insurance
policies must name us and any affiliates that we designate as additional
insureds and give us at least 30 days' prior written notice of termination,
amendment, or cancellation. You must provide us with certificates of insurance
evidencing your insurance coverage no later than 10 days before your Franchised
Business opens and then, at least annually, or otherwise upon request by Dental
Sleep Solutions Franchising LLC, you must provide a copy of the certificate of
renewal or other evidence of the renewal, existence or extension of these insurance
policies. </a></p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>With respect to all insurable
properties, you must maintain all-risk property insurance against loss or
damage to business personal property of the Franchised Business in amounts not
less than the replacement cost of such property. </p>

<p class=MsoNormal style='text-align:justify'>            </p>

<p class=MsoNormal style='text-align:justify'>You must maintain commercial
general liability insurance, including premise liability,
products/completed-operations and contractual liability, against claims for
bodily injury or property damage caused by you as a result of the operation of
the Franchised Business and pursuant to your Agreement in amounts not less than
$1,000,000.00 for each occurrence and $2,000,000.00 general aggregate. Coverage
must be written on an occurrence form only; not claims-made. </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>You must maintain automobile
liability insurance against claims for personal injury, death or property
damage occurring as a result of your maintenance or operation of any
automobiles, trucks or other vehicles in an amount not less than $1,000,000.00
Combined Single Limit. </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>You must maintain professional
liability coverage, in amounts not less than $1,000,000.00 for each occurrence
and $3,000,000.00 general aggregate. Coverage must be written on an occurrence
form only; not claims-made.</p>

<p class=MsoNormal style='text-align:justify'> </p>

<p class=MsoNormal style='text-align:justify'>You must maintain worker's
compensation insurance, in such amounts as may now or later be required by any
applicable law, and you must withhold and pay any and all amounts required to
be paid for unemployment compensation, disability, social security, and other
such taxes imposed upon you as an employer. </p>

<p class=MsoNormal style='text-align:justify'> </p>

<p class=MsoNormal style='text-align:justify'>All policies of liability
insurance must insure Dental Sleep Solutions Franchising LLC as an additional
insured and must protect us against any liability that may accrue by reason of your
ownership, maintenance or operation the Franchised Business.  </p>

<p class=MsoNormal style='text-align:justify'> </p>

<p class=MsoNormal style='text-align:justify'>We reserve the right to increase
the minimum limits as well as to change or add new types of required coverage. </p>

<p class=MsoNormal> </p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027150"></a><a name="_Toc351024502"></a><a
name="_Toc351024384">PRE-OPENING CHECKLIST</a></h2>

<p class=MsoNormal><span style='color:#0070C0'>&nbsp;</span></p>

<p class=MsoNormal style='text-align:justify'>The list below is provided as a
way to guide you in tracking those things you need to do before you begin to
offer dental sleep therapy services.  While the list is fairly comprehensive,
it is by no means to be taken as all-inclusive.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Local laws, regulations and
ordinances may very well require that additional tasks be performed, or that
additional permits be obtained.  <i>Remember, it is your responsibility as a
business owner to know the legal requirements in your area</i>.  If there is
any doubt or uncertainty as to your knowledge of those requirements, you are
advised to speak to your attorney, accountant or other local authority for
additional guidance. </p>

<p class=MsoNormal><b><span style='color:red'>&nbsp;</span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b><span
style='font-size:14.0pt;line-height:120%'>DENTAL SLEEP SOLUTIONS</span></b><b><sup><span
style='font-size:14.0pt;line-height:120%'>&reg;</span></sup></b></p>

<p class=MsoNormal align=center style='text-align:center'><b><span
style='font-size:14.0pt;line-height:120%'>Pre-Opening Checklist</span></b></p>

<p class=MsoNormal align=center style='text-align:center'><span
style='font-size:14.0pt;line-height:120%'>&nbsp;</span></p>

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width=707
 style='width:423.9pt;border-collapse:collapse;border:none'>
 <thead>
  <tr>
   <td width=264 style='width:2.2in;border:solid black 1.0pt;padding:0in 5.4pt 0in 5.4pt'>
   <p class=MsoNormal align=center style='text-align:center'><b><span
   style='font-size:10.0pt;line-height:120%'>Action Item</span></b></p>
   <p class=MsoNormal align=center style='text-align:center'><b><span
   style='font-size:10.0pt;line-height:120%'>&nbsp;</span></b></p>
   </td>
   <td width=150 style='width:1.25in;border:solid black 1.0pt;border-left:none;
   padding:0in 5.4pt 0in 5.4pt'>
   <p class=MsoNormal align=center style='text-align:center'><b><span
   style='font-size:10.0pt;line-height:120%'>Targeted Completion Date</span></b></p>
   </td>
   <td width=188 style='width:112.5pt;border:solid black 1.0pt;border-left:
   none;padding:0in 5.4pt 0in 5.4pt'>
   <p class=MsoNormal align=center style='text-align:center'><b><span
   style='font-size:10.0pt;line-height:120%'>Person Responsible</span></b></p>
   </td>
   <td width=105 style='width:63.0pt;border:solid black 1.0pt;border-left:none;
   padding:0in 5.4pt 0in 5.4pt'>
   <p class=MsoNormal align=center style='text-align:center'><b><span
   style='font-size:10.0pt;line-height:120%'>Date Completed</span></b></p>
   </td>
  </tr>
 </thead>
 <tr>
  <td width=264 valign=top style='width:2.2in;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>Attendance
  at Training Scheduled. </span></p>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=150 valign=top style='width:1.25in;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=188 valign=top style='width:112.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=105 valign=top style='width:63.0pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
 </tr>
 <tr>
  <td width=264 valign=top style='width:2.2in;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>Business
  Formation Completed (Incorporation, DBA, Filings, etc.).</span></p>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=150 valign=top style='width:1.25in;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=188 valign=top style='width:112.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=105 valign=top style='width:63.0pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
 </tr>
 <tr>
  <td width=264 valign=top style='width:2.2in;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>Training
  Completed.</span></p>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=150 valign=top style='width:1.25in;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=188 valign=top style='width:112.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=105 valign=top style='width:63.0pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
 </tr>
 <tr>
  <td width=264 valign=top style='width:2.2in;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>Equipment
  Ordered. </span></p>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=150 valign=top style='width:1.25in;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=188 valign=top style='width:112.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=105 valign=top style='width:63.0pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
 </tr>
 <tr>
  <td width=264 valign=top style='width:2.2in;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>DSS Signs
  Ordered.</span></p>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=150 valign=top style='width:1.25in;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=188 valign=top style='width:112.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=105 valign=top style='width:63.0pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
 </tr>
 <tr>
  <td width=264 valign=top style='width:2.2in;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>Renovation/Remodeling
  Work Scheduled if needed.</span></p>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=150 valign=top style='width:1.25in;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=188 valign=top style='width:112.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=105 valign=top style='width:63.0pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
 </tr>
 <tr>
  <td width=264 valign=top style='width:2.2in;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>Business
  Stationery, Business Cards and Brochures Ordered. </span></p>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=150 valign=top style='width:1.25in;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=188 valign=top style='width:112.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=105 valign=top style='width:63.0pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
 </tr>
 <tr>
  <td width=264 valign=top style='width:2.2in;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>Yellow
  Page Ads/Internet directories  Placed.</span></p>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=150 valign=top style='width:1.25in;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=188 valign=top style='width:112.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=105 valign=top style='width:63.0pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
 </tr>
 <tr>
  <td width=264 valign=top style='width:2.2in;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>List of
  Local Health Care Providers to DSS Franchising LLC.</span></p>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=150 valign=top style='width:1.25in;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=188 valign=top style='width:112.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=105 valign=top style='width:63.0pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
 </tr>
 <tr>
  <td width=264 valign=top style='width:2.2in;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>Internet
  Service Set Up if not already.</span></p>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=150 valign=top style='width:1.25in;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=188 valign=top style='width:112.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=105 valign=top style='width:63.0pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
 </tr>
 <tr>
  <td width=264 valign=top style='width:2.2in;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>Additional
  computers/laptops /tablets ordered if needed.</span></p>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=150 valign=top style='width:1.25in;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=188 valign=top style='width:112.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=105 valign=top style='width:63.0pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
 </tr>
 <tr>
  <td width=264 valign=top style='width:2.2in;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>Business
  Stationery, Business Cards &amp; Brochures Received.</span></p>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=150 valign=top style='width:1.25in;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=188 valign=top style='width:112.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=105 valign=top style='width:63.0pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
 </tr>
 <tr>
  <td width=264 valign=top style='width:2.2in;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>Business
  Opening Date Established.</span></p>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=150 valign=top style='width:1.25in;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=188 valign=top style='width:112.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=105 valign=top style='width:63.0pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
 </tr>
 <tr>
  <td width=264 valign=top style='width:2.2in;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>Employee
  Training Completed.</span></p>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=150 valign=top style='width:1.25in;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=188 valign=top style='width:112.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=105 valign=top style='width:63.0pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
 </tr>
 <tr>
  <td width=264 valign=top style='width:2.2in;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>Grand
  Opening Announcements Placed.</span></p>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=150 valign=top style='width:1.25in;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=188 valign=top style='width:112.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=105 valign=top style='width:63.0pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
 </tr>
 <tr>
  <td width=264 valign=top style='width:2.2in;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>Open for
  Business.</span></p>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=150 valign=top style='width:1.25in;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=188 valign=top style='width:112.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
  <td width=105 valign=top style='width:63.0pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal><span style='font-size:10.0pt;line-height:120%'>&nbsp;</span></p>
  </td>
 </tr>
</table>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027151"></a><a name="_Toc351024503"></a><a
name="_Toc351024385">ETHICS</a></h2>

<h3><a name="_Toc351027152"></a><a name="_Toc351024504"></a><a
name="_Toc351024386"></a><a name="_Toc259183390"></a><a name="_Toc55889583"></a><a
name="_Toc346834811"></a><a name="_Toc346185871"></a><a name="_Toc346031959"></a><a
name="_Toc344047491"></a><a name="_Toc343253089">Corporate Social
Responsibility</a></h3>

<p class=MsoBodyText><span style='line-height:120%;font-family:"Calibri","sans-serif"'>&nbsp;</span></p>

<p class=MsoBodyText style='text-align:justify'><span style='line-height:120%;
font-family:"Calibri","sans-serif"'>Prior to offering your new services we'd
like to take this opportunity to remind you that the decisions you make as a
business owner do not only have personal ramifications - they may also have
social consequences.  Social responsibility is really ethics at the
organizational level, since it refers to the obligation of an organization to
make choices and to take actions that will contribute to the good of society,
as well as the good of the organization.  Authentic social responsibility is
not initiated because of forced compliance to specific laws and regulations. 
In contrast to legal responsibility, social responsibility involves a voluntary
response from an organization that is above and beyond what is specified by the
law.</span></p>

<p class=MsoBodyText style='text-align:justify'><span style='line-height:120%;
font-family:"Calibri","sans-serif"'>&nbsp;</span></p>

<p class=MsoBodyText style='text-align:justify'><span style='line-height:120%;
font-family:"Calibri","sans-serif"'>As a business owner, you are constantly
facing decisions and situations that have been known to test the resolve of
some individuals.  On a legal front, you must comply with an ever-expanding
array of laws having to do with non-discrimination, taxation and fair trade
practices, to name just a few.  Outside the legal arena, there may be times
when an irate patient, an opportunistic or dishonest member of your staff, or a
vendor with questionable accounting practices gives you reason to pause and
analyze the most appropriate course of action.  Whatever the catalyst, each
must be dealt with in a way that will protect your name, your reputation, your
legal standing and at all times, the DENTAL SLEEP SOLUTIONS&reg; trademark.</span></p>

<p class=MsoBodyText style='text-align:justify'><span style='line-height:120%;
font-family:"Calibri","sans-serif"'>&nbsp;</span></p>

<p class=MsoBodyText style='text-align:justify'><span style='line-height:120%;
font-family:"Calibri","sans-serif"'>It is your obligation under your Franchise
Agreement to deal fairly and honestly with all patients.  You have committed to
rendering prompt, courteous and willing service, to operating your business
under the highest ethical and moral standards, and to do nothing that may bring
disrepute to yourself or the DENTAL SLEEP SOLUTIONS&reg; name.   </span></p>

<p class=MsoBodyText style='text-align:justify'><span style='line-height:120%;
font-family:"Calibri","sans-serif"'>&nbsp;</span></p>

<p class=MsoBodyText style='text-align:justify'><span style='line-height:120%;
font-family:"Calibri","sans-serif"'>How do you meet that commitment in a world
that constantly drops unexpected challenges in your path?  By and large, your
own common sense and personal standards of morality will need to guide you.  If
they seem unclear, legislation and legal agreements need to be your stepping
stone to deciding what is right.  </span></p>

<p class=MsoBodyText style='text-align:justify'><span style='line-height:120%;
font-family:"Calibri","sans-serif"'>&nbsp;</span></p>

<p class=MsoBodyText style='text-align:justify'><span style='line-height:120%;
font-family:"Calibri","sans-serif"'>If, after considering all your options, the
answers still seem unclear, try reviewing the basic list below.  These four
primary considerations will generally guide you when determining what course of
action will best serve your corporate social responsibility.  </span></p>

<p class=MsoBodyText style='text-align:justify'><span style='line-height:120%;
font-family:"Calibri","sans-serif"'>&nbsp;</span></p>

<p class=MsoBodyText style='margin-left:.5in;text-align:justify;text-indent:
-.25in'><span style='line-height:120%;font-family:"Calibri","sans-serif"'>1.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp; </span></span><span
style='line-height:120%;font-family:"Calibri","sans-serif"'>Be a good corporate
citizen - contribute resources to the community, improving the quality of life.
</span></p>

<p class=MsoBodyText style='text-align:justify'><span style='line-height:120%;
font-family:"Calibri","sans-serif"'>&nbsp;</span></p>

<p class=MsoBodyText style='margin-left:.5in;text-align:justify;text-indent:
-.25in'><span style='line-height:120%;font-family:"Calibri","sans-serif"'>2.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp; </span></span><span
style='line-height:120%;font-family:"Calibri","sans-serif"'>Be ethical -
obliged to do what is right, just and fair, and avoiding harm.  </span></p>

<p class=MsoBodyText style='text-align:justify;text-indent:.5in'><span
style='line-height:120%;font-family:"Calibri","sans-serif"'>&nbsp;</span></p>

<p class=MsoBodyText style='margin-left:.5in;text-align:justify;text-indent:
-.25in'><span style='line-height:120%;font-family:"Calibri","sans-serif"'>3.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp; </span></span><span
style='line-height:120%;font-family:"Calibri","sans-serif"'>Obey the law - law
is society's codification of right and wrong, playing by the rules of the game.
</span></p>

<p class=MsoBodyText style='text-align:justify'><span style='line-height:120%;
font-family:"Calibri","sans-serif"'>&nbsp;</span></p>

<p class=MsoBodyText style='margin-left:.5in;text-align:justify;text-indent:
-.25in'><span style='line-height:120%;font-family:"Calibri","sans-serif"'>4.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp; </span></span><span
style='line-height:120%;font-family:"Calibri","sans-serif"'>Be profitable - the
foundation upon which all other considerations rest.</span></p>

<p class=MsoBodyText style='text-align:justify'><span style='line-height:120%;
font-family:"Calibri","sans-serif"'>&nbsp;</span></p>

<p class=MsoBodyText style='margin-left:.5in;text-align:justify;text-indent:
-.25in'><span style='line-height:120%;font-family:"Calibri","sans-serif"'>5.<span
style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp; </span></span><span
style='line-height:120%;font-family:"Calibri","sans-serif"'>At all times, set
the standard of behavior that you want your people to follow, and accept
nothing less than their full compliance with that standard.</span></p>

<p class=MsoBodyText style='text-align:justify'><span style='line-height:120%;
font-family:"Calibri","sans-serif"'>&nbsp;</span></p>

<span style='font-size:12.0pt;line-height:120%;font-family:"Arial","sans-serif"'><br
clear=all style='page-break-before:always'>
</span>

<p class=MsoNormal><span style='line-height:120%;font-family:"Arial","sans-serif"'>&nbsp;</span></p>

<p class=MsoNormal><img width=287 height=1089
src="includes/manual_operations_assets/image010.png"
align=left hspace=12 vspace=10
alt="Text Box: Operations&#13;&#10;Manual&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;Dental Sleep Solutions&reg;&#13;&#10;&#13;&#10;"></p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><span style='font-size:36.0pt;line-height:120%;font-family:
"Cambria","serif"'>&nbsp;</span></p>

<p class=MsoNormal><span style='font-size:36.0pt;line-height:120%;font-family:
"Cambria","serif"'>&nbsp;</span></p>

<p class=MsoNormal><span style='font-size:36.0pt;line-height:120%;font-family:
"Cambria","serif"'>&nbsp;</span></p>

<p class=MsoNormal><span style='font-size:36.0pt;line-height:120%;font-family:
"Cambria","serif"'>Section III</span></p>

<p class=MsoNormal><b><span style='font-size:28.0pt;line-height:120%;
font-family:"Cambria","serif"'>Your Employees</span></b></p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoListParagraphCxSpFirst style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>The Hidden Costs Of Employing</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Training</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Morale</p>

<p class=MsoListParagraphCxSpLast style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Recommended Staffing Levels</p>

<p class=MsoNormal>&nbsp;</p>

<span style='font-size:12.0pt;line-height:120%;font-family:"Arial","sans-serif"'><br
clear=all style='page-break-before:always'>
</span>

<p class=MsoNormal><span style='line-height:120%;font-family:"Arial","sans-serif"'>&nbsp;</span></p>

<p class=MsoBodyText><span style='font-family:"Arial","sans-serif"'>&nbsp;</span></p>

<div style='border:none;border-bottom:solid windowtext 3.0pt;padding:0in 0in 1.0pt 0in'>

<h1 style='border:none;padding:0in'><a name="_Toc351027153"></a><a
name="_Toc351024505"></a><a name="_Toc351024387">3.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span>Your Employees</a></h1>

</div>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><b><i><span lang=EN-GB>Dental
Sleep Solutions Franchising LLC does not have the power to hire or fire your
employees.  We do not determine wages, benefits nor do we interject ourselves
into your day-to-day relationship with your employees.  </span>This section is strictly informational and provides general guidelines and is not to be used as a substitute for legal or accounting advice in planning your business.</i></b></p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<h2 style='text-align:justify'><a name="_Toc351027154"></a><a
name="_Toc351024506"></a><a name="_Toc351024388">THE HIDDEN COSTS OF EMPLOYING</a></h2>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>When you're hiring keep in mind
that, on the average, employees will cost you between 15 and 30 percent above
their wages or salaries, depending on what benefits you offer.  For example, if
you're paying an employee $18,000 per year in salary, figure your real cost at
15 percent above their wages just to cover payroll taxes, worker's
compensation, and paid vacation.  Figure 30 percent above total wages if you
add a full slate of benefits.  In other words, that $18,000 a year employee is
really costing you as much as $23,400.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Then there are the costs you
don't directly see.  Consider the cost of training a new employee, and the time
they spend on the payroll consuming instead of directly contributing to the
profits of the business.  Consider the mistakes and lost productivity a new
employee represents until that first month or two goes by and they finally
settle into a comfortable routine.  In some businesses, it's been estimated
that the up front, hidden cost of a new employee to the business will be the
equivalent of as much as a month's salary.  </p>

<p class=MsoNormal style='text-align:justify'>        </p>

<p class=MsoNormal style='text-align:justify'>With so much of your income
devoted to paying your employees, your ultimate success or failure will often
be determined by the quality of employees you choose.  To minimize turnover, to
find people most likely to be productive, and to hold your costs down to a
level that are going to yield you a profit, the best thing you can do is become
an expert at finding, hiring, and then retaining the brightest and best
people.  The investment of time and effort required to do so will end up paying
for itself many, many times over.    </p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027155"></a><a name="_Toc351024507"></a><a
name="_Toc351024389">TRAINING</a></h2>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Training your staff to understand
dental sleep medicine so that they will be able to work directly with patients,
be able to effectively utilize the proprietary DSS software program, and be
knowledgeable about all of the different dental devices will be a <b>critical</b>
element in providing quality dental sleep therapy services.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>The investment you make now in
training your existing staff (and in the future, for new hires) will allow you
to provide quality dental sleep services to your patients that can not only change
their lives but create referrals for your practice.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>We recommend that you develop a
specific training outline using your DENTAL SLEEP SOLUTIONS&reg;' Training Manual
as your guide.  When training, it's important to remember that the old adage
&quot;if the student hasn't learned, the teacher hasn't taught&quot; is true. 
One proven, effective method for training is:</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<ol style='margin-top:0in' start=1 type=1>
 <li class=MsoNormal style='text-align:justify'><i>Explain what it is you want
     the employee to learn.</i></li>
 <li class=MsoNormal style='text-align:justify'><i>Demonstrate how the task is
     to be performed.</i></li>
 <li class=MsoNormal style='text-align:justify'><i>Have the employee try it.</i></li>
 <li class=MsoNormal style='text-align:justify'><i>Coach and evaluate the
     performance.</i></li>
 <li class=MsoNormal style='text-align:justify'><i>Repeat steps 3 and 4 as
     needed.</i></li>
 <li class=MsoNormal style='text-align:justify'><i>Follow up.</i></li>
</ol>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>After the initial training, there
will be other times that require your intervention.  Among them are:</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:.7in;text-align:justify;text-indent:-.25in'><span
style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span><b>When any employee is called upon to perform a task for the
first time.</b></p>

<p class=MsoNormal style='margin-left:.7in;text-align:justify;text-indent:-.25in'><span
style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span><b>When an employee asks for help.</b></p>

<p class=MsoNormal style='margin-left:.7in;text-align:justify;text-indent:-.25in'><span
style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span><b>When a task or assignment is not being performed properly.</b></p>

<p class=MsoNormal style='margin-left:.7in;text-align:justify;text-indent:-.25in'><span
style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span><b>Whenever a new function is being introduced to the entire
staff.</b></p>

<p class=MsoNormal style='text-align:justify'><b>&nbsp;</b></p>

<p class=MsoNormal style='text-align:justify'>Because this is a new area of service
for your practice, your staff will need more attention in the early going.  Be
positive, offering supportive and constructive feedback.  This is your
opportunity to show them your personal commitment to success, both yours and
theirs. </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Spend as much time as possible
with your trainee, and only when you feel they are beginning to grasp their
duties, place them under the supervision of a trusted employee.  The critical
point to remember is that you need to follow up.  Never assume that just
because you said something once, the message you intended has been delivered
and permanently received.  Don't assume that just because they remembered
something today, they will remember it in the same manner tomorrow.  Learning
is a process of repetition and practice.  Make sure you keep an eye on what is
being practiced.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Since critiquing early
performance is an integral part of the learning process, a useful tool for
keeping the training atmosphere positive is what's known as the <i>criticism
sandwich.  </i>When you see something being done wrong, prior to addressing the
problem, search for something that's being done right and use it to cushion the
blow.  That way, you can explain what the employee has done wrong, but sandwich
that criticism between two positive statements of praise for a job he or she
has done well.  Your message will be delivered in a manner that will correct
and motivate at the same time.        </p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027156"></a><a name="_Toc351024508"></a><a
name="_Toc351024390">MORALE</a></h2>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Authorities on business
leadership agree that a significant factor in a business owner's success is the
ability to encourage, accept, and use the ideas of the company's employees. 
Giving them full credit for an idea that proves to be successful stimulates
employee contributions and cooperation, and creates a true spirit of teamwork. 
People like to feel that they are part of a team, that they have importance,
that their contributions are both recognized and appreciated.  People operating
in such an environment tend to look out for the organization, to constantly
seek ways to improve it.  People who think that way will help make any business
grow.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Recognizing that employee morale
and team spirit are important to the success of any business, the following
suggestions for building them may be helpful:</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<ol style='margin-top:0in' start=1 type=1>
 <li class=MsoNormal style='text-align:justify;line-height:150%'>Tell and show
     your employees that you are interested in them and welcome their ideas on
     how conditions might be improved.</li>
 <li class=MsoNormal style='text-align:justify;line-height:150%'>Treat your
     employees as individuals, never as impersonal cogs in a working
     environment.  </li>
 <li class=MsoNormal style='text-align:justify;line-height:150%'>Always deal
     with the performance, never the person.</li>
 <li class=MsoNormal style='text-align:justify;line-height:150%'>Accept the
     fact that others may not see things as you do.</li>
 <li class=MsoNormal style='text-align:justify;line-height:150%'>Set
     expectations, and publicly acknowledge when they are met.</li>
 <li class=MsoNormal style='text-align:justify;line-height:150%'>Give
     explanations for management actions when possible.</li>
 <li class=MsoNormal style='text-align:justify;line-height:150%'>Provide
     information and guidance on matters affecting employee security.</li>
 <li class=MsoNormal style='text-align:justify;line-height:150%'>Encourage
     promotion from within.</li>
 <li class=MsoNormal style='text-align:justify;line-height:150%'>Offer
     criticism privately in the form of constructive suggestions for improvement.</li>
 <li class=MsoNormal style='text-align:justify;line-height:150%'>Train
     supervisors to think about the people involved, rather than just the work.</li>
 <li class=MsoNormal style='text-align:justify;line-height:150%'>Keep your
     people up to date on all business matters affecting them, and quell rumors
     with correct information.</li>
</ol>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>In other words, treat your people
the same way you wish to be treated.  Offer them courtesy, recognition, and a
genuine sense of caring, and they will not only take care of your business for
you, they'll look forward to doing it.</p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2 style='text-align:justify'><a name="_Toc351027157"></a><a
name="_Toc351024509"></a><a name="_Toc351024391">RECOMMENDED STAFFING LEVELS</a></h2>

<p class=MsoNormal><span style='color:red'>&nbsp;</span></p>

<p class=MsoNormal style='text-align:justify'>At first, your staffing needs and
levels will be similar to what is needed to run a general dental practice.  You
will need an administrative person to handle telephones and administrative
duties, and someone to assist you with dental sleep therapy patient
appointments.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>As your dental sleep medicine practice
grows, you'll add staff as needed; you will be in the best position to
determine when you need to add staff to support your new business. </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal align=center style='text-align:center'><b><span
style='font-size:22.0pt;line-height:120%'>Dental Sleep Solutions&reg;</span></b></p>

<p class=MsoNormal align=center style='text-align:center'><span
style='font-size:14.0pt;line-height:120%'>Practice Building Job Duties</span></p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>Assign a staff member to be responsible for these tasks:</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><b>CLINICAL</b></p>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none'>
 <tr>
  <td width=130 valign=top style='width:77.8pt;border:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>STAFF MEMBER</p>
  </td>
  <td width=591 valign=top style='width:354.5pt;border:solid black 1.0pt;
  border-left:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>DUTY</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:77.8pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=591 valign=top style='width:354.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Screening existing patients</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:77.8pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=591 valign=top style='width:354.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Taking impressions and bite</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:77.8pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=591 valign=top style='width:354.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Lab Rx and Lab Tracking</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:77.8pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=591 valign=top style='width:354.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Device delivery and care and titration instructions</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:77.8pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=591 valign=top style='width:354.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Follow up appointments:  update flow sheet, progress
  notes, patient plan, scheduling next visit</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:77.8pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=591 valign=top style='width:354.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>HST:  Coordinate if out of office; set up, download and
  instruct if in office</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:77.8pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=591 valign=top style='width:354.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Consultations/educating patients</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:77.8pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=591 valign=top style='width:354.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Annual Recalls - appointments</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:77.8pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=591 valign=top style='width:354.5pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
</table>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><b>&nbsp;</b></p>

<p class=MsoNormal><b>&nbsp;</b></p>

<p class=MsoNormal><b>&nbsp;</b></p>

<p class=MsoNormal><b>ADMINISTRATIVE</b></p>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none'>
 <tr>
  <td width=130 valign=top style='width:78.15pt;border:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>STAFF MEMBER</p>
  </td>
  <td width=590 valign=top style='width:354.15pt;border:solid black 1.0pt;
  border-left:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>DUTY</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:78.15pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:354.15pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Handling phone calls, NP paperwork, NP web portal</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:78.15pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:354.15pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>ALL patient info entered into SW</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:78.15pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:354.15pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Requesting Ref/Rx/LOMN/PSG</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:78.15pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:354.15pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Scanning Ref/Rx/LOMN/PSG into SW</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:78.15pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:354.15pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Requesting VOB / Pre Auth</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:78.15pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:354.15pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Claim Filed / Status</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:78.15pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:354.15pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>New staff member training</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:78.15pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:354.15pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Patient tracking</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:78.15pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:354.15pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Annual recall</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:78.15pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:354.15pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Manage preferred provider contracts</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:78.15pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:354.15pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Manage Medicare process</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:78.15pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:354.15pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Prepare and coordinate monthly progress meetings</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:78.15pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:354.15pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:78.15pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:354.15pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:78.15pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:354.15pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td width=130 valign=top style='width:78.15pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:354.15pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
</table>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><b>SOFTWARE</b></p>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none'>
 <tr>
  <td width=131 valign=top style='width:78.55pt;border:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>STAFF MEMBER</p>
  </td>
  <td width=590 valign=top style='width:353.75pt;border:solid black 1.0pt;
  border-left:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>DUTY</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.55pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.75pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>NP paperwork</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.55pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.75pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>NP web portal</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.55pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.75pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Enter or accept NP info into SW</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.55pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.75pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Enter Baseline PSG/HST into SW</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.55pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.75pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Manage flow sheet</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.55pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.75pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Enter / Manage Progress Notes</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.55pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.75pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Enter / Manage new sleep studies and HST into flow or
  summary sheet</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.55pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.75pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Scan ALL patient documents </p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.55pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.75pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Manage patient letters (through flow sheet)</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.55pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.75pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.55pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.75pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.55pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.75pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
</table>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><b>MARKETING (INTERNAL)</b></p>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none'>
 <tr>
  <td width=137 valign=top style='width:81.9pt;border:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>STAFF MEMBER</p>
  </td>
  <td width=662 valign=top style='width:396.9pt;border:solid black 1.0pt;
  border-left:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>DUTY</p>
  </td>
 </tr>
 <tr>
  <td width=137 valign=top style='width:81.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=662 valign=top style='width:396.9pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Existing patient screening</p>
  </td>
 </tr>
 <tr>
  <td width=137 valign=top style='width:81.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=662 valign=top style='width:396.9pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Blanket letter / email announcing dental sleep medicine</p>
  </td>
 </tr>
 <tr>
  <td width=137 valign=top style='width:81.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=662 valign=top style='width:396.9pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Adding dental sleep medicine to existing newsletter or
  developing newsletter</p>
  </td>
 </tr>
 <tr>
  <td width=137 valign=top style='width:81.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=662 valign=top style='width:396.9pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Posters updated and displayed appropriately</p>
  </td>
 </tr>
 <tr>
  <td width=137 valign=top style='width:81.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=662 valign=top style='width:396.9pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Developing business cards, brochures, letterheads</p>
  </td>
 </tr>
 <tr>
  <td width=137 valign=top style='width:81.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=662 valign=top style='width:396.9pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Maintaining  adequate supply of bus cards, brochures,
  letterhead</p>
  </td>
 </tr>
 <tr>
  <td width=137 valign=top style='width:81.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=662 valign=top style='width:396.9pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td width=137 valign=top style='width:81.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=662 valign=top style='width:396.9pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td width=137 valign=top style='width:81.9pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=662 valign=top style='width:396.9pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
</table>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><b>MARKETING (EXTERNAL)</b></p>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none'>
 <tr>
  <td width=131 valign=top style='width:78.45pt;border:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>STAFF MEMBER</p>
  </td>
  <td width=590 valign=top style='width:353.85pt;border:solid black 1.0pt;
  border-left:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>DUTY</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.45pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.85pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Identify referral sources in the community (medical,
  dental, other)</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.45pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.85pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Develop marketing plan for referral sources</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.45pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.85pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Execute marketing plan</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.45pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.85pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Deliver bus cards, brochures, referral pads</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.45pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.85pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Set up lunch and learns</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.45pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.85pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Set up lunches with MD's</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.45pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.85pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Develop and manage speaking engagements with civic groups</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.45pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.85pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Develop and manage web site, Facebook, tweets, etc.</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.45pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.85pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Develop and manage advertising (print, radio, other)</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.45pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.85pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Develop and manage external signage</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.45pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.85pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.45pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.85pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.45pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.85pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
</table>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><b>&nbsp;</b></p>

<p class=MsoNormal><b>&nbsp;</b></p>

<p class=MsoNormal><b>&nbsp;</b></p>

<p class=MsoNormal><b>ONGOING</b></p>

<table class=MsoTableGrid border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none'>
 <tr>
  <td width=131 valign=top style='width:78.5pt;border:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>STAFF MEMBER</p>
  </td>
  <td width=590 valign=top style='width:353.8pt;border:solid black 1.0pt;
  border-left:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>DUTY</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.5pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.8pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Seek out new referral sources and write appropriate
  letters</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.5pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.8pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Manage existing referral sources:  keep adequately stocked
  with brochures, ref pads</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.5pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.8pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Reward referral sources with PERSONAL visits and goody
  baskets</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.5pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.8pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Monthly meetings with referral sources (lunches,
  breakfasts, lunch and learns, etc)</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.5pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.8pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>At least one speaking engagement per month</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.5pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.8pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>Maintain CONSTANT vigil on entering all patients into SW</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.5pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.8pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.5pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.8pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.5pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.8pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.5pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.8pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
 <tr>
  <td width=131 valign=top style='width:78.5pt;border:solid black 1.0pt;
  border-top:none;padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
  <td width=590 valign=top style='width:353.8pt;border-top:none;border-left:
  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;
  padding:0in 5.4pt 0in 5.4pt'>
  <p class=MsoNormal>&nbsp;</p>
  </td>
 </tr>
</table>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>--END OF JOB DUTIES FORM--</p>

<span style='font-size:12.0pt;line-height:120%;font-family:"Calibri","sans-serif"'><br
clear=all style='page-break-before:always'>
</span>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal><img width=287 height=1091
src="includes/manual_operations_assets/image011.png"
align=left hspace=12 vspace=10
alt="Text Box: Operations&#13;&#10;Manual&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;Dental Sleep Solutions&reg;&#13;&#10;"></p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><span style='font-size:36.0pt;line-height:120%;font-family:
"Cambria","serif"'>Section IV</span></p>

<p class=MsoNormal><b><span style='font-size:28.0pt;line-height:120%;
font-family:"Cambria","serif"'>Business Set-Up &amp; Operations</span></b></p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoListParagraphCxSpFirst style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>An Overview Of The Dental Sleep Solutions&reg; System</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Call Center/Lead Processing</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Practice Manager Software</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Getting Started</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>New Patient Initial Contact Procedures</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Initial Consultation</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Comprehensive Exam &amp; Impressions</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Device Delivery</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>First Evaluation</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Device Evaluation Appointment       </p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Home Sleep Test Appointment</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Yearly Evaluation</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Thirty Month Evaluation       </p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Insurance Information</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Dental Sleep Solutions&reg; Forms</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Materials &amp; Equipment Needed To Open For Business</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Recommended Vendors</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Recommended Appliance Manufacturers/Labs</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Recommended Home Sleep Testing Devices            </p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Recommended Printing Services</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Required Signage</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Dealing With Vendors</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Establishing &amp; Maintaining Vendor Relations</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Recommended Product Check-In Policies</p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Your Responsibilities As A Franchise Owner</p>

<p class=MsoListParagraphCxSpLast style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Trademarked Merchandise</p>

<span style='font-size:12.0pt;line-height:120%;font-family:"Calibri","sans-serif"'><br
clear=all style='page-break-before:always'>
</span>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<div style='border:none;border-bottom:solid windowtext 3.0pt;padding:0in 0in 1.0pt 0in'>

<h1 style='border:none;padding:0in'><a name="_Toc351027158"></a><a
name="_Toc351024510"></a><a name="_Toc351024392">4.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span>Business Set-Up &amp; Operations</a></h1>

</div>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><b><u><span style='text-decoration:none'>&nbsp;</span></u></b></p>

<h2><a name="_Toc351027159"></a><a name="_Toc351024511"></a><a
name="_Toc351024393">AN OVERVIEW OF THE</a> </h2>

<h2><a name="_Toc351027160"></a><a name="_Toc351024512"></a><a
name="_Toc351024394">DENTAL SLEEP SOLUTIONS<sup>&reg;</sup> SYSTEM</a></h2>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>As a DENTAL SLEEP SOLUTIONS&reg;
franchisee, you will have access to our proprietary web-based software program
created specifically for Dental Sleep Solutions Franchising LLC's dental sleep
medicine program.  Our program not only provides advanced software that takes a
patient from the first contact through completed treatment and annual follow
up, but includes full administrative support as well.  Using information
provided by you and your patients directly into our web-based software, Dental
Sleep Solutions Franchising LLC will generate all of your letters to both
patients and their health care providers for you. This allows you to focus
completely on your patients and their needs.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Based on our experience with
dental sleep medicine, and understanding how vital communication and information
is to this process, we have developed a series of letters and related forms
that are part of our full-service program and integrated into our proprietary DENTAL
SLEEP SOLUTIONS&reg; Software (&quot;DSS Software&quot;).  When you update your
clients' web-based medical records in our system, that will automatically
trigger any communications that are related to the update.  Because of the
efficiencies of the DSS Software and our dedicated service in this area, we
have eliminated the need for you to hire additional office staff.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>This section contains detailed
information on each step of the program and will show you how each step, letter
and form fits into your patients' dental sleep therapy program. </p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027161"></a><a name="_Toc351024513"></a><a
name="_Toc351024395">CALL CENTER/LEAD PROCESSING</a></h2>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>DSS Franchising LLC may utilize
multiple levels of marketing to generate patient leads for our franchisees. 
Some of this marketing may include your specific contact information, and
therefore, your office may receive telephone calls from prospective patients
directly; other marketing efforts will direct patient calls to a central call
center.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>DSS Franchising LLC will maintain
a call center to receive and process incoming calls.  Calls will be received
and processed in a timely manner and referred to the appropriate franchisee. 
You will be notified of the new referral through the DSS software management
system.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>When calls come in after hours,
prospective patients will be prompted to leave a voicemail message; these calls
will be processed the next business day.  Any inquiries that come in via email
will be followed up and processed in a similar manner. </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>You may contact the call center
directly by calling 877-95-SNORE or direct your questions to any company
management team member.</p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027162"></a><a name="_Toc351024514"></a><a
name="_Toc351024396">PRACTICE MANAGER SOFTWARE</a></h2>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>DSS Franchising LLC has spent a
considerable amount of time developing our web-based practice management
software to serve the needs of our franchisees and their patients.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><i>It is important to note that
you are <u>required</u> to enter all information related to your dental sleep
therapy patients into the DSS Software.  This data is critical to the
software-driven system that we have designed for your franchised business, and
many of our systems depend on your input of patients.</i></p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Software features include:</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>New-patient information collection via a live web portal: <i>patient
medical history, insurance information, new-patient forms, address and contact
info, etc.</i> </p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Tracking of patient treatment progress: <i>appointment history,
symptoms, etc.</i></p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Digital storage of relevant patient images and sleep study
results: <i>x-rays and other sleep apnea-related data</i> </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Gathering and storage of relevant patient information for DSS
Franchising LLC back-office staff for medical insurance preauthorization and
billing: <i>treatment history, doctor prescriptions, letters of medical
necessity, etc.</i></p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Tracking of insurance and billing information for each patient
(ledger).</p>

<p class=MsoListParagraph>&nbsp;</p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>A scheduler to manage patient appointments</p>

<p class=MsoListParagraph>&nbsp;</p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>A task manager to better manage day to day operations</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Assisting in the generation of letters/treatment progress notes
to be sent out to parties interested in tracking patient progress: <i>e.g.
Patient's primary care physician, referring physician, any necessary medical
caregivers, etc.</i>&nbsp; </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>The software will also be used to
collect patient treatment data statistics in order to individually coach
franchisees on how they can operate their practice more efficiently.</p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><span style='text-decoration:none'>&nbsp;</span></h2>

<h2><a name="_Toc351027163">DENTAL SLEEP PROCEDURES MANUAL</a></h2>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>Please <a href="manual.php">click here</a> to be redirected to the Dental Sleep
Procedures Manual.</p>


<p class=MsoNormal>&nbsp;</p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027164"></a><a name="_Toc351024563"></a><a
name="_Toc351024445">MATERIALS &amp; EQUIPMENT NEEDED TO OPEN FOR BUSINESS</a></h2>

<p class=MsoNormal><b><span style='color:red'>&nbsp;</span></b></p>

<p class=MsoNormal style='text-align:justify'>DENTAL SLEEP SOLUTIONS&reg; will
provide you with your initial supply of marketing materials, including business
cards, brochures, letterhead and operatory signs.  In addition, we will also
provide you with all of the following items you will need to set up your dental
sleep medicine practice:</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Instructional Videos/DVDs:</p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify'>      <i>Patient
Education</i></p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify'><i>      MD
Education</i></p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify'><i>      Appliance
Care &amp; Titration</i></p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify'><i>&nbsp;</i></p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>3 George or TAP Gauges</p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>3 ROM Triangles</p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>5 Measuring Tapes</p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>6 Orthotic Appliance Models:</p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify'><i>      EMA</i></p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify'><i>      SUAD</i></p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify'><i>      Dorsal
Design</i></p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify'><i>      TAP3</i></p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify'><i>      Narval</i></p>

<p class=MsoNormal style='margin-left:1.25in;text-align:justify'><i>      AVEO
TSD</i></p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>We may require additional equipment
or alterations/upgrades/replacement of your current equipment or office set-up in
the future. </p>

<h3 style='text-align:justify'><a name="_Toc351027165"></a><a
name="_Toc351024564"></a><a name="_Toc351024446">Recommended Vendors</a></h3>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Currently you are not required to
purchase equipment or supplies from specific vendors for the operation of your DENTAL
SLEEP SOLUTIONS&reg; business, other than our trademark and certain proprietary
products that we may develop.  We may change this policy in the future. You <u>are</u>
required to purchase only sleep medicine equipment and supplies that are FDA
approved.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>DENTAL SLEEP SOLUTIONS&reg; has
negotiated discounted fees from certain laboratories and other sleep-related
vendors for the benefit of all of our franchisees.  We recommend that you use the
following vendors, and the products listed, for your dental devices, services
and sleep equipment.</p>

<h3><span style='text-decoration:none'>&nbsp;</span></h3>

<h3><a name="_Toc351027166"></a><a name="_Toc351024565"></a><a
name="_Toc351024447">Recommended Appliance Manufacturers/Labs</a></h3>

<p class=MsoNormal><b>&nbsp;</b></p>

<p class=MsoNormal><b>Product:                      Dorsal Design MAD </b></p>

<p class=MsoNormal><b>Manufacturer/Lab:    </b>Dynaflex</p>

<p class=MsoNormal>                                    10403 International
Plaza Drive</p>

<p class=MsoNormal>                                    St. Ann, MO  63074-1805</p>

<p class=MsoNormal>                        Mailing:</p>

<p class=MsoNormal>                                    P.O. Box 99</p>

<p class=MsoNormal>                                    St. Ann, MO 63074-0099</p>

<p class=MsoNormal>                                    T:  800-489-4020         F: 
314-429-7575</p>

<p class=MsoNormal>                                    Dynaflex.com</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><b>Product:                      Somnodent MAS</b></p>

<p class=MsoNormal><b>Manufacturer/Lab:    </b>Somnomed</p>

<p class=MsoNormal>                                    7460 Warren Pkway, Ste
190</p>

<p class=MsoNormal>                                    Frisco, TX 75034</p>

<p class=MsoNormal>                                    T: 888-447-6673          F: 
972-377-3404</p>

<p class=MsoNormal><b>&nbsp;</b></p>

<p class=MsoNormal><b>Product:                      TAP 3 and TAP/PAP</b></p>

<p class=MsoNormal><b>Manufacturer/Lab:    </b>Airway Management, Inc.</p>

<p class=MsoNormal>                                    3418 Midcourt Rd. Suite
114, Carrolton, TX 75006</p>

<p class=MsoNormal>                                    T:  866-AMISNOR (866-264-7667)      F:  
214-691-3151</p>

<p class=MsoNormal>                                    amisleep.com</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><b>Product:</b>                      <b>TAP 3 and EMA</b></p>

<p class=MsoNormal><b>Lab:</b>                             Keller Labs</p>

<p class=MsoNormal>                                    160 Larkin Williams
Industrial Court</p>

<p class=MsoNormal>                                    <span lang=ES-MX>Fenton,
MO  63026</span></p>

<p class=MsoNormal><span lang=ES-MX>                                    T: 
800-325-3056         F:  636-600-4396</span></p>

<p class=MsoNormal><span lang=ES-MX>                                    Kellerlab.com</span></p>

<p class=MsoNormal><span lang=ES-MX>&nbsp;</span></p>

<p class=MsoNormal><b>Product:                      SUAD</b></p>

<p class=MsoNormal><b>Manufacturer/Lab:    </b>Strong Dental</p>

<p class=MsoNormal>                                    3430 E. Jefferson
Avenue, Suite 307, Detroit, Michigan  48207</p>

<p class=MsoNormal>                                    T:  800-339-4452         F: 
519-322-1320</p>

<p class=MsoNormal>                                    strongdental.com</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><b>Product:                      EMA and AVEO TRD</b></p>

<p class=MsoNormal><b>Manufacturer/Lab:    </b>Glidewell Laboratories</p>

<p class=MsoNormal>                                    4141 MacArthur Blvd., Newport
Beach, CA 92660</p>

<p class=MsoNormal>                                    T:  800-854-7256         F: 
800-411-9722</p>

<p class=MsoNormal>                                    glidewelldental.com</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><b>Product:                      Narval</b></p>

<p class=MsoNormal><b>Manufacturer/Lab:    </b>Dental Prosthetic Services (DPS)</p>

<p class=MsoNormal>                                    1150 Old Marion Rd NE,
Cedar Rapids, IA 52402</p>

<p class=MsoNormal>                                    T:  800-332-3341         F: 
319-393-8455</p>

<p class=MsoNormal>                                    www.DPSDental.com</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><b>Product:                      Adjustable PM Positioner</b></p>

<p class=MsoNormal><b>                                    SomnoDent MAS</b></p>

<p class=MsoNormal><b>                                    TAP 3</b></p>

<p class=MsoNormal><b>Manufacturer/Lab:    </b>Dental Services Group (DSG)</p>

<p class=MsoNormal>                                    Multiple Locations
throughout the U.S.</p>

<p class=MsoNormal>                                    14333 58<sup>th</sup>
Street North, Clearwater, FL 33760</p>

<p class=MsoNormal>                                    T:  800-237-1723         F: 
727-535-9475</p>

<p class=MsoNormal>                                    www.DentalServices.net/clearwater</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><b>Product:                      Adjustable PM Positioner</b></p>

<p class=MsoNormal><b>                                    SomnoDent MAS</b></p>

<p class=MsoNormal><b>                                    TAP 3</b></p>

<p class=MsoNormal><b>                                   Many
More Appliances (list forthcoming)</b></p>

<p class=MsoNormal><b>Manufacturer/Lab:    </b>Appliance Therapy Group</p>

<p class=MsoNormal>                                    9129 Lurline Ave,
Chatsworth, CA 91311</p>

<p class=MsoNormal>                                    T:  800-423-3270         F: 
954-340-0596</p>

<p class=MsoNormal>                                    www.ApplianceTherapy.com</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<h3><a name="_Toc351027167"></a><a name="_Toc351024566"></a><a
name="_Toc351024448">Recommended Home Sleep Testing Devices</a></h3>

<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width="2%"
 style='width:2.6%'>
 <tr>
  <td style='padding:0in 0in 0in 0in'></td>
 </tr>
</table>

<p class=MsoNormal><b>Product:                      Ares Sleep Recorder</b></p>

<p class=MsoNormal><b>Manufacturer:            </b>Watermark / Ares Corporate
Headquarters </p>

<p class=MsoNormal>                                    1750 Clint Moore Road,
Suite 101, Boca Raton, FL 33487<br>
                                    T:  877-710-6999         </p>

<p class=MsoNormal>                                    watermarkmedical.com</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><b>Product:                      EZ Sleep In-Home Sleep Testing</b></p>

<p class=MsoNormal><b>Manufacturer:            </b>EZ Sleep / Westlake Sleep
Institute </p>

<p class=MsoNormal>                                    250 N. Westlake Blvd,
Ste 130</p>

<p class=MsoNormal style='margin-left:1.0in;text-indent:.5in'>Westlake Village,
CA 91362<br>
            T:  805-497-7378         F: 805-497-3776</p>

<p class=MsoNormal>                                    www.EZSleepTest.com</p>

<p class=MsoNormal><b>&nbsp;</b></p>

<p class=MsoNormal><b>Product:                      Medibyte and Medibyte Jr.
Sleep Recorders</b></p>

<p class=MsoNormal><b>Manufacturer:            </b>Braebon Medical Corporation </p>

<p class=MsoNormal style='margin-left:1.5in'>Suite #1 - 100 Schneider Road,
Kanata, Ontario CANADA K2K1Y2<br>
T: 888-462-4841          F: 613-831-6699</p>

<p class=MsoNormal>                                    www.Braebon.com</p>

<p class=MsoNormal><b>&nbsp;</b></p>

<p class=MsoNormal><b>Product:                      Remmer's Sleep Recorder</b></p>

<p class=MsoNormal style='margin-left:1.5in;text-indent:-1.5in'><b>Manufacturer:            </b>SagaTech
Electronics Inc., Suite 9, 1515 Highfield Crescent SE,Calgary, Alberta, Canada 
T2G 5M4<br>
T:  403-228-4214         F:   403-228-4297</p>

<p class=MsoNormal>                                    sagatech.ca/rsr/products.php<br>
                                    <a href="mailto:inquiries@sagatech.ca"><span
style='color:windowtext'>inquiries@sagatech.ca</span></a></p>

<p class=MsoNormal><span class=MsoHyperlink><span style='color:windowtext'><span
 style='text-decoration:none'>&nbsp;</span></span></span></p>

<span class=MsoHyperlink><span style='font-size:12.0pt;font-family:"Calibri","sans-serif";
color:windowtext'><br clear=all style='page-break-before:always'>
</span></span>

<p class=MsoNormal style='line-height:normal'><span class=MsoHyperlink><span
style='color:windowtext'><span style='text-decoration:none'>&nbsp;</span></span></span></p>

<h3><a name="_Toc351027168"></a><a name="_Toc351024567"></a><a
name="_Toc351024449">Recommended Printing Services</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='margin-left:1.5in;text-indent:-1.5in'><b>Vendor:                      Serbin
Printing</b></p>

<p class=MsoNormal style='margin-left:1.5in'>1500 N. Washington Blvd.</p>

<p class=MsoNormal style='margin-left:1.5in'>Sarasota, FL 34263</p>

<p class=MsoNormal style='margin-left:1.5in'>T:  941-366-0755         F:   941-365-6327</p>

<p class=MsoNormal style='margin-left:1.5in'>www.Serbinprinting.com</p>

<p class=MsoNormal style='margin-left:1.5in'>dcross@serbinprinting.com</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<span style='font-size:12.0pt;line-height:120%;font-family:"Calibri","sans-serif"'><br
clear=all style='page-break-before:always'>
</span>

<p class=MsoNormal>&nbsp;</p>

<h3><a name="_Toc351027169"></a><a name="_Toc351024568"></a><a
name="_Toc351024450">Required Signage</a>  </h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>We will provide you with a
minimum of three poster board type operatory signs, approximately 16&quot; x
20" each, that must be displayed in your waiting/reception room as well as in
the hygiene operatories and the main operatory that you use for treating sleep
patients.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>In addition, any NEW signs that
you have made for your practice during your contract as a DSS franchisee will
be required to have "DENTAL SLEEP SOLUTIONS&reg;" as part of your signage.  You will
not be required to retrofit any existing signage now in place.</p>

<p class=MsoNormal>&nbsp;</p>

<b><span style='font-size:12.0pt;line-height:120%;font-family:"Calibri","sans-serif";
color:red'><br clear=all style='page-break-before:always'>
</span></b>

<p class=MsoNormal><b><span style='color:red'>&nbsp;</span></b></p>

<h2><a name="_Toc351027170"></a><a name="_Toc351024569"></a><a
name="_Toc351024451">DEALING WITH VENDORS</a></h2>

<p class=MsoNormal>&nbsp;</p>

<h3 style='text-align:justify'><a name="_Toc351027171"></a><a
name="_Toc351024570"></a><a name="_Toc351024452"></a><a name="_Toc272322131">Establishing
&amp; Maintaining Vendor Relations</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Vendors are to some degree hired
help.  You are the customer, and it is the vendors who are providing you with a
product or service; in that regard your relationship is not that dissimilar to
that of an employer and employee.  You tell them what you need, and their job
is to provide it.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>By the same token, vendors have
been known to save the day for countless business owners by making special
deliveries, deviating from time to time on their company's delivery or product
guarantee rules, and even offering advice and counsel that might be unavailable
anywhere else.  From that perspective, they can at times be the equivalent of
an operating partner.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>The best overall relationship is
probably a combination of the two.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Your vendors are a key part of
the success of your business.  You need them to make timely deliveries of
quality product upon terms and conditions that will allow both of you to make a
profit.  Conversely, they also need you because without your purchases, and
those of everyone else they sell to, they also will have no business.  That
creates a synergy between you, a community of interest that the smart business
person recognizes and utilizes to its full advantage.        </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Developing relationships with
your primary vendors can have a positive impact on your business.  Take the
time to get to know the key contacts at these vendors when you first get started
and then occasionally throughout the year.  Remember, whenever you're dealing
with people, little things go a long way.  Treat people right, and the odds
increase that they'll strive to help you out anyway they can.  They may not
always be able to go the extra mile for you, but having them willing to try is
to your advantage, with no downside.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><a name="_Toc351027172"></a><a
name="_Toc351024571"></a><a name="_Toc351024453"></a><a name="_Toc272322132"><span
class=Heading3Char><span style='font-size:16.0pt;line-height:120%'>Recommended
Product Check-In Policies</span></span></a></p>

<p class=MsoNormal style='text-align:justify'><b><u><span style='text-decoration:
 none'>&nbsp;</span></u></b></p>

<p class=MsoNormal style='text-align:justify'>We recommend that you create a
log of dental devices ordered (including patient name, date ordered, vendor,
date promised, etc.) so that you can track and confirm that they are received
in a timely manner.  Each device should also be checked for obvious defects
when it arrives.  If the box is damaged when it arrives, we recommend that you
have the delivery person wait while you open it to inspect the device.</p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027173"></a><a name="_Toc351024572"></a><a
name="_Toc351024454"></a><a name="_Toc272322144">YOUR RESPONSIBILITIES AS A
FRANCHISE OWNER</a></h2>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>One of your responsibilities as a
DENTAL SLEEP SOLUTIONS&reg; franchise owner is to provide your employees and
patients with a clean, safe and secure business environment.  Whether it be
maintaining a work place free of hazards, or seeing to it that your public
access areas have no defects that might lead to accident or injury, it is your
responsibility and obligation to make sure that all areas of your facility are
safe.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Maintaining a safe environment in
your franchise is not only a responsibility, it's also a good business
decision.  Accidents that can be attributed to poor maintenance or neglect can
lead to significant financial exposure in the form of regulatory sanctions or
lawsuits.  A trip over a misplaced wastepaper basket or a slip on a rug is all
it takes.</p>

<p class=MsoNormal style='text-align:justify'> </p>

<p class=MsoNormal style='text-align:justify'>The key to maintaining a safe
environment is in the training you give your employees, and in keeping your
eyes open at all times.  To minimize accidents which can cause injury, disrupt
normal operations, or damage facilities, equipment or property, your
responsibilities include the following:</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;
</span></span>See that unsafe conditions or practices are promptly eliminated.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;
</span></span>Frequently remind all employees in the safe use of tools and
equipment.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;
</span></span>Continually be a good role model in safety consciousness.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;
</span></span>Make routine inspections of office for safety hazards.</p>

<p class=MsoNormal style='text-align:justify'><a name="_Toc272322145"><b>&nbsp;</b></a></p>

<p class=MsoNormal style='text-align:justify'><b><u>Safety Checklist</u></b></p>

<p class=MsoNormal style='text-align:justify'><b><u><span style='text-decoration:
 none'>&nbsp;</span></u></b></p>

<p class=MsoNormal style='text-align:justify'>Use this list to periodically
evaluate the safety of your office:</p>

<p class=MsoNormal style='text-align:justify'><b>&nbsp;</b></p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in;
line-height:115%'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Are emergency phone numbers posted and readily available?                 </p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in;
line-height:115%'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Are all floors clean and in good repair?                                           </p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in;
line-height:115%'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Are cover plates missing on any electrical equipment outlets or
switches?         </p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in;
line-height:115%'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Any electrical breakers or main switches hard to reach or
inaccessible?  </p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in;
line-height:115%'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Are there any extension cords or frayed wiring being used?                     </p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in;
line-height:115%'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Are aisle-ways in the back room congested or blocked?                            </p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in;
line-height:115%'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Are storage shelves overloaded, unsecured, or unsteady?                        </p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in;
line-height:115%'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Are multipurpose fire extinguishers located within easy
reach?                           </p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in;
line-height:115%'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Have fire extinguishers been inspected in the last 12 months?                 </p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in;
line-height:115%'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Are access covers missing from any heat generating equipment?             </p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in;
line-height:115%'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Do lights work in all storage areas?                                      </p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in;
line-height:115%'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Are trash receptacles kept clean and regularly emptied?                           </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>This checklist provides a list of
common hazards.  It is intended to help increase your safety awareness.  Be
aware that this checklist is not all-inclusive.  You must look at other
possible hazards not included in this list.  Your office represents the DENTAL
SLEEP SOLUTIONS&reg; franchise every day of the week and for this reason, it should
be clean, safe and secure. </p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027174"></a><a name="_Toc351024573"></a><a
name="_Toc351024455">TRADEMARKED MERCHANDISE</a></h2>

<p class=MsoNormal><span style='color:red'>&nbsp;</span></p>

<p class=MsoNormal>We do not currently have any trademarked merchandise for our
franchise system, but we may offer it in the future.  These items will be
available only through us or a designated supplier and the program details will
be provided at that time.</p>

<b><span style='font-size:12.0pt;line-height:120%;font-family:"Calibri","sans-serif"'><br
clear=all style='page-break-before:always'>
</span></b>

<p class=MsoNormal><b>&nbsp;</b></p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><img width=287 height=1091
src="includes/manual_operations_assets/image011.png"
align=left hspace=12 vspace=10
alt="Text Box: Operations&#13;&#10;Manual&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;Dental Sleep Solutions&reg;&#13;&#10;"></p>

<p class=MsoNormal><span style='font-size:36.0pt;line-height:120%;font-family:
"Cambria","serif"'>Section V</span></p>

<p class=MsoNormal><b><span style='font-size:28.0pt;line-height:120%;
font-family:"Cambria","serif"'>Fees</span></b></p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoListParagraphCxSpFirst style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>System License &amp; Case Management Fees</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>System License Fee</p>

<p class=MsoListParagraphCxSpLast style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Case Management Fee</p>

<b><span style='font-size:12.0pt;line-height:120%;font-family:"Calibri","sans-serif"'><br
clear=all style='page-break-before:always'>
</span></b>

<p class=MsoNormal><b>&nbsp;</b></p>

<div style='border:none;border-bottom:solid windowtext 3.0pt;padding:0in 0in 1.0pt 0in'>

<h1 style='border:none;padding:0in'><a name="_Toc351027175"></a><a
name="_Toc351024574"></a><a name="_Toc351024456">5.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span>Fees</a></h1>

</div>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<h2><a name="_Toc351027176"></a><a name="_Toc351024575"></a><a
name="_Toc351024457">SYSTEM LICENSE &amp; CASE MANAGEMENT FEES</a> </h2>

<p class=MsoNormal><span style='color:#0070C0'>&nbsp;</span></p>

<h3 style='text-align:justify'><a name="_Toc351027177"></a><a
name="_Toc351024576"></a><a name="_Toc351024458">System License Fee</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>The monthly System License Fee is
for your use of the Marks and DENTAL SLEEP SOLUTIONS&reg;' System.  This Fee is due
in the third month after you sign the Franchise Agreement and then monthly for
the term of your Agreement.  The amount of the Fee is $695.00 and it will be
automatically withdrawn from your bank account on the 5th day of the month
under the terms of your Electronic Funds Transfer Authorization Agreement.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<h3 style='text-align:justify'><a name="_Toc351027178"></a><a
name="_Toc351024577"></a><a name="_Toc351024459">Case Management Fee</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>DENTAL SLEEP SOLUTIONS&reg;' Practice
Manager software will automatically create a monthly Case Management Fee
invoice which will be submitted to you electronically and will be based on the
number of patients who have completed their Comprehensive Exams &amp;
Impressions appointment that month.  The Case Management Fee is $195.00 per
completed case.  This amount will be automatically withdrawn from your bank
account on the 5th day of the month under the terms of your Electronic Funds
Transfer Authorization Agreement.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Note: You are REQUIRED to report
ALL patients who are eligible for the Case Management Fee.  Dental Sleep
Solutions Franchising, LLC depends on this Case Management Fee to help verify
production and negotiate further discounts for its members.  Failure to report
Case Management Fees may result in fines and mandatory audits of your office
(per the terms of your Franchise Agreement).</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<span style='font-size:12.0pt;line-height:120%;font-family:"Calibri","sans-serif"'><br
clear=all style='page-break-before:always'>
</span>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><img width=287 height=1093
src="includes/manual_operations_assets/image012.png"
align=left hspace=12 vspace=10
alt="Text Box: Operations&#13;&#10;Manual&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;Dental Sleep Solutions&reg;&#13;&#10;&#13;&#10;"></p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><span style='font-size:28.0pt;line-height:120%;font-family:
"Cambria","serif"'>Section VI</span></p>

<p class=MsoNormal><b><span style='font-size:28.0pt;line-height:120%;
font-family:"Cambria","serif"'>Advertising</span></b></p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoListParagraphCxSpFirst style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Advertising - A General Overview</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Advertising Program</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Purpose Of Advertising</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Creating The Ad Budget</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Selecting The Right Media</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Newspapers</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Radio</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>The Yellow Pages</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Independent Local Directories</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Direct Mail</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>The Internet</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Public Speaking</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>The Best Advertisement There Is: You</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Measuring Advertising Effectiveness            </p>

<p class=MsoListParagraphCxSpMiddle style='text-indent:-.25in'><span
style='font-family:Symbol'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span></span>Approved Advertising Materials &amp; Promotional Programs</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>The Grand Opening</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Ongoing Advertising/Promotion</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Publicity</p>

<p class=MsoListParagraphCxSpMiddle style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>Publicity And How Publicity Programs Work</p>

<p class=MsoListParagraphCxSpLast style='margin-left:1.0in;text-indent:-.25in'><span
style='font-family:"Courier New"'>o<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;
</span></span>The Basics</p>

<span style='font-size:12.0pt;line-height:120%;font-family:"Calibri","sans-serif"'><br
clear=all style='page-break-before:always'>
</span>

<p class=MsoNormal>&nbsp;</p>

<div style='border:none;border-bottom:solid windowtext 3.0pt;padding:0in 0in 1.0pt 0in'>

<h1 style='border:none;padding:0in'><a name="_Toc351027179"></a><a
name="_Toc351024578"></a><a name="_Toc351024460">6.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span>Advertising</a></h1>

</div>

<h2><a name="_Toc351027180"></a><a name="_Toc351024579"></a><a
name="_Toc351024461">ADVERTISING - A GENERAL OVERVIEW</a></h2>

<p class=MsoNormal><span style='color:#0070C0'>&nbsp;</span></p>

<h3 style='text-align:justify'><a name="_Toc351027181"></a><a
name="_Toc351024580"></a><a name="_Toc351024462">Advertising Program</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>We have not established an
Advertising Fund. We have established and administer advertising programs for
the creation and development of marketing, advertising, and related programs
and materials on a system-wide basis<b>.  </b>We underwrite the cost of the
advertising programs which are administered by our Managing Members.  You are
not required to contribute to these programs.  As the DENTAL SLEEP SOLUTIONS&reg;
franchise system expands, we may create an advertising council. </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>We will develop and place
advertising for the DENTAL SLEEP SOLUTIONS&reg; franchise system; decide whether to
use advertising agencies and which ones; and decide which media to use, which
may include Internet, print, radio, television, public events, or direct mail. 
We restrict, designate, and have the right to approve or control all of your
e-commerce activities, including the Internet, as they relate to sleep
medicine. <span lang=EN-GB>Your DENTAL SLEEP SOLUTIONS&reg; sleep medicine practice
will be promoted on our main corporate website which is currently
www.dentalsleepsolutions.com.</span> You may also promote DENTAL SLEEP
SOLUTIONS&reg; on your dental practice website but we must review and approve your
content prior to adding it to your website.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>We will provide you with copies
of our available advertising material, if you desire, at our cost.  You may
also develop and use your own advertising material, but samples of <u>all</u>
advertising, promotional, and marketing material that we have not prepared or
approved must be submitted for our approval before you use them.  If you do not
receive our written approval within fifteen days after we receive the
materials, the materials will be considered disapproved.  You may not use any
advertising or promotional materials that we have disapproved. </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>When using the DSS logo, you must
use our supplied artwork.  In addition to promotional material, this artwork
will be used for business cards, stationery, envelopes, etc.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>If you develop your own marketing
and promotional materials and want to use the &quot;DSS&quot; shades of blue,
we recommend using the following hexadecimal color model shades: </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>00447C (DSS Primary Blue) </p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>B8C4DB (DSS 2nd Blue)</p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>58A3E2 (DSS Accent Blue)</p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>002747(DSS Dark Accent Blue)</p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>FFFFFF (White)</p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>&bull;<span style='font:7.0pt "Times New Roman"'>&nbsp;
</span></span>Palette Below</p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify'><img border=0
width=524 height=126 id="Picture 1"
src="includes/manual_operations_assets/image013.png"></p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<h3 style='text-align:justify'><a name="_Toc351027182"></a><a
name="_Toc351024581"></a><a name="_Toc351024463">Purpose of Advertising</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Advertising can often be the
difference between a business that succeeds and one that doesn't.  While
word-of-mouth referrals will always be one of the most important aspects of
your business success, advertising provides a direct line of communication regarding
your franchise to large numbers of physicians and prospective patients.  There
is no more effective means of telling people in your trade area what you want
them to know or hear. </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Your advertising's primary
purpose is to accomplish the following:</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Wingdings'>v<span style='font:7.0pt "Times New Roman"'> </span></span>Convince
physicians, sleep labs and patients that your dental sleep therapy services are
the best.</p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Wingdings'>v<span style='font:7.0pt "Times New Roman"'> </span></span>Enhance
the image of your practice.</p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Wingdings'>v<span style='font:7.0pt "Times New Roman"'> </span></span>Point
out the need and create a desire for your services.</p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Wingdings'>v<span style='font:7.0pt "Times New Roman"'> </span></span>Announce
new products or<b> </b>services and programs.</p>

<p class=MsoNormal style='margin-left:.5in;text-align:justify;text-indent:-.25in'><span
style='font-family:Wingdings'>v<span style='font:7.0pt "Times New Roman"'> </span></span>Draw
patients to your location.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>While not all advertisements are
created equal, most effective ones have these characteristics in common:</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify'><b><span
style='font-family:"Franklin Gothic Medium","sans-serif"'>They are simple and
easily understood.</span></b></p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify'><b><span
style='font-family:"Franklin Gothic Medium","sans-serif"'>They are truthful and
sincere.</span></b></p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify'><b><span
style='font-family:"Franklin Gothic Medium","sans-serif"'>They are informative.</span></b></p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify'><b><span
style='font-family:"Franklin Gothic Medium","sans-serif"'>They are client-oriented.</span></b></p>

<p class=MsoNormal style='margin-left:1.0in;text-align:justify'><b><span
style='font-family:"Franklin Gothic Medium","sans-serif"'>They tell who, what,
when, how and why.</span></b></p>

<p class=MsoNormal style='margin-left:2.0in;text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Good advertising draws favorable
attention, from the right people, to your business.  It creates an interest in your
services, and an inclination to do business with you.  Most importantly, good
advertising causes action.  It persuades the prospective patient to call to get
more information on dental sleep medicine.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Consumers often don't realize the
need for certain products or<b> </b>services until educated by advertising.  The
same is true for physicians who routinely see patients with health issues
related to sleep disordered breathing.  This is why a new service such as ours
requires extensive advertising in the early months, and it explains in part why
advertising expenses are higher during the first few years.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Advertising also has a cumulative
effect, in that response is often slow at first, but tends to increase with
time.  For that reason, sporadic ad splurges rarely pay off.  History has shown
time and time again that it is better to advertise regularly and continuously on
a small scale, than to place large advertisements infrequently.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<h3 style='text-align:justify'><a name="_Toc351027183"></a><a
name="_Toc351024582"></a><a name="_Toc351024464">Creating the Ad Budget</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>How much is enough for an ad
budget?  One way to approach the question of budgeting is to ask, &quot;How
long is a piece of string?&quot;  The answer?  It's long enough to do the job. 
For most companies, this string is measured according to a percentage of
projected gross sales.  We recommend <b>a minimum </b>ad budget of 2% of your
gross sales. This is generally referred to as the<i> &quot;cost method,&quot;</i>
which correctly theorizes that an advertiser can't afford to spend more money
than he has. </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>By way of illustration, if your
projected gross sales for the first year, based on your business plan, are
$250,000, then by using the cost method to determine the advertising budget
(figuring 2% of sales), you would have $5,000, or about $400 a month, to work
with.  For your grand opening you would typically set aside $5,000 to $10,000
to establish the DENTAL SLEEP SOLUTIONS&reg; brand on your territory.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>That may not seem like much, and
for some businesses it won't be - they need a longer string in order to get the
job done.  These businesses base their advertising budgets on the amount of
money needed to move the product or sell the service, an approach which is called
the <i>&quot;task method.&quot;</i>  There are many different ways to determine
the amount of money needed to move the product, but the most common and
probably effective way is through experience.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Since you are new to dental sleep
medicine, you don't have past records to guide you though.  You know your
objective is to identify and set appointments for people with sleep disordered
breathing issues in order to introduce them to your services, but only by
experimenting to a certain degree will you know for sure what's going to work
in your market and what isn't.  We will be able to give you some good ideas. 
By utilizing our knowledge, balancing it against your own business plan, then
finding out what media will be appropriate and what the cost will be to
effectively advertise using those media, you should be able to mount an
effective campaign and control your costs at the same time.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<h3 style='text-align:justify'><a name="_Toc351027184"></a><a
name="_Toc351024583"></a><a name="_Toc351024465"></a><a name="_Toc276557632">Selecting
the Right Media</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Advertising media generally used
in this business include the following:</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>                        <b><i>Local</i></b>
<b><i>Newspapers                  Yellow Pages</i></b></p>

<p class=MsoNormal style='text-align:justify'><b><i>                        Radio                                      Independent
Local Directories</i></b></p>

<p class=MsoNormal style='text-align:justify'><b><i>                        Direct
Mail                             The Internet   </i></b></p>

<p class=MsoNormal style='text-align:justify'><b><i>                        Public
Speaking</i></b></p>

<p class=MsoNormal style='text-align:justify'><b><i>                        </i></b></p>

<p class=MsoNormal style='text-align:justify'><b><i>                                                </i></b></p>

<p class=MsoNormal style='text-align:justify'>Below is a brief discussion of
the above-mentioned media and some key facts on each.</p>

<p class=MsoNormal style='text-align:justify'><a name="_Toc276557633"></a><a
name="_Toc252271327"><b><span style='color:red'>&nbsp;</span></b></a></p>

<h3 style='text-align:justify'><a name="_Toc351027185"></a><a
name="_Toc351024584"></a><a name="_Toc351024466">Newspapers</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Despite the increasing reliance
on the Internet for news and information, some newspapers are still well-read
and a daily habit for many people.   In addition, smaller circulation community
newspapers, which are often published on a weekly basis, can have strong local
support, making newspapers an effective local advertising tool in some markets.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Local newspapers that service the
community in which your business is located can provide a direct link to your
potential patients and are usually a fairly cost-effective buy.</p>

<p class=MsoNormal style='text-align:justify'><a name="_Toc252271328"><b><i>&nbsp;</i></b></a></p>

<h3 style='text-align:justify'><a name="_Toc351027186"></a><a
name="_Toc351024585"></a><a name="_Toc351024467"></a><a name="_Toc276557634">Radio</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Radio is an integral part of
American culture.  In some way, it touches the lives of almost everyone, every
day, by offering a form of entertainment that attracts listeners almost
irrespective of what they are doing.  In 2004, there were over 10,000 radio
stations in the U.S. with a wide variety of formats (news, talk, Top 40,
country, classical, etc.).  Radio can be a very cost effective medium for the
right business and message; it affords broad coverage and the ability to
pinpoint specific demographic targets.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<h3 style='text-align:justify'><a name="_Toc351027187"></a><a
name="_Toc351024586"></a><a name="_Toc351024468"></a><a name="_Toc276557635"></a><a
name="_Toc252271329"></a><a name="_Toc346843179"></a><a name="_Toc346255649"></a><a
name="_Toc346125757">The Yellow Pages</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Most local businesses still
advertise in the Yellow Pages, whether they use the online version, the books
themselves or a combination of both.  Understand your demographic target and
explore all the options to see what is the best fit for promoting your
business.</p>

<p class=MsoNormal style='text-align:justify'><a name="_Toc252271330"><b><i>&nbsp;</i></b></a></p>

<h3 style='text-align:justify'><a name="_Toc351027188"></a><a
name="_Toc351024587"></a><a name="_Toc351024469"></a><a name="_Toc276557636">Independent
Local Directories</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>In many communities, local
directories are still available and can be a good alternative to Yellow Page
advertising when dollars are limited.  These directories are focused on just
one or two towns and can be a useful tool for consumers and businesses alike
when looking for products and services.  </p>

<p class=MsoNormal style='text-align:justify'><a name="_Toc252271331"></a><a
name="_Toc346843192"></a><a name="_Toc346255662"></a><a name="_Toc346125770"><b><i>&nbsp;</i></b></a></p>

<h3 style='text-align:justify'><a name="_Toc351027189"></a><a
name="_Toc351024588"></a><a name="_Toc351024470"></a><a name="_Toc276557637">Direct
Mail</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Direct mail advertising can be
defined as the controlled distribution of information to a selected audience. 
It offers you more flexibility of budgeting and greater selectivity in choosing
prospects than other kinds of advertising.  It also allows you to send a
personalized sales message to prospective customers.</p>

<p class=MsoNormal style='text-align:justify'><a name="_Toc252271332"><b><i>&nbsp;</i></b></a></p>

<h3 style='text-align:justify'><a name="_Toc351027190"></a><a
name="_Toc351024589"></a><a name="_Toc351024471"></a><a name="_Toc276557638">The
Internet</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Your internet presence will be
handled by us; your practice will be promoted on our corporate website. 
Inquiries that come through the website or our 800 number call center will be
screened and passed along to you.  <a name="_Toc252271333"></a><a
name="_Toc346843194"></a><a name="_Toc346255664"></a><a name="_Toc346125772"></a></p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<h3 style='text-align:justify'><a name="_Toc351027191"></a><a
name="_Toc351024590"></a><a name="_Toc351024472">Public Speaking</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>A recent Gallup Poll listed
glossophobia, or the fear of public speaking, second only to snakes as the top
listed fears of Americans.  We have a recommendation for you:  get over it and
just do it!   Numerous civic and community organizations exist who are always
looking for public speakers:  Rotary Clubs, Lions Clubs, Optimist Clubs,
churches, community outreach and educational clubs, the list goes on&hellip; Your DSS
team will gladly give you a PowerPoint presentation that you can use when you
decide to conquer this fear and get behind the podium.  You won't regret it.</p>

<h3 style='text-align:justify'><a name="_Toc351027192"></a><a
name="_Toc351024591"></a><a name="_Toc351024473"></a><a name="_Toc276557640"></a><a
name="_Toc252271334"></a><a name="_Toc346843171"></a><a name="_Toc346255641"></a><a
name="_Toc346125749">The Best Advertisement There Is: You</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Word-of-mouth is always an
important aspect in the growth of any business.  Happy patients can steer
dozens of other patients into your franchise.  By the same token, a
dissatisfied patient will often go to great lengths to let their friends and
acquaintances know that they had a bad experience somewhere.  The moral of that
truth is a simple one.  Take care of your patients, and they will take care of
you.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>While your activities inside the
franchise are important, it's also true that many successful business people
are frequently well-known (personally) in their communities.  This is no
accident, for smart business people know the importance of making contacts;
they become active in their communities - joining and leading civic
organizations, attending charity events, speaking at seminars, getting involved
in politics, attending openings of other businesses and events at local
institutions.  Of course, the proper running of your business comes first, but
time spent developing contacts and maintaining a visible public profile does
pay off.</p>

<p class=MsoNormal style='text-align:justify'><a name="_Toc252271335"></a><a
name="_Toc346843195"></a><a name="_Toc346255665"></a><a name="_Toc346125773"><b><i>&nbsp;</i></b></a></p>

<h3 style='text-align:justify'><a name="_Toc351027193"></a><a
name="_Toc351024592"></a><a name="_Toc351024474"></a><a name="_Toc276557641">Measuring
Advertising Effectiveness</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>As a business owner, you should
never stop surveying and studying the results of your advertising and marketing
efforts.  Keep an eye on how well your programs are working and on how much of
a return you're getting on your advertising dollars.  The most important tool
for measuring advertising effectiveness is simply asking the question, &quot;how
did you hear about us?&quot; any time you have a new patient inquire about your
service.  To the best of your ability, carefully track and monitor sales
results whenever you place a new ad or try a new advertising vehicle.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>These checks cannot provide
precise measurements, but they will at least give you some idea how your
program is performing.  Remember that timing, the advertising message, and such
uncontrollable factors as weather, the season, competitors' activities, and
general economic conditions will affect any advertising program.  Also keep in
mind that even if initial results are not significant, the program may still
have served an institutional purpose by telling people your business is there. 
If even some of those people give you their business in the future, you've
still realized a return on your investment.</p>

<b><u><span style='font-size:18.0pt;line-height:120%;font-family:"Cambria","serif";
text-transform:uppercase'><br clear=all style='page-break-before:always'>
</span></u></b>

<h2><a name="_Toc351027194"></a><a name="_Toc351024593"></a><a
name="_Toc351024475">APPROVED ADVERTISING MATERIALS &amp; PROMOTIONAL PROGRAMS</a></h2>

<p class=MsoNormal><b><span style='color:red'>&nbsp;</span></b></p>

<h3><a name="_Toc351027195"></a><a name="_Toc351024594"></a><a
name="_Toc351024476">The Grand Opening</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>You may want to consider hosting a social event such as an
"open house" or a "grand opening".  Although you are not required to do so,
such an event could be used to invite prominent citizens and members of the
health care community to your office.  Meeting in an informal and social
setting would provide you with an opportunity to network and would more than
likely benefit your practice through increased referral sources.</p>

<p class=MsoNormal>&nbsp;</p>

<h3><a name="_Toc351027196"></a><a name="_Toc351024595"></a><a
name="_Toc351024477">Ongoing Advertising/Promotion</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal>Successful advertising and promotion of your dental sleep
medicine practice requires an ongoing commitment in time, energy, and
finances.  Dental Sleep Solutions&reg; will guide and assist you in deciding how
best to utilize your available resources.</p>

<b><u><span style='font-size:16.0pt;line-height:120%;font-family:"Cambria","serif"'><br
clear=all style='page-break-before:always'>
</span></u></b>

<h3><a name="_Toc351027197"></a><a name="_Toc351024596"></a><a
name="_Toc351024478">Publicity</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Your DENTAL SLEEP SOLUTIONS&reg;
franchise includes a series of letters that we send out on your behalf
introducing your services to health care professionals in your area. 
We have an introductory letter available to send, and you are encouraged to send it to all of your adult patients letting them
know you are part of the DENTAL SLEEP SOLUTIONS&reg; team and that you are now offering
dental sleep therapy services.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>You can continue this process by
developing press releases for the local media.  Promoting your franchise and
its name in the community is an important element of both positive public
relations and building your business base.  The objective of publicity is to
increase awareness of a business, to develop an association or mental link
between the name DENTAL SLEEP SOLUTIONS&reg; and a provider of quality dental sleep
therapy services, and to establish yourself in the community as a caring
corporate citizen.  Publicity is especially effective for making your grand
opening announcement and most local media will be happy to run your press
release, or interview you themselves, for a story about your new business.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>Effective promotion of any
business requires a combination of time, creativity, energy and commitment. 
Financial resources can also be very helpful, but many effective programs can
be run for little to no cost.  After reviewing the previous section of this Manual related to advertising, you should have a better understanding of how to use the media to get your trade name heard and recognized.  The information that follows will help you build on that knowledge by giving
you some tested, practical means of creating exposure for your business, of
developing an identity that people will remember.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<h3 style='text-align:justify'><a name="_Toc351027198"></a><a
name="_Toc351024597"></a><a name="_Toc351024479"></a><a name="_Toc247958252">Publicity
and How Publicity Programs Work</a></h3>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>A well-crafted publicity program
can be used to generate a very effective, low-cost promotion for a business,
and ultimately increase profits.  The basic objective is to create or increase
public awareness about an activity, or convey a message of general public
interest using press releases.</p>

<p class=MsoNormal style='text-align:justify'> </p>

<p class=MsoNormal style='text-align:justify'>A press release is a story/news
article written about a given subject by a knowledgeable person who acts as an
independent reporter, then submits the story to different media.  Press
releases typically announce new products or services offered, earnings or
losses, promotions or changes in personnel, etc., and, as such, are a natural
for announcing that a new business is opening.</p>

<p class=MsoNormal style='text-align:justify'> </p>

<p class=MsoNormal style='text-align:justify'>Press releases are sent to
editors and news directors of newspapers, magazines, television and radio
stations. Releases may be targeted to specific editors, such as Sports Editors,
Feature Editors, and Business Editors.  (For example, a new franchise opening
might be targeted to a Feature or Business Editor.)  Editors, in turn, decide
what news will be included in their publication or upcoming broadcast.  The
goal of a release is to capture an editor's attention with facts and
information that would be of both interest and benefit to his audience.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>A magazine or newspaper editor
may print or rewrite a portion of the release, or print the entire release and
include a photo.  He may also pass the release to a reporter to use for a
feature article or interview.  Trade magazines, an excellent resource for press
releases, differ from consumer magazines in that they are written for and read
by industry, not consumers.  Television and radio stations may use the release
as a news brief or as part of a feature report.  </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>You may want to hire a
professional to create press releases for you.  <u>ALL</u> press releases must
be sent to us for review and approval before you distribute them.</p>

<p class=MsoNormal style='text-align:justify'><a name="_Toc247958253"><b><i>&nbsp;</i></b></a></p>

<h3 style='text-align:justify'><a name="_Toc351027199"></a><a
name="_Toc351024598"></a><a name="_Toc351024480">The Basics</a></h3>

<p class=MsoNormal style='text-align:justify'>Even if you have never been
involved in a publicity program before, there are some basic ways to get the
word out on your new business:</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='margin-left:31.5pt;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>v<span style='font:7.0pt "Times New Roman"'>
</span></span>Organize an informational breakfast, lunch or after-hours meeting
to introduce your new business to interested area physicians and sleep labs.</p>

<p class=MsoNormal style='margin-left:31.5pt;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>v<span style='font:7.0pt "Times New Roman"'>
</span></span>Organize an informational evening/weekend seminar for potential
patients.</p>

<p class=MsoNormal style='margin-left:31.5pt;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>v<span style='font:7.0pt "Times New Roman"'>
</span></span>Call your local newspaper and invite them to send a reporter to
take pictures and do a brief story.</p>

<p class=MsoNormal style='margin-left:31.5pt;text-align:justify;text-indent:
-.25in'><span style='font-family:Wingdings'>v<span style='font:7.0pt "Times New Roman"'>
</span></span>Contact physicians and sleep labs and discuss ways that you can
create promotional alliances; each business could have information on the other
to share with their patients or you could sponsor some sort of joint promotion.</p>

<p class=MsoListParagraph style='margin-left:31.5pt'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>IN SUMMARY, we hope you have
found this Franchise Operations Manual to be a valuable resource for your
dental sleep medicine practice.  We have made every effort to make it a complete
"cookbook" for how best to practice this new and exciting facet of dentistry. 
Welcome to our team!</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<span style='font-size:12.0pt;line-height:120%;font-family:"Calibri","sans-serif"'><br
clear=all style='page-break-before:always'>
</span>

<p class=MsoNormal align=center style='text-align:center'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><img width=287 height=1093
src="includes/manual_operations_assets/image014.png"
align=left hspace=12 vspace=10
alt="Text Box: Operations&#13;&#10;Manual&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;&#13;&#10;Dental Sleep Solutions&reg;&#13;&#10;&#13;&#10;"></p>

<p class=MsoNormal>&nbsp;</p>

<p class=MsoNormal><span style='font-size:28.0pt;line-height:120%;font-family:
"Cambria","serif"'>&nbsp;</span></p>

<p class=MsoNormal><span style='font-size:28.0pt;line-height:120%;font-family:
"Cambria","serif"'>&nbsp;</span></p>

<p class=MsoNormal><b><span style='font-size:28.0pt;line-height:120%;
font-family:"Cambria","serif"'>Appendix A</span></b></p>

<p class=MsoNormal><b><span style='font-size:22.0pt;line-height:120%;
font-family:"Cambria","serif"'>&nbsp;</span></b></p>

<p class=MsoNormal><b><span style='font-size:22.0pt;line-height:120%;
font-family:"Cambria","serif"'>&nbsp;</span></b></p>

<p class=MsoNormal><b><span style='font-size:22.0pt;line-height:120%;
font-family:"Cambria","serif"'>Dental Sleep Solutions<sup>&reg;</sup></span></b></p>

<p class=MsoNormal><b><span style='font-size:28.0pt;line-height:120%;
font-family:"Cambria","serif"'>FORMS</span></b></p>

<p class=MsoNormal><b><span style='font-size:28.0pt;line-height:120%;
font-family:"Cambria","serif"'>&nbsp;</span></b></p>

<b><span style='font-size:28.0pt;font-family:"Cambria","serif"'><br clear=all
style='page-break-before:always'>
</span></b>

<p class=MsoNormal style='line-height:normal'><b><span style='font-size:28.0pt;
font-family:"Cambria","serif"'>&nbsp;</span></b></p>

<div style='border:none;border-bottom:solid windowtext 3.0pt;padding:0in 0in 1.0pt 0in'>

<h1 style='border:none;padding:0in'><a name="_Toc351027200"></a><a
name="_Toc351024599"></a><a name="_Toc351024481">7.<span style='font:7.0pt "Times New Roman"'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</span>Appendix A</a></h1>

</div>

<h2><a name="_Toc351027201"></a><a name="_Toc351024600"></a><a
name="_Toc351024482">Dental Sleep SolutionS<sup>&reg;</sup> Forms</a></h2>

<h3 style='text-align:justify'><a name="_Toc351027202"></a><a
name="_Toc351024601"></a><a name="_Toc351024483">List of Forms</a></h3>

<p class=MsoListParagraph style='margin-left:1.0in'><b>&nbsp;</b></p>

<p class=MsoNormal style='margin-bottom:10.0pt;line-height:115%'><b>NOTE: The
available forms may change from time to time.  A complete listing of the Dental
Sleep Solutions&reg; forms can always be found in the "PROCEDURES MANUAL" document.</b></p>

<p class=MsoNormal style='text-align:justify'><b>New Patient Forms</b></p>

<p class=MsoNormal style='text-align:justify'>These are a printed copy of the
patient information and comprehensive health and sleep questionnaire that is
ideally completed via the web portal.</p>

<p class=MsoNormal style='text-align:justify'><b>&nbsp;</b></p>

<p class=MsoNormal style='text-align:justify'><b>Record Release </b></p>

<p class=MsoNormal style='text-align:justify'>This form is included in the <b>New
Patient Forms </b>completed via the web portal or via the paper forms.  It's
always a good idea to have this on file in your patient records; you must have
this signed form in order to release sensitive health care information that you
have to another doctor.  Likewise, the doctor we are requesting a sleep study
from should have a signed form from our patient as well.  If we have the
patient in our office, we can get them to sign the form authorizing the sleep
lab or doctor to release the sleep study to you.  We then fax that signed form
to that lab or person so that they can legally release the study.  US having
the form, signed and filled out appropriately, will save time and hassle of our
patient having to do this for another office.</p>

<p class=MsoNormal style='text-align:justify'><b>&nbsp;</b></p>

<p class=MsoNormal style='text-align:justify'><b>Affidavit for Intolerance to
CPAP </b><i>(if applicable)</i></p>

<p class=MsoNormal style='text-align:justify'>This form is included in the <b>New
Patient Forms </b>completed via the web portal or via the paper forms. For patients
who have had a sleep study and been diagnosed with sleep apnea and tried/failed
at CPAP therapy, this form is occasionally required by an insurance company in
order to get insurance coverage for a dental device.  We make it available for
you but do not require it unless it is requested by the insurance company.  If
it is required, have the patient complete it and scan it into the software.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><b>Non-Dentist of Record Release</b></p>

<p class=MsoNormal style='text-align:justify'>This form is to be given to all
patients who are <b><u>not</u></b> regular patients of yours.  It is designed
to explain to patients that they will need to seek their <b><u>routine dental
care</u></b> at their regular dentist's office and that the scope of the dental
exam is not intended to replace their routine dental visits. </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><b>Informed Consent</b></p>

<p class=MsoNormal style='text-align:justify'>This form must be reviewed and
signed by every patient prior to treatment.  It is <u>extremely important</u>
that all patients are informed of possible side effects of dental sleep
therapy.  TREATMENT SHOULD NOT BE PROVIDED WITHOUT A SIGNED CONSENT.  This
completed form must be scanned into the software.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><b>Home Care Instructions  </b></p>

<p class=MsoNormal style='text-align:justify'>These instructions detail the
care and use of the patient's dental sleep device.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><b>Device Titration </b></p>

<p class=MsoNormal style='text-align:justify'>This form is given to the patient
when it has been determined that he will advance the device over a period of
time on his own.  It should be customized to fit the particular patient's needs
and device type.  Ask the patient to keep track of their adjustments on this
form and to bring this form with them each time they come in for follow up. </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'>When you have finished titration
and confirmed a treatment position verified by a sleep test, you should scan
the <b>Device Titration</b> form into the patient's record and then it is no
longer needed.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><b>Device Titration (EMA)</b></p>

<p class=MsoNormal style='text-align:justify'>This form is used in place of the
<b>Device Titration </b>form<b> </b>for patients utilizing an EMA device.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><b>Sleep Recorder Release </b></p>

<p class=MsoNormal style='text-align:justify'>This form is signed when a
patient takes home your home sleep recorder to insure its safe return.  An
imprint from a credit card is also taken from the patient when he is given this
form.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><b>Medical History Update</b></p>

<p class=MsoNormal style='text-align:justify'>This form is utilized to prompt
your patient to remind you about any changes in health history or medicines.  Have
the patient fill this out and then scan into the patient's chart.  In addition,
document appropriately in the progress notes and Questionnaire tab.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><b>Financial Agreement</b></p>

<p class=MsoNormal style='text-align:justify'>This is a financial agreement
template that may be useful in formalizing patient payments and insurance
co-payments<i>.  Note:  This manual is not intended to replace obtaining legal
advice for financial and insurance agreements.  All financial forms and
agreement polices should be reviewed by your local counsel with respect to
state and federal laws.</i></p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><b>Financial Agreement (Medicare)</b></p>

<p class=MsoNormal style='text-align:justify'>This is a financial agreement
template that may be useful in formalizing patient payments with Medicare
patients.  <i>Note:  This manual is not intended to replace obtaining legal
advice for financial and insurance agreements.  All financial forms and
agreement polices should be reviewed by your local counsel with respect to
state and federal laws.</i></p>

<p class=MsoNormal style='text-align:justify'><i>&nbsp;</i></p>

<p class=MsoNormal style='text-align:justify'><b>ESS/TSS</b></p>

<p class=MsoNormal style='text-align:justify'>This form contains a written copy
of the Epworth Sleepiness Scale and the Thornton Snoring Scale.   It is
normally not utilized because these forms are typically completed in the
software. </p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><b>The Dental Sleep Solutions&reg;
Experience</b></p>

<p class=MsoNormal style='text-align:justify'>This form will provide a detailed
description of the entire Dental Sleep Solutions&reg; protocol for dental sleep
therapy.</p>

<p class=MsoNormal style='text-align:justify'>&nbsp;</p>

<p class=MsoNormal style='text-align:justify'><b>Intro Letter to Pts of Record</b></p>

<p class=MsoNormal style='text-align:justify'>This is a letter template to send
out to all of your existing patients of record in your dental practice.  It
notifies them that you are now a Dental Sleep Solutions&reg; dentist and that you
offer treatment for OSA and snoring.</p>

<p class=MsoNormal style='margin-bottom:10.0pt;line-height:115%'><b>&nbsp;</b></p>

<span style='font-size:12.0pt;line-height:120%;font-family:"Calibri","sans-serif"'><br
clear=all style='page-break-before:always'>
</span>

<p class=MsoNormal><b><span style='font-size:24.0pt;line-height:120%;
font-family:"Franklin Gothic Medium","sans-serif"'>&nbsp;</span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b><span
style='font-size:24.0pt;line-height:120%;font-family:"Franklin Gothic Medium","sans-serif"'>&nbsp;</span></b></p>

<p class=MsoNormal align=center style='text-align:center'><b><span
style='font-size:28.0pt;line-height:120%;font-family:"Franklin Gothic Medium","sans-serif"'>&nbsp;</span></b></p>

<p class=MsoNormal align=center style='text-align:center;line-height:normal'><b><span
style='font-size:20.0pt;font-family:"Franklin Gothic Medium","sans-serif"'>DENTAL
SLEEP SOLUTIONS<sup>&reg; </sup>FRANCHISING LLC</span></b></p>

<p class=MsoNormal align=center style='text-align:center;line-height:normal'><b><span
style='font-size:20.0pt;font-family:"Franklin Gothic Medium","sans-serif"'>&nbsp;</span></b></p>

<p class=MsoNormal align=center style='margin-top:12.0pt;text-align:center;
line-height:normal'><b><span style='font-size:28.0pt;font-family:"Franklin Gothic Medium","sans-serif"'>SYSTEMS
&amp; OPERATIONS MANUAL</span></b></p>

<p class=MsoNormal align=center style='text-align:center;line-height:normal'><b><span
style='font-size:28.0pt;font-family:"Franklin Gothic Medium","sans-serif";
color:white;background:black'>&nbsp;</span></b></p>

<p class=MsoNormal align=center style='text-align:center;line-height:normal'><b><span
style='font-size:28.0pt;font-family:"Franklin Gothic Medium","sans-serif";
color:white;background:black'>LICENSE #<?= $_SESSION['docid']; ?></span></b></p>

<p class=MsoNormal align=center style='text-align:center;line-height:normal'><b><span
style='font-size:28.0pt;font-family:"Franklin Gothic Medium","sans-serif";
color:white;background:black'>FOR USE BY: <?= $docname; ?></span></b></p>

<p class=MsoNormal align=center style='text-align:center'><span
style='font-size:20.0pt;line-height:120%;font-family:"Times New Roman","serif"'>&nbsp;</span></p>

<p class=MsoNormal align=center style='text-align:center;punctuation-wrap:simple;
text-autospace:none;vertical-align:baseline'><b><span style='font-size:16.0pt;
line-height:120%;font-family:"Franklin Gothic Medium","sans-serif"'>FOR THE USE
OF AUTHORIZED</span></b></p>

<p class=MsoNormal align=center style='text-align:center;punctuation-wrap:simple;
text-autospace:none;vertical-align:baseline'><b><span style='font-size:16.0pt;
line-height:120%;font-family:"Franklin Gothic Medium","sans-serif"'>FRANCHISEES/OPERATORS/MANAGERS</span></b></p>

<p class=MsoNormal style='punctuation-wrap:simple;text-autospace:none;
vertical-align:baseline'><b><span style='font-size:16.0pt;line-height:120%;
font-family:"Times New Roman","serif"'> </span></b></p>

<p class=MsoNormal style='punctuation-wrap:simple;text-autospace:none;
vertical-align:baseline'><b><span style='font-size:16.0pt;line-height:120%;
font-family:"Times New Roman","serif"'>&nbsp;</span></b></p>

<p class=MsoNormal align=center style='text-align:center;punctuation-wrap:simple;
text-autospace:none;vertical-align:baseline'><b><span style='font-size:22.0pt;
line-height:120%;font-family:"Bernard MT Condensed","serif"'>PROPRIETARY AND CONFIDENTIAL</span></b></p>

<p class=MsoNormal style='line-height:normal'>&nbsp;</p>

</div>

