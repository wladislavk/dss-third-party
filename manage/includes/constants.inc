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
// $dss_trxn_status_labels[DSS_TRXN_NA]['short'] = 'N/A';
$dss_trxn_status_labels[DSS_TRXN_PENDING] = 'Pending';
// $dss_trxn_status_labels[DSS_TRXN_PENDING]['short'] = 'Pend.';
$dss_trxn_status_labels[DSS_TRXN_PROCESSING] = 'Processing';
// $dss_trxn_status_labels[DSS_TRXN_PROCESSING]['short'] = 'Proc.';
$dss_trxn_status_labels[DSS_TRXN_SENT] = 'Sent';
// $dss_trxn_status_labels[DSS_TRXN_SENT]['short'] = 'Sent';
$dss_trxn_status_labels[DSS_TRXN_PAID] = 'Paid';
// $dss_trxn_status_labels[DSS_TRXN_PAID]['short'] = 'Paid';
$dss_trxn_status_labels[DSS_TRXN_REJECTED] = 'Rejected';
// $dss_trxn_status_labels[DSS_TRXN_REJECTED]['short'] = 'Rej.';

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
define('DSS_CLAIM_PATIENT_DISPUTE', 10);
define('DSS_CLAIM_PAID_SEC_PATIENT', 11);
define('DSS_CLAIM_SEC_PATIENT_DISPUTE', 12);
define('DSS_CLAIM_SEC_REJECTED', 13);
define('DSS_CLAIM_EFILE_ACCEPTED', 14);
define('DSS_CLAIM_SEC_EFILE_ACCEPTED', 15);

// A convenience array to get claim labels
$dss_claim_status_labels = array();
$dss_claim_status_labels[DSS_CLAIM_PENDING] = 'Pending';
// $dss_claim_status_labels[DSS_CLAIM_PENDING]['short'] = 'Pend.';
$dss_claim_status_labels[DSS_CLAIM_SENT] = 'Sent';
// $dss_claim_status_labels[DSS_CLAIM_SENT]['short'] = 'Sent';
$dss_claim_status_labels[DSS_CLAIM_DISPUTE] = 'Disputed';
// $dss_claim_status_labels[DSS_CLAIM_DISPUTE]['short'] = 'Disp.';
$dss_claim_status_labels[DSS_CLAIM_PAID_INSURANCE] = 'Paid';
// $dss_claim_status_labels[DSS_CLAIM_PAID_INSURANCE]['short'] = 'Paid';
$dss_claim_status_labels[DSS_CLAIM_PAID_PATIENT] = 'Paid to Patient';
// $dss_claim_status_labels[DSS_CLAIM_PAID_PATIENT]['short'] = 'Paid to pt.';
$dss_claim_status_labels[DSS_CLAIM_REJECTED] = 'Rejected';
// $dss_claim_status_labels[DSS_CLAIM_REJECTED]['short'] = 'Rej.';
$dss_claim_status_labels[DSS_CLAIM_SEC_PENDING] = 'Secondary Pending';
// $dss_claim_status_labels[DSS_CLAIM_SEC_PENDING]['short'] = 'Sec Pend.';
$dss_claim_status_labels[DSS_CLAIM_SEC_SENT] = 'Secondary Sent';
// $dss_claim_status_labels[DSS_CLAIM_SEC_SENT]['short'] = 'Sec Sent';
$dss_claim_status_labels[DSS_CLAIM_SEC_DISPUTE] = 'Secondary Disputed';
// $dss_claim_status_labels[DSS_CLAIM_SEC_DISPUTE]['short'] = 'Sec Disp.';
$dss_claim_status_labels[DSS_CLAIM_PAID_SEC_INSURANCE] = 'Secondary Paid';
// $dss_claim_status_labels[DSS_CLAIM_PAID_SEC_INSURANCE]['short'] = 'Sec. Paid';
$dss_claim_status_labels[DSS_CLAIM_PATIENT_DISPUTE] = 'Disputed';
// $dss_claim_status_labels[DSS_CLAIM_PATIENT_DISPUTE]['short'] = 'Disp.';
$dss_claim_status_labels[DSS_CLAIM_PAID_SEC_PATIENT] = 'Secondary Paid to Patient';
// $dss_claim_status_labels[DSS_CLAIM_PAID_SEC_PATIENT]['short'] = 'Sec. Paid to pt.';
$dss_claim_status_labels[DSS_CLAIM_SEC_PATIENT_DISPUTE] = 'Secondary Disputed';
// $dss_claim_status_labels[DSS_CLAIM_SEC_PATIENT_DISPUTE]['short'] = 'Sec. Disp.';
// $dss_claim_status_labels[DSS_CLAIM_SEC_PATIENT_DISPUTE]['short'] = 'Sec. Disp.';
$dss_claim_status_labels[DSS_CLAIM_EFILE_ACCEPTED] = 'Efile Accepted';
// $dss_claim_status_labels[DSS_CLAIM_EFILE_ACCEPTED]['short'] = 'E-Acc.';
$dss_claim_status_labels[DSS_CLAIM_SEC_EFILE_ACCEPTED] = 'Secondary Efile Accepted';
// $dss_claim_status_labels[DSS_CLAIM_SEC_EFILE_ACCEPTED]['short'] = 'Sec. E-Acc.';

