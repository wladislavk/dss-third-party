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
ALTER TABLE dental_q_page2 ADD COLUMN surgery varchar(50);


CREATE TABLE `dental_q_page2_surgery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `patientid` int(11) DEFAULT NULL,
  `surgery_date` datetime DEFAULT NULL,
  `surgery` varchar(255) DEFAULT NULL,
  `surgeon` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

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
ALTER TABLE dental_q_page3 ADD COLUMN additional_paragraph text;


