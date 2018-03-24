CREATE TABLE dental_payment_reports (
  payment_id INT NOT NULL AUTO_INCREMENT,
  claimid INT,
  reference_id VARCHAR(50),
  response TEXT,
  adddate DATETIME,
  ip_address  VARCHAR(50),
  PRIMARY KEY (payment_id)
);