// Pre-authorization statuses (pre-auth)
define('DSS_PREAUTH_PENDING', 0);
define('DSS_PREAUTH_COMPLETE', 1);
define('DSS_PREAUTH_PREAUTH_PENDING', 2);
define('DSS_PREAUTH_REJECTED', 3);

// A convenience array to get pre-auth labels
$dss_preauth_status_labels = array();
$dss_preauth_status_labels[DSS_PREAUTH_PENDING] = 'Pending';
// $dss_preauth_status_labels[DSS_PREAUTH_PENDING]['short'] = 'Pend.';
$dss_preauth_status_labels[DSS_PREAUTH_COMPLETE] = 'Complete';
// $dss_preauth_status_labels[DSS_PREAUTH_COMPLETE]['short'] = 'Comp.';
$dss_preauth_status_labels[DSS_PREAUTH_PREAUTH_PENDING] = 'Pre-Auth Pending';
// $dss_preauth_status_labels[DSS_PREAUTH_PREAUTH_PENDING]['short'] = 'Pre-Auth Pend.';
$dss_preauth_status_labels[DSS_PREAUTH_REJECTED] = 'Rejected';
// $dss_preauth_status_labels[DSS_PREAUTH_REJECTED]['short'] = 'Rjct.';

// Pre-authorization statuses (pre-auth)
define('DSS_HST_REQUESTED', 0);
define('DSS_HST_PENDING', 1);
define('DSS_HST_SCHEDULED', 2);
define('DSS_HST_COMPLETE', 3);
define('DSS_HST_REJECTED', 4);
define('DSS_HST_CONTACTED', 5);

// A convenience array to get pre-auth labels
$dss_hst_status_labels = array();
$dss_hst_status_labels[DSS_HST_REQUESTED] = 'Unsent';
$dss_hst_status_labels[DSS_HST_PENDING] = 'Pending';
$dss_hst_status_labels[DSS_HST_SCHEDULED] = 'Scheduled';
$dss_hst_status_labels[DSS_HST_COMPLETE] = 'Complete';
$dss_hst_status_labels[DSS_HST_REJECTED] = 'Rejected';
$dss_hst_status_labels[DSS_HST_CONTACTED] = 'Contacted';

//Transaction Payers (ledger)
define('DSS_TRXN_PAYER_PRIMARY', 0);
define('DSS_TRXN_PAYER_SECONDARY', 1);
define('DSS_TRXN_PAYER_PATIENT', 2);
define('DSS_TRXN_PAYER_WRITEOFF', 3);
define('DSS_TRXN_PAYER_DISCOUNT', 4);

// A convenience array to get trxn payment labels
$dss_trxn_payer_labels = array();
$dss_trxn_payer_labels[DSS_TRXN_PAYER_PRIMARY] = "Primary Insurance";
// $dss_trxn_payer_labels[DSS_TRXN_PAYER_PRIMARY]['short'] = "Prim. Ins.";
$dss_trxn_payer_labels[DSS_TRXN_PAYER_SECONDARY] = "Secondary Insurance";
// $dss_trxn_payer_labels[DSS_TRXN_PAYER_SECONDARY]['short'] = "Sec. Ins.";
$dss_trxn_payer_labels[DSS_TRXN_PAYER_PATIENT] = "Patient";
// $dss_trxn_payer_labels[DSS_TRXN_PAYER_PATIENT]['short'] = "Pat.";
$dss_trxn_payer_labels[DSS_TRXN_PAYER_WRITEOFF] = "Write Off";
// $dss_trxn_payer_labels[DSS_TRXN_PAYER_WRITEOFF]['short'] = "Write Off";
$dss_trxn_payer_labels[DSS_TRXN_PAYER_DISCOUNT] = "Professional Discount";
// $dss_trxn_payer_labels[DSS_TRXN_PAYER_DISCOUNT]['short'] = "Pro. Disc.";

