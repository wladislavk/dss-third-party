alter table dental_insurance add column dispute_reason text;
alter table dental_insurance add column sec_dispute_reason text;

CREATE TABLE dental_insurance_file (
  id int(11) NOT NULL AUTO_INCREMENT,
  claimid int(11) NOT NULL,
  claimtype enum('primary', 'secondary'),
  filename varchar(200),
  adddate datetime default NULL,
  ip_address varchar(50) default NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;


