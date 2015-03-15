<?php namespace Ds3\Libraries\Legacy; ?><?php

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

<p>Dear %contact_salutation% %contact_lastname%:</p>

<p>*PLEASE TYPE THE TEXT OF THIS LETTER HERE*</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%</p>";

?>
