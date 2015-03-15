<?php namespace Ds3\Legacy; ?><div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab" tabindex="0">All Variables</li>
    <li class="TabbedPanelsTab" tabindex="0">Recipient</li>
    <li class="TabbedPanelsTab" tabindex="0">Practice info</li>
    <li class="TabbedPanelsTab" tabindex="0">Referral</li>
    <li class="TabbedPanelsTab" tabindex="0">Patient General</li>    <li class="TabbedPanelsTab" tabindex="0">Patient Medical</li>    <li class="TabbedPanelsTab" tabindex="0">Sleep Studies</li>    
    <li class="TabbedPanelsTab" tabindex="0">Subjective</li>    
  </ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent">
      <table border="1">
        <tr>
          <td><strong>Variables</strong></td>
          <td><strong>Description</strong></td>
          <td><strong>Example</strong></td>
        </tr>
        <tr>
          <td>%todays_date%</td>
          <td>Today's date</td>
          <td>July 31, 2013</td>
        </tr>
        <tr>
          <td>%contact_salutation%</td>
          <td>Recipient salutation</td>
          <td>Dr., Mr., Ms., Mrs.</td>
        </tr>
        <tr>
          <td>%contact_fullname%</td>
          <td>Recipient full name (including salutation)</td>
          <td>Dr. John Smith</td>
        </tr>
        <tr>
          <td>%contact_firstname%</td>
          <td>Recipient first name</td>
          <td>John</td>
        </tr>
        <tr>
          <td>%contact_lastname%</td>
          <td>Recipient last name</td>
          <td>Smith</td>
        </tr>
        <tr>
          <td>%contact_email%</td>
          <td>Recipient email</td>
          <td>drsmith@smithdental.com</td>
        </tr>
        <tr>
          <td>%practice%</td>
          <td>Recipient Office/Practice name (if appliance)</td>
          <td>Smith Dental Associates</td>
        </tr>
        <tr>
          <td>%addr1%</td>
          <td>Recipient address line 1</td>
          <td>123 Main Street</td>
        </tr>
        <tr>
          <td>%addr2%</td>
          <td>Recipient address line 2</td>
          <td>Suite 230</td>
        </tr>
        <tr>
          <td>%city%</td>
          <td>Receipient address City</td>
          <td>Phoenix</td>
        </tr>
        <tr>
          <td>%state%</td>
          <td>Receipient address State</td>
          <td>AZ</td>
        </tr>
        <tr>
          <td>%zip%</td>
          <td>Receipient address Zip code</td>
          <td>12456</td>
        </tr>
        <tr>
          <td>%other_mds%</td>
          <td>A list of all the medical contacts who are also receiving a copy of this letter.  For example, if you generate a letter to 4 contacts and insert a "Cc: %other_mds%".  field it will list all the other doctors receiving the letter.  NOTE: This variable is 'smart', in that it will NOT include the name of the physician if that physician is the one to whom the letter is addressed.</td><td>Dr. John Smith, Dr. Jane Doe</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>%doctor_fullname%</td>
          <td>Your office's dentist/doctor full name (including salutation)</td>
          <td>Dr. Yourname Smith</td>
        </tr>
        <tr>
          <td>%doctor_lastname%</td>
          <td>Your office's dentist/doctor last name</td>
          <td>Smith</td>
        </tr>
        <tr>
          <td>%doctor_practice%</td>
          <td>Your office/practice name</td>
          <td>Myoffice Dental Practice</td>
        </tr>
        <tr>
          <td>%doctor_phone%</td>
          <td>Your office phone number</td>
          <td>(512) 555-5555</td>
        </tr>
        <tr>
          <td>%doctor_addr%</td>
          <td>Your office/practice complete address (address, city, state, zip)</td>
          <td>456 My Street, Anywhere, AZ 12654</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>%ptreferral_fullname%</td>
          <td>Referral source for patient (including salutation).  NOTE: If the letter is being sent to the referral souce, then instead of a name this variable will say "you" (e.g. 'he was referred to me by you.')</td>
          <td>Dr. Joe Referral, you</td>
        </tr>
        <tr>
          <td>%ptreferral_firstname%</td>
          <td>Referral source last name</td>
          <td>Joe</td>
        </tr>
        <tr>
          <td>%ptreferral_lastname%</td>
          <td>Referral source last name</td>
          <td>Smith</td>
        </tr>
        <tr>
          <td>%ptreferral_practice%</td>
          <td>Referral source practice name</td>
          <td>Smith Referral Practice</td>
        </tr>
        <tr>
          <td>%ptref_addr1%</td>
          <td>Referral source address line 1</td>
          <td>123 Main Street</td>
        </tr>
        <tr>
          <td>%ptref_addr2%</td>
          <td>Referral source address line 2</td>
          <td>Suite 230</td>
        </tr>
        <tr>
          <td>%ptref_city%</td>
          <td>Referral source address city</td>
          <td>Phoenix</td>
        </tr>
        <tr>
          <td>%ptref_state%</td>
          <td>Referral source address state</td>
          <td>AZ</td>
        </tr>
        <tr>
          <td>%ptref_zip%</td>
          <td>Referral source address zip</td>
          <td>12456</td>
        </tr>
        <tr>
          <td>%tyreferred%</td>
          <td>Thank you sentence to referral source</td>
          <td>Thank you for referring Mr. Test Access to our office for treatment with a dental sleep device.</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>%patient_fullname%</td>
          <td>Patient's full name</td>
          <td>Suzie Johnson</td>
        </tr>
        <tr>
          <td>%patient_titlefullname%</td>
          <td>Patient's full name (including salutation)</td>
          <td>Ms. Suzie Johnson</td>
        </tr>
        <tr>
          <td>%patient_firstname%</td>
          <td>Patient's first name</td>
          <td>Suzie</td>
        </tr>
        <tr>
          <td>%patient_lastname%</td>
          <td>Patient's last name (including salutation)</td>
          <td>Ms. Johnson</td>
        </tr>
        <tr>
          <td>%ccpatient_fullname%</td>
          <td>Patient fullname (including salutation) displayed ONLY if you create the letter to multiple contacts and include the patient as recipient.</td>
          <td>Ms. Suzie Johnson or BLANK (IF patient not set to receive copy of letter)</td>
        </tr>
        <tr>
          <td>%patient_photo%</td>
          <td>Patient face photo (uploaded on the Pt Info tab)</td>
          <td>PHOTO</td>
        </tr>
        <tr>
          <td>%patient_email%</td>
          <td>Patient email address</td>
          <td>patient@patientemail.com</td>
        </tr>
        <tr>
          <td>%patient_dob%</td>
          <td>Patient's date of birth</td>
          <td>8/9/1950</td>
        </tr>
        <tr>
          <td>%patient_age%</td>
          <td>Patient's age (calculated from birth date)</td>
          <td>63</td>
        </tr>
        <tr>
          <td>%patient_gender%</td>
          <td>Patient gender</td>
          <td>male, female</td>
        </tr>
        <tr>
          <td>%bmi%</td>
          <td>Patient BMI (Body Mass Index)</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>%His/Her%</td>
          <td>Display either "His" or "Her" depending on gender of patient</td>
          <td>His, Her</td>
        </tr>
        <tr>
          <td>%He/She%</td>
          <td>Display either "He" or "She" depending on gender of patient</td>
          <td>He, She</td>
        </tr>
        <tr>
          <td>%his/her%</td>
          <td>Display either "his" or "her" depending on gender of patient</td>
          <td>his, her</td>
        </tr>
        <tr>
          <td>%he/she%</td>
          <td>Display either "he" or "she" depending on gender of patient</td>
          <td>he, she</td>
        </tr>
        <tr>
          <td>%him/her%</td>
          <td>Display either "him or "her" depending on gender of patient</td>
          <td>him, her</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>%history%</td>
          <td>List of patient's medical history (if no medical history then this populates with "none provided")</td>
          <td>arthritis, asthma, chest pain</td>
        </tr>
        <tr>
          <td>%medications%</td>
          <td>List of patient's medication (if no medications listed then this populates with "none provided")</td>
          <td>aspirin, xanax</td>
        </tr>
        <tr>
          <td>%reason_seeking_tx%</td>
          <td>Reasons seeking treatment according to patient Questionnaire</td>
          <td>my wife hates my snoring, waking up gasping</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>%consult_date%</td>
          <td>Date of initial consultation with patient</td>
          <td>May 20, 2013</td>
        </tr>
        <tr>
          <td>%impressions_date%</td>
          <td>Date of impression (according to Tracker) for patient</td>
          <td>May 20, 2013</td>
        </tr>
        <tr>
          <td>%delivery_date%</td>
          <td>Date oral appliance was delivered (as set in Tracker)</td>
          <td>May 20, 2013</td>
        </tr>
        <tr>
          <td>%dental_device%</td>
          <td>Name of dental device for patient</td>
          <td>TAP Elite</td>
        </tr>
        <tr>
          <td>%nightsperweek%</td>
          <td>Number of nights patient reports wearing dental device according to most recent 'Subjective Findings'</td>
          <td>4</td>
        </tr>
        <tr>
          <td>%delay_reason%</td>
          <td>Reason patient is delaying treatment (set from Tracker page)</td>
          <td>additional dental work</td>
        </tr>
        <tr>
          <td>%noncomp_reason%</td>
          <td>Reason patient is non-compliant with dental device (set from Tracker page)</td>
          <td>pain in jaw</td>
        </tr>
        <tr>
          <td>%esstssupdate%</td>
          <td>Sentence comparing initial ESS/TSS score to most recent</td>
          <td>His Epworth Sleepiness Scale / Thornton Snoring Score has changed from 15/20 to 8/11.</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>%1st_sleeplab_name%</td>
          <td>Name of sleep lab performing patient's initial sleep study (displays "home" if home sleep test)</td>
          <td>Baseline Sleep Lab, home</td>
        </tr>
        <tr>
          <td>%diagnosis%</td>
          <td>Initial sleep study diagnosis</td>
          <td>327.23 Obstructive Sleep Apnea</td>
        </tr>
        <tr>
          <td>%type_study%</td>
          <td>Initial sleep study type</td>
          <td>home sleep test, oximeter sleep test, sleep test</td>
        </tr>
        <tr>
          <td>%1ststudy_date%</td>
          <td>Initial sleep study date performed</td>
          <td>May 20, 2013</td>
        </tr>
        <tr>
          <td>%ahi%</td>
          <td>Initial sleep study AHI (Apnea-Hypopnea Index)</td>
          <td>45</td>
        </tr>
        <tr>
          <td>%1stRDI%</td>
          <td>Initial sleep study RDI (Respiratory-Disturbance Index)</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>%1stRDI/AHI%</td>
          <td>Initial sleep study RDI (Respiratory-Disturbance Index) / AHI (Apnea-Hypopnea Index)</td>
          <td>50/65</td>
        </tr>
        <tr>
          <td>%1stLowO2%</td>
          <td>Initial sleep study low oxygen (O2 nadir)</td>
          <td>88</td>
        </tr>
        <tr>
          <td>%1stTO290%</td>
          <td>Initial sleep study time spent below 90% O2 saturation</td>
          <td>5 hours</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>%2nd_sleeplab_name%</td>
          <td>Name of sleep lab performing patient's most recent sleep study (displays "home" if home sleep test)</td>
          <td>Followup Sleep Lab, home</td>
        </tr>
        <tr>
          <td>%2nddiagnosis%</td>
          <td>Most recent sleep study diagnosis</td>
          <td>327.23 Obstructive Sleep Apnea</td>
        </tr>
        <tr>
          <td>%2ndtype_study%</td>
          <td>Most recent sleep study type</td>
          <td>home sleep test, oximeter sleep test, sleep test</td>
        </tr>
        <tr>
          <td>%2ndstudy_date%</td>
          <td>Most recent sleep study date performed</td>
          <td>May 20, 2013</td>
        </tr>
        <tr>
          <td>%2ndahi%</td>
          <td>Most recent sleep study AHI (Apnea-Hypopnea Index)</td>
          <td>45</td>
        </tr>
        <tr>
          <td>%2ndrdi%</td>
          <td>Most recent sleep study RDI (Respiratory-Disturbance Index)</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>%2ndRDI/AHI%</td>
          <td>Most recent sleep study RDI (Respiratory-Disturbance Index) / AHI (Apnea-Hypopnea Index)</td>
          <td>50/65</td>
        </tr>
        <tr>
          <td>%2ndLowO2%</td>
          <td>Most recent sleep study low oxygen (O2 nadir)</td>
          <td>88</td>
        </tr>
        <tr>
          <td>%2ndTO290%</td>
          <td>Most recent sleep study time spent below 90% O2 saturation</td>
          <td>5 hours</td>
        </tr>
        <tr>
          <td>%2ndahisupine%</td>
          <td>Most recent sleep study AHI (Apnea-Hypopnea Index) in supine position</td>
          <td>40</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>%initESS/TSS%</td>
          <td>Initial Epworth Sleepiness Score (ESS) and Thornton Snoring Score (TSS) from baseline Subjective Findings</td>
          <td>15/25</td>
        </tr>
        <tr>
          <td>%currESS/TSS%</td>
          <td>Most recent Epworth Sleepiness Score (ESS) and Thornton Snoring Score (TSS) from Subjective Findings</td>
          <td>13/15</td>
        </tr>
        <tr>
          <td>%1stESS%</td>
          <td>Baseline Epworth Sleepiness Score (ESS) from Questionnaire results</td>
          <td>15</td>
        </tr>
        <tr>
          <td>%1stSnoring%</td>
          <td>Baseline 'Rate your snoring' rating from Questionnaire results</td>
          <td>8</td>
        </tr>
        <tr>
          <td>%1stEnergy%</td>
          <td>Baseline 'Rate your energy level' rating from Questionnaire results</td>
          <td>5</td>
        </tr>
        <tr>
          <td>%1stQuality%</td>
          <td>Baseline Snoring rating from Questionnaire results</td>
          <td>3</td>
        </tr>
        <tr>
          <td>%2ndESS%</td>
          <td>Most recent Epworth Sleepiness Score (ESS) from Subjective Findings</td>
          <td>13</td>
        </tr>
        <tr>
          <td>%2ndSnoring%</td>
          <td>Most recent 'Rate your snoring' rating from Subjective Findings</td>
          <td>4</td>
        </tr>
        <tr>
          <td>%2ndEnergy%</td>
          <td>Most recent 'Rate your energy level' rating from Subjective Findings</td>
          <td>9</td>
        </tr>
        <tr>
          <td>%2ndQuality%</td>
          <td>Most recent Snoring rating from Subjective Findings</td>
          <td>7</td>
        </tr>
      </table>
    </div>
    <div class="TabbedPanelsContent">
      <table border="1">
        <tr>
          <td><strong>Variables</strong></td>
          <td><strong>Description</strong></td>
          <td><strong>Example</strong></td>
        </tr>
        <tr>
          <td>%todays_date%</td>
          <td>Today's date</td>
          <td>July 31, 2013</td>
        </tr>
        <tr>
          <td>%contact_salutation%</td>
          <td>Recipient salutation</td>
          <td>Dr., Mr., Ms., Mrs.</td>
        </tr>
        <tr>
          <td>%contact_fullname%</td>
          <td>Recipient full name (including salutation)</td>
          <td>Dr. John Smith</td>
        </tr>
        <tr>
          <td>%contact_firstname%</td>
          <td>Recipient first name</td>
          <td>John</td>
        </tr>
        <tr>
          <td>%contact_lastname%</td>
          <td>Recipient last name</td>
          <td>Smith</td>
        </tr>
        <tr>
          <td>%contact_email%</td>
          <td>Recipient email</td>
          <td>drsmith@smithdental.com</td>
        </tr>
        <tr>
          <td>%practice%</td>
          <td>Recipient Office/Practice name (if appliance)</td>
          <td>Smith Dental Associates</td>
        </tr>
        <tr>
          <td>%addr1%</td>
          <td>Recipient address line 1</td>
          <td>123 Main Street</td>
        </tr>
        <tr>
          <td>%addr2%</td>
          <td>Recipient address line 2</td>
          <td>Suite 230</td>
        </tr>
        <tr>
          <td>%city%</td>
          <td>Receipient address City</td>
          <td>Phoenix</td>
        </tr>
        <tr>
          <td>%state%</td>
          <td>Receipient address State</td>
          <td>AZ</td>
        </tr>
        <tr>
          <td>%zip%</td>
          <td>Receipient address Zip code</td>
          <td>12456</td>
        </tr>
        <tr>
          <td>%other_mds%</td>
          <td>A list of all the medical contacts who are also receiving a copy of this letter.  For example, if you generate a letter to 4 contacts and insert a "Cc: %other_mds%".  field it will list all the other doctors receiving the letter.  NOTE: This variable is 'smart', in that it will NOT include the name of the physician if that physician is the one to whom the letter is addressed.</td>
          <td>Dr. John Smith, Dr. Jane Doe</td>
        </tr>
      </table>
    </div>
    <div class="TabbedPanelsContent">
      Content 2 
      <table border="1">
        <tr>
          <td><strong>Variables</strong></td>
          <td><strong>Description</strong></td>
          <td><strong>Example</strong></td>
        </tr>
        <tr>
          <td>%doctor_fullname%</td>
          <td>Your office's dentist/doctor full name (including salutation)</td>
          <td>Dr. Yourname Smith</td>
        </tr>
        <tr>
          <td>%doctor_lastname%</td>
          <td>Your office's dentist/doctor last name</td>
          <td>Smith</td>
        </tr>
        <tr>
          <td>%doctor_practice%</td>
          <td>Your office/practice name</td>
          <td>Myoffice Dental Practice</td>
        </tr>
        <tr>
          <td>%doctor_phone%</td>
          <td>Your office phone number</td>
          <td>(512) 555-5555</td>
        </tr>
        <tr>
          <td>%doctor_addr%</td>
          <td>Your office/practice complete address (address, city, state, zip)</td>
          <td>456 My Street, Anywhere, AZ 12654</td>
        </tr>
      </table>
    </div>
    <div class="TabbedPanelsContent">
      <table border="1">
        <tr>
          <td><strong>Variables</strong></td>
          <td><strong>Description</strong></td>
          <td><strong>Example</strong></td>
        </tr>
        <tr>
          <td>%ptreferral_fullname%</td>
          <td>Referral source for patient (including salutation).  NOTE: If the letter is being sent to the referral souce, then instead of a name this variable will say "you" (e.g. 'he was referred to me by you.')</td>
          <td>Dr. Joe Referral, you</td>
        </tr>
        <tr>
          <td>%ptreferral_firstname%</td>
          <td>Referral source last name</td>
          <td>Joe</td>
        </tr>
        <tr>
          <td>%ptreferral_lastname%</td>
          <td>Referral source last name</td>
          <td>Smith</td>
        </tr>
        <tr>
          <td>%ptreferral_practice%</td>
          <td>Referral source practice name</td>
          <td>Smith Referral Practice</td>
        </tr>
        <tr>
          <td>%ptref_addr1%</td>
          <td>Referral source address line 1</td>
          <td>123 Main Street</td>
        </tr>
        <tr>
          <td>%ptref_addr2%</td>
          <td>Referral source address line 2</td>
          <td>Suite 230</td>
        </tr>
        <tr>
          <td>%ptref_city%</td>
          <td>Referral source address city</td>
          <td>Phoenix</td>
        </tr>
        <tr>
          <td>%ptref_state%</td>
          <td>Referral source address state</td>
          <td>AZ</td>
        </tr>
        <tr>
          <td>%ptref_zip%</td>
          <td>Referral source address zip</td>
          <td>12456</td>
        </tr>
        <tr>
          <td>%tyreferred%</td>
          <td>Thank you sentence to referral source</td>
          <td>Thank you for referring Mr. Test Access to our office for treatment with a dental sleep device.</td>
        </tr>
      </table>
    </div>
    <div class="TabbedPanelsContent">
      Content 3 
      <table border="1">
        <tr>
          <td><strong>Variables</strong></td>
          <td><strong>Description</strong></td>
          <td><strong>Example</strong></td>
        </tr>
        <tr>
          <td>%patient_fullname%</td>
          <td>Patient's full name</td>
          <td>Suzie Johnson</td>
        </tr>
        <tr>
          <td>%patient_titlefullname%</td>
          <td>Patient's full name (including salutation)</td>
          <td>Ms. Suzie Johnson</td>
        </tr>
        <tr>
          <td>%patient_firstname%</td>
          <td>Patient's first name</td>
          <td>Suzie</td>
        </tr>
        <tr>
          <td>%patient_lastname%</td>
          <td>Patient's last name (including salutation)</td>
          <td>Ms. Johnson</td>
        </tr>
        <tr>
          <td>%ccpatient_fullname%</td>
          <td>Patient fullname (including salutation) displayed ONLY if you create the letter to multiple contacts and include the patient as recipient.</td>
          <td>Ms. Suzie Johnson or BLANK (IF patient not set to receive copy of letter)</td>
        </tr>
        <tr>
          <td>%patient_photo%</td>
          <td>Patient face photo (uploaded on the Pt Info tab)</td>
          <td>PHOTO</td>
        </tr>
        <tr>
          <td>%patient_email%</td>
          <td>Patient email address</td>
          <td>patient@patientemail.com</td>
        </tr>
        <tr>
          <td>%patient_dob%</td>
          <td>Patient's date of birth</td>
          <td>8/9/1950</td>
        </tr>
        <tr>
          <td>%patient_age%</td>
          <td>Patient's age (calculated from birth date)</td>
          <td>63</td>
        </tr>
        <tr>
          <td>%patient_gender%</td>
          <td>Patient gender</td>
          <td>male, female</td>
        </tr>
        <tr>
          <td>%bmi%</td>
          <td>Patient BMI (Body Mass Index)</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>%His/Her%</td>
          <td>Display either "His" or "Her" depending on gender of patient</td>
          <td>His, Her</td>
        </tr>
        <tr>
          <td>%He/She%</td>
          <td>Display either "He" or "She" depending on gender of patient</td>
          <td>He, She</td>
        </tr>
        <tr>
          <td>%his/her%</td>
          <td>Display either "his" or "her" depending on gender of patient</td>
          <td>his, her</td>
        </tr>
        <tr>
          <td>%he/she%</td>
          <td>Display either "he" or "she" depending on gender of patient</td>
          <td>he, she</td>
        </tr>
        <tr>
          <td>%him/her%</td>
          <td>Display either "him or "her" depending on gender of patient</td>
          <td>him, her</td>
        </tr>
      </table>
    </div>
    <div class="TabbedPanelsContent">
      <table border="1">
        <tr>
          <td><strong>Variables</strong></td>
          <td><strong>Description</strong></td>
          <td><strong>Example</strong></td>
        </tr>
        <tr>
          <td>%history%</td>
          <td>List of patient's medical history (if no medical history then this populates with "none provided")</td>
          <td>arthritis, asthma, chest pain</td>
        </tr>
        <tr>
          <td>%medications%</td>
          <td>List of patient's medication (if no medications listed then this populates with "none provided")</td>
          <td>aspirin, xanax</td>
        </tr>
        <tr>
          <td>%reason_seeking_tx%</td>
          <td>Reasons seeking treatment according to patient Questionnaire</td>
          <td>my wife hates my snoring, waking up gasping</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>%consult_date%</td>
          <td>Date of initial consultation with patient</td>
          <td>May 20, 2013</td>
        </tr>
        <tr>
          <td>%impressions_date%</td>
          <td>Date of impression (according to Tracker) for patient</td>
          <td>May 20, 2013</td>
        </tr>
        <tr>
          <td>%delivery_date%</td>
          <td>Date oral appliance was delivered (as set in Tracker)</td>
          <td>May 20, 2013</td>
        </tr>
        <tr>
          <td>%dental_device%</td>
          <td>Name of dental device for patient</td>
          <td>TAP Elite</td>
        </tr>
        <tr>
          <td>%nightsperweek%</td>
          <td>Number of nights patient reports wearing dental device according to most recent 'Subjective Findings'</td>
          <td>4</td>
        </tr>
        <tr>
          <td>%delay_reason%</td>
          <td>Reason patient is delaying treatment (set from Tracker page)</td>
          <td>additional dental work</td>
        </tr>
        <tr>
          <td>%noncomp_reason%</td>
          <td>Reason patient is non-compliant with dental device (set from Tracker page)</td>
          <td>pain in jaw</td>
        </tr>
        <tr>
          <td>%esstssupdate%</td>
          <td>Sentence comparing initial ESS/TSS score to most recent</td>
          <td>His Epworth Sleepiness Scale / Thornton Snoring Score has changed from 15/20 to 8/11.</td>
        </tr>
      </table>
    </div>
    <div class="TabbedPanelsContent">Content 4 
      <table border="1">
        <tr>
          <td><strong>Variables</strong></td>
          <td><strong>Description</strong></td>
          <td><strong>Example</strong></td>
        </tr>
        <tr>
          <td>%1st_sleeplab_name%</td>
          <td>Name of sleep lab performing patient's initial sleep study (displays "home" if home sleep test)</td>
          <td>Baseline Sleep Lab, home</td>
        </tr>
        <tr>
          <td>%diagnosis%</td>
          <td>Initial sleep study diagnosis</td>
          <td>327.23 Obstructive Sleep Apnea</td>
        </tr>
        <tr>
          <td>%type_study%</td>
          <td>Initial sleep study type</td>
          <td>home sleep test, oximeter sleep test, sleep test</td>
        </tr>
        <tr>
          <td>%1ststudy_date%</td>
          <td>Initial sleep study date performed</td>
          <td>May 20, 2013</td>
        </tr>
        <tr>
          <td>%ahi%</td>
          <td>Initial sleep study AHI (Apnea-Hypopnea Index)</td>
          <td>45</td>
        </tr>
        <tr>
          <td>%1stRDI%</td>
          <td>Initial sleep study RDI (Respiratory-Disturbance Index)</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>%1stRDI/AHI%</td>
          <td>Initial sleep study RDI (Respiratory-Disturbance Index) / AHI (Apnea-Hypopnea Index)</td>
          <td>50/65</td>
        </tr>
        <tr>
          <td>%1stLowO2%</td>
          <td>Initial sleep study low oxygen (O2 nadir)</td>
          <td>88</td>
        </tr>
        <tr>
          <td>%1stTO290%</td>
          <td>Initial sleep study time spent below 90% O2 saturation</td>
          <td>5 hours</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>%2nd_sleeplab_name%</td>
          <td>Name of sleep lab performing patient's most recent sleep study (displays "home" if home sleep test)</td>
          <td>Followup Sleep Lab, home</td>
        </tr>
        <tr>
          <td>%2nddiagnosis%</td>
          <td>Most recent sleep study diagnosis</td>
          <td>327.23 Obstructive Sleep Apnea</td>
        </tr>
        <tr>
          <td>%2ndtype_study%</td>
          <td>Most recent sleep study type</td>
          <td>home sleep test, oximeter sleep test, sleep test</td>
        </tr>
        <tr>
          <td>%2ndstudy_date%</td>
          <td>Most recent sleep study date performed</td>
          <td>May 20, 2013</td>
        </tr>
        <tr>
          <td>%2ndahi%</td>
          <td>Most recent sleep study AHI (Apnea-Hypopnea Index)</td>
          <td>45</td>
        </tr>
        <tr>
          <td>%2ndrdi%</td>
          <td>Most recent sleep study RDI (Respiratory-Disturbance Index)</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>%2ndRDI/AHI%</td>
          <td>Most recent sleep study RDI (Respiratory-Disturbance Index) / AHI (Apnea-Hypopnea Index)</td>
          <td>50/65</td>
        </tr>
        <tr>
          <td>%2ndLowO2%</td>
          <td>Most recent sleep study low oxygen (O2 nadir)</td>
          <td>88</td>
        </tr>
        <tr>
          <td>%2ndTO290%</td>
          <td>Most recent sleep study time spent below 90% O2 saturation</td>
          <td>5 hours</td>
        </tr>
        <tr>
          <td>%2ndahisupine%</td>
          <td>Most recent sleep study AHI (Apnea-Hypopnea Index) in supine position</td>
          <td>40</td>
        </tr>
      </table>
    </div>
    <div class="TabbedPanelsContent">
      <table border="1">
        <tr>
          <td><strong>Variables</strong></td>
          <td><strong>Description</strong></td>
          <td><strong>Example</strong></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>%initESS/TSS%</td>
          <td>Initial Epworth Sleepiness Score (ESS) and Thornton Snoring Score (TSS) from baseline Subjective Findings</td>
          <td>15/25</td>
        </tr>
        <tr>
          <td>%currESS/TSS%</td>
          <td>Most recent Epworth Sleepiness Score (ESS) and Thornton Snoring Score (TSS) from Subjective Findings</td>
          <td>13/15</td>
        </tr>
        <tr>
          <td>%1stESS%</td>
          <td>Baseline Epworth Sleepiness Score (ESS) from Questionnaire results</td>
          <td>15</td>
        </tr>
        <tr>
          <td>%1stSnoring%</td>
          <td>Baseline 'Rate your snoring' rating from Questionnaire results</td>
          <td>8</td>
        </tr>
        <tr>
          <td>%1stEnergy%</td>
          <td>Baseline 'Rate your energy level' rating from Questionnaire results</td>
          <td>5</td>
        </tr>
        <tr>
          <td>%1stQuality%</td>
          <td>Baseline 'Sleep Quality' rating from Questionnaire results</td>
          <td>3</td>
        </tr>
        <tr>
          <td>%2ndESS%</td>
          <td>Most recent Epworth Sleepiness Score (ESS) from Subjective Findings</td>
          <td>13</td>
        </tr>
        <tr>
          <td>%2ndSnoring%</td>
          <td>Most recent 'Rate your snoring' rating from Subjective Findings</td>
          <td>4</td>
        </tr>
        <tr>
          <td>%2ndEnergy%</td>
          <td>Most recent 'Rate your energy level' rating from Subjective Findings</td>
          <td>9</td>
        </tr>
        <tr>
          <td>%2ndQuality%</td>
          <td>Most recent 'Sleep Quality' rating from Subjective Findings</td>
          <td>7</td>
        </tr>
      </table>
    </div>
  </div>
</div>

<script type="text/javascript">
  var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
</script>
