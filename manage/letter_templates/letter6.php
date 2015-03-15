<?php namespace Ds3\Legacy; ?><?php

$template = "
<p>
%franchisee_fullname%<br />
%franchisee_practice%<br />
%franchisee_addr%
</p>
<p>&nbsp;</p>
<p>%todays_date%</p>
<p>&nbsp;</p>
<table border=\"0\">
<tr>
<td width=\"70\"></td>
<td>
%contact_fullname%<br />
%practice%
%addr1%%addr2%<br />
%city%, %state% %zip%<br />
</td>
</tr>
</table>
<p>&nbsp;</p>

<p>Dear %contact_firstname%:</p>

<p>We appreciate the trust you have placed in us by scheduling a consultation appointment for an evaluation of your snoring and/or sleep apnea problem.  We will make every effort to honor that trust by providing the quality of care you require and deserve.</p>

<br />
<table width=\"500px\">
  <tr>
    <td width=\"50%\">Your appointment is scheduled for:</td>
    <td width=\"50%\">%consult_date%</td>
  </tr>
  <tr>
    <td width=\"50%\">Our address is:</td>
    <td width=\"50%\">%franchisee_addr%</td>
  </tr>
</table>
<br />

<p>If you have not already completed our patient forms, please plan on arriving 20 minutes before your scheduled appointment time to complete them.  If you have already filled them out, please remember to bring them with you.</p>

<p>If you have any questions that need to be answered prior to your appointment, please call us.  Our office staff will assist you in every way possible.  We look forward to meeting you!</p>


<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%<br />
%franchisee_phone%<br />
%franchisee_addr%</p>";

?>
