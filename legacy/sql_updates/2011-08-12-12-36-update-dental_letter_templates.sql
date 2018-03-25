UPDATE dental_letter_templates
SET name = "Ty to Other Referral"
WHERE id = '20';

UPDATE dental_letter_templates
SET name = "To Pt Termination" 
WHERE id = '24';

DELETE FROM dental_letter_templates WHERE id = '25'; 
