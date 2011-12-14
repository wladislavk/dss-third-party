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
%addr1%
%addr2%<br />
%city%, %state% %zip%<br />
</td>
</tr>
</table>
<p>&nbsp;</p>

<p>Dear %contact_firstname%:</p>

<p>We delivered your %dental_device% dental device on %delivery_date%.  Our follow up schedule mandates at least one follow up appointment within the first 30 days.  Somehow, you have slipped through the cracks.  We have no record of that visit.</p>

<p>Please contact our office immediately to schedule your follow up appointment.</p>

<p>Thank you.</p>

<p>Sincerely,
<br />
<br />
<br />
Dr. %franchisee_fullname%<br />
<br />
cc:<br />  %other_mds%</p>";

?>