//Transaction Payment Types (ledger)
define('DSS_TRXN_PYMT_CREDIT', 0);
define('DSS_TRXN_PYMT_DEBIT', 1);
define('DSS_TRXN_PYMT_CHECK', 2);
define('DSS_TRXN_PYMT_CASH', 3);
define('DSS_TRXN_PYMT_WRITEOFF', 4);
define('DSS_TRXN_PYMT_EFT', 5);

// A convenience array to get trxn payment type labels
$dss_trxn_pymt_type_labels = array();
$dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CREDIT] = "Credit Card";
// $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CREDIT]['short'] = "CC";
$dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_DEBIT] = "Debit";
// $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_DEBIT]['short'] = "Debit";
$dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CHECK] = "Check";
// $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CHECK]['short'] = "Check";
$dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CASH] = "Cash";
// $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_CASH]['short'] = "Cash";
$dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_WRITEOFF] = "Write Off";
// $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_WRITEOFF]['short'] = "Write Off";
$dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_EFT] = "E-Funds Transfer (EFT)";
// $dss_trxn_pymt_type_labels[DSS_TRXN_PYMT_EFT]['short'] = "EFT";

//Max File size allowed for upload forms
define('DSS_FILE_MAX_SIZE', 10000000);

//Allowed File Types for upload forms
define('DSS_FILE_IMAGE_GIF', 0);
define('DSS_FILE_IMAGE_JPEG', 1);
define('DSS_FILE_IMAGE_PJPEG', 2);
define('DSS_FILE_APP_PDF', 3);
define('DSS_FILE_IMAGE_PNG', 4);
define('DSS_FILE_IMAGE_BMP', 5);
define('DSS_FILE_APP_DOC', 6);
define('DSS_FILE_APP_DOCX', 7);
define('DSS_FILE_APP_XLS', 8);
define('DSS_FILE_APP_XLSX', 9);

// A convenience array to get file types
$dss_image_file_types = array();
$dss_image_file_types[DSS_FILE_IMAGE_GIF] = "image/gif";
$dss_image_file_types[DSS_FILE_IMAGE_JPEG] = "image/jpeg";
$dss_image_file_types[DSS_FILE_IMAGE_PJPEG] = "image/pjpeg";
$dss_image_file_types[DSS_FILE_IMAGE_PNG] = "image/png";
$dss_image_file_types[DSS_FILE_IMAGE_BMP] = "image/bmp";

// A convenience array to get file types
$dss_file_types = array();
$dss_file_types[DSS_FILE_IMAGE_GIF] = "image/gif";
$dss_file_types[DSS_FILE_IMAGE_JPEG] = "image/jpeg";
$dss_file_types[DSS_FILE_IMAGE_PJPEG] = "image/pjpeg";
$dss_file_types[DSS_FILE_IMAGE_PNG] = "image/png";
$dss_file_types[DSS_FILE_APP_PDF] = "application/pdf";
$dss_file_types[DSS_FILE_IMAGE_BMP] = "image/bmp";
$dss_file_types[DSS_FILE_APP_DOC] = "application/msword";
$dss_file_types[DSS_FILE_APP_DOCX] = "application/vnd.openxmlformats-officedocument.wordprocessingml.document";
$dss_file_types[DSS_FILE_APP_XLS] = "application/vnd.ms-excel";
$dss_file_types[DSS_FILE_APP_XLSX] = "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet";

// Detect the extension if the filetype attribute is not reliable
$dss_file_extensions = array();
$dss_file_extensions[DSS_FILE_IMAGE_GIF] = "gif";
$dss_file_extensions[DSS_FILE_IMAGE_JPEG] = "jpg";
$dss_file_extensions[DSS_FILE_IMAGE_PJPEG] = "pjpeg";
$dss_file_extensions[DSS_FILE_IMAGE_PNG] = "png";
$dss_file_extensions[DSS_FILE_APP_PDF] = "pdf";
$dss_file_extensions[DSS_FILE_IMAGE_BMP] = "bmp";
$dss_file_extensions[DSS_FILE_APP_DOC] = "doc";
$dss_file_extensions[DSS_FILE_APP_DOCX] = "docx";
$dss_file_extensions[DSS_FILE_APP_XLS] = "xls";
$dss_file_extensions[DSS_FILE_APP_XLSX] = "xlsx";

