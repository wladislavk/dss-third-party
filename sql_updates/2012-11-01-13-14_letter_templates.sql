ALTER TABLE dental_letter_templates ADD COLUMN body text not null;
ALTER TABLE dental_letter_templates ADD COLUMN default_letter tinyint(1) not null default 0;

update dental_letter_templates SET default_letter=1;

UPDATE dental_letter_templates SET body="
<p>%company%<br />
%company_addr%
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
%city%, %state% %zip%<br /></td></tr></table>
<p>&nbsp;</p>
<p>
Dear %salutation% %contact_lastname%:
</p>
<p>
Thank you for allowing us a few moments of your time.  We represent Dental Sleep Solutions Franchising, LLC, a franchise entity that recruits, trains, and provides administrative support to dentists i
n the area of dental sleep medicine.
</p>
<p>
Our dentists receive training from Board Certified dentists in the areas of:<br /><ul>
<li>Sleep medicine and sleep disorders</li>
<li>Sleep Disordered Breathing (SDB)</li>
<li>Treatment options for SDB</li>
<ul>
<li>Including CPAP, dental device therapy, surgery, and behavioral solutions</li>
<li>Unique hybrid therapies that include mating CPAP to a dental device</li>
</ul>
</ul>
</p>
<p>
We are writing to you today to invite you to partner with us in diagnosing and treating patients with sleep disordered breathing.  We promote a team healthcare approach that involves the physician and dentist working closely to provide a successful treatment modality for each and every patient.  If you feel that your patients could benefit from a sleep screening consultation, we invite you to contact us directly so that we can put you in touch with a local Dental Sleep Solutions&reg; provider.  Rest assured that when you are dealing with a Dental Sleep Solutions&reg; dentist, you are dealing with an individual who understands the issues and the treatment options. 
</p>
<p>
Please don't hesitate to call if you have any questions.
We look forward to a long and prosperous relationship and thank you for your referrals in advance.
</p>
<p>
Regards,
<br />
<br />
<br />
<table width=\"100%\">
<tr>
<td width=\"60%\">
Richard B. Drake, DDS
</td>
<td width=\"40%\">
George \"Gy\" Yatros, DMD
</td>
</tr>
</table>
</p>" WHERE id=1;


UPDATE dental_letter_templates SET body="
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

<p>Dear Dr. %contact_lastname%:</p>

<p>Thank you for allowing me a few minutes of your time.  My name is %franchisee_fullname%, and I am a dentist who has partnered with Dental Sleep Solutions&reg;, a company committed to maximizing successful treatment options for patients who suffer from sleep disordered breathing.    As a Dental Sleep Solutions&reg; Dentist, I have completed a \"mini residency\" training program put on by nationally known Board Certified dentists; our office adheres to practice protocols that are consistent with the highest levels of patient care.</p>
<p>We welcome your referrals for the treatment of snoring, upper airway resistance syndrome, and obstructive sleep apnea.    We evaluate patients individually and recommend treatment plans based on disease severity and patient preferences, all the while following the guidelines as laid down by the American Academy of Sleep Medicine's (AASM) position paper on the parameters  for use of oral appliances in the treatment of OSA, as appeared  in the February, 2006 issue of <i>Sleep</i>.   It states that oral appliances may be used as a first line of therapy for patients with mild to moderate OSA as well as for patients who are severe and have failed CPAP or who prefer them to CPAP.</p>

<p>We are working closely with physicians such as you who recognize the importance of diagnosing and treating this illness.  As awareness of the ill effects of OSA (hypertension, MI, CHF, stroke, fatigue, impotence, mood swings, and dozing accidents) increases in the public's eye, all of medicine will begin to see an increasing number of patients asking questions about snoring and sleep apnea and seeking treatment options.  We hope you'll consider referring these patients to us.</p>

<p>Again, thank you for your time, and I look forward to working with you.</p>

<p>Regards,
<br />
<br />
<br />
%franchisee_fullname%</p>
" WHERE id=2;

UPDATE dental_letter_templates SET body="
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

