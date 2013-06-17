
INSERT INTO `dental_appt_types` (name, color, classname, docid) (SELECT 'General', 'FFF9CF', 'general', userid FROM dental_users WHERE docid=0);
INSERT INTO `dental_appt_types` (name, color, classname, docid) (SELECT 'Follow-up', 'D6CFFF', 'follow-up', userid FROM dental_users WHERE docid=0);
INSERT INTO `dental_appt_types` (name, color, classname, docid) (SELECT 'Sleep Test', 'CFF5FF', 'sleep_test', userid FROM dental_users WHERE docid=0);
INSERT INTO `dental_appt_types` (name, color, classname, docid) (SELECT 'Impressions', 'DFFFCF', 'impressions', userid FROM dental_users WHERE docid=0);
INSERT INTO `dental_appt_types` (name, color, classname, docid) (SELECT 'New Pt', 'FFCFCF', 'new_pt', userid FROM dental_users WHERE docid=0);
INSERT INTO `dental_appt_types` (name, color, classname, docid) (SELECT 'Deliver Device', 'FBA16C', 'deliver_device', userid FROM dental_users WHERE docid=0);


INSERT INTO `dental_resources` (name, rank, docid) (SELECT 'Chair 1', 1, userid FROM dental_users WHERE docid=0);
