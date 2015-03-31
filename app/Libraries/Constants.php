<?php namespace Ds3\Libraries;

class Constants
{
    // Transaction statuses (ledger)
    const DSS_TRXN_NA          = 0;
    const DSS_TRXN_PENDING     = 1;
    const DSS_TRXN_PROCESSING  = 2;
    const DSS_TRXN_SENT        = 3;
    const DSS_TRXN_PAID        = 4;
    const DSS_TRXN_REJECTED    = 5;
    
    // A convenience array to get trxn labels
    public static $dss_trxn_status_labels = array(
        self::DSS_TRXN_NA          => 'N/A',
        self::DSS_TRXN_PENDING     => 'Pending',
        self::DSS_TRXN_PROCESSING  => 'Processing',
        self::DSS_TRXN_SENT        => 'Sent',
        self::DSS_TRXN_PAID        => 'Paid',
        self::DSS_TRXN_REJECTED    => 'Rejected'
    );

    // Transaction types (ledger)
    const DSS_TRXN_TYPE_MED      = 1;
    const DSS_TRXN_TYPE_PATIENT  = 2;
    const DSS_TRXN_TYPE_INS      = 3;
    const DSS_TRXN_TYPE_DIAG     = 4;
    const DSS_TRXN_TYPE_ADJ      = 6;

    // A convenience array to get trxn type labels
    public static $dss_trxn_type_labels = array(
        self::DSS_TRXN_TYPE_MED      => 'Medical Code',
        self::DSS_TRXN_TYPE_PATIENT  => 'Patient Payment Code',
        self::DSS_TRXN_TYPE_INS      => 'Insurance Payment Code',
        self::DSS_TRXN_TYPE_DIAG     => 'Dianostic Code',
        self::DSS_TRXN_TYPE_ADJ      => 'Adjustment Code'
    );

    // Claim statuses (insurance)
    const DSS_CLAIM_PENDING              = 0;
    const DSS_CLAIM_SENT                 = 1;
    const DSS_CLAIM_DISPUTE              = 2;
    const DSS_CLAIM_PAID_INSURANCE       = 3;
    const DSS_CLAIM_REJECTED             = 4;
    const DSS_CLAIM_PAID_PATIENT         = 5;
    const DSS_CLAIM_SEC_PENDING          = 6;
    const DSS_CLAIM_SEC_SENT             = 7;
    const DSS_CLAIM_SEC_DISPUTE          = 8;
    const DSS_CLAIM_PAID_SEC_INSURANCE   = 9;
    const DSS_CLAIM_PATIENT_DISPUTE      = 10;
    const DSS_CLAIM_PAID_SEC_PATIENT     = 11;
    const DSS_CLAIM_SEC_PATIENT_DISPUTE  = 12;
    const DSS_CLAIM_SEC_REJECTED         = 13;
    const DSS_CLAIM_EFILE_ACCEPTED       = 14;
    const DSS_CLAIM_SEC_EFILE_ACCEPTED   = 15;

    // A convenience array to get claim labels
    public static $dss_claim_status_labels = array(
        self::DSS_CLAIM_PENDING              => 'Pending',
        self::DSS_CLAIM_SENT                 => 'Sent',
        self::DSS_CLAIM_DISPUTE              => 'Disputed',
        self::DSS_CLAIM_PAID_INSURANCE       => 'Paid',
        self::DSS_CLAIM_REJECTED             => 'Paid to Patient',
        self::DSS_CLAIM_PAID_PATIENT         => 'Rejected',
        self::DSS_CLAIM_SEC_PENDING          => 'Secondary Pending',
        self::DSS_CLAIM_SEC_SENT             => 'Secondary Sent',
        self::DSS_CLAIM_SEC_DISPUTE          => 'Secondary Disputed',
        self::DSS_CLAIM_PAID_SEC_INSURANCE   => 'Secondary Paid',
        self::DSS_CLAIM_PATIENT_DISPUTE      => 'Disputed',
        self::DSS_CLAIM_PAID_SEC_PATIENT     => 'Secondary Paid to Patient',
        self::DSS_CLAIM_SEC_PATIENT_DISPUTE  => 'Secondary Disputed',
        self::DSS_CLAIM_EFILE_ACCEPTED       => 'Efile Accepted',
        self::DSS_CLAIM_SEC_EFILE_ACCEPTED   => 'Secondary Efile Accepted'
    );