define('DSS_IMAGE_MAX_SIZE', 10000000);
define('DSS_IMAGE_MAX_WIDTH', 2000);
define('DSS_IMAGE_MAX_HEIGHT', 2000);
define('DSS_IMAGE_RESIZE_WIDTH', 1500);
define('DSS_IMAGE_RESIZE_HEIGHT', 1500);
define('DSS_IMAGE_PROFILE_WIDTH', 200);
define('DSS_IMAGE_PROFILE_HEIGHT', 200);
define('DSS_IMAGE_DEVICE_WIDTH', 150);
define('DSS_IMAGE_DEVICE_HEIGHT', 150);

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
$dss_referred_labels[DSS_REFERRED_FRANCHISE] = "Internal";
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

define('DSS_USER_TYPE_FRANCHISEE', 1);
define('DSS_USER_TYPE_SOFTWARE', 2);
$dss_user_type_labels = array();
$dss_user_type_labels[DSS_USER_TYPE_FRANCHISEE] = "Franchisee";
$dss_user_type_labels[DSS_USER_TYPE_SOFTWARE] = "Software";

define('DSS_ADMIN_ACCESS_SUPER', 1);
define('DSS_ADMIN_ACCESS_ADMIN', 2);
define('DSS_ADMIN_ACCESS_BASIC', 3);
define('DSS_ADMIN_ACCESS_BILLING_ADMIN', 4);
define('DSS_ADMIN_ACCESS_BILLING_BASIC', 5);
define('DSS_ADMIN_ACCESS_HST_ADMIN', 6);
define('DSS_ADMIN_ACCESS_HST_BASIC', 7);

$dss_admin_access_labels = array();
$dss_admin_access_labels[DSS_ADMIN_ACCESS_SUPER] = "Super User";
$dss_admin_access_labels[DSS_ADMIN_ACCESS_ADMIN] = "Admin User";
$dss_admin_access_labels[DSS_ADMIN_ACCESS_BASIC] = "Basic User";
$dss_admin_access_labels[DSS_ADMIN_ACCESS_BILLING_ADMIN] = "Billing Admin User";
$dss_admin_access_labels[DSS_ADMIN_ACCESS_BILLING_BASIC] = "Billing Basic User";
$dss_admin_access_labels[DSS_ADMIN_ACCESS_HST_ADMIN] = "HST Admin User";
$dss_admin_access_labels[DSS_ADMIN_ACCESS_HST_BASIC] = "HST Basic User";


define('DSS_USER_ACCESS_STAFF', 1);
define('DSS_USER_ACCESS_DOCTOR', 2);

define('DSS_INVOICE_PENDING', 4);
define('DSS_INVOICE_INVOICED', 0);
define('DSS_INVOICE_PAID', 1);
define('DSS_INVOICE_ERROR', 2);
define('DSS_INVOICE_PAYMENT_ERROR', 3);

define('DSS_PERCASE_PENDING', 0);
define('DSS_PERCASE_INVOICED', 1);

define('DSS_INVOICE_TYPE_SU_FO', 1); //Super invoices front office
define('DSS_INVOICE_TYPE_BC_FO', 2); //Billing company invoices front office
define('DSS_INVOICE_TYPE_SU_BC', 3); //Super invoices billing company


define('DSS_LETTER_PENDING', 0);
define('DSS_LETTER_SENT', 1);
define('DSS_LETTER_SEND_FAILED', 2);

define('DSS_STRIPE_PUB_KEY', 'pk_test_AwG89We9HPlSSaFDI1TZgnie');
define('DSS_STRIPE_SEC_KEY', 'sk_test_2Bwg6V5pLmm8Gbidwxc8Iwhk');

define('DSS_DEVICE_SETTING_TYPE_RANGE', 0);
define('DSS_DEVICE_SETTING_TYPE_FLAG', 1);

$dss_device_setting_type_labels = array();
$dss_device_setting_type_labels[DSS_DEVICE_SETTING_TYPE_RANGE] = "Range";
$dss_device_setting_type_labels[DSS_DEVICE_SETTING_TYPE_FLAG] = "Flag";

