INSERT INTO dental_letter_templates SET
name="Pedo Referral", 
body="
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
<p>
Dear %salutation% %contact_lastname%:
</p>
<p>
We have a mutual patient, %patient_fullname%. As you recall, %patient_firstname% is a %patient_age% year old %patient_gender%. During oral examination it was noted that %patient_firstname% grinds %his/her% teeth at night, snores most nights, and appears to have enlarged tonsils/adenoids.
</p>
<p>We believe in screening not only adults but also children for sleep and breathing disorders. Crowded airways due to large tonsils and adenoids, as well as nasal congestion, all contribute to suboptimal sleep quality for many children. Please evaluate %patient_fullname% for a possible breathing disorder. We will continue to do all we can to develop the patient’s dentition and skeletal features to maximize airway patency.</p>
<p>Thank you for your willingness to work with us. Please keep us in mind for all of your sleep disordered breathing patients whom you think may benefit from Mandibular Repositioning Device therapy.</p>
<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%</p>
", default_letter=1;

