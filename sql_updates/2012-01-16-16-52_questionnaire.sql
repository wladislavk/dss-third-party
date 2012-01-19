ALTER TABLE dental_q_page1 ADD COLUMN tss varchar(20);
ALTER TABLE dental_q_page1 ADD COLUMN ess varchar(20);

ALTER TABLE dental_q_page2 ADD COLUMN cur_cpap varchar(50);
ALTER TABLE dental_q_page2 ADD COLUMN sleep_center_name_text varchar(255);
ALTER TABLE dental_q_page2 ADD COLUMN dd_wearing varchar(50);
ALTER TABLE dental_q_page2 ADD COLUMN dd_prev varchar(50);
ALTER TABLE dental_q_page2 ADD COLUMN dd_otc varchar(50);
ALTER TABLE dental_q_page2 ADD COLUMN dd_fab varchar(50);
ALTER TABLE dental_q_page2 ADD COLUMN dd_who varchar(255);
ALTER TABLE dental_q_page2 ADD COLUMN dd_experience text;


CREATE TABLE `dental_insurance_preauth` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patient_amount_left_to_meet` decimal(11,2) DEFAULT NULL,
  `expected_insurance_payment` decimal(11,2) DEFAULT NULL,
  `expected_patient_payment` decimal(11,2) DEFAULT NULL,
  `network_benefits` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;



ALTER TABLE dental_q_page3 ADD COLUMN  wisdom_extraction_text varchar(255);
ALTER TABLE dental_q_page3 ADD COLUMN  removable_text varchar(255);
ALTER TABLE dental_q_page3 ADD COLUMN  dentures varchar(50);
ALTER TABLE dental_q_page3 ADD COLUMN  dentures_text varchar(255);
ALTER TABLE dental_q_page3 ADD COLUMN  tmj_cp varchar(50);
ALTER TABLE dental_q_page3 ADD COLUMN  tmj_cp_text varchar(255);
ALTER TABLE dental_q_page3 ADD COLUMN  tmj_pain varchar(50);
ALTER TABLE dental_q_page3 ADD COLUMN  tmj_pain_text varchar(255);
ALTER TABLE dental_q_page3 ADD COLUMN  tmj_surgery varchar(50);
ALTER TABLE dental_q_page3 ADD COLUMN  tmj_surgery_text varchar(255);
ALTER TABLE dental_q_page3 ADD COLUMN  injury varchar(50);
ALTER TABLE dental_q_page3 ADD COLUMN  injury_text varchar(255);
ALTER TABLE dental_q_page3 ADD COLUMN  gum_prob varchar(50);
ALTER TABLE dental_q_page3 ADD COLUMN  gum_prob_text varchar(255);
ALTER TABLE dental_q_page3 ADD COLUMN  gum_surgery varchar(50);
ALTER TABLE dental_q_page3 ADD COLUMN  gum_surgery_text varchar(255);
ALTER TABLE dental_q_page3 ADD COLUMN  clinch_grind_text varchar(255);
ALTER TABLE dental_q_page3 ADD COLUMN  future_dental_det varchar(255);
ALTER TABLE dental_q_page3 ADD COLUMN  drymouth_text varchar(255);

ALTER TABLE dental_q_page3 ADD COLUMN family_hd varchar(50);
ALTER TABLE dental_q_page3 ADD COLUMN family_bp varchar(50);
ALTER TABLE dental_q_page3 ADD COLUMN family_dia varchar(50);
ALTER TABLE dental_q_page3 ADD COLUMN family_sd varchar(50);
ALTER TABLE dental_q_page3 ADD COLUMN alcohol varchar(50);
ALTER TABLE dental_q_page3 ADD COLUMN sedative varchar(50);
ALTER TABLE dental_q_page3 ADD COLUMN caffeine varchar(50);
ALTER TABLE dental_q_page3 ADD COLUMN smoke varchar(50);
ALTER TABLE dental_q_page3 ADD COLUMN smoke_packs varchar(50);
ALTER TABLE dental_q_page3 ADD COLUMN tobacco varchar(50);
ALTER TABLE dental_q_page3 ADD COLUMN additional_paragraph varchar(50);
