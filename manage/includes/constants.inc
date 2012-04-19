<?php
// Transaction statuses (ledger)
define('DSS_TRXN_NA', 0);         // trxn created/updated, but not filed.
define('DSS_TRXN_PENDING', 1);    // trxn's 'File' checkbox checked.
define('DSS_TRXN_PROCESSING', 2); // trxn's associated claim form is being processed by back office.
define('DSS_TRXN_SENT', 3);       // trxn's associated claim form was sent to insurance.
define('DSS_TRXN_PAID', 4);       // trxn's associated claim was received by front office and paid.
define('DSS_TRXN_REJECTED', 5);   // trxn's associated claim was received by front office and not paid.

// A convenience array to get trxn labels
$dss_trxn_status_labels = array();
$dss_trxn_status_labels[DSS_TRXN_NA] = 'N/A';
$dss_trxn_status_labels[DSS_TRXN_NA]['short'] = 'N/A';
$dss_trxn_status_labels[DSS_TRXN_PENDING] = 'Pending';
$dss_trxn_status_labels[DSS_TRXN_PENDING]['short'] = 'Pend.';
$dss_trxn_status_labels[DSS_TRXN_PROCESSING] = 'Processing';
$dss_trxn_status_labels[DSS_TRXN_PROCESSING]['short'] = 'Proc.';
$dss_trxn_status_labels[DSS_TRXN_SENT] = 'Sent';
$dss_trxn_status_labels[DSS_TRXN_SENT]['short'] = 'Sent';
$dss_trxn_status_labels[DSS_TRXN_PAID] = 'Paid';
$dss_trxn_status_labels[DSS_TRXN_PAID]['short'] = 'Paid';
$dss_trxn_status_labels[DSS_TRXN_REJECTED] = 'Rejected';
$dss_trxn_status_labels[DSS_TRXN_REJECTED]['short'] = 'Rej.';

// Transaction types (ledger)
define('DSS_TRXN_TYPE_MED', 1);
define('DSS_TRXN_TYPE_PATIENT', 2);
define('DSS_TRXN_TYPE_INS', 3);
define('DSS_TRXN_TYPE_DIAG', 4);
define('DSS_TRXN_TYPE_ADJ', 6);

// A convenience array to get trxn type labels
$dss_trxn_type_labels = array();
$dss_trxn_type_labels[DSS_TRXN_TYPE_MED] = 'Medical Code';
$dss_trxn_type_labels[DSS_TRXN_TYPE_PATIENT] = 'Patient Payment Code';
$dss_trxn_type_labels[DSS_TRXN_TYPE_INS] = 'Insurance Payment Code';
$dss_trxn_type_labels[DSS_TRXN_TYPE_DIAG] = 'Dianostic Code';
$dss_trxn_type_labels[DSS_TRXN_TYPE_ADJ] = 'Adjustment Code';

// Claim statuses (insurance)
define('DSS_CLAIM_PENDING', 0);
define('DSS_CLAIM_SENT', 1);
define('DSS_CLAIM_DISPUTE', 2);
define('DSS_CLAIM_PAID_INSURANCE', 3);
define('DSS_CLAIM_REJECTED', 4);
define('DSS_CLAIM_PAID_PATIENT', 5);
define('DSS_CLAIM_SEC_PENDING', 6);
define('DSS_CLAIM_SEC_SENT', 7);
define('DSS_CLAIM_SEC_DISPUTE', 8);
define('DSS_CLAIM_PAID_SEC_INSURANCE', 9);

// A convenience array to get claim labels
$dss_claim_status_labels = array();
$dss_claim_status_labels[DSS_CLAIM_PENDING] = 'Pending';
$dss_claim_status_labels[DSS_CLAIM_PENDING]['short'] = 'Pend.';
$dss_claim_status_labels[DSS_CLAIM_SENT] = 'Sent';
$dss_claim_status_labels[DSS_CLAIM_SENT]['short'] = 'Sent';
$dss_claim_status_labels[DSS_CLAIM_DISPUTE] = 'Disputed';
$dss_claim_status_labels[DSS_CLAIM_DISPUTE]['short'] = 'Disp.';
$dss_claim_status_labels[DSS_CLAIM_PAID_INSURANCE] = 'Paid';
$dss_claim_status_labels[DSS_CLAIM_PAID_INSURANCE]['short'] = 'Paid';
$dss_claim_status_labels[DSS_CLAIM_PAID_PATIENT] = 'Paid to Patient';
$dss_claim_status_labels[DSS_CLAIM_PAID_PATIENT]['short'] = 'Paid to pt.';
$dss_claim_status_labels[DSS_CLAIM_REJECTED] = 'Rejected';
$dss_claim_status_labels[DSS_CLAIM_REJECTED]['short'] = 'Rej.';
$dss_claim_status_labels[DSS_CLAIM_SEC_PENDING] = 'Secondary Pending';
$dss_claim_status_labels[DSS_CLAIM_SEC_PENDING]['short'] = 'Sec Pend.';
$dss_claim_status_labels[DSS_CLAIM_SEC_SENT] = 'Secondary Sent';
$dss_claim_status_labels[DSS_CLAIM_SEC_SENT]['short'] = 'Sec Sent';
$dss_claim_status_labels[DSS_CLAIM_SEC_DISPUTE] = 'Secondary Disputed';
$dss_claim_status_labels[DSS_CLAIM_SEC_DISPUTE]['short'] = 'Sec Disp.';
$dss_claim_status_labels[DSS_CLAIM_PAID_SEC_INSURANCE] = 'Secondary Paid';
$dss_claim_status_labels[DSS_CLAIM_PAID_SEC_INSURANCE]['short'] = 'Sec. Paid';