    // Pre-authorization statuses (pre-auth)
    const DSS_PREAUTH_PENDING          = 0;
    const DSS_PREAUTH_COMPLETE         = 1;
    const DSS_PREAUTH_PREAUTH_PENDING  = 2;
    const DSS_PREAUTH_REJECTED         = 3;

    // A convenience array to get pre-auth labels
    public static $dss_preauth_status_labels = array(
        self::DSS_PREAUTH_PENDING          => 'Pending',
        self::DSS_PREAUTH_COMPLETE         => 'Complete',
        self::DSS_PREAUTH_PREAUTH_PENDING  => 'Pre-Auth Pending',
        self::DSS_PREAUTH_REJECTED         => 'Rejected'
    );

    // Pre-authorization statuses (pre-auth)
    const DSS_HST_REQUESTED  = 0;
    const DSS_HST_PENDING    = 1;
    const DSS_HST_SCHEDULED  = 2;
    const DSS_HST_COMPLETE   = 3;
    const DSS_HST_REJECTED   = 4;
    const DSS_HST_CONTACTED  = 5;

    // A convenience array to get pre-auth labels
    public static $dss_hst_status_labels = array(
        self::DSS_HST_REQUESTED  => 'Unsent',
        self::DSS_HST_PENDING    => 'Pending',
        self::DSS_HST_SCHEDULED  => 'Scheduled',
        self::DSS_HST_COMPLETE   => 'Complete',
        self::DSS_HST_REJECTED   => 'Rejected',
        self::DSS_HST_CONTACTED  => 'Contacted'
    );

    //Transaction Payers (ledger)
    const DSS_TRXN_PAYER_PRIMARY    = 0;
    const DSS_TRXN_PAYER_SECONDARY  = 1;
    const DSS_TRXN_PAYER_PATIENT    = 2;
    const DSS_TRXN_PAYER_WRITEOFF   = 3;
    const DSS_TRXN_PAYER_DISCOUNT   = 4;

    // A convenience array to get trxn payment labels
    public static $dss_trxn_payer_labels = array(
        self::DSS_TRXN_PAYER_PRIMARY    => 'Primary Insurance',
        self::DSS_TRXN_PAYER_SECONDARY  => 'Secondary Insurance',
        self::DSS_TRXN_PAYER_PATIENT    => 'Patient',
        self::DSS_TRXN_PAYER_WRITEOFF   => 'Write Off',
        self::DSS_TRXN_PAYER_DISCOUNT   => 'Professional Discount'
    );

    //Transaction Payment Types (ledger)
    const DSS_TRXN_PYMT_CREDIT    = 0;
    const DSS_TRXN_PYMT_DEBIT     = 1;
    const DSS_TRXN_PYMT_CHECK     = 2;
    const DSS_TRXN_PYMT_CASH      = 3;
    const DSS_TRXN_PYMT_WRITEOFF  = 4;

    // A convenience array to get trxn payment type labels
    public static $dss_trxn_pymt_type_labels = array(
        self::DSS_TRXN_PYMT_CREDIT    => 'Credit Card',
        self::DSS_TRXN_PYMT_DEBIT     => 'Debit',
        self::DSS_TRXN_PYMT_CHECK     => 'Check',
        self::DSS_TRXN_PYMT_CASH      => 'Cash',
        self::DSS_TRXN_PYMT_WRITEOFF  => 'Write Off'
    );

