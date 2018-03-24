UPDATE dental_patients SET referred_source=2 where referred_by IS NOT NULL AND referred_by!='' AND referred_source not in (1,2,3,4,5,6,7);