// Pre-authorization statuses (pre-auth)
define('DSS_PREAUTH_PENDING', 0);
define('DSS_PREAUTH_COMPLETE', 1);
define('DSS_PREAUTH_PREAUTH_PENDING', 2);
define('DSS_PREAUTH_REJECTED', 3);

// A convenience array to get pre-auth labels
$dss_preauth_status_labels = array();
$dss_preauth_status_labels[DSS_PREAUTH_PENDING] = 'Pending';
$dss_preauth_status_labels[DSS_PREAUTH_PENDING]['short'] = 'Pend.';
$dss_preauth_status_labels[DSS_PREAUTH_COMPLETE] = 'Complete';
$dss_preauth_status_labels[DSS_PREAUTH_COMPLETE]['short'] = 'Comp.';
$dss_preauth_status_labels[DSS_PREAUTH_PREAUTH_PENDING] = 'Pre-Auth Pending';
$dss_preauth_status_labels[DSS_PREAUTH_PREAUTH_PENDING]['short'] = 'Pre-Auth Pend.';
$dss_preauth_status_labels[DSS_PREAUTH_REJECTED] = 'Rejected';
$dss_preauth_status_labels[DSS_PREAUTH_REJECTED]['short'] = 'Rjct.';

//Transaction Payers (ledger)
define('DSS_TRXN_PAYER_PRIMARY', 0);
define('DSS_TRXN_PAYER_SECONDARY', 1);
define('DSS_TRXN_PAYER_PATIENT', 2);
define('DSS_TRXN_PAYER_WRITEOFF', 3);
define('DSS_TRXN_PAYER_DISCOUNT', 4);

// A convenience array to get trxn payment labels
$dss_trxn_payer_labels = array();
$dss_trxn_payer_labels[DSS_TRXN_PAYER_PRIMARY] = "Primary Insurance";
$dss_trxn_payer_labels[DSS_TRXN_PAYER_PRIMARY]['short'] = "Prim. Ins.";
$dss_trxn_payer_labels[DSS_TRXN_PAYER_SECONDARY] = "Secondary Insurance";
$dss_trxn_payer_labels[DSS_TRXN_PAYER_SECONDARY]['short'] = "Sec. Ins.";
$dss_trxn_payer_labels[DSS_TRXN_PAYER_PATIENT] = "Patient";
$dss_trxn_payer_labels[DSS_TRXN_PAYER_PATIENT]['short'] = "Pat.";
$dss_trxn_payer_labels[DSS_TRXN_PAYER_WRITEOFF] = "Write Off";
$dss_trxn_payer_labels[DSS_TRXN_PAYER_WRITEOFF]['short'] = "Write Off";
$dss_trxn_payer_labels[DSS_TRXN_PAYER_DISCOUNT] = "Professional Discount";
$dss_trxn_payer_labels[DSS_TRXN_PAYER_DISCOUNT]['short'] = "Pro. Disc.";

//Transaction Payment Types (ledger)
define('DSS_TRXN_PYMT_CREDIT', 0);
define('DSS_TRXN_PYMT_DEBIT', 1);
define('DSS_TRXN_PYMT_CHECK', 2);
define('DSS_TRXN_PYMT_CASH', 3);
define('DSS_TRXN_PYMT_WRITEOFF', 4);

// A convenience array to get trxn payment type labels
$dss_trxn_pymt_type_labels = array();
$dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CREDIT] = "Credit Card";
$dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CREDIT]['short'] = "CC";
$dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_DEBIT] = "Debit";
$dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_DEBIT]['short'] = "Debit";
$dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CHECK] = "Check";
$dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CHECK]['short'] = "Check";
$dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CASH] = "Cash";
$dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CASH]['short'] = "Cash";
$dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_WRITEOFF] = "Write Off";
$dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_WRITEOFF]['short'] = "Write Off";

//Max File size allowed for upload forms
define('DSS_FILE_MAX_SIZE', 20000000);

//Allowed File Types for upload forms
define('DSS_FILE_IMAGE_GIF', 0);
define('DSS_FILE_IMAGE_JPEG', 1);
define('DSS_FILE_IMAGE_PJPEG', 2);
define('DSS_FILE_APP_PDF', 3);

