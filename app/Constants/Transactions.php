<?php

namespace DentalSleepSolutions\Constants;

abstract class Transactions
{
    // Transaction types (ledger)
    const TRANSACTION_TYPE_MED = 1;
    const TRANSACTION_TYPE_PATIENT = 2;
    const TRANSACTION_TYPE_INS = 3;
    const TRANSACTION_TYPE_DIAG = 4;
    const TRANSACTION_TYPE_ADJ = 6;

    // Transaction Payment Types (ledger)
    const TRANSACTION_PAYMENT_CREDIT = 0;
    const TRANSACTION_PAYMENT_DEBIT = 1;
    const TRANSACTION_PAYMENT_CHECK = 2;
    const TRANSACTION_PAYMENT_CASH = 3;
    const TRANSACTION_PAYMENT_WRITEOFF = 4;
    const TRANSACTION_PAYMENT_EFT = 5;

    // Transaction Payers (ledger)
    const TRANSACTION_PAYER_PRIMARY = 0;
    const TRANSACTION_PAYER_SECONDARY = 1;
    const TRANSACTION_PAYER_PATIENT = 2;
    const TRANSACTION_PAYER_WRITEOFF = 3;
    const TRANSACTION_PAYER_DISCOUNT = 4;

    const TRANSACTION_PAYMENT_TYPE_LABELS = [
        self::TRANSACTION_PAYMENT_CREDIT   => "Credit Card",
        self::TRANSACTION_PAYMENT_DEBIT    => "Debit",
        self::TRANSACTION_PAYMENT_CHECK    => "Check",
        self::TRANSACTION_PAYMENT_CASH     => "Cash",
        self::TRANSACTION_PAYMENT_WRITEOFF => "Write Off",
        self::TRANSACTION_PAYMENT_EFT      => "E-Funds Transfer (EFT)"
    ];

    const TRANSACTION_PAYER_LABELS = [
        self::TRANSACTION_PAYER_PRIMARY   => "Primary Insurance",
        self::TRANSACTION_PAYER_SECONDARY => "Secondary Insurance",
        self::TRANSACTION_PAYER_PATIENT   => "Patient",
        self::TRANSACTION_PAYER_WRITEOFF  => "Write Off",
        self::TRANSACTION_PAYER_DISCOUNT  => "Professional Discount",
    ];
}
