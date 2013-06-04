UPDATE dental_users SET
  use_patient_portal = 1,
  use_letters = 1,
  use_course = 1,
  use_course_staff = 1,
  homepage=1  
  WHERE userid IN (select userid from dental_user_company where companyid=4);