    //Max File size allowed for upload forms
    const DSS_FILE_MAX_SIZE  = 10000000;

    //Allowed File Types for upload forms
    const DSS_FILE_IMAGE_GIF    = 0;
    const DSS_FILE_IMAGE_JPEG   = 1;
    const DSS_FILE_IMAGE_PJPEG  = 2;
    const DSS_FILE_APP_PDF      = 3;
    const DSS_FILE_IMAGE_PNG    = 4;
    const DSS_FILE_IMAGE_BMP    = 5;
    const DSS_FILE_APP_DOC      = 6;
    const DSS_FILE_APP_DOCX     = 7;
    const DSS_FILE_APP_XLS      = 8;
    const DSS_FILE_APP_XLSX     = 9;

    // A convenience array to get file types
    public static $dss_image_file_types = array(
        self::DSS_FILE_IMAGE_GIF    => 'image/gif',
        self::DSS_FILE_IMAGE_JPEG   => 'image/jpeg',
        self::DSS_FILE_IMAGE_PJPEG  => 'image/pjpeg',
        self::DSS_FILE_IMAGE_PNG    => 'image/png',
        self::DSS_FILE_IMAGE_BMP    => 'image/bmp'
    );

    // A convenience array to get file types
    public static $dss_file_types = array(
        self::DSS_FILE_IMAGE_GIF    => 'image/gif',
        self::DSS_FILE_IMAGE_JPEG   => 'image/jpeg',
        self::DSS_FILE_IMAGE_PJPEG  => 'image/pjpeg',
        self::DSS_FILE_IMAGE_PNG    => 'image/png',
        self::DSS_FILE_IMAGE_BMP    => 'image/bmp',
        self::DSS_FILE_APP_PDF      => 'application/pdf',
        self::DSS_FILE_APP_DOC      => 'application/msword',
        self::DSS_FILE_APP_DOCX     => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        self::DSS_FILE_APP_XLS      => 'application/vnd.ms-excel',
        self::DSS_FILE_APP_XLSX     => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    );

    const DSS_IMAGE_MAX_SIZE        = 10000000;
    const DSS_IMAGE_MAX_WIDTH       = 2000;
    const DSS_IMAGE_MAX_HEIGHT      = 2000;
    const DSS_IMAGE_RESIZE_WIDTH    = 1500;
    const DSS_IMAGE_RESIZE_HEIGHT   = 1500;
    const DSS_IMAGE_PROFILE_WIDTH   = 200;
    const DSS_IMAGE_PROFILE_HEIGHT  = 200;
    const DSS_IMAGE_DEVICE_WIDTH    = 150;
    const DSS_IMAGE_DEVICE_HEIGHT   = 150;

    // User types
    const DSS_USER_TYPE_ROOT    = 4;
    const DSS_USER_TYPE_GLOBAL  = 3;
    const DSS_USER_TYPE_ADMIN   = 2;
    const DSS_USER_TYPE_LOCAL   = 1;

    public static $dss_user_type_labels = array(
        self::DSS_USER_TYPE_ROOT    => 'Root User',
        self::DSS_USER_TYPE_GLOBAL  => 'Global User',
        self::DSS_USER_TYPE_ADMIN   => 'Local Admin',
        self::DSS_USER_TYPE_LOCAL   => 'Local User'
    );

    const DSS_REFERRED_PATIENT    = 1;
    const DSS_REFERRED_PHYSICIAN  = 2;
    const DSS_REFERRED_MEDIA      = 3;
    const DSS_REFERRED_FRANCHISE  = 4;
    const DSS_REFERRED_DSSOFFICE  = 5;
    const DSS_REFERRED_OTHER      = 6;