<p>Are you tired at times when you don't want to be?  Do you find it difficult to get out of bed in the morning?  Do you feel fatigued and irritable?  Is your bed partner complaining more and more about your snoring?</p>

<p>You may be suffering from Obstructive Sleep Apnea (OSA).  Repeated closure of the upper airway during sleep leads to many unwanted outcomes including the following:
<ul>
  <li>loud snoring</li>
  <li>stopped breathing episodes</li>
  <li>poor, unrefreshing sleep</li>
  <li>excessive daytime sleepiness</li>
  <li>impotence</li>
  <li>weight gain</li>
  <li>increased risks for hypertension and heart attack</li>
  <li>diabetes</li>
  <li>congestive heart failure</li>
  <li>stroke</li>
  <li>increased risk for falling asleep while driving.</li>
</ul> 

<p>The good news is that we can do something about these problems!</p>

<p>%franchisee_practice% has joined with <b>Dental Sleep Solutions&reg;</b> to undergo specific training on how to treat snoring and sleep apnea utilizing state of the art, FDA approved dental sleep devices.</p>

<p>If you or someone you know is suffering with snoring or sleep apnea and would like more information about how we can help by using dental sleep therapy please call our office and we will be happy to schedule a complimentary consultation.  We also invite you to visit our website at www.dentalsleepsolutions.com for more information.</p>

<p>We look forward to helping you or someone you know to get a better night's sleep!</p>

<p>Sincerely,</p>
<br />
<br />

<p>%franchisee_fullname%</p>
" WHERE id=3;

UPDATE dental_letter_templates SET body="
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

<p>Though you may not realize it, snoring is a telltale sign that you may suffer from a disease called Obstructive Sleep Apnea.</p>

<p>We are excited to inform you that our office has partnered with <b>Dental Sleep Solutions&reg;</b>, one of the country's most respected and knowledgeable groups in the area of dental sleep medicine. Our entire office has been trained in how to recognize and treat snoring and sleep apnea utilizing leading edge technologies.</p>

<p><b>Dental Sleep Solutions'&reg;</b> techniques help reduce or eliminate snoring and Obstructive Sleep Apnea by creating a custom dental sleep device that is worn while you sleep.</p>

<p>Obstructive Sleep Apnea has been linked to serious, sometimes even life-threatening, health problems.  Early recognition and treatment  is <b>very important</b>.  We would appreciate it if you would please fill out our Sleep Screening Questionnaire while you are here today so that we can make an initial assessment and schedule a free consultation if needed.</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%</p>
" WHERE id=4;

UPDATE dental_letter_templates SET body="
<p>%contact_email%</p>
<br />
<br />

<p>Dear %contact_firstname%,</p>

<p>We appreciate the trust you have placed in us by scheduling a consultation appointment for an evaluation of your snoring and/or sleep apnea problem.  We will make every effort to honor that trust by providing the quality of care you require and deserve.</p>

