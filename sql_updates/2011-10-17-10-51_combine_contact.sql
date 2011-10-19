ALTER TABLE dental_contact ADD COLUMN referredby_info int(1); 
ALTER TABLE dental_contact ADD COLUMN old_referredbyid int(11);
ALTER TABLE dental_patients ADD COLUMN referred_notes varchar(255);

INSERT INTO dental_contact (
	docid,
	salutation,
	lastname, 
	firstname,
	middlename,
	company,  
	add1,   
	add2,  
	city,  
	state,
	zip, 
	phone1,   
	phone2,  
	fax,    
	email, 
	national_provider_id,
	qualifier,          
	qualifierid,       
	greeting,         
	sincerely,       
	contacttypeid,  
	notes,         
	preferredcontact,
	status,         
	adddate,
	ip_address,
	referredby_info,
	old_referredbyid
	)
      SELECT 
	docid,
        salutation,
        lastname,       
        firstname,
        middlename,
        company,        
        add1,           
        add2,           
        city,           
        state,
        zip,            
        phone1,         
        phone2,
        fax,            
        email,          
        national_provider_id,
        qualifier,      
        qualifierid,    
        greeting,       
        sincerely,      
        contacttypeid,  
        notes,          
        preferredcontact,
        status,         
        adddate,
        ip_address,
        referredby_info,
        referredbyid
          FROM dental_referredby;


UPDATE dental_patients set referred_by = (select dental_contact.contactid from dental_contact WHERE dental_contact.old_referredbyid=dental_patients.referred_by);









ALTER TABLE dental_contact DROP COLUMN old_referredby_id;