    public static $dss_referred_labels = array(
        self::DSS_REFERRED_PATIENT    => 'Patient',
        self::DSS_REFERRED_PHYSICIAN  => 'Physician',
        self::DSS_REFERRED_MEDIA      => 'Media',
        self::DSS_REFERRED_FRANCHISE  => 'Internal',
        self::DSS_REFERRED_DSSOFFICE  => 'DSS Office',
        self::DSS_REFERRED_OTHER      => 'Other'
    );

    const DSS_PATIENT_CONTACT_SLEEP    = 1;
    const DSS_PATIENT_CONTACT_PRIMARY  = 2;
    const DSS_PATIENT_CONTACT_DENTIST  = 3;
    const DSS_PATIENT_CONTACT_ENT      = 4;
    const DSS_PATIENT_CONTACT_OTHER    = 5;

    public static $dss_patient_contact_labels = array(
        self::DSS_PATIENT_CONTACT_SLEEP    => 'Sleep MD',
        self::DSS_PATIENT_CONTACT_PRIMARY  => 'Primary Care MD',
        self::DSS_PATIENT_CONTACT_DENTIST  => 'Dentist',
        self::DSS_PATIENT_CONTACT_ENT      => 'ENT',
        self::DSS_PATIENT_CONTACT_OTHER    => 'Other MD'
    );

    const DSS_USER_TYPE_FRANCHISEE  = 1;
    const DSS_USER_TYPE_SOFTWARE    = 2;

    public static $UserTypeLabel = array(
        self::DSS_USER_TYPE_FRANCHISEE  => 'Franchisee',
        self::DSS_USER_TYPE_SOFTWARE    => 'Software'
    );

    const DSS_ADMIN_ACCESS_SUPER          = 1;
    const DSS_ADMIN_ACCESS_ADMIN          = 2;
    const DSS_ADMIN_ACCESS_BASIC          = 3;
    const DSS_ADMIN_ACCESS_BILLING_ADMIN  = 4;
    const DSS_ADMIN_ACCESS_BILLING_BASIC  = 5;
    const DSS_ADMIN_ACCESS_HST_ADMIN      = 6;
    const DSS_ADMIN_ACCESS_HST_BASIC      = 7;

    public static $dss_admin_access_labels = array(
        self::DSS_ADMIN_ACCESS_SUPER          => 'Super User',
        self::DSS_ADMIN_ACCESS_ADMIN          => 'Admin User',
        self::DSS_ADMIN_ACCESS_BASIC          => 'Basic User',
        self::DSS_ADMIN_ACCESS_BILLING_ADMIN  => 'Billing Admin User',
        self::DSS_ADMIN_ACCESS_BILLING_BASIC  => 'Billing Basic User',
        self::DSS_ADMIN_ACCESS_HST_ADMIN      => 'HST Admin User',
        self::DSS_ADMIN_ACCESS_HST_BASIC      => 'HST Basic User'
    );

    const DSS_USER_ACCESS_STAFF   = 1;
    const DSS_USER_ACCESS_DOCTOR  = 2;

    const DSS_INVOICE_PENDING        = 4;
    const DSS_INVOICE_INVOICED       = 0;
    const DSS_INVOICE_PAID           = 1;
    const DSS_INVOICE_ERROR          = 2;
    const DSS_INVOICE_PAYMENT_ERROR  = 3;

    const DSS_PERCASE_PENDING   = 0;
    const DSS_PERCASE_INVOICED  = 1;

    const DSS_INVOICE_TYPE_SU_FO  = 1; //Super invoices front office
    const DSS_INVOICE_TYPE_BC_FO  = 2; //Billing company invoices front office
    const DSS_INVOICE_TYPE_SU_BC  = 3; //Super invoices billing company

    const DSS_LETTER_PENDING      = 0;
    const DSS_LETTER_SENT         = 1;
    const DSS_LETTER_SEND_FAILED  = 2;

    const DSS_STRIPE_PUB_KEY  = 'pk_test_AwG89We9HPlSSaFDI1TZgnie';
    const DSS_STRIPE_SEC_KEY  = 'sk_test_2Bwg6V5pLmm8Gbidwxc8Iwhk';

