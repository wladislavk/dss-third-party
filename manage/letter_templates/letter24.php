<?php

$template = "
<p>
%franchisee_fullname%<br />
%franchisee_practice%<br />
%franchisee_addr%
</p><p>&nbsp;</p>
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

<p>We delivered your %dental_device% dental device on %delivery_date% and our records show that you are not continuing with the treatment plan we created for you.  Please be aware that your decision not follow through on treatment has resulted in you being officially discharged from our sleep disorder program.</p>

<p>We now refer back to your primary care doctor to revisit other treatment options for sleep disordered breathing.  Should you wish to reactivate your treatment plan in the future, please contact us.</p>

<p>Sincerely,
<br />
<br />
<br />
Dr. %franchisee_fullname%<br />
</p>";

?>
