ALTER TABLE dental_contact ADD COLUMN old_referredbyid int(11);

UPDATE dental_contact c SET old_referredbyid=
	(SELECT r.referredbyid from dental_referredby r WHERE
		r.firstname = c.firstname AND
		r.lastname = c.lastname AND
		r.company = c.company);

UPDATE dental_letters l SET md_referral_list=
	(SELECT c.contactid FROM dental_contact c WHERE
		c.old_referredbyid = l.md_referral_list)
	WHERE l.generated_date < '2011-10-28 16:47:00';