    const DSS_DEVICE_SETTING_TYPE_RANGE  = 0;
    const DSS_DEVICE_SETTING_TYPE_FLAG   = 1;

    public static $dss_device_setting_type_labels = array(
        self::DSS_DEVICE_SETTING_TYPE_RANGE  => 'Range',
        self::DSS_DEVICE_SETTING_TYPE_FLAG   => 'Flag'
    );

    const DSS_AMOUNT_ADJUST_USER      = 0;
    const DSS_AMOUNT_ADJUST_NEGATIVE  = 1;
    const DSS_AMOUNT_ADJUST_POSITIVE  = 2;

    public static $dss_amount_adjust_labels = array(
        self::DSS_AMOUNT_ADJUST_USER      => 'User Entered',
        self::DSS_AMOUNT_ADJUST_NEGATIVE  => 'Always Negative',
        self::DSS_AMOUNT_ADJUST_POSITIVE  => 'Always Positive'
    );

    const DSS_EMAIL_FOOTER = '<i>Dental Sleep Solutions will never ask you for passwords or payment information via email.</i> The contents of this message, together with any attachments, are intended only for the use of the individual or entity to which they are addressed and may contain information that is legally privileged, confidential and exempt from disclosure. If you are not the intended recipient, you are hereby notified that any dissemination, distribution or copying of this message, or any attachment, is strictly prohibited. If you have received this message in error, please notify the original sender or contact Dental Sleep Solutions immediately by telephone (941-757-4642) or by responding to this email and delete this message, along with any attachments, from your computer.';

    const DSS_TICKET_STATUS_OPEN      = 0;
    const DSS_TICKET_STATUS_REOPENED  = 1;
    const DSS_TICKET_STATUS_CLOSED    = 2;

    public static $dss_ticket_status_labels = array(
        self::DSS_TICKET_STATUS_OPEN      => 'Open',
        self::DSS_TICKET_STATUS_REOPENED  => 'Re-opened',
        self::DSS_TICKET_STATUS_CLOSED    => 'Closed'
    );

    const DSS_COMPANY_TYPE_BILLING   = 0;
    const DSS_COMPANY_TYPE_SOFTWARE  = 1;
    const DSS_COMPANY_TYPE_HST       = 2;

    public static $dss_company_type_labels = array(
        self::DSS_COMPANY_TYPE_BILLING   => 'Billing',
        self::DSS_COMPANY_TYPE_SOFTWARE  => 'Software',
        self::DSS_COMPANY_TYPE_HST       => 'HST'
    );

    const DSS_USER_STATUS_ACTIVE     = 1;
    const DSS_USER_STATUS_INACTIVE   = 2;
    const DSS_USER_STATUS_SUSPENDED  = 3;

    public static $dss_user_status_labels = array(
        self::DSS_USER_STATUS_ACTIVE     => 'Active',
        self::DSS_USER_STATUS_INACTIVE   => 'In-Active',
        self::DSS_USER_STATUS_SUSPENDED  => 'Suspended'
    );

    const DSS_OFFICE_TYPE_BACK   = 0;
    const DSS_OFFICE_TYPE_FRONT  = 1;

    const DSS_ENROLLMENT_SUBMITTED  = 0;
    const DSS_ENROLLMENT_ACCEPTED   = 1;
    const DSS_ENROLLMENT_REJECTED   = 2;

    public static $dss_enrollment_labels = array(
        self::DSS_ENROLLMENT_SUBMITTED  => 'Submitted',
        self::DSS_ENROLLMENT_ACCEPTED   => 'Accepted',
        self::DSS_ENROLLMENT_REJECTED   => 'Rejected'
    );

    const DSS_DEFAULT_ELIGIBLE_API_KEY = '33b2e3a5-8642-1285-d573-07a22f8a15b4';
}
