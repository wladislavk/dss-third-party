CREATE TABLE dental_document_category (
  categoryid int(11) NOT NULL AUTO_INCREMENT,
  name varchar(200),
  status int(1),
  adddate datetime default NULL,
  ip_address varchar(50) default NULL,
  PRIMARY KEY (`categoryid`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1; 

CREATE TABLE dental_document (
  documentid int(11) NOT NULL AUTO_INCREMENT,
  categoryid int(11) NOT NULL,
  name varchar(200),
  filename varchar(200),
  adddate datetime default NULL,
  ip_address varchar(50) default NULL,
  PRIMARY KEY (`documentid`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
