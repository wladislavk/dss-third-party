<?php
// Transaction statuses (ledger)
define('DSS_TRXN_NA', 0);         // trxn created/updated, but not filed.
define('DSS_TRXN_PENDING', 1);    // trxn's 'File' checkbox checked.
define('DSS_TRXN_PROCESSING', 2); // trxn's associated claim form is being processed by back office.
define('DSS_TRXN_SENT', 3);       // trxn's associated claim form was sent to insurance.
define('DSS_TRXN_PAID', 4);       // trxn's associated claim was received by front office and paid.
define('DSS_TRXN_REJECTED', 5);   // trxn's associated claim was received by front office and not paid.

// Claim statuses (insurance)
define('DSS_CLAIM_PENDING', 1);
define('DSS_CLAIM_SENT', 0);
define('DSS_CLAIM_PAID', 3);
define('DSS_CLAIM_REJECTED', 4);

// Pre-authorization statuses (pre-auth)
define('DSS_PREAUTH_PENDING', 0);
define('DSS_PREAUTH_COMPLETE', 1);


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

// A convenience array to get claim labels
$dss_claim_status_labels = array();
$dss_claim_status_labels[DSS_CLAIM_PENDING] = 'Pending';
$dss_claim_status_labels[DSS_CLAIM_PENDING]['short'] = 'Pend.';
$dss_claim_status_labels[DSS_CLAIM_SENT] = 'Sent';
$dss_claim_status_labels[DSS_CLAIM_SENT]['short'] = 'Sent';
$dss_claim_status_labels[DSS_CLAIM_PAID] = 'Paid';
$dss_claim_status_labels[DSS_CLAIM_PAID]['short'] = 'Paid';
$dss_claim_status_labels[DSS_CLAIM_REJECTED] = 'Rejected';
$dss_claim_status_labels[DSS_CLAIM_REJECTED]['short'] = 'Rej.';

// A convenience array to get pre-auth labels
$dss_preauth_status_labels = array();
$dss_preauth_status_labels[DSS_PREAUTH_PENDING] = 'Pending';
$dss_preauth_status_labels[DSS_PREAUTH_PENDING]['short'] = 'Pend.';
$dss_preauth_status_labels[DSS_PREAUTH_COMPLETE] = 'Complete';
$dss_preauth_status_labels[DSS_PREAUTH_COMPLETE]['short'] = 'Comp.';