define('DSS_AMOUNT_ADJUST_USER', 0);
define('DSS_AMOUNT_ADJUST_NEGATIVE', 1);
define('DSS_AMOUNT_ADJUST_POSITIVE', 2);

$dss_amount_adjust_labels = array();
$dss_amount_adjust_labels[DSS_AMOUNT_ADJUST_USER] = "User Entered";
$dss_amount_adjust_labels[DSS_AMOUNT_ADJUST_NEGATIVE] = "Always Negative";
$dss_amount_adjust_labels[DSS_AMOUNT_ADJUST_POSITIVE] = "Always Positive";

define('DSS_EMAIL_FOOTER', '<i>Dental Sleep Solutions will never ask you for passwords or payment information via email.</i> The contents of this message, together with any attachments, are intended only for the use of the individual or entity to which they are addressed and may contain information that is legally privileged, confidential and exempt from disclosure. If you are not the intended recipient, you are hereby notified that any dissemination, distribution or copying of this message, or any attachment, is strictly prohibited. If you have received this message in error, please notify the original sender or contact Dental Sleep Solutions immediately by telephone (941-757-4642) or by responding to this email and delete this message, along with any attachments, from your computer.');


define('DSS_TICKET_STATUS_OPEN', 0);
define('DSS_TICKET_STATUS_REOPENED', 1);
define('DSS_TICKET_STATUS_CLOSED', 2);

$dss_ticket_status_labels = array();
$dss_ticket_status_labels[DSS_TICKET_STATUS_OPEN] = "Open";
$dss_ticket_status_labels[DSS_TICKET_STATUS_REOPENED] = "Re-opened";
$dss_ticket_status_labels[DSS_TICKET_STATUS_CLOSED] = "Closed";


define('DSS_COMPANY_TYPE_BILLING', 0);
define('DSS_COMPANY_TYPE_SOFTWARE', 1);
define('DSS_COMPANY_TYPE_HST', 2);

$dss_company_type_labels = array();
$dss_company_type_labels[DSS_COMPANY_TYPE_BILLING] = "Billing";
$dss_company_type_labels[DSS_COMPANY_TYPE_SOFTWARE] = "Software";
$dss_company_type_labels[DSS_COMPANY_TYPE_HST] = "HST";

define('DSS_USER_STATUS_ACTIVE', 1);
define('DSS_USER_STATUS_INACTIVE', 2);
define('DSS_USER_STATUS_SUSPENDED', 3);

$dss_user_status_labels = array();
$dss_user_status_labels[DSS_USER_STATUS_ACTIVE] = 'Active';
$dss_user_status_labels[DSS_USER_STATUS_INACTIVE] = 'In-Active';
$dss_user_status_labels[DSS_USER_STATUS_SUSPENDED] = 'Suspended';

define('DSS_OFFICE_TYPE_BACK', 0);
define('DSS_OFFICE_TYPE_FRONT', 1);


define('DSS_ENROLLMENT_SUBMITTED', 0);
define('DSS_ENROLLMENT_ACCEPTED', 1);
define('DSS_ENROLLMENT_REJECTED', 2);
define('DSS_ENROLLMENT_PDF_RECEIVED', 3);
define('DSS_ENROLLMENT_PDF_SENT', 4);

$dss_enrollment_labels = array();
$dss_enrollment_labels[DSS_ENROLLMENT_SUBMITTED] = 'Submitted';
$dss_enrollment_labels[DSS_ENROLLMENT_ACCEPTED] = 'Accepted';
$dss_enrollment_labels[DSS_ENROLLMENT_REJECTED] = 'Rejected';
$dss_enrollment_labels[DSS_ENROLLMENT_PDF_RECEIVED] = 'PDF Received';
$dss_enrollment_labels[DSS_ENROLLMENT_PDF_SENT] = 'PDF Sent';

define('DSS_DEFAULT_ELIGIBLE_API_KEY', '33b2e3a5-8642-1285-d573-07a22f8a15b4');

$dss_file_upload_errors = array(
    UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
    UPLOAD_ERR_NO_FILE => 'No file was uploaded',
    UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
    UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
    UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload',
);

define('DSS_CLAIM_FILE_TYPE_RX', 6);
define('DSS_CLAIM_FILE_TYPE_LOMN', 7);
define('DSS_CLAIM_FILE_TYPE_BOTH', 14);