<ol>
  <li>You can click on this link [\"www.dentalsleepsolutions.com/ONLINEFORM\"] and fill out your paperwork online (this method will ensure fastest service),<br />
    <br />
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;OR</li>

  <li>You can download the attachment, print it, fill it out, and then bring it with you to your appointment.  It is important to bring your paperwork  or to fill out the paperwork online, or we may not  be able to see you.</li>
</ol>
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

<p>If you have any questions that need to be answered prior to your appointment, please call us.  Our office staff will assist you in every way possible.  We look forward to meeting you!</p>
<br />

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%<br />
%franchisee_phone%<br />
%franchisee_addr%</p>
" WHERE id=5;

UPDATE dental_letter_templates SET body="
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
%franchisee_addr%</p>
" WHERE id=6;

UPDATE dental_letter_templates SET body="
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

<table>
  <tr>
                <td width=\"50px\">Re:</td>
                <td>%patient_fullname%</td>
        </tr>
        <tr>
                <td width=\"50px\">DOB:</td>
                <td>%patient_dob%</td>
        </tr>
</table>

<p>Dear Dr. %contact_lastname%:</p>

<p>Thank you for referring %patient_fullname% to our office for treatment with a dental sleep device.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender%.  %patient_firstname% had a %type_study% done at the %1st_sleeplab_name% which showed an AHI of %ahi%; %he/she% was diagnosed with %diagnosis%.</p>

<p>I very much appreciate your confidence and the referral, but I regret to inform you that %patient_firstname% is not a candidate for dental device therapy.  I have counseled %him/her% to return to your office to discuss other treatment options.</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%<br />
<br />
cc:<br />  %other_mds%</p>
" WHERE id=7;

UPDATE dental_letter_templates SET body="
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

<p>
Dear %contact_firstname%:</p>

<p>Thank you for taking the time to come in and consult with us regarding your sleep disordered breathing problem.  I hope that you found it was worth your time. We work very hard to be the best we can be.</p>

<p>I understand that you chose not to pursue treatment with a dental device, and I am concerned that you are not treating your sleep disordered breathing problem.</p>

<p>As you may very well be aware, this disease leads to increased risks for hypertension, heart attack, congestive heart failure, diabetes, stroke, as well as an increased risk for falling asleep while driving, all of which can be reversed by successful treatment!</p>

<p>I wholeheartedly encourage you to pursue some form of treatment for your sleep disordered breathing.</p>

<p>Please know that we are always here to help.</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%</p>
" WHERE id=8;

UPDATE dental_letter_templates SET body="
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

<table>
  <tr>
                <td width=\"50px\">Re:</td>
                <td>%patient_fullname% - ACCEPTS TREATMENT</td>
        </tr>
        <tr>
                <td width=\"50px\">DOB:</td>
                <td>%patient_dob%</td>
        </tr>
</table>

<p>Dear Dr. %contact_lastname%:</p>

<p>Thank you for referring %patient_fullname% to our office for treatment with a dental sleep device.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender%%historysentence%.  %medicationssentence% %patient_firstname% had a %completed_type_study% done at the %completed_sleeplab_name% which showed an AHI of %completed_ahi%; %he/she% was diagnosed with %completed_diagnosis%.</p>

<p>Oral evaluation of %patient_firstname% revealed no contraindications to wearing a dental sleep device.  %He/She% is scheduled to begin treatment as soon as we receive the dental device back from the lab</p>


<p>Thank you again for your confidence and the referral.  We will keep you updated as treatment progresses.</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%<br />
<br />
cc:<br />  %other_mds%</p>
" WHERE id=9;

UPDATE dental_letter_templates SET body="
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
<table>
  <tr>
                <td width=\"50px\">Re:</td>
                <td>%patient_fullname%</td>
        </tr>
        <tr>
                <td width=\"50px\">DOB:</td>
                <td>%patient_dob%</td>
        </tr>
</table>

<p>Dear Dr. %contact_lastname%:</p>

<p>%tyreferred% As you recall, %patient_firstname% is a %patient_age% year old %patient_gender%%historysentence%.  %medicationssentence%  %patient_firstname% had a %type_study% done at the %1st_sleeplab_name% which showed an AHI of %ahi%; %he/she% was diagnosed with %diagnosis%.</p>

<p>Oral evaluation of %patient_firstname% revealed no contraindications to wearing a dental sleep device.  However, %he/she% is waiting to begin treatment due to %delay_reason%.</p>

<p>Thank you again for your confidence and the referral.  We will keep you updated on %his/her% treatment progress.</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%<br />
<br />
cc:<br />  %other_mds%</p>
" WHERE id=10;

UPDATE dental_letter_templates SET body="
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
<table>
  <tr>
                <td width=\"50px\">Re:</td>
                <td>%patient_fullname% - PATIENT REFUSED TREATMENT</td>
        </tr>
        <tr>
                <td width=\"50px\">DOB:</td>
                <td>%patient_dob%</td>
        </tr>
</table>

<p>Dear Dr. %contact_lastname%:</p>

<p>Thank you for referring %patient_fullname% to our office for treatment with a dental sleep device.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender%%historysentence%.  %medicationssentence% %patient_firstname% had a %completed_type_study% done at the %completed_sleeplab_name% which showed an AHI of %completed_ahi%; %he/she% was diagnosed with %completed_diagnosis%.</p>

<p>I regret to inform you that the patient has refused treatment with a dental sleep device.  I am referring %him/her% back to you to discuss other treatment options.</p>

<p>Thank you again for your confidence and the referral.  We are committed to helping patients successfully treat their sleep disordered breathing.</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%<br />
<br />
cc:<br />  %other_mds%</p>
" WHERE id=11;

UPDATE dental_letter_templates SET body="
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
<table>
  <tr>
                <td width=\"50px\">Re:</td>
                <td>%patient_fullname% - PATIENT DID NOT ATTEND CONSULTATION</td>
        </tr>
        <tr>
                <td width=\"50px\">DOB:</td>
                <td>%patient_dob%</td>
        </tr>
</table>

<p>Dear Dr. %contact_lastname%:</p>

<p>Thank you for referring %patient_fullname% to our office.</p>

<p>I appreciate your confidence and the referral, but I regret to inform you that our attempts to arrange a consultation with %patient_firstname% have been unsuccessful.  Please be aware that %he/she% may not be treating %his/her% sleep disordered breathing.</p>

<p>Again, thank you and please continue to keep us in mind for all of your mild to moderate sleep apneics, as well as those who cannot tolerate CPAP.</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%</p>

<p>cc:<br />  %other_mds%</p>
" WHERE id=12;

UPDATE dental_letter_templates SET body="
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
<table>
  <tr>
                <td width=\"50px\">Re:</td>
                <td>%patient_fullname% - DENTAL SLEEP DEVICE TREATMENT</td>
        </tr>
        <tr>
                <td width=\"50px\">DOB:</td>
                <td>%patient_dob%</td>
        </tr>
</table>

<p>Dear Dr. %contact_lastname%:</p>

<p>We have a mutual patient, %patient_fullname%.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender% who scored an AHI of %completed_ahi% after undergoing a %completed_type_study% done at the %completed_sleeplab_name%. %He/She% was referred to me %by_referral_fullname% for treatment of %his/her% sleep disordered breathing with a Mandibular Advancement Device.</p>

<p>Oral evaluation of %patient_firstname% revealed no contraindications to wearing a dental sleep device.  %He/She% is scheduled to begin treatment very soon.</p>

<p>We will keep you updated as treatment progresses.  Please keep us in mind for all of your patients who suffer from sleep disordered breathing.</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%<br />
<br />
cc:<br />  %other_mds%</p>
" WHERE id=13;

UPDATE dental_letter_templates SET body="
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

<p>Thank you for choosing Dental Sleep Solutions&reg; and %franchisee_fullname% to treat your sleep disordered breathing.  As you are no doubt now aware, Dental Sleep Solutions&reg; dentists are some of the most highly trained and educated dentists in dental sleep medicine.  Our dentists are committed to helping you breathe better, sleep better, and feel better.</p>

<p>We have attached a summary of the clinical notes made by %franchisee_lastname% for your records.  We hope that you will take an active role in your treatment therapy.  Please take the time to visit our website, too, at www.dentalsleepsolutions.com and give us a shout to let us know how we are doing.</p>

<p>In the meantime, spread the word!  Many of your friends and family members could likely benefit from a dental sleep medicine consultation.  Dental Sleep Solutions&reg; is expanding its network of participating dentists regularly --  please check out our website for details.</p>

<p>Thank you for choosing Dental Sleep Solutions&reg;!</p>

<p>Sincerely,
<br />
<br />
<br />
<table width=\"100%\">
<tr>
<td width=\"60%\">
Richard B. Drake, DDS
</td>
<td width=\"40%\">
George \"Gy\" Yatros, DMD
</td>
</tr>
</table>
</p>
" WHERE id=14;

UPDATE dental_letter_templates SET body="
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

<table>
  <tr>
                <td width=\"50px\">Re:</td>
                <td>%patient_fullname%</td>
        </tr>
        <tr>
                <td width=\"50px\">DOB:</td>
                <td>%patient_dob%</td>
        </tr>
</table>

<p>%patient_fullname% is a %patient_age% year old %patient_gender% with a past medical history that includes:   Medications: %medications%</p>

<p><b>HPI</b>:  Patient underwent a %2ndtype_study% on %2ndstudy_date% due to %reason_seeking_tx%.  Patient has a BMI of %bmi% and had symptoms of %symptoms%.  %He/She% was diagnosed with %2nddiagnosis%.</p>

<p><b>SUBJECTIVE</b>:  %patient_firstname% presents with subjective complaint(s) of %reason_seeking_tx%.</p>

<p><b>OBJECTIVE</b>:  %patient_firstname% underwent a %2ndtype_study% on %2ndstudy_date%.  %He/She% was diagnosed with %2nddiagnosis%.  %He/She% had an AHI of %2ndahi%.  On %his/her% back, %his/her% AHI was %2ndahisupine%; during REM sleep %his/her% AHI was [REM AHI from summary sheet].  %He/She% had a low O2 level of %2ndLowO2%;  and %he/she% spent %2ndO2Sat90%% of the night below 90% O2.</p>

<p><b>ASSESSMENT</b>:  %patient_firstname% was diagnosed with %2nddiagnosis%.  %He/She% is a good candidate for dental device therapy.</p>

<p><b>PLAN</b>:  Discussed risks, benefits,  and alternatives of treatment options. Recommend [Patient's Treatment Plan]</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%<br />
" WHERE id=15;

UPDATE dental_letter_templates SET body="
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

<table>
  <tr>
                <td width=\"50px\">Re:</td>
                <td>%patient_fullname% - DENTAL DEVICE TREATMENT PROGRESS</td>
        </tr>
        <tr>
                <td width=\"50px\">DOB:</td>
                <td>%patient_dob%</td>
        </tr>
</table>

<p>Dear %contact_salutation% %contact_lastname%:</p>

%patprogress%

<p>I write regarding our mutual Patient, %patient_fullname%.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender% who scored an AHI of %ahi% after undergoing a %type_study% done at the %1st_sleeplab_name%.

<p>We delivered a %dental_device% dental device on %delivery_date%.  We are now seeing %patient_firstname% for follow up.</p>

<p>The patient reports wearing the device %nightsperweek% nights per week. %esstssupdate% Additionally, %he/she% reports less snoring, improved daytime functioning, and more refreshing sleep.</p>

<p>We will continue to update you on %his/her% progress.  Thank you for the opportunity to participate in this patient's treatment.</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%<br />
<br />
cc:<br />  %nonpcp_mds%<br />
%ccpatient_fullname%</p>
" WHERE id=16;

UPDATE dental_letter_templates SET body="
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

<table>
  <tr>
                <td width=\"50px\">Re:</td>
                <td>%patient_fullname% - PATIENT NO LONGER DENTAL DEVICE COMPLIANT</td>
        </tr>
        <tr>
                <td width=\"50px\">DOB:</td>
                <td>%patient_dob%</td>
        </tr>
</table>

<p>Dear Dr. %contact_lastname%:</p>

%patprogress%

<p>I write regarding our mutual Patient, %patient_fullname%.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender% who scored an AHI of %ahi% after undergoing a %type_study% done at the %1st_sleeplab_name%.</p>

<p>We delivered a %dental_device% dental device on %delivery_date%.</p>

<p>I regret to inform you that %he/she% has become non compliant with dental device therapy due to %noncomp_reason%.</p>

<p>I am referring her back to you to discuss other treatment alternatives.  Thank you again for the opportunity to participate in %patient_firstname%'s therapy; please know that we will do our best to follow through with all patients to ensure successful treatment.</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%<br />
<br />
cc:<br />  %nonpcp_mds%<br />
%ccpatient_fullname%</p>
" WHERE id=17;

UPDATE dental_letter_templates SET body="
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

<p>We delivered your %dental_device% dental device on %delivery_date%.  Our follow up schedule mandates at least one follow up appointment within the first 30 days.  Somehow, you have slipped through the cracks.  We have no record of that visit.</p>

<p>Please contact our office immediately to schedule your follow up appointment.</p>

<p>Thank you.</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%<br />
<br />
cc:<br />  %other_mds%</p>
" WHERE id=18;

UPDATE dental_letter_templates SET body="
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

<table>
  <tr>
                <td width=\"50px\">Re:</td>
                <td>%patient_fullname% - DENTAL DEVICE TREATMENT RESULTS</td>
        </tr>
        <tr>
                <td width=\"50px\">DOB:</td>
                <td>%patient_dob%</td>
        </tr>
</table>

<p>Dear %contact_salutation% %contact_lastname%:</p>
  
%patprogress%

<p>I write regarding our mutual Patient, %patient_fullname%.  As you recall, %patient_firstname% is a %patient_age% year old %patient_gender% who scored an AHI of %ahi% and/or RDI of %1stRDI% after undergoing a %type_study% done at the %1st_sleeplab_name%.   %He/She% spent %1stTO290% % of the night below 90% sp O2, and had an O2 nadir of %1stLowO2%.</p>

<p>We delivered %dental_device% device on %delivery_date%, and %he/she% has reported doing well with it.  I write to give you a progress update after the initial titration period and following a take home sleep study. %patient_firstname%'s results, baseline and post appliance insertion appear below.</p>

<table cellpadding=\"7px\">
        <tr>
                <th>OBJECTIVE</th>
                <th>Before</th>
                <th>%1ststudy_date%&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th>After</th>
                <th>%2ndstudy_date%</th>
        </tr>
        <tr>
                <td>RDI / AHI</td>
                <td colspan=\"2\" style=\"text-align:center;\">%1stRDI/AHI%</td>
                <td colspan=\"2\" style=\"text-align:center;\">%2ndRDI/AHI%</td>
        </tr>
        <tr>
                <td>Low O2</td>
                <td colspan=\"2\" style=\"text-align:center;\">%1stLowO2%</td>
                <td colspan=\"2\" style=\"text-align:center;\">%2ndLowO2%</td>
        </tr>
        <tr>
                <td>T O2 &#8804; 90%</td>
                <td colspan=\"2\" style=\"text-align:center;\">%1stTO290%</td>
                <td colspan=\"2\" style=\"text-align:center;\">%2ndTO290%</td>
        </tr>
        <tr>
                <td>ESS</td>
                <td colspan=\"2\" style=\"text-align:center;\">%1stESS%</td>
                <td colspan=\"2\" style=\"text-align:center;\">%2ndESS%</td>
        </tr>
        <tr>
                <th>SUBJECTIVE</th>
                <td colspan=\"2\" style=\"text-align:center;\"></td>
                <td colspan=\"2\" style=\"text-align:center;\"></td>
        </tr>
        <tr>
                <td>Snoring</td>
                <td colspan=\"2\" style=\"text-align:center;\">%1stSnoring%</td>
                <td colspan=\"2\" style=\"text-align:center;\">%2ndSnoring%</td>
        </tr>
        <tr>
                <td>Energy Level</td>
                <td colspan=\"2\" style=\"text-align:center;\">%1stEnergy%</td>
                <td colspan=\"2\" style=\"text-align:center;\">%2ndEnergy%</td>
        </tr>
        <tr>
                <td>Sleep Quality</td>
                <td colspan=\"2\" style=\"text-align:center;\">%1stQuality%</td>
                <td colspan=\"2\" style=\"text-align:center;\">%2ndQuality%</td>
        </tr>
</table>

<p>%patient_firstname% has been counseled that OSA is a progressive disease and I have stressed the importance of a team healthcare approach and disciplined follow up.   I believe we have reached maximum medical improvement with a dental device, and at this point I plan to refer %patient_firstname% back to your office for further medical care.</p>

<p>Please don't hesitate to call if you have any questions. I thank you again for the opportunity to participate in this patient's treatment.</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%<br />
<br />
cc:<br />  %nonpcp_mds%<br />
%ccpatient_fullname%</p>
" WHERE id=19;

UPDATE dental_letter_templates SET body="
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

<table>
  <tr>
                <td width=\"50px\">Re:</td>
                <td>%patient_fullname% - ACCEPTS TREATMENT</td>
        </tr>
        <tr>
                <td width=\"50px\">DOB:</td>
                <td>%patient_dob%</td>
        </tr>
</table>

<p>Dear %contact_firstname% %contact_lastname%:</p>

<p>Thank you for referring %patient_fullname% to our office for treatment with a dental sleep device.  There is no greater compliment than for someone such as you to refer a colleague, friend, or family member.</p>

<p>Thank you again for your confidence and the referral!</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%<br />
<br />
cc:<br />  %other_mds%</p>
" WHERE id=20;

UPDATE dental_letter_templates SET body="
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

<p>Can you believe it was a year ago that we fabricated your %dental_device% dental sleep device?  We hope that you are continuing to do well.</p>

<p>Please take time to contact our office and schedule your yearly follow up.   Since sleep disordered breathing is a progressive disorder it is important that we evaluate your appliance for proper fit and discuss your continued treatment regimen.</p>

<p>As you may very well be aware, sleep disordered breathing leads to increased risks for hypertension, heart attack, congestive heart failure, diabetes, stroke, as well as an increased risk for falling asleep while driving -- all of which can be reversed by successful treatment!</p>

<p>We look forward to seeing you soon.</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%</p>
" WHERE id=21;

UPDATE dental_letter_templates SET body="
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

<table>
  <tr>
                <td width=\"50px\">Re:</td>
                <td>%patient_fullname% - DENIAL OF COVERAGE</td>
        </tr>
        <tr>
                <td width=\50px\">ID:</td>
                <td>%insurance_id%</td>
        </tr>
        <tr>
                <td width=\"50px\">DOB:</td>
                <td>%patient_dob%</td>
        </tr>
</table>


<p>Dear Sir or Madam:</p>

<p>I received your denial of coverage for the Mandibular Repositioning Device that has been prescribed for %patient_fullname% by %franchisee_fullname% and I am writing on behalf of our patient to appeal that decision.  You have based your decision on [(INSERT REASON WHY THEY ARE DENYING HERE)].</p>

<p>%patient_lastname% has been prescribed a Mandibular Repositioning Device by %franchisee_fullname% to treat %his/her% documented sleep apnea.  This is neither an oral splint or appliance, nor a dental splint or dental brace.  It is a Mandibular Repositioning Device, specifically considered as Durable Medical Equipment, and specifically coded as a MEDICAL treatment for a MEDICAL diagnosis.  While these appliances are intraoral, they are not meant to treat the teeth.  Instead, they reposition the jaw and tongue to open up the airway. Because the treatment is used to treat a medical condition it cannot be considered \"dental.\"</p>

<p>It is gross negligence to deny payment for a Mandibular Repositioning Device under these circumstances.</p>

<p>The American Academy of Sleep Medicine recently published a Practice Parameters paper (<i>Sleep</i>, February, 2006) on the use of oral appliances to treat sleep apnea.  This paper stated that the abundance of evidence-based research on oral appliance therapy has shown Mandibular Repositioners to be successful enough that they are now recommend as a first line of therapy for mild to moderate sleep apnea, as well as for patients with more severe apnea who prefer the appliance to CPAP or cannot tolerate CPAP.</p>

<p>This letter should explain why treatment for %patient_lastname% should be covered under \"medical reimbursement.\"   I look forward to the opportunity to discuss this appeal and this case with you over the telephone.</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%</p>
" WHERE id=22;

UPDATE dental_letter_templates SET body="
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

<p>It’s hard to believe that it was nearly three years ago that we delivered your dental device.  I hope that you are wearing your device and continuing to reap the benefits of better sleep and better health.  I am writing to you today because most dental devices begin to show significant wear around the three year mark and can lose their ability to effectively treat your sleep disordered breathing.   Most insurers will pay to have them remade if necessary, so we'd like to encourage you to set up an appointment so that we can evaluate your device for possible replacement.</p>

<p>Please give us a call here at the office to schedule an appointment.  We look forward to seeing you soon!</p>

<p>Sincerely,
<br />
<br />
<br />
%franchisee_fullname%</p>
" WHERE id=23;

UPDATE dental_letter_templates SET body="
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
%franchisee_fullname%<br />
</p>
" WHERE id=24;