// A convenience array to get file types
$dss_image_file_types = array();
$dss_image_file_types[DSS_FILE_IMAGE_GIF] = "image/gif";
$dss_image_file_types[DSS_FILE_IMAGE_JPEG] = "image/jpeg";
$dss_image_file_types[DSS_FILE_IMAGE_PJPEG] = "image/pjpeg";

// A convenience array to get file types
$dss_file_types = array();
$dss_file_types[DSS_FILE_IMAGE_GIF] = "image/gif";
$dss_file_types[DSS_FILE_IMAGE_JPEG] = "image/jpeg";
$dss_file_types[DSS_FILE_IMAGE_PJPEG] = "image/pjpeg";
$dss_file_types[DSS_FILE_APP_PDF] = "application/pdf";

define('DSS_IMAGE_MAX_WIDTH', 2000);
define('DSS_IMAGE_MAX_HEIGHT', 2000);


// User types
define('DSS_USER_TYPE_ROOT', 4);
define('DSS_USER_TYPE_GLOBAL', 3);
define('DSS_USER_TYPE_ADMIN', 2);
define('DSS_USER_TYPE_LOCAL', 1);

$dss_user_type_labels = array();
$dss_user_type_labels[DSS_USER_TYPE_ROOT] = "Root User";
$dss_user_type_labels[DSS_USER_TYPE_GLOBAL] = "Global User";
$dss_user_type_labels[DSS_USER_TYPE_ADMIN] = "Local Admin";
$dss_user_type_labels[DSS_USER_TYPE_LOCAL] = "Local User";

/* Dynamically provided in database and set up by backoffice form
// Appliances 
define('DSS_APPLIANCE_MRD', 1);
define('DSS_APPLIANCE_TRD', 2);
define('DSS_APPLIANCE_TRD2', 3);
define('DSS_APPLIANCE_TAP3', 5);

$dss_appliance_labels = array();
$dss_appliance_labels[DSS_APPLIANCE_MRD] = "FDA approved mandibular repositioning device (MRD)";
$dss_appliance_labels[DSS_APPLIANCE_MRD]["short"] = "";
$dss_appliance_labels[DSS_APPLIANCE_TRD] = "FDA approved tongue retaining device";
$dss_appliance_labels[DSS_APPLIANCE_TRD]["short"] = "";
$dss_appliance_labels[DSS_APPLIANCE_TRD2] = "FDA approved tongue retaining device with breathing tube";
$dss_appliance_labels[DSS_APPLIANCE_TRD2]["short"] = "";
$dss_appliance_labels[DSS_APPLIANCE_TAP3] = "TAP 3";
$dss_appliance_labels[DSS_APPLIANCE_TAP3]["short"] = "";
*/

define('DSS_REFERRED_PATIENT', 1);
define('DSS_REFERRED_PHYSICIAN', 2);
define('DSS_REFERRED_MEDIA', 3);
define('DSS_REFERRED_FRANCHISE', 4);
define('DSS_REFERRED_DSSOFFICE', 5);
define('DSS_REFERRED_OTHER', 6);

$dss_referred_labels = array();
$dss_referred_labels[DSS_REFERRED_PATIENT] = "Patient";
$dss_referred_labels[DSS_REFERRED_PHYSICIAN] = "Physician";
$dss_referred_labels[DSS_REFERRED_MEDIA] = "Media";
$dss_referred_labels[DSS_REFERRED_FRANCHISE] = "Franchise";
$dss_referred_labels[DSS_REFERRED_DSSOFFICE] = "DSS Office";
$dss_referred_labels[DSS_REFERRED_OTHER] = "Other";


define('DSS_PATIENT_CONTACT_SLEEP', 1);
define('DSS_PATIENT_CONTACT_PRIMARY', 2);
define('DSS_PATIENT_CONTACT_DENTIST', 3);
define('DSS_PATIENT_CONTACT_ENT', 4);
define('DSS_PATIENT_CONTACT_OTHER', 5);

$dss_patient_contact_labels = array();
$dss_patient_contact_labels[DSS_PATIENT_CONTACT_SLEEP] = "Sleep MD";
$dss_patient_contact_labels[DSS_PATIENT_CONTACT_PRIMARY] = "Primary Care MD";
$dss_patient_contact_labels[DSS_PATIENT_CONTACT_DENTIST] = "Dentist";
$dss_patient_contact_labels[DSS_PATIENT_CONTACT_ENT] = "ENT";
$dss_patient_contact_labels[DSS_PATIENT_CONTACT_OTHER] = "Other MD";


define('DSS_ADMIN_ACCESS_SUPER', 1);
define('DSS_ADMIN_ACCESS_BASIC', 2);

$dss_admin_access_labels = array();
$dss_admin_access_labels[DSS_ADMIN_ACCESS_SUPER] = "Super User";
$dss_admin_access_labels[DSS_ADMIN_ACCESS_BASIC] = "Basic User";
